<?php

use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BackendAuthController;
use App\Http\Controllers\BackendUserController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FrontendUserController;
use App\Http\Controllers\HomebannerController;
use App\Http\Controllers\InquiryController;
use App\Http\Controllers\MediaLibraryController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PrescriptionController;
use App\Http\Controllers\DoctorScheduleController;
use App\Http\Controllers\SpecializationController;
use App\Http\Controllers\CampaignController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AppointmentController;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum', 'verified', 'web']], function () {
    Route::get('/two-step-verification', [BackendAuthController::class, 'twoStepRequest'])->name('2fa.request');
    Route::post('/two-step-verification', [BackendAuthController::class, 'twoStepVerify'])->name('2fa.verify');
    Route::get('/activate', [BackendAuthController::class, 'activateProfileView'])->name('profile.activate.request');
    Route::post('/activate', [BackendAuthController::class, 'activateProfile'])->name('profile.activate');
});


Route::group(['middleware' => ['auth:sanctum', 'verified', 'web']], function () {

    Route::get('/', function () {
        return redirect('/admin/dashboard');
    });
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Inquiry
    Route::prefix('inquiry')->group(function () {
        Route::get('/', [InquiryController::class, 'index'])->middleware(['can:inquiry.view'])->name('inquiry.index');
        Route::get('/get/data', [InquiryController::class, 'getData'])->middleware(['can:inquiry.view'])->name('inquiry.getdata');
        Route::get('/edit/{id}', [InquiryController::class, 'edit'])->middleware(['can:inquiry.edit'])->name('inquiry.edit');
        Route::post('/', [InquiryController::class, 'update'])->middleware(['can:inquiry.edit'])->name('inquiry.update');
        Route::post('/delete', [InquiryController::class, 'destroy'])->middleware(['can:inquiry.delete'])->name('inquiry.delete');
    });

    Route::prefix('doctor')->group(function () {
        Route::get('/', [DoctorController::class, 'index'])->middleware(['can:doctor.view'])->name('doctor.index');
        Route::get('/create', [DoctorController::class, 'create'])->middleware(['can:doctor.create'])->name('doctor.create');
        Route::get('/edit/{id}', [DoctorController::class, 'edit'])->middleware(['can:doctor.edit'])->name('doctor.edit');
        Route::post('/store', [DoctorController::class, 'store'])->middleware(['can:doctor.create'])->name('doctor.store');
        Route::post('/update', [DoctorController::class, 'update'])->middleware(['can:doctor.edit'])->name('doctor.update');
        Route::get('/getdata', [DoctorController::class, 'getData'])->middleware(['can:doctor.view'])->name('doctor.getdata');
        Route::post('/doctor/delete', [DoctorController::class, 'destroy'])->name('doctor.delete')->middleware(['can:doctor.delete']);

    });

    Route::prefix('specialization')->group(function () {
    Route::get('/', [SpecializationController::class, 'index'])->middleware(['can:specialization.view'])->name('specialization.index');
    Route::get('/create', [SpecializationController::class, 'create'])->middleware(['can:specialization.create'])->name('specialization.create');
    Route::get('/edit/{id}', [SpecializationController::class, 'edit'])->middleware(['can:specialization.edit'])->name('specialization.edit');
    Route::post('/store', [SpecializationController::class, 'store'])->middleware(['can:specialization.create'])->name('specialization.store');
    Route::post('/update', [SpecializationController::class, 'update'])->middleware(['can:specialization.edit'])->name('specialization.update');
    Route::get('/getdata', [SpecializationController::class, 'getData'])->middleware(['can:specialization.view'])->name('specialization.getdata');
    Route::delete('/destroy', [SpecializationController::class, 'destroy'])->middleware(['can:specialization.delete'])->name('specialization.destroy');
});
    Route::prefix('product')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->middleware(['can:product.view'])->name('product.index');
    Route::get('/getdata', [ProductController::class, 'getData'])->middleware(['can:product.view'])->name('product.getdata');
    Route::get('/create', [ProductController::class, 'create'])->middleware(['can:product.create'])->name('product.create');
    Route::post('/store', [ProductController::class, 'store'])->middleware(['can:product.create'])->name('product.store');
    Route::get('/edit/{id}', [ProductController::class, 'edit'])->middleware(['can:product.edit'])->name('product.edit');
    Route::post('/update', [ProductController::class, 'update'])->middleware(['can:product.edit'])->name('product.update');
    Route::post('/delete', [ProductController::class, 'destroy'])->middleware(['can:product.delete'])->name('product.delete');
});
   Route::prefix('doctor-schedule')->group(function () {
    Route::get('/', [DoctorScheduleController::class, 'index'])->middleware(['can:doctorshedule.view'])->name('doctor-schedule.index');
    Route::get('/getdata', [DoctorScheduleController::class, 'getData'])->middleware(['can:doctorshedule.view'])->name('doctor-schedule.getdata');
    Route::get('/create', [DoctorScheduleController::class, 'create'])->middleware(['can:doctorshedule.create'])->name('doctor-schedule.create');
    Route::get('/edit/{id}', [DoctorScheduleController::class, 'edit'])->middleware(['can:doctorshedule.edit'])->name('doctor-schedule.edit');
    Route::post('/store', [DoctorScheduleController::class, 'store'])->middleware(['can:doctorshedule.create'])->name('doctor-schedule.store');
    Route::post('/update', [DoctorScheduleController::class, 'update'])->middleware(['can:doctorshedule.edit'])->name('doctor-schedule.update');
    });

    Route::prefix('pharmacy')->group(function () {
    Route::get('/', [PharmacyController::class, 'index'])->name('pharmacy.index')->middleware(['can:pharmacy.view']);
    Route::get('/getdata', [PharmacyController::class, 'getData'])->name('pharmacy.getdata')->middleware(['can:pharmacy.view']);
    Route::get('/view/{id}', action: [PharmacyController::class, 'view'])->name('pharmacy.view')->middleware(['can:pharmacy.view']);
    Route::post('/pharmacy/order-status/{id}', [PharmacyController::class, 'statusUpdate'])->name('pharmacy.status.update')->middleware(['can:pharmacy.view']);

});

