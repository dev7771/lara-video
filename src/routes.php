<?php

$middleware = ['web', 'auth:admin'];

$prefix = 'admin';

$as = '';

$namespace = '\Turanzamanli\LaraVideo';


Route::group(compact('middleware', 'prefix', 'as', 'namespace'), function () {

		Route::resource('/videos', 'VideoController');
});