<?php

use App\Http\Controllers\Admin\Api\CertificateController;
use App\Http\Controllers\Api\CertificateController as ApiCertificateController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\JobsController;
use App\Http\Controllers\Api\Rastaurant\RestaurantController;
use App\Http\Controllers\Api\SkillsController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->group(function () {

    Route::get('user', [GeneralController::class, 'user']);
    Route::post('init-info', [UserController::class, 'initInfo']);
    Route::post('update-info', [UserController::class, 'updateInfo']);
    Route::post('create-name',[UserController::class,'createName']);



    Route::middleware('role:vendor')->group(function () {
        Route::prefix('vendor')->group(function () {
            Route::post('update', [VendorController::class, 'update']);
            Route::post('updateOpening', [VendorController::class, 'updateOpening']);
            Route::get('bills', [VendorController::class, 'bills']);
            Route::get('reviews', [VendorController::class, 'reviews']);
            Route::post('add-review', [UserController::class, 'addReview']);
            Route::post('change-image', [VendorController::class, 'changeImage']);
            Route::prefix('products')->group(function () {
                Route::get('@{type}', [VendorController::class, 'products']);
                Route::get('single/{id}', [VendorController::class, 'productSingle']);
                Route::post('add', [VendorController::class, 'productsAdd']);
                Route::match(['GET','POST'],'gallery/{id}', [VendorController::class, 'gallery']);
                Route::post('edit', [VendorController::class, 'productsEdit']);
                Route::post('del', [VendorController::class, 'productsDel']);
            });


        });
        // Route::post('vendor/subscribe',[VendorController::class,'subscribe']);
        // Route::post('vendor/change-service',[VendorController::class,'changeMainService']);
        // Route::post('vendor/change-service-status',[VendorController::class,'changeStatusService']);
        // Route::post('vendor/add-Service',[VendorController::class,'addService']);

        Route::post('job/bids', [JobsController::class, 'jobBids']);
        Route::get('job/my-bids-list', [JobsController::class, 'myBidsList']);
        Route::post('job-bid', [JobsController::class, 'jobwiseBids']);
        Route::post('job-finished-request', [JobsController::class, 'jobFinishedRequest']);
        Route::post('job-bid-request-list', [JobsController::class, 'JobBidRequestList']);
        Route::get('vendor-finished-job', [JobsController::class, 'vendorFinishedJobs']);
        Route::post('accept-payment', [JobsController::class, 'acceptPayment']);



        Route::prefix('skill')->group(function () {
            Route::post('add', [SkillsController::class, 'addSkill']);
            Route::post('update', [SkillsController::class, 'updateSkill']);
            Route::get('list', [SkillsController::class, 'skillList']);
            Route::post('delete',[SkillsController::class,'skillDelete']);
        });


        Route::prefix('certificate')->group(function () {
            Route::post('add', [ApiCertificateController::class, 'addCertificate']);
            Route::post('update',[ApiCertificateController::class,'updateCertificate']);
            Route::get('list',[ApiCertificateController::class,'certificateList']);
            Route::post('delete',[ApiCertificateController::class,'certificateDelete']);
        });


    });


    Route::middleware('role:user')->group(function () {
        Route::post('add-review', [UserController::class, 'addReview']);
        Route::post('add-bookmark', [UserController::class, 'addBookmark']);
        Route::post('remove-bookmark', [UserController::class, 'removeBookmark']);
        Route::post('user/update', [UserController::class, 'update']);
        Route::post('user/change-image', [UserController::class, 'changeImage']);


        Route::prefix('job')->group(function () {
            Route::post('add', [JobsController::class, 'addJobs']);
            Route::post('edit', [JobsController::class, 'editJobs']);
            Route::post('delete', [JobsController::class, 'deleteJob']);
            Route::post('bid-list', [JobsController::class, 'jobBidList']);
            Route::get('bid-requested-list', [JobsController::class, 'jobBidRequestdList']);

            // Route::post('runnig', [JobsController::class, 'runningJob']);

        });

        Route::post('accept/bid',[JobsController::class, 'acceptBid']);
        Route::post('accept/job-finished-request',[JobsController::class, 'acceptJobFinishedRequest']);
        Route::get('user-finished-job', [JobsController::class, 'userFinishedJobs']);


        // restaurant
        Route::prefix('restaurant')->group(function () {
            Route::get('', [RestaurantController::class, 'restaurantList']);
            Route::post('menus', [RestaurantController::class, 'restaurantMenu']);
            Route::post('order', [RestaurantController::class, 'restaurantOrder']);
            Route::get('order-list', [RestaurantController::class, 'restaurantOrderList']);
        });

        Route::prefix('realstates')->group(function () {
            Route::get('', [RestaurantController::class, 'realstatesList']);
        });






    });


    Route::get('job/my-jobs', [JobsController::class, 'myJob']);
    Route::get('user', [GeneralController::class, 'user']);


});
Route::post('search', [GeneralController::class, 'searchProduct']);
Route::post('vendor', [GeneralController::class, 'vendor']);
Route::post('product', [GeneralController::class, 'product']);
Route::post('images', [GeneralController::class, 'images']);
Route::get('setting', [GeneralController::class, 'setting']);

Route::post('signup', [GeneralController::class, 'signup']);

Route::post('phonelogin',[UserController::class,'phoneLogin']);
Route::post('check-otps',[UserController::class,'checkOtps']);


