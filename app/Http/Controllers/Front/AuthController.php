<?php

namespace App\Http\Controllers\Front;

use App\Helper;
use App\Http\Controllers\Controller;
use App\Http\Middleware\Step;
use App\Mail\UserJoined;
use App\Models\Otp;
use App\Models\Service;
use App\Models\UniqueGrid;
use App\Models\User;
use App\Models\Vendor;
use App\Models\VendorBill;
use App\Models\VendorServices;
use App\Models\UserProfile;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function logout()
    {

        Auth::logout();
        return redirect()->route('index');
    }


    public function login(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $data = $request->validate([
                'email' => 'email|required',
                'password' => 'required'
            ]);
            // dd($request->all());

            if (Auth::attempt($data, true)) {
                $user = Auth::user();
                $token = UniqueGrid::where('grid', $request->hooked)->first();
                if ($token == null) {
                    $token = new UniqueGrid();
                    $token->grid = $request->hooked;
                }
                $token->user_id = $user->id;
                $token->save();
                if ($request->filled('redirect')) {
                    return redirect($request->redirect);
                } else {
                    if ($user->getRole() == 'user') {
                        $user->role = 2;
                        return redirect()->route('vendor.dashboard');
                    } else {

                        return redirect()->route($user->getRole() . 'index');
                    }
                }
            } else {
                return redirect()->back()->with('err', 'Email password combination missmatch')->withInput(['email' => $request->email]);
            }
            // dd($data);
        } else {
            return view('front.auth.login');
        }
    }

    public function checkEmail(Request $request)
    {
        return response()->json(
            [
                'email' => User::where('email', $request->email)->count() <= 0,
                'phone' => Vendor::where('phone', $request->phone)->count() <= 0
            ]
        );
    }

    public function join(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $data = getSetting('website');
            // dd($data);

            $validator = Validator::make(
                $request->all(),
                [
                    'email' => 'email|required|unique:users,email',
                    'phone' => 'numeric|required|unique:vendors,phone',
                    'name' => 'required|max:255',
                    'city_id' => 'exists:cities,id|required',
                    'type' => 'required',
                    'password' => ['required', 'confirmed', Password::min(6)],

                ],
                [
                    'email.unique' => 'Email is Already in Use',
                    'phone.unique' => 'Phone Number is Already in use',
                    'name.required' => 'Name is Required',
                    'email.required' => 'Email Address is Required',
                    'phone.required' => 'Phone Number is Required',
                    'city_id.exists' => 'City Does Not Exists',
                    'city_id.required' => 'City is Required',
                    'type.required' => 'Member Type is Required'
                ]
            );

            if ($validator->fails()) {
                // return response()->json(
                //     [
                //         'status'=>false,
                //         'errors'=>$validator->getMessageBag()
                //     ]
                // );
                return redirect()
                    ->route('join')
                    ->withErrors($validator)
                    ->withInput();
            } else {
                $user = new User();
                $vendor = new Vendor();

                try {
                    // dd($request->all());
                    //code...
                    $user->name = $request->name;
                    $user->token = mt_rand(10000000, 99999999);
                    $i = 1;
                    $tempusername = str_replace(' ', '.', $request->name);
                    $username = $tempusername;
                    while (User::where('username', $username)->count() > 0) {
                        $username = $tempusername . $i++;
                    }
                    $user->username = strtolower($username);
                    $user->email = $request->email;
                    // $user->role=$request->type=='normal'?3:2;
                    $user->role = 2;
                    $user->password = bcrypt($request->password);
                    $user->save();
                    $vendor->phone = $request->phone;
                    $vendor->address = $request->address;
                    $vendor->city_id = $request->city_id;
                    $vendor->type = 1;
                    // if($vendor->type==1){
                    //     $vendor->service_id=$request->service_id;

                    // }
                    $vendor->gender = $request->gender;
                    $vendor->dob = $request->dob;
                    $vendor->user_id = $user->id;
                    $vendor->save();
                    // if($vendor->type==1){

                    //     $newservice=new VendorServices();
                    //     $newservice->vendor_id=$user->vendor->id;
                    //     $newservice->service_id =$request->service_id;
                    //     $newservice->active=0;
                    //     $newservice->save();
                    //     $now=Carbon::now();
                    //     $service=Service::where('id',$request->service_id)->select('name','rate')->first();
                    //     $arr=["Service activation","service activation 1  Year",'Subscribtion For '.$service->name,'Subscribtion For '.$service->name.' 1  Year'];
                    //      $bill=new VendorBill();
                    //     $bill->name=$user->name;
                    //     $bill->vendor_id=$vendor->id;
                    //     $bill->amount=$data->type>1?$service->rate:(int)$data->price;
                    //     $bill->type=1;
                    //     $bill->service_id=$vendor->service_id;
                    //     $bill->particular=$arr[(int)$data->type];
                    //     $bill->date=$now;
                    //     $bill->save();
                    // }
                    Auth::login($user, true);
                    Mail::to($user)->send(new UserJoined($user));
                    $token = UniqueGrid::where('grid', $request->hooked)->first();
                    if ($token == null) {
                        $token = new UniqueGrid();
                        $token->grid = $request->hooked;
                    }
                    $token->user_id = $user->id;
                    $token->save();
                    if (Session::exists('redirect')) {
                        $url = session('redirect', '/');
                        Session::forget('redirect');
                        Session::save();
                        return redirect($url);
                    } else {

                        return redirect()->route($user->getRole() . '.dashboard');
                    }
                } catch (\Throwable $th) {
                    //throw $th;
                    if ($user->id != 0 && $user->id != null) {
                        if ($vendor->id != 0 && $vendor->id != null) {
                            VendorBill::where('vendor_id', $vendor->id)->delete();
                            $vendor->delete();
                        }
                        $user->delete();
                    }
                }
                // dd($request->all());
            }
        } else {
            return view('front.auth.join');
        }
    }

    public function loginFirst(Request $request)
    {
        if ($request->getMethod() == "POST") {
        } else {
            $redirect = session('redirect');
            return view('front.auth.firstlogin', compact('redirect'));
        }
    }
    public function loginPhone(Request $request)
    {
        if ($request->isMethod('POST')) {
            $now = now();
            $otp = Otp::where('phone', $request->phone)->first();
            if (!$otp) {
                $otp = new Otp();
                $otp->phone = $request->phone;
                $otp->otp = mt_rand(111111, 999999);
                $otp->validtill = $now->addMinute(3);
                $otp->save();
            } else {
                $otp->otp = mt_rand(111111, 999999);
                $otp->validtill = $now->addMinute(3);
                $otp->save();
            }
            Session::put('phone', $otp->phone);
            Session::save();
            Helper::sendOTP($otp->phone, $otp->otp, $otp->validtill);
            $user = User::where('phone', $otp->phone)->first();
            if (!$user) {
                return response()->json([
                    'status' => true,
                    'user' => false,
                ]);
            } else {
                return response()->json([
                    'status' => true,
                    'user' => true,
                ]);
            }
        } else {
            $cities = Helper::getCitiesMini();
            $phone = Session::get('phone');
            return view('front.auth.phonelogin', compact('cities', 'phone'));
        }
    }

    public function loginOTP(Request $request)
    {
        $phone = Session::get('phone');
        $otp = Otp::where('phone', $phone)->first();
        if ($request->getMethod() == "POST") {
            if ($otp->otp == $request->otp) {
                $user = User::where('phone', $phone)->first();
                if ($user == null) {
                    $user = new User();
                    $user->phone = $phone;
                    $user->role = 2;
                    $user->name = $request->input('name');
                    $user->email = $request->input('email');
                    $user->city_id = $request->input('city_id');
                    $user->password = bcrypt($phone);
                    $user->save();
                    Session::put('setup', 3);
                    Session::save();
                    return response()->json([
                        'status' => true,
                        'message' => 'User created successfully',

                    ]);
                } else {
                    Session::put('setup', 3);
                    Session::save();
                    return response($user);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid OTP'
                ]);
            }
        }
    }


    public function setupUser(Request $request)
    {
        $redirect = session('redirect');
        $phone = Session::get('phone');
        $google_id = Session::get('google_id');
        $email = Session::get('email');
        $setup = Session::get('setup');
        if ($setup == null) {
            return redirect()->route('loginFirst');
        }
        if ($request->getMethod() == "POST") {
            if ($setup == 3) {
                $localUser = new User();
                $i = 1;
                $localUser->name = $request->name;

                $tempusername = str_replace(' ', '.', $request->name);
                $username = $tempusername;
                while (User::where('username', $username)->count() > 0) {
                    $username = $tempusername . $i++;
                }
                $localUser->auth_source = 3;
                $localUser->username = strtolower($username);
                $localUser->role = $request->type;
                $localUser->password = bcrypt('_pass' . mt_rand(111111, 999999));
                $localUser->save();
            } else if ($setup == 2) {
                $localUser = User::where('email', $email)->first();
            }

            $vendor = $localUser->vendor;
            if ($vendor == null) {
                $vendor = new vendor();
                if ($request->type == 2) {
                    $vendor->type = 1;
                } else {
                    $vendor->type = 2;
                }
                $vendor->phone = $phone;
                $vendor->user_id = $localUser->id;
            }
            $vendor->city_id = $request->city_id;
            $vendor->address = $request->address;

            $vendor->location_id = $request->location_id;
            $vendor->save();
            Session::forget('google_id');
            Session::forget('email');
            Session::forget('setup');
            Session::forget('phone');
            Session::forget('redirect');
            Session::save();
            Auth::login($localUser);
            if ($redirect != null) {
                return redirect($redirect);
            } else {
                return redirect()->route('user.dashboard');
            }
        } else {
            if ($setup == 3) {
                $localUser = new User();
            } else {
                $localUser = User::where('email', $email)->first();
            }
            $cities = DB::table('cities')->get(['id', 'name']);
            $locations = DB::table('locations')->get(['id', 'name', 'city_id']);
            $cats = DB::table('categories')->get(['id', 'name']);
            $services = DB::table('services')->get(['id', 'name', 'category_id']);

            return view('front.auth.phonesetup', compact('cities', 'locations', 'cats', 'phone', 'redirect', 'setup', 'email', 'localUser'));
        }
    }

    public function callback(Request $request)
    {
        $user = Socialite::driver('google')->user();
        $localUser = User::where('email', $user->email)->first();

        if ($localUser == null) {

            $i = 1;
            $localUser = new User();
            $localUser->name = $user->name;


            if ($user->nickname == null) {
                $tempusername = str_replace(' ', '.', $user->name);
                $username = $tempusername;
                while (User::where('username', $username)->count() > 0) {
                    $username = $tempusername . $i++;
                }
            } else {
                $username = $user->nickname;
            }

            $localUser->auth_source = 2;
            $localUser->username = strtolower($username);
            $localUser->email = $user->email;
            $localUser->role = 2;
            $localUser->google_id = $user->id;
            $localUser->password = bcrypt('pass' . mt_rand(0, 999999));
            $localUser->email_verified_at = now();
            $localUser->verified = 1;
            $localUser->save();

            $profile = new UserProfile();

            $profile->user_id = $localUser->id;
            $profile->profile_picture = $user->avatar;
            $profile->save();
        } else {

            if ($localUser->google_id == null) {
                $localUser->google_id = $user->id;
                $localUser->auth_source = 2;
                $localUser->save();
            }


            $profile = UserProfile::firstOrNew(['user_id' => $localUser->id]);
            $profile->profile_picture = $user->avatar;
            $profile->save();
        }


        Auth::login($localUser, true);


        if (Session::exists('redirect')) {
            $redirect = session('redirect', '/');
            Session::forget('redirect');
            Session::save();
            return redirect($redirect);
        } else {
            return redirect()->route('vendor.dashboard');
        }
    }
}
