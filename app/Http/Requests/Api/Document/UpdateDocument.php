<?php

namespace App\Http\Requests\Api\Document;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDocument extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->can('update', $this->route('document'));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'string:min:6|max:100',
            'description' => 'string|min:10',
            'file' => 'file'
        ];
    }
}
