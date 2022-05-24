<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


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
//Frontend
Route::get('/','IndexController@show');

Route::get('gioi-thieu','IndexController@about');
Route::get('lien-he','IndexController@contact');
Route::get('/24h-cong-nghe','IndexController@blog');
Route::get('/24h-cong-nghe/chi-tiet-bai-viet/{id}','IndexController@detail')->name('detail_blog');

Route::get('/danh-muc-san-pham/{slug}','IndexController@product')->name('product_cat');
Route::get('/danh-muc-san-pham/{cat_slug}/{slug}','IndexController@brand')->name('brand');
Route::get('/chi-tiet-san-pham/{slug}','IndexController@detail_product')->name('detail_product');
Route::get('/chi-tiet-gio-hang','CartController@show')->name('cart.show');
Route::get('/loc-san-pham/{slug}','ProductController@action')->name('product.action');
Route::get('/loc-san-pham/{cat_slug}/{slug}','ProductController@action_brand')->name('product.action.brand');
Route::get('/loc-san-pham-theo-gia/{slug}','ProductController@action_price')->name('product.action.price');
Route::get('/cart/add/{slug}','CartController@add')->name('cart.add');
Route::get('/add-to-cart/{slug}','CartController@add_cart_ajax')->name('add.cart');
Route::get('/cart/delete/{rowId}','CartController@delete')->name('cart.delete');
Route::get('/cart/destroy','CartController@destroy');
Route::post('/cart/update','CartController@update')->name('cart.update');
Route::post('/cart_ajax','CartController@cart_ajax')->name('cart.ajax');
Route::get('/checkout','CartController@checkout');
Route::post('/checkout/detail_order','CartController@store');
Route::get('/checkout/last','CartController@add_detail_order');
Route::get('/buy_now/last/{slug}','CartController@add_buy_now_detail_order')->name('buy_now_last');
// Route::get('/checkout/last','CartController@add_detail_order');
Route::get('/buy_now/{slug}','CartController@buy_now')->name('buy_now');
Route::post('/store_buy_now/{slug}','CartController@store_buy_now')->name('store_buy_now');
Route::get('/search','IndexController@search')->name('search');

