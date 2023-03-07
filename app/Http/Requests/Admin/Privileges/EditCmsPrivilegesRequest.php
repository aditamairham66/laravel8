<?php

namespace App\Http\Requests\Admin\Privileges;

use Illuminate\Foundation\Http\FormRequest;

class EditCmsPrivilegesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required",
        ];
    }
}
