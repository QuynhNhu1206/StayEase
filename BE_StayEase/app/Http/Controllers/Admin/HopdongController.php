<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HopDongRequest;
use App\Models\HopDong;
use Dompdf\Dompdf;
use Dompdf\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\File;

class HopdongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hopdong = DB::table('hopdongs')
                ->join('users as chu', 'hopdongs.id_chu_tro', '=', 'chu.id')
                ->join('users as khach', 'hopdongs.id_khach_thue', '=', 'khach.id')
                ->join('phongtro', 'hopdongs.id_phong', '=', 'phongtro.id')
                ->select(
                    'hopdongs.*',
                    'chu.name as ten_chu_tro',
                    'khach.name as ten_khach_thue',
                    'phongtro.ten_phong_tro'
                )
                ->get();

        return response()->json([
            'status' => 'success',
            'data' => $hopdong
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $existContract = HopDong::where('id_phong', $request->id_phong)->first();

        if ($existContract) {
            return response()->json([
                'status' => 'error',
                'message' => 'Phòng này đã có hợp đồng, không thể tạo thêm.'
            ], 400);
        }
        // B1: Lưu thông tin hợp đồng vào DB
        $hopDong = HopDong::create([
            'ma_hop_dong' => 'HD-' . time(),
            'id_chu_tro' => $request->id_chu_tro,
            'id_khach_thue' => $request->id_khach_thue,
            'id_phong' => $request->id_phong,
            'ngay_ky' => $request->ngay_ky,
            'ngay_bat_dau' => $request->ngay_bat_dau,
            'ngay_ket_thuc' => $request->ngay_ket_thuc,
            'gia_thue' => $request->gia_thue,
            'tien_coc' => $request->tien_coc,
            'hinh_thuc_thanh_toan' => $request->hinh_thuc_thanh_toan,
            'noi_dung' => $request->noi_dung,
        ]);

        // B2: Tạo thư mục lưu file
        $folderPath = public_path("upload/hopdong/{$hopDong->ma_hop_dong}");
        if (!file_exists($folderPath)) {
            mkdir($folderPath, 0777, true);
        }

        // B3: Sinh nội dung Word từ HTML
        $phpWord = new PhpWord();
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(13);

        $section = $phpWord->addSection();
        Html::addHtml($section, $hopDong->noi_dung, false, false);

        // Đường dẫn file
        $docxPath = "$folderPath/hopdong.docx";
        $pdfPath  = "$folderPath/hopdong.pdf";

        // B4: Xuất file DOCX
        $writerDocx = IOFactory::createWriter($phpWord, 'Word2007');
        $writerDocx->save($docxPath);

        // B6: Xuất file PDF (dùng Dompdf)
        $options = new Options();
        $options->set('defaultFont', 'DejaVu Sans'); // font hỗ trợ tiếng Việt
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($hopDong->noi_dung, 'UTF-8');
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        file_put_contents($pdfPath, $dompdf->output());

        // B7: Lưu đường dẫn vào DB
        $hopDong->update([
            'file_word' => "upload/hopdong/{$hopDong->ma_hop_dong}/hopdong.docx",
            'file_pdf'  => "upload/hopdong/{$hopDong->ma_hop_dong}/hopdong.pdf",
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Tạo hợp đồng thành công',
            // 'data' => $hopDong
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $ma_hop_dong)
    {
        $checkContract = HopDong::where('ma_hop_dong', $ma_hop_dong)->first();
        if(!$checkContract) {
            return response()->json([
                'status'    => 404,
                'message'   => "Không tìm thấy hợp đồng để cập nhật!"
            ]);
        }

        if($checkContract->trang_thai == "Chua hieu luc") {
            $checkContract->trang_thai = "Hieu luc";
        } else if($checkContract->trang_thai == "Hieu Luc") {
            $checkContract->trang_thai = "Het han";
        } else {
            $checkContract->trang_thai = "Huy";
        }
        $checkContract->save();
        return response()->json([
            'status'    => 200,
            'message'   => "Đã cập nhật thành công hợp đồng " . $ma_hop_dong . "!"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $ma_hop_dong)
    {
        $checkContract = HopDong::where('ma_hop_dong', $ma_hop_dong)->where('trang_thai', 'Chua hieu luc')->first();
        if(!$checkContract) {
            return response()->json([
                'status'    => 404,
                'message'   => "Không tìm thấy hợp đồng để xóa!"
            ]);
        }

        $folderPath = public_path('upload/hopdong/' . $ma_hop_dong);
        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath); // Xóa cả thư mục
        }

        $checkContract->delete();

        return response()->json([
            'status'    => 200,
            'message'   => "Đã xóa thành công hợp đồng " . $ma_hop_dong . "!"
        ]);
    }
}
