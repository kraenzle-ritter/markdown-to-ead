<?php

namespace KraenzleRitter\MarkdownToEad;

use Illuminate\Support\ServiceProvider;

class MarkdownToEadServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(): void
    {
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register(): void
    {
        // Register the service the package provides.
        $this->app->singleton('markdown-to-ead', function ($app) {
            return new MarkdownToEad;
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['markdown-to-ead'];
    }
}
