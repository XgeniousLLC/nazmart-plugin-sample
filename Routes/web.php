<?php

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
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

/* frontend routes */
Route::prefix('sitewaypaymentgateway')->group(function() {
    Route::post("landlord-price-plan-sitesway",[\Modules\SiteWayPaymentGateway\Http\Controllers\SiteWayPaymentGatewayController::class,"landlordPricePlanIpn"])
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->name("sitepaymentgateway.landlord.price.plan.ipn");

});


/* tenant payment ipn route*/
Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class
])->prefix('sitewaypaymentgateway')->group(function () {
    Route::post("tenant-price-plan-sitesway",[\Modules\SiteWayPaymentGateway\Http\Controllers\SiteWayPaymentGatewayController::class,"TenantSiteswayIpn"])
        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class])
        ->name("sitepaymentgateway.tenant.price.plan.ipn");

});

/* admin panel routes landlord */
Route::group(['middleware' => ['auth:admin','adminglobalVariable', 'set_lang'],'prefix' => 'admin-home'],function () {
    Route::prefix('sitewaypaymentgateway')->group(function() {
        Route::get('/settings', [\Modules\SiteWayPaymentGateway\Http\Controllers\SiteWayPaymentGatewayAdminPanelController::class,"settings"])->name("sitepaymentgateway.landlord.admin.settings");
        Route::post('/settings', [\Modules\SiteWayPaymentGateway\Http\Controllers\SiteWayPaymentGatewayAdminPanelController::class,"settingsUpdate"]);
    });
});


Route::group(['middleware' => [
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
    'auth:admin',
    'tenant_admin_glvar',
    'package_expire',
    'tenantAdminPanelMailVerify',
    'tenant_status',
    'set_lang'
    ],'prefix' => 'admin-home'],function () {
    Route::prefix('sitewaypaymentgateway/tenant')->group(function() {
        Route::get('/settings', [\Modules\SiteWayPaymentGateway\Http\Controllers\SiteWayPaymentGatewayAdminPanelController::class,"settings"])->name("sitepaymentgateway.tenant.admin.settings");
        Route::post('/settings', [\Modules\SiteWayPaymentGateway\Http\Controllers\SiteWayPaymentGatewayAdminPanelController::class,"settingsUpdate"]);
    });
});

