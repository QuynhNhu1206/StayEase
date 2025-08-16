<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ThietBiRequest;
use App\Models\thietbi;
use Illuminate\Http\Request;

class ThietBiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $thietbi = thietbi::all();
        return response()->json([
            'status' => 'success',
            'data' => $thietbi
        ]);
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
    public function store(ThietBiRequest $request)
{
    $data = $request->all();

    $thietBi = thietbi::where('id_phong', $data['id_phong'])
        ->where('ten_thiet_bi', $data['ten_thiet_bi'])
        ->first();

    if ($thietBi) {
        $thietBi->so_luong_thiet_bi += $data['so_luong_thiet_bi'];
        $thietBi->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Thiết bị đã tồn tại, cập nhật số lượng thành công',
            'data' => $thietBi
        ], 200);
    }

    $newThietBi = thietbi::create($data);

    return response()->json([
        'status' => 'success',
        'message' => 'Thêm thiết bị mới thành công',
        'data' => $newThietBi
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
        $id_tb = thietbi::findOrFail($id);
        $data = $request->all();
        if($id_tb->update($data)){
            return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thiết bị thành công',
            'data' => $data
    ], 201);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id_tb = thietbi::findOrFail($id);
        if($id_tb->delete()){
            return response()->json([
            'status' => 'success',
            'message' => 'Cập nhật thiết bị thành công',
            'data' => thietbi::all()
    ], 200);
        }
    }
}
