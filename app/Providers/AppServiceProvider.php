<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
 public function boot()
{
    if (!file_exists(public_path('engineering_storage'))) {
        $target = base_path('../engineering/storage/app/public');
        $link = public_path('engineering_storage');

        try {
            symlink($target, $link);
        } catch (\Throwable $e) {
            \Log::error("Gagal membuat symlink: " . $e->getMessage());
        }
        
    }
    }
}
