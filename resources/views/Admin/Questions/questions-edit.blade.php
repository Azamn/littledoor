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
                            <li class="breadcrumb-item"><a href="/admin/dashboard"><i data-feather="home"></i></a></li>
                            <li class="breadcrumb-item"><a href="">Questions</a></li>
                            {{-- <li class="breadcrumb-item active">Create</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h5>Questions Details</h5>
                        </div>
                        <form class="widget-contact-form" id="updateQuestion" action="{{ "/admin/update/question/".$questionData['id']}}"
                            method="POST" enctype="multipart/form-data">
                            {{-- <form method="post" action="" class="form theme-form needs-validation" novalidate="" enctype="multipart/form-data" > --}}
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">

                            <div class="card-body">
                                <div class="" id="formDiv">
                                    <div class="form-group">
                                        <label class="col-md-3 col-form-label">Question</label>
                                        <textarea type="text" name="question" id="Question" class="form-control" placeholder="Enter Question"></textarea>
                                        <span class="text-danger error-text features_error"></span>

                                    </div>
                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="">
                                    <button class="btn btn-lg btn-primary" type="submit">Update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection


@section('js')
    <script src="{{ asset('Assets/Admin/js/form-validation-custom.js') }}"></script>
    <script src="{{ asset('Asset/website/js/functions.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(function() {
            // update QUESTIONS
            $('#updateQuestion').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                var token = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function(response) {
                        $(form).find('span.error-text').text('');
                    },

                    success: function(data) {
                        if (data.status == false) {
                            $.each(data.errors, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $(form)[0].reset();

                            Swal.fire({
                                position: 'center',
                                icon: 'success',
                                title: data.message,
                                showConfirmButton: false,
                                timer: 1500
                            });

                        }
                    }
                });

            });

        });
    </script>
@endsection
