<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\Message;

class HomeController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('materialadmin::empty');
    }
}
