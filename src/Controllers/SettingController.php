<?php namespace IgetMaster\MaterialAdmin\Controllers;

use \Config, \Input, \App;
use IgetMaster\MaterialAdmin\Controllers\Traits\RelationalTrait;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;

class SettingController extends BaseController {
    use RelationalTrait;

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
     * @param string $name
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

		return view($setting['edit'])->withSetting($setting)->withName($name)->withAction('create');
	}

    /**
     * Check if setting is using Request pattern or Model Rules pattern (deprecated),
     * and return the right Request object.
     * @param $setting
     * @param $model
     * @return \Illuminate\Http\Request
     */
    private function getRequest($setting, $model)
    {
        $requestClass = request;
        if (array_key_exists('request', $setting)) {
            $requestClass = $setting['request'];
        } else {
            $validator = \Validator::make(
                \Input::all(),
                $model->rules
            );

            if ($validator->fails())
            {
                return \Redirect::back()->withInput()->withErrors($validator);
            }
        }

        return new $requestClass();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param string $name
     * @return Response
     */
	public function store($name)
	{
        // Check if setting exist on config. If don't exists, return 404.
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			abort(404);
		}

        // Get setting options
		$setting = $settings_items[$name];
		$model_class = $setting['model'];

		$model = new $model_class();

        // Get request class
        $request = $this->getRequest($setting, $model);


		$model->fill($request->all())->save();

		$this->fill_setting_relationships($setting, $model);

		if (Input::has('redirect_back_to')) {
			return redirect(Input::get('redirect_back_to'));
		} else {
			return \Redirect::route('setting.index');
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $name
	 * @return Response
	 */
	public function show($name)
	{
		$settings_items = Config::get('admin.settings_items');
		if (!array_key_exists($name, $settings_items)) {
			App::abort(404);
		}

		$setting = $settings_items[$name];

		if (!array_key_exists('show', $setting)) {
			App::abort(404);
		}

		return view($setting['show'])->withSetting($setting)->withName($name);
	}


    /**
     * Show the form for editing the specified resource.
     *
     * @param string $name
     * @param  int $id
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

		$relationships = [];
		foreach($setting['relationships'] as $relationship) {
			$relationships[] = $relationship['name'];
		}

		$model = $model_class::with($relationships)->findOrFail($id);
		return view($setting['edit'])->withSetting($setting)->withModel($model)->withName($name)->withAction('edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  string $id
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

		$this->fill_setting_relationships($setting, $model);

		if (Input::has('redirect_back_to')) {
			return redirect(Input::get('redirect_back_to'));
		} else {
			return \Redirect::route('setting.index');
		}
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param string $name
     * @param  int $id
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

		if (Input::has('redirect_back')) {
			return \Redirect::back();
		} else {
			return \Redirect::route('setting.index');
		}
	}

    /**
     * @param $setting
     * @param $model
     */
    private function fill_setting_relationships($setting, $model)
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
