<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use App\Http\Middleware\CheckClient;

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

Route::group(["middleware" => ["auth", "checkAdmin"]], function () {
    Route::get("/", [
        App\Http\Controllers\DashboardController::class,
        "index",
    ])->name("dashboard.index");
});

Auth::routes([
    'register' => false, // Registration Routes...
    // 'reset' => false, // Password Reset Routes...
    // 'verify' => false, // Email Verification Routes...
]);

Route::get("/system/data/refresh", [App\Http\Controllers\DataController::class,"auto_refresh"])->name("auto_refresh");

// Account routes
Route::prefix('/account')->middleware(['auth'])->group(function () {
    Route::get("/", [App\Http\Controllers\AccountController::class, "index"])->name("account.index");    
    Route::put("/", [App\Http\Controllers\AccountController::class, "profile"])->name("profile.update");   
    Route::post("/password", [App\Http\Controllers\AccountController::class, "store_update_password"])->name("change_password");
    Route::post("/avatar", [App\Http\Controllers\AccountController::class, "uploadAvatar"])->name("avatar.upload");
});


// Dashboard routes
Route::group(["prefix" => "dashboard", "middleware" => ["auth","checkAdmin"]], function () {
    // Dashboard
    Route::get("/", [App\Http\Controllers\DashboardController::class,"index"])->name("dashboard");
    Route::get("/stats", [App\Http\Controllers\DashboardController::class,"stats"])->name("dashboard.stats");

    // client routes
    Route::group(["middleware" => ["can:view clients"]], function () {
        Route::prefix('client')->group(function () {

            // Index
            Route::get("/", [App\Http\Controllers\ClientController::class,"index"])->name("client.index");

            // Create
            Route::group(["middleware" => ["can:create client"]], function () {
                Route::get("/create", [App\Http\Controllers\ClientController::class,"create"])->name("client.create");
                Route::post("/", [App\Http\Controllers\ClientController::class,"save"])->name("client.save");
            });

            // Read
            Route::get("/{username}/details", [App\Http\Controllers\ClientController::class,"details"])->name("client.details");
            Route::get("/{username}/services", [App\Http\Controllers\ClientController::class,"services"])->name("client.service");
            Route::delete('/clear-mac-address/{id}', [App\Http\Controllers\ClientController::class, "clearMacAddress"])->name('clear_mac_address');
            Route::get("/{username}/statistics", [App\Http\Controllers\ClientController::class,"statistics"])->name("client.statistics");
            Route::get("/statistics/viewstats", [App\Http\Controllers\ClientController::class,"viewStats"])->name("view_stats");
            Route::get("/statistics/viewstats/sessions", [App\Http\Controllers\ClientController::class,"getSessionsData"])->name("view_stats.sessions");
            Route::get("/{username}/live_data", [App\Http\Controllers\ClientController::class,"liveData"])->name("client.livedata");
            Route::get("/services/active", [App\Http\Controllers\ClientController::class,"active_services"])->name("client.service.active");
            Route::get("/services/inactive", [App\Http\Controllers\ClientController::class,"inactive_services"])->name("client.service.inactive");
            Route::get("/online", [App\Http\Controllers\ClientController::class,"online"])->name("client.online");
            Route::get('/services/view/{type}', [App\Http\Controllers\ClientController::class, "display_services"])->name('client.view.services');
            Route::get('/services/{id}/service/status', [App\Http\Controllers\ClientController::class, 'getServiceStatus'])->name('service.status');

            // View and update client payments
            Route::group(["middleware" => ["can:manage finance"]], function () {
                Route::get("/{username}/billing", [App\Http\Controllers\ClientController::class,"billing"])->name("client.billing");
                Route::post("/{username}/payment", [App\Http\Controllers\ClientController::class,"payment"])->name("client.payment");
                Route::get("/{username}/invoices", [App\Http\Controllers\ClientController::class,"invoices"])->name("client.invoices");
                Route::post('/update-wallet-balance', [App\Http\Controllers\ClientController::class,"updateWalletBalance"])->name('update.wallet.balance');
            });

            // Update
            Route::group(["middleware" => ["can:update client"]], function () {
                Route::get("/edit/{username}", [App\Http\Controllers\ClientController::class,"edit"])->name("client.edit");
                Route::put("/edit/{username}", [App\Http\Controllers\ClientController::class,"update"])->name("client.update");
            });

            // Delete
            Route::group(["middleware" => ["can:delete client"]], function () {
                Route::post("/delete", [App\Http\Controllers\ClientController::class,"delete_client"])->name("client.delete");
            });

            // Manage client pppoe services
            Route::group(["middleware" => ["can:manage pppoe"]], function () {
                Route::get("/{username}/services/create", [App\Http\Controllers\ClientController::class,"create_service"])->name("client.create.service");
                Route::get("/services/{id}/edit", [App\Http\Controllers\ClientController::class,"edit_service"])->name("service.edit");
                Route::put("/services/{id}/update", [App\Http\Controllers\ClientController::class,"update_service"])->name("service.update");
                Route::post("/{username}/services/delete", [App\Http\Controllers\ClientController::class,"delete_service"])->name("service.delete");
                Route::post("/{username}/services/save", [App\Http\Controllers\ClientController::class,"save_service"])->name("service.save");
                Route::post("/services/{service}/extend", [App\Http\Controllers\ClientController::class,"extend"])->name("service.extend");
                Route::get("/disconnect/{service}", [App\Http\Controllers\ClientController::class,"disconnect"])->name("client.disconnect");
                Route::post('/service/block-unblock/{id}', [App\Http\Controllers\ClientController::class, 'blockUnblock'])->name('service.blockUnblock');
                Route::get('/service/{service}/change-service', [App\Http\Controllers\ClientController::class, 'changeService'])->name('service.change');
                Route::put("/service/{service}/update", [App\Http\Controllers\ClientController::class,"postUpdateService"])->name("client.service.update");

            });

            Route::get("{username}/communication", [App\Http\Controllers\ClientController::class, "communication"])->name("clients.communication");
            Route::get("{username}/logs", [App\Http\Controllers\ClientController::class, "logs"])->name("clients.logs");
            Route::post("{user}/message", [App\Http\Controllers\ClientController::class, "client_simple_send"])->name("client.message.send");
            Route::get('/fetch-tags', [App\Http\Controllers\ClientController::class, 'fetchTags'])->name('fetch.tags');

        });
    });

    // Leads routes
    Route::middleware('can:view leads')->prefix('leads')->group(function () {

        // Index
        Route::get("/", [App\Http\Controllers\LeadController::class,"index"])->name("lead.index");
    
        // Create
        Route::group(["middleware" => ["can:create lead"]], function () {
            Route::get("/create", [App\Http\Controllers\LeadController::class,"create"])->name("lead.create");
            Route::post("/", [App\Http\Controllers\LeadController::class,"save"])->name("lead.save");
        });

        // Update
        Route::group(["middleware" => ["can:update lead"]], function () {
            Route::get("/edit/{username}", [App\Http\Controllers\LeadController::class,"edit"])->name("lead.edit");
            Route::put("/edit/{username}", [App\Http\Controllers\LeadController::class,"update"])->name("lead.update");
        });
        // Delete
        Route::group(["middleware" => ["can:delete lead"]], function () {
            Route::post("/delete", [App\Http\Controllers\LeadController::class,"delete"])->name("lead.delete");
        });
        // Convert
        Route::group(["middleware" => ["can:convert lead"]], function () {
            Route::post("/convert", [App\Http\Controllers\LeadController::class,"convert"])->name("lead.convert");
        });
    });

    // Messages routes
    Route::middleware('can:view messages')->prefix('/messages')->group(function () {
        Route::get("/", [App\Http\Controllers\MessageController::class, "index"])->name("message.index");
        
        // Send single messages 
        Route::middleware('can:send message')->group(function () {
            Route::get("/create", [App\Http\Controllers\MessageController::class, "create"])->name("message.create");
            Route::post("/send", [App\Http\Controllers\MessageController::class, "simple_send"])->name("message.send");
        });
        //Send bulk messages
        Route::middleware('can:send bulk message')->group(function () {
            Route::get("/bulk", [App\Http\Controllers\MessageController::class, "bulk"])->name("message.bulk");
            Route::post("/bulk", [App\Http\Controllers\MessageController::class, "bulk_send"])->name("message.bulk.send");
        });
        // message format
        Route::post("/format", [App\Http\Controllers\MessageController::class, "format"])->name("message.format");
    });
    
    // Billing routes
    Route::middleware('can:manage finance')->prefix('billing')->group(function () {
        Route::get('/', [App\Http\Controllers\BillingController::class, 'index'])->name('billing.index');
        Route::get('/invoices', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice.index');
        Route::get('/invoice/create', [App\Http\Controllers\InvoiceController::class, 'create'])->name('invoice.create');
        Route::post('/invoice/create', [App\Http\Controllers\InvoiceController::class, 'store'])->name('invoice.store');
        Route::get('/invoice/{invoice}/edit', [App\Http\Controllers\InvoiceController::class, 'edit'])->name('invoice.edit');
        Route::put('/invoice/{invoice}/update', [App\Http\Controllers\InvoiceController::class, 'update'])->name('invoice.update');
        Route::post('/invoice/delete', [App\Http\Controllers\InvoiceController::class, 'destroy'])->name('invoice.delete');
        Route::post('/invoice/credit_note', [App\Http\Controllers\InvoiceController::class, 'createCreditNote'])->name('creditnote.store');
        Route::get('/invoice/creditnote/{id}', [App\Http\Controllers\InvoiceController::class, 'showCreditNoteAjax'])->name('creditnote.show.ajax');
        Route::get('/invoice/exportFilteredData', [App\Http\Controllers\InvoiceController::class, 'exportFilteredData'])->name('invoice.exportFilteredData');

        // View transactions
        Route::middleware('can:view transactions')->group(function () {
            Route::get('/mpesa', [App\Http\Controllers\BillingController::class, 'mpesa'])->name('billing.mpesa');
            Route::get('/mpesa/server-side-processing', [App\Http\Controllers\BillingController::class, 'mpesaServerSideProcessing'])->name('billing.mpesa.serverSideProcessing');
            Route::get('/transactions', [App\Http\Controllers\BillingController::class, 'transactions'])->name('billing.transactions');
            Route::get('/{id}/mpesa_transaction', [App\Http\Controllers\BillingController::class, 'mpesa_transaction'])->name('billing.mpesa_transaction');
        });
        // Create report
        Route::middleware('can:create report')->group(function () {
            Route::get('/report', [App\Http\Controllers\BillingController::class, 'report'])->name('billing.generateReport');
            Route::post('/report', [App\Http\Controllers\BillingController::class, 'generateReport'])->name('billing.report');
        });
    });

    // Nas Routes
    Route::middleware('can:manage nas')->prefix('nas')->group(function () {
        // Read/Index
        Route::get("/", [App\Http\Controllers\NasController::class, "index"])->name("nas.index");

        // Create
        Route::middleware('can:create nas')->group(function () {
            Route::get("/create", [App\Http\Controllers\NasController::class, "create"])->name("nas.create");
            Route::post("/create", [App\Http\Controllers\NasController::class, "save"])->name("nas.save");
        });
        
        // read details
        Route::get("/{id}/view", [App\Http\Controllers\NasController::class, "view"])->name("nas.view");
        Route::get("/{nas}/details", [App\Http\Controllers\NasController::class, "details"])->name("nas.details");
        Route::get("/{nas}/services", [App\Http\Controllers\NasController::class, "services"])->name("nas.services");

        // Update/Edit
        Route::middleware('can:update nas')->group(function () {
            Route::get("/{id}/edit", [App\Http\Controllers\NasController::class, "edit"])->name("nas.edit");
            Route::post("/edit", [App\Http\Controllers\NasController::class, "update"])->name("nas.update");
        });
        // View traffic 
        Route::get("/traffic", [App\Http\Controllers\NasController::class, "traffic"])->name("nas.traffic");

        // Configure nas
        Route::middleware('can:configure nas')->group(function () {
            Route::get("/nas/{nas}/config/login", [App\Http\Controllers\NasController::class,"login",])->name("nas.configLogin");
            Route::post("/{nas}/config", [App\Http\Controllers\NasController::class, "config"])->name("nas.config");
        });

        Route::get('/refreshAddress/{id}', [App\Http\Controllers\NasController::class, 'refreshAddress'])->name('nas.refreshAddress');

        // Delete
        Route::middleware('can:delete nas')->group(function () {
            Route::post("/delete", [App\Http\Controllers\NasController::class, "delete"])->name("nas.delete");
        });
    });
     
    // IPv4 Network routes
    Route::middleware('can:view network')->prefix('network')->group(function () {
        Route::get("/index", [App\Http\Controllers\NetworkController::class, "index"])->name("network.index");

        // update network
        Route::middleware('can:update network')->group(function () {
            Route::post("/update", [App\Http\Controllers\NetworkController::class, "store"])->name("network.store");
            Route::get("/{network}/edit", [App\Http\Controllers\NetworkController::class, "edit"])->name("network.edit");
            Route::put("/{network}/update", [App\Http\Controllers\NetworkController::class, "update"])->name("network.update");
            Route::get('/nas/get-ip-networks/{id}', [App\Http\Controllers\NetworkController::class, "nasNetworks"])->name('nas.networks');
            Route::get('/get-available-ip-addresses/{networkId}', [App\Http\Controllers\NetworkController::class, 'getAvailableIpAddresses'])->name('network.getAvailableIpAddresses');
            Route::delete('/{networkId}', [App\Http\Controllers\NetworkController::class, 'destroy'])->name('network.destroy');
        });
    });

    // Tariffs routes
    Route::middleware('can:view tariffs')->prefix('tariffs')->group(function () {

        // Index
        Route::get("/", [App\Http\Controllers\TariffController::class,"index"])->name("tariff.index");
    
        // Create
        Route::middleware(['can:create tariff'])->group(function () {
            Route::get("/create", [App\Http\Controllers\TariffController::class,"create"])->name("tariff.create");
            Route::post("/create", [App\Http\Controllers\TariffController::class,"save"])->name("tariff.save");
        });
        
        // Update
        Route::middleware(['can:update tariff'])->group(function () {
            Route::get("/{package}/edit", [App\Http\Controllers\TariffController::class,"edit"])->name("tariff.edit");
            Route::put("/{package}/update", [App\Http\Controllers\TariffController::class,"update"])->name("tariff.update");
        });
    
        // Delete
        Route::middleware(['can:delete tariff'])->group(function () {
            Route::post("/delete", [App\Http\Controllers\TariffController::class,"delete"])->name("tariff.delete");
        });
    });

    // admin Hotspot routes
    Route::middleware('can:manage hotspot')->prefix('hotspot')->group(function () {
        Route::get('/', [App\Http\Controllers\HotspotController::class, 'index'])->name('hotspot.index');

        // Hotspot design
        Route::middleware(['can:change hotspot design'])->group(function () {
            // Routes that require the middleware
            Route::get('/design', [App\Http\Controllers\HotspotController::class, 'design'])->name('hotspot.design');
            Route::post('/design', [App\Http\Controllers\HotspotController::class, 'uploadtemplate'])->name('hotspot.upload_template');
        });

        // Hotspot plans
        Route::middleware(['can:create hotspot plan'])->group(function () {
            // Routes that require the middleware
            Route::get('/plans', [App\Http\Controllers\PlanController::class, 'index'])->name('plan.index');
            Route::post('/plans', [App\Http\Controllers\PlanController::class, 'store'])->name('plan.store');
            Route::get('/plans/{id}/edit', [App\Http\Controllers\PlanController::class, 'edit'])->name('plan.edit');
            Route::put('/plans/{id}/update', [App\Http\Controllers\PlanController::class, 'update'])->name('plan.update');
            Route::post('/plans/delete', [App\Http\Controllers\PlanController::class, 'destroy'])->name('plan.delete');
        });

        // Hotspot vouchers
        Route::middleware(['can:create hotspot voucher'])->group(function () {
            // Routes that require the middleware
            Route::get('/vouchers', [App\Http\Controllers\VoucherController::class, 'index'])->name('voucher.index');
            Route::post('/vouchers', [App\Http\Controllers\VoucherController::class, 'createVoucher'])->name('voucher.store');
            Route::post('/vouchers/send', [App\Http\Controllers\VoucherController::class, 'send'])->name('voucher.send');
            Route::get('/vouchers/{id}/show', [App\Http\Controllers\VoucherController::class, 'show'])->name('voucher.show');
            Route::post('/vouchers/delete', [App\Http\Controllers\VoucherController::class, 'destroy'])->name('voucher.delete');
            Route::post('/vouchers/delete_multiple', [App\Http\Controllers\VoucherController::class, 'destroy_multiple'])->name('voucher.delete_multiple');
            Route::get('/vouchers/extend', [App\Http\Controllers\VoucherController::class, 'extend'])->name('voucher.extend');
            Route::post('/vouchers/extend', [App\Http\Controllers\VoucherController::class, 'extend_vouchers'])->name('extend_vouchers');
        });

        // Hotspot revenue
        Route::middleware(['can:view hotspot revenue'])->group(function () {
            // Route that requires the middleware
            Route::get('/revenue', [App\Http\Controllers\HotspotController::class, 'revenue'])->name('hotspot.revenue');
            // web.php
            Route::get('/stats/{month}', [App\Http\Controllers\HotspotController::class, 'hotspotstats'])->name('hotspotstats.show');
            // New route for server-side DataTables processing
            Route::get('/hotspotstats/data/{month}', [App\Http\Controllers\HotspotController::class, 'getHotspotStatsData'])->name('hotspotstats.data');
            Route::post('/hotspotstats/{month}/pdf', [App\Http\Controllers\HotspotController::class, 'generatePdf'])->name('hotspotstats.pdf');

        });

        // Hotspot settings
        Route::middleware(['can:change hotspot settings'])->group(function () {
            // Routes that require the middleware
            Route::get('/settings', [App\Http\Controllers\HotspotController::class, 'settings'])->name('hotspot.settings');
            Route::get('/mikrotik/template', [App\Http\Controllers\HotspotController::class, 'generateMikrotikFiles'])->name('hotspot.generateMikrotikFiles');
        });
    });
     
    // Settings routes
    Route::middleware('can:view admins')->prefix('admin')->group(function () {
        // Index
        Route::get('/', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
        Route::get('/activity_log', [App\Http\Controllers\AdminController::class, 'logs'])->name('admin.logs');

        // Define the middleware
        Route::middleware(['can:create admin'])->group(function () {
            // Routes that require the middleware
            Route::get('/user/create', [App\Http\Controllers\AdminController::class, 'create_user'])->name('admin.user.create');
            Route::post('/user/create', [App\Http\Controllers\AdminController::class, 'save_user'])->name('admin.user.save');
        });

        // Define the middleware
        Route::middleware(['can:edit admin'])->group(function () {
            // Routes that require the middleware
            Route::get('/user/edit/{username}', [App\Http\Controllers\AdminController::class, 'edit_user'])->name('admin.user.edit');
            Route::put('/user/edit/{user}', [App\Http\Controllers\AdminController::class, 'update_user'])->name('admin.user.update');
        });

        // Delete
        Route::middleware(['can:delete admin'])->group(function () {
            // Route that requires the middleware
            Route::post('/user/delete', [App\Http\Controllers\AdminController::class, 'delete_user'])->name('admin.user.delete');
        });
    
        // Roles routes
        Route::middleware(['can:manage roles'])->group(function () {
            // Routes that require the middleware
            Route::get('/roles', [App\Http\Controllers\RolesController::class, 'index'])->name('admin.role.index');
            Route::post('/roles', [App\Http\Controllers\RolesController::class, 'create'])->name('admin.role.create');
            Route::put('/roles/{id}', [App\Http\Controllers\RolesController::class, 'update'])->name('admin.role.update');
            Route::delete('/roles', [App\Http\Controllers\RolesController::class, 'destroy'])->name('admin.role.destroy');
        });

        // Permissions routes
        Route::middleware(['can:manage permissions'])->group(function () {
            // Routes that require the middleware
            Route::get('/permissions', [App\Http\Controllers\PermissionsController::class, 'index'])->name('admin.permission.index');
            Route::post('/permissions', [App\Http\Controllers\PermissionsController::class, 'rolepermissions'])->name('admin.permission.update');
        });
    });

    // Route::get("/finance", [
    //     App\Http\Controllers\DashboardController::class,
    //     "finance",
    // ])->name("admin.finance");

    // Settings routes
    Route::middleware('can:manage system settings')->prefix('settings')->group(function () {
        // General settings
        Route::prefix('general')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "general"])->name("settings.general");
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_general_settings"])->name("settings.general_save");
        });

        // Preferences settings
        Route::prefix('preferences')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "preferences"])->name("settings.preferences");
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_preferences_settings"])->name("settings.preferences_save");
        });

        // Notifications settings
        Route::prefix('notifications')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "notifications"])->name("settings.notifications");
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_notifications_settings"])->name("settings.notifications_save");
        });

        // Mail settings
        Route::prefix('mail')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "mail"])->name("settings.mail");
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_mail_settings"])->name("settings.mail_save");
        });

        Route::get("/communication", [App\Http\Controllers\SettingsController::class, "communication"])->name("settings.communication");

        // Mpesa settings
        Route::prefix('mpesa')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "mpesa"])->name("settings.mpesa");
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_mpesa_settings"])->name("settings.mpesa_save");
        });

        // Kopokopo settings
        Route::prefix('kopokopo')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "kopokopo"])->name("settings.kopokopo");
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_kopokopo_settings"])->name("settings.kopokopo_save");
        });

        // Equity Bank settings
        Route::prefix('equity')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "equity"])->name("settings.equity");
        });

        Route::prefix('components')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "systemServices"])->name("settings.components");
            Route::post('/restart/openvpn', [App\Http\Controllers\SettingsController::class,"restartOpenVpn"])->name('restart.openvpn');
            Route::post('/restart/freeradius', [App\Http\Controllers\SettingsController::class,"restartFreeRadius"])->name('restart.freeradius');
            Route::post('/restart/supervisor', [App\Http\Controllers\SettingsController::class,"restartSupervisor"])->name('restart.supervisor');

        });

        // Routes related to backup 
        // Route::get("/s3", [App\Http\Controllers\SettingsController::class, "s3"])->name("settings.s3");
        Route::post('/restore', [App\Http\Controllers\RestoreController::class, 'restore'])->name('restore.index');
        // Route::get('/restore-page', [App\Http\Controllers\RestoreController::class, 'restorePage'])->name('restore.page');

        // Map settings
        Route::get("/api_keys", [App\Http\Controllers\SettingsController::class, "apiKeys"])->name("settings.api");

        // SMS settings
        Route::prefix('sms')->group(function () {
            Route::get("/", [App\Http\Controllers\SettingsController::class, "smsGateways"])->name("settings.sms.smsGateways");
            Route::post("/gateway/upload", [App\Http\Controllers\SettingsController::class, "uploadGateway"])->name("sms.gateway.upload");
            Route::get('/{gateway}', [App\Http\Controllers\SettingsController::class, "showGatewaySettings"])->name('settings.sms.gateway');
            Route::post("/", [App\Http\Controllers\SettingsController::class, "save_sms_settings"])->name("settings.sms_save");
            Route::post('/delete-gateway/{gateway}', [App\Http\Controllers\SettingsController::class, "delete_gateway"])->name('delete.gateway');
        });

        // Logo and hotspot cover settings
        Route::post("/logo", [App\Http\Controllers\SettingsController::class, "uploadLogo"])->name("logo.upload");
        Route::post("/hotspot_cover", [App\Http\Controllers\SettingsController::class, "uploadHotspotImage"])->name("hotspotcover.upload");
        
        // Templates routes
        Route::prefix('templates')->group(function () {
            Route::get("/", [App\Http\Controllers\TemplateController::class, "index"])->name("templates.index");
            Route::get("/createsmstemplate", [App\Http\Controllers\TemplateController::class, "createsmstemplate"])->name("template.createsmstemplate");
            Route::get("/createmailtemplate", [App\Http\Controllers\TemplateController::class, "createmailtemplate"])->name("template.createmailtemplate");
            Route::post("/createsmstemplate", [App\Http\Controllers\TemplateController::class, "smsstore"])->name("template.smsstore");
            Route::post("/createmailtemplate", [App\Http\Controllers\TemplateController::class, "emailstore"])->name("template.emailstore");
            Route::get("/{template}/edit", [App\Http\Controllers\TemplateController::class, "edit"])->name("template.edit");
            Route::patch("/{template}/edit", [App\Http\Controllers\TemplateController::class, "update"])->name("template.update");
            Route::get("/defaults", [App\Http\Controllers\TemplateController::class, "defaults"])->name("template.defaults");
            Route::post("/destroy", [App\Http\Controllers\TemplateController::class, "destroy"])->name("template.delete");
            Route::post("/defaults", [App\Http\Controllers\SettingsController::class, "save_default_settings"])->name("settings.defaults.save");
        });
    
        // Ovpn routes
        Route::prefix('ovpn')->group(function () {
            Route::get("/", [App\Http\Controllers\OvpnController::class, "index"])->name("ovpn.index");
            Route::post("/setup", [App\Http\Controllers\OvpnController::class, "setup_ovpn"])->name("ovpn.setup_ovpn");
            Route::post("/", [App\Http\Controllers\OvpnController::class, "store"])->name("ovpn.store");
            Route::get("/{ovpn}/download", [App\Http\Controllers\OvpnController::class, "download"])->name("ovpn.download");
            Route::get('/ovpn/{ovpn}', [App\Http\Controllers\OvpnController::class, 'downloadOvpn'])->name('ovpn.download.device');
            Route::post("/restart", [App\Http\Controllers\OvpnController::class, "restartOpenVPN"])->name("ovpn.restart");
            Route::post("/delete", [App\Http\Controllers\OvpnController::class, "ovpn_delete_client"])->name("ovpn.delete");
        });
        Route::get("/import", [App\Http\Controllers\ExcelImportController::class, "customer_import_view"])->name("customer.import.view");
        Route::post("/import", [App\Http\Controllers\ExcelImportController::class, "import_customer"])->name("customer.import");
        Route::get("customers/export", [App\Http\Controllers\ExcelImportController::class, "export_customers"])->name("customer.export");
    });

    Route::middleware(['auth', 'role:super-admin'])->prefix('info')->group(function () {
        Route::get('/license', [App\Http\Controllers\SystemController::class, 'index'])->name('license.index');
        Route::post('/lisense/activate', [App\Http\Controllers\SystemController::class, 'activate'])->name('activate_license');
        Route::post('/lisense/reset', [App\Http\Controllers\SystemController::class, 'reset'])->name('license.reset');
        Route::get('/updater', [App\Http\Controllers\SystemController::class, 'get_update'])->name('updater.index');
        Route::post('/updater', [App\Http\Controllers\SystemController::class, 'update'])->name('updater.update');
        Route::get('/updater/progress/{uid}', [App\Http\Controllers\SystemController::class, 'progress'])->name('updater.progress');
    });

    Route::prefix('support')->group(function () {
        // Static routes should be defined first to avoid conflict with dynamic routes
        Route::get('/', [App\Http\Controllers\SupportController::class, 'index'])->name('support.index');
        Route::get('/config', [App\Http\Controllers\SupportController::class, 'config'])->name('support.config');
        Route::get('/preferences', [App\Http\Controllers\SupportController::class, 'preferences'])->name('support.preferences');
        Route::get('/get_users', [App\Http\Controllers\SupportController::class, 'getUsers'])->name('support.users');
        Route::post('/create_ticket', [App\Http\Controllers\SupportController::class, 'createTicket'])->name('support.store');
        
        // Routes related to configuration and searching
        Route::get('/tickets/search-user', [App\Http\Controllers\SupportController::class, 'searchUser'])->name('support.searchUser');
        Route::get('support/ticket-statistics', [App\Http\Controllers\SupportController::class, 'getTicketStatistics'])->name('tickets.statistics');
        Route::post('/support/attach-user-to-ticket', [App\Http\Controllers\SupportController::class, 'attachUserToTicket'])->name('support.attachToUser');
        Route::post('/config/mail', [App\Http\Controllers\SupportController::class, 'mail_save'])->name('support.mail_save');
        Route::post('/config/preferences', [App\Http\Controllers\SupportController::class, 'save_preferences'])->name('support.preferences_save');
    
        // Dynamic routes; these come later to avoid overriding static routes
        Route::get('{conversation}', [App\Http\Controllers\SupportController::class, 'show'])->name('support.show');
        Route::post('{conversation}/respond', [App\Http\Controllers\SupportController::class, 'respond'])->name('support.respond');
        Route::patch('{conversation}/status', [App\Http\Controllers\SupportController::class, 'updateStatus'])->name('support.updateStatus');
    });    
    
    
});

