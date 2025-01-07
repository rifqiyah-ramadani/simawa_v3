<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use App\Policies\RolePolicy;
use Spatie\Permission\Models\Permission as SpatiePermission;
use App\Models\Permission;
use App\Models\BuatPendaftaranBeasiswa;
use App\Observers\BuatPendaftaranObserver;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         // Bind Spatie's Permission model to the custom Permission model
        $this->app->bind(SpatiePermission::class, Permission::class);
    }

    /**
     * Bootstrap any application services.
     */
    protected $policies = [
        Role::class => RolePolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot()
    {
        $this->registerPolicies();

        // Define abilities using Gate
        Gate::define('create role', function ($user) {
            return $user->hasRole('super_admin'); // Contoh: hanya admin yang bisa membuat role
        });

        Gate::define('read role', function ($user) {
            return $user->hasRole('super_admin');
        });

        // BuatPendaftaranBeasiswa::observe(BuatPendaftaranObserver::class);
   }
}
