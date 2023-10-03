<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductsRequest extends FormRequest
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
            'description' => 'required|string|max:1200',
            'price' => 'required|numeric|min:0',
            'date_of_manufacture' => 'required|date|before:expiry',
            'quantity' => 'required|integer',
            'expiry' => 'required|date|after:date_of_manufacture',
            'status' => 'required',
            'sub_categories_id' => 'required',
            // 'image' => 'required',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'quantity.required' => 'Vui lòng nhập số lượng sản phẩm.',
            'description.required' => 'Vui Lòng nhập mô tả sản phẩm',
            'integer' => 'Số lượng sản phẩm dạng số nguyên',
            'price.required' => 'Vui lòng nhập giá.',
            'price.numeric' => 'Giá phải là số.',
            'price.min' => 'Giá không thể âm.',
            'date_of_manufacture.required' => 'Vui lòng nhập ngày sản xuất.',
            'date_of_manufacture.date' => 'Ngày sản xuất không hợp lệ.',
            'expiry.required' => 'Vui lòng nhập ngày hết hạn.',
            'expiry.date' => 'Ngày hết hạn không hợp lệ.',
            'after' => 'Ngày hết hạn phải sau ngày sản xuất.',
            'before' => 'Ngày sản xuất phải trước ngày hết hạn.',
            // 'image.required' => 'Vui lòng chọn ảnh.'
        ];
    }
}
