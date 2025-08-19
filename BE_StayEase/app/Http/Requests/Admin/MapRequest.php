<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class MapRequest extends FormRequest
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
            'ma_map'=>'required',
            'dia_chi'=>'required',
            'quan_huyen'=>'required',
            'kinh_do'=>'required',
            'vi_do'=>'required',
            'tinh_tp'=>'required',
            'xa_phuong'=>'required'
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute: không được để trống'
        ];
    }

    public function attributes()
    {
        return [
            'ma_map'=>'Mã map',
            'dia_chi'=>'Địa chỉ',
            'quan_huyen'=>'Quận/huyện',
            'kinh_do'=>'Kinh độ',
            'vi_do'=>'Vĩ độ',
            'tinh_tp'=>'Tỉnh/TP',
            'xa_phuong'=>'Xã/phường'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'fail',
            'message' => 'Dữ liệu không hợp lệ',
            'errors' => $validator->errors()
        ],422));
    }
}
