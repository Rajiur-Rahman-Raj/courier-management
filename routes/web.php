<?php

use App\Http\Controllers\Admin\AdminDepositController;
use App\Http\Controllers\Admin\AdminFundController;
use App\Http\Controllers\Admin\AdminPayoutController;
use App\Http\Controllers\Admin\AdminStorageController;
use App\Http\Controllers\Admin\AdminTransactionController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\AdminTicketController;
use App\Http\Controllers\Admin\BranchController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\LocationController;
use App\Http\Controllers\Admin\ManualGatewayController;
use App\Http\Controllers\Admin\PackingController;
use App\Http\Controllers\Admin\ParcelController;
use App\Http\Controllers\Admin\PaymentLogController;
use App\Http\Controllers\Admin\RolesPermissionController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\BasicControlController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DepositController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\FundController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PayoutController;
use App\Http\Controllers\PayoutMethodController;
use App\Http\Controllers\SiteNotificationController;
use App\Http\Controllers\SmsControlController;
use App\Http\Controllers\SmsTemplateController;
use App\Http\Controllers\SubscribeController;
use App\Http\Controllers\SupportController;
use App\Http\Controllers\TemplateController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\UserShipmentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('queue-work', function () {
	return Illuminate\Support\Facades\Artisan::call('queue:work', ['--stop-when-empty' => true]);
})->name('queue.work');

Route::get('clear', function () {
	return Illuminate\Support\Facades\Artisan::call('optimize:clear');
});

Route::get('schedule-run', function () {
	return Illuminate\Support\Facades\Artisan::call('schedule:run');
})->name('schedule:run');

Route::get('removeStatus', function () {
	session()->forget('status');
})->name('removeStatus');

Route::match(['get', 'post'], 'success', [PaymentController::class, 'success'])->name('success');

Route::match(['get', 'post'], 'failed', [PaymentController::class, 'failed'])->name('failed');

Route::match(['get', 'post'], 'payment/{code}/{trx?}/{type?}', [PaymentController::class, 'gatewayIpn'])->name('ipn');

Auth::routes(['verify' => true]);

