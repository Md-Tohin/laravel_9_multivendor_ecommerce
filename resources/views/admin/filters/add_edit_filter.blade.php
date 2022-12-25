@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold">Filters</h4>
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
                                action="@if (empty($filter['id'])) {{ url('admin/add-edit-filter') }} @else {{ url('admin/add-edit-filter/' . $filter['id']) }} @endif"
                                method="POST" enctype="multipart/form-data" class="forms-sample">
                                @csrf
                                <div class="form-group">
                                    <label for="cat_ids">Select Catgory</label>
                                    <select name="cat_ids[]" id="cat_ids" multiple class="form-control" style="color: #495057; height: 200px;"
                                        required>
                                        <option value=""> Select </option>
                                        @foreach ($categories as $section)
                                            <optgroup label="{{ $section['name'] }}"></optgroup>
                                            @foreach ($section['categories'] as $category)
                                                <option @if(!empty($filter['cat_ids'] == $category['id']) ) selected="" @endif value="{{ $category['id'] }}">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; --&nbsp;&nbsp;{{ $category['category_name'] }}</option>
                                                @foreach ($category['sub_categories'] as $subcategory)
                                                    <option @if(!empty($filter['cat_ids'] == $subcategory['id']) ) selected="" @endif value="{{ $subcategory['id'] }}" >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;&nbsp;{{ $subcategory['category_name'] }}</option>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group">
                                    <label for="filter_name">Filter Name</label>
                                    <input type="text" class="form-control" name="filter_name" id="filter_name"
                                        @if (empty($filter['id'])) value="{{ old('filter_name') }}" @else value="{{ $filter['filter_name'] }}" @endif
                                        placeholder="Enter Filter Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="filter_column">Filter Column</label>
                                    <input type="text" class="form-control" name="filter_column" id="filter_column"
                                        @if (empty($filter['id'])) value="{{ old('filter_column') }}" @else value="{{ $filter['filter_column'] }}" @endif
                                        placeholder="Enter Filter Column" required>
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