// public hotspot routes
Route::prefix('hotspot')->group(function () {
    Route::post('/vouchers/buy', [App\Http\Controllers\VoucherController::class, 'buy'])->name('voucher.buy');
    Route::post('/login_session', [App\Http\Controllers\HotspotController::class, 'login_session'])->name('hotspot.login_session');
    Route::get('/login', [App\Http\Controllers\HotspotController::class, 'login'])->name('hotspot.login');
    Route::post('/logincheck', [App\Http\Controllers\HotspotController::class, 'logincheck'])->name('hotspotlogincheck');
    Route::post('/checkVoucherIssuance', [App\Http\Controllers\HotspotController::class ,'checkVoucherIssuance'])->name('checkVoucherIssuance');
    // Route::get('/voucher-login/{voucher}', [App\Http\Controllers\HotspotController::class, 'autoLogin'])->name('hotspot.autologin');
});

// Ajax contact route
Route::post('/contact', [App\Http\Controllers\ContactController::class, 'contact'])->name('contact.post');

// Invoice show route
Route::get('/invoice/{number}', [App\Http\Controllers\InvoiceController::class, 'show'])->name('invoice.show');

// Payment routes
Route::prefix('c2b')->group(function () {
    Route::post('/payment/stkPush', [App\Http\Controllers\MpesaController::class, "stkPush"])->name("mpesa.stkPush");
    Route::post('/payment/register_url', [App\Http\Controllers\MpesaController::class, "register_url"])->name("mpesa.register_url");
    Route::post('/payment/validation', [App\Http\Controllers\MpesaController::class, "validation"])->name("mpesa.validation");
    Route::post('/payment/confirmation', [App\Http\Controllers\MpesaController::class, "confirmation"])->name("mpesa.confirmation");
    Route::post('/payment/callback', [App\Http\Controllers\MpesaController::class, "callback"])->name("mpesa.callback");
    // Kopokopo callback
    Route::post('/kopokopo/callback', [App\Http\Controllers\KopokopoController::class, "callback"])->name("kopokopo.callback");
    Route::post('/kopokopo/ipn', [App\Http\Controllers\KopokopoController::class, "ipn"])->name("kopokopo.ipn");
    // Equity bank payments
    Route::post('/equity/validation', [App\Http\Controllers\EquityBankPaymentController::class, 'validateBill'])->name('validate-bill');
    Route::post('/equity/confirmation', [App\Http\Controllers\EquityBankPaymentController::class, 'processNotification'])->name('process-notification');
});



