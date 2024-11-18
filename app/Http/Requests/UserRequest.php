<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255', 'unique:users,name'],
            'initial_name'  => ['nullable', 'string', 'max:15', 'uppercase', 'unique:users,initial_name'],
            'email'         => ['required', 'string', 'email', 'unique:users,email'],
            'is_active'     => ['required', 'boolean'],
            'role'          => ['required', 'string', 'exists:roles,name'],
            'join_date'     => ['nullable', 'date', 'date_format:Y-m-d'],
        ];
    }
}
