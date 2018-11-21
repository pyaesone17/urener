<?php

namespace App\Providers;

use App\Url;
use App\Observers\UrlObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Observe the model event changes and 
        // burst cache from the memory store like redis 
        Url::observe(UrlObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $idGenerator = $this->app->get('config')->get('urlshortener.idgenerator');
        $concreteGenerator = $idGenerator === "uuid" ? 'App\Services\UuidGenerator' : 'App\Services\ShortIdGenerator';

        $this->simpleBind([
            'App\Contracts\UrlServiceInterface' => 'App\Services\UrlService',
            'App\Contracts\IdGeneratorInterface' => $concreteGenerator,
        ]);
    }

    /**
     * Laravel container doesn't support array bindings.
     * This is just sugar syntax for bindings multiple concrete
     *
     * @return void
     */
    protected function simpleBind(array $bindings)
    {
        foreach ($bindings as $interface => $concrete) {
            $this->app->bind($interface, $concrete);
        }
    }
}
