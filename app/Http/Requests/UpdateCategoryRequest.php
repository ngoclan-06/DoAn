<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
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
            // 'image' => 'required',
            'status' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'max' => 'Vui lòng không nhập quá 255 kí tự',
            'status.required' => 'Vui lòng chọn trạng thái cho banner.',
            // 'image.required' => 'Vui lòng chọn ảnh.',
            // 'unique' => 'Tên danh mục đã tồn tại. Vui lòng nhập tên danh mục khác.'
        ];
    }
}
