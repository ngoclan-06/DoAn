<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email_address' => 'required|email|unique:users,email_address',
            'password' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'password_confirmation' => 'required|same:password',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên.',
            'email_address.required' => 'Vui lòng nhập email.',
            'password.required' => 'Vui lòng nhập password.',
            'address.required' => 'Vui lòng nhập địa chỉ.',
            'phone.required' => 'VUi lòng nhập SĐT.',
            'unique' => 'Email này đã tồn tại. Vui lòng nhập lại!',
            'password_confirmation.required' => 'Vui lòng nhập password confirmation.',
            'same' => 'Không trùng khớp với password. Xin vui lòng nhập lại!'
        ];
    }
}
