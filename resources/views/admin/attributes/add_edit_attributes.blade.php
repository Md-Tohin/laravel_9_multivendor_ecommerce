@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold">Attributes</h4>
                    <br>
                </div>
                <div class="col-md-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add Attributes</h4>

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
                                action="{{ url('admin/add-edit-attributes/' . $product['id']) }}"
                                method="POST" class="forms-sample">
                                @csrf
                              
                                <div class="form-group">
                                    <label for="product_name" style="font-weight: 700;">Product Name :</label>
                                    &nbsp; {{ $product['product_name'] }}                                   
                                </div>
                                <div class="form-group">
                                    <label for="product_name" style="font-weight: 700;">Product Color :</label>
                                    &nbsp; {{ $product['product_color'] }}                                   
                                </div>
                                <div class="form-group">
                                    <label for="product_name" style="font-weight: 700;">Product Price :</label>
                                    &nbsp; {{ $product['product_price'] }}                                   
                                </div>
                                <div class="form-group">
                                    <label for="product_name" style="font-weight: 700;">Product Image :</label>
                                    &nbsp;
                                    @if (!empty($product['product_image']) && file_exists('front/images/product_images/small/'.$product['product_image']))
                                        <img style="width: 120px;" src="{{ url('front/images/product_images/small/'.$product['product_image']) }}" alt="Image">
                                    @else
                                        <img style="width: 120px;" src="{{ url('front/images/product_images/small/no_image.jpg') }}" alt="Image">
                                    @endif                              
                                </div>

                                <div class="form-group">
                                    <div class="field_wrapper">
                                        <div>
                                            <input type="text" name="size[]" placeholder="Size" style="width: 120px;" required/>
                                            <input type="text" name="sku[]" placeholder="SKU" style="width: 120px;" required/>                                            
                                            <input type="text" name="price[]" placeholder="Price" style="width: 120px;" required/>
                                            <input type="text" name="stock[]" placeholder="Stock" style="width: 120px;" required/>
                                            <a href="javascript:void(0);" class="add_button" title="Add Attributes">Add</a>
                                        </div>
                                    </div>
                                </div>
                               
                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                            </form>
                            <br><br><h4 class="card-title">Product Attributes</h4>

                            <form action="{{ url('admin/edit-attribute/'.$product['id']) }}" method="post">
                                @csrf       
                                <table id="products" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Size</th>
                                            <th>SKU</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($product['attributes'] as $key => $attribute)                                                                                                          
                                            <tr>
                                                <td>
                                                    {{ $key + 1 }}
                                                    <input style="display: none" type="text" name="attributeId[]" value="{{ $attribute['id'] }}">
                                                </td>
                                                <td>{{ $attribute['size'] }}</td>
                                                <td>{{ $attribute['sku'] }}</td>
                                                <td>
                                                    <input type="number" name="price[]" value="{{ $attribute['price'] }}" style="width:70px" required>                                                
                                                </td>
                                                <td>
                                                    <input type="number" name="stock[]" value="{{ $attribute['stock'] }}" style="width:70px" required>                                                      
                                                </td>                                                                   
                                                <td>
                                                    @if ($attribute['status'] == 1)
                                                        <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}"
                                                            href="javascript:void(0)" attribute_id="{{ $attribute['id'] }}">
                                                            <i status="Active" style="font-size: 25px;"
                                                                class="mdi mdi-bookmark-check"></i>
                                                        </a>
                                                    @else
                                                        <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}"
                                                            href="javascript:void(0)" attribute_id="{{ $attribute['id'] }}">
                                                            <i status="Inactive" style="font-size: 25px;"
                                                                class="mdi mdi-bookmark-outline"></i>
                                                        </a>
                                                    @endif
                                                    <a href="javascript:void(0)" class="confirmDelete" module="attribute" moduleId="{{ $attribute['id'] }}">
                                                        <i style="font-size: 25px;" title="Delete Attribute" class="mdi mdi-file-excel-box"></i>
                                                    </a>
                                                </td>
                                            
                                            </tr>                                        
                                        @endforeach
                                    </tbody>
                                </table>
                                <button class="btn btn-success" type="submit">Update Attributes</button>
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
