<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\SendEmailController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Mail;
 use App\Mail\NotifyMail;
 use App\Mail\canceladmin;
use App\Mail\canceluser;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('layouts.app');
// });

Route::get('/login', function () {
    return view('auth.login');
})->name('homepage');


Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        return view('layouts.app');});
        Route::get('/', function () {
            return view('pages.home');
        })->name('dashboard');


        Route::get('/sc', function () {
            return view('pages.schedulenew');
        })->name('schedule');
        
        Route::get('/video', [VideoCallController::class, 'get_token'])->name('video');
        Route::get('/schedule_calls',[TimeSlotController::class, 'getall'])->name('schedule_calls');
        Route::get('/delete/{id}',[TimeSlotController::class, 'destroy'])->name('delete-calls');
        
        Route::get('/checkbox', [App\Http\Controllers\CheckboxController::class, 'index'])->middleware(['auth'])->name('checkbox.index');
        Route::post('/store-checkbox', [App\Http\Controllers\CheckboxController::class, 'store'])->name('checkbox.store');
        
        Route::post('/update-status', [App\Http\Controllers\CheckboxController::class, 'store'])->name('update-status');
        
        
  
        
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        Route::get('/add', function () { return view('pages.doctors.create');});
        
        Route::get('/doctors',[DoctorController::class, 'index'])->name('doctors');        
        Route::post('/storedoctors',[DoctorController::class, 'store'])->name('doctors.store');
        Route::get('/edit/{id}',[DoctorController::class,'edit'])->name('doctors.edit');
        Route::post('/update/{id}', [DoctorController::class, 'update'])->name('doctors.update');
        Route::get('/delete/{id}', [DoctorController::class, 'destroy'])->name('doctors.destroy');
        
});

Route::get('/google', [AuthController::class, 'redirectToGoogle']);

    // Route::get('google/callback', 'AuthController@handleGoogleCallback');
Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);
Route::get('/facebook', [AuthController::class, 'redirectToFacebook']);
// Route::get('facebook/callback', 'AuthController@handleFacebookCallback');
Route::get('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);

Route::get('/privacy', function () {
    return view('pages.privasy');
});