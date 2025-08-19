<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HinhAnhPhongRequest extends FormRequest
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
            'image_url'=>'image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute: không được để trống',
            'image' => ':attribute: :hình ảnh upload lên phải là hình ảnh',
            'mimes' => ':attribute: :hình ảnh upload lên phải là các định dạng sau: jpeg, png, jpg',
            'image_url.max' => ':attribute: Hình ảnh upload lên vượt qua kích thước cho phép :max'
        ];
    }

    public function attributes()
    {
        return [
            'id_phong'=>'Mã phòng',
            'image_url'=>'Ảnh phòng'
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
