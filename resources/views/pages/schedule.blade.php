
@extends('layouts.dashboard')
@push('css')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    @endpush
@section('content')
<div class="text-center"><h1>Online Scheduled Calls</h1></div>
<div class="m-5">
    <table id="example" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>id</th>
                    <th>
                 Name</th>
                    <th>
                    Date</th>
                  
                    <th>
                    Start Time</th>
                 
                    <th>
                    End Time</th>
                 
                    <th>
                 Purpose</th>
                 
                    <th>
                 Action</th>
                 
                </tr>
            </thead>
            <tbody>
                @foreach ($bookings as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->date }}</td>
                    <td>{{ $item->availability->starttime }}</td>
                    <td>{{ $item->availability->endtime }}</td>
                    <td>{{ $item->subject }}</td>
                    <td>
                        <div class="">
                            <a href="{{ route('video') }}" class="btn btn-warning"><i class="fas fa-video"></i></a>
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