// Auth::routes();
//Backend
// Route::get('/home', 'HomeController@index')->name('home');
Auth::routes();
Route::middleware(['auth'])->group(function () {
   //Admin users
   Route::get('/dashboard','DashboardController@show')->middleware('auth');
   Route::get('/admin','DashboardController@show');
   Route::get('admin/user/list','AdminUserController@list');
   Route::get('admin/user/add','AdminUserController@add')->middleware('can:user-add');
   Route::post('admin/user/store','AdminUserController@store');
   Route::get('admin/user/delete/{id}','AdminUserController@delete')->name('delete_user')->middleware('can:user-delete');
   Route::get('admin/user/forceDelete/{id}','AdminUserController@forceDelete')->name('forceDelete');
   Route::get('admin/user/action','AdminUserController@action')->middleware('can:user-list');
   Route::get('admin/user/edit/{id}','AdminUserController@edit')->name('admin.user.edit')->middleware('can:user-edit');
   Route::get('admin/user/edit-info/{id}','AdminUserController@edit_info')->name('admin.user.edit_info');
   Route::post('admin/user/update-info/{id}','AdminUserController@update_info')->name('admin.user.update_info');
   Route::get('admin/user/restore/{id}','AdminUserController@restore')->name('admin.user.restore');
   Route::post('admin/user/update/{id}','AdminUserController@update')->name('admin.user.update');
   Route::get('admin/user/grant-permission/{id}','AdminUserController@permission')->name('admin.user.permission')->middleware('can:grand-permission-user');
   Route::post('admin/user/update-permission/{id}','AdminUserController@updatePermission')->name('admin.user.update.permission');
   //Roles
   Route::get('admin/role/add','AdminRoleController@add')->middleware('can:add-role');
   Route::get('admin/role/edit/{id}','AdminRoleController@edit')->name('admin.role.edit')->middleware('can:edit-role');
   Route::post('admin/role/update/{id}','AdminRoleController@update')->name('admin.role.update');
   Route::get('admin/role/delete/{id}','AdminRoleController@delete')->name('admin.role.delete');
   Route::get('admin/permission/list','AdminPermissionController@list')->middleware('can:list-permission');
   Route::post('admin/permission/store','AdminPermissionController@store');
   Route::post('admin/role/store','AdminRoleController@store');
   Route::get('admin/role/list','AdminRoleController@show')->middleware('can:list-role');

   //Admin posts
   Route::get('admin/post/list','AdminPostController@show')->middleware('can:list-post');
   Route::get('admin/post/add','AdminPostController@add')->middleware('can:add-post');
   Route::post('admin/post/store','AdminPostController@store');
   Route::get('admin/post/cat/list','AdminPostCatsController@list')->middleware('can:post-cat');
   Route::post('admin/post/cat/add','AdminPostCatsController@add')->name('post.cat.add')->middleware('can:post-cat');
   Route::get('admin/post/delete/{id}','AdminPostController@delete')->name('admin.post.delete')->middleware('can:delete-post');
   Route::get('admin/post/force-delete/{id}','AdminPostController@force_delete')->name('admin.post.force_delete')->middleware('can:delete-post');
   Route::get('admin/post/edit/{id}','AdminPostController@edit')->name('admin.post.edit')->middleware('can:edit-post');
   Route::get('admin/post/restore/{id}','AdminPostController@restore')->name('admin.post.restore');
   Route::post('admin/post/update/{id}','AdminPostController@update')->name('admin.post.update');
   Route::get('admin/post/action','AdminPostController@action');
   //Admin product categories
   Route::get('admin/product/cat/list','AdminProductCatController@show')->middleware('can:product-cat-list');
   Route::post('admin/product/cat/add','AdminProductCatController@add')->middleware('can:product-cat-add');
   Route::get('admin/product/cat/delete/{id}','AdminProductCatController@delete')->name('admin.productCat.delete')->middleware('can:product-cat-delete');
   //Admin Products
   Route::get('admin/product/add','AdminProductController@add')->middleware('can:product-add');
   Route::post('admin/product/store','AdminProductController@store');
   Route::get('admin/product/list','AdminProductController@show')->middleware('can:product-list');
   Route::get('admin/product/edit/{id}','AdminProductController@edit')->name('admin.product.edit')->middleware('can:product-edit');
   Route::post('admin/product/update/{id}','AdminProductController@update')->name('admin.product.update');
   Route::get('admin/product/delete/{id}','AdminProductController@delete')->name('admin.product.delete')->middleware('can:product-delete');
   Route::get('admin/product/force-delete/{id}','AdminProductController@force_delete')->name('admin.product.force_delete')->middleware('can:product-delete');
   Route::get('admin/product/restore/{id}','AdminProductController@restore')->name('admin.product.restore');
   Route::post('admin/product/action','AdminProductController@action');
   //Admin Product brands
   Route::get('admin/product/brand/list','AdminProductController@show_brand')->middleware('can:list-brand');
   Route::post('admin/product/brand/add','AdminProductController@add_brand')->middleware('can:add-brand');
   //Admin Pages
   Route::get('admin/page/add','AdminPageController@add')->middleware('can:add-page');
   Route::get('admin/page/list','AdminPageController@show')->middleware('can:list-page');
   Route::post('admin/page/store','AdminPageController@store');
   Route::get('admin/page/detail/{id}','AdminPageController@detail')->name('admin.page.detail');
   Route::get('admin/page/delete/{id}','AdminPageController@delete')->name('admin.page.delete')->middleware('can:delete-page');
   Route::get('admin/page/force-delete/{id}','AdminPageController@force_delete')->name('admin.page.force_delete')->middleware('can:delete-page');
   Route::get('admin/page/restore/{id}','AdminPageController@restore')->name('admin.page.restore');
   Route::get('admin/page/edit/{id}','AdminPageController@edit')->name('admin.page.edit')->middleware('can:edit-page');
   Route::post('admin/page/update/{id}','AdminPageController@update')->name('admin.page.update');
   //Admin Sell
   Route::get('admin/order/list','AdminSellController@show')->middleware('can:list-order');
   Route::get('admin/order/detail/{id}','AdminSellController@detail')->name('admin.order.detail')->middleware('can:detail-order');
   Route::get('admin/order/action','AdminSellController@action');
   Route::get('admin/order/delete/{id}','AdminSellController@delete')->name('admin.order.delete')->middleware('can:delete-order');
   Route::post('admin/order/update/{id}','AdminSellController@update')->name('admin.order.update')->middleware('can:update-order');
   //Admin slide
   Route::get('admin/slide/list','AdminSlideController@show')->middleware('can:list-slide');
   Route::get('admin/slide/add','AdminSlideController@add')->middleware('can:add-slide');
   Route::post('admin/slide/store','AdminSlideController@store');
   Route::get('admin/slide/edit/{id}','AdminSlideController@edit')->name('admin.slide.edit')->middleware('can:edit-slide');
   Route::post('admin/slide/update/{id}','AdminSlideController@update')->name('admin.slide.update');
   Route::get('admin/slide/delete/{id}','AdminSlideController@delete')->name('admin.slide.delete')->middleware('can:delete-slide');
   Route::get('admin/slide/force-delete/{id}','AdminSlideController@force_delete')->name('admin.slide.force_delete')->middleware('can:delete-slide');
   Route::get('admin/slide/action','AdminSlideController@action');
   Route::get('admin/slide/restore/{id}','AdminSlideController@restore')->name('admin.slide.restore');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
