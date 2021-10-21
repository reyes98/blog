<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveContactRequest extends FormRequest
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
            'address' => ['nullable', 'string'],
            'phone' => ['required', 'string'],
            'email' => ['required', 'string'],
            'contact_image' => ['nullable', 'image'],
            'contact_formal_image' => ['nullable', 'image'],
            'contact_description' => ['nullable', 'string'],
            'google_map_url' => ['nullable', 'url'],
        ];
    }
}
