<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'weight' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'sometimes',
            'added_value' => 'required',
            'deducted_value' => 'required',
            'code' => "required|unique:products,id,{$this->id}",
            'image' => 'required',
            'stock' => 'required',
        ];
    }

    /**
     * Custom message for validation
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'weight.required' => 'الوزن مطلوب',
            'category_id.required' => 'التصنيف مطلوب',
            'added_value.required' => 'القيمة المضافة مطلوب',
            'deducted_value.required' => 'القيمة المخصصة مطلوبة',
            'code.required' => 'الرمز مطلوب',
            'code.unique' => 'الرمز مستخدم',
            'stock.required' => 'كمية المخزن مطلوبة',
            'image.required' => 'يجب ان يحتوي المنتج على صورة',
        ];
    }

}


