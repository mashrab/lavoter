<?php

namespace Zvermafia\Lavoter\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Zvermafia\Lavoter\Models\Uuid;

class LavoterController extends Controller
{
	/**
	 * @var \Zvermafia\Lavoter\Models\Uuid
	 */
	private $uuids;

	/**
	 * Magic method.
	 * 
	 * @param \Zvermafia\Lavoter\Models\Uuid $uuids
	 *
	 * @return void
	 */
	public function __construct(Uuid $uuids)
	{
		$this->uuids = $uuids;
	}

	/**
	 * Check a given uuid to exists in DB
	 * or create if the uuid isn't exists in DB
	 *
	 * @param  \Illuminate\Http\Request $request
	 * 
	 * @return Illuminate\Http\Response
	 */
	public function сheckOrCreate(Request $request)
	{
		$item = $this->uuids->firstOrCreate(['uuid' => $request->uuid]);

		return response()->json([
			'status' => 'success',
			'uuid'   => $request->uuid,
		]);
	}
}