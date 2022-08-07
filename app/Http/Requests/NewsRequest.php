<?php

namespace App\Http\Requests;

use App\Models\Image;
use Illuminate\Foundation\Http\FormRequest;
use function __;

class NewsRequest extends FormRequest
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
            'title' => ['required', 'min:3', 'max:255'],
            'message' => ['required', 'min:3'],
            'images.*' => ['mimes:jpg,png,jpeg', 'image', 'max:1024'],
            'images' => ['max:' . Image::MAX_IMAGES],
        ];
    }

    public function messages()
    {
        return [
            'images.max' => __('You can upload only :number images.', ['number' => Image::MAX_IMAGES])
        ];
    }
}
