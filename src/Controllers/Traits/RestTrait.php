<?php namespace IgetMaster\MaterialAdmin\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

trait RestTrait
{

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
     * Default destroy method for an RESTful controller.
     * Destroy one or multiple models by id.
     *
     * @param  unsigned int $id
     * @return Response
     */

    public function getTranslationNamespace()
    {
        if (is_null($this->translation_namespace)) {
            return $this->resource;
        }
        return $this->translation_namespace;
    }

    public function destroy($id)
    {
        $count = 1;
        $messages = new MessageBag();
        $class = $this->model;

        if (\Request::has('remove_ids')) {
            $id = \Request::get('remove_ids');
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
