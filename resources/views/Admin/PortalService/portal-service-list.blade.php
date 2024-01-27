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
                            <li class="breadcrumb-item active">Portal Service</li>
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
                        <h3>Portal Service Charges </h3>
                        <div class="mt-4">
                            <a class="btn btn-primary" href="/admin/portal-service-charges-create">Add Portal Service Charges</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Tax</th>
                                        <th scope="col">Platform Fees</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null(@$portalServiceChargeData))
                                        @foreach ($portalServiceChargeData as $key => $portalService)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $portalService['tax'] }}</td>
                                                <td>{{ $portalService['platform_fee'] }}</td>
                                               
                                                <td>
                                                    <a href="{{'/admin/portal-service/charges/'.$portalService['id']}}">
                                                        <button class="btn btn-pill btn-primary"
                                                            data-id="{{ $portalService['id'] }}">Edit</button>
                                                    </a>
                                                    <a href="#">
                                                        @csrf
                                                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                        <button class="btn btn-pill btn-danger" id="deleteBtn"
                                                            type="submit"
                                                            data-id="{{ $portalService['id'] }}">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th scope="row">1</th>
                                            <td>sdv</td>
                                            <td><img src="{{ asset('Admin/images/littledoor/logo.png') }}" height="100px"
                                                    alt=""></td>
                                            <td>
                                                <div class="media-body  switch-m">
                                                    <label class="switch">
                                                        <input type="checkbox"><span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- <a class="btn btn-primary m-2" data-id="{{ $facilities['id'] }}" id="editBtn">Edit</a> --}}
                                                <button class="btn btn-danger m-2" data-id="" id="deleteBtn"
                                                    type="submit">Delete</button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    </div>
@endsection
{{-- @section('js') --}}
<script src="{{ asset('Admin/js/form-validation-custom.js') }}"></script>
<script src="{{ asset('Admin/js/jquery.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

<script>
    // delete
    $(document).on('click', '#deleteBtn', function() {

        var form = this;
        var portal_service_charges_id = $(form).attr('data-id');
        var url = '{{ route('delete.portal-service') }}';

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
                        portal_service_charges_id: portal_service_charges_id
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
{{-- @endsection --}}
