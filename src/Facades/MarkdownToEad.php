<?php

namespace Ottosmops\MarkdownToEad\Facades;

use Illuminate\Support\Facades\Facade;

class MarkdownToEad extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'MarkdownToEad';
    }
}
