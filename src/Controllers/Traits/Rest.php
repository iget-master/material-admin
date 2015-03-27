<?php namespace App\Http\Controllers\Traits;

use Illuminate\Support\MessageBag;

trait Rest {
	/**
	 * Default destroy method for an RESTful controller.
	 * Destroy one or multiple models by id.
	 *
	 * @param  unsigned int $id
	 * @return Response
	 */
	public function destroy($id) {
		$count = 1;
		$messages = new MessageBag();
		$class = $this->model;

		if (\Input::has('id')) {
			$id = \Input::get('id');
			$count = count($id);
		}

		if ($class::destroy($id)) {
			$messages->add('success', trans_choice($this->resource . '.destroy_success', $count));
			return \Redirect::route($this->resource . '.index')->with('messages', $messages);
		} else {
			$messages->add('danger', trans_choice($this->resource . '.destroy_error', $count));
			return \Redirect::back()->withInput()->with('messages', $messages);
		}
	}
}