<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use IgetMaster\MaterialAdmin\Controllers\Traits\Rest;

abstract class RestController extends BaseController {

	use DispatchesCommands, ValidatesRequests, Rest;
}