Route::prefix(' ')->group(function () {
    Route::get('/', [PrescriptionController::class, 'index'])->middleware(['can:prescription.view'])->name('prescription.index');
    Route::get('/show/{id}', [PrescriptionController::class, 'show'])->middleware(['can:prescription.view'])->name('prescription.show');
    Route::get('/getdata', [PrescriptionController::class, 'getData'])->middleware(['can:prescription.view'])->name('prescription.getdata');
    Route::get('/{appointmentId}/create', [PrescriptionController::class, 'create'])->middleware(['can:prescription.create'])->name('prescription.create');
    Route::get('/{appointmentId}/edit/{id}', [PrescriptionController::class, 'edit'])->middleware(['can:prescription.edit'])->name('prescription.edit');
    Route::post('/store', [PrescriptionController::class, 'store'])->middleware(['can:prescription.create'])->name('prescription.store');
    Route::post('/update', [PrescriptionController::class, 'update'])->middleware(['can:prescription.edit'])->name('prescription.update');
});

Route::prefix('order')->group(function () {
   Route::post('/send', [OrderController::class, 'send'])->name('order.send')->middleware(['can:order.create']);
});


Route::get('appointments/book',    [AppointmentController::class, 'index'])->name('appointments.book')->middleware(['can:appointments.view']);
Route::post('appointments/store',  [AppointmentController::class, 'store'])->name('appointments.store')->middleware(['can:appointments.create']);
Route::get('appointments/slots/{doctorId}', [AppointmentController::class, 'getAvailableSlots'])->name('appointments.getAvailableSlots')->middleware(['can:appointments.create']);
Route::get('appointments',         [AppointmentController::class, 'list'])->name('appointments.list')->middleware(['can:appointments.view']);
Route::get('appointments/data',    [AppointmentController::class, 'getData'])->name('appointments.getdata')->middleware(['can:appointments.view']);



