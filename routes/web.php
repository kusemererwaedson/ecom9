<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// require __DIR__.'/auth.php';  


Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
    // Admin Login Route 
    Route::match(['get','post'],'login','AdminController@login');
    Route::group(['middleware'=>['admin']],function(){
        // Admin Login Route 
        Route::get('dashboard','AdminController@dashboard');
    
        //Update Admin Password
        Route::match(['get','post'],'update-admin-password','AdminController@updateAdminPassword');

        //Check Admin Password
        Route::post('check-admin-password','AdminController@checkAdminPassword');

        //Update Admin Details
        Route::match(['get','post'],'update-admin-details','AdminController@updateAdminDetails');

        //Update Vendor Details
        Route::match(['get','post'],'update-vendor-details/{slug}','AdminController@updateVendorDetails');

        // View Admins / Subadmins / Vendors
        Route::get('admins/{type?}','AdminController@admins');

        // View Vendor Details
        Route::get('view-vendor-details/{id}','AdminController@viewVendorDetails');

         // Update Admin status
         Route::post('update-admin-status','AdminController@updateAdminStatus');

        // Admin logut here
        Route::get('logout','AdminController@logout');

        //brands
        Route::get('brands','BrandController@brands');
        // Update brands status
        Route::post('update-brand-status','BrandController@updateBrandStatus');
        // Delete brands
        Route::get('delete-brand/{id}','BrandController@deleteBrandStatus');
        // Edit Section
        Route::match(['get','post'],'add-edit-brand/{id?}','BrandController@addEditBrand');

        //Sections
        Route::get('sections','SectionController@sections');
        // Update Section status
        Route::post('update-section-status','SectionController@updateSectionStatus');
        // Delete Section
        Route::get('delete-section/{id}','SectionController@deleteSectionStatus');
        // Edit Section
        Route::match(['get','post'],'add-edit-section/{id?}','SectionController@addEditSection');

        // Categories
        Route::get('categories','CategoryController@categories');
        Route::post('update-category-status','CategoryController@updateCategoryStatus');
        Route::match(['get','post'],'add-edit-category/{id?}','CategoryController@addEditCategory');
        Route::get('delete-category/{id}','CategoryController@deleteCategory');
        Route::get('delete-category-image/{id}','CategoryController@deleteCategoryImage');

        // Prpducts
        Route::get('products','ProductsController@products');
        Route::post('update-product-status','ProductsController@updateProductStatus');
        Route::get('delete-product/{id}','ProductsController@deleteProduct');
        Route::match(['get','post'],'add-edit-product/{id?}','ProductsController@addEditProduct');

        Route::get('delete-product-image/{id}','ProductsController@deleteProductImage');
        Route::get('delete-product-video/{id}','ProductsController@deleteProductVideo');

        //Attributes
        Route::match(['get','post'],'add-edit-attributes/{id?}','ProductsController@addAttributes');
        Route::post('update-attribute-status','ProductsController@updateAttributeStatus');
        Route::get('delete-attribute/{id}','ProductsController@deleteAttribute');
        Route::match(['get','post'],'edit-attributes/{id}','ProductsController@editAttributes');

        // Images
        Route::match(['get','post'],'add-images/{id}','ProductsController@addImages');
        Route::get('delete-image/{id}','ProductsController@deleteImage');
        Route::post('update-image-status','ProductsController@updateImageStatus');
    }); 
}); 

Route::namespace('App\Http\Controllers\Front')->group(function(){
    Route::get('/','IndexController@index');
});
