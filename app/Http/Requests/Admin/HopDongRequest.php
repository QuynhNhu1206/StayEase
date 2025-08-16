<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class HopDongRequest extends FormRequest
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
            'ten_hop_dong'=>'required',
            'start_date'=>'required',
            'end_date'=>'required',
            'tien_coc'=>'required',
            'tien_phong'=>'required',
            'trang_thai'=>'required',
            'file_hop_dong' => 'required|file|mimes:pdf,doc,docx|max:2048'

        ];
    }
    public function messages()
    {
        return [
            'required'=>':attribute: không được để trống',
            'file' => ':attribute: :file upload lên phải là tệp',
            'mimes' => ':attribute: :file upload lên phải là các định dạng sau: pdf, doc, docx',
            'file_hop_dong.max' => ':attribute: file upload lên vượt qua kích thước cho phép :max'
        ];
    }

    public function attributes()
    {
        return [
            'id_phong'=>'Mã phòng',
            'id_users'=>'Mã user',
            'ten_hop_dong'=>'Tên hợp đồng',
            'start_date'=>'Ngày bắt đầu',
            'end_date'=>'Ngày kết thúc',
            'tien_coc'=>'Tiền cọc',
            'tien_phong'=>'Tiền phòng',
            'trang_thai'=>'Trạng thái',
            'file_hop_dong'=>'File hợp đồng'
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
