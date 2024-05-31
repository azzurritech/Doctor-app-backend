@extends('layouts.dashboard')
@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
@endpush
@section('content')
<div class="text-center"><h1>Doctors List</h1></div>
<div class="mt-3 ms-5 me-5 mb-5">
<div class="text-right mb-3"><a href="/add" class=""><button class="btn btn-primary">Add New Doctor</button></a></div>
    <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>
                 Name</th>
                    <th>
                    specilization</th>
                    <th>
                    Address</th>
                    <th>
                    image</th>
                 
                    <th>
                 Experience</th>
                 
                    <th>
                 Action</th>
                 
                </tr>
            </thead>
            <tbody>
            @foreach ($doctors as $item)
            <?php
            var_dump($item);
            die();
            ?>
                <tr>
                    <td>{{ $item['id'] }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->status }}</td>
                    <td>{{ $item->address }}</td>
                    <td>
                       
                                    <img src="{{ asset('assets/doctorImages') . '/' . $item->image }}"
                                        class="img-fluid" alt="{{ $item->name }}"
                                        style="width:40px; height:40px"/>      
                    </td>
                  
                    <td>{{ $item->experience }}</td>
                    <td>
                        <div class="">
                            <a href="{{ route('doctors.edit', [$item->id]) }}" class="btn btn-warning"><i class="fas fa-edit"></i></a>
                            <!-- <i class="fa-regular fa-pen-to-square"></i> -->
                            <a href="#" class="btn btn-danger"><i class="fas fa-ban"></i></a>
                        </div>

                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
</div>
</section>
@push('js')

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script>
    $(document).ready(function () {
    $('#example').DataTable();
});
</script>
    

    @endpush
    @endsection
