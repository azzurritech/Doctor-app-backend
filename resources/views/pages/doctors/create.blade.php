@extends('layouts.dashboard')
@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @endpush
@section('content')
<section class="content">
<div class="text-center"><h1>Adding Doctor</h1></div>


<div class="text-right mb-3"><a href="/doctors" class=""><button class="btn btn-primary">Back To Doctors</button></a></div>
<form method="POST" action="/storedoctors" enctype="multipart/form-data">
    @CSRF
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Add A Doctor</h3>

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
                        <input type="text" id="inputName" name="name" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputName">Specilization</label>
                        <input type="text" id="inputName" name="speciality" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="inputDescription">Address</label>
                        <textarea id="inputDescription" name="address" class="form-control" rows="4"></textarea>
                    </div>
                <div class="row">
                    <div class="form-group">
                        <div class="col-12">
                        <label for="image">Image</label>
                        <div class="custom-file">
                            <input type="file" name="image" class="custom-file-input" id="customFile">
                            <label class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            <div class="col-6">
                            <div class="mt-3" id="image-preview">
                            <label>Image Preview:</label>
                            <img src="#" alt="Image Preview" class="img-thumbnail" style="display: none; height:100px; width: 100px;">
                            </div>
                            </div>
                        </div>
                    </div>
                </div>    
                    <div class="form-group">
                        <label for="inputName">Experience</label>
                        <input type="text" id="inputName" name="experience" class="form-control">
                    </div>

                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>

    </div>
    <div class="row mb-4">
        <div class="col-12">

            <input type="submit" value="Add A Doctor" class="btn btn-success float-right">
        </div>
    </div>
</form>

</section>

<script>
    const imageInput = document.getElementById('customFile');
    const imagePreview = document.querySelector('#image-preview img');

    imageInput.addEventListener('change', function() {
        const file = imageInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            imagePreview.src = '#';
            imagePreview.style.display = 'none';
        }
    });
</script>

@endsection