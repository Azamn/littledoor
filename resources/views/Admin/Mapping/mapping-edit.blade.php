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
                            <li class="breadcrumb-item"><a href="">Category Question Mapping</a></li>
                            {{-- <li class="breadcrumb-item active">Create</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5>Category Question Mapping Details</h5>
                        </div>
                        <form class="widget-contact-form" id="subCategoryQuestionOptionMappingUpdate"
                            action="{{ '/admin/update/sub-category-question-option-mapping/' . @$mappingData['id'] }}"
                            method="POST" enctype="multipart/form-data">
                            {{-- <form method="post" action="" class="form theme-form needs-validation" novalidate="" enctype="multipart/form-data" > --}}
                            @csrf
                            <meta name="csrf-token" content="{{ csrf_token() }}">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col">

                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Category</label>
                                            <div class="col-sm-9">

                                                <select class="form-control from-control btn-square digits" id="category_id"
                                                    name="category_name">
                                                    @if (!is_null(@$mappingData['sub_category_name']))
                                                        @if (!is_null($subCategoryData))
                                                            @foreach ($subCategoryData as $category)
                                                                <option @if ($category['id'] == @$mappingData['sub_category_id']) selected @endif
                                                                    value="{{ $category['id'] }}">
                                                                    {{ $category['name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3 col-form-label">Questions</label>
                                            <div class="col-sm-9">

                                                <select class="form-control from-control btn-square digits" id="question"
                                                    name="question_id">
                                                    @if (!is_null(@$mappingData['question_name']))
                                                        @if (!is_null($questionData))
                                                            @foreach ($questionData as $question)
                                                                <option @if ($question['id'] == @$mappingData['question_id']) selected @endif
                                                                    value="{{ $question['id'] }}">
                                                                    {{ $question['name'] }}
                                                                </option>
                                                            @endforeach
                                                        @endif
                                                    @endif
                                                </select>
                                            </div>
                                        </div>

                                        <h5>SELECT OPTIONS</h5>
                                        @if (!is_null($options))
                                        @foreach ($options as $option)
                                        <div class="form-group m-0 row">
                                            <div class="mb-3">
                                                <div class="form-check checkbox checkbox-primary mb-0">
                                                    <input class="form-check-input" 

                                                    @foreach ($mappingData['options'] as $optionMap)
                                                        @if($optionMap['option_id'] == $option['id'])
                                                        {
                                                            checked
                                                        }
                                                        @endif
                                                    @endforeach

                                                    name="option_ids[{{ $option['id']  }}]" id="checkbox-primary-{{ $option['id']  }}"
                                                        type="checkbox">
                                                    <label class="form-check-label" for="checkbox-primary-{{ $option['id']  }}">{{$option['name']}}</label>
                                                </div>

                                            </div>
                                        </div>
                                        @endforeach
                                    @endif


                                       

                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="">
                                        <button class="btn btn-primary btn-lg" type="submit">Update</button>
                                    </div>
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

            $('#subCategoryQuestionOptionMappingUpdate').on('submit', function(e) {
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

        });
    </script>
@endsection
