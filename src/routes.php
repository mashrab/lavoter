<?php

Route::group(['prefix' => 'lavoter', 'as' => 'lavoter.', 'namespace' => 'Zvermafia\Lavoter\Controllers'], function ()
{
	/**
	 * Check
	 */
	Route::post('check-or-create', [
		'as'   => 'check_or_create',
		'uses' => 'LavoterController@сheckOrCreate',
	]);
});