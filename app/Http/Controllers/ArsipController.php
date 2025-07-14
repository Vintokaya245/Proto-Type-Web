<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\Periode;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// =============================
// Controller untuk manajemen Arsip Statis
// Berisi fitur: list, tambah, edit, hapus, export Excel, dsb.
// =============================

class ArsipController extends Controller
{
    /**
     * Menampilkan daftar arsip (dengan filter & pencarian)
     */
    public function index(Request $request)
    {
        // Ambil semua periode untuk filter
        $periodes = Periode::all();
        // Query data arsip (relasi ke periode)
        $query = Arsip::with('periode');
        // Filter berdasarkan periode jika dipilih
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }
        // Fitur pencarian (lihat penjelasan di bawah)
        if ($request->has('q') && trim($request->q) !== '') {
            $q = trim($request->q);

            // Deteksi input seperti "box 27" (case-insensitive)
            if (preg_match('/^box\s*(\d+)$/i', $q, $matches)) {
                $query->where('box', $matches[1]);
            }
            // Deteksi input seperti "jumlah:1 BUKU" atau "box:27"
            elseif (preg_match('/^([a-zA-Z_]+):(.*)$/', $q, $matches)) {
                $field = strtolower(trim($matches[1]));
                $value = trim($matches[2]);
                $allowed = ['name', 'description', 'kurun_waktu', 'jumlah', 'box'];
                if (in_array($field, $allowed)) {
                    $query->where($field, 'like', "%$value%");
                } else {
                    // fallback ke global
                    $query->where(function($sub) use ($q) {
                        $sub->where('name', 'like', "%$q%")
                            ->orWhere('description', 'like', "%$q%")
                            ->orWhere('kurun_waktu', 'like', "%$q%")
                            ->orWhere('jumlah', 'like', "%$q%")
                            ->orWhere('box', 'like', "%$q%")
                        ;
                    });
                }
            } else {
                // global search
                $query->where(function($sub) use ($q) {
                    $sub->where('name', 'like', "%$q%")
                        ->orWhere('description', 'like', "%$q%")
                        ->orWhere('kurun_waktu', 'like', "%$q%")
                        ->orWhere('jumlah', 'like', "%$q%")
                        ->orWhere('box', 'like', "%$q%")
                    ;
                });
            }
        }
        $arsip = $query->paginate(10)->withQueryString();
        return view('arsip.index', compact('arsip', 'periodes'));
    }

    /**
     * Menampilkan form tambah arsip
     */
    public function create()
    {
        $periodes = Periode::all();
        return view('arsip.create', compact('periodes'));
    }

    /**
     * Simpan data arsip baru ke database
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,id',
            'description' => 'nullable|string',
            'kurun_waktu' => 'nullable|string',
            'jumlah' => 'nullable|string',
            'box' => 'nullable|string'
        ]);

        $data = $request->only(['name', 'periode_id', 'description', 'kurun_waktu', 'jumlah', 'box']);
        Arsip::create($data);
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail arsip (jika ada)
     */
    public function show(Arsip $arsip)
    {
        return view('arsip.show', compact('arsip'));
    }

    /**
     * Tampilkan form edit arsip
     */
    public function edit(Arsip $arsip)
    {
        $periodes = Periode::all();
        return view('arsip.edit', compact('arsip', 'periodes'));
    }

    /**
     * Update data arsip di database
     */
    public function update(Request $request, Arsip $arsip)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'periode_id' => 'required|exists:periode,id',
            'description' => 'nullable|string',
            'kurun_waktu' => 'nullable|string',
            'jumlah' => 'nullable|string',
            'box' => 'nullable|string'
        ]);

        $data = $request->only(['name', 'periode_id', 'description', 'kurun_waktu', 'jumlah', 'box']);
        $arsip->update($data);
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil diupdate!');
    }

    /**
     * Hapus data arsip dari database
     */
    public function destroy(Arsip $arsip)
    {
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus!');
    }

    /**
     * Export data arsip ke file Excel (menggunakan PhpSpreadsheet)
     * - Bisa filter periode
     * - Format tabel, judul, styling, dsb
     */
    public function downloadExcel(Request $request)
    {
        $query = Arsip::with('periode');
        if ($request->filled('periode_id')) {
            $query->where('periode_id', $request->periode_id);
        }
        $arsip = $query->get();

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Judul besar
        $sheet->setCellValue('A2', 'DAFTAR ARSIP STATIS');
        $sheet->mergeCells('A2:F2');
        $sheet->getStyle('A2')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Subjudul/periode
        $periodeText = '';
        if ($request->filled('periode_id')) {
            $periode = \App\Models\Periode::find($request->periode_id);
            if ($periode) {
                $periodeText = 'Periode : ' . $periode->name;
            }
        } else {
            $periodeText = 'Periode : Semua Periode';
        }
        $sheet->setCellValue('A3', $periodeText);
        $sheet->mergeCells('A3:F3');
        $sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

        // Spasi sebelum tabel
        $startRow = 5;

        // Header tabel
        $header = ['No', 'Berkas/jenis Arsip', 'Kurun/Waktu', 'Jumlah', 'Box', 'Keterangan'];
        $sheet->fromArray($header, null, "A{$startRow}");
        $sheet->getStyle("A{$startRow}:F{$startRow}")->getFont()->setBold(true);
        $sheet->getStyle("A{$startRow}:F{$startRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle("A{$startRow}:F{$startRow}")->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle("A{$startRow}:F{$startRow}")->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFEFEFEF');

        // HEADER: warna hijau muda, font bold, border bawah tebal, border lain tipis
        $headerStyle = [
            'font' => [
                'bold' => true,
                'size' => 16,
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
            'fill' => [
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => [
                    'rgb' => 'D9EAD3', // hijau muda
                ],
            ],
            'borders' => [
                'top' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'B7B7B7'],
                ],
                'left' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'B7B7B7'],
                ],
                'right' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'B7B7B7'],
                ],
                'bottom' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle("A{$startRow}:F{$startRow}")->applyFromArray($headerStyle);

        // Data
        $row = $startRow + 1;
        foreach ($arsip as $i => $item) {
            $sheet->setCellValue('A'.$row, $i+1);
            $sheet->setCellValue('B'.$row, str_replace(["\n", "\r"], '', $item->name));
            $sheet->setCellValue('C'.$row, $item->kurun_waktu);
            $sheet->setCellValue('D'.$row, $item->jumlah);
            $sheet->setCellValue('E'.$row, $item->box);
            $sheet->setCellValue('F'.$row, $item->description);
            $row++;
        }
        $lastRow = $row - 1;

        // DATA: border tipis semua sisi, font besar, tanpa striped
        $dataStyle = [
            'font' => [
                'size' => 16,
            ],
            'alignment' => [
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                'indent' => 1,
                'wrapText' => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => 'B7B7B7'],
                ],
            ],
        ];
        for ($i = $startRow + 1; $i <= $lastRow; $i++) {
            $sheet->getStyle("A{$i}:F{$i}")->applyFromArray($dataStyle);
            // Kolom angka rata tengah
            $sheet->getStyle("C{$i}:F{$i}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        }

        // Kolom header angka rata tengah
        $sheet->getStyle("C{$startRow}:F{$startRow}")->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Perbesar padding/tinggi baris
        for ($i = $startRow + 1; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(28);
        }
        $sheet->getRowDimension($startRow)->setRowHeight(32);

        // Font seluruh sheet besar
        $sheet->getStyle("A2:F{$lastRow}")->getFont()->setName('Calibri')->setSize(16);

        // Kolom nama arsip tetap lebar
        $sheet->getColumnDimension('B')->setWidth(70);

        // Auto width kolom, kecuali kolom nama arsip diatur manual
        $sheet->getColumnDimension('A')->setWidth(5);   // No
        foreach (['C', 'D', 'E', 'F'] as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        // Tinggi baris header & judul
        $sheet->getRowDimension(2)->setRowHeight(28);
        $sheet->getRowDimension($startRow)->setRowHeight(22);

        // Font seluruh sheet
        $sheet->getStyle("A2:F{$lastRow}")->getFont()->setName('Calibri')->setSize(11);

        // Perbesar font seluruh sheet
        $sheet->getStyle("A2:F{$lastRow}")->getFont()->setName('Calibri')->setSize(16); // font lebih besar

        // Perbesar tinggi baris judul, header, dan data
        $sheet->getRowDimension(2)->setRowHeight(40); // Judul
        $sheet->getRowDimension($startRow)->setRowHeight(32); // Header
        for ($i = $startRow + 1; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(28); // Data
        }

        // Perbesar lebar kolom
        $sheet->getColumnDimension('A')->setWidth(8);   // No
        $sheet->getColumnDimension('B')->setWidth(55);  // Nama arsip
        $sheet->getColumnDimension('C')->setWidth(17.57); // Kurun/Waktu
        $sheet->getColumnDimension('D')->setWidth(12.86); // Jumlah
        $sheet->getColumnDimension('E')->setWidth(11.00); // Box
        $sheet->getColumnDimension('F')->setWidth(16.29); // Keterangan

        // Set semua row height menjadi 63 (Excel points)
        for ($i = $startRow; $i <= $lastRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(63);
        }
        // Set semua column width A-F menjadi 57.14 (Excel width)
        foreach (range('A', 'F') as $col) {
            $sheet->getColumnDimension($col)->setWidth(57.14);
        }

        // Set lebar kolom A menjadi 7.29 (Excel width), kolom B-F tetap 57.14
        $sheet->getColumnDimension('A')->setWidth(7.29);
        // Hapus pengaturan width massal agar tidak menimpa pengaturan width spesifik
        // foreach (range('B', 'F') as $col) {
        //     $sheet->getColumnDimension($col)->setWidth(57.14);
        // }

        // Set khusus baris 4 dan 5 (header dan judul kolom) row height menjadi 16.5 (Excel points)
        $sheet->getRowDimension(4)->setRowHeight(16.5);
        $sheet->getRowDimension(5)->setRowHeight(16.5);

        // Border hitam untuk seluruh tabel (header dan data)
        $blackBorder = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle("A{$startRow}:F{$lastRow}")->applyFromArray($blackBorder);

        // Download response
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'Daftar Arsip Statis.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        $writer->save('php://output');
        exit;
    }
}
