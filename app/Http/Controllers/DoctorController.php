<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Redirect;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::all();
        return view('pages.doctors.index' , compact('doctors'));
    }
    //for api
    public function getall()
    {
        $doctors = Doctor::all();
        return response()->json($doctors);
    }

    public function create()
    {
        return view('doctor.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
             'name' => 'required',
             'speciality' => 'required',
             'address' => 'required',
             'image' => 'required|image',
             'experience' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        $data = $request->all(); // Initialize $data with all the input data
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $ext = $file->getClientOriginalExtension(); // Get the extension
            $filename = time() . '.' . $ext;
            $file->move('assets/doctorImages/', $filename);
            $data['image'] = $filename; // Add the 'image' field to the $data array


            // $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            // $request->image->move(public_path('assets/doctorImages'), $imageName);
            // $data['image'] = $imageName; // Add the 'image' field to the $data array
        }
    
        $doctors = new Doctor($data); // Create a new Doctor instance with the $data array
        $doctors->save();
    
        return redirect()->route('doctors')->with('success', 'Doctor saved!');
    }

    public function edit($id)
    {
        $doctor = Doctor::find($id);
        return view('pages.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        $doctor = Doctor::find($id);

        if (!$doctor) {
            return redirect()->route('doctors')->with('error', 'Id not found');
        }

        $data = $request->all();

        if ($request->file('image')) {

            $validator = Validator::make($request->all(), [
                'image' => 'required',
            ]);

            if($validator->fails()) {
                return Redirect::back()->withErrors($validator);
            }


            try {

                unlink('assets/doctorImages' . '/' . $doctor->image);

                $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
                $request->image->move(public_path('assets/doctorImages'), $imageName);

                $data['image'] = $imageName;

                $doctor->image = $data['image'];
                $doctor->save();

            } catch (\Exception$e) {

                $imageName = Carbon::now()->timestamp . '.' . $request->image->extension();
                $request->image->move(public_path('assets/doctorImages'), $imageName);

                $data['image'] = $imageName;
                $doctor->image = $data['image'];
                $doctor->save();

            }
        }

        if ($request->address) {
            $doctor->address = $request->address;
        }
        $doctor->name = $request->name;
        $doctor->speciality = $request->speciality;
        $doctor->experience = $request->experience;
        $doctor->save();

        return redirect()->route('doctors')->with('message', 'Doctor updated Successfully');
    }



    public function destroy($id)
    {

        $doctor = Doctor::find($id);

        if (!$doctor) {
            return redirect()->route('doctors')->with('error', 'Id not found');
        }

         try {

           $doctor = Doctor::where('id', $id)->get()->first();
           unlink('assets/doctorImages' . '/' . $doctor->image);
           $doctor->delete();
           return redirect()->route('doctors')->with('message', 'Doctor deleted Successfully');

         } catch (\Exception$e) {
            $doctor->delete();
            return redirect()->route('doctors')->with('message', 'Doctor deleted Successfully');
        }
    }

}

