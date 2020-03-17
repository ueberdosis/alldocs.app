<?php

namespace Ueberdosis\Pandoc\Facades;

use Illuminate\Support\Facades\Facade;

class Pandoc extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Ueberdosis\Pandoc\Pandoc::class;
    }
}
