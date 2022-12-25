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
                                action="@if (empty($filter['id'])) {{ url('admin/add-edit-filter-value') }} @else {{ url('admin/add-edit-filter-value/' . $filter['id']) }} @endif"
                                method="POST" class="forms-sample">
                                @csrf
                                <div class="form-group">
                                    <label for="filter_id">Select Filter Column</label>
                                    <select name="filter_id" id="filter_id" class="form-control"
                                        style="color: #495057;" required>
                                        <option value=""> Select </option>
                                        @foreach ($filters as $value)
                                            <option 
                                            @if (!empty($value['id'] == $filter['filter_id'])) selected="" @endif
                                                value="{{ $value['id'] }}">{{ $value['filter_name'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="filter_value">Filter Value</label>
                                    <input type="text" class="form-control" name="filter_value" id="filter_value"
                                        @if (empty($filter['id'])) value="{{ old('filter_value') }}" @else value="{{ $filter['filter_value'] }}" @endif
                                        placeholder="Enter Filter Value" required>
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
