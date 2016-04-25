<?php

namespace Zvermafia\Lavoter\Controllers;

use App\Http\Controllers\Controller;
use Webpatser\Uuid\Uuid;
use Zvermafia\Lavoter\Models\Uuide;

class LavoterController extends Controller
{
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
}