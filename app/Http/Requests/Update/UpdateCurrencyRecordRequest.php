<?php

namespace App\Http\Requests\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrencyRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'company_id' => 'numeric',
            'project_salary' => 'numeric',
            'currency_id' => 'numeric',
            'bank_rate' => 'numeric',
            'tax_rate' => 'numeric',
            'net' => 'numeric',
            'month' => 'numeric',
            'operation_date' => 'max:19',
        ];
    }
}
