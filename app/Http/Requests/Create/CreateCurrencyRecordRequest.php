<?php

namespace App\Http\Requests\Create;

use Illuminate\Foundation\Http\FormRequest;

class CreateCurrencyRecordRequest extends FormRequest
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
            'company_id' => 'required|numeric',
            'project_salary' => 'required|numeric',
            'currency_id' => 'required|numeric',
            'bank_rate' => 'required|numeric',
            'tax_rate' => 'required|numeric',
            'net' => 'required|numeric',
            'month' => 'required|numeric',
            'operation_date' => 'required|max:19',
        ];
    }
}
