<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegistrationRequest extends FormRequest
{

    protected $stopOnFirstFailure = true;

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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'address' => 'required',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required'
        ];
    }

    public function messages()
    {
        return [
             'name.required' => 'A név megadása kötelező!',
            'email.required' => 'Az email cím megadása kötelező!',
            'email.unique' => 'Ez az email cím már foglalt!',
            'email.email' => 'Ez az email cím nem valós!',
            'password.confirmed' => 'A két jelszó nem eggyezik!',
            'password.min' => 'A jelszó legalább 8 karakter kell legyen!'
        ];
    }
}
