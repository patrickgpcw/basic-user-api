<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserApiUpdateRequest extends FormRequest
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
            'first_name' => ['required', 'max:30', 'string'],
            'last_name' => ['required', 'max:30', 'string'],
            'email' => ['required', 'max:30', 'email', Rule::unique('users')->ignore($this->user)],
            'telephone' => ['required', 'regex:/^\+55[0-9]{10,11}$/', 'string'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'password_confirmation' => [Rule::requiredIf($this->input('password') != null), 'string', 'min:8'],
        ];
    }
}
