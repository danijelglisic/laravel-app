<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\helper\UserPasswordRules;

class RegisterRequest extends FormRequest
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
            'name' => ['required'],
            'lastname' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'phone_number' => ['required', 'string'],
            'password' => UserPasswordRules::WITH_CONFIRMED()
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password needs to contain at least one uppercase letter,
            one number, and one special character (@,$,!,%,*,#,?,_,&)'
        ];
    }
}
