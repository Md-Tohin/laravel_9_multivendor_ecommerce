<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item">
            <a @if (Session::get('page') == 'dashboard') style="background: #4B49AC !important; color: #fff !important;" @endif
                class="nav-link" href="{{ url('admin/dashboard') }}">
                <i class="icon-grid menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @if (Auth::guard('admin')->user()->type == 'vendor')
            <li class="nav-item">
                <a @if (Session::get('page') == 'vendor_personal' || Session::get('page') == 'vendor_business' || Session::get('page') == 'vendor_bank') style="background: #4B49AC !important; color: #fff !important;" @endif
                    class="nav-link" data-toggle="collapse" href="#ui-vendor" aria-expanded="false"
                    aria-controls="ui-vendor">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Vendor Details</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-vendor">
                    <ul class="nav flex-column sub-menu"
                        style="background: #fff !important; color: #4B49AC !important;">
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'vendor_personal') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/update-vendor-details/personal') }}">Personal
                                Details</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'vendor_business') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/update-vendor-details/business') }}">Business
                                Details</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'vendor_bank') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/update-vendor-details/bank') }}">Bank Details</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a @if (Session::get('page') == 'section' || Session::get('page') == 'categories' || Session::get('page') == 'products' || Session::get('page') == 'filters') style="background: #4B49AC !important; color: #fff !important;" @endif
                    class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false"
                    aria-controls="ui-catalogue">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Catalogue Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-catalogue">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'products') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/products') }}">Products</a>
                        </li>
                    </ul>
                </div>
            </li>
        @else
            <li class="nav-item">
                <a @if (Session::get('page') == 'update_admin_details' || Session::get('page') == 'update_admin_password') style="background: #4B49AC !important; color: #fff !important;" @endif
                    class="nav-link" data-toggle="collapse" href="#ui-setting" aria-expanded="false"
                    aria-controls="ui-setting">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Settings</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-setting">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important">
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'update_admin_password') style="background: #4B49AC !important; color:#fff !important" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/update-admin-password') }}">Update
                                Password</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'update_admin_details') style="background: #4B49AC !important; color:#fff !important" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/update-admin-details') }}">Update
                                Details</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a @if (Session::get('page') == 'admin' || Session::get('page') == 'vendor' || Session::get('page') == 'subadmin' || Session::get('page') == 'view_all') style="background: #4B49AC !important; color:#fff !important" @endif
                    class="nav-link" data-toggle="collapse" href="#ui-admin" aria-expanded="false"
                    aria-controls="ui-admin">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Admin Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-admin">
                    <ul class="nav flex-column sub-menu"
                        style="background: #fff !important; color: #4B49AC !important;">
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'admin') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/admins/admin') }}">Admins</a>
                        </li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'subadmin') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/admins/subadmin') }}">Subadmins</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'vendor') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/admins/vendor') }}">Vendors</a>
                        </li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'view_all') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/admins') }}">All</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="collapse" href="#ui-user" aria-expanded="false"
                    aria-controls="ui-user">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">User Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-user">
                    <ul class="nav flex-column sub-menu">
                        <li class="nav-item"> <a class="nav-link" href="">Users</a></li>
                        <li class="nav-item"> <a class="nav-link" href="">Subscribers</a></li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a @if (Session::get('page') == 'section' || Session::get('page') == 'categories' || Session::get('page') == 'products' || Session::get('page') == 'filters') style="background: #4B49AC !important; color: #fff !important;" @endif
                    class="nav-link" data-toggle="collapse" href="#ui-catalogue" aria-expanded="false"
                    aria-controls="ui-catalogue">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Catalogue Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-catalogue">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important;">
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'section') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/sections') }}">Section</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'categories') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/categories') }}">Categories</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'brands') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/brands') }}">Brands</a></li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'products') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/products') }}">Products</a>
                        </li>
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'filters') style="background: #4B49AC !important; color: #fff !important;" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/filters') }}">Filters</a>
                        </li>

                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a @if (Session::get('page') == 'banners' || Session::get('page') == 'sliders') style="background: #4B49AC !important; color: #fff !important;" @endif
                    class="nav-link" data-toggle="collapse" href="#ui-banner" aria-expanded="false"
                    aria-controls="ui-banner">
                    <i class="icon-layout menu-icon"></i>
                    <span class="menu-title">Banner Management</span>
                    <i class="menu-arrow"></i>
                </a>
                <div class="collapse" id="ui-banner">
                    <ul class="nav flex-column sub-menu" style="background: #fff !important; color: #4B49AC !important">
                        <li class="nav-item"> <a
                                @if (Session::get('page') == 'sliders') style="background: #4B49AC !important; color:#fff !important" @else style="background: #fff !important; color: #4B49AC" @endif
                                class="nav-link" href="{{ url('admin/banners') }}">Home Page
                                Banner</a></li>

                    </ul>
                </div>
            </li>
        @endif

        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#form-elements" aria-expanded="false"
                aria-controls="form-elements">
                <i class="icon-columns menu-icon"></i>
                <span class="menu-title">Form elements</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="form-elements">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item"><a class="nav-link" href="pages/forms/basic_elements.html">Basic
                            Elements</a></li>
                </ul>
            </div>
        </li>

    </ul>
</nav>
