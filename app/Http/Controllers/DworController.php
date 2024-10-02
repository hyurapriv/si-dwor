<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dwor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class DworController extends Controller
{

    // $data = Country::join('state', 'state.country_id', '=', 'country.country_id')
    //           		->join('city', 'city.state_id', '=', 'state.state_id')
    //           		->get(['country.country_name', 'state.state_name', 'city.city_name']);

    //    	/*Above code will produce following query

    //     Select 
    //     	`country`.`country_name`, 
    //     	`state`.`state_name`, 
    //     	`city`.`city_name` 
    //     from `country` 
    //     inner join `state` 
    //     	on `state`.`country_id` = `country`.`country_id` 
    //     inner join `city` 
    //     	on `city`.`state_id` = `state`.`state_id`

    //     */


    //     public function index()
    //     {

    //         $data_a = DB::table('dwor_jkp')->orderBy('tgl_registrasi','asc')->get();////Dwor::all();
    //         foreach ($data_a as $item)
    //         { $tanggal[]=$item->tgl;
    //            $total[]=intval($item->total);
    //            $igd[]=intval($item->igd);
    //             $perinatologi[]=intval($item->perinatologi);
    //             $poli_anak[]=intval($item->poli_anak);
    //             $poli_bedah[]=intval($item->poli_bedah);
    //             $poli_gigi_umum[]=intval($item->poli_gigi_umum);
    //             $poli_jantung[]=intval($item->poli_jantung);
    //             $poli_konservasi_gigi[]=intval($item->poli_konservasi_gigi);
    //             $poli_kulit_kelamin[]=intval($item->poli_kulit_kelamin);
    //             $poli_kusta[]=intval($item->poli_kusta);
    //             $poli_mata[]=intval($item->poli_mata);
    //             $poli_obgyn[]=intval($item->poli_obgyn);
    //             $poli_orthopedi[]=intval($item->poli_orthopedi);
    //             $poli_peny_dalam[]=intval($item->poli_peny_dalam);
    //             $poli_tb[]=intval($item->poli_tb);
    //             $poli_tht_kl[]=intval($item->poli_tht_kl);
    //             $poli_umum[]=intval($item->poli_umum);
    //             $rehab_medik[]=intval($item->rehab_medik);
    //         }
    //    // dd($total);
    //          return view('dwor.index',['tanggal' => $tanggal,'igd' => $igd,'total' => $total,
    //          'perinatologi' => $perinatologi,
    //          'poli_anak' => $poli_anak,
    //          'poli_bedah' => $poli_bedah,
    //          'poli_gigi_umum' => $poli_gigi_umum,
    //          'poli_jantung' => $poli_jantung,
    //          'poli_konservasi_gigi' => $poli_konservasi_gigi,
    //          'poli_kulit_kelamin' => $poli_kulit_kelamin,
    //          'poli_kusta' => $poli_kusta,
    //          'poli_mata' => $poli_mata,
    //          'poli_obgyn' => $poli_obgyn,
    //          'poli_orthopedi' => $poli_orthopedi,
    //          'poli_peny_dalam' => $poli_peny_dalam,
    //          'poli_tb' => $poli_tb,
    //          'poli_tht_kl' => $poli_tht_kl,
    //          'poli_umum' => $poli_umum,
    //          'rehab_medik' => $rehab_medik,
    //          'dwor' => $data_a, 'judul' => 'index']);     
    //     }



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
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];
    }

    private function getBulanFilter($selectedYear)
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        $allMonths = $this->getBulan();

        if ($selectedYear < $currentYear) {
            return $allMonths;
        } elseif ($selectedYear == $currentYear) {
            return array_slice($allMonths, 0, $currentMonth, true);
        } else {
            return [];
        }
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
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $data = DB::table('dwor_jkp')
            ->whereYear('tgl_registrasi', $year)
            ->whereMonth('tgl_registrasi', $month)
            ->orderBy('tgl_registrasi', 'asc')
            ->get();


        $tanggal = $data->pluck('tgl')->toArray();
        $total = $data->pluck('total')->map(function ($item) {
            return intval($item);
        })->toArray();
        $base_line = array_fill(0, count($data), 117);
        $target = array_fill(0, count($data), 136);

        $years = DB::table('dwor_jkp')->selectRaw('YEAR(tgl_registrasi) as year')->distinct()->pluck('year');
        $months = $this->getBulan();

        $chartData = [
            'tanggal' => $tanggal,
            'total' => $total,
            'base_line' => $base_line,
            'target' => $target
        ];

        return view('dwor.dwor', [
            'chartData' => $chartData,
            'tanggal' => $tanggal,
            'total' => $total,
            'dwor' => $data,
            'judul' => 'index',
            'xjudul' => "Secara Total",
            'base_line' => $base_line,
            'target' => $target,
            'months' => $months,
            'years' => $years,
            'selectedYear' => $year,
            'selectedMonth' => $month
        ]);
    }

    public function utama(Request $request, $poli)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month', date('m'));

        $query = DB::table('dwor_jkp')
            ->whereYear('tgl_registrasi', $year)
            ->whereMonth('tgl_registrasi', $month)
            ->orderBy('tgl_registrasi', 'asc');

        switch ($poli) {
            case 'igd':
                $data = $query->select('tgl', 'total', 'igd')->get();
                $data_poli = $data->pluck('igd')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'IGD';
                $base_line = array_fill(0, count($data), 5);
                $target = array_fill(0, count($data), 7);
                break;
            case 'anak':
                $data = $query->select('tgl', 'total', 'poli_anak')->get();
                $data_poli = $data->pluck('poli_anak')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Anak';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'bedah':
                $data = $query->select('tgl', 'total', 'poli_bedah')->get();
                $data_poli = $data->pluck('poli_bedah')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Bedah';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'gigi_umum':
                $data = $query->select('tgl', 'total', 'poli_gigi_umum')->get();
                $data_poli = $data->pluck('poli_gigi_umum')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Gigi Umum';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'jantung':
                $data = $query->select('tgl', 'total', 'poli_jantung')->get();
                $data_poli = $data->pluck('poli_jantung')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Jantung';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'konservasi':
                $data = $query->select('tgl', 'total', 'poli_konservasi_gigi')->get();
                $data_poli = $data->pluck('poli_konservasi_gigi')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Konservasi Gigi';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'kulit':
                $data = $query->select('tgl', 'total', 'poli_kulit_kelamin')->get();
                $data_poli = $data->pluck('poli_kulit_kelamin')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Kulit Kelamin';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'kusta':
                $data = $query->select('tgl', 'total', 'poli_kusta')->get();
                $data_poli = $data->pluck('poli_kusta')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Kusta';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'mata':
                $data = $query->select('tgl', 'total', 'poli_mata')->get();
                $data_poli = $data->pluck('poli_mata')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Mata';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'obgyn':
                $data = $query->select('tgl', 'total', 'poli_obgyn')->get();
                $data_poli = $data->pluck('poli_obgyn')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Obgyn';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'orthopedi':
                $data = $query->select('tgl', 'total', 'poli_orthopedi')->get();
                $data_poli = $data->pluck('poli_orthopedi')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Orthopedi';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'penyakit_dalam':
                $data = $query->select('tgl', 'total', 'poli_peny_dalam')->get();
                $data_poli = $data->pluck('poli_peny_dalam')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Penyakit Dalam';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'tht_kl':
                $data = $query->select('tgl', 'total', 'poli_tht_kl')->get();
                $data_poli = $data->pluck('poli_tht_kl')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli THT KL';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
            case 'umum':
                $data = $query->select('tgl', 'total', 'poli_umum')->get();
                $data_poli = $data->pluck('poli_umum')->map(function ($item) {
                    return intval($item);
                })->toArray();
                $nama_poli = 'Poli Umum';
                $base_line = array_fill(0, count($data), 1);
                $target = array_fill(0, count($data), 1);
                break;
        }

        $tanggal = $data->pluck('tgl')->toArray();
        $total = $data->pluck('total')->map(function ($item) {
            return intval($item);
        })->toArray();

        $years = DB::table('dwor_jkp')->selectRaw('YEAR(tgl_registrasi) as year')->distinct()->pluck('year');
        $months = $this->getBulan();

        $chartData = [
            'tanggal' => $tanggal,
            'total' => $total,
            'data_poli' => $data_poli,
            'base_line' => $base_line,
            'target' => $target
        ];

        return view('dwor.dwor_poli', [
            'chartData' => $chartData,
            'tanggal' => $tanggal,
            'total' => $total,
            'data_poli' => $data_poli,
            'judul' => 'index',
            'xjudul' => $nama_poli,
            'base_line' => $base_line,
            'target' => $target,
            'months' => $months,
            'years' => $years,
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'selectedPoli' => $poli
        ]);
    }

    public function bor(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchFilteredData('dwor_bor_2', $year, $month);
        $columns = [
            'total',
            'igd',
            'perinatologi',
            'poli_anak',
            'poli_bedah',
            'poli_gigi_umum',
            'poli_jantung',
            'poli_konservasi_gigi',
            'poli_kulit_kelamin',
            'poli_kusta',
            'poli_mata',
            'poli_obgyn',
            'poli_orthopedi',
            'poli_peny_dalam',
            'poli_tb',
            'poli_tht_kl',
            'poli_umum',
            'rehab_medik'
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
            'total',
            'igd',
            'perinatologi',
            'poli_anak',
            'poli_bedah',
            'poli_gigi_umum',
            'poli_jantung',
            'poli_konservasi_gigi',
            'poli_kulit_kelamin',
            'poli_kusta',
            'poli_mata',
            'poli_obgyn',
            'poli_orthopedi',
            'poli_peny_dalam',
            'poli_tb',
            'poli_tht_kl',
            'poli_umum',
            'rehab_medik'
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
            'total',
            'igd',
            'perinatologi',
            'poli_anak',
            'poli_bedah',
            'poli_gigi_umum',
            'poli_jantung',
            'poli_konservasi_gigi',
            'poli_kulit_kelamin',
            'poli_kusta',
            'poli_mata',
            'poli_obgyn',
            'poli_orthopedi',
            'poli_peny_dalam',
            'poli_tb',
            'poli_tht_kl',
            'poli_umum',
            'rehab_medik'
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
}
