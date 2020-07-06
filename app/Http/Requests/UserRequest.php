<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
      $rules = [
        'email'                 => 'required|email',
        'password'              => 'required|min:6',
        'password_confirmation' => 'filled',
      ];

      if ($this->password_confirmation) {
        $rules['name']      = 'required|max:20';
        $rules['email']     = 'required|email|unique:users';
        $rules['password']  = 'required|min:6|confirmed';
      }

      return $rules;
    }
}
