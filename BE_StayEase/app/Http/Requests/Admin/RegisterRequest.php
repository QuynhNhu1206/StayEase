<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'username'=>'required|string|max:255',
            'name'=>'required|string|max:255',
            'ngay_sinh'=>'required|date',
            'email'=>'required|email',
            'que_quan'=> 'required',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string|min:8',
            'so_dien_thoai'=>'required|max:10',
            'gioi_tinh'=>'required',
            'cccd'=>'required|max:12'
        ];
    }

    public function messages(){
        return [
            'required' => ':attribute: không được để trống',
            'max' => ':attribute: không được vượt quá :max kí tự',
            'comfirmed' => ':attribute: không khớp với mật khẩu',
            'min' => ':attribute: tối thiếu là :min kí tự',
            'email.email' => ':attribute: :email sai định dạng'
        ];
    }

    public function attributes(){
        return [
            'username'=>'Tên đăng nhập',
            'name'=> 'Tên',
            'ngay_sinh'=>'Ngày sinh',
            'email' => 'Email',
            'que_quan' => 'Quê quán',
            'password' => 'Mật khẩu',
            'password_confirmation' => 'Xác nhận mật khẩu',
            'so_dien_thoai'=>'Só điện thoại',
            'gioi_tinh'=>'Giới tính',
            'cccd'=>'Căn cước công dân'
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
