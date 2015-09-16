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
				'language' => 'required',
				'img_url' => 'image|max:2000',
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

		//upload of user image
		if (\Input::file('img_url')){
			$fileLocation = base_path()."/storage/uploads/users_image/";
			if(!\File::exists($fileLocation)){
				\File::makeDirectory($fileLocation);
			}
			$fileName = "user_".$user->id;
			$fileExtension = \Input::file('img_url')->getClientOriginalExtension();
			$imageData = getimagesize(\Input::file('img_url'));

			if(\Input::file('img_url')->getMimeType() == "image/jpeg"){
				$image = imagecreatefromjpeg(\Input::file('img_url')->getRealPath());
				$val = 100;
			} else {
				$image = imagecreatefrompng(\Input::file('img_url')->getRealPath());
				$val = null;
			}

        	// calculate thumbnail size
			if($imageData[0] >= $imageData[1]){
        		$new_width = ($imageData[0] * 120) / $imageData[1];
        		$new_height = 120;
        		$marginTop = 0;
        		$marginLeft = ($new_width - 120) / 2;
			} else {
        		$new_width = 120;
        		$new_height = ($imageData[1] * 120) / $imageData[0];
        		$marginTop = ($new_height - 120) / 2;
        		$marginLeft = 0;
			}

			// create a new temporary image
			$thumb_im_resize = imagecreatetruecolor( $new_width, $new_height );

			// copy and resize old image into new image
			imagecopyresized( $thumb_im_resize, $image, 0, 0, 0, 0, $new_width, $new_height, $imageData[0], $imageData[1]);

			// crop the resized image
			$to_crop_array = array('x' =>$marginLeft, 'y' => $marginTop, 'width' => 120, 'height'=> 120);
			$thumb_im_crop = imagecrop($thumb_im_resize, $to_crop_array);

			if($val == 100){//jpeg
				imagejpeg($thumb_im_crop, \Input::file('img_url')->getRealPath(), $val, 100);
			} else {
				imagepng($thumb_im_crop, \Input::file('img_url')->getRealPath(), $val, 100);
			}

			$fileVerify = $fileLocation.$fileName;

			if($val == null && \File::exists($fileVerify.".jpg")){
				\File::delete($fileVerify.".jpg");
			} else if($val == null && \File::exists($fileVerify.".jpeg")){
				\File::delete($fileVerify.".jpeg");
			} else if($val == 100 && \File::exists($fileVerify.".png")) {
				\File::delete($fileVerify.".png");
			}

			if(\Input::file('img_url')->move($fileLocation, $fileName.".".$fileExtension)){
				$user->img_url = $fileLocation.$fileName.".".$fileExtension;
				$user->save();
			}
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
				'language' => 'required',
				'img_url' => 'image|max:2000',
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

		//upload of user image
		if (\Input::file('img_url')){
			$fileLocation = base_path()."/storage/uploads/users_image/";
			if(!\File::exists($fileLocation)){
				\File::makeDirectory($fileLocation);
			}
			$fileName = "user_".$user->id;
			$fileExtension = \Input::file('img_url')->getClientOriginalExtension();
			$imageData = getimagesize(\Input::file('img_url'));

			if(\Input::file('img_url')->getMimeType() == "image/jpeg"){
				$image = imagecreatefromjpeg(\Input::file('img_url')->getRealPath());
				$val = 100;
			} else {
				$image = imagecreatefrompng(\Input::file('img_url')->getRealPath());
				$val = null;
			}

        	// calculate thumbnail size
			if($imageData[0] >= $imageData[1]){
        		$new_width = ($imageData[0] * 120) / $imageData[1];
        		$new_height = 120;
        		$marginTop = 0;
        		$marginLeft = ($new_width - 120) / 2;
			} else {
        		$new_width = 120;
        		$new_height = ($imageData[1] * 120) / $imageData[0];
        		$marginTop = ($new_height - 120) / 2;
        		$marginLeft = 0;
			}

			// create a new temporary image
			$thumb_im_resize = imagecreatetruecolor( $new_width, $new_height );

			// copy and resize old image into new image 
			imagecopyresized( $thumb_im_resize, $image, 0, 0, 0, 0, $new_width, $new_height, $imageData[0], $imageData[1]);

			// crop the resized image
			$to_crop_array = array('x' =>$marginLeft, 'y' => $marginTop, 'width' => 120, 'height'=> 120);
			$thumb_im_crop = imagecrop($thumb_im_resize, $to_crop_array);

			if($val == 100){//jpeg
				imagejpeg($thumb_im_crop, \Input::file('img_url')->getRealPath(), $val, 100);
			} else {
				imagepng($thumb_im_crop, \Input::file('img_url')->getRealPath(), $val, 100);
			}

			$fileVerify = $fileLocation.$fileName;

			if($val == null && \File::exists($fileVerify.".jpg")){
				\File::delete($fileVerify.".jpg");
			} else if($val == null && \File::exists($fileVerify.".jpeg")){
				\File::delete($fileVerify.".jpeg");
			} else if($val == 100 && \File::exists($fileVerify.".png")) {
				\File::delete($fileVerify.".png");
			}

			if(\Input::file('img_url')->move($fileLocation, $fileName.".".$fileExtension)){
				$user->img_url = $fileLocation.$fileName.".".$fileExtension;
			}
		}

		$user->save();

		$messages = with(new MessageBag())->add('success', 'Usuário modificado com sucesso!');

		return \Redirect::route('user.index')->with('messages', $messages);
	}

	public function getUserImage($id)
	{
		$image = User::findOrFail($id)->img_url;
		return response()->download($image);
	}
}
