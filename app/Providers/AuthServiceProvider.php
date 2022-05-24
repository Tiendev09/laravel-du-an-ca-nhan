<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        //Users
        Gate::define('user-list', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.list-user'));
        });
        Gate::define('user-add', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.add-user'));
        });
        Gate::define('user-edit', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.edit-user'));

        });
        Gate::define('user-delete', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.delete-user'));
        });
        //Product Categories
        Gate::define('product-cat-list', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.list-product-categories'));
        });
        Gate::define('product-cat-edit', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.edit-product-categories'));
        });
        Gate::define('product-cat-add', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.add-product-categories'));
        });
        Gate::define('product-cat-delete', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.delete-product-categories'));
        });
        //Products
        Gate::define('product-list','App\Policies\ProductPolicy@view');
        Gate::define('product-add','App\Policies\ProductPolicy@create');
        Gate::define('product-edit','App\Policies\ProductPolicy@update');
        Gate::define('product-delete','App\Policies\ProductPolicy@delete');
        //Posts
        Gate::define('list-post', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.list-post'));
        });
        Gate::define('post-cat', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.post-cat'));
        });
        Gate::define('add-post', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.add-post'));
        });
        Gate::define('edit-post', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.edit-post'));
        });
        Gate::define('delete-post', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.delete-post'));
        });
        Gate::define('grand-permission-user', function ($user) {
            return $user->checkPermissionAccess(config('permissions.access.grand-permission-user'));
        });
        //Pages
        Gate::define('list-page','App\Policies\PagePolicy@view');
        Gate::define('add-page','App\Policies\PagePolicy@create');
        Gate::define('edit-page','App\Policies\PagePolicy@update');
        Gate::define('delete-page','App\Policies\PagePolicy@delete');
        //Order
        Gate::define('list-order','App\Policies\OrderPolicy@view');
        Gate::define('delete-order','App\Policies\OrderPolicy@delete');
        Gate::define('update-order','App\Policies\OrderPolicy@update');
        Gate::define('detail-order','App\Policies\OrderPolicy@detail');
        //Slide
        Gate::define('list-slide','App\Policies\SlidePolicy@view');
        Gate::define('delete-slide','App\Policies\SlidePolicy@delete');
        Gate::define('add-slide','App\Policies\SlidePolicy@create');
        //Role
        Gate::define('list-role','App\Policies\RolePolicy@view');
        Gate::define('add-role','App\Policies\RolePolicy@create');
        Gate::define('edit-role','App\Policies\RolePolicy@update');
        Gate::define('delete-role','App\Policies\RolePolicy@delete');
        //Permission
        Gate::define('list-permission', 'App\Policies\PermissionPolicy@view');
        Gate::define('delete-permission', 'App\Policies\PermissionPolicy@delete');
        //Brands
        Gate::define('list-brand', 'App\Policies\BrandPolicy@view');
        Gate::define('add-brand', 'App\Policies\BrandPolicy@add');
        Gate::define('delete-brand','App\Policies\BrandPolicy@delete');
    }
}
