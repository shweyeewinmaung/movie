<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TvchannelFormRequest extends FormRequest
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
           'name' => 'required',
           'tvcategory_id' => 'required',
           'channel_image' => 'required',
           'channel_api' => 'required',
        ];
    }
}
