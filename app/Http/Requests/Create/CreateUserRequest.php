<?php

namespace App\Http\Requests\Create;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'required|max:32|min:6|unique:users',
            'email' => 'required|max:32|min:6|unique:users',
            'password' => 'required|max:32|min:8',
            'name' => 'max:255|required',
            'age' => 'required',
            'name_on_project' => 'required',
            'english_lvl' => 'required',
            'role' => 'max:45|required',
        ];
    }
}
