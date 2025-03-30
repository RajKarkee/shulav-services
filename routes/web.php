<?php
use App\Http\Controllers\front1\FrontController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\CertificateController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\PopupController;
use App\Http\Controllers\Admin\PricingController;
use App\Http\Controllers\Admin\Rastaurant\MenuController;
use App\Http\Controllers\Admin\Rastaurant\RealstatesController;
use App\Http\Controllers\Admin\Rastaurant\RestaurantController;
use App\Http\Controllers\Admin\Setting\CategoryController;
use App\Http\Controllers\Admin\Setting\CityController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\Admin\ProductTypeController;
use App\Http\Controllers\Front\AuthController as FrontAuthController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\JobController as FrontJobController;
use App\Http\Controllers\Front\RestaurantController as FrontRestaurantController;
use App\Http\Controllers\Front\UserController;
use App\Http\Controllers\Front\VendorController as FrontVendorController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\Vendor\ProductController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\ServiceController;

use App\Mail\ProductAdded;
use App\Mail\UserJoined;
use App\Models\User;
use App\Models\VendorBill;
use Faker\Guesser\Name;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;

Route::get('/', [FrontController::class, 'index'])->name('index');
Route::name('front1.')->group(function () {
    Route::get('/menu', [FrontController::class, 'menu'])->name('menu');
    Route::get('/view', [FrontController::class, 'view'])->name('view');
});





Route::get('gen/{pass}', function ($pass) {
    return response()->json(['pass' => bcrypt($pass)]);
});

Route::get('mail/{email}', function ($email) {
    $user = User::where('email', $email)->first();
    $bill = VendorBill::latest()->first();
    $user->token = 'lorem';
    Mail::to($user)->send(new ProductAdded($user, $bill));
    return view('email.bill', compact('user', 'bill'));

    // return response()->json(['pass' => bcrypt($pass)]);
});
// Route::redirect('/home','/admin/dashboard');
// Route::redirect('/','/admin/dashboard');


Route::match(['GET', 'POST'], 'verify', [FrontVendorController::class, 'verify'])->name('verify');
Route::match(['GET', 'POST'], '/chooseCity', [HomeController::class, 'chooseCity'])->name('chooseCity');
// Route::redirect('/home','/');

// Route::get('/', [HomeController::class, 'index'])->name('index');

Route::post('/indexData', [HomeController::class, 'indexData'])->name('indexData');
Route::get('homepage/{id}', [HomeController::class, 'append']);
Route::post('/register-token', [HomeController::class, 'registerToken'])->name('registerToken');
Route::get('/@{username}', [HomeController::class, 'share'])->name('share');
Route::get('/product/{product}', [HomeController::class, 'pshare'])->name('pshare');
Route::match(['GET', 'POST'], '/cities', [HomeController::class, 'cities'])->name('cities');
Route::match(['GET', 'POST'], '/services', [HomeController::class, 'services'])->name('services');
Route::match(['GET', 'POST'], '/search', [HomeController::class, 'search'])->name('search');
Route::match(['GET', 'POST'], '/contact', [HomeController::class, 'contact'])->name('contact');
Route::match(['GET', 'POST'], '/message', [HomeController::class, 'message'])->name('message');
Route::match(['GET', 'POST'], '/contact', [HomeController::class, 'contact'])->name('contact');
Route::match(['GET', 'POST'], '/faq/{faq}', [HomeController::class, 'faq'])->name('faq');
Route::match(['GET', 'POST'], '/searchname', [HomeController::class, 'searchname'])->name('searchname');
Route::match(['GET', 'POST'], '/product-search', [HomeController::class, 'productSearch'])->name('product-search');

