<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            // 'current_password' => 'required',
            // 'new_password' => 'required|string|min:8',
            // 'password_confirmation' => 'required|same:new_password'
            'current_password' => 'required|regex:' . config('const.password_regex'),
            'new_password' => 'required|string|min:6|regex:' . config('const.password_regex'),
            'password_confirmation' => 'required|same:new_password|regex:' . config('const.password_regex')
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
            'current_password.required' => 'Vui lòng nhập mật khẩu hiện tại.',
            'current_password.regex' => 'Vui lòng nhập mật khẩu ít nhất 6 ký tự bao gồm chữ hoa, chữ thường và ký tự đặc biệt.',
            'new_password.required' => 'Vui lòng nhập mật khẩu mới.',
            'new_password.regex' => 'Vui lòng nhập mật khẩu ít nhất 6 ký tự bao gồm chữ hoa, chữ thường và ký tự đặc biệt.',
            'password_confirmation.required' => 'Vui lòng nhập xác nhận mật khẩu.',
            'password_confirmation.regex' => 'Vui lòng nhập mật khẩu ít nhất 6 ký tự bao gồm chữ hoa, chữ thường và ký tự đặc biệt.',
            'min' => 'Password phải tối thiểu 6 ký tự.',
            'same' => 'Mật khẩu xác nhận và mật khẩu mới phải khớp nhau.'
        ];
    }
}
