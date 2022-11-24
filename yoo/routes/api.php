<?php

use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Driver\DriverController;
use App\Http\Controllers\Management\ManagementController;
use App\Http\Controllers\Operator\OperatorController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AuthenController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\PaymentInboxController;
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

//public routes
//User
// Route::prefix('user')->group(function () {
//     Route::post('/register', [UserController::class, 'register']);
//     Route::post('/login', [UserController::class, 'login']);
// });

//Customer
Route::prefix('customer')->group(function () {
    Route::post('/otp', [CustomerController::class, 'mobileOtp']);
    Route::post('/otp-verify', [CustomerController::class, 'otpVerify']);
    Route::post('/register', [CustomerController::class, 'register']);
    Route::post('/login', [CustomerController::class, 'login']);

    Route::post('/find-account', [CustomerController::class, 'findAccount']);
    Route::post('/change-pass-outside', [CustomerController::class, 'changePassOutside']);

    Route::post('/otp-verify/change-pass-outside', [CustomerController::class, 'changePassOtpVerifyOutside']);
    Route::get('/create-operator/{id}', [OperatorController::class, 'addOperatorOnce']);
});

Route::post('/update-wallet-method-image/{id}', [ShopController::class, 'updateShopTypeImage']);
Route::post('/update-wallet-method-image', [ShopController::class, 'updateWalletMethodImage']);


//driver
Route::prefix('driver')->group(function () {
    Route::post('/otp', [DriverController::class, 'mobileOtp']);
    Route::post('/otp-verify', [DriverController::class, 'otpVerify']);
    Route::post('/register', [DriverController::class, 'register']);
    Route::post('/login', [DriverController::class, 'login']);
    Route::post('/driver-noti', [DriverController::class, 'driverNoti']);

    Route::post('/update-by-id/{id}', [DriverController::class, 'updateProfileById']);
    Route::post('/find-account', [DriverController::class, 'findAccount']);
    Route::post('/change-pass-outside', [DriverController::class, 'changePassOutside']);

    Route::post('/otp-verify/change-pass-outside', [DriverController::class, 'changePassOtpVerifyOutside']);

    Route::get('/driver-sms', [DriverController::class,'driverSms'])->name('driverSms');

});

//management
Route::prefix('management')->group(function () {
    Route::post('/register', [ManagementController::class, 'register']);
    Route::post('/login', [ManagementController::class, 'login']);

});

//operator
Route::prefix('operator')->group(function () {
    Route::post('/register', [OperatorController::class, 'register']);
    Route::post('/login', [OperatorController::class, 'login']);
});

//dropdown
Route::prefix('dropdown')->group(function () {
    Route::get('/vehicle-types', [DropdownController::class, 'getVehicleTypes']);
    Route::get('/vehicle-areas', [DropdownController::class, 'getAreas']);
    Route::get('/management-roles', [DropdownController::class, 'managementRoles']);
    Route::get('/shop-types', [DropdownController::class, 'shopTypes']);
    Route::get('/item-tags', [DropdownController::class, 'itemTag']);
});

//authentications
Route::prefix('authen')->group(function () {
    Route::post('/change-pass-otp', [AuthenController::class, 'changePassOtp']);
    Route::post('/change-pass-otp-verify', [AuthenController::class, 'changePassOtpVerify']);
    Route::post('/change-pass', [AuthenController::class, 'changePass']);
});

//protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/driver/logout', [DriverController::class, 'logout']);

    Route::prefix('management')->group(function () {
        Route::post('/logout', [ManagementController::class, 'logout']);
        Route::get('/drivers/list', [ManagementController::class, 'driversList']);
        Route::get('/driver/show/{id}', [ManagementController::class, 'driverShow']);
        Route::post('/driver/verification/update/{id}', [ManagementController::class, 'driverVerificationUpdate']);
        Route::post('/payment-inbox', [ManagementController::class,'store'])->name('management.paymentInbox');
    });

    Route::prefix('customer')->group(function () {
        Route::get('/profile', [CustomerController::class, 'profile']);
        Route::post('/profile/update', [CustomerController::class, 'updateProfile']);
        Route::post('/logout', [CustomerController::class, 'logout']);
        Route::post('/order/create', [OrderController::class, 'orderCreate']);
        Route::post('/shop/order/create', [OrderController::class, 'shopOrderCreate']);
        Route::post('/addons', [CustomerController::class, 'AddOns']);
        Route::get('/order/{id}', [OrderController::class, 'customerOrder']);
        Route::get('/orders/ongoing', [OrderController::class, 'customerOngoingOrders']);
        Route::get('/orders/completed', [OrderController::class, 'customerCompletedOrders']);
        Route::get('/orders/cancelled', [OrderController::class, 'customerCancelledOrders']);
        Route::post('/order/update/{id}', [OrderController::class, 'customerOrdersUpdate']);
        Route::post('/token', [CustomerController::class, 'isToken']);
        Route::get('/item-types', [CustomerController::class, 'itemTypes']);
        Route::get('/payment-methods', [CustomerController::class, 'paymentMethod']);
        Route::get('/areas', [CustomerController::class, 'area']);
        Route::post('/change-pass-inside', [CustomerController::class, 'changePassInside']);
        Route::post('/otp-verify/change-pass-inside', [CustomerController::class, 'changePassOtpVerifyInside']);

        // shops
        Route::get('/shops/{shop_type_id}', [CustomerController::class, 'shopList']);
        Route::get('/shop/info/{id}', [CustomerController::class, 'shopInfo']);
        Route::get('/items/{shop_type_id}', [CustomerController::class, 'itemList']);
        Route::get('/item/info/{id}', [CustomerController::class, 'itemInfo']);
        Route::post('/shop/create-review', [CustomerController::class, 'createShopReview']);


        // credits
        Route::get('/credits', [CustomerController::class, 'credits']);
        Route::post('/credits/add', [CustomerController::class, 'addCredits']);
    });

    Route::prefix('driver')->group(function () {
        Route::get('/profile', [DriverController::class, 'profile']);
        Route::post('/profile/update', [DriverController::class, 'updateProfile']);
        Route::post('/document/update', [DriverController::class, 'updateDocument']);
        Route::get('/vehicles', [DriverController::class, 'getAllVehicle']);
        Route::post('/vehicle/update', [DriverController::class, 'updateVehicle']);
        Route::post('/vehicle/create', [DriverController::class, 'createVehicle']);
        Route::get('/orders/available', [OrderController::class, 'driverAvailableOrders']);
        Route::get('/orders/ongoing', [OrderController::class, 'driverOngoingOrders']);
        Route::get('/orders/completed', [OrderController::class, 'driverCompletedOrders']);
        Route::get('/orders/cancelled', [OrderController::class, 'driverCancelledOrders']);
        Route::post('/order/assign/{id}', [OrderController::class, 'driverOrderAssign']);
        Route::post('/order/update/{id}', [OrderController::class, 'driverOrderUpdate']);
        Route::post('/order/create/pickup-item-image/{id}', [OrderController::class, 'createPickUpItemImage']);
        Route::post('/token', [DriverController::class, 'isToken']);
        Route::post('/update/sponsor-code', [DriverController::class, 'updateSponsorCode']);
        Route::post('/order/create/arrived-pickup-item-image/{id}', [OrderController::class, 'arrivedPickUpitemImage']);
        Route::post('/topup/send-request', [DriverController::class, 'sendRequest']);
        Route::post('/topup/cancel-request/{id}', [DriverController::class, 'cancelRequest']);
        Route::get('/topup/view-request', [DriverController::class, 'viewRequest']);
        Route::get('/wallet-balance', [DriverController::class, 'walletBalance']);
        Route::get('/transaction', [DriverController::class, 'transactions']);
        Route::get('/areas', [DriverController::class, 'area']);
        Route::post('/order/coordinates/{id}', [OrderController::class, 'orderCoordinates']);
        Route::get('/images', [DriverController::class, 'driverImages']);
        Route::get('/topup-method', [DriverController::class, 'getTopUpMethod']);
        Route::get('/training-videos', [DriverController::class, 'traningVideo']);
        Route::post('/update/training-status/{id}', [DriverController::class, 'updateTrainingStatus']);
        Route::post('/change-pass-inside', [DriverController::class, 'changePassInside']);
        Route::post('/otp-verify/change-pass-inside', [DriverController::class, 'changePassOtpVerifyInside']);

    });

    Route::prefix('operator')->group(function () {
        Route::post('/subscription', [OperatorController::class, 'subscription']);
        Route::get('/profile', [OperatorController::class, 'profile']);
        Route::post('/profile/update', [OperatorController::class, 'updateProfile']);
        Route::get('/drivers/list', [OperatorController::class, 'driverList']);
        Route::get('/driver/show/{id}', [OperatorController::class, 'driverShow']);
        Route::post('/logout', [OperatorController::class, 'logout']);
    });
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
