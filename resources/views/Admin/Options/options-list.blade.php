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
                            <li class="breadcrumb-item active">Options</li>
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
                        <h3>Options </h3>
                        <div class="mt-4">
                            <a class="btn btn-primary" href="/admin/options">Add Options</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-1" style="width:100%">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Options Name</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null($masterOptionsData))
                                        @foreach ($masterOptionsData as $key => $optionsData)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $optionsData['name'] }}</td>
                                                <td>
                                                    <div class="media-body  switch-m">
                                                        <label class="switch">
                                                            @csrf
                                                            <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                            <input type="checkbox"
                                                                onchange="option_active_toggle_function({{ $optionsData['id'] }})"
                                                                @if ($optionsData['status']) checked="" @endif><span
                                                                class="switch-state"></span>
                                                        </label>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="#">
                                                        @csrf
                                                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                        <a class="btn btn-primary m-2" href={{ '/admin/edit/option/' . $optionsData['id'] }}"
                                                        data-id="{{ $optionsData['id'] }}" id="editBtn">Edit</a>
                                                        <button class="btn btn-pill btn-danger" id="deleteBtn"
                                                            type="submit"
                                                            data-id="{{ $optionsData['id'] }}">Delete</button>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <th scope="row">1</th>
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
                <! Container-fluid Ends>
            </div>
        @endsection
        @section('js')
            <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

            <script>
                function option_active_toggle_function(option_id) {
                    var option_id = option_id;

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url: '{{ route('option.change.status') }}',
                        method: 'GET',
                        data: {
                            option_id: option_id
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
                    var option_id = $(form).attr('data-id');
                    var url = '{{ route('delete.option') }}';

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
                                    option_id: option_id
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
