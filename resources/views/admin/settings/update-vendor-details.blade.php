@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Update Vendor Details</h3>
                <br>
                <br>
            </div>
        </div>

        @if ($slug == 'personal')
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Personal Information</h4>

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

                        <form action="{{ url('admin/update-vendor-details/personal') }}" method="POST"
                            enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            <div class="form-group">
                                <label for="email">Vendor Username/Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ Auth::guard('admin')->user()->email }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name"
                                    value="{{ Auth::guard('admin')->user()->name }}" placeholder="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" name="address" id="address"
                                    value="{{ $vendorDetails['address'] }}" placeholder="Address" required>
                            </div>
                            <div class="form-group">
                                <label for="city">City</label>
                                <input type="text" class="form-control" name="city" id="city"
                                    value="{{ $vendorDetails['city'] }}" placeholder="City" required>
                            </div>
                            <div class="form-group">
                                <label for="state">State</label>
                                <input type="text" class="form-control" name="state" id="state"
                                    value="{{ $vendorDetails['state'] }}" placeholder="State" required>
                            </div>
                            <div class="form-group">
                                <label for="country">Country</label>
                                <select name="country" id="country" class="form-control" style="color: #495057">
                                    <option value="">Select Country</option>
                                    @foreach ($countries as $country)
                                    <option value="{{ $country->country_name }}" {{
                                        ($vendorDetails['country']==$country['country_name']) ? 'selected' : '' }}>{{
                                        $country->country_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pincode">Pincode</label>
                                <input type="text" class="form-control" name="pincode" id="pincode"
                                    value="{{ $vendorDetails['pincode'] }}" placeholder="Pincode" required>
                            </div>
                            <div class="form-group">
                                <label for="mobile">Mobile</label>
                                <input type="text" class="form-control" name="mobile" id="mobile"
                                    value="{{ Auth::guard('admin')->user()->mobile }}" placeholder="Mobile" required>
                            </div>

                            <div class="form-group">
                                <label for="image">Vendor Photo</label>
                                <input type="file" class="form-control" name="image" id="image" placeholder="Mobile">
                                @if (!empty(Auth::guard('admin')->user()->image))
                                <a href="{{ url('admin/images/photos/' . Auth::guard('admin')->user()->image) }}"
                                    target="_blank">View Image</a>
                                <input type="hidden" name="current_image"
                                    value="{{ Auth::guard('admin')->user()->image }}">
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @elseif($slug == 'business')
        <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Business Information</h4>

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

                        <form action="{{ url('admin/update-vendor-details/business') }}" method="POST"
                            enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="email">Vendor Username/Email</label>
                                        <input type="text" class="form-control" name="email" id="email"
                                            value="{{ Auth::guard('admin')->user()->email }}" readonly>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_name">Shop Name</label>
                                        <input type="text" class="form-control" name="shop_name" id="shop_name"
                                            @isset($vendorDetails['shop_name'])
                                            value="{{ $vendorDetails['shop_name'] }}" @endisset
                                            placeholder="Enter Shop Name" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_address">Shop Address</label>
                                        <input type="text" class="form-control" name="shop_address" id="shop_address"
                                            @if (isset($vendorDetails['shop_address']))
                                            value="{{ $vendorDetails['shop_address'] }}" @endif
                                            placeholder="Enter Shop Address" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_city">Shop City</label>
                                        <input type="text" class="form-control" name="shop_city" id="shop_city"
                                            @if(isset($vendorDetails['shop_city']))
                                            value="{{ $vendorDetails['shop_city'] }}" @endif
                                            placeholder="Enter Shop City" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_state">Shop State</label>
                                        <input type="text" class="form-control" name="shop_state" id="shop_state"
                                            @if(isset($vendorDetails['shop_state']))
                                            value="{{ $vendorDetails['shop_state'] }}" @endif
                                            placeholder="Enter Shop State" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_country">Shop Country</label>
                                        <select name="shop_country" id="shop_country" class="form-control"
                                            style="color: #495057" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                            <option value="{{ $country['country_name'] }}"
                                                @if(isset($vendorDetails['shop_country']) &&
                                                $country['country_name']==$vendorDetails['shop_country']) selected
                                                @endif>{{ $country->country_name
                                                }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_pincode">Shop Pincode</label>
                                        <input type="text" class="form-control" name="shop_pincode" id="shop_pincode"
                                            @if(isset($vendorDetails['shop_pincode']))
                                            value="{{ $vendorDetails['shop_pincode'] }}" @endif
                                            placeholder="Enter Shop Pincode" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_mobile">Shop Mobile</label>
                                        <input type="text" class="form-control" name="shop_mobile" id="shop_mobile"
                                            @if(isset($vendorDetails['shop_mobile']))
                                            value="{{ $vendorDetails['shop_mobile'] }}" @endif
                                            placeholder="Enter Shop Mobile Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_email">Shop Email</label>
                                        <input type="text" class="form-control" name="shop_email" id="shop_email"
                                            @if(isset($vendorDetails['shop_email']))
                                            value="{{ $vendorDetails['shop_email'] }}" @endif
                                            placeholder="Enter Shop Email Address" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="shop_website">Shop Website</label>
                                        <input type="text" class="form-control" name="shop_website" id="shop_website"
                                            @if(isset($vendorDetails['shop_website']))
                                            value="{{ $vendorDetails['shop_website'] }}" @endif
                                            placeholder="Enter Shop Website" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="business_license_number">Business License Number</label>
                                        <input type="text" class="form-control" name="business_license_number"
                                            id="business_license_number"
                                            @if(isset($vendorDetails['business_license_number']))
                                            value="{{ $vendorDetails['business_license_number'] }}" @endif
                                            placeholder="Enter Business License Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="gst_number">GST Number</label>
                                        <input type="text" class="form-control" name="gst_number" id="gst_number"
                                            @if(isset($vendorDetails['gst_number']))
                                            value="{{ $vendorDetails['gst_number'] }}" @endif
                                            placeholder="Enter GST Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="pan_number">PAN Number</label>
                                        <input type="text" class="form-control" name="pan_number" id="pan_number"
                                            @if(isset($vendorDetails['pan_number']))
                                            value="{{ $vendorDetails['pan_number'] }}" @endif
                                            placeholder="Enter PAN Number" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_proof">Address Proof</label>
                                        <select class="form-control" name="address_proof" id="address_proof">
                                            <option>Choose One</option>
                                            <option value="Passport" @if (isset($vendorDetails['address_proof']) &&
                                                $vendorDetails['address_proof']=="Passport" ) selected @endif>
                                                Passport</option>
                                            <option value="Voting Card" @if (isset($vendorDetails['address_proof']) &&
                                                $vendorDetails['address_proof']=="Voting Card" ) selected @endif>
                                                Voting Card</option>
                                            <option value="PAN" @if (isset($vendorDetails['address_proof']) &&
                                                $vendorDetails['address_proof']=="PAN" ) selected @endif>
                                                PAN</option>
                                            <option value="Driving Lience" @if (isset($vendorDetails['address_proof']) &&
                                                $vendorDetails['address_proof']=="Driving Lience" ) selected @endif>
                                                Driving Lience</option>
                                            <option value="Aadhar Card" @if (isset($vendorDetails['address_proof']) &&
                                                $vendorDetails['address_proof']=="Aadhar Card" ) selected @endif>
                                                Aadhar Card</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address_proof_image">Address Proof Image</label>
                                        <input type="file" class="form-control" name="address_proof_image"
                                            id="address_proof_image" placeholder="Mobile">
                                        @if (!empty($vendorDetails['address_proof_image']))
                                        <a href="{{ url('admin/images/proofs/' . $vendorDetails['address_proof_image']) }}"
                                            target="_blank">View Image</a>
                                        <input type="hidden" name="current_image"
                                            value="{{ $vendorDetails['address_proof_image'] }}">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        @elseif($slug == 'bank')
        <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Update Bank Information</h4>

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

                        <form action="{{ url('admin/update-vendor-details/bank') }}" method="POST"
                            enctype="multipart/form-data" class="forms-sample">
                            @csrf
                            <div class="form-group">
                                <label for="email">Vendor Username/Email</label>
                                <input type="text" class="form-control" name="email" id="email"
                                    value="{{ Auth::guard('admin')->user()->email }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="account_holder_name">Account Holder Name</label>
                                <input type="text" class="form-control" name="account_holder_name"
                                    id="account_holder_name" @if(isset($vendorDetails['account_holder_name'])) value="{{ $vendorDetails['account_holder_name'] }}" @endif
                                    placeholder="Account Holder Name" required>
                            </div>
                            <div class="form-group">
                                <label for="bank_name">Bank Name</label>
                                <input type="text" class="form-control" name="bank_name" id="bank_name" @if(isset($vendorDetails['bank_name']))
                                    value="{{ $vendorDetails['bank_name'] }}" @endif placeholder="Bank Name" required>
                            </div>
                            <div class="form-group">
                                <label for="account_number">Account Number</label>
                                <input type="text" class="form-control" name="account_number" id="account_number" @if(isset($vendorDetails['account_number']))
                                    value="{{ $vendorDetails['account_number'] }}" @endif placeholder="Account Number"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="bank_ifsc_code">Bank IFSC Code</label>
                                <input type="text" class="form-control" name="bank_ifsc_code" id="bank_ifsc_code" @if(isset($vendorDetails['bank_ifsc_code']))
                                    value="{{ $vendorDetails['bank_ifsc_code'] }}" @endif placeholder="Bank IFSC Code"
                                    required>
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif


    </div>
    <!-- content-wrapper ends -->
    <!-- partial:../../partials/_footer.html -->
    @include('admin.layout.footer')
    <!-- partial -->
</div>
@endsection