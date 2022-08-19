<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'item_code' =>'required|max:191',
            'item_name' =>'required|max:191',
            'item_ruta' =>'required|image',
            'id_unit'   =>'required|max:191',
            'id_status' =>'required|max:191'
        ];
    }
}
