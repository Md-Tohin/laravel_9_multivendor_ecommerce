@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold">Products</h4>
                    <br>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">{{ $title }}</h4>

                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Error:</strong> {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>Success:</strong> {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <form
                                action="@if (empty($product['id'])) {{ url('admin/add-edit-product') }} @else {{ url('admin/add-edit-product/' . $product['id']) }} @endif"
                                method="POST" enctype="multipart/form-data" class="forms-sample">
                                @csrf
                                <div class="form-group">
                                    <label for="category_id">Select Catgory</label>
                                    <select name="category_id" id="category_id" class="form-control" style="color: #495057"
                                        required>
                                        <option value=""> Choose One </option>
                                        @foreach ($categories as $section)
                                            <optgroup label="{{ $section['name'] }}"></optgroup>
                                            @foreach ($section['categories'] as $category)
                                                <option @if(!empty($product['category_id'] == $category['id']) ) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                                @foreach ($category['sub_categories'] as $subcategory)
                                                    <option @if(!empty($product['category_id'] == $subcategory['id']) ) selected="" @endif value="{{ $subcategory['id'] }}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                <div class="loadFilters">
                                    @include('admin.filters.category_filters')
                                </div>
                                <div class="form-group">
                                    <label for="brand_id">Select Brand</label>
                                    <select name="brand_id" id="brand_id" class="form-control" style="color: #495057"
                                        >
                                        <option value=""> -- Choose One --</option>
                                        @foreach ($getBrands as $brand)
                                            <option value="{{ $brand['id'] }}" {{ $product['brand_id'] == $brand['id'] ? "selected" : "" }}> {{ $brand['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="product_name">Product Name</label>
                                    <input type="text" class="form-control" name="product_name" id="product_name"
                                        @if (empty($product['id'])) value="{{ old('product_name') }}" @else value="{{ $product['product_name'] }}" @endif
                                        placeholder="Enter Product Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_code">Product Code</label>
                                    <input type="text" class="form-control" name="product_code" id="product_code"
                                        @if (empty($product['id'])) value="{{ old('product_code') }}" @else value="{{ $product['product_code'] }}" @endif
                                        placeholder="Enter Product Code" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_color">Product Color</label>
                                    <input type="text" class="form-control" name="product_color" id="product_color"
                                        @if (empty($product['id'])) value="{{ old('product_color') }}" @else value="{{ $product['product_color'] }}" @endif
                                        placeholder="Enter Product Color" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_price">Product Price</label>
                                    <input type="text" class="form-control" name="product_price"
                                        id="product_price"
                                        @if (empty($product['id'])) value="{{ old('product_price') }}" @else value="{{ $product['product_price'] }}" @endif
                                        placeholder="Enter Product Price" required>
                                </div>
                                <div class="form-group">
                                    <label for="product_discount">Product Discount (%)</label>
                                    <input type="text" class="form-control" name="product_discount"
                                        id="product_discount"
                                        @if (empty($product['id'])) value="{{ old('product_discount') }}" @else value="{{ $product['product_discount'] }}" @endif
                                        placeholder="Enter Product Discount">
                                </div>

                                <div class="form-group">
                                    <label for="product_weight">Product Weight</label>
                                    <input type="text" class="form-control" name="product_weight" id="product_weight"
                                        @if (empty($product['id'])) value="{{ old('product_weight') }}" @else value="{{ $product['product_weight'] }}" @endif
                                        placeholder="Enter Product Weight">
                                </div>

                                <div class="form-group">
                                    <label for="group_code">Group Code</label>
                                    <input type="text" class="form-control" name="group_code" id="group_code"
                                        @if (empty($product['id'])) value="{{ old('group_code') }}" @else value="{{ $product['group_code'] }}" @endif
                                        placeholder="Enter Group Code">
                                </div>

                                <div class="form-group">
                                    <label for="product_image">Product Image</label>
                                    <input type="file" class="form-control" name="product_image" id="product_image"
                                        @if (empty($product['id'])) value="{{ old('product_image') }}" @else value="{{ $product['product_image'] }}" @endif
                                    >
                                    @if (!empty($product['product_image']))
                                        <a href="{{ url('front/images/product_images/small/' . $product['product_image']) }}"
                                            target="_blank">View Image</a> &nbsp; &nbsp;|&nbsp;
                                            <a href="javascript:void(0)" class="confirmDelete" module="product-image" moduleId="{{ $product['id'] }}"> Delete Image</a>
                                        <input type="hidden" name="current_image"
                                            value="{{ $product['product_image'] }}">

                                    @endif

                                </div>
                                <div class="form-group">
                                    <label for="product_video">Product Video</label>
                                    <input type="file" class="form-control" name="product_video" id="product_video"
                                        @if (empty($product['id'])) value="{{ old('product_video') }}" @else value="{{ $product['product_video'] }}" @endif
                                        >
                                    @if (!empty($product['product_video']))
                                        <a href="{{ url('front/videos/product_videos/' . $product['product_video']) }}"
                                            target="_blank">View Video</a> &nbsp; &nbsp;|&nbsp;
                                            <a href="javascript:void(0)" class="confirmDelete" module="product-video" moduleId="{{ $product['id'] }}"> Delete Video</a>
                                        <input type="hidden" name="current_video"
                                            value="{{ $product['product_video'] }}">

                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="description">Product Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"
                                        placeholder="Enter Product Description">
                                                @if (empty($product['id']))
                                                    {{ old('description') }}
                                                @else
                                                    {{ $product['description'] }}
                                                @endif
                                            </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title"
                                        @if (empty($product['id'])) value="{{ old('meta_title') }}" @else value="{{ $product['meta_title'] }}" @endif
                                        placeholder="Enter Mete Title">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <input type="text" class="form-control" name="meta_description" id="meta_description"
                                        @if (empty($product['id'])) value="{{ old('meta_description') }}" @else value="{{ $product['meta_description'] }}" @endif
                                        placeholder="Enter Meta Description">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                        @if (empty($product['id'])) value="{{ old('meta_keywords') }}" @else value="{{ $product['meta_keywords'] }}" @endif
                                        placeholder="Meta Keywords">
                                </div>
                                <div class="form-group">
                                    <label for="is_featured">Featured Item</label>
                                    <input type="checkbox" name="is_featured" id="is_featured" value="Yes"
                                        @if (!empty($product['is_featured']) && $product['is_featured']=="Yes") checked="" @endif>
                                </div>
                                <div class="form-group">
                                    <label for="is_bestseller">Best Seller Item</label>
                                    <input type="checkbox" name="is_bestseller" id="is_bestseller" value="Yes"
                                        @if (!empty($product['is_bestseller']) && $product['is_bestseller']=="Yes") checked="" @endif>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </form>
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
