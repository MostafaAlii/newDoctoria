<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Services\Otp\{OtpServiceManager};
class OtpServiceProvider extends ServiceProvider {
    public function register() {
        $this->app->singleton(OtpServiceManager::class, function ($app) {
            return new OtpServiceManager();
        });
    }

    public function boot()
    {
        //
    }
}
