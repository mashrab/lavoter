<?php

return [	
	/**
	 * If this parameter is true then voting step will be 3.
	 * Let's imagine you clicked 3 times:
	 *     up, down and down.
	 * Then total value change like below:
	 *     1, 0, -1
	 * If this paremeter is false total value change like below:
	 *     1, -1, -1
	 *
	 * Default is false.
	 */
	'step_back' => false,
];