<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
            'cust_company'  =>'required|max:191',
            'cust_phone'    =>'required|max:191',
            'cust_address'  =>'required|max:191',
            'cust_email'    =>'required|unique:customer|max:191',
            'id_status'     =>'required|max:191'
        ];
    }
}
