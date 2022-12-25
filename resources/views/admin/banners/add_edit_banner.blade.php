@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h3 class="font-weight-bold">Hpme Page Banners</h3>
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
                                action="@if (empty($banner['id'])) {{ url('admin/add-edit-banner') }} @else {{ url('admin/add-edit-banner/' . $banner['id']) }} @endif"
                                method="POST" enctype="multipart/form-data" class="forms-sample">
                                @csrf

                                <div class="form-group">
                                    <label for="type">Banner Type</label>
                                    <select class="form-control text-dark" name="type" id="type">
                                        <option value="">Select</option>
                                        <option value="Slider" @if(!empty($banner['type']) && ($banner['type'] == "Slider")) selected="" @endif>Slider</option>
                                        <option value="Fix" @if(!empty($banner['type']) && ($banner['type'] == "Fix")) selected="" @endif>Fix</option>
                                    </select>
                                    {{-- <input type="text" class="form-control" name="link" id="link"
                                        value="{{ $banner['link'] }}" placeholder="Enter Banner Link" required> --}}
                                </div>
                            
                                <div class="form-group">
                                    <label for="image">Banner Image</label>
                                    <input type="file" class="form-control" name="image" id="image">
                                    @if (!empty($banner->image))
                                        <a href="{{ url('front/images/banner_images/'.$banner['image']) }}"
                                            target="_blank">View Image</a> &nbsp; &nbsp;|&nbsp;
                                        <a href="javascript:void(0)" class="confirmDelete" module="banner-image"
                                            moduleId="{{ $banner['id'] }}"> Delete Image</a>
                                        <input type="hidden" name="current_image" value="{{ $banner->image }}">
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="link">Banner Link</label>
                                    <input type="text" class="form-control" name="link" id="link"
                                        value="{{ $banner['link'] }}" placeholder="Enter Banner Link" required>
                                </div>
                                <div class="form-group">
                                    <label for="title">Banner Title</label>
                                    <input type="text" class="form-control" name="title" id="title"
                                        value="{{ $banner['title'] }}" placeholder="Enter Banner Title" required>
                                </div>
                                <div class="form-group">
                                    <label for="alt">Banner Alternate Text</label>
                                    <input type="text" class="form-control" name="alt" id="alt"
                                        value="{{ $banner['alt'] }}" placeholder="Enter Banner Alternate Text" required>
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
