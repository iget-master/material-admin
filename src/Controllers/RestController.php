<?php namespace IgetMaster\MaterialAdmin\Controllers;

use IgetMaster\MaterialAdmin\Controllers\Traits\RelationalTrait;
use IgetMaster\MaterialAdmin\Controllers\Traits\RestTrait;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class RestController extends BaseController
{
    use ValidatesRequests, RelationalTrait, RestTrait;
}
