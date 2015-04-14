<?php namespace IgetMaster\MaterialAdmin\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

trait Rest {

	/**
	 * The model class name used by the controller.
	 *
	 * @var string
	 */
	public $model;

	/**
	 * The resource name used in routes
	 *
	 * @var string
	 */
	public $resource;

	/**
	 * Translation namespace
	 * Use it to override default namespace.
	 *
	 * @var string
	 */
	public $translation_namespace = null;

    /**
     * Helper method to fill an relational class when using the tables.js input format.
     *
     * @param $class
     * @param $external_fields
     * @param $replace_new_ids
     * @param Request $request
     * @return array
     */
    
    public function fillRelationalModel($class, $external_fields, $replace_new_ids, Request $request) {
        $new_ids = [];
        if ($request->has($class)) {
            $request_items = $request->input($class);
            $class = "App\\Models\\${class}";
            foreach($request_items as $index=>$item) {
                $new = true;
                if (!is_array($item)) {
                    $item = [$index=>$item];
                    $new = false;
                }
                foreach($item as $id=>$data) {
                    if (isset($replace_new_ids) && is_array($replace_new_ids)) {
                        foreach ($replace_new_ids as $field_name=>$replace_ids) {
                            if (array_key_exists($data[$field_name], $replace_ids)) {
                                $data[$field_name] = $replace_ids[$data[$field_name]];
                            }
                        }
                    }

                    if (is_array($external_fields)) {
                        $data = array_merge($data, $external_fields);
                    }

                    if ($new) {
                        $new_ids["[new][${id}]"] = $class::create($data)->id;
                    } else {
                        $class::findOrFail($id)->fill($data);
                    }
                }
            }
        }

        return $new_ids;
    }

    /**
     * Get the translation namespace. If not defined, defaults to
     * resource name.
     *
     * @return string
     */
    public function getTranslationNamespace()
    {
        if (is_null($this->translation_namespace)) {
            return $this->resource;
        }
        return $this->translation_namespace;
    }

	/**
	 * Default destroy method for an RESTful controller.
	 * Destroy one or multiple models by id.
	 *
	 * @param  unsigned int $id
	 * @return Response
	 */

	public function destroy($id)
	{
		$count = 1;
		$messages = new MessageBag();
		$class = $this->model;

		if (\Input::has('id')) {
			$id = \Input::get('id');
			$count = count($id);
		}

		if ($class::destroy($id)) {
			$messages->add('success', trans_choice($this->getTranslationNamespace() . '.destroy_success', $count));
			return \Redirect::route($this->resource . '.index')->with('messages', $messages);
		} else {
			$messages->add('danger', trans_choice($this->getTranslationNamespace() . '.destroy_error', $count));
			return \Redirect::back()->withInput()->with('messages', $messages);
		}
	}
}