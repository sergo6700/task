<?php

use Illuminate\Support\Facades\Route;


Route::get('{path}', 'SpaController')->where('path', '(.*)');
