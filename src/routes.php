<?php

Route::group(['prefix' => 'lavoter', 'namespace' => 'Zvermafia\Lavoter\Controllers'], function ()
{
	Route::post('check-or-create', [
		'as'   => 'lavoter.check_or_create',
		'uses' => 'LavoterController@сheckOrCreate',
	]);
});