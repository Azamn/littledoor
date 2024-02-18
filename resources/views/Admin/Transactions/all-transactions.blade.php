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
                            <li class="breadcrumb-item active">All Transaction Details</li>
                            {{-- <li class="breadcrumb-item active">Product list</li> --}}
                        </ol>
                    </div>
                </div>
            </div>
        </div>
      
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Patient Name</th>
                                        <th scope="col">Doctor Name</th>
                                        <th scope="col">Transaction Amount</th>
                                        <th scope="col">Transaction Number</th>
                                        <th scope="col">Transaction Status</th>
                                        <th scope="col">Transaction Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if (!is_null(@$transactionDetails))
                                        @foreach ($transactionDetails as $key => $transaction)
                                            <tr>
                                                <th scope="row">{{ $key + 1 }}</th>
                                                <td>{{ $transaction['patient_name'] }}</td>
                                                <td>{{ $transaction['doctor_name'] }}</td>
                                                <td>{{ $transaction['amount'] }}</td>
                                                <td>{{ $transaction['transaction_number'] }}</td>
                                                <td>
                                                @if($transaction['status'] == 'Success' )
                                                    <span class= "badge badge-light-success">{{ $transaction['status'] }} </span>
                                                @elseif($transaction['status'] == 'Failed' )
                                                    <span class= "badge badge-light-secondary">{{ $transaction['status'] }} </span>
                                                @else
                                                    <span class= "badge badge-light-warning">{{ $transaction['status'] }} </span>
                                                @endif
                                                </td>   
                                                <td>{{ $transaction['created_at'] }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                            
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

    </div>
    </div>
@endsection
{{-- @section('js') --}}
<script src="{{ asset('Admin/js/form-validation-custom.js') }}"></script>
<script src="{{ asset('Admin/js/jquery.min.js') }}"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.all.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.3/dist/sweetalert2.min.css">

<script>
    // delete
   
</script>
{{-- @endsection --}}
