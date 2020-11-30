<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieFormRequest extends FormRequest
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
             'video_file' => 'required|mimes:mp4',
            // 'encodednames' => 'required|mimes:m3u8,ts',
           //'video_file' => 'required',
           //'subtitles.subtitle_file'=>'required|mimes:jpeg'
            
        ];
    }
}
