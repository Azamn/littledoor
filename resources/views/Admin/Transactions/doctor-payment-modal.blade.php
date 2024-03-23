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
                        <li class="breadcrumb-item"><a href="">Transaction</a></li>
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
                        <h5>Doctor Payment Request</h5>
                    </div>
                    <form class="widget-contact-form" id="aboutusAdd" action="" enctype="multipart/form-data">
                    {{-- <form method="post" action="" class="form theme-form needs-validation" novalidate="" enctype="multipart/form-data" > --}}
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="col">

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Doctor Name</label>
                                        <div class="col-sm-9">
                                            {{$data['doctor_name']}}
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Request Amount</label>
                                        <div class="col-sm-9">
                                            {{$data['request_amount']}}
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3 col-form-label">Transaction Number</label>
                                        <div class="col-sm-9"><textarea type="text" name="transaction_number" id="transaction_number"
                                                class="form-control" placeholder="Enter Transaction Number"></textarea>
                                            <span class="text-danger error-text name_error"></span>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="col-sm-9 offset-sm-3">
                                <button class="btn btn-primary" type="submit">Update</button>
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
<script src="{{asset('Assets/Admin/js/form-validation-custom.js')}}"></script>
<script src="{{asset('Asset/website/js/functions.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>

    $(function(){

        $('#aboutusAdd').on('submit', function(e){
            e.preventDefault();
            var form = this;
            var token = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url:$(form).attr('action'),
                method:$(form).attr('method'),
                data:new FormData(form),
                processData:false,
                dataType:'json',
                contentType:false,
                beforeSend:function(response){
                    $(form).find('span.error-text').text('');
                },

                success:function(data){
                    if(data.status == false){
                        $.each(data.errors, function(prefix,val){
                            $(form).find('span.'+prefix+'_error').text(val[0]);
                        });
                    }else{
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
        $('input[type="file"][name="image"]').on('change', function(){
            var img_path = $(this)[0].value;
            var img_holder = $('.img-holder');
            var extension = img_path.substring(img_path.lastIndexOf('.')+1).toLowerCase();

            if(extension == 'jpeg' || extension == 'jpg' || extension == 'png'){
                if(typeof(FileReader) != 'undefined'){
                    img_holder.empty();
                    var reader = new FileReader();
                    reader.onload = function(e){
                        $('<img/>',{'src':e.target.result,'class':'img-fluid','style':'max-width:100px;margin-bottom:10px'}).
                        appendTo(img_holder);
                    }
                    img_holder.show();
                    reader.readAsDataURL($(this)[0].files[0]);
                }else{
                    $(img_holder).html('This browser does not support FileReader.');
                }
            }
        });

    });

</script>

@endsection
