<?php

Route::group(['prefix' => 'lavoter', 'as' => 'lavoter.', 'namespace' => 'Zvermafia\Lavoter\Controllers'], function ()
{
	/**
	 * Create
	 */
	Route::post('create', [
		'as'   => 'create',
		'uses' => 'LavoterController@create',
	]);

	/**
	 * Check
	 */
	Route::post('check/{uuide?}', [
		'as'   => 'check',
		'uses' => 'LavoterController@сheck',
	]);

	/**
	 * Check
	 */
	Route::get('show', [
		'as'   => 'show',
		'uses' => 'LavoterController@show',
	]);
});