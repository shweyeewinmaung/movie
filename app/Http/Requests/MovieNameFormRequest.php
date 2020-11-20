<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieNameFormRequest extends FormRequest
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
           'name'=>'required',
           'movie_file' => 'required |mimes:jpeg,png',
           'category_id' => 'required',
           'subcategory_id' => 'required',
           'outline' => 'required',
        ];
    }
}
