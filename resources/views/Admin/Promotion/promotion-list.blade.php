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
                            <li class="breadcrumb-item active">Promotion</li>
                            
                        </ol>
                    </div>
                </div>
            </div>
        </div>
            <div class="container-fluid">
                
                <div class="card">
                    <div class="card-header">
                        <h3>Promotion</h3>
                        <div class="mt-4">
                            <a class="btn btn-primary" href="/admin/promotion-create">Add Promotion</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="display" id="data-source-1" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Start Date</th>
                                        <th scope="col">End Date</th>
                                        <th scope="col">Is Always</th>
                                        <th scope="col">Image</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"> Promotion $key + 1 Promotion </th>
                                        <td>Promotion name</td>
                                        <td>12/28/1998</td>
                                        <td>12/28/1998</td>
                                        <td><div class="media-body switch-m">
                                            <label class="switch">
                                                @csrf
                                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                <input type="checkbox"><span
                                                    class="switch-state"></span>
                                            </label>
                                        </div></td>
                                        
                                        <td>
                                            <img src="Promotion $emotion['image'] ?? null Promotion" width="50"
                                                alt="">
                                        </td>
                                        <td>
                                            <a href="/admin/promotion-view">
                                                @csrf
                                                <meta name="csrf-token" content="{{ csrf_token() }}" />
                                                <button class="btn btn-primary btn-pill">View</button>
                                            </a>
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