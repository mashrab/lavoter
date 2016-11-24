<?php

namespace Zvermafia\Lavoter\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Zvermafia\Lavoter\Models\Uuid;

class LavoterController extends Controller
{
	/**
	 * @var Uuid
	 */
	private $uuids;

	/**
	 * Magic method.
	 * 
	 * @param  Uuid  $uuids
	 * @return void
	 */
	public function __construct(Uuid $uuids)
	{
		$this->uuids = $uuids;
	}

	/**
	 * Check the given uuid to exists in DB
	 * or create if the uuid isn't exists in DB.
	 *
	 * @param  Request  $request
	 * @return Illuminate\Http\Response
	 */
	public function сheckOrCreate(Request $request)
	{
		$item = $this->uuids->firstOrCreate(['uuid' => $request->lavoter_uuid]);

		return response()->json([
			'lavoter_uuid' => $request->lavoter_uuid,
		], 200);
	}
}