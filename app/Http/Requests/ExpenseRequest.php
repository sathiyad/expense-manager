<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpenseRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'description' => 'sometime|string',
            'amount' => 'required|regex:/^(?:\d+)(?:\.\d\d?)?$/',
            'type' => 'required|in:equal,exact,percentage',
            'splitBetween' => 'required|array|percentage:'.$this->type,
            'splitBetween.*.user_id' => 'required|exists:users,id',
            'splitBetween.*.amount' => 'required_if:type,==,exact|regex:/^(?:\d+)(?:\.\d\d)?$/',
            'splitBetween.*.percentage' => 'required_if:type,==,percentage',
        ];
    }

    public function messages()
    {
        return [
            'splitBetween.percentage' => 'The total percentage must be 100',
            'splitBetween.*.user_id.required' => 'User id field is required',
            'splitBetween.*.user_id.exists' => 'User id field is invalid',
            'splitBetween.*.amount.required_if' => 'Amount field is required when type is exact',
            'splitBetween.*.amount.regex' => 'The Amount format is invalid',
            'splitBetween.*.percentage.required_if' => 'Percentage field is required when type is percentage',
        ];
    }
}
