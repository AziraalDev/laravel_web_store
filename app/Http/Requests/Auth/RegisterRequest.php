<?php

namespace App\Http\Requests\Auth;

use App\Rules\PhoneNumber;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true; // temporarily (no users)
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:35'],
            'lastname' => ['required', 'string', 'max:35'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', new PhoneNumber],
            'birthday' => ['required', 'date', 'before_or_equal:-18 years'], // Adults only
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }
}
