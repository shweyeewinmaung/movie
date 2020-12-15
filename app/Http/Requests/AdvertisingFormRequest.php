<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisingFormRequest extends FormRequest
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
           'company_name'=>'required',
           'from_date' => 'required',
           'to_date' => 'required',
           'display_time' => 'required',
           'display_type' => 'required',
           'advertisingfile' => 'required',
        ];
    }
}
