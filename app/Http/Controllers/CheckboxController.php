<?php

namespace App\Http\Controllers;
use App\Models\Checkbox;
use Illuminate\Http\Request;
use session;
class CheckboxController extends Controller
{
    public function index()
    {
        $checkbox = Checkbox::latest()->first();
        return  response()->json([
            'data' => $checkbox,
        ]);
    }

    public function store(Request $request){
    
        $checkbox = new Checkbox();
        $checkbox->value = $request->value;

        $checkbox->save();
       session(['status' => $checkbox]);
       
        return Redirect::back()->with(['message' => 'Checkbox value stored successfully']);
    }
    public function updateStatus(Request $request)
    {}
}