<?php

use App\Http\Controllers\CustomerTicketController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

// Home Routes
Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/', [HomeController::class, 'index']);
Route::post('/filterFleet/{filter}', [HomeController::class, 'filterFleet']);
Route::get('/getSubmitStatus', [HomeController:: class, 'getSubmitStatus']);
Route::match(['get', 'post'], '/reachout', [CustomerTicketController::class, 'store']);

// Rent Routes
Route::prefix('rent')->middleware(['auth', 'verified'])->group(function () {
    Route::redirect('/', url()->previous());
    Route::get('/schedule', [RentController::class, 'chooseSchedule'])->name('rent-schedule');
    Route::post('/set-schedule', [RentController::class, 'setSchedule']);
    Route::get('/vehicles', [RentController::class, 'chooseVehicle'])->name('rent-vehicle');
    Route::get('/vehicles/{model}', [RentController::class, 'viewVehicle']);
    Route::post('/set-vehicle/{model}', [RentController::class, 'setVehicleModel']);
    Route::get('/check-vehicle/{model}', [RentController::class, 'checkVehicle']);
    Route::get('/filterVehicle', [RentController::class, 'filterVehicle']);
    Route::get('/form', [RentController::class, 'contactForm'])->name('rent-detail');
    Route::post('/store', [RentController::class, 'store']);
    Route::post('/cancel/{id}', [RentController::class, 'cancel']);
});

// Payment Routes
Route::prefix('payment')->group(function() {
    Route::get('create/{rent_number}', [PaymentController::class, 'create'])->name('rent-payment');
    Route::post('store/{rent_number}', [PaymentController::class, 'store']);
    Route::get('{rent_number}', [PaymentController::class, 'showInvoice'])->name('payment.show');
});

// User Routes
Route::prefix('user')->middleware('auth')->group(function() {
    Route::get('/profile', [UserController::class, 'show'])->name('user.profile');
    Route::post('/profile/edit', [UserController::class, 'edit'])->name('user.profile.edit');
    Route::post('/changePassword', [UserController::class, 'changePass'])->name('user.changePass');
    Route::delete('/deleteAccount', [UserController::class, 'deleteAccount'])->name('delete.account');
    Route::get('/booking/{rent_number}', [UserController::class, 'bookingDetail'])->name('booking.detail');
    Route::get('/booking', [UserController::class, 'showBookings'])->name('user.bookings');
    Route::post('/filterBooking', [UserController::class, 'filterBookings'])->name('filter.booking');
});

// Login & Register Routes
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::get('/admin/login', [LoginController::class, 'loginAdmin'])->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/register', [RegisterController::class, 'index'])->middleware('guest')->name('register');
Route::post('/register', [RegisterController::class, 'store']);

// Forgot Password Routes
Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordForm'])->middleware('guest')->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLink'])->middleware('guest')->name('password.email');
Route::get('/reset-password/{token}', [ForgotPasswordController::class, 'resetPasswordForm'])->middleware('guest')->name('password.reset');
Route::post('/reset-password', [ForgotPasswordController::class, 'resetPassword'])->middleware('guest')->name('password.update');

// Email Verification
Route::get('/email/verify', function () {
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
 
    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
 
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// Admin Routes
Route::prefix('admin')->group(function() {
    Route::get('/', [DashboardController::class, 'index']);
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/monthly_revenue', [DashboardController::class, 'getMonthlyRevenue']);
    Route::get('/monthly_rents', [DashboardController::class, 'getMonthlyRent']);
});
