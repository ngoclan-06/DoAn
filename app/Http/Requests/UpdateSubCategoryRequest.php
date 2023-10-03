<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubCategoryRequest extends FormRequest
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

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            // 'image' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            // 'image.required' => 'Vui lòng chọn ảnh.',
            // 'unique' => 'Tên danh mục này đã tồn tại. Vui lòng nhập lại tên danh mục.'
        ];
    }
}
