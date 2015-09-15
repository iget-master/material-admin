<?php namespace IgetMaster\MaterialAdmin\Controllers;

use IgetMaster\MaterialAdmin\Http\Requests\UserFilterRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\User;
use IgetMaster\MaterialAdmin\Models\PermissionGroup;

class UserController extends RestController {
	/**
	 * The model class name used by the controller.
	 *
	 * @var string
	 */
	public $model = "IgetMaster\MaterialAdmin\Models\User";

	/**
	 * The resource name used in routes
	 *
	 * @var string
	 */
	public $resource = "user";

	/**
	 * Translation namespace
	 *
	 * @var string
	 */
	public $translation_namespace = "materialadmin::user";

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(UserFilterRequest $request)
	{
		$users = User::with('permission_group')->filter($request->filters())->get();;

        return view('materialadmin::user.index')->withUsers($users);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return \View::make('materialadmin::user.create')->with('permission_groups', PermissionGroup::getSelectOptions());
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$validator = \Validator::make(
			\Input::all(), 
			Array(
				'name' => 'required',
				'surname' => 'required',
				'email' => 'required|email|unique:users',
				'password' => 'required|confirmed|min:6',
				'permission_group_id' => 'required|integer',
				'dob' => 'date',
				'language' => 'required'
			)
		);


		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$user = User::create(
			Array(
				'name' => \Input::get('name'),
				'surname' => \Input::get('surname'),
				'email' => \Input::get('email'),
				'permission_group_id' => \Input::get('permission_group_id'),
				'password' => \Hash::make(\Input::get('password')),
				'dob' => \Input::get('dob'),
				'language' => \Input::get('language'),
			)
		);

		if (\Input::has('img_url')){
			$fileLocation = "\storage\uploads\users_image";
			if(!File::exists($fileLocation)){
				File::makeDirectory($fileLocation);
			}
			$fileName = "user_".$user->id.".".\Input::file('img_url')->getMimeType();
			if(\Input::file('img_url')->move($fileLocation, $fileName);
			$user->img_url = $fileLocation. "\" .$fileName;
			$user->save();
		}

		return \Redirect::route('user.index');
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
		$user = User::with('permission_group')->findOrFail($id);
		$response = \View::make('materialadmin::user.edit')->with('user', $user)->with('permission_groups', PermissionGroup::getSelectOptions());
		return $response; 

	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		$user = User::findOrFail($id);

		$validator = \Validator::make(
			\Input::all(), 
			Array(
				'name' => 'required',
				'surname' => 'required',
				'password' => 'confirmed|min:6',
				'permission_group_id' => 'required|integer',
				'dob' => 'date',
				'language' => 'required'
			)
		);

		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$user->name = \Input::get('name');
		$user->surname = \Input::get('surname');
		$user->permission_group_id = \Input::get('permission_group_id');
		$user->dob = \Input::get('dob');
		$user->language = \Input::get('language');

		if (strlen(\Input::get('password'))) {
			$user->password = \Hash::make(\Input::get('password'));
		}

		$user->save();

		$messages = with(new MessageBag())->add('success', 'Usuário modificado com sucesso!');

		return \Redirect::route('user.index')->with('messages', $messages);
	}
}
