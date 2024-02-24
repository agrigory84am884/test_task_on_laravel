<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'string',
        ];
    
        // Check if the request method is POST (creation)
        if ($this->getMethod() === 'POST') {
            $rules['website_id'] = 'required';
        } else {
            $rules['website_id'] = 'exists:websites,id';
        }
    
        return $rules;
    }
}