// Customer Login
Route::get('customer/login', [App\Http\Controllers\CustomerLoginController::class, 'showLoginForm'])->name('customer.login');
Route::post('customer/login', [App\Http\Controllers\CustomerLoginController::class, 'login'])->name('customer.postAuth');
Route::post('customer/logout', [App\Http\Controllers\CustomerLoginController::class, 'logout'])->name('customer.logout');

// Customer dashboard routes
Route::prefix('customer')->middleware('portal', CheckClient::class)->group(function () {
    Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('customer.dashboard');
    Route::get('/transaction/{id}', [App\Http\Controllers\CustomerController::class, 'transaction'])->name('transaction.show');
    Route::post('/mpesa/stk', [App\Http\Controllers\MpesaController::class, 'stkPush'])->name('mpesa.customer.stk');
    Route::get('/invoices', [App\Http\Controllers\CustomerController::class, 'invoices'])->name('customer.invoices');
    Route::get('/statistics', [App\Http\Controllers\CustomerController::class, 'statistics'])->name('customer.statistics');
    Route::get("/statistics/viewstats", [App\Http\Controllers\CustomerController::class,"viewStats"])->name("customer.view_stats");
    Route::get("/livedata", [App\Http\Controllers\CustomerController::class,"livedata"])->name("customer.livedata");
    Route::get("/company/info", [App\Http\Controllers\CustomerController::class,"info"])->name("customer.company.info");
    Route::get("/service/update/{username}", [App\Http\Controllers\CustomerController::class,"updateService"])->name("customer.updateService");
    Route::put("/service/{service}/update", [App\Http\Controllers\CustomerController::class,"postUpdateService"])->name("customer.service.update");
    Route::get("/traffic", [App\Http\Controllers\CustomerController::class, "traffic"])->name("customer.traffic");
});





