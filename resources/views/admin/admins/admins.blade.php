@extends('admin.layout.layout')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>

                        <div class="table-responsive pt-3">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>
                                            Admin ID
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Type
                                        </th>
                                        <th>
                                            Mobile
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Image
                                        </th>
                                        <th>
                                            Status
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($admins as $key => $value)
                                    <tr>
                                        <td>{{ $value['id'] }}</td>
                                        <td>{{ $value['name'] }}</td>
                                        <td>{{ $value['type'] }}</td>
                                        <td>{{ $value['mobile'] }}</td>
                                        <td>{{ $value['email'] }}</td>

                                        <td>
                                            @if (file_exists('admin/images/photos/'.$value['image']) &&
                                            !empty($value['image']))
                                            <img src="{{ url('admin/images/photos/'.$value['image']) }}"
                                                alt="profile" />
                                            @else
                                            <img src="{{ url('no-image.png') }}" alt="profile" />
                                            @endif
                                        </td>
                                        <td>
                                            @if ($value['status'] == 1)
                                            <a class="updateAdminStatus" id="admin-{{ $value['id'] }}"
                                                href="javascript:void(0)" admin_id="{{ $value['id'] }}">
                                                <i status="Active" style="font-size: 25px;"
                                                    class="mdi mdi-bookmark-check"></i>
                                            </a>
                                            @else
                                            <a class="updateAdminStatus" id="admin-{{ $value['id'] }}"
                                                href="javascript:void(0)" admin_id="{{ $value['id'] }}">
                                                <i status="Inactive" style="font-size: 25px;"
                                                    class="mdi mdi-bookmark-outline"></i>
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            @if($value['type'] == 'vendor')
                                            <a href="{{ url('admin/view-vendor-details/'.$value['id']) }}">
                                                <i style="font-size: 25px;" class="mdi mdi-file-document"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
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