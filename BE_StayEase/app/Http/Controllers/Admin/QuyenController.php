<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\QuyenRequest;
use App\Models\quyen;
use Illuminate\Http\Request;

class QuyenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $quyen = quyen::all();
        return response()->json([
            'status'=>'success',
            'data'=>$quyen
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {


    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(QuyenRequest $request)
    {
        $quyen = quyen::create($request->all());
        return response()->json([
            'status'=>'success',
            'message'=>'Thêm quyền thành công',
            'data'=>$quyen
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
    public function update(QuyenRequest $request, string $id)
    {
         $quyens = quyen::findOrFail($id);
        $data = $request->all();
        if ($quyens->update($data)) {
            return response()->json([
                'id' => $id,
                'status' => 'Success',
                'message' => 'Cập nhật quyền thành công',
                'data' => $data
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
         $quyen = quyen::findOrFail($id);

        if ($quyen->delete()) {

            return response()->json([
                'status' => 'success',
                'message' => 'Xóa phòng trọ thành công',
                'data' => quyen::all()

            ], 200);
        }
    }
}
