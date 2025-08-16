<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PhongTroRequest extends FormRequest
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
            'ma_phong' => 'required|string',
            'id_danh_muc' => 'required',
            'id_users' => 'required',
            'ten_phong_tro' => 'required|string',
            'dia_chi' => 'required|string',
            'anh_phong' => 'nullable|array',
            'anh_phong.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'mo_ta' => 'nullable|string',
            'dien_tich' => 'required',
            'gia_tien' => 'required',
            'trang_thai' => 'required|integer',
            'so_luong_nguoi' => 'required|integer'
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute: không được để trống',
            'anh_phong.*.image' => ':attribute phải là file ảnh',
            'anh_phong.*.mimes' => ':attribute chỉ chấp nhận jpeg, png, jpg, gif',
            'anh_phong.*.max' => ':attribute không được vượt quá 2MB',
        ];
    }

    public function attributes()
    {
        return [
            'ma_phong' => 'Mã phòng',
            'id_danh_muc' => 'Mã danh mục',
            'id_user' => 'Mã user',
            'ten_phong_tro' => 'Tên phòng trọ',
            'dia_chi' => 'Địa chỉ',
            'anh_phong' => 'Ảnh phòng',
            'mo_ta' => 'Mô tả',
            'dien_tich' => 'Diện tích',
            'gia_tien' => 'Giá tiền',
            'trang_thai' => 'Trạng thái',
            'so_luong_nguoi' => 'Số lượng người'
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
