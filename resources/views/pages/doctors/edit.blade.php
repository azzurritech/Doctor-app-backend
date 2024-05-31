@extends('layouts.dashboard')
@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @endpush
@section('content')
<section class="content">
<div class="text-right mb-3"><a href="/doctors" class=""><button class="btn btn-primary">Back To Doctors</button></a></div>
<form method="POST" action="{{ route('doctors.update', [$doctor->id]) }}" enctype="multipart/form-data">
    @CSRF
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Edit A Doctor</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse"
                            title="Collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="inputName">Name</label>
                        <input type="text" id="inputName" name="name" value="{{old('name', $doctor->name)}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Specilization</label>
                        <input type="text" id="inputName" name="speciality" value="{{old('speciality', $doctor->speciality)}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Address</label>
                        <textarea id="inputDescription" name="address" class="form-control" rows="4">{{ old('address',  $doctor->address) }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" value="{{old('image', $doctor->image)}}"  class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            <img src="{{ asset('assets/doctorImages') . '/' . $doctor->image }}"
                                                            class="img-fluid" alt="{{ $doctor->title }}"
                                                            style="width:40px" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputName">Experience</label>
                        <input type="text" id="inputName" name="experience" value="{{old('experience', $doctor->experience)}}"  class="form-control">
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>
    <div class="row mb-4">
        <div class="col-12">

            <input type="submit" value="Update" class="btn btn-success float-right">
        </div>
    </div>
</form>
</section>
@endsection