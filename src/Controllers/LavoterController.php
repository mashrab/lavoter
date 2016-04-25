<?php

namespace Zvermafia\Lavoter\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Zvermafia\Lavoter\Models\Uuide;

class LavoterController extends Controller
{
	/**
	 * Create and store a new uuide
	 * 
	 * @return Illuminate\Http\Response
	 */
	public function create()
	{
		$item = Uuide::create([
			'uuide' => Uuid::generate(4),
		]);

		$response = [];

		if ($item)
		{
			$response = [
				'status' => 'success',
				'length' => strlen($item->uuide),
				'uuide'  => $item->uuide,
			];
		}
		else
		{
			$response = [
				'status'  => 'fail',
				'message' => 'Something went wrong.',
			];
		}

		return response()->json($response);
	}

	/**
	 * Check a given uuide to exists in DB
	 * 
	 * @return Illuminate\Http\Response
	 */
	public function check($uuide = null)
	{
		if ( ! $uuide)
		{
			$response = [
				'status'  => 'false',
				'message' => 'The uuide parameter is reuqired.',
			];

			return response()->json($response);
		}

		$item = Uuide::firstOrCreate(['uuide' => $uuide]);

		if ($item)
		{
			$response = [
				'status'  => 'success',
				'length' => strlen($item->uuide),
				'uuide'  => $item->uuide,
			];
		}
		else
		{
			$response = [
				'status'  => 'false',
				'message' => 'Someting went wrong.',
			];
		}

		return response()->json($response);
	}

	/**
	 * Showing current user's uuide page
	 * 
	 * @return Illuminate\Http\Response
	 */
	public function show(Request $request)
	{
		if ( ! config('app.debug') && ! config('lavoter.page_show'))
		{
			abort(404);
		}

		$uuide = $request->cookie('uuide') ? $request->cookie('uuide') : 'undefined';

		return view('lavoter::show', compact('uuide'));
	}
}