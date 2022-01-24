<?php

namespace IgetMaster\MaterialAdmin\Http\Requests;

class UserRequest extends FilterRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'surname' => 'required|max:255',
            'password' => 'confirmed|min:6|max:255',
            'permission_group_id' => 'required|integer',
            'dob' => 'date',
            'language' => 'required|max:5'
        ];
    }
}
