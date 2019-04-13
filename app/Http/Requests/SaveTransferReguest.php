<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Validation\Rule;

class SaveTransferReguest extends FormRequest
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
            'value' => ['required', 'numeric', 'min:1', 'max:' . (\Auth::user()->account->assumed_value)],
            'user' => ['required', Rule::notIn([\Auth::user()->id]), 'integer'],
            'planeDate' => ['required', 'date', "after_or_equal:" . date('Y-m-d H:i:s')]
        ];
    }

    public function messages()
    {
        return [
            'value.max' => 'Value mast be less then Your account value'
        ];
    }
}