Route::group(['prefix' => 'admin'], function () {
	/* Authentication Routes */
	Route::get('/', [LoginController::class, 'showLoginForm'])->name('admin.login');
	Route::post('login', [LoginController::class, 'login'])->name('admin.auth.login');

	/* Password Reset Routes */
	Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
	Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
	Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('admin.password.reset')->middleware('guest');
	Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('admin.password.reset.update');

	Route::get('/403', [AdminController::class, 'forbidden'])->name('403');
});


Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'demo']], function () {

	/* ===== ADMIN STORAGE ===== */
	Route::get('storage', [AdminStorageController::class, 'index'])->name('storage.index');
	Route::any('storage/edit/{id}', [AdminStorageController::class, 'edit'])->name('storage.edit');
	Route::post('storage/set-default/{id}', [AdminStorageController::class, 'setDefault'])->name('storage.setDefault');

	Route::get('push-notification-show', [SiteNotificationController::class, 'showByAdmin'])->name('admin.push.notification.show');
	Route::get('push.notification.readAll', [SiteNotificationController::class, 'readAllByAdmin'])->name('admin.push.notification.readAll');
	Route::get('push-notification-readAt/{id}', [SiteNotificationController::class, 'readAt'])->name('admin.push.notification.readAt');

	// Manage Branch
	Route::middleware('permission')->group(function () {
		Route::get('branch-list', [BranchController::class, 'branchList'])->name('branchList');
		Route::get('create-branch', [BranchController::class, 'createBranch'])->name('createBranch');
		Route::post('branch-store', [BranchController::class, 'branchStore'])->name('branchStore');
		Route::get('branch-edit/{id}', [BranchController::class, 'branchEdit'])->name('branchEdit');
		Route::post('branch-update/{id}', [BranchController::class, 'branchUpdate'])->name('branchUpdate');
		Route::get('branch-profile/{id}', [BranchController::class, 'showBranchProfile'])->name('showBranchProfile');

		Route::get('branch-manager-list', [BranchController::class, 'branchManagerList'])->name('branchManagerList');
		Route::get('create-branch-manager', [BranchController::class, 'createBranchManager'])->name('createBranchManager');
		Route::post('branch-manager-store', [BranchController::class, 'branchManagerStore'])->name('branchManagerStore');
		Route::get('branch-manager-edit/{id}', [BranchController::class, 'branchManagerEdit'])->name('branchManagerEdit');
		Route::post('branch-manager-update/{id}', [BranchController::class, 'branchManagerUpdate'])->name('branchManagerUpdate');
		Route::get('branch-staff-list/{id}', [BranchController::class, 'branchStaffList'])->name('branchStaffList');

		// Manage Branch Employee
		Route::get('branch-employee-list', [BranchController::class, 'branchEmployeeList'])->name('branchEmployeeList');
		Route::get('create-employee', [BranchController::class, 'createEmployee'])->name('createEmployee');
		Route::post('branch-employee-store', [BranchController::class, 'branchEmployeeStore'])->name('branchEmployeeStore');
		Route::get('branch-employee-edit/{id}', [BranchController::class, 'branchEmployeeEdit'])->name('branchEmployeeEdit');
		Route::post('branch-employee-update/{id}', [BranchController::class, 'branchEmployeeUpdate'])->name('branchEmployeeUpdate');

		// Manage Branch Driver
		Route::get('branch-driver-list', [BranchController::class, 'branchDriverList'])->name('branchDriverList');
		Route::get('create-driver', [BranchController::class, 'createDriver'])->name('createDriver');
		Route::post('branch-driver-store', [BranchController::class, 'branchDriverStore'])->name('branchDriverStore');
		Route::get('branch-driver-edit/{id}', [BranchController::class, 'branchDriverEdit'])->name('branchDriverEdit');
		Route::post('branch-driver-update/{id}', [BranchController::class, 'branchDriverUpdate'])->name('branchDriverUpdate');

		// Manage Shipments
		Route::get('shipment-list/{shipment_status}/{shipment_type}', [ShipmentController::class, 'shipmentList'])->name('shipmentList');
		Route::get('{shipment_type}/create-shipment', [ShipmentController::class, 'createShipment'])->name('createShipment');
		Route::get('shipment/{id}/edit/{shipment_identifier}', [ShipmentController::class, 'editShipment'])->name('editShipment');
		Route::get('view-shipment/{id}', [ShipmentController::class, 'viewShipment'])->name('viewShipment');
		Route::post('shipment-store/{type?}', [ShipmentController::class, 'shipmentStore'])->name('shipmentStore');
		Route::post('shipment-update/{id}', [ShipmentController::class, 'shipmentUpdate'])->name('shipmentUpdate');

		Route::put('cancel-shipment-request/{id}', [ShipmentController::class, 'cancelShipmentRequest'])->name('cancelShipmentRequest');
		Route::put('accept-shipment-request/{id}', [ShipmentController::class, 'acceptShipmentRequest'])->name('acceptShipmentRequest');
		Route::put('assign-to-collect-shipment-request/{id}', [ShipmentController::class, 'assignToCollectShipmentRequest'])->name('assignToCollectShipmentRequest');
		Route::put('assign-to-delivered-shipment-request/{id}', [ShipmentController::class, 'assignToDeliveredShipmentRequest'])->name('assignToDeliveredShipmentRequest');

		Route::delete('shipment-delete/{id}', [ShipmentController::class, 'deleteShipment'])->name('deleteShipment');
		Route::get('trash-shipment-list', [ShipmentController::class, 'trashShipmentList'])->name('trashShipmentList');
		Route::get('restore-shipment/{id}', [ShipmentController::class, 'restoreShipment'])->name('restoreShipment');
		Route::delete('force-shipment-delete/{id}', [ShipmentController::class, 'forceDeleteShipment'])->name('forceDeleteShipment');

//		Route::put('shipment-status-update/{id}', [ShipmentController::class, 'shipmentStatusUpdate'])->name('shipmentStatusUpdate');
		Route::put('update-shipment-status/{id}/{type?}', [ShipmentController::class, 'updateShipmentStatus'])->name('updateShipmentStatus');
		Route::put('pay-condition-shipment-to-sender/{id}', [ShipmentController::class, 'payConditionShipmentToSender'])->name('payConditionShipmentToSender');

		// Manage Shipment Types
		Route::get('shipment-type-list', [ShipmentController::class, 'shipmentTypeList'])->name('shipmentTypeList');
		Route::put('shipment-type-update/{id}', [ShipmentController::class, 'shipmentTypeUpdate'])->name('shipmentTypeUpdate');

		// Manage Shipping rates
		Route::get('default-shipping-rate', [ShipmentController::class, 'defaultRate'])->name('defaultRate');
		Route::put('default-shipping-rate-operator-country-update/{id}', [ShipmentController::class, 'defaultShippingRateOperatorCountryUpdate'])->name('defaultShippingRateOperatorCountryUpdate');
		Route::put('default-shipping-rate-internationally-update/{id}', [ShipmentController::class, 'defaultShippingRateInternationallyUpdate'])->name('defaultShippingRateInternationallyUpdate');

		Route::get('operator-country-shipping-rate/{type?}', [ShipmentController::class, 'operatorCountryRate'])->name('operatorCountryRate');
		Route::get('create-shipping-rate-operator-country', [ShipmentController::class, 'createShippingRateOperatorCountry'])->name('createShippingRateOperatorCountry');
		Route::post('shipping-rate-operator-country-store/{type?}', [ShipmentController::class, 'shippingRateOperatorCountryStore'])->name('shippingRateOperatorCountry.store');
		Route::get('operator-country-show-shipping-rate/{type?}/{id}', [ShipmentController::class, 'operatorCountryShowRate'])->name('operatorCountryShowRate');
		Route::put('state-rete-update/{id}', [ShipmentController::class, 'stateRateUpdate'])->name('stateRateUpdate');
		Route::put('city-rete-update/{id}', [ShipmentController::class, 'cityRateUpdate'])->name('cityRateUpdate');
		Route::put('area-rete-update/{id}', [ShipmentController::class, 'areaRateUpdate'])->name('areaRateUpdate');
		Route::delete('delete-state-rate-operator-country/{id}', [ShipmentController::class, 'deleteStateRate'])->name('deleteStateRate');
		Route::delete('delete-city-rate-operator-country/{id}', [ShipmentController::class, 'deleteCityRate'])->name('deleteCityRate');
		Route::delete('delete-area-rate-operator-country/{id}', [ShipmentController::class, 'deleteAreaRate'])->name('deleteAreaRate');


		Route::get('internationally-shipping-rate/{type?}', [ShipmentController::class, 'internationallyRate'])->name('internationallyRate');
		Route::get('create-shipping-rate-internationally', [ShipmentController::class, 'createShippingRateInternationally'])->name('createShippingRateInternationally');
		Route::post('shipping-rate-internationally-store/{type?}', [ShipmentController::class, 'shippingRateInternationallyStore'])->name('shippingRateInternationally.store');

		Route::get('internationally-show-shipping-rate/{type?}/{id}', [ShipmentController::class, 'internationallyShowRate'])->name('internationallyShowRate');
		Route::put('country-rete-update-internationally/{id}', [ShipmentController::class, 'countryRateUpdateInternationally'])->name('countryRateUpdateInternationally');
		Route::put('state-rete-update-internationally/{id}', [ShipmentController::class, 'stateRateUpdateInternationally'])->name('stateRateUpdateInternationally');
		Route::put('city-rete-update-internationally/{id}', [ShipmentController::class, 'cityRateUpdateInternationally'])->name('cityRateUpdateInternationally');

		Route::delete('delete-internationally-country-rate/{id}', [ShipmentController::class, 'deleteICountryRate'])->name('deleteICountryRate');
		Route::delete('delete-internationally-state-rate/{id}', [ShipmentController::class, 'deleteIStateRate'])->name('deleteIStateRate');
		Route::delete('delete-internationally-city-rate/{id}', [ShipmentController::class, 'deleteICityRate'])->name('deleteICityRate');

		Route::post('shipping-date-store', [ShipmentController::class, 'shippingDateStore'])->name('shippingDateStore');

		// Manage Packing Service
		Route::get('packing-service-list', [PackingController::class, 'packingServiceList'])->name('packingServiceList');
		Route::post('package-store', [PackingController::class, 'packageStore'])->name('packageStore');
		Route::put('package-update/{id}', [PackingController::class, 'packageUpdate'])->name('packageUpdate');

		Route::post('variant-store', [PackingController::class, 'variantStor1e'])->name('variantStore');
		Route::put('variant-update/{id}', [PackingController::class, 'variantUpdate'])->name('variantUpdate');

		Route::post('packing-service-store', [PackingController::class, 'packingServiceStore'])->name('packingServiceStore');
		Route::put('packing-service-update/{id}', [PackingController::class, 'packingServiceUpdate'])->name('packingServiceUpdate');

		// Manage Parcel Service
		Route::get('parcel-service-list', [ParcelController::class, 'parcelServiceList'])->name('parcelServiceList');
		Route::post('parcel-type-store', [ParcelController::class, 'parcelTypeStore'])->name('parcelTypeStore');
		Route::put('package-type-update/{id}', [ParcelController::class, 'parcelTypeUpdate'])->name('parcelTypeUpdate');

		Route::post('parcel-unit-store', [ParcelController::class, 'parcelUnitStore'])->name('parcelUnitStore');
		Route::put('parcel-unit-update/{id}', [ParcelController::class, 'parcelUnitUpdate'])->name('parcelUnitUpdate');


		Route::post('parcel-service-store', [ParcelController::class, 'parcelServiceStore'])->name('parcelServiceStore');
		Route::put('parcel-service-update/{id}', [ParcelController::class, 'parcelServiceUpdate'])->name('parcelServiceUpdate');

		// Manage Clients
		Route::get('client-list', [ClientController::class, 'clientList'])->name('clientList');
		Route::get('client-create', [ClientController::class, 'createClient'])->name('createClient');
		Route::post('client-store', [ClientController::class, 'clientStore'])->name('clientStore');

		Route::get('client-edit/{id}', [ClientController::class, 'clientEdit'])->name('clientEdit');
		Route::post('client-update/{id}', [ClientController::class, 'clientUpdate'])->name('clientUpdate');


		// Manage Locations
		Route::get('country-list', [LocationController::class, 'countryList'])->name('countryList');
		Route::post('country-store', [LocationController::class, 'countryStore'])->name('countryStore');
		Route::put('country-update/{id}', [LocationController::class, 'countryUpdate'])->name('countryUpdate');

		Route::get('state/{type?}/{id?}', [LocationController::class, 'stateList'])->name('stateList');
		Route::post('state-store', [LocationController::class, 'stateStore'])->name('stateStore');
		Route::put('state-update/{id}', [LocationController::class, 'stateUpdate'])->name('stateUpdate');


		Route::get('city/{type?}/{id?}', [LocationController::class, 'cityList'])->name('cityList');
		Route::post('city-store', [LocationController::class, 'cityStore'])->name('cityStore');
		Route::put('city-update/{id}', [LocationController::class, 'cityUpdate'])->name('cityUpdate');

		Route::get('area/{type?}/{id?}', [LocationController::class, 'areaList'])->name('areaList');
		Route::post('area-store', [LocationController::class, 'areaStore'])->name('areaStore');
		Route::put('area-update/{id}', [LocationController::class, 'areaUpdate'])->name('areaUpdate');

		// Manage Departments
		Route::get('department-list', [DepartmentController::class, 'departmentList'])->name('departmentList');
		Route::get('create-department', [DepartmentController::class, 'createDepartment'])->name('createDepartment');
		Route::post('department-store', [DepartmentController::class, 'departmentStore'])->name('departmentStore');
		Route::get('department-edit/{id}', [DepartmentController::class, 'departmentEdit'])->name('departmentEdit');
		Route::post('department-update/{id}', [DepartmentController::class, 'departmentUpdate'])->name('departmentUpdate');


		/* USER LIST */
		Route::get('user-list', [UserController::class, 'index'])->name('user-list');
		Route::get('inactive-user-list', [UserController::class, 'inactiveUserList'])->name('inactive.user.list');

		Route::get('user-search', [UserController::class, 'search'])->name('user.search');
		Route::get('inactive-user-search', [UserController::class, 'inactiveUserSearch'])->name('inactive.user.search');

		Route::match(['get', 'post'], 'user-edit/{user}', [UserController::class, 'edit'])->name('user.edit');
		Route::match(['get', 'post'], 'vendor-edit/{user}', [UserController::class, 'vendorEdit'])->name('client.edit');
		Route::post('user-balance/update/{id}', [UserController::class, 'userBalanceUpdate'])->name('user.balance.update');
		Route::post('client-balance/update/{id}', [UserController::class, 'userBalanceUpdate'])->name('client.balance.update');
		Route::match(['get', 'post'], 'user-asLogin/{user}', [UserController::class, 'asLogin'])->name('user.asLogin');
		Route::match(['get', 'post'], 'user-clientLogin/{user}', [UserController::class, 'asLogin'])->name('user.clientLogin');
		Route::match(['get', 'post'], 'send-mail-user/{user?}', [UserController::class, 'sendMailUser'])->name('send.mail.user');

		/* PROFILE SHOW UPDATE BY USER */
		Route::match(['get', 'post'], 'profile', [AdminProfileController::class, 'index'])->name('admin.profile');
		Route::match(['get', 'post'], 'change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');


		/* PAYMENT METHOD MANAGE BY ADMIN*/
		Route::get('payment-methods', [PaymentMethodController::class, 'index'])->name('payment.methods');
		Route::get('edit-payment-methods/{id}', [PaymentMethodController::class, 'edit'])->name('edit.payment.methods');
		Route::put('update-payment-methods/{id}', [PaymentMethodController::class, 'update'])->name('update.payment.methods');
		Route::post('sort-payment-methods', [PaymentMethodController::class, 'sortPaymentMethods'])->name('sort.payment.methods');

		// Manual Methods
		Route::get('payment-methods/manual', [ManualGatewayController::class, 'index'])->name('admin.deposit.manual.index');
		Route::get('payment-methods/manual/new', [ManualGatewayController::class, 'create'])->name('admin.deposit.manual.create');
		Route::post('payment-methods/manual/new', [ManualGatewayController::class, 'store'])->name('admin.deposit.manual.store');
		Route::get('payment-methods/manual/edit/{id}', [ManualGatewayController::class, 'edit'])->name('admin.deposit.manual.edit');
		Route::put('payment-methods/manual/update/{id}', [ManualGatewayController::class, 'update'])->name('admin.deposit.manual.update');

		Route::get('payment/pending', [PaymentLogController::class, 'pending'])->name('admin.payment.pending');
		Route::put('payment/action/{id}', [PaymentLogController::class, 'action'])->name('admin.payment.action');
		Route::get('payment/log', [PaymentLogController::class, 'index'])->name('admin.payment.log');
		Route::get('payment/search', [PaymentLogController::class, 'search'])->name('admin.payment.search');

		/* PAYOUT METHOD MANAGE BY ADMIN */
		Route::get('payout-method-list', [PayoutMethodController::class, 'index'])->name('payout.method.list');
		Route::match(['get', 'put'], 'payout-method/{payoutMethod}', [PayoutMethodController::class, 'edit'])->name('payout.method.edit');
		Route::match(['get', 'post'], 'payout-method-add', [PayoutMethodController::class, 'addMethod'])->name('payout.method.add');

		/* ROLES AND PERMISSION BY ADMIN */
		Route::get('role/list', [RolesPermissionController::class, 'roleList'])->name('admin.role');
		Route::get('create/role', [RolesPermissionController::class, 'createRole'])->name('createRole');
		Route::post('role/store', [RolesPermissionController::class, 'roleStore'])->name('roleStore');
		Route::get('edit/role/{id}', [RolesPermissionController::class, 'editRole'])->name('editRole');
		Route::post('role/update/{id}', [RolesPermissionController::class, 'roleUpdate'])->name('roleUpdate');
		Route::delete('delete/role/{id}', [RolesPermissionController::class, 'deleteRole'])->name('deleteRole');

		Route::get('manage/staffs', [RolesPermissionController::class, 'staffList'])->name('admin.role.staff');
		Route::post('manage/staffs/create', [RolesPermissionController::class, 'staffCreate'])->name('admin.role.usersCreate');
		Route::put('manage/staffs/edit/{id}', [RolesPermissionController::class, 'staffEdit'])->name('admin.role.usersEdit');
		Route::post('manage/staffs/status/change/{id}', [RolesPermissionController::class, 'statusChange'])->name('admin.role.statusChange');

		Route::post('manage/manager/login/{id}', [RolesPermissionController::class, 'userLogin'])->name('admin.role.managerLogin');
		Route::post('manage/employee/login/{id}', [RolesPermissionController::class, 'userLogin'])->name('admin.role.employeeLogin');
		Route::post('manage/driver/login/{id}', [RolesPermissionController::class, 'userLogin'])->name('admin.role.driverLogin');
		Route::post('manage/staffs/login/{id}', [RolesPermissionController::class, 'userLogin'])->name('admin.role.usersLogin');

		/* ===== DEPOSIT VIEW MANAGE BY ADMIN ===== */
		Route::match(['get', 'post'], 'add-balance-user/{userId}', [AdminDepositController::class, 'addBalanceUser'])->name('admin.user.add.balance');

		/* ===== FUND ADD VIEW MANAGE BY ADMIN ===== */
		Route::get('fund-add-list', [AdminFundController::class, 'index'])->name('admin.fund.add.index');
		Route::get('fund-add-search', [AdminFundController::class, 'search'])->name('admin.fund.add.search');
		Route::get('fund-add-list/{userId}', [AdminFundController::class, 'showByUser'])->name('admin.user.fund.add.show');
		Route::get('fund-add-search/{userId}', [AdminFundController::class, 'searchByUser'])->name('admin.user.fund.add.search');

		/* ===== PAYOUT VIEW MANAGE BY ADMIN ===== */
		Route::get('payout-list', [AdminPayoutController::class, 'index'])->name('admin.payout.index');
		Route::get('payout-search', [AdminPayoutController::class, 'search'])->name('admin.payout.search');
		Route::get('payout-list/{userId}', [AdminPayoutController::class, 'showByUser'])->name('admin.user.payout.show');
		Route::get('payout-search/{userId}', [AdminPayoutController::class, 'searchByUser'])->name('admin.user.payout.search');
		Route::get('details-payout/{utr}', [AdminPayoutController::class, 'show'])->name('payout.details');
		Route::post('confirm-payout/{utr}', [AdminPayoutController::class, 'confirmPayout'])->name('admin.user.payout.confirm');
		Route::post('cancel-payout/{utr}', [AdminPayoutController::class, 'cancelPayout'])->name('admin.user.payout.cancel');

		/* Transaction List*/
		Route::get('transaction-list', [AdminTransactionController::class, 'index'])->name('admin.transaction.index');
		Route::get('transaction-search', [AdminTransactionController::class, 'search'])->name('admin.transaction.search');
		Route::get('transaction-list/{userId}', [AdminTransactionController::class, 'showByUser'])->name('admin.user.transaction.show');
		Route::get('transaction-search/{userId}', [AdminTransactionController::class, 'searchByUser'])->name('admin.user.transaction.search');


		/* ===== BASIC CONTROL MANAGE BY ADMIN ===== */
		Route::get('settings/{settings?}', [BasicControlController::class, 'index'])->name('settings');

		Route::match(['get', 'post'], 'basic-control', [BasicControlController::class, 'basic_control'])->name('basic.control');
		Route::match(['get', 'post'], 'service-control', [BasicControlController::class, 'serviceControl'])->name('service.control');
		Route::match(['get', 'post'], 'pusher-config', [BasicControlController::class, 'pusherConfig'])->name('pusher.config');
		Route::match(['get', 'post'], 'email-config', [BasicControlController::class, 'emailConfig'])->name('email.config');
		Route::match(['get', 'post'], 'sms-config', [SmsControlController::class, 'smsConfig'])->name('sms.config');

		Route::get('plugin-config', [BasicControlController::class, 'pluginConfig'])->name('plugin.config');
		Route::match(['get', 'post'], 'tawk-config', [BasicControlController::class, 'tawkConfig'])->name('tawk.control');
		Route::match(['get', 'post'], 'fb-messenger-config', [BasicControlController::class, 'fbMessengerConfig'])->name('fb.messenger.control');
		Route::match(['get', 'post'], 'google-recaptcha', [BasicControlController::class, 'googleRecaptchaConfig'])->name('google.recaptcha.control');
		Route::match(['get', 'post'], 'google-analytics', [BasicControlController::class, 'googleAnalyticsConfig'])->name('google.analytics.control');

		/* ===== ADMIN EMAIL-CONFIGURATION SETTINGS ===== */
		Route::get('email-templates', [EmailTemplateController::class, 'index'])->name('email.template.index');
		Route::match(['get', 'post'], 'default-template', [EmailTemplateController::class, 'defaultTemplate'])->name('email.template.default');
		Route::get('email-template/edit/{id}', [EmailTemplateController::class, 'edit'])->name('email.template.edit');
		Route::post('email-template/update/{id}', [EmailTemplateController::class, 'update'])->name('email.template.update');
		Route::post('testEmail', [EmailTemplateController::class, 'testEmail'])->name('testEmail');

		/* ===== ADMIN SMS-CONFIGURATION SETTINGS ===== */
		Route::get('sms-template', [SmsTemplateController::class, 'index'])->name('sms.template.index');
		Route::get('sms-template/edit/{id}', [SmsTemplateController::class, 'edit'])->name('sms.template.edit');
		Route::post('sms-template/update/{id}', [SmsTemplateController::class, 'update'])->name('sms.template.update');

		/* ===== ADMIN NOTIFICATION-CONFIGURATION SETTINGS ===== */
		Route::get('notify-template', [NotifyController::class, 'index'])->name('notify.template.index');
		Route::get('notify-template/edit/{id}', [NotifyController::class, 'edit'])->name('notify.template.edit');
		Route::post('notify-template/update/{id}', [NotifyController::class, 'update'])->name('notify.template.update');


		/* ===== ADMIN LANGUAGE SETTINGS ===== */
		Route::get('languages', [LanguageController::class, 'index'])->name('language.index');
		Route::get('language/create', [LanguageController::class, 'create'])->name('language.create');
		Route::post('language/create', [LanguageController::class, 'store'])->name('language.store');
		Route::get('language/{language}', [LanguageController::class, 'edit'])->name('language.edit');
		Route::put('language/{language}', [LanguageController::class, 'update'])->name('language.update');
		Route::delete('language-delete/{language}', [LanguageController::class, 'destroy'])->name('language.delete');

		Route::get('language-keyword/{language}', [LanguageController::class, 'keywordEdit'])->name('language.keyword.edit');
		Route::put('language-keyword/{language}', [LanguageController::class, 'keywordUpdate'])->name('language.keyword.update');
		Route::post('language-import-json', [LanguageController::class, 'importJson'])->name('language.import.json');
		Route::post('store-key/{language}', [LanguageController::class, 'storeKey'])->name('language.store.key');
		Route::put('update-key/{language}', [LanguageController::class, 'updateKey'])->name('language.update.key');
		Route::delete('delete-key/{language}', [LanguageController::class, 'deleteKey'])->name('language.delete.key');


		/* ===== ADMIN SUPPORT TICKET ===== */
		Route::get('tickets', [AdminTicketController::class, 'tickets'])->name('admin.ticket');
		Route::get('tickets-search', [AdminTicketController::class, 'ticketSearch'])->name('admin.ticket.search');
		Route::get('tickets-view/{id}', [AdminTicketController::class, 'ticketReply'])->name('admin.ticket.view');
		Route::put('ticket-reply/{id}', [AdminTicketController::class, 'ticketReplySend'])->name('admin.ticket.reply');
		Route::get('ticket-download/{ticket}', [AdminTicketController::class, 'ticketDownload'])->name('admin.ticket.download');
		Route::post('ticket-delete', [AdminTicketController::class, 'ticketDelete'])->name('admin.ticket.delete');

		/* ===== ADMIN TEMPLATE SETTINGS ===== */
		Route::get('template/{section}', [TemplateController::class, 'show'])->name('template.show');
		Route::put('template/{section}/{language}', [TemplateController::class, 'update'])->name('template.update');

		Route::get('contents/{content}', [ContentController::class, 'index'])->name('content.index');
		Route::get('content-create/{content}', [ContentController::class, 'create'])->name('content.create');
		Route::put('content-create/{content}/{language?}', [ContentController::class, 'store'])->name('content.store');
		Route::get('content-show/{content}', [ContentController::class, 'show'])->name('content.show');
		Route::put('content-update/{content}/{language?}', [ContentController::class, 'update'])->name('content.update');
		Route::delete('content-delete/{id}', [ContentController::class, 'destroy'])->name('content.delete');

		/* ===== ADMIN BLOG SETTINGS ===== */
		Route::get('blog-category', [BlogController::class, 'categoryList'])->name('blogCategory');
		Route::get('blog-category-create', [BlogController::class, 'blogCategoryCreate'])->name('blogCategoryCreate');
		Route::post('blog-category-store/{language?}', [BlogController::class, 'blogCategoryStore'])->name('blogCategoryStore');
		Route::get('blog-category-edit/{id}', [BlogController::class, 'blogCategoryEdit'])->name('blogCategoryEdit');
		Route::put('/blog-category-update/{id}/{language?}', [BlogController::class, 'blogCategoryUpdate'])->name('blogCategoryUpdate');
		Route::delete('/blog-category-delete/{id}', [BlogController::class, 'blogCategoryDelete'])->name('blogCategoryDelete');

		Route::get('blog-list', [BlogController::class, 'blogList'])->name('blogList');
		Route::get('blog-create', [BlogController::class, 'blogCreate'])->name('blogCreate');
		Route::post('blog-store/{language?}', [BlogController::class, 'blogStore'])->name('blogStore');
		Route::get('blog-edit/{id}', [BlogController::class, 'blogEdit'])->name('blogEdit');
		Route::put('blog-update/{id}/{language?}', [BlogController::class, 'blogUpdate'])->name('blogUpdate');
		Route::delete('blog-delete/{id}', [BlogController::class, 'blogDelete'])->name('blogDelete');

		Route::match(['get', 'post'], 'logo-settings', [HomeController::class, 'logoUpdate'])->name('logo.update');
		Route::match(['get', 'post'], 'breadcrumb-settings', [HomeController::class, 'breadcrumbUpdate'])->name('breadcrumb.update');
		Route::match(['get', 'post'], 'seo-settings', [HomeController::class, 'seoUpdate'])->name('seo.update');

		/* ===== SUBSCRIBER VIEW MANAGE BY ADMIN ===== */
		Route::get('subscriber-list', [SubscribeController::class, 'index'])->name('subscribe.index');
		Route::get('subscriber-search', [SubscribeController::class, 'search'])->name('subscribe.search');
		Route::match(['get', 'post'], 'send-mail-subscriber/{subscribe?}', [SubscribeController::class, 'sendMailSubscribe'])->name('send.mail.subscribe');
	});

	/* PROFILE SHOW UPDATE BY USER */
	Route::match(['get', 'post'], 'profile', [AdminProfileController::class, 'index'])->name('admin.profile');
	Route::match(['get', 'post'], 'change-password', [AdminController::class, 'changePassword'])->name('admin.change.password');


	Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.home');
	Route::post('logout', [LoginController::class, 'logout'])->name('admin.logout');
});

