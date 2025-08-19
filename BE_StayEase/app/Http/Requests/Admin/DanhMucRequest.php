<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DanhMucRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'ma_danh_muc'=>'required|string',
            'ten_danh_muc'=>'required|string|max:255',
            'trang_thai'=>'required|integer',
            'mota'=>'nullable|string'
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attibute: không được để trống',
            'max'=>':attribute: không được vượt quá :max kí tự',
            'integer'=>':attribute: không được sai định dạng'
        ];
    }


    public function attributes()

    {
        return [
            'ma_danh_muc' => 'Mã danh mục',
            'ten_danh_muc' => 'Tên danh mục',
            'trang_thai' => 'Trạng thái',
            'mo_ta'=>'Mô tả'
        ];
    }

     protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'fail',
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $validator->errors()
        ], 422));
    }
}
