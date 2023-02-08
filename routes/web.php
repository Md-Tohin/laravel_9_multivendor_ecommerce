<?php

use Illuminate\Support\Facades\Route;
use App\Models\Category;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');


Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->group(function(){

    //  =================================  Admin Route  =============================
    //  Admin Login Route
    Route::match(['get', 'post'], 'login', 'AdminController@login');
    Route::group(['middleware'=>['admin']],function(){
        //  Admin Dashboard Route
        Route::get('dashboard', 'AdminController@dashboard');
        //  Update Admin Password
        Route::match(['get', 'post'], 'update-admin-password','AdminController@updateAdminPassword');
        //  Check Admin Password Call by Ajax
        Route::post('check-admin-password', 'AdminController@checkAdminPassword');
        //  Update Admin Details
        Route::match(['get', 'post'], 'update-admin-details','AdminController@updateAdminDetails');
        //  Update Vendor Details
        Route::match(['get', 'post'], 'update-vendor-details/{slug}', 'AdminController@updateVendorDetails');
        //  View Admins / Subadmins / Vendors
        Route::get('admins/{type?}', 'AdminController@admins');
        //  View Vendor Details
        Route::get('view-vendor-details/{id}', 'AdminController@viewVendorDetails');
        //  Update Admin Status By Ajax
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');

        //  ============================  Section Route ==================================
        //  View Section
        Route::get('sections', 'SectionController@sections');
        //  Update Section Status By Ajax
        Route::post('update-section-status', 'SectionController@updateSectionStatus');
        //  Delete Section
        Route::get('delete-section/{id}', 'SectionController@deleteSection');
        //  Add Edit Section 
        Route::match(['get','post'], 'add-edit-section/{id?}', 'SectionController@addEditSection');

        //  ============================  Brand Route ==================================
        //  View Brands
        Route::get('brands', 'BrandController@brandns');
        //  Update Brand Status By Ajax
        Route::post('update-brand-status', 'BrandController@updateBrandStatus');
        //  Delete Brand
        Route::get('delete-brand/{id}', 'BrandController@deleteBrand');
        //  Add Edit Brand 
        Route::match(['get','post'], 'add-edit-brand/{id?}', 'BrandController@addEditBrand');

        //  ============================  Category Route ==================================
        //  View Category
        Route::get('categories', 'CategoryController@categories');
        //  Add Edit Category
        Route::match(['get', 'post'], 'add-edit-categories/{id?}', 'CategoryController@addEditCategory');
        //  Update Category Status
        Route::post('update-category-status', 'CategoryController@updateCategoryStatus');
        //  Delete Category
        Route::get('delete-category/{id}', 'CategoryController@deleteCategory');
        //  Add Edit Category 
        Route::match(['get','post'], 'add-edit-category/{id?}', 'CategoryController@addEditCategory');
        //  Add Edit Category 
        Route::get('append-categories-lavel', 'CategoryController@appendCategoriesLevel');
        //  Category Image Delete
        Route::get('delete-category-image/{id}', 'CategoryController@deleteCategoryImage');

         //  ============================  Product Route ==================================
        //  View Products
        Route::get('products', 'ProductController@products');
        //  Update Product Status By Ajax
        Route::post('update-product-status', 'ProductController@updateProductStatus');
        //  Delete Product
        Route::get('delete-product/{id}', 'ProductController@deleteProduct');
        //  Add Edit Product 
        Route::match(['get','post'], 'add-edit-product/{id?}', 'ProductController@addEditProduct');
        //  Delete Product Image
        Route::get('delete-product-image/{id}', 'ProductController@deleteProductImage');
        //  Delete Product Video
        Route::get('delete-product-video/{id}', 'ProductController@deleteProductVideo');

         //  ============================  Banner Route ==================================
        //  View Banner
        Route::get('banners', 'BannerController@banners');
        //  Update Banner Status By Ajax
        Route::post('update-banner-status', 'BannerController@updateBannerStatus');
        //  Delete Banner
        Route::get('delete-banner/{id}', 'BannerController@deleteBanner');
        //  Delete Banner Image
        Route::get('delete-banner-image/{id}', 'BannerController@deleteBannerImage');
        //  Add Edit Banner 
        Route::match(['get','post'], 'add-edit-banner/{id?}', 'BannerController@addEditBanner');

        //  Coupon Routes
        Route::get('coupons', 'CouponController@coupons');
        Route::post('update-coupon-status', 'CouponController@updateCouponStatus');
        Route::get('delete-coupon/{id}', 'CouponController@deleteCoupon');
        Route::match(['get', 'post'], 'add-edit-coupon/{id?}', 'CouponController@addEditCoupon');

        //  Attributes 
        Route::match(['get', 'post'], 'add-edit-attributes/{id?}', 'ProductController@addEditAttributes');
        Route::post('update-attribute-status', 'ProductController@updateAttributeStatus');
        Route::match(['get', 'post'], 'edit-attribute/{id}', 'ProductController@editAttributes');
        Route::get('delete-attribute/{id}', 'ProductController@deleteAttribute');

        // Filters
        Route::get('filters', 'FilterController@filters');
        Route::post('update-filter-status', 'FilterController@updateFilterStatus');
        Route::match(['get','post'], 'add-edit-filter/{id?}', 'FilterController@addEditFilter');
        Route::post('category-filters', 'FilterController@categoryFilters');

        // Filters Values
        Route::get('filters-values', 'FilterController@filtersValues');
        Route::post('update-filter-value-status', 'FilterController@updateFilterValueStatus');
        Route::match(['get','post'], 'add-edit-filter-value/{id?}', 'FilterController@addEditFilterValue'); 
        Route::get('delete-filter-value/{id}', 'FilterController@deleteFilterValue');       

        //  Multi Images
        Route::match(['get', 'post'], 'add-images/{id}', 'ProductController@addImages');
        Route::post('update-image-status', 'ProductController@updateImageStatus');
        Route::get('delete-image/{id}', 'ProductController@deleteImage');

        //  Admin Logout Route
        Route::get('logout', 'AdminController@logout');

        //  Users Routes
        Route::get('users', 'UserController@users');
        Route::post('update-user-status', 'UserController@updateUserStatus');
    });   

});

