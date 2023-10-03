<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'email_address' => 'required|email|unique:users,email_address',
            // 'password' => 'required',
            'name' => 'required|max:255|string',
            'address' => 'required|max:255|string',
            'phone' => 'required|size:10',
            'role' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên của bạn.',
            'max' => 'Không nhập quá 255 kí tự',
            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'role.required' => 'Vui lòng chọn quyền đăng nhập',
            'email_address.required' => 'Vui lòng nhập email',
            'unique' => 'Email đã tồn tại.',
            'email' => 'Vui lòng nhập đúng định dạng email: abc@gmail.com',
            // 'password.required' => 'Vui lòng nhập password'
        ];
    }
}
