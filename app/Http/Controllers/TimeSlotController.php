<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\TimeSlot;
use App\Models\newslots;
use App\Models\Availability;
use Illuminate\Http\Request;
use DateInterval;
use DatePeriod;
use Illuminate\Support\Facades\DB;
use Auth;

use App\Mail\UserSchedulingEmail;
use App\Mail\AdminSchedulingEmail;
use App\Mail\canceladmin;
use App\Mail\canceluser;

use Illuminate\Support\Facades\Mail;

class TimeSlotController extends Controller
{
    public function getAvailableTimeSlotsForCurrentDay()
{
    $start = Carbon::now()->startOfDay();
    $end = Carbon::now()->endOfDay();

    $existingSlots = TimeSlot::where('start_time', '>=', $start)
        ->where('end_time', '<=', $end)
        ->get(['start_time', 'end_time', 'status'])
        ->toArray();

    $slots = [];

    $interval = new DateInterval('PT30M');
    $period = new DatePeriod($start, $interval, $end);

    foreach ($period as $dt) {
        $startTime = $dt->format('Y-m-d H:i:s');
        $endTime = $dt->add($interval)->format('Y-m-d H:i:s');

        $slotStatus = false;

        foreach ($existingSlots as $existingSlot) {
            if ($existingSlot['start_time'] == $startTime && $existingSlot['end_time'] == $endTime) {
                $slotStatus = $existingSlot['status'];
            }
        }

        $slots[] = ['start_time' => $startTime, 'end_time' => $endTime, 'status' => $slotStatus];
    }

    return $slots;
}

public function index()
 {
        $times = [
            'start' => '00:00:00',
            'end' => '23:59:59',
        ];

        $startOfDay = Carbon::parse($times['start']);
        $endOfDay = Carbon::parse($times['end']);
        for ($time = $startOfDay; $time < $endOfDay; $time->addMinutes(30)) {
            $endTime = $time->copy()->addMinutes(30);

            foreach (Doctor::all() as $doctor) {
                Availability::firstOrCreate([
                    'starttime' => $time->format('H:i:s'),
                    'endtime' => $endTime->format('H:i:s'),
                    'doctor_id' => $doctor->id,
                ]);
            }
        }

        return response()->json(['message' => 'Slots created for all doctors']);
    }

public function update(Request $request)
{
    $name = $request->input('name');
    $email = $request->input('email');
    $subject = $request->input('subject');
    $slot_id = $request->input('slot_id');
    $date = $request->input('date');
    $user_id = $request->input('user_id');
    $availability = DB::table('slots')
        ->where('id', $slot_id)
        ->first();

                // } catch (\Exception $e) {
                //     // Handle any parsing/formatting errors here
                //     return response()->json(['error' => 'Invalid date format'], 400);
                // }
            
        
        
       
        $booked = new newslots(); 
        
     
        $booked->name = $name;
        $booked->email = $email;
        $booked->subject = $subject;
        $booked->date = $date;
        $booked->user_id = $user_id;
        $booked->slot_id = $slot_id;
        $booked->save();
        $data = Availability::find($slot_id);
        $booked->starttime = $data->starttime;  
        $booked->endtime = $data->endtime;
        // Mail::to($request->email)->send(new UserSchedulingEmail($booked));
        // Mail::to('raohmx@gmail.com')->send(new AdminSchedulingEmail($booked));
    
    // } else {
  
    //     return response()->json(['message' => 'error in else code']);    
      
    

    return response()->json(['message' => 'slot bookked successfully']);
}



// public function update(Request $request)
// {
//     $name = $request->input('name');
//     $day = $request->input('day');
//     $time = $request->input('starttime');
//     $endTime = $request->input('endtime');
//     $user_id = $request->input('user_id');
//     $email = $request->input('email');
//     $subject = $request->input('subject');
//     $availability = DB::table('availabilities')
//         ->where('day', '=', $day)
//         ->where('starttime', '=', $time)
//         ->where('endtime', '=', $endTime)
//         ->first();
//     if (!$availability) {
//         DB::table('availabilities')->insert([
//             'name' => $name,
//             'day' => $day,
//             'starttime' => $time,
//             'endtime' => $endTime,
//             'user_id' => $user_id,
//             'email' => $email,
//             'available' => true,
//         ]);
//         $call = $name/$day/$time;
//         Mail::to($request->email)->send(new UserSchedulingEmail($call));
//         Mail::to('raohmx@gmail.com')->send(new AdminSchedulingEmail($call));
//     } else {
//         DB::table('availabilities')
//             ->where('day', '=', $day)
//             ->where('starttime', '=', $time)
//             ->where('endtime', '=', $endTime)
//             ->update([
//                 'available' => true,
//                 'name' => $name,
//                 'user_id' => $user_id,
//                 'email' => $email,
//             ]);
//             $call = array(
//                 'name' => $name,
//                 'day' => $day,
//                 'starttime' => $time,
//                 'endtime' => $endTime,
//                 'user_id' => $user_id,
//                 'email' => $email,
//             );
//         Mail::to($request->email)->send(new UserSchedulingEmail($call));
//         Mail::to('raohmx@gmail.com')->send(new AdminSchedulingEmail($call));
//     }

//     return response()->json(['message' => 'Availability updated successfully']);
// }


public function all(Request $request, $date)
{
    $data['slots'] = Availability::get(['id','starttime', 'endtime']);
    $inputDate = $date;
              
    // try {
      
        setlocale(LC_TIME, 'it_IT');

// Set the timezone for Carbon
Carbon::setLocale('it');
Carbon::setToStringFormat('d M');

// Map Italian day and month names to English
$italianDays = ['lun', 'mar', 'mer', 'gio', 'ven', 'sab', 'dom'];
$italianMonths = ['gen', 'feb', 'mar', 'apr', 'mag', 'giu', 'lug', 'ago', 'set', 'ott', 'nov', 'dic'];
$englishDays = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
$englishMonths = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

// Separate the day and month from the input string
$parts = explode(' ', $inputDate);
$italianDay = $parts[0];
$italianMonth = $parts[2];

// Convert Italian day and month to English
$englishDay = str_replace($italianDays, $englishDays, $italianDay);
$englishMonth = str_replace($italianMonths, $englishMonths, $italianMonth);

// Replace the day and month in the input date
$inputDate = str_replace($italianDay, $englishDay, $inputDate);
$inputDate = str_replace($italianMonth, $englishMonth, $inputDate);

// Parse the input date using Carbon::parse()
$date = Carbon::parse($inputDate)->startOfDay();
$acceptLanguage = $request->header('Accept-Language');
if (str_contains($acceptLanguage, 'it')) { 
// Format the date with day and month names in English 
$formattedDate = $date->locale('en')->isoFormat('ddd Do MMM');
$date = str_replace(['th', 'st', 'nd', 'rd'], '', $formattedDate);
} else {
    // return response()->json(['message' => 'That slot is not Aavailable']);
  //  Format the date with day and month names in the current locale
  $formattedDate = $date->locale('en')->isoFormat('ddd Do MMM');             
  $date = str_replace(['th', 'st', 'nd', 'rd'], '', $formattedDate);
}
    $data1['booked'] = newslots::where('date', $date)->get(['slot_id','user_id']);

    $mergedData = array_merge($data, $data1);

    return response()->json($mergedData);
}

public function cancel(Request $request)
{
    $slot_id = $request->input('slot_id');
    $user_id = $request->input('user_id');
    $date = $request->input('date');
              
    // Retrieve the booking to be cancelled
    $booking = newslots::where('slot_id', $slot_id)
                        ->where('user_id', $user_id)
                        ->where('date', $date)
                        ->first();

    if ($booking) {
        // Delete the booking from the database
        $booking->delete();

       // Send cancellation confirmation emails to the user and admin
        Mail::to($booking->email)->send(new UserSchedulingEmail($booking));
        Mail::to('raohmx@gmail.com')->send(new AdminSchedulingEmail($booking));

        return response()->json(['message' => 'Booking cancelled successfully']);
    } else {
        return response()->json(['message' => 'Booking not found or you are not authorized to cancel this booking'], 404);
    }
}

// public function cancel(Request $request)
// {
//     $day = $request->input('day');
//     $time = $request->input('starttime');
//     $endTime = $request->input('endtime');
//     $user_id = $request->input('user_id'); 
//     $availability = DB::table('availabilities')
//         ->where('day', '=', $day)
//         ->where('starttime', '=', $time)
//         ->where('endtime', '=', $endTime)
//         ->where('available', '=', true)
//         ->where('user_id', '=', $user_id)
//         ->first();

//         if (!$availability) {
//             return response()->json(['message' => 'not authrized']);
//         } else {
//             DB::table('availabilities')
//             ->where('day', '=', $day)
//             ->where('starttime', '=', $time)
//             ->where('endtime', '=', $endTime)
//             ->update([
//                 'available' => false,
//                 'name' => null,
//                 'user_id' => null,
//             ]);
//         }
//     return response()->json(['message' => 'slot cancel successfully']);
// }

public function getall()
{
    // $bookings = newslots::all()->latest();
    $bookings = newslots::orderBy('created_at','desc')->get();
    return view('pages.schedule', compact('bookings'));
}
public function getbooked(Request $request)
{
    // Get the user ID from the request
    $user_id = $request->input('user_id');

    // Retrieve the bookings for the user
    $bookings = newslots::where('user_id', $user_id)->get();

    // Get the starttime and endtime for each booking
    $bookingData = [];

    foreach ($bookings as $booking) {
        $availability = Availability::find($booking->slot_id);

        $bookingData[] = [
            'id' => $booking->id,
            'date' => $booking->date,
            'user_id' => $booking->user_id,
            'name' => $booking->name,
            'email' => $booking->email,
            'subject' => $booking->subject,
            'slot_id' => $booking->slot_id,
            'starttime' => $availability->starttime,
            'endtime' => $availability->endtime,
            'created_at' => $booking->created_at,
            'updated_at' => $booking->updated_at
        ];
    }

    return response()->json($bookingData);
}
public function destroy($id)
{
   
    $booking = newslots::find($id);

    if (!$booking) {
        return redirect()->route('schedule_calls')->with('error','Id not found');
    }
    Mail::to($booking->email)->send(new canceluser($booking));
    Mail::to('raohmx@gmail.com')->send(new canceladmin($booking));
        $booking->delete();
        return redirect()->route('schedule_calls')->with('success', 'Appointment Cancel Successfully');
    
}
function allslots() {
    $slots= Availability::all();
    return response()->json($slots);
}

}


