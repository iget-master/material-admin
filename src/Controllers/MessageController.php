<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\Message;

class MessageController extends RestController {
	/**
	 * The model class name used by the controller.
	 *
	 * @var string
	 */
	public $model = "IgetMaster\MaterialAdmin\Models\Message";

	/**
	 * The resource name used in routes
	 *
	 * @var string
	 */
	public $resource = "message";

	/**
	 * Translation namespace
	 *
	 * @var string
	 */
	public $translation_namespace = "materialadmin::message";

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('materialadmin::message.index')->with('messages', Message::where('to_user_id', \Auth::id())->orderBy('created_at', 'desc')->paginate(15));
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
			'to_user_id' => 'required|exists:users,id',
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
			"created_at" => date('Y-m-d G:i:s')
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
		$message = Message::findOrFail($id);

		if ($message->read == 0) {
			$message->read = 1;
			$message->save();
		}

		return view('materialadmin::message.show')->with('message', $message);
	}

    /**
     * @param $id
     */
    public function markAsRead($id)
    {
        $message = Message::findOrFail($id);
        $message->read = 1;
        $message->save();

        return \Redirect::route('message.index');
    }

    /**
     * @param $id
     */
    public function markAsUnread($id)
    {
        $message = Message::findOrFail($id);
        $message->read = 0;
        $message->save();

        return \Redirect::route('message.index');
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
}
