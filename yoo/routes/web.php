<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\Operator\OperatorController;
use App\Http\Controllers\Frontend\Management\ManagementController;
use App\Http\Controllers\Frontend\ShopAdmin\ShopAdminController;
use App\Http\Controllers\Frontend\LegalDocs\LegalDocsController;
use App\Http\Controllers\Frontend\ApiDocs\ApiDocsController;
use App\Http\Controllers\Frontend\Download\DownloadController;
use App\Http\Controllers\Frontend\Landing\LandingController;
use App\Http\Controllers\Frontend\Customer\CustomerController;
use App\Http\Controllers\Address\AddressController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ChangePassController;
use App\Http\Controllers\VerificationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

//Version2
Route::get('/loginv2', [LoginController::class, 'loginv2']);
Route::get('/registerv2', [RegisterController::class, 'registerv2'])->name('registerv2');


//api docs
Route::get('/documentation/api/v1', [ApiDocsController::class, 'apiDocs']);

// login
Route::prefix('login')->middleware(['guest:operator', 'guest:management' ,'preventbackhistory'])->group(function () {
    Route::get('/', [LoginController::class, 'login'])->name('login');
    Route::post('/authenticate', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

// register
Route::prefix('register')->middleware(['guest:operator', 'guest:management' ,'preventbackhistory'])->group(function () {
    Route::get('/', [RegisterController::class, 'register'])->name('register'); //register.
    Route::post('/create-new-account', [RegisterController::class, 'createNewAccount'])->name('register.createNewAccount');
    Route::post('/create-customer-account', [RegisterController::class, 'createCustomerAccount'])->name('register.createCustomerAccount');
});

// address
Route::prefix('address')->group(function () {
    Route::get('/province', [AddressController::class, 'province'])->name('address.province');
    Route::get('/city', [AddressController::class, 'city'])->name('address.city');
    Route::get('/barangays', [AddressController::class, 'barangay'])->name('address.barangay');
    Route::get('/barangay-by-province', [AddressController::class, 'barangayByProvince'])->name('address.barangayByProvince');
    Route::get('/barangay-by-city', [AddressController::class, 'barangayByCity'])->name('address.barangayByCity');
});

// verify
Route::prefix('verify')->group(function () {
    Route::get('/email', [VerificationController::class, 'email'])->name('verify.email');
    Route::get('/mobile-number', [VerificationController::class, 'mobileNumber'])->name('verify.mobileNumber');
    Route::get('/verify-sponsor-code', [VerificationController::class, 'sponsorCode'])->name('verify.sponsorCode');
    Route::get('/shop-code', [VerificationController::class, 'shopCode'])->name('verify.shopCode');
    Route::get('/shop-catergory', [VerificationController::class, 'shopCategory'])->name('verify.shopCategory');
    Route::get('/verify-referral-code', [VerificationController::class, 'referralCode'])->name('verify.referralCode');
    Route::get('/verify-place-id', [VerificationController::class, 'placeId'])->name('verify.placeId');
    Route::get('/verify-old-password', [VerificationController::class, 'checkOldPass'])->name('verify.checkOldPass');
    Route::get('/verify-otp', [VerificationController::class, 'checkOtpCode'])->name('verify.checkOtpCode');
});

// Change Pass
Route::prefix('change-pass')->group(function () {
    Route::get('/inside', [ChangePassController::class, 'changePassInside'])->name('changePass.changePassInside');
    Route::post('/send-otp-code', [ChangePassController::class, 'sendOtpCode'])->name('changePass.sendOtpCode');
    Route::post('/verify-otp-code-inside', [ChangePassController::class, 'verifyOtpCodeInside'])->name('changePass.verifyOtpCodeInside');
    Route::get('/new-pass', [ChangePassController::class, 'newPassInside'])->name('changePass.newPassInside');
    Route::post('/verify-new-pass-Inside', [ChangePassController::class, 'verifyNewPassInside'])->name('changePass.verifyNewPassInside');
    Route::get('/forgot-password', [ChangePassController::class, 'forgotPassword'])->name('changePass.forgotPassword');
    Route::post('/check-mobile-number', [ChangePassController::class, 'checkMobileNumber'])->name('changePass.checkMobileNumber');
    Route::get('/outside', [ChangePassController::class, 'changePassOutside'])->name('changePass.changePassOutside');
    Route::post('/verify-otp-code-outside', [ChangePassController::class, 'verifyOtpCodeOutside'])->name('changePass.verifyOtpCodeOutside');
    Route::get('/new-pass-outside', [ChangePassController::class, 'newPassOutside'])->name('changePass.newPassOutside');
    Route::post('/verify-new-pass-outside', [ChangePassController::class, 'verifyNewPassOutside'])->name('changePass.verifyNewPassOutside');
});

// customer
Route::prefix('customer')->name('customer.')->group(function(){
    Route::get('/', [CustomerController::class, 'index'])->name('index');
});

// operator
Route::prefix('operator')->name('operator.')->group(function(){
    Route::middleware(['auth:operator', 'preventbackhistory'])->group(function(){
        Route::get('/', [OperatorController::class, 'index'])->name('index');
        Route::get('/users', [OperatorController::class, 'users'])->name('users');
        Route::get('/users/drivers-list', [OperatorController::class, 'driverList'])->name('users.driverList');
        Route::get('/users/suboperator-list', [OperatorController::class, 'subOperatorList'])->name('users.subOperatorList');

        // operator get users
        Route::get('/users/drivers', [OperatorController::class, 'getUserDrivers'])->name('getUserDrivers');
        Route::get('/users/operator', [OperatorController::class, 'getUserOperator'])->name('getUserOperator');

        // operator settings
        Route::get('/profile', [OperatorController::class, 'profile'])->name('profile');
        Route::get('/profile/sub-list', [OperatorController::class, 'getProfileSubList'])->name('getProfileSubList');
        Route::get('/driver-info/{id}', [OperatorController::class, 'driverInfo'])->name('driver-info');
        Route::get('/logout', [OperatorController::class, 'logout'])->name('logout');
        Route::get('/settings', [OperatorController::class, 'settings'])->name('settings');
        Route::get('/update-driver-verification-id/{id}/{status_id}', [OperatorController::class, 'updateDriverVerificationId'])->name('updateDriverVerificationId');
        Route::post('/update-profile/{id}', [OperatorController::class, 'updateProfile'])->name('update-profile');
        Route::get('/cancel-update', [OperatorController::class, 'cancelUpdate'])->name('cancelUpdate');

        // operator topup
        Route::get('/top-up/my-requests', [OperatorController::class, 'topUpMyRequestsFetch'])->name('topUpMyRequestsFetch');
        Route::get('/top-up/my-request/cancel/{id}', [OperatorController::class, 'topUpMyRequestCancel'])->name('topUpMyRequestCancel');
        Route::post('/top-up/send-request', [OperatorController::class, 'topUpSendRequest'])->name('topUpSendRequest');
        Route::get('/top-up/accounts', [OperatorController::class, 'topUpAccounts'])->name('topUpAccounts');
        Route::get('/top-up/accounts/fetch', [OperatorController::class, 'topUpAccountsFetch'])->name('topUpAccountsFetch');
        Route::post('/top-up/account/load', [OperatorController::class, 'topUpAccountsLoad'])->name('topUpAccountsLoad');
        Route::get('/top-up/account/requests', [OperatorController::class, 'topUpAccountsRequests'])->name('topUpAccountsRequests');
        Route::get('/top-up/requests', [OperatorController::class, 'topUpRequests'])->name('topUpRequests');
        Route::get('/top-up/requests/fetch', [OperatorController::class, 'topUpRequestsFetch'])->name('topUpRequestsFetch');
        Route::get('/top-up/request/view-details', [OperatorController::class, 'topUpRequestViewDetails'])->name('topUpRequestViewDetails');
        Route::post('/top-up/request/load', [OperatorController::class, 'topUpRequestLoad'])->name('topUpRequestLoad');
        Route::get('/top-up/transactions', [OperatorController::class, 'topUpTransactions'])->name('topUpTransactions');
        Route::get('/top-up/transactions/fetch', [OperatorController::class, 'topUpTransactionsFetch'])->name('topUpTransactionsFetch');

        Route::get('/top-up/view-requests', [OperatorController::class, 'topUpViewRequest'])->name('topUpViewRequest');

        Route::get('/top-up/get-cancel-my-requests', [OperatorController::class, 'getViewCancelRequest'])->name('getViewCancelRequest');
        Route::get('/top-up/cancel-my-request/{id}', [OperatorController::class, 'cancelTopUpRequest'])->name('cancelTopUpRequest');

        Route::post('/settings/update-profile', [OperatorController::class, 'settingsUpdateProfile'])->name('settingsUpdateProfile');
        Route::post('/settings/connect-wallet', [OperatorController::class, 'connectWallet'])->name('connectWallet');
        Route::get('/settings/update-wallet-fetch/{id}', [OperatorController::class, 'settingsWalletFetch'])->name('settingsWalletFetch');
        Route::post('/settings/update-wallet', [OperatorController::class, 'settingsWalletUpdate'])->name('settingsWalletUpdate');
        Route::post('/settings/disconnect-wallet', [OperatorController::class, 'settingsWalletDisconnect'])->name('settingsWalletDisconnect');
        Route::post('/settings/connect-wallet', [OperatorController::class, 'settingsWalletConnect'])->name('settingsWalletConnect');
        Route::post('/settings/send-otp', [OperatorController::class, 'settingsChangePassSendOtp'])->name('settingsChangePassSendOtp');
        Route::post('/settings/confirm-otp', [OperatorController::class, 'settingsChangePassConfirmOtp'])->name('settingsChangePassConfirmOtp');
        Route::post('/add-users', [OperatorController::class, 'addUsers'])->name('addUsers');

        // orders
        Route::get('/orders', [OperatorController::class, 'orders'])->name('orders');
        Route::get('/order/lists', [OperatorController::class, 'getOrderList'])->name('getOrderList');
        Route::post('/operator-payment', [OperatorController::class, 'operatorPayment'])->name('operatorPayment');

        // operator shops
        Route::get('/shop/{type}/{view}', [OperatorController::class, 'shop'])->name('shop'); //publish shop view
        Route::get('/shop/{type}/fetch/{shop_type_id}/grid', [OperatorController::class, 'shopFetchGrid'])->name('shopFetchGrid');
        Route::get('/shop/{type}/info/{id}', [OperatorController::class, 'shopInfo'])->name('shopInfo');
        Route::get('/shop-info/category/fetch/{id}', [OperatorController::class, 'shopInfoCategoryFetch'])->name('shopInfoCategoryFetch');
        Route::post('/shop/add', [OperatorController::class, 'addShop'])->name('addShop');
        Route::get('/shop/edit/fetch/{id}', [OperatorController::class, 'editShopFetch'])->name('editShopFetch');
        Route::post('/shop/edit', [OperatorController::class, 'editShop'])->name('editShop');

        Route::get('/shop-info/fetch/{item_category_id}', [OperatorController::class, 'shopInfoFetch'])->name('shopInfoFetch');
        Route::post('/shop-info/add-category', [OperatorController::class, 'shopInfoAddCategory'])->name('shopInfoAddCategory');

        Route::post('/shop-info/add-item', [OperatorController::class, 'shopInfoAddItem'])->name('shopInfoAddItem');
        Route::get('/shop/edit/item/fetch/{id}', [OperatorController::class, 'shopInfoEditItemFetch'])->name('shopInfoEditItemFetch');
        Route::post('/shop/edit/item', [OperatorController::class, 'shopInfoEditItem'])->name('shopInfoEditItem');
        Route::post('/shop/delete/item', [OperatorController::class, 'shopInfoDeleteItem'])->name('shopInfoDeleteItem');

        Route::get('/shop-info/submit/{id}', [OperatorController::class, 'shopInfoSubmit'])->name('shopInfoSubmit');
        Route::get('/shop-info/item/info-fetch/{id}', [OperatorController::class, 'shopInfoItemInfoFetch'])->name('shopInfoItemInfoFetch');
        Route::get('/shop-info/check-shop-count', [OperatorController::class, 'shopCheckShopCount'])->name('shopCheckShopCount');
        Route::get('/shop-info/item/toggle-fetch/{id}', [OperatorController::class, 'shopInfoItemToggleFetchItem'])->name('shopInfoItemToggleFetchItem');
        Route::post('/shop-info/add-shop-hour', [OperatorController::class, 'shopInfoAddShopHour'])->name('shopInfoAddShopHour');

        Route::post('/shop-info/item/add-item-variant', [OperatorController::class, 'shopInfoAddItemVariant'])->name('shopInfoAddItemVariant');
        Route::get('/shop/edit/item/edit-item-variant/fetch/{id}', [OperatorController::class, 'shopInfoEditItemVariantFetch'])->name('shopInfoEditItemVariantFetch');
        Route::post('/shop/edit/item/edit-item-variant', [OperatorController::class, 'shopInfoEditItemVariant'])->name('shopInfoEditItemVariant');
        Route::post('/shop/edit/item/delete-item-variant', [OperatorController::class, 'shopInfoDeleteItemVariant'])->name('shopInfoDeleteItemVariant');

        Route::post('/shop-info/item/add-item-combo-category', [OperatorController::class, 'shopInfoAddItemComboCategory'])->name('shopInfoAddItemComboCategory');

        Route::post('/shop-info/item/add-item-combo', [OperatorController::class, 'shopInfoAddItemCombo'])->name('shopInfoAddItemCombo');
        Route::get('/shop/edit/item/edit-item-combo/fetch/{id}', [OperatorController::class, 'shopInfoEditItemComboFetch'])->name('shopInfoEditItemComboFetch');
        Route::post('/shop/edit/item/edit-item-combo', [OperatorController::class, 'shopInfoEditItemCombo'])->name('shopInfoEditItemCombo');
        Route::post('/shop/edit/item/delete-item-combo', [OperatorController::class, 'shopInfoDeleteItemCombo'])->name('shopInfoDeleteItemCombo');
        // shop toggle route
        Route::post('/shop-info/item/toggle-status-update', [OperatorController::class, 'shopInfoItemToggleStatusUpdate'])->name('shopInfoItemToggleStatusUpdate');
        Route::post('/shop-info/toggle-status-update', [OperatorController::class, 'shopInfoToggleStatusUpdate'])->name('shopInfoToggleStatusUpdate');
        Route::get('/shop-info/submit-shop-approval/{id}', [OperatorController::class, 'submitShopApproval'])->name('submitShopApproval');
        Route::get('/shop-info/note-fetch/{id}', [OperatorController::class, 'shopInfoNoteFetch'])->name('shopInfoNoteFetch');
        Route::get('/shop-info/toggle-fetch/{id}', [OperatorController::class, 'shopInfoToggleFetch'])->name('shopInfoToggleFetch');


        Route::post('/shop-info/edit/shop-image', [OperatorController::class, 'shopInfoEditShopImage'])->name('shopInfoEditShopImage'); // edit shop image
        Route::post('/shop-info/edit/item-image', [OperatorController::class, 'shopInfoEditItemImage'])->name('shopInfoEditItemImage'); // edit shop image




    });
});

// management
Route::prefix('management')->name('management.')->group(function(){
    Route::middleware(['auth:management' ,'preventbackhistory'])->group(function(){
        Route::get('/', [ManagementController::class, 'index'])->name('index');
        // management users
        Route::get('/user/drivers', [ManagementController::class, 'userDrivers'])->name('userDrivers');
        Route::get('/user/drivers/fetch', [ManagementController::class, 'userDriversFetch'])->name('userDriversFetch');
        Route::get('/user/driver/info/{id}', [ManagementController::class, 'userDriverInfo'])->name('userDriverInfo');
        Route::get('/user/driver/info/update-verification-status/{id}/{status_id}', [ManagementController::class, 'userDriverInfoUpdateVerificationStatus'])->name('userDriverInfoUpdateVerificationStatus');

        Route::get('/user/customers', [ManagementController::class, 'userCustomers'])->name('userCustomers');
        Route::get('/user/customers/fetch', [ManagementController::class, 'userCustomersFetch'])->name('userCustomersFetch');

        Route::get('/user/operators', [ManagementController::class, 'userOperators'])->name('userOperators');
        Route::get('/user/operators/fetch', [ManagementController::class, 'userOperatorsFetch'])->name('userOperatorsFetch');
        Route::get('/user/operator/info/{id}', [ManagementController::class, 'userOperatorInfo'])->name('userOperatorInfo');
        Route::get('/user/operator/info/update-verification-status/{id}/{status_id}', [ManagementController::class, 'userOperatorInfoUpdateVerificationStatus'])->name('userOperatorInfoUpdateVerificationStatus');
        Route::post('/user/operator/info/add-payment/{id}', [ManagementController::class, 'userOperatorInfoAddPayment'])->name('userOperatorInfoAddPayment');
        Route::get('/user/operator/info/payment-details/fetch', [ManagementController::class, 'userOperatorInfoPaymetDetailsFetch'])->name('userOperatorInfoPaymetDetailsFetch');
        Route::post('/user/operator/info/update-status', [ManagementController::class, 'userOperatorInfoUpdatePaymentStatus'])->name('userOperatorInfoUpdatePaymentStatus');
        Route::get('/user/operator/info/pending-payments/fetch/{id}', [ManagementController::class, 'userOperatorInfoPendingPaymentsFetch'])->name('userOperatorInfoPendingPaymentsFetch');
        Route::get('/user/operator/info/subscription-packages/fetch/{id}', [ManagementController::class, 'userOperatorInfoSubscriptionPackegesFetch'])->name('userOperatorInfoSubscriptionPackegesFetch');
        Route::get('/user/managements', [ManagementController::class, 'userManagement'])->name('userManagement');
        Route::get('/user/managements/fetch', [ManagementController::class, 'userManagementFetch'])->name('userManagementFetch');
        // management get users

        Route::get('/users/getUserDetails', [ManagementController::class, 'getUserInfoDetails'])->name('getUserInfoDetails');
        Route::get('/logout', [ManagementController::class, 'logout'])->name('logout');
        Route::get('/profile', [ManagementController::class, 'profile'])->name('profile');

        // management topup
        Route::get('/top-up/accounts', [ManagementController::class, 'topUpAccounts'])->name('topUpAccounts');
        Route::get('/top-up/accounts/fetch', [ManagementController::class, 'topUpAccountsFetch'])->name('topUpAccountsFetch');
        Route::get('/top-up/account/transactions/fetch', [ManagementController::class, 'topUpAccountTransactionFetch'])->name('topUpAccountTransactionFetch');
        Route::post('/top-up/account/load', [ManagementController::class, 'topUpAccountLoad'])->name('topUpAccountLoad');
        Route::get('/top-up/requests', [ManagementController::class, 'topUpRequests'])->name('topUpRequests');
        Route::get('/top-up/requests/fetch', [ManagementController::class, 'topUpRequestsFetch'])->name('topUpRequestsFetch');
        Route::get('/top-up/request/view-details', [ManagementController::class, 'topUpRequestViewDetails'])->name('topUpRequestViewDetails');
        Route::post('/top-up/request/load', [ManagementController::class, 'topUpRequestLoad'])->name('topUpRequestLoad');

        Route::post('/add-users', [ManagementController::class, 'addUsers'])->name('addUsers');

        // Settings
        Route::get('/settings', [ManagementController::class, 'settings'])->name('settings');
        Route::post('/settings/update-profile', [ManagementController::class, 'settingsUpdateProfile'])->name('settingsUpdateProfile');
        Route::get('/settings/update-wallet-fetch/{id}', [ManagementController::class, 'settingsWalletFetch'])->name('settingsWalletFetch');
        Route::post('/settings/update-wallet', [ManagementController::class, 'settingsWalletUpdate'])->name('settingsWalletUpdate');
        Route::post('/settings/disconnect-wallet', [ManagementController::class, 'settingsWalletDisconnect'])->name('settingsWalletDisconnect');
        Route::post('/settings/connect-wallet', [ManagementController::class, 'settingsWalletConnect'])->name('settingsWalletConnect');
        Route::post('/settings/send-otp', [ManagementController::class, 'settingsChangePassSendOtp'])->name('settingsChangePassSendOtp');
        Route::post('/settings/confirm-otp', [ManagementController::class, 'settingsChangePassConfirmOtp'])->name('settingsChangePassConfirmOtp');

        // management order list
        Route::get('/orders', [ManagementController::class, 'orders'])->name('orders');
        Route::get('/orders/fetch', [ManagementController::class, 'ordersFetch'])->name('ordersFetch');

        // managemetn operator payment
        Route::post('/update/operator-status', [ManagementController::class, 'updateOperatorStatus'])->name('updateOperatorStatus');
        Route::get('/get-operator-payment-details-direct', [ManagementController::class, 'getPaymentDetailsDirect'])->name('getPaymentDetailsDirect');
        Route::post('/add-operator-subscription/{id}', [ManagementController::class, 'addOperatorSubscription'])->name('addOperatorSubscription');

        // management shops
        Route::get('/shop/{type}/{view}', [ManagementController::class, 'shop'])->name('shop'); //publish shop view
        Route::get('/shop/{type}/fetch/{shop_type_id}/grid', [ManagementController::class, 'shopFetchGrid'])->name('shopFetchGrid');
        Route::get('/shop/{type}/fetch/table', [ManagementController::class, 'shopFetchTable'])->name('shopFetchTable');
        Route::get('/shop/{type}/info/{id}', [ManagementController::class, 'shopInfo'])->name('shopInfo');
        Route::post('/shop/add', [ManagementController::class, 'addShop'])->name('addShop');
        Route::post('/shop-info/add-category', [ManagementController::class, 'shopInfoAddCategory'])->name('shopInfoAddCategory');
        Route::post('/shop-info/add-item', [ManagementController::class, 'shopInfoAddItem'])->name('shopInfoAddItem');
        Route::get('/shop-info/publish/{id}', [ManagementController::class, 'shopInfoPublish'])->name('shopInfoPublish');
        Route::get('/shop-info/toggle-fetch/{id}', [ManagementController::class, 'shopInfoToggleFetch'])->name('shopInfoToggleFetch');
        Route::post('/shop-info/toggle-status-update', [ManagementController::class, 'shopInfoToggleStatusUpdate'])->name('shopInfoToggleStatusUpdate');
        Route::get('/shop-info/item/toggle-fetch/{id}', [ManagementController::class, 'shopInfoItemToggleFetchItem'])->name('shopInfoItemToggleFetchItem');
        Route::post('/shop-info/item/toggle-status-update', [ManagementController::class, 'shopInfoItemToggleStatusUpdate'])->name('shopInfoItemToggleStatusUpdate');
        Route::get('/shop-info/item/info-fetch/{id}', [ManagementController::class, 'shopInfoItemInfoFetch'])->name('shopInfoItemInfoFetch');
        Route::post('/shop-info/item/add-item-combo-category', [ManagementController::class, 'shopInfoAddItemComboCategory'])->name('shopInfoAddItemComboCategory');
        Route::post('/shop-info/item/add-item-combo', [ManagementController::class, 'shopInfoAddItemCombo'])->name('shopInfoAddItemCombo');
        Route::get('/shop-info/item/item-combo/fetch{item_combo_category_id}', [ManagementController::class, 'shopInfoItemComboFetch'])->name('shopInfoItemComboFetch');
        Route::post('/shop-info/item/add-item-variant', [ManagementController::class, 'shopInfoAddItemVariant'])->name('shopInfoAddItemVariant');
        Route::get('/shop-info/approve-decline/{id}/{status}', [ManagementController::class, 'shopInfoApproveDecline'])->name('shopInfoApproveDecline');
        Route::post('/shop-info/add-note', [ManagementController::class, 'shopInfoAddNote'])->name('shopInfoAddNote');
        Route::post('/shop-info/add-shop-hour', [ManagementController::class, 'shopInfoAddShopHour'])->name('shopInfoAddShopHour');
        Route::post('/shop-info/edit/shop-image', [ManagementController::class, 'shopInfoEditShopImage'])->name('shopInfoEditShopImage'); // edit shop image
        Route::post('/shop-info/edit/item-image', [ManagementController::class, 'shopInfoEditItemImage'])->name('shopInfoEditItemImage'); // edit shop image
        Route::get('/shop/edit/fetch/{id}', [ManagementController::class, 'editShopFetch'])->name('editShopFetch');
        Route::post('/shop/edit', [ManagementController::class, 'editShop'])->name('editShop');
        Route::get('/shop/edit/item/fetch/{id}', [ManagementController::class, 'shopInfoEditItemFetch'])->name('shopInfoEditItemFetch');
        Route::post('/shop/edit/item', [ManagementController::class, 'shopInfoEditItem'])->name('shopInfoEditItem');
        Route::post('/shop/delete/item', [ManagementController::class, 'shopInfoDeleteItem'])->name('shopInfoDeleteItem');
        Route::get('/shop/edit/item/edit-item-combo/fetch/{id}', [ManagementController::class, 'shopInfoEditItemComboFetch'])->name('shopInfoEditItemComboFetch');
        Route::post('/shop/edit/item/edit-item-combo', [ManagementController::class, 'shopInfoEditItemCombo'])->name('shopInfoEditItemCombo');
        Route::post('/shop/edit/item/delete-item-combo', [ManagementController::class, 'shopInfoDeleteItemCombo'])->name('shopInfoDeleteItemCombo');
        Route::get('/shop/edit/item/edit-item-variant/fetch/{id}', [ManagementController::class, 'shopInfoEditItemVariantFetch'])->name('shopInfoEditItemVariantFetch');
        Route::post('/shop/edit/item/edit-item-variant', [ManagementController::class, 'shopInfoEditItemVariant'])->name('shopInfoEditItemVariant');
        Route::post('/shop/edit/item/delete-item-variant', [ManagementController::class, 'shopInfoDeleteItemVariant'])->name('shopInfoDeleteItemVariant');
    });
});

// shopadmin
Route::prefix('shopadmin')->name('shopadmin.')->group(function(){
    Route::middleware(['auth:shopadmin' ,'preventbackhistory'])->group(function(){
        //
        Route::get('/logout', [ShopAdminController::class, 'logout'])->name('logout');

        // Settings
        Route::get('/settings', [ShopAdminController::class, 'settings'])->name('settings');
        Route::post('/settings/update-profile', [ShopAdminController::class, 'settingsUpdateProfile'])->name('settingsUpdateProfile');
        Route::get('/settings/update-wallet-fetch/{id}', [ShopAdminController::class, 'settingsWalletFetch'])->name('settingsWalletFetch');
        Route::post('/settings/update-wallet', [ShopAdminController::class, 'settingsWalletUpdate'])->name('settingsWalletUpdate');
        Route::post('/settings/disconnect-wallet', [ShopAdminController::class, 'settingsWalletDisconnect'])->name('settingsWalletDisconnect');
        Route::post('/settings/connect-wallet', [ShopAdminController::class, 'settingsWalletConnect'])->name('settingsWalletConnect');
        Route::post('/settings/send-otp', [ShopAdminController::class, 'settingsChangePassSendOtp'])->name('settingsChangePassSendOtp');
        Route::post('/settings/confirm-otp', [ShopAdminController::class, 'settingsChangePassConfirmOtp'])->name('settingsChangePassConfirmOtp');

        // profile
        Route::get('/profile', [ShopAdminController::class, 'profile'])->name('profile');

        // shop
        Route::get('/shop/{type}/{view}', [ShopAdminController::class, 'shop'])->name('shop'); //publish shop view
        Route::get('/shop/{type}/fetch/{shop_type_id}/grid', [ShopAdminController::class, 'shopFetchGrid'])->name('shopFetchGrid');
        Route::get('/shop/{type}/info/{id}', [ShopAdminController::class, 'shopInfo'])->name('shopInfo');
        Route::post('/shop/add', [ShopAdminController::class, 'addShop'])->name('addShop');
        Route::get('/shop-info/category/fetch/{id}', [ShopAdminController::class, 'shopInfoCategoryFetch'])->name('shopInfoCategoryFetch');
        Route::post('/shop-info/add-category', [ShopAdminController::class, 'shopInfoAddCategory'])->name('shopInfoAddCategory');
        Route::post('/shop-info/add-item', [ShopAdminController::class, 'shopInfoAddItem'])->name('shopInfoAddItem');
        Route::get('/shop-info/publish/{id}', [ShopAdminController::class, 'shopInfoPublish'])->name('shopInfoPublish');
        Route::get('/shop-info/toggle-fetch/{id}', [ShopAdminController::class, 'shopInfoToggleFetch'])->name('shopInfoToggleFetch');
        Route::post('/shop-info/toggle-status-update', [ShopAdminController::class, 'shopInfoToggleStatusUpdate'])->name('shopInfoToggleStatusUpdate');
        Route::get('/shop-info/item/toggle-fetch/{id}', [ShopAdminController::class, 'shopInfoItemToggleFetchItem'])->name('shopInfoItemToggleFetchItem');
        Route::post('/shop-info/item/toggle-status-update', [ShopAdminController::class, 'shopInfoItemToggleStatusUpdate'])->name('shopInfoItemToggleStatusUpdate');
        Route::get('/shop-info/item/info-fetch/{id}', [ShopAdminController::class, 'shopInfoItemInfoFetch'])->name('shopInfoItemInfoFetch'); // fetch item info
        Route::post('/shop-info/item/add-item-combo-category', [ShopAdminController::class, 'shopInfoAddItemComboCategory'])->name('shopInfoAddItemComboCategory'); // delete item combo category
        Route::post('/shop-info/item/add-item-combo', [ShopAdminController::class, 'shopInfoAddItemCombo'])->name('shopInfoAddItemCombo'); //add item combo
        Route::post('/shop-info/item/add-item-variant', [ShopAdminController::class, 'shopInfoAddItemVariant'])->name('shopInfoAddItemVariant');
        Route::get('/shop-info/approve-decline/{id}/{status}', [ManagementController::class, 'shopInfoApproveDecline'])->name('shopInfoApproveDecline');
        Route::post('/shop-info/add-note', [ShopAdminController::class, 'shopInfoAddNote'])->name('shopInfoAddNote');
        Route::get('/shop-info/toggle-fetch/{id}', [ShopAdminController::class, 'shopInfoToggleFetch'])->name('shopInfoToggleFetch');
        Route::post('/shop-info/add-shop-hour', [ShopAdminController::class, 'shopInfoAddShopHour'])->name('shopInfoAddShopHour');
        Route::get('/shop/edit/fetch/{id}', [ShopAdminController::class, 'editShopFetch'])->name('editShopFetch'); // fetch shop data
        Route::post('/shop/edit', [ShopAdminController::class, 'editShop'])->name('editShop');  // edit shop
        Route::get('/shop/edit/item/fetch/{id}', [ShopAdminController::class, 'shopInfoEditItemFetch'])->name('shopInfoEditItemFetch'); // fetch item data
        Route::post('/shop/edit/item', [ShopAdminController::class, 'shopInfoEditItem'])->name('shopInfoEditItem'); //edit item
        Route::post('/shop/delete/item', [ShopAdminController::class, 'shopInfoDeleteItem'])->name('shopInfoDeleteItem'); // delete item
        Route::get('/shop/edit/item/edit-item-combo/fetch/{id}', [ShopAdminController::class, 'shopInfoEditItemComboFetch'])->name('shopInfoEditItemComboFetch'); //fetch item combo
        Route::post('/shop/edit/item/edit-item-combo', [ShopAdminController::class, 'shopInfoEditItemCombo'])->name('shopInfoEditItemCombo'); // edit item combo
        Route::post('/shop/edit/item/delete-item-combo', [ShopAdminController::class, 'shopInfoDeleteItemCombo'])->name('shopInfoDeleteItemCombo'); // delete item combo
        Route::get('/shop/edit/item/edit-item-variant/fetch/{id}', [ShopAdminController::class, 'shopInfoEditItemVariantFetch'])->name('shopInfoEditItemVariantFetch'); // fetch item variant data
        Route::post('/shop/edit/item/edit-item-variant', [ShopAdminController::class, 'shopInfoEditItemVariant'])->name('shopInfoEditItemVariant'); // edit item variant
        Route::post('/shop/edit/item/delete-item-variant', [ShopAdminController::class, 'shopInfoDeleteItemVariant'])->name('shopInfoDeleteItemVariant'); // delete item variant
        Route::post('/shop-info/edit/shop-image', [ShopAdminController::class, 'shopInfoEditShopImage'])->name('shopInfoEditShopImage'); // edit shop image
        Route::post('/shop-info/edit/item-image', [ShopAdminController::class, 'shopInfoEditItemImage'])->name('shopInfoEditItemImage'); // edit shop image

    });
});

// Route::prefix('management')->name('management.shopadmin')->group(function(){
//     Route::middleware(['auth:shopadmin' ,'preventbackhistory'])->group(function(){
//         Route::get('/shop/{type}/{view}', [ManagementController::class, 'shop'])->name('shop'); //publish shop view
//         Route::get('/shop/{type}/fetch/{shop_type_id}/grid', [ManagementController::class, 'shopFetchGrid'])->name('shopFetchGrid');
//         Route::get('/shop/{type}/fetch/table', [ManagementController::class, 'shopFetchTable'])->name('shopFetchTable');
//         Route::get('/shop/{type}/info/{id}', [ManagementController::class, 'shopInfo'])->name('shopInfo');
//         Route::post('/shop/add', [ManagementController::class, 'addShop'])->name('addShop');
//         Route::get('/shop-info/fetch/{item_category_id}', [ManagementController::class, 'shopInfoFetch'])->name('shopInfoFetch');
//         Route::post('/shop-info/add-category', [ManagementController::class, 'shopInfoAddCategory'])->name('shopInfoAddCategory');
//         Route::post('/shop-info/add-item', [ManagementController::class, 'shopInfoAddItem'])->name('shopInfoAddItem');
//         Route::get('/shop-info/publish/{id}', [ManagementController::class, 'shopInfoPublish'])->name('shopInfoPublish');
//         Route::get('/shop-info/toggle-fetch/{id}', [ManagementController::class, 'shopInfoToggleFetch'])->name('shopInfoToggleFetch');
//         Route::post('/shop-info/toggle-status-update', [ManagementController::class, 'shopInfoToggleStatusUpdate'])->name('shopInfoToggleStatusUpdate');
//         Route::get('/shop-info/item/toggle-fetch/{id}', [ManagementController::class, 'shopInfoItemToggleFetchItem'])->name('shopInfoItemToggleFetchItem');
//         Route::post('/shop-info/item/toggle-status-update', [ManagementController::class, 'shopInfoItemToggleStatusUpdate'])->name('shopInfoItemToggleStatusUpdate');

//         Route::get('/shop-info/approve-decline/{id}/{status}', [ManagementController::class, 'shopInfoApproveDecline'])->name('shopInfoApproveDecline');
//         Route::post('/shop-info/add-note', [ManagementController::class, 'shopInfoAddNote'])->name('shopInfoAddNote');
//         Route::get('/logout', [ManagementController::class, 'shopAdminLogout'])->name('logout');
//     });
// });




// Route::group(['prefix' => 'operator', 'middleware' => ['auth:web', 'preventbackhistory']], function () {
//     Route::get('/', [OperatorController::class, 'index'])->name('operator.index');
//     Route::get('/users', [OperatorController::class, 'users'])->name('operator.users');
//     Route::get('/users/drivers-list', [OperatorController::class, 'driverList'])->name('operator.users.driverList');
//     Route::get('/users/suboperator-list', [OperatorController::class, 'subOperatorList'])->name('operator.users.subOperatorList');

//     // operator get users
//     Route::get('/users/drivers', [OperatorController::class, 'getUserDrivers'])->name('operator.getUserDrivers');
//     Route::get('/users/operator', [OperatorController::class, 'getUserOperator'])->name('operator.getUserOperator');

//     // operator settings
//     Route::get('/profile', [OperatorController::class, 'profile'])->name('operator.profile');
//     Route::get('/profile/sub-list', [OperatorController::class, 'getProfileSubList'])->name('operator.getProfileSubList');
//     Route::get('/driver-info/{id}', [OperatorController::class, 'driverInfo'])->name('operator.driver-info');
//     Route::get('/logout', [OperatorController::class, 'logout'])->name('operator.logout');
//     Route::get('/settings', [OperatorController::class, 'settings'])->name('operator.settings');
//     Route::get('/update-driver-verification-id/{id}/{status_id}', [OperatorController::class, 'updateDriverVerificationId'])->name('operator.updateDriverVerificationId');
//     Route::post('/update-profile/{id}', [OperatorController::class, 'updateProfile'])->name('operator.update-profile');
//     Route::get('/cancel-update', [OperatorController::class, 'cancelUpdate'])->name('changePass.cancelUpdate');

//     // operator topup
//     Route::get('/top-up/my-requests', [OperatorController::class, 'topUpMyRequestsFetch'])->name('operator.topUpMyRequestsFetch');
//     Route::get('/top-up/my-request/cancel/{id}', [OperatorController::class, 'topUpMyRequestCancel'])->name('operator.topUpMyRequestCancel');
//     Route::post('/top-up/send-request', [OperatorController::class, 'topUpSendRequest'])->name('operator.topUpSendRequest');
//     Route::get('/top-up/accounts', [OperatorController::class, 'topUpAccounts'])->name('operator.topUpAccounts');
//     Route::get('/top-up/accounts/fetch', [OperatorController::class, 'topUpAccountsFetch'])->name('operator.topUpAccountsFetch');
//     Route::post('/top-up/account/load', [OperatorController::class, 'topUpAccountsLoad'])->name('operator.topUpAccountsLoad');
//     Route::get('/top-up/account/requests', [OperatorController::class, 'topUpAccountsRequests'])->name('operator.topUpAccountsRequests');
//     Route::get('/top-up/requests', [OperatorController::class, 'topUpRequests'])->name('operator.topUpRequests');
//     Route::get('/top-up/requests/fetch', [OperatorController::class, 'topUpRequestsFetch'])->name('operator.topUpRequestsFetch');
//     Route::get('/top-up/request/view-details', [OperatorController::class, 'topUpRequestViewDetails'])->name('operator.topUpRequestViewDetails');
//     Route::post('/top-up/request/load', [OperatorController::class, 'topUpRequestLoad'])->name('operator.topUpRequestLoad');
//     Route::get('/top-up/transactions', [OperatorController::class, 'topUpTransactions'])->name('operator.topUpTransactions');
//     Route::get('/top-up/transactions/fetch', [OperatorController::class, 'topUpTransactionsFetch'])->name('operator.topUpTransactionsFetch');

//     Route::get('/top-up/view-requests', [OperatorController::class, 'topUpViewRequest'])->name('operator.topUpViewRequest');

//     Route::get('/top-up/get-cancel-my-requests', [OperatorController::class, 'getViewCancelRequest'])->name('operator.getViewCancelRequest');
//     Route::get('/top-up/cancel-my-request/{id}', [OperatorController::class, 'cancelTopUpRequest'])->name('operator.cancelTopUpRequest');

//     Route::post('/settings/connect-wallet', [OperatorController::class, 'connectWallet'])->name('operator.connectWallet');
//     Route::post('/settings/edit-wallet', [OperatorController::class, 'updateWallet'])->name('operator.updateWallet');
//     Route::post('/settings/disconnect-wallet', [OperatorController::class, 'disconnectWallet'])->name('operator.disconnectWallet');
//     Route::post('/add-users', [OperatorController::class, 'addUsers'])->name('operator.addUsers');

//     // orders
//     Route::get('/orders', [OperatorController::class, 'orders'])->name('operator.orders');
//     Route::get('/order/lists', [OperatorController::class, 'getOrderList'])->name('operator.getOrderList');
//     Route::post('/operator-payment', [OperatorController::class, 'operatorPayment'])->name('operator.operatorPayment');

//     // operator shops
//     Route::get('/shop/{type}', [OperatorController::class, 'shop'])->name('operator.shop'); //publish shop view
//     Route::get('/shop/{type}/fetch/{shop_type_id}/grid', [OperatorController::class, 'shopFetchGrid'])->name('operator.shopFetchGrid');
//     Route::get('/shop/{type}/info/{id}', [OperatorController::class, 'shopInfo'])->name('operator.shopInfo');
//     Route::post('/shop/add', [OperatorController::class, 'addShop'])->name('operator.addShop');
//     Route::get('/shop-info/fetch/{item_category_id}', [OperatorController::class, 'shopInfoFetch'])->name('operator.shopInfoFetch');
//     Route::post('/shop-info/add-category', [OperatorController::class, 'shopInfoAddCategory'])->name('operator.shopInfoAddCategory');
//     Route::post('/shop-info/add-item', [OperatorController::class, 'shopInfoAddItem'])->name('operator.shopInfoAddItem');
//     Route::post('/shop-info/update-status', [OperatorController::class, 'shopInfoUpdateStatus'])->name('operator.shopInfoUpdateStatus');
// });

// management
// Route::group(['prefix' => 'management', 'middleware' => ['auth:management', 'preventbackhistory']], function () {
//     Route::get('/', [ManagementController::class, 'index'])->name('management.index');
//     Route::get('/users', [ManagementController::class, 'user'])->name('management.users');

//     // management users
//     Route::get('/user/drivers', [ManagementController::class, 'userDrivers'])->name('management.userDrivers');
//     Route::get('/user/drivers/fetch', [ManagementController::class, 'userDriversFetch'])->name('management.userDriversFetch');
//     Route::get('/user/driver/info/{id}', [ManagementController::class, 'userDriverInfo'])->name('management.userDriverInfo');
//     Route::get('/user/driver/info/update-verification-status/{id}/{status_id}', [ManagementController::class, 'userDriverInfoUpdateVerificationStatus'])->name('management.userDriverInfoUpdateVerificationStatus');

//     Route::get('/user/customers', [ManagementController::class, 'userCustomers'])->name('management.userCustomers');
//     Route::get('/user/customers/fetch', [ManagementController::class, 'userCustomersFetch'])->name('management.userCustomersFetch');

//     Route::get('/user/operators', [ManagementController::class, 'userOperators'])->name('management.userOperators');
//     Route::get('/user/operators/fetch', [ManagementController::class, 'userOperatorsFetch'])->name('management.userOperatorsFetch');
//     Route::get('/user/operator/info/{id}', [ManagementController::class, 'userOperatorInfo'])->name('management.userOperatorInfo');
//     Route::get('/user/operator/info/update-verification-status/{id}/{status_id}', [ManagementController::class, 'userOperatorInfoUpdateVerificationStatus'])->name('management.userOperatorInfoUpdateVerificationStatus');
//     Route::post('/user/operator/info/add-payment/{id}', [ManagementController::class, 'userOperatorInfoAddPayment'])->name('management.userOperatorInfoAddPayment');
//     Route::get('/user/operator/info/payment-details/fetch', [ManagementController::class, 'userOperatorInfoPaymetDetailsFetch'])->name('management.userOperatorInfoPaymetDetailsFetch');
//     Route::post('/user/operator/info/update-status', [ManagementController::class, 'userOperatorInfoUpdatePaymentStatus'])->name('management.userOperatorInfoUpdatePaymentStatus');
//     Route::get('/user/operator/info/pending-payments/fetch/{id}', [ManagementController::class, 'userOperatorInfoPendingPaymentsFetch'])->name('management.userOperatorInfoPendingPaymentsFetch');
//     Route::get('/user/operator/info/subscription-packages/fetch/{id}', [ManagementController::class, 'userOperatorInfoSubscriptionPackegesFetch'])->name('management.userOperatorInfoSubscriptionPackegesFetch');

//     Route::get('/user/managements', [ManagementController::class, 'userManagement'])->name('management.userManagement');
//     Route::get('/user/managements/fetch', [ManagementController::class, 'userManagementFetch'])->name('management.userManagementFetch');
//     // get users

//     Route::get('/users/getUserDetails', [ManagementController::class, 'getUserInfoDetails'])->name('management.getUserInfoDetails');

//     Route::get('/logout', [ManagementController::class, 'logout'])->name('management.logout');
//     Route::get('/settings', [ManagementController::class, 'settings'])->name('management.settings');
//     Route::get('/profile', [ManagementController::class, 'profile'])->name('management.profile');

//     Route::post('/update-profile/{id}', [ManagementController::class, 'updateProfile'])->name('management.updateProfile');

//     // management topup
//     Route::get('/top-up/accounts', [ManagementController::class, 'topUpAccounts'])->name('management.topUpAccounts');
//     Route::get('/top-up/accounts/fetch', [ManagementController::class, 'topUpAccountsFetch'])->name('management.topUpAccountsFetch');
//     Route::get('/top-up/account/transactions/fetch', [ManagementController::class, 'topUpAccountTransactionFetch'])->name('management.topUpAccountTransactionFetch');
//     Route::post('/top-up/account/load', [ManagementController::class, 'topUpAccountLoad'])->name('management.topUpAccountLoad');
//     Route::get('/top-up/requests', [ManagementController::class, 'topUpRequests'])->name('management.topUpRequests');
//     Route::get('/top-up/requests/fetch', [ManagementController::class, 'topUpRequestsFetch'])->name('management.topUpRequestsFetch');
//     Route::get('/top-up/request/view-details', [ManagementController::class, 'topUpRequestViewDetails'])->name('management.topUpRequestViewDetails');
//     Route::post('/top-up/request/load', [ManagementController::class, 'topUpRequestLoad'])->name('management.topUpRequestLoad');


//     Route::post('/add-users', [ManagementController::class, 'addUsers'])->name('management.addUsers');

//     // management wallet connect
//     Route::post('/settings/connect-wallet', [ManagementController::class, 'connectWallet'])->name('management.connectWallet');
//     Route::post('/settings/edit-wallet', [ManagementController::class, 'updateWallet'])->name('management.updateWallet');
//     Route::post('/settings/disconnect-wallet', [ManagementController::class, 'disconnectWallet'])->name('management.disconnectWallet');

//     // management order list
//     Route::get('/orders', [ManagementController::class, 'orders'])->name('management.orders');
//     Route::get('/orders/fetch', [ManagementController::class, 'ordersFetch'])->name('management.ordersFetch');

//     // managemetn operator payment
//     Route::post('/update/operator-status', [ManagementController::class, 'updateOperatorStatus'])->name('management.updateOperatorStatus');
//     Route::get('/get-operator-payment-details-direct', [ManagementController::class, 'getPaymentDetailsDirect'])->name('management.getPaymentDetailsDirect');
//     Route::post('/add-operator-subscription/{id}', [ManagementController::class, 'addOperatorSubscription'])->name('management.addOperatorSubscription');

//     // management shops
//     Route::get('/shop/{type}', [ManagementController::class, 'shop'])->name('management.shop'); //publish shop view
//     Route::get('/shop/{type}/fetch/{shop_type_id}/grid', [ManagementController::class, 'shopFetchGrid'])->name('management.shopFetchGrid');
//     Route::get('/shop/{type}/info/{id}', [ManagementController::class, 'shopInfo'])->name('management.shopInfo');
//     Route::post('/shop/add', [ManagementController::class, 'addShop'])->name('management.addShop');
//     Route::get('/shop-info/fetch/{item_category_id}', [ManagementController::class, 'shopInfoFetch'])->name('management.shopInfoFetch');
//     Route::post('/shop-info/add-category', [ManagementController::class, 'shopInfoAddCategory'])->name('management.shopInfoAddCategory');
//     Route::post('/shop-info/add-item', [ManagementController::class, 'shopInfoAddItem'])->name('management.shopInfoAddItem');
//     Route::post('/shop-info/update-status', [ManagementController::class, 'shopInfoUpdateStatus'])->name('management.shopInfoUpdateStatus');
// });







// Route::prefix('operator')->group(function(){

// })->middleware('auth');

//operator
// Route::prefix('operator')->group(function(){
//     Route::get('/login', [OperatorController::class,'login'])->name('operator.login');
//     Route::post('/checklogin', [OperatorController::class,'checkLogin'])->name('operator.checkLogin');
//     Route::get('/logout', [OperatorController::class,'logout'])->name('operator.logout');
//     Route::get('/register', [OperatorController::class,'register'])->name('oprator.register');
//     Route::get('/home', [OperatorController::class, 'home'])->name('operator.home');
//     Route::get('/users', [OperatorController::class, 'users'])->name('operator.users');
//     Route::get('/driver-info/{id}', [OperatorController::class, 'driverInfo'])->name('operator.driver-info');
//     Route::get('/profile', [OperatorController::class, 'profile'])->name('operator.profile');
//     Route::get('/settings', [OperatorController::class, 'settings'])->name('operator.settings');
// });




//customer

//legal docs
Route::get('/privacy', [LegalDocsController::class, 'privacy']);

//downloads
Route::prefix('download')->group(function () {
    Route::get('/driver-apk', [DownloadController::class, 'directDownloadDriverApk'])->name('download.directDownloadDriverApk');
    Route::get('/customer-apk', [DownloadController::class, 'directDownloadCustomerApk'])->name('download.directDownloadCustomerApk');
});

// landing Page
Route::get('/', [LandingController::class, 'index'])->name('landingPage');
