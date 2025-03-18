<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Job;
use App\Models\JobBid;
use App\Models\Payment;
use App\Models\Review;
use App\Models\Service;
use App\Models\Vendor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index(){
        $vendor_id = getVendor()->id;
        $jobs = Job::where('vendor_id',$vendor_id)->latest()->get();
        $user = Auth::user();
        return view('front.page.jobs.index',compact('user','jobs'));
    }

    public function list(){
        $vendor_id = getVendor()->id;
        $jobs = Job::where('vendor_id',$vendor_id)->get();
        return view('front.page.jobs.list',compact('jobs'));
    }


    public function addPage(){
        $user = Auth::user();
        $categories = Category::all();
        $services = Service::all();
        return view('front.page.jobs.add',compact('user','categories','services'));
    }

    public function add(Request $request){
        // dd($request->all());
        $service = Service::where('id',$request->service_id)->first();
        $user_id = Auth::user()->id;
        $vendor = Vendor::where('user_id',$user_id)->first();
        $jobs = New Job();
        $jobs->vendor_id = $vendor->id;
        $jobs->service_id = $request->service_id;
        $jobs->category_id = $service->category_id;
        $jobs->title = $request->title;
        $jobs->desc = $request->desc;
        $jobs->bid = $request->bid??0;
        if ($request->hasFile('image')) {
            $jobs->image = $request->image->store('front/image/jobs');
        }
        $jobs->save();
        return redirect()->route('user.jobs.index');
    }

    public function edit($id){
        $job = Job::where('id',$id)->first();
        return view('front.page.jobs.edit',compact('job'));
    }

    public function update(Request $request,$id){
        $service = Service::where('id',$request->service_id)->first();
        $jobs = Job::where('id',$id)->first();
        $jobs->vendor_id = getVendor()->id;
        $jobs->service_id = $request->service_id;
        $jobs->category_id = $service->category_id;
        $jobs->title = $request->title;
        $jobs->desc = $request->desc;
        $jobs->bid = $request->bid??0;
        if ($request->hasFile('image')) {
            $jobs->image = $request->image->store('front/image/jobs');
        }
        $jobs->save();
        return redirect()->back()->with('success','jobs updated successfully!');
    }

    public function delete($id){
        $service = Service::where('id',$id)->first();
        $service->delete();
        return redirect()->back()->with('success','jobs deleted successfully!');
    }

    public function detail($id){
        $vendor_id = getVendor()->id;
        $job = Job::where('vendor_id',$vendor_id)->where('id',$id)->first();

        // dd($job);
        $user = Auth::user();

        // $bids = DB::table('job_bids')->where('job_bids.job_id',$job->id)
        // ->select('job_bids.id','job_bids.amount')->get();
        if($job->status==0){
            $bids = DB::table('job_bids')->where('job_id',$job->id)
            ->join('vendors','vendors.id','job_bids.vendor_id')
            ->join('users','users.id','=','vendors.user_id')
            ->select('vendors.*','job_bids.amount','users.name')->get();

            $skills = DB::table('skills')->whereIn('user_id',$bids->pluck('user_id'))
            ->select('skills.title','skills.type','skills.user_id')->get();

            $certificates = DB::table('certificates')->whereIn('user_id',$bids->pluck('user_id'))
            ->select('certificates.title','certificates.image','certificates.user_id')->get();

            foreach ($bids as $key => $bid) {
               $bid->skills = $skills->where('user_id',$bid->user_id);
               $bid->certificates = $certificates->where('user_id',$bid->user_id);
            }
        }else{
            $bids[0] = DB::table('job_bids')->where('job_id',$job->id)->where('status',1)
            ->join('vendors','vendors.id','job_bids.vendor_id')
            ->join('users','users.id','=','vendors.user_id')
            ->select('vendors.*','job_bids.amount','users.name')->first();
            // dd($bids);

            $bids[0]->skills = DB::table('skills')->where('user_id',$bids[0]->user_id)
            ->select('skills.title','skills.type','skills.user_id')->get();


            $bids[0]->certificates = DB::table('certificates')->where('user_id',$bids[0]->user_id)
            ->select('certificates.title','certificates.image','certificates.user_id')->get();

            // dd($bids);
        }

        // dd($bids);

        return view('front.page.jobs.detail',compact('job','user','bids'));
    }

    public function runningJob(){
        $user = Auth::user();
        $jobs = Job::where('vendor_id',getVendor()->id)->whereIn('status',[1,2])->latest()->get();
        return view('front.page.jobs.running',compact('jobs','user'));
    }

    public function finishedJob(){
        $user = Auth::user();
        $jobs = Job::where('vendor_id',getVendor()->id)->where('status',3)->latest()->get();
        return view('front.page.jobs.finished',compact('jobs','user'));
    }


    public function bidRequestedJob(){
        $user = Auth::user();
        $vendor_id = getVendor()->id;
        // $req = Job::where('vendor_id',$vendor_id)->latest()->get();
        // $jobBid = JobBid::whereIn('job_id',$req->pluck('id'))->get();

        $jobBid = JobBid::all();
        $jobs = Job::whereIn('id',$jobBid->pluck('job_id'))->where('vendor_id',$vendor_id)->where('status',0)->get();
        return view('front.page.jobs.requested',compact('jobs','user','jobBid'));
    }

    public function acceptBid($id,$vendor_id){
        $v_id = getVendor()->id;
        $job = Job::where('id',$id)->where('vendor_id',$v_id)->first();

        $job->status=1;
        $job->save();

        $bid = JobBid::where('job_id',$job->id)->where('vendor_id',$vendor_id)->first();
        // dd($bid);
        $bid->status=1;
        $bid->save();
        return redirect()->back()->with('success','Bid accepted successfully!');
    }

    public function acceptFinishedJob(Request $req){
        // dd($req->all());
        $user = Auth::user();
        $review = new Review();
        $review->vendor_id = $req->vendor_id;
        $review->user_id = $user->id;
        $review->rate = $req->rating;
        $review->desc = $req->desc;
        $review->save();

        $job = Job::where('id',$req->job_id)->first();
        $job->status = 3;
        $job->save();

        $pay = new Payment();
        $pay->vendor_id = $req->vendor_id;
        $pay->user_id = $user->id;
        $pay->type = $req->type;
        $pay->job_id = $req->job_id;
        $pay->amount = $req->amt;

        if($req->type == 0){
            $pay->status = 2;
        }else{
            $pay->status = 1;
            $pay->reference_id = '#'.$req->job_id;
        }

        $pay->save();
        return redirect()->route('user.jobs.finished');

    }
}
