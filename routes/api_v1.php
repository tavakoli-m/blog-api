<?php

use Illuminate\Support\Facades\Route;

Route::get('/welcome',fn() => response()->json(['message' => 'hello api']));