<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Http\Requests\Request;
class UserUpdateRequest extends FormRequest
{
    public function authorize()
	{
		return true;
	}

	public function rules()
	{
		//$id = $this->user;
		return [
			'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6' 
		];
	}
	public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required!'
        ];
	}

}
