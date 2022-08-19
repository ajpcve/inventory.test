<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
            'house_address'     =>'required|max:191',
            'house_phone'       =>'required|max:191',
            'house_person'      =>'required|max:191',
            'house_description' =>'required|max:191',
            'house_email'       =>'required|unique:warehouse|max:191',
            'id_status'         =>'required|max:191'
        ];
    }
}
