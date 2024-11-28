<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\GetAllData;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Auth\ApiAuthController;
use App\Http\Controllers\Order\OrdersNewController;
use App\Http\Controllers\Api\MyslotApiController;
use App\Http\Controllers\Api\MyExpartsApiController;
use App\Http\Controllers\Api\CertificateApiController;
use App\Http\Controllers\Api\TransactionApiController;
use Laravel\Passport\Http\Controllers\ScopeController;
use App\Http\Controllers\Api\StoreprofileApiController;
use Laravel\Passport\Http\Controllers\ClientController;
use App\Http\Controllers\Agent\AppointmentslotController;
use App\Http\Controllers\Api\ServiceProductApiController;
use App\Http\Controllers\Api\AppointmentslotApiController;
use App\Http\Controllers\Api\PromotionBannerApiController;
use App\Http\Controllers\Api\UsercommonprofileApiController;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\Http\Controllers\AuthorizationController;
use Laravel\Passport\Http\Controllers\TransientTokenController;
use Laravel\Passport\Http\Controllers\PersonalAccessTokenController;
use App\Http\Controllers\Order\PaymentController;
use App\Http\Controllers\UserController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
// auth .....................................

Route::post('/register', [ApiAuthController::class, 'register']);
Route::post('/login', [ApiAuthController::class, 'login']);
Route::get('/getall', [GetAllData::class, 'getAllData']);
Route::get('/getallbygender', [GetAllData::class, 'getAllDataBygender']);
Route::get('promotion-banners', [PromotionBannerApiController::class, 'index']);
Route::middleware('auth:sanctum')->group(function () {});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/myexparts', [MyExpartsApiController::class, 'index']);
    Route::get('/myexparts/getall', [MyExpartsApiController::class, 'getall']);
    Route::post('/myexparts/store', [MyExpartsApiController::class, 'store']);
    Route::get('/myexparts/{id}/edit', [MyExpartsApiController::class, 'edit']);
    Route::put('/myexparts/{id}/update', [MyExpartsApiController::class, 'update']);
    Route::delete('/myexparts/{id}/delete', [MyExpartsApiController::class, 'destroy']);
});
Route::post('promotion-banners', [PromotionBannerApiController::class, 'store']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/paystore', [PaymentController::class, 'storepayment']);
    Route::get('/payments/{id}', [PaymentController::class, 'showpayment']);
    Route::get('/payments/order/{orderId}', [PaymentController::class, 'getByOrderIdpayment']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('promotion-banners/{promotionBanner}', [PromotionBannerApiController::class, 'show']);
    Route::put('promotion-banners/{promotionBanner}', [PromotionBannerApiController::class, 'update']);
    Route::delete('promotion-banners/{promotionBanner}', [PromotionBannerApiController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('myslots', [MyslotApiController::class, 'index']);
    Route::post('myslots/store', [MyslotApiController::class, 'store']);

    Route::put('myslots/{myslot}/update', [MyslotApiController::class, 'update']);
    Route::delete('myslots/{myslot}/delete', [MyslotApiController::class, 'destroy']);
});
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/certificates/get', [CertificateApiController::class, 'index']);
    Route::post('/certificates/store', [CertificateApiController::class, 'store']);
    Route::get('/certificates/{certificate}/show', [CertificateApiController::class, 'show']);
    Route::put('/certificates/{certificate}/update', [CertificateApiController::class, 'update']);
    Route::delete('/certificates/{certificate}/delete', [CertificateApiController::class, 'destroy']);
});


