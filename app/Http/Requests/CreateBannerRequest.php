<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBannerRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:banners,title',
            'description' => 'required|string|max:255',
            'status' => 'required',
            'image' => 'required'
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'Vui lòng nhập tiêu đề.',
            'max' => 'Vui lòng không nhập quá 255 kí tự',
            'description.required' => 'Vui lòng nhập mô tả chi tiết tấm banner.',
            'status.required' => 'Vui lòng chọn trạng thái cho banner.',
            'image.required' => 'Vui lòng chọn ảnh.',
            'unique' => 'Tên banner đã tồn tại. Vui lòng nhập tên banner khác.'
        ];
    }
}
