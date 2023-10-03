<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email_address' => 'required|email',
            'password' => 'required',
        ];
    }

    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function messages()
    {
        return [
            'email_address.required' => 'Vui lòng nhập tên email.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'email' => 'Vui lòng nhập đúng định dạng email: example@gmail.com.',
        ];
    }
}
