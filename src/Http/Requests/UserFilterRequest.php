<?php
/**
 * Created by PhpStorm.
 * User: IGET-001
 * Date: 18/04/2015
 * Time: 15:39
 */

namespace IgetMaster\MaterialAdmin\Http\Requests;


class UserFilterRequest extends FilterRequest {
    protected $filters = [
        'name' => 'string',
        'email' => 'string',
        'id' => 'logical',
        'dob' => 'date',
    ];

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
        return [];
    }
}