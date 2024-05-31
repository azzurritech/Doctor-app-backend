<?php

namespace App\Http\Controllers;

use Artisan;
use DateTime;
use stdClass;
use DB;
use Carbon\Carbon;
use DateTimeZone;
use GuzzleHttp\Client;
use App\Models\Call;
use Illuminate\Http\Request;
use App\Components\Services\VideoTokenGenerate;
use App\Mail\UserSchedulingEmail;
use App\Mail\AdminSchedulingEmail;

use Illuminate\Support\Facades\Mail;

class VideoCallController extends Controller
{
    public function __construct()
    {
        $this->appId = '6c066cba675c4bc6ba6ed43f51b7ccc7';
        $this->appCertificate = 'c2ba2eca4e9a4dddb2bc5f0e09f02e01';

        $expireTimeInSeconds = 3600;
        $currentTimestamp = (new DateTime("now", new DateTimeZone('UTC')))->getTimestamp();
        $this->privilegeExpiredTs = $currentTimestamp + $expireTimeInSeconds;
        $this->channelName = 'pharmacy_app';
    }

    public function get_token(Request $request)
    {
        $uid = 21;
        $rtcRole = 1;
        $rtcToken = VideoTokenGenerate::generate($this->appId, $this->appCertificate, $this->channelName, $uid, $rtcRole,$this->privilegeExpiredTs);
        putenv("CALL_TOKEN=$rtcToken");
         // Reload the environment variables
        // Artisan::call('config:clear');
        // Artisan::call('config:cache');
        return view('pages.VideoCallPage');
    }

    public function joinCall(Request $request)
    {
        $userId = $request->input('user_id');

        // Check if user is already associated with a call
        $existingCall = Call::where(function ($query) {
                $query->whereNull('call_end_time')
                    ->orWhere('call_end_time', '>', now());
            })
            ->first();

        if ($existingCall) {
            return response()->json([
                'message' => 'Another user is already on the call',
                'schedule_url' => 'https://example.com/schedule-call',
            ]);
        }
        $rtcRole = 1;
            $token = VideoTokenGenerate::generate($this->appId, 
            $this->appCertificate, $this->channelName, $userId,
             $rtcRole,$this->privilegeExpiredTs);
            putenv("CALL_TOKEN=$token");
        // Store call start time in calls table
        $call = new Call();
        $call->user_id = $userId;
        $call->token = $token;
        $call->call_start_time = now();
        $call->call_end_time = $call->call_start_time->addMinutes(30);
        $call->save();
        
        return response()->json([
            'message' => 'Call joined successfully',
            'token' => $token,
        ],200);
    }

    public function endCall(Request $request)
{
    $userId = $request->input('user_id');

    // Check if user is associated with a call in progress
    $existingCall = Call::where('user_id', $userId)
        ->where(function ($query) {
            $query->whereNull('call_end_time')
                ->orWhere('call_end_time', '>', now());
        })
        ->first();

    if (!$existingCall) {
        return response()->json([
            'message' => 'No call in progress for the user',
        ]);
    }

    // Update call end time in calls table
    $existingCall->call_end_time = now();
    $existingCall->save();

    return response()->json([
        'message' => 'Call ended successfully',
    ]);
}

public function scheduleCall(Request $request)
{
    $userId = $request->input('user_id');
    
    $lastCallEndTime = Call::whereNotNull('call_end_time')
    ->orWhereNotNull('scheduled_call_end_time')
    ->orderBy(DB::raw('GREATEST(IFNULL(call_end_time, "1970-01-01 00:00:00"), IFNULL(scheduled_call_end_time, "1970-01-01 00:00:00"))'), 'desc')
    ->selectRaw('GREATEST(IFNULL(call_end_time, "1970-01-01 00:00:00"), IFNULL(scheduled_call_end_time, "1970-01-01 00:00:00")) as max_time')
    ->value('max_time');

    

    // Calculate the earliest time for scheduling the next call
    if ($lastCallEndTime) {
        $earliestScheduleTime = Carbon::parse($lastCallEndTime)->addMinutes(5);
    } else {
        $earliestScheduleTime = now();
    }
   
   
    // Get the input scheduled time from the request
    $scheduledTime = $request->input('scheduled_time');
    
    // Check if the scheduled time is after the earliest schedule time
    if (Carbon::parse($scheduledTime)->lt($earliestScheduleTime)) {
        return response()->json([
            'message' => 'You can only schedule a call after the end time of the last call or after 30 minutes',
        ], 400);
    }

    // Use the earliest schedule time if the user wants to schedule the call on the earliest possible time
    if ($request->input('earliest_schedule')) {
        $scheduledTime = $earliestScheduleTime;
    }
    
    // Store the call in the database
    $call = new Call();
    $call->user_id = $userId;
    $call->email = $request->email;
    $call->scheduled_time = Carbon::parse($scheduledTime);
    $call->scheduled_call_end_time =Carbon::parse($scheduledTime)->addMinutes(30);
    $call->save();
   
    Mail::to($request->email)->send(new UserSchedulingEmail($call));
    Mail::to('raohmx@gmail.com')->send(new AdminSchedulingEmail($call));


    return response()->json([
        'message' => 'Call scheduled successfully',
        'scheduled_time' => Carbon::parse($scheduledTime)->toIso8601String(),
    ]);
}

public function index($user_id)
{
    $data = Call::where('user_id', $user_id)->first();
    return response()->json([
        'message' => 'data fetch successfully',
        'data' => $data,
    ],200);
}
}