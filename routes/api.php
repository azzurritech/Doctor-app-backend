<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VideoCallController;
use App\Http\Controllers\TimeSlotController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\AuthController;





// use App\Http\Controllers\CheckboxController;



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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
   
});


Route::post('/login', [AuthController::class,'login']);
Route::post('/register', [AuthController::class,'register']);



Route::post('/get_call/{user_id}', [VideoCallController::class,'joinCall']);
Route::post('/end_call/{user_id}', [VideoCallController::class,'endCall']);
Route::post('/schedule_call/{user_id}', [VideoCallController::class,'scheduleCall']);

Route::get('/schedule/{user_id}',[VideoCallController::class,'index']);

Route::get('/makingslots', [TimeSlotController::class, 'index']);
Route::post('/booked', [TimeSlotController::class, 'update']);
Route::get('/slots/{date}', [TimeSlotController::class, 'all']);
Route::get('/getbooked', [TimeSlotController::class, 'getbooked']);

Route::post('/cancel', [TimeSlotController::class, 'cancel']);
Route::get('/allslots', [TimeSlotController::class, 'allslots']);

Route::get('/status', [App\Http\Controllers\CheckboxController::class, 'index']);

Route::get('/doctors',[DoctorController::class, 'getall']);        


    // Route::get('google', 'AuthController@redirectToGoogle');
Route::get('/google', [AuthController::class, 'redirectToGoogle']);

    // Route::get('google/callback', 'AuthController@handleGoogleCallback');
Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback']);

    
    // Route::get('facebook', 'AuthController@redirectToFacebook');
    Route::get('/facebook', [AuthController::class, 'redirectToFacebook']);
    // Route::get('facebook/callback', 'AuthController@handleFacebookCallback');
Route::get('/facebook/callback', [AuthController::class, 'handleFacebookCallback']);




