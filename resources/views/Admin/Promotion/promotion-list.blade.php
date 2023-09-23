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
                            <li class="breadcrumb-item active">Promotion</li>

                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">

            <div class="card">
                <div class="card-header">
                    <h3>Promotion</h3>
                    <div class="mt-4">
                        <a class="btn btn-primary" href="/admin/promotion-create">Add Promotion</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="display" id="data-source-1" style="width:100%">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Start Date</th>
                                    <th scope="col">End Date</th>
                                    <th scope="col">Is Always</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!is_null(@$masterPromotionsData))
                                    @foreach ($masterPromotionsData as $key => $promotion)
                                        <tr>
                                            <th scope="row">{{ $key + 1 }}</th>
                                            <td>{{ $promotion['title'] }}</td>

                                            @if (!is_null($promotion['start_date']))
                                                <td>{{ $promotion['start_date'] }}</td>
                                            @else
                                                <td> - </td>
                                            @endif

                                            @if (!is_null($promotion['end_date']))
                                                <td>{{ $promotion['end_date'] }}</td>
                                            @else
                                                <td> - </td>
                                            @endif

                                            <td>{{ $promotion['is_always'] }}</td>


                                            <td>
                                                <img src="{{ $promotion['image_url'] ?? null }}" width="50"
                                                    alt="">
                                            </td>
                                            <td>
                                                <div class="media-body  switch-m">
                                                    <label class="switch">
                                                        @csrf
                                                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                        <input type="checkbox"
                                                            onchange="promotion_active_toggle_function({{ $promotion['id'] }})"
                                                            @if ($promotion['status']) checked="" @endif><span
                                                            class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </td>
                                            <td>
                                                {{-- <a href="#">
                                                    <button class="btn btn-pill btn-primary"
                                                        data-id="{{ $promotion['id'] }}">Edit</button>
                                                </a> --}}
                                                <a href="#">
                                                    @csrf
                                                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                    <button class="btn btn-pill btn-danger" id="deleteBtn" type="submit"
                                                        data-id="{{ $promotion['id'] }}">Delete</button>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection

<script src="{{ asset('Admin/js/form-validation-custom.js') }}"></script>
<script src="{{ asset('Admin/js/jquery.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

<script>
    // delete
    $(document).on('click', '#deleteBtn', function() {

        var form = this;
        var promotion_id = $(form).attr('data-id');
        var url = '{{ route('delete.promotion') }}';

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
                        promotion_id: promotion_id
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

    // change status
    function promotion_active_toggle_function(promotion_id) {
        var promotion_id = promotion_id;

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route('change.promotion-status') }}',
            method: 'GET',
            data: {
                promotion_id: promotion_id
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
</script>
