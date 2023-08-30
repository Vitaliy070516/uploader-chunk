<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploaderRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return string[]
     */
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:csv'
        ];
    }
}
