@extends('Admin.layouts.base')

@section('content')
<div class="page-body" >
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-6 ">
                    <h3>Dashboard</h3>
                </div>
                <div class="col-6">
                    <ol class="breadcrumb text-white">
                        <li class="breadcrumb-item"><a href="index.html"><i data-feather="home"></i></a></li>
                        <li class="breadcrumb-item">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row size-column">

            <div class="col-xl-7 box-col-12 xl-100">
                <div class="row dash-chart">
                    <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
                        <div class="card o-hidden" style="background-color :#643fdb">
                            <div class="card-body">
                                <div class="media">
                                    <div class="media-body text-white">
                                        <p class="f-w-900 font-roboto text-white">Doctor Count</p>
                                        <div class="progress-box">
                                            <h4 class="f-w-900 mb-0 f-26"><span class="counter">{{$data['doctor_count']}}</span></h4>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 box-col-6 col-lg-12 col-md-6">
                        <div class="card o-hidden"  style="background-color :#643fdb">
                            <div class="card-body text-white">
                                <div class="ecommerce-widgets media">
                                    <div class="media-body">
                                        <p class="f-w-900 font-roboto text-white">Patient Count</p>
                                        <h4 class="f-w-900 mb-0 f-26"><span class="counter">{{$data['patient_count']}}</span></h4>
                                    </div>
                                   
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-6 box-col-6 col-lg-6 col-md-6">
                        <div class="card o-hidden" >
                            <div class="card-header card-no-border" style="background-color :#f47f7f">

                                <div class="media">
                                    <div class="media-body">
                                        <p><span class="f-w-900 text-white font-roboto">Total Transaction</span></p>
                                        <h4 class="f-w-900 mb-0 text-white f-26"><span class="counter">{{$data['total_transaction']}}</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="profit-card">
                                            <div id="spaline-chart"></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 box-col-6 col-lg-6 col-md-6">
                        <div class="card o-hidden" >
                            <div class="card-header card-no-border" style="background-color :#f47f7f">

                                <div class="media">
                                    <div class="media-body">
                                        <p><span class="f-w-900 text-white font-roboto">Tax Amount</span></p>
                                        <h4 class="f-w-900 mb-0 text-white f-26"><span class="counter">{{$data['tax_amount']}}</span></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="media">
                                    <div class="media-body">
                                        <div class="profit-card">
                                            <div id="spaline-chart"></div>
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
