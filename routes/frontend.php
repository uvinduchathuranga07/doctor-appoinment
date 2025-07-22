<?php

use App\Http\Controllers\Frontend\FrontendAuthController;
use App\Http\Controllers\Frontend\FrontEndCustomerController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\InquiryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\CustomHelpers;
use App\Services\ApiClient\ApiClient;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
|
| Here is where you can register frontend routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "frontend" middleware group. Now create something great!
|
*/

Route::get('oauth/{driver}', [FrontendAuthController::class, 'redirectToProvider'])->name('social.oauth');
Route::post('oauth/{driver}', [FrontendAuthController::class, 'redirectToProvider'])->name('social.oauth');
Route::get('oauth/{driver}/callback', [FrontendAuthController::class, 'handleProviderCallback'])->name('social.callback');

  Route::get('/', [HomeController::class, 'maintain'])->name('maintain');
  Route::get('/home', [HomeController::class, 'index'])->name('index');



  Route::get('/forgot-password', [PageController::class, 'forgotpassword'])->name('forgotpassword');
  Route::post('/forgot-password', [FrontendAuthController::class, 'forgotPasswordSubmit'])->name('forgotpassword.submit');
  // Route::get('forget-password-link/{token}', [FrontendAuthController::class, 'forgotpassword'])->name('forget-password-link');
  Route::get('/reset-password/{token}', [PageController::class, 'NewPassword'])->name('forget-password-link');
  Route::post('/reset-password', [FrontendAuthController::class, 'newPassword'])->name('forget-password-link.store');
  Route::post('/register', [FrontendAuthController::class, 'makeRegister'])->name('front.end.customer.store');
  Route::post('/login', [FrontendAuthController::class, 'makeLogin'])->name('front.end.customer.login');
  Route::get('/logout', [FrontendAuthController::class, 'makeLogout'])->name('front.end.customer.logout');

  // Route::get('/getdata', [HomeController::class, 'getdata'])->name('index.getdata');
  // Route::post('/enroll-to-affiliate', [FrontendAuthController::class, 'enrollToAffiliate'])->name('frontend.enroll-affiliate');
  // Route::post('/submit-inquiry', [InquiryController::class, 'submit'])->name('submit-inquiry');
  // Route::get('/app-download', [PageController::class, 'AppDownload'])->name('appdownload');

  Route::get('test-email', function() {
    return view('emails.inquiry-submit', ['inquiry' => \App\Models\Inquiry::find(1)]);
  });

