<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
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
            'admin_commission' => 'required' ,
            'marketer_commission' => 'required',
            'package_price' => 'required',
            'weight_avaliable' => 'required',
            'gram_price' => 'sometimes',
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
            'name.required' => 'الأسم مطلوب',
            'admin_commission.required' => 'عمولة الأدمن مطلوب',
            'marketer_commission.required' => 'عمولة المسوق مطلوب',
            'package_price.required' => 'سعر التغليف مطلوب',
            'weight_avaliable.required' => 'الوزن متاح مطلوب',
        ];
    }

}
