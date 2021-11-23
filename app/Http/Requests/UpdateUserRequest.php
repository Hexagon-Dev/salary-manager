<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'login' => 'max:32|min:6',
            'email' => 'max:32|min:6',
            'password' => 'max:32|min:8',
            'name' => 'max:255',
            'age' => 'max:45',
            'role' => 'max:45',
        ];
    }
}
