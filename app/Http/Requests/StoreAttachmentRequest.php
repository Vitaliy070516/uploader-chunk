<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAttachmentRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'attachment' => 'required|max:1024|mimes:pdf,png,jpeg,gif,txt,csv'
        ];
    }
}
