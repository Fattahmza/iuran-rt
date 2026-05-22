<?php

namespace App\Exports;

use App\Models\Iuran;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class IuranExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function query()
    {
        $query = Iuran::with('user');

        if ($this->request->bulan) {
            $query->where('bulan', $this->request->bulan);
        }
        if ($this->request->tahun) {
            $query->where('tahun', $this->request->tahun);
        }
        if ($this->request->status) {
            $query->where('status', $this->request->status);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No', 'NIK', 'Nama Warga', 'RT/RW', 'Bulan', 'Tahun',
            'Jumlah', 'Tanggal Bayar', 'Status', 'Jenis', 'Keterangan'
        ];
    }

    public function map($iuran): array
    {
        static $no = 1;
        return [
            $no++,
            $iuran->user->nik ?? '-',
            $iuran->user->name ?? '-',
            ($iuran->user->rt ?? '-') . '/' . ($iuran->user->rw ?? '-'),
            $iuran->bulan,
            $iuran->tahun,
            $iuran->jumlah,
            $iuran->tanggal_bayar ? $iuran->tanggal_bayar->format('d/m/Y') : '-',
            $iuran->status,
            $iuran->jenis,
            $iuran->keterangan ?? '-'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4CAF50']]],
        ];
    }
}
