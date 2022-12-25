@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <div class="">
                                <h4 style="float: left;" class="card-title">Products</h4>
                                <a style="float: right;" class="btn btn-success btn-sm" href="{{ url('admin/add-edit-product') }}">Add Product</a>
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
                                <table id="products" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>SL No</th>
                                            <th>Product Name</th>
                                            <th>Product Code</th>
                                            <th>Product Color</th>
                                            <th>Product Image</th>
                                            <th>Category</th>
                                            <th>Section</th>
                                            <th>Added by</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $key => $product)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $product['product_name'] }}</td>
                                            <td>{{ $product['product_code'] }}</td>
                                            <td>{{ $product['product_color'] }}</td>
                                            <td>
                                                @if (!empty($product['product_image']))
                                                <a href="{{ url('front/images/product_images/small/'.$product['product_image']) }}" target="_blank" rel="noopener noreferrer">
                                                    <img style="width: 80px; height: 80px;" src="{{ url('front/images/product_images/small/'.$product['product_image']) }}" alt="Image">
                                                </a>
                                                    @else
                                                    <img style="width: 80px; height: 80px;" src="{{ url('front/images/product_images/small/no_image.jpg') }}" alt="Image">
                                                @endif
                                                
                                            </td>
                                            <td>{{ $product['category']['category_name'] }}</td>
                                            <td>{{ $product['section']['name'] }}</td>
                                            <td>
                                                @if ($product['admin_type']=="vendor")
                                                    <a href="{{ url('admin/view-vendor-details/'.$product['admin_id']) }}">{{ ucfirst($product['admin_type']) }}</a>
                                                @else
                                                    {{ $product['admin_type'] }}
                                                @endif
                                            </td>                                            
                                            <td>
                                                @if ($product['status'] == 1)
                                                    <a class="updateProductStatus" id="product-{{ $product['id'] }}"
                                                        href="javascript:void(0)" product_id="{{ $product['id'] }}">
                                                        <i status="Active" style="font-size: 25px;"
                                                            class="mdi mdi-bookmark-check"></i>
                                                    </a>
                                                @else
                                                    <a class="updateProductStatus" id="product-{{ $product['id'] }}"
                                                        href="javascript:void(0)" product_id="{{ $product['id'] }}">
                                                        <i status="Inactive" style="font-size: 25px;"
                                                            class="mdi mdi-bookmark-outline"></i>
                                                    </a>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ url('admin/add-edit-product/'.$product['id']) }}" title="Edit Product" class="">
                                                    <i style="font-size: 25px;" class="mdi mdi-pencil-box"></i>
                                                </a>
                                                <a href="{{ url('admin/add-edit-attributes/'.$product['id']) }}" title="Add Attributes" class="">
                                                    <i style="font-size: 25px;" class="mdi mdi-plus-box"></i>
                                                </a>
                                                <a href="{{ url('admin/add-images/'.$product['id']) }}" title="Add Images" class="">
                                                    <i style="font-size: 25px;" class="mdi mdi-library-plus"></i>
                                                </a>

                                                {{-- <a href="{{ url("admin/delete-product/". $product['id']) }}" class="confirmDelete" title="product">
                                                    <i style="font-size: 25px;" class="mdi mdi-file-excel-box"></i>
                                                </a> --}}
                                                <a href="javascript:void(0)" class="confirmDelete" module="product" moduleId="{{ $product['id'] }}">
                                                    <i style="font-size: 25px;" title="Delete Product" class="mdi mdi-file-excel-box"></i>
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
