<?php

use App\API\Res\Facades\Response;
use Illuminate\Support\Facades\Route;

Route::get('/welcome', fn () => Response::send());
