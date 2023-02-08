@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold">Coupons</h4>
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

                            <form action="@if (empty($coupon['id'])) {{ url('admin/add-edit-coupon') }} @else {{ url('admin/add-edit-coupon/' . $coupon['id']) }} @endif"
                                method="POST" class="forms-sample">
                                @csrf
                                @if (empty($coupon['coupon_code']))
                                <div class="form-group">
                                    <label for="coupon_option">Coupon Option</label> <br>
                                    <span>
                                        <input type="radio" name="coupon_option" id="AutomaticCoupon" value="Automatic" checked>&nbsp; Automatic &nbsp; &nbsp;
                                    </span>
                                    <span>
                                        <input type="radio" name="coupon_option" id="ManualCoupon" value="Manual">&nbsp; Manual
                                    </span>                                    
                                </div>
                                <div class="form-group" style="display: none;" id="coupon_field">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input type="text" class="form-control" name="coupon_code"
                                        @if (empty($coupon['id'])) value="{{ old('coupon_code') }}" @else value="{{ $coupon['coupon_code'] }}" @endif
                                        placeholder="Enter Coupon Code">
                                </div>
                                @else
                                <input type="hidden" name="coupon_option" value="{{ $coupon['coupon_option'] }}">
                                <input type="hidden" name="coupon_code" value="{{ $coupon['coupon_code'] }}">
                                <div class="form-group" id="coupon_field">
                                    <label for="coupon_code">Coupon Code</label>
                                    <input class="form-control" value="{{ $coupon['coupon_code'] }}" readonly>
                                </div>
                                @endif
                                <div class="form-group">
                                    <label for="coupon_type">Coupon Type</label> <br>
                                    <span>
                                        <input type="radio" name="coupon_type" value="Multiple Times" @if (isset($coupon['coupon_type']) && ($coupon['coupon_type'] == "Multiple Times")) checked @endif>&nbsp; Multiple Times &nbsp;&nbsp;
                                    </span>
                                    <span>
                                        <input type="radio" name="coupon_type" value="Single Time" @if (isset($coupon['coupon_type']) && ($coupon['coupon_type'] == "Single Time")) checked @endif>&nbsp; Single Time
                                    </span>                                    
                                </div>
                                <div class="form-group">
                                    <label for="amount_type">Amount Type</label> <br>
                                    <span>
                                        <input type="radio" name="amount_type" value="Percentage" @if (isset($coupon['amount_type']) && ($coupon['amount_type'] == "Percentage")) checked @endif>&nbsp; Percentage (in %) &nbsp;&nbsp;
                                    </span>
                                    <span>
                                        <input type="radio" name="amount_type" value="Fixed" @if (isset($coupon['amount_type']) && ($coupon['amount_type'] == "Fixed")) checked @endif>&nbsp; Fixed (in TK or USD)
                                    </span>                                    
                                </div>

                                <div class="form-group">
                                    <label for="amount">Percentage or Fixed Amount</label>
                                    <input type="number" class="form-control" name="amount" id="amount"
                                        @if (empty($coupon['id'])) value="{{ old('amount') }}" @else value="{{ $coupon['amount'] }}" @endif
                                        placeholder="Enter Percentage or Fixed Amount">
                                </div>
                                
                                <div class="form-group">
                                    <label for="categories">Select Catgory</label>
                                    <select name="categories[]" multiple class="form-control" style="color: #495057"
                                        >
                                        <option value=""> Choose One </option>
                                        @foreach ($categories as $section)
                                            <optgroup label="{{ $section['name'] }}"></optgroup>
                                            @foreach ($section['categories'] as $category)
                                                <option value="{{ $category['id'] }}" @if (in_array($category['id'],$selCategories)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                                @foreach ($category['sub_categories'] as $subcategory)
                                                    <option value="{{ $subcategory['id'] }}" @if (in_array($subcategory['id'],$selCategories)) selected @endif>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                               
                                <div class="form-group">
                                    <label for="brands">Select Brand</label>
                                    <select name="brands[]" multiple class="form-control" style="color: #495057"
                                        >
                                        <option value=""> -- Choose One --</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{ $brand['id'] }}" @if (in_array($brand['id'],$selBrands)) selected @endif> {{ $brand['name'] }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="users">Select User</label>
                                    <select name="users[]" multiple class="form-control" style="color: #495057"
                                        >
                                        <option value=""> -- Choose One --</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user['email'] }}" @if (in_array($user['email'],$selUsers)) selected @endif> {{ $user['email'] }}</option>
                                        @endforeach
                                    </select>
                                </div>                              
                               
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" class="form-control" name="expiry_date" id="expiry_date"
                                        @if (empty($coupon['id'])) value="{{ old('expiry_date') }}" @else value="{{ $coupon['expiry_date'] }}" @endif
                                        placeholder="Enter expiry_date">
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