//  Front Route
Route::namespace('App\Http\Controllers\Front')->group(function () {
    Route::get('/', 'IndexController@index');

    //  Listing/Categories Route
    $catUrls = Category::select('url')->where('status', 1)->get()->pluck('url')->toArray();
    foreach ($catUrls as $key => $url) {
        Route::match(['get', 'post'],'/'.$url, 'ProductsController@listing');
    }

    //  Product Details page
    Route::get('/product/{id}', 'ProductsController@detail');
    //  Get Product Attribute price
    Route::post('/get-product-price', 'ProductsController@getProductPrice');

    //  Vendor Products 
    Route::get('/products/{vendorId}', 'ProductsController@vendorListingProduct');

    //  Vendor Login / Register
    Route::get('/vendor/login-register', 'VendorController@loginRegister');
    Route::post('/vendor/register', 'VendorController@vendorRegister');

    //  confirm vendor Account
    Route::get('vendor/confirm/{code}', 'VendorController@confirmVendor');

    //  Cart Add
    Route::post('/cart/add', 'ProductsController@cartAdd');

    //  Cart Route 
    Route::get('/cart', 'ProductsController@cart');

    //  Cart Update
    Route::post('cart/update', 'ProductsController@cartUpdate');

    //  Cart Delete
    Route::post('cart/delete', 'ProductsController@cartDelete');

    //  User Login / Register
    Route::get('user/login-register', 'UserController@loginRegister')->name('user.login-register');
    // Route::get('user/login-register', ['as' => 'login', 'uses' => 'UserController@loginRegister']);

    //  User Register
    Route::post('user/register', 'UserController@userRegister');

    //  User Login
    Route::post('user/login', 'UserController@userLogin');

    // User Forgot Password
    Route::match(['get', 'post'], 'user/forgot-password', 'UserController@forgotPassword');

    //  User Logout
    Route::get('user/logout', 'UserController@userLogout');

    //  Confirm User Account
    Route::get('user/confirm/{code}', 'UserController@confirmAccount');

    Route::group(['middleware' => ['auth']], function(){   
        //  User Account 
        Route::match(['get', 'post'], '/user/account', 'UserController@userAccount');

        //  User Update Password 
        Route::post('/user/update-password', 'UserController@updatePassword');

        //  Apply Coupon
        Route::post('apply-coupon', 'ProductsController@applyCoupon');
    });

});



require __DIR__.'/auth.php';