Route::match(['GET', 'POST'], '/service/{id}', [HomeController::class, 'service'])->name('service');
Route::match(['GET', 'POST'], '/city/{id}', [HomeController::class, 'city'])->name('city');
Route::match(['GET', 'POST'], '/single-vendor/{username}', [HomeController::class, 'vendor'])->name('vendor')->middleware('role:vendor');
Route::match(['GET', 'POST'], '/single-product/{product}', [HomeController::class, 'product'])->name('product');
Route::match(['GET', 'POST'], 'mobileProduct/{product}', [HomeController::class, 'mobileProduct'])->name('mobileProduct');
Route::post('/subscribe', [HomeController::class, 'subscribe'])->name('subscribe');

Route::match(['GET', 'POST'], 'logout', [FrontAuthController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::match(['GET', 'POST'], 'login', [FrontAuthController::class, 'login'])->name('login');
    Route::match(['GET', 'POST'], 'loginFirst', [FrontAuthController::class, 'loginFirst'])->name('loginFirst');
    Route::match(['GET', 'POST'], 'loginPhone', [FrontAuthController::class, 'loginPhone'])->name('loginPhone');
    Route::match(['GET', 'POST'], 'setupUser', [FrontAuthController::class, 'setupUser'])->name('setupUser');
    Route::match(['GET', 'POST'], 'loginOTP', [FrontAuthController::class, 'loginOTP'])->name('loginOTP');
    Route::match(['GET', 'POST'], 'callback', [FrontAuthController::class, 'callback'])->name('callback');
    Route::match(['GET', 'POST'], 'loginGoogle', [SocialController::class, 'loginGoogle'])->name('loginGoogle');
    Route::match(['GET', 'POST'], 'forgot', [FrontAuthController::class, 'forgot'])->name('forgot');
    Route::match(['GET', 'POST'], 'join', [FrontAuthController::class, 'join'])->name('join');
    Route::match(['GET', 'POST'], 'checkEmail', [FrontAuthController::class, 'checkEmail'])->name('checkEmail');
});

