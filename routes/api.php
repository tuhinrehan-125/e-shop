<?php

use App\Http\Controllers\AdvanceController;
use App\Http\Controllers\BankController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CustomerGroupController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UnitController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PosController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\BusinessLocationController;
use App\Http\Controllers\VariationController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use App\Http\Controllers\StockTransferController;
use App\Http\Controllers\SellPurchaseReturnController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QuotationController;

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

Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
        'prefix'     => 'auth',
    ],
    function ($router) {
        Route::post('login', 'ApiAuthController@login');
        Route::post('signup', 'ApiAuthController@signup');
        Route::post('logout', 'ApiAuthController@logout');
        Route::get('userinfo', 'ApiAuthController@me');
        Route::get('refresh', 'ApiAuthController@refresh');
    }
);
Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
    ],
    function ($router) {
        Route::get('business-setting', "BusinessController@index");
        Route::post('business-setting-and-location', "BusinessController@saveSettingsAndLocation");
        Route::patch('business/{id}', "BusinessController@update");
        Route::get('get-currency', "BusinessController@getAllCurrency");
    }
);

Route::resource('business-location', BusinessLocationController::class)->only(['index', 'store','update','destroy']);
Route::resource('product', ProductsController::class);
Route::post('product/search', [ProductsController::class, 'productSearch']);
Route::post('product/search-by-category-brand', [ProductsController::class, 'searchByCategoryAndBrand']);
Route::get('customer-search', [CustomerController::class, 'customerSearch']);
Route::get('client-search', [ClientController::class, 'clientSearch']);
Route::post('contact-search', [ContactController::class, 'contactSearch']);

Route::resource('category', CategoryController::class);
Route::get('get-subcategories/{category}', [CategoryController::class, 'getSubcategories']);
Route::get('get-subunits/{unit}', [UnitController::class, 'getSubUnits']);


Route::resource('advance', AdvanceController::class);
Route::resource('client', ClientController::class);
Route::resource('customer', CustomerController::class);
Route::resource('customer-group', CustomerGroupController::class);
Route::resource('contact', ContactController::class);
Route::resource('payment', PaymentController::class);
// Route::resource('collection', CollectionController::class);
// Route::resource('commission', CommissionController::class);

Route::resource('expense', ExpenseController::class);
Route::resource('expense-category', ExpenseCategoryController::class);

Route::get('customer-due', [CollectionController::class, 'customerDueMoney']);
Route::get('dashboard-data', [UserController::class, 'dashboardData']);


Route::post('order', [OrderController::class, 'store']);
Route::get('pos-prodcuts', [OrderController::class, 'posProducts']);
Route::get('banks', [BankController::class, 'index']);

Route::group(
    [
        'middleware' => 'api',
        'namespace'  => 'App\Http\Controllers',
        'prefix'     => 'reports',
    ],
    function ($router) {
        Route::get('expense', 'ReportController@expenseReport');
        Route::get('collection', 'ReportController@collectionReport');
        Route::get('payment', 'ReportController@paymentReport');
        Route::get('sells', 'ReportController@sellsReport');
    }
);
Route::resource('quotation', QuotationController ::class)->except(['create','edit']);


Route::patch('user/{id}', [UserController::class, 'update']);
Route::post('update-settings', [SettingController::class, 'updateSettings']);
Route::get('settings', [SettingController::class, 'index']);

Route::resource('paymentMethod', PaymentMethodController::class);

Route::resource('brand', BrandController::class);

Route::resource('unit', UnitController::class);
Route::get('all-units', [UnitController::class,'allUnits']);

Route::resource('product-variation', VariationController::class);

Route::resource('purchase', PurchaseController::class);
Route::patch('purchase/addpayment/{id}', [PurchaseController::class, 'addPayment']);
Route::patch('sell/addpayment/{id}', [SellController::class, 'addPayment']);
Route::get('purchase-payment', [PurchaseController::class, 'viewPayment']);
Route::get('purchase-items', [PurchaseController::class, 'purchaseItemsList']);
Route::get('sell-items', [SellController::class, 'sellItemsList']);
Route::get('sell-payment', [SellController::class, 'viewPayment']);



Route::resource('stock-transfer', StockTransferController::class);

Route::resource('sell', SellController::class);
Route::get('/pos/product_info/{variation}/{location}', [SellPurchaseReturnController::class, 'getProductTnfo']);
Route::get('/pos/products', [SellPurchaseReturnController::class, 'getPosProducts']);
Route::get('purchase-return-list', [SellPurchaseReturnController::class, 'purchaseReturnList']);
Route::get('sell-return-list', [SellPurchaseReturnController::class, 'sellReturnList']);
Route::patch('purchase-return/{id}', [SellPurchaseReturnController::class, 'returnPurchase']);
Route::patch('sell-return/{id}', [SellPurchaseReturnController::class, 'returnSell']);
Route::resource('sell-return', SellPurchaseReturnController::class);
Route::patch('sell-return/{id}', [SellPurchaseReturnController::class, 'returnsell']);


Route::group(['middleware' => ['auth']], function () {
});

Route::resource('role', RoleController::class);
Route::post('role-has-permission/{id}', [RoleController::class, 'permissionList']);
Route::post('user-role/{id}', [RoleController::class, 'userRole']);
Route::get('permissions', [PermissionController::class,'index']);
Route::post('assign-permission', [PermissionController::class,'assignPermission']);
Route::post('create-user', [UserController::class,'createUserOfBusiness']);
Route::get('users', [UserController::class,'index']);

