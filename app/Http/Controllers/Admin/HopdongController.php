<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\HopDongRequest;
use App\Models\HopDong;
use Dompdf\Dompdf;
use Illuminate\Http\Request;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\Shared\Html;
use PhpOffice\PhpWord\IOFactory;

class HopdongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hopdong = HopDong::select('id_phong', 'id_users', 'start_date', 'end_date', 'tien_phong', 'trang_thai');
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
        $folderPath = public_path("upload/hopdong/{$hopDong->id}");
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
        $rtfPath  = "$folderPath/hopdong.rtf";
        $pdfPath  = "$folderPath/hopdong.pdf";

        // B4: Xuất file DOCX
        $writerDocx = IOFactory::createWriter($phpWord, 'Word2007');
        $writerDocx->save($docxPath);

        // B5: Xuất file RTF
        $writerRtf = IOFactory::createWriter($phpWord, 'RTF');
        $writerRtf->save($rtfPath);

        // B6: Xuất file PDF (dùng Dompdf)
        $dompdf = new Dompdf();
        $dompdf->loadHtml($hopDong->noi_dung);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        file_put_contents($pdfPath, $dompdf->output());

        // B7: Lưu đường dẫn vào DB
        $hopDong->update([
            // 'file_url' => [
            //     'docx' => asset("upload/hopdong/{$hopDong->id}/hopdong.docx"),
            //     'rtf'  => asset("upload/hopdong/{$hopDong->id}/hopdong.rtf"),
            //     'pdf'  => asset("upload/hopdong/{$hopDong->id}/hopdong.pdf"),
            // ]
            'file_word' => asset("upload/hopdong/{$hopDong->id}/hopdong.docx"),
            'file_pdf'  => asset("upload/hopdong/{$hopDong->id}/hopdong.pdf"),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Tạo hợp đồng thành công',
            'data' => $hopDong
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HopDongRequest $request) {}

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
