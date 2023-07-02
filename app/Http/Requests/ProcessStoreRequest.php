<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProcessStoreRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'type_id' => ['required', 'integer', 'exists:types,id'],
            'status_id' => ['required', 'integer', 'exists:statuses,id'],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'total' => ['required', 'string'],
            'file' => ['required', 'string', 'max:255'],
            'log' => ['required', 'string', 'max:255'],
        ];
    }
}