// All Ajax Route Here
Route::post('get-role-user', [BranchController::class, 'getRoleUser'])->name('getRoleUser');
Route::post('get-role-user-info', [BranchController::class, 'getRoleUserInfo'])->name('getRoleUserInfo');
Route::post('oc-get-selected-location-ship-rate', [ShipmentController::class, 'OCGetSelectedLocationShipRate'])->name('OCGetSelectedLocationShipRate');

Route::post('get-package-variant', [PackingController::class, 'getSelectedPackageVariant'])->name('getSelectedPackageVariant');
Route::post('get-variant-service', [PackingController::class, 'getSelectedVariantService'])->name('getSelectedVariantService');

Route::post('get-parcel-type-unit', [ParcelController::class, 'getSelectedParcelTypeUnit'])->name('getSelectedParcelTypeUnit');
Route::post('get-parcel-unit-service', [PackingController::class, 'getSelectedParcelUnitService'])->name('getSelectedParcelUnitService');

Route::post('get-country-state', [LocationController::class, 'getSeletedCountryState'])->name('getSeletedCountryState');
Route::post('get-state-city', [LocationController::class, 'getSeletedStateCity'])->name('getSeletedStateCity');
Route::post('get-city-area', [LocationController::class, 'getSeletedCityArea'])->name('getSeletedCityArea');

