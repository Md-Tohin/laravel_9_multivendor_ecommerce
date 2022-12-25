@extends('admin.layout.layout')
@section('content')
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                    <h4 class="font-weight-bold">Categories</h4>
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
                                action="@if (empty($category['id'])) {{ url('admin/add-edit-category') }} @else {{ url('admin/add-edit-category/' . $category['id']) }} @endif"
                                method="POST" enctype="multipart/form-data" class="forms-sample">
                                @csrf

                                <div class="form-group">
                                    <label for="category_name">Category Name</label>
                                    <input type="text" class="form-control" name="category_name" id="category_name"
                                        @if (empty($category['id'])) value="{{ old('category_name') }}" @else value="{{ $category['category_name'] }}" @endif
                                        placeholder="Enter Category Name" required>
                                </div>
                                <div class="form-group">
                                    <label for="section_id">Select Section</label>
                                    <select name="section_id" id="section_id" class="form-control" style="color: #495057"
                                        required>
                                        <option value=""> -- Choose One --</option>
                                        @foreach ($getSections as $section)
                                            <option value="{{ $section['id'] }}"
                                                {{ $category['section_id'] == $section['id'] && !empty($category['section_id']) ? 'selected' : '' }}>
                                                {{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div id="appendCategoriesLavel">
                                    @include('admin.categories.append_categories_lavel')
                                </div>

                                <div class="form-group">
                                    <label for="category_image">Category Image</label>
                                    <input type="file" class="form-control" name="category_image" id="category_image"
                                        @if (empty($category['id'])) value="{{ old('category_image') }}" @else value="{{ $category['category_image'] }}" @endif
                                        placeholder="Enter Category Name">
                                    @if (!empty($category['category_image']))
                                        <a href="{{ url('front/images/category_images/' . $category['category_image']) }}"
                                            target="_blank">View Image</a> &nbsp; &nbsp;|&nbsp;
                                            <a href="javascript:void(0)" class="confirmDelete" module="category-image" moduleId="{{ $category['id'] }}"> Delete Image</a>
                                        <input type="hidden" name="current_image"
                                            value="{{ $category['category_image'] }}">

                                    @endif

                                </div>
                                <div class="form-group">
                                    <label for="category_discount">Category Discount</label>
                                    <input type="text" class="form-control" name="category_discount"
                                        id="category_discount"
                                        @if (empty($category['id'])) value="{{ old('category_discount') }}" @else value="{{ $category['category_discount'] }}" @endif
                                        placeholder="Enter Category Discount">
                                </div>
                                <div class="form-group">
                                    <label for="category_name">Category Description</label>
                                    <textarea name="description" id="description" class="form-control" cols="30" rows="3"
                                        placeholder="Enter Category Description">
                                                @if (empty($category['id']))
{{ old('description') }}
@else
{{ $category['description'] }}
@endif
                                            </textarea>
                                </div>
                                <div class="form-group">
                                    <label for="url">Category URL</label>
                                    <input type="text" class="form-control" name="url" id="url"
                                        @if (empty($category['id'])) value="{{ old('url') }}" @else value="{{ $category['url'] }}" @endif
                                        placeholder="Enter Category URL" required>
                                </div>
                                <div class="form-group">
                                    <label for="meta_title">Meta Title</label>
                                    <input type="text" class="form-control" name="meta_title" id="meta_title"
                                        @if (empty($category['id'])) value="{{ old('meta_title') }}" @else value="{{ $category['meta_title'] }}" @endif
                                        placeholder="Enter Mete Title">
                                </div>
                                <div class="form-group">
                                    <label for="meta_description">Meta Description</label>
                                    <input type="text" class="form-control" name="meta_description" id="meta_description"
                                        @if (empty($category['id'])) value="{{ old('meta_description') }}" @else value="{{ $category['meta_description'] }}" @endif
                                        placeholder="Enter Meta Description">
                                </div>
                                <div class="form-group">
                                    <label for="meta_keywords">Meta Keywords</label>
                                    <input type="text" class="form-control" name="meta_keywords" id="meta_keywords"
                                        @if (empty($category['id'])) value="{{ old('meta_keywords') }}" @else value="{{ $category['meta_keywords'] }}" @endif
                                        placeholder="Meta Keywords">
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
