<?php

Route::group(['prefix' => 'lavoter', 'namespace' => 'Zvermafia\Lavoter\Controllers'], function ()
{
	Route::post('uuide-create/', 'LavoterController@uuideCreate');
	Route::post('uuide-check/{uuide?}', 'LavoterController@uuideCheck');
});