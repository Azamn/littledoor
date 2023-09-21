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
                            <li class="breadcrumb-item active">Emotions</li>
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>
            <div class="container-fluid">
                
                <div class="card">
                    <div class="card-header">
                        <h3>Emotions</h3>
                        <div class="mt-4">
                            <a class="btn btn-primary" href="/admin/emotion-create">Add Emotions</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"> Emotions $key + 1 Emotions </th>
                                        <td>Emotions $emotion['name']Emotions </td>
                                        <td>
                                            <img src="Emotions $emotion['image'] ?? null Emotions" width="50"
                                                alt="">
                                        </td>
                                        <td>
                                            <a href="#">
                                                @csrf
                                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                <button class="btn btn-pill btn-danger" id="deleteBtn"
                                                    type="submit"
                                                    data-id="categoryData['id']">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>


                </div>
            </div>
    </div>
@endsection