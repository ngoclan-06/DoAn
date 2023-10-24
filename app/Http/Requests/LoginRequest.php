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
            // 'email_address' => 'required|email',
            'email_address' => 'required|max:255|regex:' . config('const.regex_email_admin'),
            // 'password' => 'required',
            'password' => 'required|regex:' . config('const.password_regex'),
            // 'password' => 'required|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/'
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
            'email_address.regex' => 'Vui lòng nhập đúng định dạng email.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.regex' => 'Vui lòng nhập mật khẩu ít nhất 6 ký tự bao gồm chữ hoa, chữ thường và ký tự đặc biệt.',
            'email' => 'Vui lòng nhập đúng định dạng email: example@gmail.com.',
        ];
    }
}
