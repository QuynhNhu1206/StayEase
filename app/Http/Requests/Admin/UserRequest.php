<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserRequest extends FormRequest
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
            'username'=>'required|string',
            'name'=>'required|string|max:255',
            'ngay_sinh'=>'required|date',
            'email'=>'required|email',
            'avatar'=>'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'password'=>'nullable|string',
            'que_quan'=>'required|string',
            'so_dien_thoai'=>'required|string',
            'gioi_tinh'=>'required',
            'cccd'=>'required|string'
        ];
    }

    public function messages()
    {
        return [
            'required'=>':attribute: không được để trống',
            'max'=>':attribute: không được vượt quá giới hạn kí tự :max',
            'date'=>':attribute: không đúng định dạng ngày tháng',
            'email'=>':attribute: không đúng định dạng email',
            'unique'=>':attribute: đã tồn tại',
            'image' => ':attribute: :hình ảnh upload lên phải là hình ảnh',
            'mimes' => ':attribute: :hình ảnh upload lên phải là các định dạng sau: jpeg, png, jpg',
            'avatar.max' => ':attribute: Hình ảnh upload lên vượt qua kích thước cho phép :max'
        ];
    }

    public function attributes()
    {
        return [
            'username'=>'Tên đăng nhập',
            'name'=>'Họ và tên',
            'ngay_sinh'=>'Ngày sinh',
            'email'=>'Email',
            'password'=>'Password',
            'que_quan'=>'Quê quán',
            'so_dien_thoai'=>'Số điện thoại',
            'gioi_tinh'=>'Giới tính',
            'cccd'=>'CCCD',
            'avatar' => 'Ảnh đại diện'
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
