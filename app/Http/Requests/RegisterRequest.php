<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name'=>'required|max:255|string',
            'email'=>'required|max:255|string|email|unique:users,email',
            'password'=>'required|string|min:8|confirmed',
            'phone_number'=> 'required|string|digits_between:10,15',


        ];

    }
    public function messages()
    {
        return [
            'email.unique' => 'This email is already taken.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'phone_number.digits_between' => 'Phone number must be between 10 and 15 digits.',
        ];

    }
}
