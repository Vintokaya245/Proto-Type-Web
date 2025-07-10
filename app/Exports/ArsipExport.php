<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ArsipExport implements FromCollection, WithHeadings, WithTitle, WithEvents, WithStyles
{
    protected $arsip;
    protected $periode;

    public function __construct($arsip, $periode = null)
    {
        $this->arsip = $arsip;
        $this->periode = $periode;
    }

    public function collection()
    {
        return $this->arsip->map(function($item, $i) {
            return [
                $i+1,
                $item->name,
                $item->kurun_waktu,
                $item->jumlah,
                $item->box,
                $item->description,
            ];
        });
    }

    public function headings(): array
    {
        return [
            ['DAFTAR ARSIP STATIS'],
            [$this->periode ? ('Periode : ' . $this->periode) : ''],
            ['No', 'Berkas/jenis Arsip', 'Kurun/Waktu', 'Jumlah', 'Box', 'Keterangan']
        ];
    }

    public function title(): string
    {
        return 'Daftar Arsip Statis';
    }

    public function registerEvents(): array
    {
        return [
            \Maatwebsite\Excel\Events\AfterSheet::class => function(\Maatwebsite\Excel\Events\AfterSheet $event) {
                // Merge judul dan periode
                $event->sheet->mergeCells('A1:F1');
                $event->sheet->mergeCells('A2:F2');
                $event->sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
                $event->sheet->getStyle('A3:F3')->getFont()->setBold(true);
            }
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['alignment' => ['horizontal' => 'center']],
            2 => ['alignment' => ['horizontal' => 'left']],
            3 => ['alignment' => ['horizontal' => 'center']],
        ];
    }
} 