<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ThietBiRequest extends FormRequest
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
            'id_phong'=>'required',
            'ten_thiet_bi'=>'required',
            'so_luong_thiet_bi'=>'required',
            'trang_thai'=>'required'
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
            'id_phong'=>'Mã phòng',
            'ten_thiet_bi'=>'Tên thiết bị',
            'so_luong_thiet_bi'=>'Số lượng thiết bị',
            'trang_thai'=>'Trạng thái'
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