Route::middleware('auth:api')->group(function () {
    Route::get('/usercommonprofile', [UsercommonprofileApiController::class, 'index']);
    Route::post('/usercommonprofile/store', [UsercommonprofileApiController::class, 'store']);
    Route::get('/usercommonprofile/{id}', [UserCommonProfileController::class, 'show']);
    Route::get('/usercommonprofile/{id}/show', [UsercommonprofileApiController::class, 'show']);
    Route::post('/usercommonprofile/{id}/update', [UsercommonprofileApiController::class, 'update']);
    Route::delete('/usercommonprofile/{id}/delete', [UsercommonprofileApiController::class, 'destroy']);
});
Route::middleware('auth:api')->group(function () {
    Route::get('storeprofiles', [StoreprofileApiController::class, 'index']);
    Route::get('storeprofiles/get', [StoreprofileApiController::class, 'indexget']);
    Route::post('storeprofiles/store', [StoreprofileApiController::class, 'store']);
    Route::get('storeprofiles/{id}/show', [StoreprofileApiController::class, 'show']);
    Route::get('storeprofiles/{id}/getagent', [StoreprofileApiController::class, 'agentprofile']);
    Route::get('storeprofiles/{id}/getagentrecomendation', [StoreprofileApiController::class, 'agentrecomendation']);
    Route::put('storeprofiles/{id}/update', [StoreprofileApiController::class, 'update']);
    Route::delete('storeprofiles/delete/{id}', [StoreprofileApiController::class, 'destroy']);
    Route::get('locations/{cityId}', [StoreprofileApiController::class, 'getLocations']);
    Route::get('/storeprofiles/latest/{limit?}', [StoreProfileApiController::class, 'getLatestStoreProfiles']);
});
Route::middleware('auth:api')->group(function () {
    Route::get('serviceproducts/info', [ServiceProductApiController::class, 'index']);
    Route::get('serviceproducts/getall', [ServiceProductApiController::class, 'getall']);
    Route::post('serviceproducts/store', [ServiceProductApiController::class, 'store']);
    Route::get('serviceproducts/{id}/show', [ServiceProductApiController::class, 'show']);
    Route::put('serviceproducts/{id}/update', [ServiceProductApiController::class, 'update']);
    Route::delete('serviceproducts/{id}/delete', [ServiceProductApiController::class, 'destroy']);

    Route::get('subcategories', [ServiceProductApiController::class, 'getSubcategories']);
    Route::get('bodyparts', [ServiceProductApiController::class, 'getBodyParts']);
    Route::get('locations', [ServiceProductApiController::class, 'getLocations']);
    Route::get('appointmentslots', [ServiceProductApiController::class, 'getAppointmentSlots']);
});
Route::middleware('auth:sanctum')->group(function () {
    // If using API routes
    Route::get('/appointmentslots/slot/{slot_id}', [AppointmentslotApiController::class, 'showBySlotId']);
    // List all appointment slots
    Route::get('/appointmentslots/index', [AppointmentslotApiController::class, 'index']);

    // Create an appointment slot
    Route::post('/appointmentslots/store', [AppointmentslotApiController::class, 'store']);
    // List all appointment slots
    Route::get('/appointmentslots/{appointmentslots}/show', [AppointmentslotApiController::class, 'index']);

    // Get a single appointment slot
    Route::get('/appointmentslots/{appointmentslot}/showsingel', [AppointmentslotApiController::class, 'show']);

    // Update an appointment slot
    Route::put('/appointmentslots/{appointmentslot}/update', [AppointmentslotApiController::class, 'update']);

    // Delete an appointment slot
    Route::delete('/appointmentslots/{appointmentslot}/delete', [AppointmentslotApiController::class, 'destroy']);
});
// Apply Sanctum middleware to secure routes
Route::middleware('auth:sanctum')->group(function () {


    Route::get('/orders', [OrderApiController::class, 'index']);
    Route::post('/orders/store', [OrderApiController::class, 'store']);
    Route::get('/orders/{order}/show', [OrderApiController::class, 'show']);
    Route::put('/orders/{order}/update', [OrderApiController::class, 'update']);
    Route::delete('/orders/{order}/delete', [OrderApiController::class, 'destroy']);

    Route::put('/orders/{order}/status', [OrderApiController::class, 'updateStatus']);
    Route::get('/orders/agent/{agent_id}', [OrderApiController::class, 'getOrdersByAgentId']);
    Route::get('/orders/user/{user_id}', [OrderApiController::class, 'getOrdersByUserId']);
    Route::get('/orders/user/{user_id}/status/{status}', [OrderApiController::class, 'getOrdersByUserAndStatus']);
    Route::post('/service-products/filter-by-locations', [ServiceProductApiController::class, 'filterByLocations']);

    // Transaction routes
    Route::post('/transactions', [TransactionApiController::class, 'store']);
    Route::get('/transactions/{transaction}', [TransactionApiController::class, 'show']);
    Route::put('/transactions/{transaction}', [TransactionApiController::class, 'update']);
    Route::delete('/transactions/{transaction}', [TransactionApiController::class, 'destroy']);
});



Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users/{id}', [UsercommonprofileApiController::class, 'getUserByIdsingel']);
});
Route::middleware('auth:sanctum')->group(function () {
    // Route to create a new order
    Route::post('/orders/new', [OrdersNewController::class, 'store']);

    // Route for vendors to fetch their orders
    Route::get('/vendor/orders', [OrdersNewController::class, 'vendorOrders']);
    Route::get('vendor/{vendorId}/orders/overview', [OrdersNewController::class, 'getVendorOrdersOverview']);
    Route::get('vendor/{vendorId}/orders/overview2', [OrdersNewController::class, 'getVendorOrdersOverview2']);

    Route::post('/userorders/get', [OrdersNewController::class, 'findUserOrdersByStatus']);
    Route::post('/reviews', [OrdersNewController::class, 'storereview'])->middleware('auth:api');
    Route::post('/orders-vendo-news/{orderId}/update-items-status', [OrdersNewController::class, 'updateProductStatus']);
    // Get reviews by agent ID (API)
    Route::get('/reviews/agent/{agent_id}', [OrdersNewController::class, 'getReviewsByAgent']);
});
//Route::middleware('auth:api')->get('/user', [ApiAuthController::class, 'user']);
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });