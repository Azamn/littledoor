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
                            <li class="breadcrumb-item active">Mapping</li>
                            {{-- <li class="breadcrumb-item active">Product list</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-8">
                        <h3>Category Question Mapping </h3>
                    </div>
                    <div class="col-md-4 text-right">
                        <div class="">
                            <a class="btn btn-primary" href="{{ route('get.create-mapping-data') }}">Add Mapping</a>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <div class="col-md-12">
            @if (!is_null(@$finalData))
                @foreach ($finalData as $data)
                    <div class="card">

                        <div class="card-header" style="padding: 20px; !important">
                            <div class="row">
                                <div class="col-md-8">
                                    @if (!is_null(@$data['sub_category_name']))
                                        <h5>
                                            <label
                                                class="badge badge-light-primary">{{ @$data['sub_category_name'] }}</label>
                                    @endif
                                    @if (!is_null(@$data['question_name']))
                                        <h4>{{ @$data['question_name'] }} </h4>
                                    @else
                                        <h4>Question </h4>
                                    @endif

                                </div>
                                <div class="col-md-4 text-right">
                                    @csrf
                                    <meta name="csrf-token" content="{{ csrf_token() }}" />

                                    <a class="btn btn-primary m-2" href="{{ '/admin/edit/sub-category-question-option-mapping/' . $data['id'] }}"
                                        data-id="{{ @$data['id'] }}" id="editBtn">Edit</a>

                                    <button class="btn btn-danger m-2" data-id="{{ @$data['id'] }}" id="deleteBtn"
                                        type="submit">Delete</button>

                                </div>
                            </div>


                        </div>
                        <div class="card-body animate-chk" style="padding: 20px; !important">
                            <div class="row">
                                <div class="col">
                                    @if (!is_null(@$data['options']))
                                        @foreach ($data['options'] as $option)
                                            <label class="d-block" for="edo-ani">{{ @$option['option_name'] }}</label>
                                        @endforeach
                                    @endif
                                </div>
                            </div>

                        </div>

                    </div>
                @endforeach
            @endif
        </div>


    </div>
@endsection
@section('js')
    <script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

    <script>
        // delete
        $(document).on('click', '#deleteBtn', function() {

            var form = this;
            var category_question_mapping_id = $(form).attr('data-id');
            var url = '{{ route('delete.sub-ctageory-question-option-mapping') }}';

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
                            category_question_mapping_id: category_question_mapping_id
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
