<?php

namespace App\API\Res\Facades;

use Illuminate\Support\Facades\Facade;

class Response extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'apiResponse';
    }
}