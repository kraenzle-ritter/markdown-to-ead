<?php

namespace KraenzleRitter\MarkdownToEad\Tests;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  \Illuminate\Foundation\Application  $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            'KraenzleRitter\MarkdownToEad\MarkdownToEadServiceProvider',
        ];
    }
}
