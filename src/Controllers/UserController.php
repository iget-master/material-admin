<?php namespace IgetMaster\MaterialAdmin\Controllers;

use IgetMaster\MaterialAdmin\Http\Requests\UserFilterRequest;
use IgetMaster\MaterialAdmin\Http\Requests\UserImageRequest;
use IgetMaster\MaterialAdmin\Http\Requests\UserPasswordRequest;
use IgetMaster\MaterialAdmin\Http\Requests\UserRequest;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\User;
use IgetMaster\MaterialAdmin\Models\PermissionGroup;
use Illuminate\Http\Request;

class UserController extends RestController
{
    /**
     * The model class name used by the controller.
     *
     * @var string
     */
    public $model = User::class;

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
     * @param UserFilterRequest $request
     * @return \Illuminate\Http\Response
     */
    public function index(UserFilterRequest $request)
    {
        $users = User::with('permission_group')->filter($request->filters())->get();

        return view('materialadmin::user.index')->withUsers($users);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return \View::make('materialadmin::user.create')->with('permission_groups', PermissionGroup::getSelectOptions());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $validator = \Validator::make(
            \Input::all(),
            array(
                'name' => 'required',
                'surname' => 'required',
                'email' => 'required|email|unique:users,email,NULL,id,deleted_at,NULL',
                'password' => 'required|confirmed|min:6',
                'permission_group_id' => 'required|integer',
                'dob' => 'date',
                'language' => 'required'
            )
        );


        if ($validator->fails()) {
            return \Redirect::back()->withInput()->withErrors($validator);
        }

        $user = User::create(
            array(
                'name' => \Input::get('name'),
                'surname' => \Input::get('surname'),
                'email' => \Input::get('email'),
                'permission_group_id' => \Input::get('permission_group_id'),
                'password' => bcrypt(\Input::get('password')),
                'dob' => \Input::get('dob'),
                'language' => \Input::get('language'),
            )
        );

        //upload of user image
        if (\Input::has('img_url')) {
            Self::saveImage(\Input::get('img_url'), $user, true);
        }

        return \Redirect::route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('permission_group')->findOrFail($id);
        $response = \View::make('materialadmin::user.edit')->with('user', $user)->with('permission_groups', PermissionGroup::getSelectOptions());
        return $response;
    }

    /**
     * Show the form for editing user password.
     * If user id is omitted, edit current authenticated user.
     *
     * @param null|integer $id
     * @return \Illuminate\Http\Response
     */
    public function editPassword($id = null)
    {
        if (is_null($id)) {
            $user = auth()->user();
        } else {
            $user = User::findOrFail($id);
        }

        return view('materialadmin::user.password')->with('user', $user);
    }

    /**
     * @param UserPasswordRequest $request
     * @param null|integer $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(UserPasswordRequest $request, $id = null)
    {
        if (is_null($id)) {
            $user = auth()->user();
        } else {
            $user = User::findOrFail($id);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $messages = with(new MessageBag())->add('success', 'Password updated successfully.');

        return \Redirect::back()->with('messages', $messages);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \IgetMaster\MaterialAdmin\Http\Requests\UserRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        $user->fill($request->all());

        if ($request->has('password')) {
            $user->password = bcrypt($request->get('password'));
        }

        $user->save();

        $messages = with(new MessageBag())->add('success', 'Usuário modificado com sucesso!');

        return \Redirect::route('user.index')->with('messages', $messages);
    }

    /**
     * get the image of the user from Storage
     *
     * @param  int  $id
     * @return Response
     */
    public function getUserImage($id)
    {
        $user = User::findOrFail($id);
        $image = storage_path('uploads/user/' . $user->img_url);

        if ($user->img_url && file_exists($image)) {
            return response()->download($image, null, ['Cache-Control' => 'no-cache', 'Pragma' => 'no-cache'], 'inline');
        } else {
            return redirect("/iget-master/material-admin/imgs/user-image.jpg");
        }
    }

    /**
     * Return a user temporary uploaded image
     *
     * @param $filename
     * @return Response
     */
    public function getTemporaryImage($filename)
    {
        return response()->download(
            base_path("storage/uploads/user/".$filename),
            null,
            [
                'Chache-Control' => 'no-cache',
                'Pragma' => 'no-cache'
            ],
            'inline'
        );
    }

    /**
     * Receive uploaded image to create the temporary user thumbnail
     *
     * @param \IgetMaster\MaterialAdmin\Http\Requests\UserImageRequest $request
     * @return Response
     */
    public function uploadUserImage(UserImageRequest $request)
    {
        $uploadedImage = $request->file;
        $fileExtension = $uploadedImage->getClientOriginalExtension();

        // Create upload directory if necessary.
        $uploadDirectoryPath = base_path("storage/uploads/user/");
        if (!\File::exists($uploadDirectoryPath)) {
            \File::makeDirectory($uploadDirectoryPath);
        }

        do {
            $filename = str_random() . ".${fileExtension}";
        } while (file_exists($uploadDirectoryPath . $filename));

        $imageData = getimagesize($uploadedImage);
        $mimeType = $uploadedImage->getMimeType();

        if ($mimeType == "image/jpeg") {
            $image = imagecreatefromjpeg($uploadedImage->getRealPath());
        } else {
            $image = imagecreatefrompng($uploadedImage->getRealPath());
        }

        // Calculate thumbnail size
        if ($imageData[0] >= $imageData[1]) {
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

        // Create a new temporary image
        $thumbnail = imagecreatetruecolor($new_width, $new_height);

        // copy and resize old image into new image
        imagecopyresized($thumbnail, $image, 0, 0, 0, 0, $new_width, $new_height, $imageData[0], $imageData[1]);

        // crop the resized image
        $thumbnail = imagecrop($thumbnail, [
            'x' =>$marginLeft,
            'y' => $marginTop,
            'width' => 120,
            'height'=> 120
        ]);

        if ($mimeType == "image/jpeg") {
            imagejpeg($thumbnail, $uploadDirectoryPath . $filename, 100);
        } else {
            imagepng($thumbnail, $uploadDirectoryPath . $filename);
        }

        return response()->json(compact('filename'));
    }
}