Route::name('user.')->prefix('user')->middleware('role:user')->group(function () {
    Route::get('', [UserController::class, 'index'])->name('dashboard');
    Route::get('bookmark/{vendor_id}', [UserController::class, 'bookmark'])->name('bookmark');
    Route::match(['GET', 'POST'], 'edit-info', [UserController::class, 'editInfo'])->name('edit-info');
    Route::match(['GET', 'POST'], 'update-pass', [UserController::class, 'updatePass'])->name('update-pass');
    Route::match(['GET', 'POST'], 'change-image', [FrontVendorController::class, 'changeImage'])->name('change-image');
    Route::match(['GET', 'POST'], 'change-name', [FrontVendorController::class, 'changeName'])->name('change-name');
    Route::match(['GET', 'POST'], 'change-desc', [FrontVendorController::class, 'changeDesc'])->name('change-desc');

    Route::post('add-review', [UserController::class, 'addReview'])->name('review.add');

    Route::prefix('jobs')->name('jobs.')->group(function () {
        Route::match(['get', 'post'], '/', [JobController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/add', [JobController::class, 'addPage'])->name('add.page');
        Route::match(['get', 'post'], '/add/store', [JobController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/edit/{id}', [JobController::class, 'edit'])->name('edit');
        Route::match(['get', 'post'], '/update/{id}', [JobController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/delete/{id}', [JobController::class, 'delete'])->name('delete');
        Route::match(['get', 'post'], '/detail/{id}', [JobController::class, 'detail'])->name('detail');
        Route::match(['get', 'post'], '/running', [JobController::class, 'runningJob'])->name('running');
        Route::match(['get', 'post'], '/finished', [JobController::class, 'finishedJob'])->name('finished');
        Route::match(['get', 'post'], '/bid-requested', [JobController::class, 'bidRequestedJob'])->name('requested');
        Route::match(['get', 'post'], '/bid-accept/{id}/{vendor_id}', [JobController::class, 'acceptBid'])->name('acceptBid');
        Route::match(['get', 'post'], '/finished-accept', [JobController::class, 'acceptFinishedJob'])->name('acceptFinishedJob');

    });

    Route::prefix('restaurant')->name('restaurant.')->group(function () {
        Route::match(['get', 'post'], '', [FrontRestaurantController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '{id}', [FrontRestaurantController::class, 'menus'])->name('menus');
        Route::match(['get', 'post'], 'menu/{id}', [FrontRestaurantController::class, 'menusDetail'])->name('menusDetail');
    });

    Route::match(['get', 'post'], 'cart', [FrontRestaurantController::class, 'cart'])->name('cart');
    Route::match(['get', 'post'], 'place-to-order', [FrontRestaurantController::class, 'placeToOrder'])->name('placeToOrder');


});


Route::name(value: 'vendor.')->prefix('vendor/dashboard')->middleware('role:vendor')->group(function () {
    // Route::match(['GET', 'POST'], 'step', [FrontVendorController::class, 'step'])->name('step');

    Route::match(['GET', 'POST'], '', [FrontVendorController::class, 'index'])->name('dashboard');
    // Route::match(['GET','POST'],'subscribe', [FrontVendorController::class,'subscribe'])->name('subscribe');
    Route::match(['GET', 'POST'], 'reviews', [FrontVendorController::class, 'reviews'])->name('reviews');
    Route::match(['GET', 'POST'], 'bill/{bill}', [FrontVendorController::class, 'bill'])->name('bill');
    Route::match(['GET', 'POST'], 'bills', [FrontVendorController::class, 'bills'])->name('bills');
    Route::match(['GET', 'POST'], 'openingHour', [FrontVendorController::class, 'openingHour'])->name('openingHour');
    Route::match(['GET', 'POST'], 'change-image', [FrontVendorController::class, 'changeImage'])->name('change-image');
    Route::match(['GET', 'POST'], 'change-main-service/{id}', [FrontVendorController::class, 'changeMainService'])->name('change-main-service');
    Route::match(['GET', 'POST'], 'change-status-service/{id}/{status}', [FrontVendorController::class, 'changeStatusService'])->name('change-status-service');
    Route::match(['GET', 'POST'], 'change-name', [FrontVendorController::class, 'changeName'])->name('change-name');
    Route::match(['GET', 'POST'], 'change-desc', [FrontVendorController::class, 'changeDesc'])->name('change-desc');
    Route::match(['GET', 'POST'], 'edit-info', [FrontVendorController::class, 'editInfo'])->name('edit-info');
    Route::match(['GET', 'POST'], 'update-pass', [FrontVendorController::class, 'updatePass'])->name('update-pass');



    Route::prefix('certificate')->name('certificate.')->group(function () {
        Route::match(['get', 'post'], '/', [CertificateController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/add', [CertificateController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/store', [CertificateController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/edit/{id}', [CertificateController::class, 'edit'])->name('edit');
        Route::match(['get', 'post'], '/update/{id}', [CertificateController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/delete/{id}', [CertificateController::class, 'delete'])->name('delete');
    });

    Route::prefix('skill')->name('skill.')->group(function () {
        Route::match(['get', 'post'], '/', [SkillController::class, 'index'])->name('index');
        Route::match(['get', 'post'], '/add', [SkillController::class, 'add'])->name('add');
        Route::match(['get', 'post'], '/store', [SkillController::class, 'store'])->name('store');
        Route::match(['get', 'post'], '/edit/{id}', [SkillController::class, 'edit'])->name('edit');
        Route::match(['get', 'post'], '/update/{id}', [SkillController::class, 'update'])->name('update');
        Route::match(['get', 'post'], '/delete/{id}', [SkillController::class, 'delete'])->name('delete');
    });


    Route::prefix('job-search')->name('job-search.')->group(function () {
        Route::match(['get', 'post'], '/', [FrontJobController::class, 'jobSearch'])->name('index');
        Route::match(['get', 'post'], '/detail/{id}', [FrontJobController::class, 'jobSearchdetails'])->name('details');
        Route::match(['get', 'post'], '/bid', [FrontJobController::class, 'addBid'])->name('bid');
    });



    Route::match(['get', 'post'], '/my-bids', [FrontJobController::class, 'mybids'])->name('mybids');
    Route::match(['get', 'post'], '/bid-accepted-jobs', [FrontJobController::class, 'bidAccepted'])->name('bidaccept');
    Route::match(['get', 'post'], '/finished-job-request/{id}', [FrontJobController::class, 'finishedJobReq'])->name('finishedJobReq');
    Route::match(['get', 'post'], '/finished-jobs', [FrontJobController::class, 'finishedJob'])->name('finishedJob');
    Route::match(['get', 'post'], '/received-payment/{id}', [FrontJobController::class, 'yesReceivedPayment'])->name('receivedAPayment');



});

// Route::middleware('')

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest')->group(function () {
        route::match(['GET', 'POST'], 'login', [AuthController::class, 'login'])->name('login');
        route::match(['GET', 'POST'], 'guest/logout', [AuthController::class, 'logout'])->name('guest.logout');
    });
    Route::middleware('role:admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::match(['GET', 'POST'], 'password', [DashboardController::class, 'password'])->name('password');

        route::match(['GET', 'POST'], 'logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('append/{id}/{command}', [DashboardController::class, 'append']);
        Route::prefix('pricing')->name('pricing.')->group(function () {
            Route::get('', [PricingController::class, 'index'])->name('index');
            Route::post('add', [PricingController::class, 'add'])->name('add');
            Route::post('edit/{pricing}', [PricingController::class, 'edit'])->name('edit');
            Route::get('del/{pricing}', [PricingController::class, 'del'])->name('del');
        });


        Route::prefix('producttype')->group(function () {
            Route::get('/product-types', [ProductTypeController::class, 'index'])->name('product_types.index');
            Route::get('/product-types/create', [ProductTypeController::class, 'create'])->name('product_types.create');
            Route::post('/product-types', [ProductTypeController::class, 'store'])->name('product_types.store');
            Route::delete('/product-types/{productType}', [ProductTypeController::class, 'destroy'])->name('product_types.destroy');
        });
        Route::prefix('products')->name('products.')->group(function () {
            Route::get('/', [AdminProductController::class, 'index'])->name('index');
            Route::post('/load-data', [AdminProductController::class, 'loadData'])->name('loadData');
            Route::get('/create', [AdminProductController::class, 'create'])->name('create');
            Route::post('/store', [AdminProductController::class, 'store'])->name('store');
            Route::match(['get', 'post'], '/edit/{product_id}', [AdminProductController::class, 'edit'])->name('edit');
            Route::get('del/{product_id}', [AdminProductController::class, 'del'])->name('del');
        });





        Route::prefix('payment')->name('payment.')->group(function () {
            Route::get('details', [PaymentController::class, 'index'])->name('index');
            Route::get('detail/{id}', [PaymentController::class, 'store'])->name('store');
        });



        // Route::prefix('product')->name('product.')->group(function () {
        //     Route::get('index/{type}', [ProductController::class, 'index'])->name('index');
        //     Route::match(['get', 'post'], '/add/{type}', [ProductController::class, 'add'])->name('add');
        //     Route::match(['get', 'post'], '/edit/{product}', [ProductController::class, 'edit'])->name('edit');
        // });



        // Vendor-specific product routes (adjust according to your existing vendor routes)
        // Route::prefix('vendor/products')->group(function () {
        //     Route::get('/', [VendorProductController::class, 'index'])->name('vendor.products.index');
        //     Route::get('/create', [VendorProductController::class, 'create'])->name('vendor.products.create');
        //     Route::post('/store', [VendorProductController::class, 'store'])->name('vendor.products.store');
        //     Route::get('/{product}/edit', [VendorProductController::class, 'edit'])->name('vendor.products.edit');
        //     Route::put('/{product}', [VendorProductController::class, 'update'])->name('vendor.products.update');
        //     Route::delete('/{product}', [VendorProductController::class, 'destroy'])->name('vendor.products.destroy');
        // });
        Route::prefix('bills')->name('bills.')->group(function () {
            Route::get('', [DashboardController::class, 'bills'])->name('index');
            Route::match(['GET', 'POST'], 'detail/{bill}', [DashboardController::class, 'billDetail'])->name('detail');
        });
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('', [FaqController::class, 'index'])->name('index');
            Route::match(['get', 'post'], 'add', [FaqController::class, 'add'])->name('add');
            Route::match(['get', 'post'], 'edit/{faq}', [FaqController::class, 'edit'])->name('edit');
            Route::match(['get', 'post'], 'del/{faq}', [FaqController::class, 'del'])->name('del');
        });
        Route::prefix('vendor')->name('vendor.')->group(function () {
            Route::get('', [VendorController::class, 'index'])->name('index');
            Route::match(['GET', 'POST'], 'add', [VendorController::class, 'add'])->name('add');
            Route::match(['GET', 'POST'], 'update', [VendorController::class, 'update'])->name('update');
            Route::match(['GET', 'POST'], 'detail/{vendor}', [VendorController::class, 'detail'])->name('detail');
            Route::match(['GET', 'POST'], 'pdetail/{product}', [VendorController::class, 'pdetail'])->name('pdetail');
            Route::match(['GET', 'POST'], 'pstatus/{product}/{status}', [VendorController::class, 'pstatus'])->name('pstatus');
            Route::match(['GET', 'POST'], 'status/{vendor}/{status}', [VendorController::class, 'status'])->name('status');
        });
        Route::prefix('setting')->name('setting.')->group(function () {


            Route::match(['GET', 'POST'], 'payment', [SettingController::class, 'payment'])->name('payment');

            Route::prefix('front')->name('front.')->group(function () {
                Route::match(['GET', 'POST'], 'step', [SettingController::class, 'step'])->name('step');
                Route::match(['GET', 'POST'], 'minor', [SettingController::class, 'minor'])->name('minor');
                Route::match(['GET', 'POST'], 'website', [SettingController::class, 'website'])->name('website');
                Route::match(['GET', 'POST'], 'contact', [SettingController::class, 'contact'])->name('contact');
                Route::prefix('slider')->name('slider.')->group(function () {
                    route::get('', [SliderController::class, 'index'])->name('index');
                    route::match(["GET", "POST"], 'add', [SliderController::class, 'add'])->name('add');
                    route::match(["GET", "POST"], 'edit/{slider}', [SliderController::class, 'edit'])->name('edit');
                    route::post('del/{slider}', [SliderController::class, 'del'])->name('del');
                });
                Route::prefix('popup')->name('popup.')->group(function () {
                    route::get('', [PopupController::class, 'index'])->name('index');
                    route::match(["GET", "POST"], 'add', [PopupController::class, 'add'])->name('add');
                    route::match(["GET", "POST"], 'edit/{popup}', [PopupController::class, 'edit'])->name('edit');
                    route::post('del/{popup}', [PopupController::class, 'del'])->name('del');
                    route::post('status/{popup}/{status}', [PopupController::class, 'status'])->name('status');
                });
            });
            Route::prefix('category')->name('category.')->group(function () {
                route::get('', [CategoryController::class, 'index'])->name('index');
                route::get('/cat/{cat}', [CategoryController::class, 'category'])->name('category');
                route::post('add', [CategoryController::class, 'add'])->name('add');
                route::post('update', [CategoryController::class, 'update'])->name('update');
                route::post('delete', [CategoryController::class, 'delete'])->name('delete');
            });
            // Route::prefix('category')->name('category.')->group(function () {
            //     route::get('', [CategoryController::class, 'index'])->name('index');
            //     route::get('/cat/{cat}', [CategoryController::class, 'category'])->name('category');
            //     route::post('add', [CategoryController::class, 'add'])->name('add');
            //     route::post('update', [CategoryController::class, 'update'])->name('update');
            //     route::post('delete', [CategoryController::class, 'delete'])->name('delete');
            // });
            Route::prefix('city')->name('city.')->group(function () {
                route::get('', [CityController::class, 'index'])->name('index');
                route::match(['GET', 'POST'], 'add', [CityController::class, 'add'])->name('add');
                route::match(['GET', 'POST'], 'edit/{city}', [CityController::class, 'edit'])->name('edit');
                route::post('delete', [CityController::class, 'delete'])->name('delete');
                Route::prefix('location')->name('location.')->group(function () {
                    Route::get('/{id}', [LocationController::class, 'index'])->name('index');
                    route::match(['GET', 'POST'], '/{id}/add', [LocationController::class, 'add'])->name('add');
                    route::match(['GET', 'POST'], 'edit/{location}', [LocationController::class, 'edit'])->name('edit');
                    route::post('delete', [LocationController::class, 'delete'])->name('delete');
                });

            });
        });

        Route::prefix('restaurant')->name('restaurant.')->group(function () {
            route::match(['GET', 'POST'], '', [RestaurantController::class, 'index'])->name('index');
            route::match(['GET', 'POST'], 'load-data', [RestaurantController::class, 'loadData'])->name('loadData');
            route::match(['GET', 'POST'], 'update', [RestaurantController::class, 'update'])->name('update');
            route::match(['GET', 'POST'], 'delete', [RestaurantController::class, 'delete'])->name('delete');

            Route::prefix('menu')->name('menu.')->group(function () {
                route::match(['GET', 'POST'], '', [MenuController::class, 'index'])->name('index');
                route::match(['GET', 'POST'], 'load-data', [MenuController::class, 'loadData'])->name('loadData');
                route::match(['GET', 'POST'], 'update', [MenuController::class, 'update'])->name('update');
                route::match(['GET', 'POST'], 'delete', [MenuController::class, 'delete'])->name('delete');
            });
        });

        Route::prefix('realstates')->name('realstates.')->group(function () {
            route::match(['GET', 'POST'], '', [RealstatesController::class, 'index'])->name('index');
            route::match(['GET', 'POST'], 'location', [RealstatesController::class, 'location'])->name('location');
            route::match(['GET', 'POST'], 'load-data', [RealstatesController::class, 'loadData'])->name('loadData');
            route::match(['GET', 'POST'], 'update', [RealstatesController::class, 'update'])->name('update');
            route::match(['GET', 'POST'], 'detail/{id}', [RealstatesController::class, 'detail'])->name('detail');
            route::match(['GET', 'POST'], 'image/{id}', [RealstatesController::class, 'imagedelete'])->name('imagedelete');
            route::match(['GET', 'POST'], 'gallery-save', [RealstatesController::class, 'gallery'])->name('gallery');
        });


    });
});
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('service', ServiceController::class);
});


Route::get('users/{username}', function ($username) {
    $user = User::where('username', $username)->first();

    dd($user->createToken($username));
});
// Client ID: 4
// Client secret: FP9rBEpFNgVYl9LakaHBOgdfIZR3ZUgsVM0jdcw9
// "grant_type" : "password",
// "client_id" : "4",
// "client_secret" : "FP9rBEpFNgVYl9LakaHBOgdfIZR3ZUgsVM0jdcw9",
// "username" : "komal2@gmail.com",
// "password" : "admin",
// "scope" : "*"

function getTokenAndRefreshToken(Client $oClient, $email, $password)
{
    $oClient = Client::where('password_client', 1)->first();
    $http = new Client;
    $response = $http->request('POST', 'http://mylemp-nginx/oauth/token', [
        'form_params' => [
            'grant_type' => 'password',
            'client_id' => $oClient->id,
            'client_secret' => $oClient->secret,
            'username' => $email,
            'password' => $password,
            'scope' => '*',
        ],
    ]);
    $result = json_decode((string) $response->getBody(), true);
}
