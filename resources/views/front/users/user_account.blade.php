@extends('front.layout.layout')

@section('content')
<!-- Page Introduction Wrapper -->
<div class="page-style-a">
    <div class="container">
        <div class="page-intro">
            <h2>Account</h2>
            <ul class="bread-crumb">
                <li class="has-separator">
                    <i class="ion ion-md-home"></i>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="is-marked">
                    <a href="account.html">Account</a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Page Introduction Wrapper /- -->
<!-- Account-Page -->
<div class="page-account u-s-p-t-80">
    <div class="container">
        <div class="row">            
            <!-- Account Details -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20" style="font-size: 18px">Update Contact Details</h2>
                    <div id="account-success"></div>
                    <form action="javascript:;" method="POST" id="accountForm">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" id="user-email" value="{{ Auth::user()->email }}" name="email" class="text-field" readonly style="background: #ccc">
                            <p id="account-email"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-name">Name
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="name" value="{{ Auth::user()->name }}" id="user-name" class="text-field" placeholder="Name">
                            <p id="account-name"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-mobile">Mobile
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="mobile" value="{{ Auth::user()->mobile }}" id="user-mobile" class="text-field" placeholder="Mobile">
                            <p id="account-mobile"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-address">Address
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="address" value="{{ Auth::user()->address }}" id="user-address" class="text-field" placeholder="Address">
                            <p id="account-address"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-city">City
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="city" value="{{ Auth::user()->city }}" id="user-city" class="text-field" placeholder="City">
                            <p id="account-city"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-state">State
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="state" value="{{ Auth::user()->state }}" id="user-state" class="text-field" placeholder="State">
                            <p id="account-state"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-country">Country
                                <span class="astk">*</span>
                            </label>
                            <select name="country" id="user-country" class="form-control" style="color: #495057">
                                <option value="">Select Country</option>
                                @foreach ($countries as $country)
                                <option value="{{ $country->country_name }}" {{
                                    (Auth::user()->country==$country['country_name']) ? 'selected' : '' }}>{{
                                    $country->country_name }}</option>
                                @endforeach
                            </select>
                            <p id="account-country"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="user-pincode">Pincode
                                <span class="astk">*</span>
                            </label>
                            <input type="text" name="pincode" value="{{ Auth::user()->pincode }}" id="user-pincode" class="text-field" placeholder="Pincode">
                            <p id="account-pincode"></p>
                        </div>
                        
                        <div class="m-b-45">
                            <button class="button button-outline-secondary w-100">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Account Details /- -->
            <!-- Account Password -->
            <div class="col-lg-6">
                <div class="reg-wrapper">
                    <h2 class="account-h2 u-s-m-b-20" style="font-size: 18px">Update Password</h2>
                    <div id="password-success"></div>
                    <div id="password-error"></div>
                    <form id="passwordForm" action="javascript:;" method="POST">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="current-password">Current Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="current_password" id="current-password" class="text-field"
                                placeholder="Current Password">
                            <p id="password-current_password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="new-password">New Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="new_password" id="new-password" class="text-field"
                                placeholder="New Password">
                            <p id="password-new_password"></p>
                        </div>
                        <div class="u-s-m-b-30">
                            <label for="confirm-password">Confirm Password
                                <span class="astk">*</span>
                            </label>
                            <input type="password" name="confirm_password" id="confirm-password" class="text-field"
                                placeholder="Confirm Password">
                            <p id="password-confirm_password"></p>
                        </div>
                        
                        <div class="u-s-m-b-45">
                            <button class="button button-primary w-100">Update Password</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Account Password /- -->
        </div>
    </div>
</div>
<!-- Account-Page /- -->
@endsection