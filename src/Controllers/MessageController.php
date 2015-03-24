<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\Message;

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
		return view('materialadmin::message.index')->with('messages', Message::where('to_user_id', \Auth::id())->orderBy('created_at')->paginate(15));
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
		$msg = Message::findOrFail($id);
		$msg->read = 1;
		$msg->save();

		return view('materialadmin::message.show')->with('message', Message::findOrFail($id));
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
		$message = Message::findOrFail($id);
		$messages = new MessageBag();

		if ($message->delete()) {
			$messages->add('success', 'Mensagem excluída com sucesso!');
			return \Redirect::route('message.index')->with('messages', $messages);
		} else {
			$messages->add('danger', 'Não foi possível excluir a mensagem!');
		}
		

		return \Redirect::back()->withInput()->with('messages', $messages);
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function multiple_destroy()
	{
		$ids = \Input::get('id');
		$success = [];
		$error = [];
		$denied = [];
		$messages = new MessageBag();
		
		foreach ($ids as $id) {
			$message = Message::findOrFail($id);

			if (\Auth::user()->level >= $message->level) {
				if ($message->delete()) {
					$success[] = $id;
				} else {
					$error[] = $id;
				}
			} else {
				$denied[] = $id;
			}
		}

		/*
			Agrupa mensagens de sucesso 
		*/
			
		if (count($success) > 0) {
			$message = "";
			foreach ($success as $id) {
				$message .= $id . ", ";
			}
			$message = substr($message, 0, -2);
			if (count($success) == 1) {
				$message = "Mensagem #" . $message . " excluída com sucesso.";
			} else if (count($success) > 1) {
				$message = "Mensagens #" . $message . " excluídas com sucesso.";
			}
			$messages->add('success', $message);
		}

		if (count($error) > 0) {
			$message = "";
			foreach ($error as $id) {
				$message .= $id . ", ";
			}
			$message = substr($message, 0, -2);
			if (count($error) == 1) {
				$message = "Não foi possível excluir a mensagem #" . $message . ".";
			} else if (count($error) > 1) {
				$message = "Não foi possível excluir as mensagens #" . $message . ".";
			}
			$messages->add('danger', $message);
		}	

		return \Redirect::back()->withInput()->with('messages', $messages);
	}

}