Route::prefix('campaign')->group(function () {
    Route::get('/', [CampaignController::class, 'index'])->middleware(['can:campaign.view'])->name('campaign.index');
    Route::get('/getdata', [CampaignController::class, 'getData'])->middleware(['can:campaign.view'])->name('campaign.getdata');
    Route::get('/create', [CampaignController::class, 'create'])->middleware(['can:campaign.create'])->name('campaign.create');
    Route::get('/edit/{id}', [CampaignController::class, 'edit'])->middleware(['can:campaign.edit'])->name('campaign.edit');
    Route::post('/store', [CampaignController::class, 'store'])->middleware(['can:campaign.create'])->name('campaign.store');
    Route::post('/update', [CampaignController::class, 'update'])->middleware(['can:campaign.edit'])->name('campaign.update');
    Route::delete('/destroy', [CampaignController::class, 'destroy'])->middleware(['can:campaign.delete']) ->name('campaign.destroy');
});

    Route::prefix('customer')->group(function () {
        Route::get('/customer', [CustomerController::class, 'index'])->middleware(['can:customer.view'])->name('customer.index');
        Route::get('/get/data', [CustomerController::class, 'getData'])->middleware(['can:customer.view'])->name('customer.getdata');
        Route::get('/create', [CustomerController::class, 'create'])->middleware(['can:customer.create'])->name('customer.create');
        Route::post('/store', [CustomerController::class, 'store'])->middleware(['can:customer.create'])->name('customer.store');
        Route::put('/update/status', [CustomerController::class, 'updateStatus'])->middleware(['can:customer.edit'])->name('customer.change.status');
        Route::get('/edit/{id}', [CustomerController::class, 'edit'])->middleware(['can:customer.edit'])->name('customer.edit');
        Route::post('/update', [CustomerController::class, 'update'])->middleware(['can:customer.edit'])->name('customer.update');
        Route::post('/delete', [CustomerController::class, 'destroy'])->middleware(['can:customer.delete'])->name('customer.delete');
        Route::get('/affilate-customer/{id}', [CustomerController::class, 'affiliateIndex'])->middleware(['can:customer.view'])->name('affilate-customer.view');
        Route::get('/affilate-customer/get/data/{id}', [CustomerController::class, 'affiliateCustomerGetData'])->middleware(['can:customer.view'])->name('affilate-customer.getData');
        Route::post('/affiliate-enroll/{id}', [CustomerController::class, 'confirmAffiliateRequest'])->middleware(['can:customer.view'])->name('affilate-customer.enroll');
    });

    Route::prefix('profile')->group(function () {
        Route::get('/', [BackendAuthController::class, 'showProfile'])->name('admin.profile');
        Route::put('/update-user-photo', [BackendAuthController::class, 'uploadProfilePhoto'])->middleware(['can:profile.updatePhoto'])->name('profile.update-photo');
        Route::put('/update-user-info', [BackendAuthController::class, 'updateUserInfo'])->middleware(['can:profile.updateInfo'])->name('profile.update-info');
        Route::put('/change-password', [BackendAuthController::class, 'changePassword'])->middleware(['can:profile.updatePassword'])->name('profile.update-password');
        Route::post('/disable', [BackendAuthController::class, 'disableProfile'])->middleware(['can:profile.deactivate'])->name('profile.disable');
        Route::post('/delete', [BackendAuthController::class, 'deleteProfile'])->middleware(['can:profile.delete'])->name('profile.delete');
    });

    Route::prefix('settings')->group(function () {
        Route::get('/general', [SettingsController::class, 'generalSettings'])->middleware(['can:settings.view'])->name('settings.general');
        Route::post('/general', [SettingsController::class, 'generalSettingsUpdate'])->middleware(['can:settings.edit'])->name('settings.general.update');
        Route::get('/mail', [SettingsController::class, 'mailSettings'])->middleware(['can:settings.view'])->name('settings.mail');
        Route::post('/mail', [SettingsController::class, 'mailSettingsUpdate'])->middleware(['can:settings.edit'])->name('settings.mail.update');
        Route::get('/social-auth', [SettingsController::class, 'socialAuthSettings'])->middleware(['can:settings.view'])->name('settings.social-auth');
        Route::post('/social-auth', [SettingsController::class, 'socialAuthSettingsUpdate'])->middleware(['can:settings.edit'])->name('settings.social-auth.update');
        Route::get('/content-pages/{id}', [SettingsController::class, 'socialAuthSettings'])->middleware(['can:settings.view'])->name('settings.content-pages.edit');
        Route::post('/content-pages', [SettingsController::class, 'socialAuthSettingsUpdate'])->middleware(['can:settings.edit'])->name('settings.content-pages.update');
        Route::get('/affiliate-pages', [SettingsController::class, 'affiliateSettings'])->middleware(['can:settings.view'])->name('settings.affiliate-pages');
        Route::post('/affiliate-pages/update', [SettingsController::class, 'affiliateSettingsUpdate'])->middleware(['can:settings.edit'])->name('settings.affiliate-pages.update');
    });
    // media library
    Route::prefix('media-library')->group(function () {
        Route::get('/', [MediaLibraryController::class, 'index'])->middleware(['can:media.view'])->name('media.index');
        Route::post('/upload', [MediaLibraryController::class, 'upload'])->middleware(['can:media.create'])->name('media.upload');
        Route::get('/download/{id}', [MediaLibraryController::class, 'download'])->middleware(['can:media.edit'])->name('media.download');
        Route::post('/delete', [MediaLibraryController::class, 'delete'])->middleware(['can:media.delete'])->name('media.delete');
    });
    // rolses & permissions
    Route::prefix('roles')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->middleware(['can:roles-permissions.view'])->name('settings.roles');
        Route::get('/getdata', [RoleController::class, 'getdata'])->middleware(['can:roles-permissions.view'])->name('settings.roles.getdata');
        Route::get('/create', [RoleController::class, 'create'])->middleware(['can:roles-permissions.create'])->name('settings.roles.create');
        Route::post('/store', [RoleController::class, 'store'])->middleware(['can:roles-permissions.create'])->name('settings.roles.store');
        Route::get('/edit/{id}', [RoleController::class, 'edit'])->middleware(['can:roles-permissions.edit'])->name('settings.roles.edit');
        Route::post('/update', [RoleController::class, 'update'])->middleware(['can:roles-permissions.edit'])->name('settings.roles.update');
        Route::get('/permissions/{id}', [RoleController::class, 'editPermissions'])->middleware(['can:roles-permissions.edit'])->name('settings.roles.permissions');
        Route::post('/permissions/update', [RoleController::class, 'updatePermissions'])->middleware(['can:roles-permissions.edit'])->name('settings.roles.permissions.update');
        Route::post('/delete', [RoleController::class, 'destroy'])->middleware(['can:roles-permissions.delete'])->name('settings.roles.delete');
    });
    Route::prefix('employee')->group(function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('employee.index');
        Route::get('/getdata', [EmployeeController::class, 'getData'])->name('employee.getdata');
        Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
        Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
        Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
        Route::post('/update', [EmployeeController::class, 'update'])->name('employee.update');
    });

    // backend users
    Route::prefix('backend-users')->group(function () {
        Route::get('/', [BackendUserController::class, 'index'])->middleware(['can:backend-user.view'])->name('settings.users');
        Route::get('/get/data', [BackendUserController::class, 'getData'])->middleware(['can:backend-user.view'])->name('settings.users.getdata');
        Route::get('/create', [BackendUserController::class, 'create'])->middleware(['can:backend-user.create'])->name('settings.users.create');
        Route::post('/store', [BackendUserController::class, 'store'])->middleware(['can:backend-user.create'])->name('settings.users.store');
        Route::get('/edit/{id}', [BackendUserController::class, 'edit'])->middleware(['can:backend-user.edit'])->name('settings.users.edit');
        Route::post('/update', [BackendUserController::class, 'update'])->middleware(['can:backend-user.edit'])->name('settings.users.update');
        Route::put('/update/status', [BackendUserController::class, 'updateStatus'])->middleware(['can:backend-user.edit'])->name('settings.users.change.status');
        Route::put('/update/password', [BackendUserController::class, 'updatePassword'])->middleware(['can:backend-user.edit'])->name('settings.users.change.password');
        Route::post('/suspend', [BackendUserController::class, 'softDelete'])->middleware(['can:backend-user.delete'])->name('settings.users.delete');
        Route::post('/restore', [BackendUserController::class, 'restore'])->middleware(['can:backend-user.delete'])->name('settings.users.restore');
        Route::post('/delete', [BackendUserController::class, 'delete'])->middleware(['can:backend-user.delete'])->name('settings.users.remove');
    });
    // frontend users
    Route::prefix('front-users')->group(function () {
        Route::get('/', [FrontendUserController::class, 'index'])->middleware(['can:frontend-user.view'])->name('settings.front-user');
        Route::get('/get/data', [FrontendUserController::class, 'getData'])->middleware(['can:frontend-user.view'])->name('settings.front-user.getdata');
        Route::get('/create', [FrontendUserController::class, 'create'])->middleware(['can:frontend-user.create'])->name('settings.front-user.create');
        Route::post('/store', [FrontendUserController::class, 'store'])->middleware(['can:frontend-user.create'])->name('settings.front-user.store');
        Route::get('/edit/{id}', [FrontendUserController::class, 'edit'])->middleware(['can:frontend-user.edit'])->name('settings.front-user.edit');
        Route::post('/update', [FrontendUserController::class, 'update'])->middleware(['can:frontend-user.edit'])->name('settings.front-user.update');
        Route::put('/update/status', [FrontendUserController::class, 'updateStatus'])->middleware(['can:frontend-user.edit'])->name('settings.front-user.change.status');
        Route::put('/update/password', [FrontendUserController::class, 'updatePassword'])->middleware(['can:frontend-user.edit'])->name('settings.front-user.change.password');
        Route::post('/delete', [FrontendUserController::class, 'destroy'])->middleware(['can:frontend-user.delete'])->name('settings.front-user.delete');
    });
});
