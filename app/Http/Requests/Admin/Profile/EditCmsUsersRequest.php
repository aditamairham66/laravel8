<?php

namespace App\Http\Requests\Admin\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class EditCmsUsersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|min:3",
            "email" => [
                "required",
                "email",
                Rule::unique('cms_users', 'email')->ignore($this->route()->parameter('request'))
            ],
            "photo" => "nullable|image|max:1000",
            "password" => [
                "nullable",
                Password::min(6)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed'
            ],
            "password_confirmation" => "same:password",
        ];
    }
}
