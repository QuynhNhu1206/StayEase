<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PhongTroRequest;
use App\Models\phongtro;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

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
        $phong_tro->id_users =$data['id_users'];
        $phong_tro->ten_phong_tro = $data['ten_phong_tro'];
        $phong_tro->dia_chi =$data['dia_chi'];
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


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
