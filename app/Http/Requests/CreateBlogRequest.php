<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBlogRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:blog,name',
            'image' => 'required',
            'content' => 'required|string',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên bài viết.',
            'image.required' => 'Vui lòng chọn ảnh.',
            'content.required' => 'Vui lòng nhập nội dung cho bài viết.',
            'unique' => 'Tên bài viết này đã tồn tại. Vui lòng nhập lại tên bài viết.'
        ];
    }
}
