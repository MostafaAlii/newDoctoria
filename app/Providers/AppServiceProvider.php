<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use League\Fractal\Manager;
use League\Fractal\Serializer\ArraySerializer;
class AppServiceProvider extends ServiceProvider {
    public function register(): void {

    }

    public function boot(): void {
        $this->app->singleton(Manager::class, function ($app) {
            $fractal = new Manager();
            $fractal->setSerializer(new ArraySerializer());
            return $fractal;
        });
    }
}
