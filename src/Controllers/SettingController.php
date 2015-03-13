<?php namespace IgetMaster\MaterialAdmin\Controllers;

use \Config;
use \Input;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;
use IgetMaster\MaterialAdmin\Models\User;
use IgetMaster\MaterialAdmin\Models\PermissionGroup;

class SettingController extends BaseController {

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
		return view('materialadmin::setting.index');
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($name)
	{
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			App::abort(404);
		}

		$setting = $settings_items[$name];
		$model_class = $setting['model'];

		return view($setting['edit'])->withSetting($setting)->withName($name);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($name)
	{
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			App::abort(404);
		}

		$setting = $settings_items[$name];
		$model_class = $setting['model'];

		$model = new $model_class();

		$validator = \Validator::make(
			\Input::all(), 
			$model->rules
		);

		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$model->fill(Input::all())->save();

		$this->fill_settings_relationships($setting, $model);

		return \Redirect::route('setting.index');
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
	public function edit($name, $id)
	{
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			App::abort(404);
		}

		$setting = $settings_items[$name];
		$model_class = $setting['model'];

		$model = $model_class::with('roles')->findOrFail($id);
		return view($setting['edit'])->withSetting($setting)->withModel($model)->withName($name);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($name, $id)
	{
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			App::abort(404);
		}

		$setting = $settings_items[$name];
		$model_class = $setting['model'];

		$model = $model_class::findOrFail($id);

		$validator = \Validator::make(
			\Input::all(), 
			$model->rules
		);

		if ($validator->fails())
		{
			return \Redirect::back()->withInput()->withErrors($validator);
		}

		$model->fill(Input::all())->save();

		$this->fill_settings_relationships($setting, $model);

		return \Redirect::route('setting.index');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($name, $id)
	{
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			App::abort(404);
		}

		$setting = $settings_items[$name];
		$model_class = $setting['model'];
		$messages = new MessageBag();

		try {
			$model_class::destroy($id);
		} catch ( \PDOException $e) {
			if ($e->errorInfo[1] == 1451) {
				$messages->add('danger', trans('materialadmin::error.sql_1451'));
				return \Redirect::back()->withInput()->with('messages', $messages);
			} else {
				throw $e;
			}
		}

		return \Redirect::route('setting.index');

		// $user = User::findOrFail($id);
		// $messages = new MessageBag();

		// if (\Auth::user()->id == $user->id) {
		// 	$messages->add('danger', 'Você não pode excluir o próprio usuário.');
		// } else {
		// 	if (\Auth::user()->level >= $user->level) {
		// 		if ($user->delete()) {
		// 			$messages->add('success', 'Usuário excluído com sucesso!');
		// 			return \Redirect::route('user.index')->with('messages', $messages);
		// 		} else {
		// 			$messages->add('danger', 'Não foi possível excluir usuário!');
		// 		}
		// 	} else {
		// 		$messages->add('danger', 'Você não possui permissão para excluir esse usuário.');
		// 	}
		// }

		// return \Redirect::back()->withInput()->with('messages', $messages);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function multiple_destroy()
	{

	}

	private function fill_settings_relationships($setting, $model)
	{
		foreach ($setting['relationships'] as $relationship) {
			if ($relationship["relation"] == 'many-to-many') {
				if (Input::has($relationship["name"])) {
					$model->$relationship["name"]()->sync(Input::get($relationship["name"]));
				}
			}
		}
	}

}
