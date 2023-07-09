@extends('Admin.layouts.base')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/admin/dashboard"> <i data-feather="home"></i></a></li>
                            <li class="breadcrumb-item active">Doctor</li>
                            {{-- <li class="breadcrumb-item active">Product list</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <! Container-fluid starts>
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <h3>Doctor </h3>

                    </div>
                    @if (!is_null($doctorData))
                        <div class="table-responsive">
                            <table class="table" id='client_table'>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">City </th>
                                        <th scope="col">Status </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                @foreach ($doctorData as $key => $doctor)
                                    <tbody>
                                        <tr>
                                            <th scope="row">{{ $key+1 }}</th>
                                            <td>{{ $doctor['name'] }}</td>
                                            <td>{{ $doctor['email'] }}</td>
                                            <td>{{ $doctor['mobile_no'] }}</td>
                                            <td>{{ $doctor['city'] }}</td>
                                            <td>
                                                <div class="media-body  switch-m">
                                                    <label class="switch">
                                                        @csrf
                                                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                        <input type="checkbox"
                                                            onchange="doctor_active_toggle_function({{ $doctor['id'] }})"
                                                            @if ($doctor['status']) checked="" @endif><span
                                                            class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- <a class="btn btn-primary m-2" data-id="{{ $facilities['id'] }}" id="editBtn">Edit</a> --}}
                                                <button class="btn btn-primary m-2" data-id="" id="deleteBtn"
                                                    type="submit">View Details</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                @endforeach

                            </table>
                        </div>
                    @else
                        <div class="table-responsive">
                            <table class="table" id='client_table'>
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Mobile Number</th>
                                        <th scope="col">Qualification </th>
                                        <th scope="col">Status </th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>sdv</td>
                                        <td>sdv</td>
                                        <td>sdv</td>
                                        <td>sdv</td>
                                        <td>
                                            <div class="media-body  switch-m">
                                                <label class="switch">
                                                    <input type="checkbox"><span class="switch-state"></span>
                                                </label>
                                            </div>
                                        </td>
                                        <td>
                                            {{-- <a class="btn btn-primary m-2" data-id="{{ $facilities['id'] }}" id="editBtn">Edit</a> --}}
                                            <button class="btn btn-primary m-2" data-id="" id="deleteBtn"
                                                type="submit">View Details</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif

                </div>
            </div>
            <! Container-fluid Ends>
    </div>
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        function doctor_active_toggle_function(doctor_id) {
            var doctor_id = doctor_id;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('change.doctor-status') }}',
                method: 'GET',
                data: {
                    doctor_id: doctor_id
                },
                dataType: 'json',
                success: function(data) {

                    if (data.status == true) {
                        Swal.fire({
                            position: 'center',
                            icon: 'success',
                            title: data.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        location.reload(true);
                    }

                    // title:'Title',
                },
                error: function(data) {},
            });
        }

        // delete
        $(document).on('click', '#deleteBtn', function() {

            var form = this;
            var aboutus_id = $(form).attr('data-id');
            var url = '';

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                // icon: 'warning',
                showCancelButton: true,
                allowOutsideClick: false,
                cancelButtonColor: '#7366ff',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: url,
                        method: 'DELETE',
                        data: {
                            aboutus_id: aboutus_id
                        },
                        dataType: 'json',

                        success: function(data) {
                            if (data.status == true) {
                                Swal.fire({
                                    position: 'center',
                                    icon: 'success',
                                    title: data.message,
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                location.reload(true);
                            }
                        }

                    });
                }
            });
        });
    </script>
@endsection
