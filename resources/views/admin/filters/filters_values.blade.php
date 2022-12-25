@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <h4 style="float: left;" class="card-title">Filters Values</h4>
                                
                                <a style="float: right;" class="btn btn-info btn-sm" href="{{ url('admin/filters') }}">View Filter Column</a>
                                <a style="float: right; margin-right: 10px;" class="btn btn-success btn-sm" href="{{ url('admin/add-edit-filter-value') }}">Add Filter Values</a>  
                                                              
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
                                <table id="filtersValues" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Filter ID</th>
                                            <th>Filter Name</th>
                                            <th>Filter Value</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($filters_values as $key => $value)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $value['filter_id'] }}</td>
                                            <td>
                                                @php
                                                    $filterName = App\Models\ProductsFilter::getFilterName($value['filter_id']);
                                                    echo $filterName ;
                                                @endphp
                                            </td>
                                            <td>{{ $value['filter_value'] }}</td>
                                            <td>
                                                @if ($value['status'] == 1)
                                                    <a class="updateFiltersValueStatus" id="filter-{{ $value['id'] }}"
                                                        href="javascript:void(0)" filter_id="{{ $value['id'] }}">
                                                        <i status="Active" style="font-size: 25px;"
                                                            class="mdi mdi-bookmark-check"></i>
                                                    </a>
                                                @else
                                                    <a class="updateFiltersValueStatus" id="filter-{{ $value['id'] }}"
                                                        href="javascript:void(0)" filter_id="{{ $value['id'] }}">
                                                        <i status="Inactive" style="font-size: 25px;"
                                                            class="mdi mdi-bookmark-outline"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/add-edit-filter-value/'.$value['id']) }}" class="">
                                                    <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                                                </a>

                                                {{-- <a href="{{ url("admin/delete-filter/". $value['id']) }}" class="confirmDelete" title="filter">
                                                    <i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i>
                                                </a> --}}
                                                <a href="javascript:void(0)" class="confirmDelete" module="filter-value" moduleId="{{ $value['id'] }}">
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
