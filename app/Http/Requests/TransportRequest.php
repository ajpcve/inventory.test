<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransportRequest extends FormRequest
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
            'trans_company' =>'required|max:191',
            'trans_phone'   =>'required|max:191',
            'trans_address' =>'required|max:191',
            'trans_email'   =>'required|unique:transport|max:191',
            'id_status'     =>'required|max:191'
        ];
    }
}
