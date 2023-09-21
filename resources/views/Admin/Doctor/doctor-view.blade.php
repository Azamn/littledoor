@extends('Admin.layouts.base')

@section('content')
    <div class="page-body">
        <div class="container-fluid">
            <div class="page-title">
                <div class="row">
                    <div class="col-6">
                        <h3>Doctor Details</h3>
                    </div>
                    <div class="col-6">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">
                                    <svg class="stroke-icon">
                                        <use href="../assets/svg/icon-sprite.svg#stroke-home"></use>
                                    </svg></a></li>

                            <li class="breadcrumb-item active">Doctor Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Container-fluid starts-->
        <div class="container-fluid">
            <div>
                <div class="row product-page-main p-0">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="product-page-details">
                                    <div class="" style="display: flex; justify-content: space-between;">
                                        <div class="">
                                            @if (!is_null($data['first_name']))
                                            <h3>{{ $data['first_name'] }}</h3>
                                        @else
                                            <h3>Doctor Name</h3>
                                        @endif
                                        </div>

                                        <div class="">
                                            <div class="media-body switch-m">
                                                <label class="switch">
                                                    @csrf
                                                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                    <input type="checkbox"
                                                        onchange="doctor_active_toggle_function({{ $data['id'] }})"
                                                        @if (@$data['status']) checked="" @endif><span
                                                        class="switch-state"></span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                   
                                   
                                </div>

                                <hr>
                                <div>
                                    <table class="product-page-width">
                                        <tbody>
                                            <tr>
                                                <td> <b>DOB &nbsp;&nbsp;&nbsp;:</b></td>
                                                @if (!is_null($data['dob']))
                                                    <td>{{ $data['dob'] }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td> <b>Gender &nbsp;&nbsp;&nbsp;:</b></td>
                                                @if (!is_null($data['gender']))
                                                    <td>{{ $data['gender'] }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td> <b>Email &nbsp;&nbsp;&nbsp;:</b></td>
                                                @if (!is_null($data['email']))
                                                    <td>{{ $data['email'] }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td> <b>Mobile No &nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                                @if (!is_null($data['mobile_no']))
                                                    <td> {{ $data['mobile_no'] }}</td>
                                                @endif
                                            </tr>
                                            <tr>
                                                <td> <b>City&nbsp;&nbsp;&nbsp;: &nbsp;&nbsp;&nbsp;</b></td>
                                                @if (!is_null($data['city']))
                                                    <td>{{ $data['city'] }}</td>
                                                @endif
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#left-collapseOne10" aria-expanded="true"
                                                aria-controls="left-collapseOne">Work Experience</button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne10"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @foreach ($data['work_experience'] as $experience)
                                                    <div>
                                                        <table class="product-page-width">
                                                            <tbody>
                                                                <tr>
                                                                    <td> <b>Category Name &nbsp;&nbsp;&nbsp;:</b></td>
                                                                    <td>{{ $experience['category_name'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b>Sub Category &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b>
                                                                    </td>
                                                                    <td>
                                                                        @if (!is_null($experience['sub_category']))
                                                                            @foreach (@$experience['sub_category'] as $subCat)
                                                                                {{ @$subCat['name'] }},
                                                                            @endforeach
                                                                        @endif
                                                                    </td>

                                                                </tr>

                                                                <tr>
                                                                    <td> <b>Year Of Experience &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td> {{ @$experience['year_of_experience'] }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b>Description &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td> {{ @$experience['description'] }} </td>
                                                                </tr>

                                                                <tr>
                                                                    @if (!is_null($experience['certificate']))
                                                                        @foreach (@$experience['certificate'] as $certificate)
                                                                            <td> <b>Certificates &nbsp;&nbsp;&nbsp;:
                                                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                                                            <td><a class="btn btn-primary"
                                                                                    href="{{ @$certificate }}" target="_blank"> <i
                                                                                        class="icon-eye"></i> View
                                                                                    Certificate </a></td>
                                                                        @endforeach
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#left-collapseOne1"
                                                aria-expanded="true" aria-controls="left-collapseOne">Education</button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne1"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @foreach ($data['education'] as $education)
                                                    <div>
                                                        <table class="product-page-width">
                                                            <tbody>
                                                                <tr>
                                                                    <td> <b>Course Name &nbsp;&nbsp;&nbsp;:</b></td>
                                                                    <td>{{ @$education['name'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b>Insitution Name &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td> {{ @$education['institution_name'] }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b>Filed Of Study &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td> {{ @$education['field_of_study'] }} </td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b>Time Period &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td>{{ @$education['start_date'] }} to
                                                                        {{ @$education['end_date'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td> <b>Description &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td>{{ @$education['description'] }}</td>
                                                                </tr>
                                                                <tr>
                                                                    @if (!is_null($education['documents']))
                                                                        @foreach (@$education['documents'] as $certificate)
                                                                            <td> <b>Certificates &nbsp;&nbsp;&nbsp;:
                                                                                    &nbsp;&nbsp;&nbsp;</b></td>
                                                                            <td><a class="btn btn-primary"
                                                                                    href="{{ @$certificate }}" target="_blank"> <i
                                                                                        class="icon-eye"></i> View
                                                                                    Certificate </a></td>
                                                                        @endforeach
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne1">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#left-collapseOne2"
                                                aria-expanded="true" aria-controls="left-collapseOne">Skills</button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne2"
                                            aria-labelledby="headingOne1" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div>
                                                    <table class="product-page-width">
                                                        <tbody>
                                                            @if (!is_null($data['skills']))
                                                                @foreach (@$data['skills'] as $skill)
                                                                <tr>
                                                                    <td> <b>Skill &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td> 
                                                                    <td>{{$skill['skill_name']}}</td>
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
                            </div>
                        </div>

                    </div>




                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample1">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"
                                                type="button" data-bs-toggle="collapse" data-bs-target="#left-collapseOne3"
                                                aria-expanded="true" aria-controls="left-collapseOne">Address</button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne3"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample1">
                                            <div class="accordion-body">
                                                <div>

                                                    @foreach ($data['address'] as $address)
                                                    <table class="product-page-width">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Address Type &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $address['address_type'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Address Line 1 &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $address['address_line_1'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Address Line 2 &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $address['address_line_2'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Pincode &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $address['pincode'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>City &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $address['city_name'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>State &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $address['state_name'] }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    @endforeach

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>



                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"

                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#left-collapseOne4" aria-expanded="true"
                                                aria-controls="left-collapseOne">Language</button>

                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne4"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div>
                                                    <table class="product-page-width">
                                                        <tbody>
                                                            @if (!is_null($data['languages']))
                                                                @foreach ($data['languages'] as $language)
                                                                <tr> 
                                                                    <td>{{$language}}</td>
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
                            </div>
                        </div>

                    </div>



                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#left-collapseOne5" aria-expanded="true"
                                                aria-controls="left-collapseOne">Appreciation</button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne5"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div>
                                                    @foreach ($data['appreciation'] as $appreciation)
                                                    <table class="product-page-width">
                                                        <tbody>
                                                            <tr>
                                                                <td> <b>Appreciation Name &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $appreciation['name'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Category&nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $appreciation['category_achieved'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Issue Date &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $appreciation['issue_date'] }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td> <b>Description &nbsp;&nbsp;&nbsp;:</b></td>
                                                                <td>{{ $appreciation['description'] }}</td>
                                                            </tr>

                                                            <tr>
                                                                @if (!is_null( $appreciation['image_url']))
                                                                    <td> <b>Appreciation Certificate &nbsp;&nbsp;&nbsp;:
                                                                        &nbsp;&nbsp;&nbsp;</b></td>
                                                                    <td><a class="btn btn-primary"
                                                                        href="{{ @$appreciation['image_url'] }}" target="_blank"> <i
                                                                            class="icon-eye"></i> View
                                                                        Certificate </a></td>
                                                                @endif
                                                            </tr>
                                                            
                                                            
                                                        </tbody>
                                                    </table>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>






                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="accordion dark-accordion" id="accordionExample">
                                    <div class="accordion-item accordion-wrapper">
                                        <h2 class="accordion-header" id="headingOne">
                                            <button class="accordion-button collapsed accordion-light-primary txt-primary"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#left-collapseOne6" aria-expanded="true"
                                                aria-controls="left-collapseOne">Other Document</button>
                                        </h2>
                                        <div class="accordion-collapse collapse" id="left-collapseOne6"
                                            aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <div>
                                                    <table class="product-page-width">
                                                        <tbody>
                                                            @if (!is_null($data['other']))
                                                                @foreach (@$data['other'] as $other)
                                                               
                                                                    @if (!is_null( $other['document']))
                                                                    <tr>
                                                                        <td> <b>Document Name &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                        <td>{{$other['name']}}</td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td> <b>File &nbsp;&nbsp;&nbsp;:
                                                                            &nbsp;&nbsp;&nbsp;</b></td>
                                                                        <td><a class="btn btn-primary"
                                                                            href="{{ @$other['document'] }}" target="_blank"> <i
                                                                                class="icon-eye"></i> View
                                                                            Certificate </a></td>
                                                                    </tr>
                                                                    @endif
                                                               
                                                                @endforeach
                                                            @endif
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




                </div>
            </div>

        </div>
        <!-- Container-fluid Ends-->
    </div>
@endsection

@section('js')
<script>
 function doctor_active_toggle_function(doctor_id) {
            var doctor_id = doctor_id;

            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{ route('change.doctor-status') }}',
                method: 'GET',
                data: {
                    doctor_id: doctor_id
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
@endsection