<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('access-superadmin', fn (User $user): bool => $user->role === 'Super Admin');
        Gate::define('access-admin', fn (User $user): bool => $user->role === 'Admin');
        Gate::define('access-barang-export', fn (User $user): bool => in_array($user->role, ['Admin', 'Super Admin'], true));
    }
}
