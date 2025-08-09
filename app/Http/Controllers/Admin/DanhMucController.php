<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DanhMucRequest;
use App\Models\danhmuc;
use Illuminate\Http\Request;
use PhpParser\Node\Stmt\TryCatch;

class DanhMucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $danhmuc = danhmuc::all();
        return response()->json([
            'status' => 'success',
            'data' => $danhmuc
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DanhMucRequest $request)
    {

        $danhmuc = DanhMuc::create($request->all());

        return response()->json([
            'status' => 'success',
            'message' => 'Thêm danh mục thành công',
            'data' => $danhmuc
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
