<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dwor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class DworController extends Controller
{
    private function getTahun($table)
    {
        return DB::table($table)
            ->selectRaw('DISTINCT YEAR(tgl_registrasi) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    private function getTahun2($table)
    {
        return DB::table($table)
            ->selectRaw('DISTINCT YEAR(tgl_masuk) as year')
            ->orderBy('year', 'desc')
            ->pluck('year');
    }
    
    private function getBulan()
    {
        return [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
    }

    private function fetchFilteredData($table, $year, $month)
    {
        return DB::table($table)
            ->whereYear('tgl_registrasi', $year)
            ->whereMonth('tgl_registrasi', $month)
            ->orderBy('tgl_registrasi', 'asc')
            ->get();
    }

    private function prepareChartData($data, $columns)
    {
        $chartData = [
            'tanggal' => $data->pluck('tgl'),
        ];

        foreach ($columns as $column) {
            $chartData[$column] = $data->pluck($column)->map(function ($value) {
                return intval($value);
            });
        }

        return $chartData;
    }

    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchFilteredData('dwor_jkp', $year, $month);
        $chartData = $this->prepareChartData($data, ['total']);

        $years = $this->getTahun('dwor_jkp');
        $months = $this->getBulan();

        return view('dwor.dwor', [
            'chartData' => $chartData,
            'dwor' => $data,
            'judul' => 'index',
            'xjudul' => "Secara Total",
            'tahun' => $years,
            'bulan' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }

    public function utama(Request $request, $poli)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchFilteredData('dwor_jkp', $year, $month);
        $poliColumn = $this->getPoliColumn($poli);
        $chartData = $this->prepareChartData($data, ['total', $poliColumn]);

        $years = $this->getTahun('dwor_jkp');
        $months = $this->getBulan();
        $poliInfo = $this->getPoliInfo($poli);

        return view('dwor.dwor_poli', [
            'chartData' => $chartData,
            'judul' => 'index',
            'xjudul' => $poliInfo['nama'],
            'tahun' => $years,
            'bulan' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'selectedPoli' => $poli,
        ]);
    }

    public function bor(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchFilteredData('dwor_bor_2', $year, $month);
        $columns = [
            'total', 'igd', 'perinatologi', 'poli_anak', 'poli_bedah', 'poli_gigi_umum',
            'poli_jantung', 'poli_konservasi_gigi', 'poli_kulit_kelamin', 'poli_kusta',
            'poli_mata', 'poli_obgyn', 'poli_orthopedi', 'poli_peny_dalam', 'poli_tb',
            'poli_tht_kl', 'poli_umum', 'rehab_medik'
        ];
        $chartData = $this->prepareChartData($data, $columns);

        $years = $this->getTahun('dwor_bor_2');
        $months = $this->getBulan();

        return view('dwor.bor', [
            'chartData' => $chartData,
            'dwor' => $data,
            'judul' => 'bor',
            'tahun' => $years,
            'bulan' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }

    public function jri(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $startDate = Carbon::create($year, $month, 1)->startOfMonth();
        $endDate = $startDate->copy()->endOfMonth();

        $data = DB::table('dwor_inap')
            ->select('tgl_masuk', 'tgl_keluar')
            ->where(function ($query) use ($startDate, $endDate) {
                $query->whereBetween('tgl_masuk', [$startDate, $endDate])
                    ->orWhereBetween('tgl_keluar', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        $q->where('tgl_masuk', '<', $startDate)
                            ->where(function ($inner) use ($endDate) {
                                $inner->where('tgl_keluar', '>', $endDate)
                                    ->orWhereNull('tgl_keluar');
                            });
                    });
            })
            ->get();

        $dateRange = collect(CarbonPeriod::create($startDate, $endDate));

        $jml = $dateRange->mapWithKeys(function ($date) use ($data) {
            $count = $data->filter(function ($item) use ($date) {
                $tgl_masuk = Carbon::parse($item->tgl_masuk)->startOfDay();
                $tgl_keluar = $item->tgl_keluar ? Carbon::parse($item->tgl_keluar)->startOfDay() : null;
                return $date->greaterThanOrEqualTo($tgl_masuk) &&
                    ($tgl_keluar === null || $date->lessThanOrEqualTo($tgl_keluar));
            })->count();
            return [$date->toDateString() => $count];
        });

        $years = $this->getTahun2('dwor_inap');
        $months = $this->getBulan();

        return view('dwor.jri', [
            'tanggal' => $dateRange->map->toDateString(),
            'jml' => $jml,
            'dwor' => $data,
            'judul' => 'jri',
            'tahun' => $years,
            'bulan' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }

    public function jkpl(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchFilteredData('dwor_jkpl', $year, $month);
        $columns = [
            'total', 'igd', 'perinatologi', 'poli_anak', 'poli_bedah', 'poli_gigi_umum',
            'poli_jantung', 'poli_konservasi_gigi', 'poli_kulit_kelamin', 'poli_kusta',
            'poli_mata', 'poli_obgyn', 'poli_orthopedi', 'poli_peny_dalam', 'poli_tb',
            'poli_tht_kl', 'poli_umum', 'rehab_medik'
        ];
        $chartData = $this->prepareChartData($data, $columns);

        $years = $this->getTahun('dwor_jkpl');
        $months = $this->getBulan();

        return view('dwor.jkpl', [
            'chartData' => $chartData,
            'dwor' => $data,
            'judul' => 'jkpl',
            'tahun' => $years,
            'bulan' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }

    public function jkpb(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchFilteredData('dwor_jkpb', $year, $month);
        $columns = [
            'total', 'igd', 'perinatologi', 'poli_anak', 'poli_bedah', 'poli_gigi_umum',
            'poli_jantung', 'poli_konservasi_gigi', 'poli_kulit_kelamin', 'poli_kusta',
            'poli_mata', 'poli_obgyn', 'poli_orthopedi', 'poli_peny_dalam', 'poli_tb',
            'poli_tht_kl', 'poli_umum', 'rehab_medik'
        ];
        $chartData = $this->prepareChartData($data, $columns);

        $years = $this->getTahun('dwor_jkpb');
        $months = $this->getBulan();

        return view('dwor.jkpb', [
            'chartData' => $chartData,
            'dwor' => $data,
            'judul' => 'jkpb',
            'tahun' => $years,
            'bulan' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }

    private function getPoliInfo($poli)
    {
        $poliInfoMap = [
            'igd' => ['nama' => 'IGD', 'base_line' => 5, 'target' => 7],
            'anak' => ['nama' => 'Poli Anak', 'base_line' => 1, 'target' => 1],
            'bedah' => ['nama' => 'Poli Bedah', 'base_line' => 4, 'target' => 4],
            'gigi_umum' => ['nama' => 'Poli Gigi Umum', 'base_line' => 1, 'target' => 1],
            'jantung' => ['nama' => 'Poli Jantung', 'base_line' => 7, 'target' => 8],
            'konservasi' => ['nama' => 'Poli Konservasi Gigi', 'base_line' => 1, 'target' => 1],
            'kulit' => ['nama' => 'Poli Kulit Kelamin', 'base_line' => 12, 'target' => 14],
            'kusta' => ['nama' => 'Poli Kusta', 'base_line' => 4, 'target' => 5],
            'mata' => ['nama' => 'Poli Mata', 'base_line' => 62, 'target' => 74],
            'obgyn' => ['nama' => 'Poli Obgyn', 'base_line' => 2, 'target' => 2],
            'orthopedi' => ['nama' => 'Poli Orthopedi', 'base_line' => 4, 'target' => 5],
            'penyakit_dalam' => ['nama' => 'Poli Penyakit Dalam', 'base_line' => 13, 'target' => 15],
            'tht_kl' => ['nama' => 'Poli THT KL', 'base_line' => 4, 'target' => 4],
            'umum' => ['nama' => 'Poli Umum', 'base_line' => 2, 'target' => 2],
        ];

        return $poliInfoMap[$poli] ?? ['nama' => 'Unknown', 'base_line' => 0, 'target' => 0];
    }

    private function getPoliColumn($poli)
    {
        $columnMap = [
            'igd' => 'igd',
            'anak' => 'poli_anak',
            'bedah' => 'poli_bedah',
            'gigi_umum' => 'poli_gigi_umum',
            'jantung' => 'poli_jantung',
            'konservasi' => 'poli_konservasi_gigi',
            'kulit' => 'poli_kulit_kelamin',
            'kusta' => 'poli_kusta',
            'mata' => 'poli_mata',
            'obgyn' => 'poli_obgyn',
            'orthopedi' => 'poli_orthopedi',
            'penyakit_dalam' => 'poli_peny_dalam',
            'tht_kl' => 'poli_tht_kl',
            'umum' => 'poli_umum',
        ];

        return $columnMap[$poli] ?? 'unknown_column';
    }
}