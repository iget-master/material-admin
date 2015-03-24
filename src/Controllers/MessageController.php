<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\Message;
// use IgetMaster\MaterialAdmin\Models\PermissionGroup;

class MessageController extends BaseController {

	public function __construct()
    {
    }

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('materialadmin::message.index')->with('messages', Message::where('to_user_id', \Auth::id())->paginate(15));
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('materialadmin::message.create');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make(\Input::all(),[
			'to_user_id' => 'required|exists:user,id',
			'subject' => 'required',
			'message' => 'required'
		]);

		if($validator->fails()){
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$message = Message::create([
			"to_user_id" => \Input::get('to_user_id'),
			"from_user_id" => \Auth::id(),
			"subject" => \Input::get('subject'),
			"message" => \Input::get('message'),
			"read" => "0",
			"created_at" => date('Y-m-d G:i:s'),
			"updated_at" => ""
		]);

		return \Redirect::route('message.index');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{

	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function multiple_destroy()
	{
		
	}

}
