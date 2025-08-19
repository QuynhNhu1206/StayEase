<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class DanhGiaRequest extends FormRequest
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
            'id_users'=>'required',
            'noi_dung'=>'required|string'
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute: không được để trống',
        ];
    }

    public function attributes()
    {
        return [
            'id_phong'=>'Mã phòng trọ',
            'id_users'=>'Mã user',
            'noi_dung'=>'Nội dung đánh giá'
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
