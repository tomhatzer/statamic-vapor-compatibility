<?php

namespace StatamicVaporCompatibility;

use Illuminate\Support\Facades\Facade;

/**
 * @see \StatamicVaporCompatibility\StatamicVaporCompatibility
 */
class StatamicVaporCompatibilityFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'statamic-vapor-compatibility';
    }
}
