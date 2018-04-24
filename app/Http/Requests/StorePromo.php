<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromo extends FormRequest
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
            // 'user_email' => 'required|min:10|max:60|unique:promos',
            'user_email' => 'required|min:10|max:60',
            'paypal_email' => 'required|min:3|max:60',

        ];
    }

    public function messages()
    {
        return [
            'user_email.required' => 'Please enter your email address',
            // 'user_email.unique' => 'You have already entered this program',
            'paypal_email.required' => 'You have not entered all required fields',
        ];
    }
}
