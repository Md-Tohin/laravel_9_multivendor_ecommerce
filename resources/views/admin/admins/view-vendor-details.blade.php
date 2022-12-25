@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                <h3 class="font-weight-bold">Vendor Details</h3>
                <a href="{{ url('admin/admins/vendor') }}">Back to Vendor</a>

            </div>
        </div>
        <br><br>
        <div class="row">

            <div class="col">
                <div class="col-md-12 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Personal Information</h4>

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input class="form-control" @if (isset($vendorDetails['email']))
                                    value="{{ $vendorDetails['email'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Name</label>
                                <input class="form-control" @if (isset($vendorDetails['name']))
                                    value="{{ $vendorDetails['name'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Mobile </label>
                                <input class="form-control" @if (isset($vendorDetails['vendor_personal']['mobile']))
                                    value="{{ $vendorDetails['vendor_personal']['mobile'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Address</label>
                                <input class="form-control" @if (isset($vendorDetails['vendor_personal']['address']))
                                    value="{{ $vendorDetails['vendor_personal']['address'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">City</label>
                                <input class="form-control" @if (isset($vendorDetails['vendor_personal']['city']))
                                    value="{{ $vendorDetails['vendor_personal']['city'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">State</label>
                                <input class="form-control" @if (isset($vendorDetails['vendor_personal']['state']))
                                    value="{{ $vendorDetails['vendor_personal']['state'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Country</label>
                                <input class="form-control" @if (isset($vendorDetails['vendor_personal']['country']))
                                    value="{{ $vendorDetails['vendor_personal']['country'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label for="email">Pincode</label>
                                <input class="form-control" @if (isset($vendorDetails['vendor_personal']['pincode']))
                                    value="{{ $vendorDetails['vendor_personal']['pincode'] }}" @endif readonly>
                            </div>

                            @if (!empty($vendorDetails['image']))
                            <div class="form-group">
                                <label for="email">Photo</label>
                                <br>
                                <a href="{{ url('admin/images/photos/' . $vendorDetails['image']) }}" target="_blank">
                                    <img src="{{ url('admin/images/photos/' . $vendorDetails['image']) }}"
                                        style="width: 200px; height: 130px" alt="Image">
                                </a>
                            </div>
                            @endif

                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Bank Information</h4>

                            <div class="form-group">
                                <label>Account Holder Name</label>
                                <input class="form-control" @if (isset($vendorBankDetails['account_holder_name']))
                                    value="{{ $vendorBankDetails['account_holder_name'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label>Bank Name</label>
                                <input class="form-control" @if (isset($vendorBankDetails['bank_name']))
                                    value="{{ $vendorBankDetails['bank_name'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label>Account Number</label>
                                <input class="form-control" @if (isset($vendorBankDetails['account_number']))
                                    value="{{ $vendorBankDetails['account_number'] }}" @endif readonly>
                            </div>
                            <div class="form-group">
                                <label>Bank IFSC Code</label>
                                <input class="form-control" @if (isset($vendorBankDetails['bank_ifsc_code']))
                                    value="{{ $vendorBankDetails['bank_ifsc_code'] }}" @endif readonly>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Business Information</h4>

                        <div class="form-group">
                            <label for="email">Shop Name</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_name']))
                                value="{{ $vendorBusinessDetails['shop_name'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop Mobile</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_mobile']))
                                value="{{ $vendorBusinessDetails['shop_mobile'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop Address</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_address']))
                                value="{{ $vendorBusinessDetails['shop_address'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop City</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_city']))
                                value="{{ $vendorBusinessDetails['shop_city'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop State</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_state']))
                                value="{{ $vendorBusinessDetails['shop_state'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop Country</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_country']))
                                value="{{ $vendorBusinessDetails['shop_country'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop Pincode</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_pincode']))
                                value="{{ $vendorBusinessDetails['shop_pincode'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop Website</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_website']))
                                value="{{ $vendorBusinessDetails['shop_website'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop Email</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['shop_email']))
                                value="{{ $vendorBusinessDetails['shop_email'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Address Proof</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['address_proof']))
                                value="{{ $vendorBusinessDetails['address_proof'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Business License Number</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['business_license_number']))
                                value="{{ $vendorBusinessDetails['business_license_number'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop GST Number</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['gst_number']))
                                value="{{ $vendorBusinessDetails['gst_number'] }}" @endif readonly>
                        </div>
                        <div class="form-group">
                            <label for="email">Shop PAN Number</label>
                            <input class="form-control" @if (isset($vendorBusinessDetails['pan_number']))
                                value="{{ $vendorBusinessDetails['pan_number'] }}" @endif readonly>
                        </div>

                        @if (!empty($vendorBusinessDetails['address_proof_image']))
                        <div class="form-group">
                            <label for="email">Address Proof Image</label>
                            <br>
                            <a href="{{ url('admin/images/proofs/' . $vendorBusinessDetails['address_proof_image']) }}"
                                target="_blank">
                                <img src="{{ url('admin/images/proofs/' . $vendorBusinessDetails['address_proof_image']) }}"
                                    style="width: 200px; height: 130px" alt="Image">
                            </a>
                        </div>
                        @endif

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