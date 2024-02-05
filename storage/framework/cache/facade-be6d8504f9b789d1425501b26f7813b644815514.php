<?php

namespace Facades\Statamic\UpdateScripts;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Statamic\UpdateScripts\Manager
 */
class Manager extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'Statamic\UpdateScripts\Manager';
    }
}
