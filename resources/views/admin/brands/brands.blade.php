@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <h4 style="float: left;" class="card-title">Brands</h4>
                                <a style="float: right;" class="btn btn-success btn-sm" href="{{ url('admin/add-edit-brand') }}">Add Brand</a>
                            </div>
                            <br>
                            <div class="messege">
                                @if (Session::has('success_message'))
                                    <p style="margin-bottom: 30px"></p>
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>Success:</strong> {{ Session::get('success_message') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                            </div>                            
                            <div class="table-responsive pt-3">
                                <table id="brands" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Brand Name</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $key => $value)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $value['name'] }}</td>
                                                <td>
                                                    @if ($value['status'] == 1)
                                                        <a class="updateBrandstatus" id="brand-{{ $value['id'] }}"
                                                            href="javascript:void(0)" brand_id="{{ $value['id'] }}">
                                                            <i status="Active" style="font-size: 25px;"
                                                                class="mdi mdi-bookmark-check"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateBrandstatus" id="brand-{{ $value['id'] }}"
                                                            href="javascript:void(0)" brand_id="{{ $value['id'] }}">
                                                            <i status="Inactive" style="font-size: 25px;"
                                                                class="mdi mdi-bookmark-outline"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="{{ url('admin/add-edit-brand/'.$value['id']) }}" class="">
                                                        <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                                                    </a>

                                                    {{-- <a href="{{ url("admin/delete-brand/". $value['id']) }}" class="confirmDelete" title="brand">
                                                        <i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i>
                                                    </a> --}}
                                                    <a href="javascript:void(0)" class="confirmDelete" module="brand" moduleId="{{ $value['id'] }}">
                                                        <i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        @include('admin.layout.footer')
        <!-- partial -->
    </div>  
@endsection
