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
                            <li class="breadcrumb-item"><a href="">Promotion</a></li>
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
                            <h5>Promotion Details</h5>
                        </div>
                        <form class="widget-contact-form" id="aboutusAdd" action="" enctype="multipart/form-data">
                            {{-- <form method="post" action="" class="form theme-form needs-validation" novalidate="" enctype="multipart/form-data" > --}}
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Promotion Name : </label>
                                            <div class="col-sm-9">
                                                Promotion Name
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Promotion Image</label>
                                            <div class="col-sm-9">
                                                <img src="" alt="">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Is Always</label>
                                            <div class="col-sm-9">
                                                <div class="media-body switch-m">
                                                    <label class="switch">
                                                        @csrf
                                                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                        <input type="checkbox" onchange="toggle_always()">
                                                        <span class="switch-state"></span>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="date-form">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">Start Date</label>
                                                <div class="col-sm-9">
                                                   12/08/1998
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label">End Date</label>
                                                <div class="col-sm-9">
                                                    12/08/1998
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="col-sm-9">
                                    <button class="btn btn-primary" type="submit">Save</button>
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
        var isVisible = true;
        function toggle_always()
        {
            var dateForm = document.getElementById("date-form");
            if (isVisible) {
                dateForm.style.display = 'none';
                isVisible = false;
            } else {
                dateForm.style.display = 'block';
                isVisible = true;
            }
        }
    </script>
@endsection
