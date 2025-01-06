<?php

namespace NicolasKion\Esi\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \NicolasKion\Esi\Esi
 */
class Esi extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \NicolasKion\Esi\Esi::class;
    }
}
