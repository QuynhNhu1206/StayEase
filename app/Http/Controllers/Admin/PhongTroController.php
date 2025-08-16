<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PhongTroRequest;
use App\Http\Requests\Admin\QuyenRequest;
use App\Models\phongtro;
use App\Models\quyen;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

use function Whoops\Example\fooBar;

class PhongTroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = phongtro::all();
        return response()->json([
            'status' => 'success',
            'data' => $data
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PhongTroRequest $request)
    {
        $data = $request->all();
        $image = [];
        $maPhong = $request->ma_phong;
        if ($request->hasFile('anh_phong')) {

            foreach ($request->file('anh_phong') as $file) {
                $img = Image::make($file);
                $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalName();
                $dirPath = public_path('upload/anhphong/' . $maPhong);
                if (!file_exists($dirPath)) {
                    mkdir($dirPath, 0777, true);
                }
                $path = $dirPath . '/' . $name;
                $img->save($path);
                $image[] = $name;
            }
        }

        $phong_tro = new phongtro();
        $phong_tro->id_danh_muc = $data['id_danh_muc'];
        $phong_tro->ma_phong = $data['ma_phong'];
        $phong_tro->id_users = $data['id_users'];
        $phong_tro->ten_phong_tro = $data['ten_phong_tro'];
        $phong_tro->dia_chi = $data['dia_chi'];
        $phong_tro->anh_phong = json_encode($image);
        $phong_tro->mo_ta = $data['mo_ta'];
        $phong_tro->dien_tich = $data['dien_tich'];
        $phong_tro->gia_tien = $data['gia_tien'];
        $phong_tro->trang_thai = $data['trang_thai'];
        $phong_tro->so_luong_nguoi = $data['so_luong_nguoi'];
        $phong_tro->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm phòng trọ thành công',
            'data' => $phong_tro

        ], 201);
    }


    public function updatePhongTro(Request $request, $id)
    {
        $phongtro = phongtro::where('id', $id)->first();
        $maPhong = $phongtro->ma_phong;
        $data = $request->all();
        // clear image cũ
        // 2 trường hợp: 1 là gửi, 2 không gửi
        if ($request->hasFile('anh_phong')) {
            // split array data db
            $dataImageDB = json_decode($phongtro->anh_phong, true);
            // 1. Lấy danh sách tên ảnh cũ từ DB
            $resultNameImage = [];
            foreach ($dataImageDB as $file) {
                $parts = explode('.', $file);
                $resultNameImage[] = $parts[1] . '.' . $parts[2];
            }
            // 2. Lấy danh sách tên ảnh mới từ request
            $image = [];
            foreach ($request->file('anh_phong') as $file) {
                $image[] = $file->getClientOriginalName();
            }
            // 3. So sánh

            $diffNew = array_diff($image, $resultNameImage); // Ảnh mới xuất hiện
            $diffOld = array_diff($resultNameImage, $image); // Ảnh cũ bị xóa
            // Nếu đã gửi thì sẽ có 2 trường hợp
            if (empty($diffOld) && count($diffNew) === count($image)) {
                // ==== TRƯỜNG HỢP 1: Tất cả là ảnh mới ====
                // Xóa toàn bộ ảnh cũ vật lý
                foreach (json_decode($phongtro->anh_phong, true) as $oldFile) {
                    $path = public_path('upload/anhphong/' . $maPhong . '/' . $oldFile);
                    if (file_exists($path)) {
                        unlink($path);
                    }
                }

                // Upload và lưu toàn bộ ảnh mới
                $newImageNames = [];
                foreach ($request->file('anh_phong') as $file) {
                    $img = Image::make($file);
                    $name = time() . '_' . uniqid() . '.' . $file->getClientOriginalName();
                    $dirPath = public_path('upload/anhphong/' . $maPhong);
                    if (!file_exists($dirPath)) {
                        mkdir($dirPath, 0777, true);
                    }
                    $path = $dirPath . '/' . $name;
                    $img->save($path);
                    $newImageNames[] = $name;
                }
                $phongtro->anh_phong = json_encode($newImageNames);
            } else {
                // ==== TRƯỜNG HỢP 2: Có ảnh mới + ảnh cũ ====

                // 3.1 Xóa ảnh cũ bị loại bỏ
                foreach ($diffOld as $oldName) {
                    foreach (json_decode($phongtro->anh_phong, true) as $oldFullName) {
                        if (strpos($oldFullName, '.' . $oldName) !== false) {
                            $path = public_path('upload/anhphong/' . $maPhong . '/' . $oldFullName);
                            if (file_exists($path)) {
                                unlink($path);
                            }
                        }
                    }
                }

                // 3.2 Giữ ảnh cũ còn lại
                $finalImages = array_values(array_filter($dataImageDB, function ($oldFullName) use ($image) {
                    foreach ($image as $imgName) {
                        if (strpos($oldFullName, '.' . $imgName) !== false) {
                            return true;
                        }
                    }
                    return false;
                }));

                // 3.3 Upload ảnh mới và thêm vào danh sách
                foreach ($request->file('anh_phong') as $file) {
                    $name = $file->getClientOriginalName();

                    if (in_array($name, $diffNew)) {

                        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalName();

                        // Tạo đường dẫn thư mục theo mã phòng
                        $dirPath = public_path('upload/anhphong/' . $maPhong);
                        if (!file_exists($dirPath)) {
                            mkdir($dirPath, 0777, true);
                        }

                        // Lưu ảnh bằng Intervention Image
                        $img = Image::make($file);
                        $path = $dirPath . '/' . $filename;
                        $img->save($path);

                        // Lưu tên file vào mảng kết quả
                        $finalImages[] = $filename;
                    }
                }
                // 3.4 Cập nhật DB
                $phongtro->anh_phong = json_encode($finalImages);
            }
        } else {
            $phongtro->anh_phong = json_decode($phongtro->anh_phong);
        }

        $phongtro->id_danh_muc = $data['id_danh_muc'];
        $phongtro->ma_phong = $data['ma_phong'];
        $phongtro->id_users = $data['id_users'];
        $phongtro->ten_phong_tro = $data['ten_phong_tro'];
        $phongtro->dia_chi = $data['dia_chi'];
        $phongtro->mo_ta = $data['mo_ta'];
        $phongtro->dien_tich = $data['dien_tich'];
        $phongtro->gia_tien = $data['gia_tien'];
        $phongtro->trang_thai = $data['trang_thai'];
        $phongtro->so_luong_nguoi = $data['so_luong_nguoi'];
        $phongtro->save();

        return response()->json([
            'id' => $id,
            'status' => 'success',
            'message' => 'Cập nhật phòng trọ thành công',
            'data' => $phongtro

        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $phongtro = phongtro::findOrFail($id);

        if ($phongtro->delete()) {

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa phòng trọ thành công',
                'data' => phongtro::all()

            ], 200);
        }
    }
    
}