Route::post('selected-branch-sender', [ShipmentController::class, 'getSelectedBranchSender'])->name('getSelectedBranchSender');
Route::post('selected-branch-receiver', [ShipmentController::class, 'getSelectedBranchReceiver'])->name('getSelectedBranchReceiver');

Route::group(['prefix' => 'user', 'middleware' => ['auth', 'verifyUser']], function () {

	Route::get('/dashboard', [HomeController::class, 'index'])->name('user.dashboard');
	Route::get('get-transaction-chart', [HomeController::class, 'getTransactionChart'])->name('user.get.transaction.chart');

	/* Transaction List */
	Route::get('transaction-list', [TransactionController::class, 'index'])->name('user.transaction');
	Route::get('transaction-search', [TransactionController::class, 'search'])->name('user.transaction.search');

	Route::get('push-notification-show', [SiteNotificationController::class, 'show'])->name('push.notification.show');
	Route::get('push.notification.readAll', [SiteNotificationController::class, 'readAll'])->name('push.notification.readAll');
	Route::get('push-notification-readAt/{id}', [SiteNotificationController::class, 'readAt'])->name('push.notification.readAt');

	/* PROFILE SHOW UPDATE BY USER */
	Route::get('profile', [UserProfileController::class, 'index'])->name('user.profile');
	Route::post('/updateProfile', [UserProfileController::class, 'updateProfile'])->name('user.updateProfile');
	Route::put('/updateInformation', [UserProfileController::class, 'updateInformation'])->name('user.updateInformation');
	Route::match(['get', 'post'], 'change-password', [UserProfileController::class, 'changePassword'])->name('user.change.password');
	Route::post('/updatePassword', [UserProfileController::class, 'updatePassword'])->name('user.updatePassword');

	Route::post('/verificationSubmit', [UserProfileController::class, 'verificationSubmit'])->name('user.verificationSubmit');
	Route::post('/addressVerification', [UserProfileController::class, 'addressVerification'])->name('user.addressVerification');

	/* PAYMENT REQUEST BY USER */
	Route::get('payout-list', [PayoutController::class, 'index'])->name('payout.index');
	Route::get('payout-search', [PayoutController::class, 'search'])->name('payout.search');
	Route::match(['get', 'post'], 'request-payout', [PayoutController::class, 'payoutRequest'])->name('payout.request');
	Route::post('confirm-payout/flutterwave/{utr}', [PayoutController::class, 'flutterwavePayout'])->name('payout.flutterwave');
	Route::post('confirm-payout/paystack/{utr}', [PayoutController::class, 'paystackPayout'])->name('payout.paystack');
	Route::match(['get', 'post'], 'confirm-payout/{utr}', [PayoutController::class, 'confirmPayout'])->name('payout.confirm');
	Route::get('payout-check-limit', [PayoutController::class, 'checkLimit'])->name('payout.checkLimit');
	Route::post('payout-bank-form', [PayoutController::class, 'getBankForm'])->name('payout.getBankForm');
	Route::post('payout-bank-list', [PayoutController::class, 'getBankList'])->name('payout.getBankList');

	/* ADD MONEY BY USER */
	Route::match(['get', 'post'], 'add-fund', [FundController::class, 'initialize'])->name('fund.initialize');
	Route::get('fund-list', [FundController::class, 'index'])->name('fund.index');
	Route::get('fund-requested', [FundController::class, 'requested'])->name('fund.request');
	Route::get('fund-search', [FundController::class, 'search'])->name('fund.search');

	/* USER SUPPORT TICKET */
	Route::get('tickets', [SupportController::class, 'index'])->name('user.ticket.list');
	Route::get('ticket-create', [SupportController::class, 'create'])->name('user.ticket.create');
	Route::post('ticket-create', [SupportController::class, 'store'])->name('user.ticket.store');
	Route::get('ticket-view/{ticket}', [SupportController::class, 'view'])->name('user.ticket.view');
	Route::put('ticket-reply/{ticket}', [SupportController::class, 'reply'])->name('user.ticket.reply');
	Route::get('ticket-download/{ticket}', [SupportController::class, 'download'])->name('user.ticket.download');

	// money-transfer
	Route::get('/money-transfer', [HomeController::class, 'moneyTransfer'])->name('user.money-transfer');
	Route::post('/send-money', [HomeController::class, 'moneyTransferConfirm'])->name('user.send.money');

	// Manage Shipments By User
	Route::get('shipment-list/{shipment_status}/{shipment_type}', [UserShipmentController::class, 'shipmentList'])->name('user.shipmentList');
	Route::get('view-shipment/{id}', [UserShipmentController::class, 'viewShipment'])->name('user.viewShipment');
	Route::get('{shipment_type}/create-shipment', [UserShipmentController::class, 'createShipment'])->name('user.createShipment');
	Route::post('shipment-store/{type?}', [UserShipmentController::class, 'shipmentStore'])->name('user.shipmentStore');

	Route::delete('delete-shipment/{id}', [UserShipmentController::class, 'deleteShipmentRequest'])->name('user.deleteShipmentRequest');
	Route::put('cancel-shipment-request/{id}', [UserShipmentController::class, 'cancelShipmentRequest'])->name('user.cancelShipmentRequest');

	//Manage Receiver By User
	Route::get('receiverList', [HomeController::class, 'receiverList'])->name('user.receiverList');
	Route::get('receiver/create', [HomeController::class, 'receiverCreate'])->name('user.receiver.create');
	Route::post('receiver/store', [HomeController::class, 'receiverStore'])->name('user.receiver.store');
});

