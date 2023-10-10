<?php

namespace App\Http\Requests;

use App\Http\Requests\helper\UserPasswordRules;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'current_password' => ['required'],
            'new_password' => UserPasswordRules::WITH_CONFIRMED(),
        ];
    }

    public function messages()
    {
        return [
            'password.regex' => 'Password needs to contain at least one uppercase letter,
            one number, and one special character (@,$,!,%,*,#,?,_,&)',
        ];
    }
}
