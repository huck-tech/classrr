<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfile extends FormRequest
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
        //$a = $this->validationData();
        //var_dump($a);die();
        return [
            'first_name' => 'required|min:2|max:30',
            'last_name' => 'required|max:30',
            'phone' => 'present',
            'dob' => 'present|date_format:"'.config('app.dateformat_php') .'"',//date_format:' //. addcslashes(config('app.dateformat_php'), ',:'),
            'gender' => 'filled',
            'address' => 'present',
            'city' => 'present',
            'zip_code' => 'present',
            'country_id' => 'present|integer',
            'avatar_id' => 'filled|integer',
            'about_me' => 'max:2500'
        ];
    }
}