Route::group(['prefix' => 'user'], function () {
	Auth::routes();
	// Payment confirm page
	Route::get('deposit-check-amount', [DepositController::class, 'checkAmount'])->name('deposit.checkAmount');
	Route::get('payment-process/{utr}', [PaymentController::class, 'depositConfirm'])->name('payment.process');
	Route::match(['get', 'post'], 'confirm-deposit/{utr}', [DepositController::class, 'confirmDeposit'])->name('deposit.confirm');
	Route::post('addFundConfirm/{utr}', [PaymentController::class, 'fromSubmit'])->name('addFund.fromSubmit');

	Route::get('check', [VerificationController::class, 'check'])->name('user.check');
	Route::get('resend_code', [VerificationController::class, 'resendCode'])->name('user.resendCode');
	Route::post('mail-verify', [VerificationController::class, 'mailVerify'])->name('user.mailVerify');
	Route::post('sms-verify', [VerificationController::class, 'smsVerify'])->name('user.smsVerify');
	Route::post('twoFA-Verify', [VerificationController::class, 'twoFAverify'])->name('user.twoFA-Verify');
});


// Frontend Route
Route::get('/', [FrontendController::class, 'home'])->name('home');
Route::get('/about', [FrontendController::class, 'about'])->name('about');
Route::get('/service', [FrontendController::class, 'service'])->name('service');
Route::get('/tracking', [FrontendController::class, 'tracking'])->name('tracking');
Route::get('/booking', [FrontendController::class, 'booking'])->name('booking');
Route::get('/booking/sender-details', [FrontendController::class, 'senderDetails'])->name('senderDetails');
Route::get('/booking/shipping-details', [FrontendController::class, 'shippingDetails'])->name('shippingDetails');
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
Route::get('/blog', [FrontendController::class, 'blog'])->name('blog');
Route::get('/blog-details/{slug}/{id}', [FrontendController::class, 'blogDetails'])->name('blogDetails');
Route::get('/category/blog/{slug}/{id}', [FrontendController::class, 'CategoryWiseBlog'])->name('CategoryWiseBlog');
Route::get('/blog/search', [FrontendController::class, 'blogSearch'])->name('blogSearch');
Route::get('/blog-details/{slug}/{id}', [FrontendController::class, 'blogDetails'])->name('blogDetails');
Route::get('/contact', [FrontendController::class, 'contact'])->name('contact');
Route::post('/contact/send', [FrontendController::class, 'contactSend'])->name('contact.send');
Route::post('subscribe', [FrontendController::class, 'subscribe'])->name('subscribe');
Route::get('{content_id}/{getLink}', [FrontendController::class, 'getLink'])->name('getLink');
Route::get('/{template}', [FrontendController::class, 'getTemplate'])->name('getTemplate');
Route::get('/language/{code?}', [FrontendController::class, 'language'])->name('language');



