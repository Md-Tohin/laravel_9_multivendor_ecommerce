@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <h4 style="float: left;" class="card-title">Categories</h4>
                                <a style="float: right;" class="btn btn-success btn-sm" href="{{ url('admin/add-edit-categories') }}">Add Category</a>
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
                                <table id="categories" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Category Name</th>
                                            <th>Parent Category</th>
                                            <th>Section</th>
                                            <th>URL</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key => $category)
                                        @php
                                            if (isset($category['parent_category']['category_name']) && (!empty($category['parent_category']['category_name']))){
                                                $parent_category = $category['parent_category']['category_name'];
                                            }                                                
                                            else{
                                                $parent_category = "Root";
                                            }                                                
                                        @endphp
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $category['category_name'] }}</td>
                                            <td>{{ $parent_category }}</td>
                                            <td>{{ $category['section']['name'] }}</td>
                                            <td>{{ $category['url'] }}</td>
                                            <td>
                                                @if ($category['status'] == 1)
                                                    <a class="updateCategoryStatus" id="category-{{ $category['id'] }}"
                                                        href="javascript:void(0)" category_id="{{ $category['id'] }}">
                                                        <i status="Active" style="font-size: 25px;"
                                                            class="mdi mdi-bookmark-check"></i>
                                                    </a>
                                                @else
                                                    <a class="updateCategoryStatus" id="category-{{ $category['id'] }}"
                                                        href="javascript:void(0)" category_id="{{ $category['id'] }}">
                                                        <i status="Inactive" style="font-size: 25px;"
                                                            class="mdi mdi-bookmark-outline"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/add-edit-category/'.$category['id']) }}" class="">
                                                    <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                                                </a>

                                                {{-- <a href="{{ url("admin/delete-category/". $category['id']) }}" class="confirmDelete" title="category">
                                                    <i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i>
                                                </a> --}}
                                                <a href="javascript:void(0)" class="confirmDelete" module="category" moduleId="{{ $category['id'] }}">
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
