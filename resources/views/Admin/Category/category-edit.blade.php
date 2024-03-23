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
                            <li class="breadcrumb-item"><a href="">Category</a></li>
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
                            <h5>Edit Category</h5>
                        </div>
                        <form class="widget-contact-form" id="categoryUpdate" action={{ "/admin/update/category/".$categoryData['id']}}
                            method="POST" enctype="multipart/form-data" novalidate="">
                            {{-- <form method="post" action="" class="form theme-form needs-validation" novalidate="" enctype="multipart/form-data" > --}}
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Category Name</label>
                                            @if (!is_null(@$categoryData['name']))
                                                <div class="col-sm-9">
                                                    <textarea type="text" name="name" id="description" class="form-control" placeholder="Category name" required>{{ $categoryData['name'] }}</textarea>
                                                    <span class="text-danger error-text name_error"></span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-md-3 col-form-label">Category Image</label>
                                            @if (!is_null(@$categoryData['image_url']))
                                            <div class="col-md-4">
                                                <img src="{{ $categoryData['image_url'] }}" alt="">
                                            </div>
                                            @endif

                                            <div class="col-md-5">
                                                <input class="form-control" id="image" type="file" name="image"
                                                    aria-label="file example">
                                                <span class="text-danger error-text image_error"></span>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label"></label>
                                            <div class="col-sm-9">
                                                <div class="img-holder"></div>
                                            </div>
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

<script src="{{ asset('Admin/js/form-validation-custom.js') }}"></script>
<script src="{{ asset('Admin/js/jquery.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">


<script>
    $(document).ready(function() {
        $('#categoryUpdate').on('submit', function(e) {
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
                            timer: 2000
                        });
                        location.replace('/admin/get-all/categories');

                    }
                }
            });
        });

    });

    //Reset input file
    $('input[type="file"][name="image"]').val('');
    // Image preview
    $('input[type="file"][name="image"]').on('change', function() {
        var img_path = $(this)[0].value;
        var img_holder = $('.img-holder');
        var extension = img_path.substring(img_path.lastIndexOf('.') + 1).toLowerCase();

        if (extension == 'jpeg' || extension == 'jpg' || extension == 'png') {
            if (typeof(FileReader) != 'undefined') {
                img_holder.empty();
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('<img/>', {
                        'src': e.target.result,
                        'class': 'img-fluid',
                        'style': 'max-width:100px;margin-bottom:10px'
                    }).
                    appendTo(img_holder);
                }
                img_holder.show();
                reader.readAsDataURL($(this)[0].files[0]);
            } else {
                $(img_holder).html('This browser does not support FileReader.');
            }
        }
    });
</script>
