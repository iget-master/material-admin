<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use IgetMaster\MaterialAdmin\Controllers\Traits\Rest;

abstract class RestController extends BaseController {

	use DispatchesCommands, ValidatesRequests, Rest;

	/**
	 * The model class name used by the controller.
	 *
	 * @var string
	 */
	public $model;

	/**
	 * The resource name used in routes
	 *
	 * @var string
	 */
	public $resource;

}
