<?php namespace IgetMaster\MaterialAdmin\Controllers\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;

trait RelationalTrait
{

    public function fillRelationalModel($class, $external_fields, $replace_new_ids, Request $request)
    {
        $new_ids = [];
        if ($request->filled($class)) {
            $request_items = $request->input($class);
            $class = "App\\Models\\${class}";
            foreach ($request_items as $index => $item) {
                $new = true;
                if ($index !== 'new') {
                    $item = [$index=>$item];
                    $new = false;
                }
                foreach ($item as $id => $data) {
                    if (isset($replace_new_ids) && is_array($replace_new_ids)) {
                        foreach ($replace_new_ids as $field_name => $replace_ids) {
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
                        if ($data['remove'] == "true") {
                            $class::destroy($id);
                        } else {
                            $class::findOrFail($id)->fill($data)->save();
                        }
                    }
                }
            }
        }

        return $new_ids;
    }
}
