@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Settings</h3>
                    <br>
                </div>
                <div class="col-md-6 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Update Admin Details</h4>

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

                            <form action="{{ url('admin/update-admin-details') }}" method="POST" enctype="multipart/form-data" class="forms-sample">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Admin Username/Email</label>
                                    <input type="text" class="form-control" name="email" id="email"
                                        value="{{ $adminDetails['email'] }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="type">Admin Type</label>
                                    <input type="text" class="form-control" name="type" id="type"
                                        value="{{ $adminDetails['type'] }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" name="name"
                                        id="name" value="{{ Auth::guard('admin')->user()->name }}" placeholder="Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="mobile">Mobile</label>
                                    <input type="text" class="form-control" name="mobile" id="mobile"
                                        value="{{ Auth::guard('admin')->user()->mobile }}" placeholder="Mobile" required>
                                </div>

                                <div class="form-group">
                                    <label for="image">Admin Photo</label>
                                    <input type="file" class="form-control" name="image" id="image"
                                        placeholder="Mobile">
                                        @if(!empty(Auth::guard('admin')->user()->image))
                                            <a href="{{ url('admin/images/photos/'.Auth::guard('admin')->user()->image) }}" target="_blank">View Image</a>
                                            <input type="hidden" name="current_image" value="{{ Auth::guard('admin')->user()->image }}">
                                        @endif
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
