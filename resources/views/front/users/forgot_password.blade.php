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
            <div class="col-md-12">
                @if (Session::has('success_message'))
                <div class="alert alert-success alert-dismissible fade show mx-auto mb-5" role="alert">
                    <strong>Success:</strong> {{ Session::get('success_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if (Session::has('error_message'))
                <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                    <strong>Error:</strong> {{ Session::get('error_message') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mb-5" role="alert">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            <!-- Forgot password -->
            <div class="col-lg-6">
                <div class="login-wrapper">
                    <h2 class="account-h2 u-s-m-b-20">Forgot password</h2>
                    <h6 class="account-h6 u-s-m-b-30">Welcome back! Forgot password to your account.</h6>
                    <div id="forgot-error"></div>
                    <form action="javascript:;" method="POST" id="forgotPasswordForm">
                        @csrf
                        <div class="u-s-m-b-30">
                            <label for="user-email">Email
                                <span class="astk">*</span>
                            </label>
                            <input type="email" name="email" id="user-email" class="text-field" placeholder="Email">
                            <p id="forgot-email"></p>
                        </div>
                        <div class="group-inline u-s-m-b-30">                            
                            <div class="group-2 text-right">
                                <div class="page-anchor">
                                    <a href="{{ url('user/login-register') }}">
                                        <i class="fas fa-circle-o-notch u-s-m-r-9"></i>Back to Login</a>
                                </div>
                            </div>
                        </div>
                        <div class="m-b-45">
                            <button type="submit" class="button button-outline-secondary w-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- Login /- -->
           
        </div>
    </div>
</div>
<!-- Account-Page /- -->
@endsection