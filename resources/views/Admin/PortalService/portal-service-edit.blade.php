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
                            <li class="breadcrumb-item"><a href="">Portal Service</a></li>
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
                            <h5>Edit Portal Service Charges</h5>
                        </div>
                        <form class="widget-contact-form" id="portalServiceUpdate"
                            action={{ '/admin/update/portal/service/charges/' . $portalServiceChargeData['id'] }} method="POST"
                            enctype="multipart/form-data" novalidate="">
                            {{-- <form method="post" action="" class="form theme-form needs-validation" novalidate="" enctype="multipart/form-data" > --}}
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Privacy Policy</label>
                                            @if (!is_null(@$portalServiceChargeData['tax']))
                                                <div class="col-sm-9">
                                                    <textarea type="text" name="tax" id="privacy_policy" class="form-control" required>{{ $portalServiceChargeData['tax'] }}</textarea>
                                                    <span class="text-danger error-text name_error"></span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Privacy Policy</label>
                                            @if (!is_null(@$portalServiceChargeData['platform_fee']))
                                                <div class="col-sm-9">
                                                    <textarea type="text" name="platform_fee" id="privacy_policy" class="form-control" required>{{ $portalServiceChargeData['platform_fee'] }}</textarea>
                                                    <span class="text-danger error-text name_error"></span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="col-sm-9 offset-sm-3">
                                        <button class="btn btn-primary" type="submit">update</button>
                                        <button class="btn btn-light" type="submit">Cancel</button>
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
    $(document).ready(function() {
        $('#portalServiceUpdate').on('submit', function(e) {
            e.preventDefault();
            e.stopPropagation();
            var form = this;

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
                    console.log(data);
                    if (data.status === false) {
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
                        location.reload();
                    }
                }
            });
        });

    });

</script>
@endsection
