<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\peminjaman;
use App\Policies\PeminjamanPolicy;

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
        Gate::define('kelola-buku', function ($user) {
            return $user->hasRole(['admin', 'petugas']);
        });
        Gate::policy(peminjaman::class, PeminjamanPolicy::class);
    }
}
