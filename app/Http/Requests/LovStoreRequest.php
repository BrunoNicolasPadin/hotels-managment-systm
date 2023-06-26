<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LovStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'type' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:255', 'unique:lovs,code'],
            'label' => ['required', 'string', 'max:255'],
        ];
    }
}
