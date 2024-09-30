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



    public function index(Request $request)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchData($year, $month);
        $chartData = $this->prepareChartData($data);

        $years = $this->getAvailableYears();
        $months = $this->getMonths();

        return view('dwor.dwor', [
            'chartData' => $chartData,
            'dwor' => $data,
            'judul' => 'index',
            'xjudul' => "Secara Total",
            'years' => $years,
            'months' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
        ]);
    }

    public function utama(Request $request, $poli)
    {
        $year = $request->input('year', Carbon::now()->year);
        $month = $request->input('month', Carbon::now()->month);

        $data = $this->fetchDataByPoli($year, $month, $poli);
        $chartData = $this->prepareChartDataByPoli($data, $poli);

        $years = $this->getAvailableYears();
        $months = $this->getMonths();

        $poliInfo = $this->getPoliInfo($poli);

        return view('dwor.dwor_poli', [
            'chartData' => $chartData,
            'judul' => 'index',
            'xjudul' => $poliInfo['nama'],
            'years' => $years,
            'months' => $months,
            'selectedYear' => $year,
            'selectedMonth' => $month,
            'selectedPoli' => $poli,
        ]);
    }

    private function fetchData($year, $month)
    {
        return DB::table('dwor_jkp')
            ->whereYear('tgl_registrasi', $year)
            ->whereMonth('tgl_registrasi', $month)
            ->orderBy('tgl_registrasi', 'asc')
            ->get(['tgl', 'total']);
    }

    private function fetchDataByPoli($year, $month, $poli)
    {
        $poliColumn = $this->getPoliColumn($poli);
        return DB::table('dwor_jkp')
            ->whereYear('tgl_registrasi', $year)
            ->whereMonth('tgl_registrasi', $month)
            ->orderBy('tgl_registrasi', 'asc')
            ->get(['tgl', 'total', $poliColumn]);
    }

    private function prepareChartData($data)
    {
        $baseline = 117;
        $target = 136;

        return [
            'tanggal' => $data->pluck('tgl'),
            'total' => $data->pluck('total')->map(function ($value) {
                return intval($value);
            }),
            'base_line' => $data->map(function () use ($baseline) {
                return $baseline;
            }),
            'target' => $data->map(function () use ($target) {
                return $target;
            }),
        ];
    }

    private function prepareChartDataByPoli($data, $poli)
    {
        $poliInfo = $this->getPoliInfo($poli);
        $poliColumn = $this->getPoliColumn($poli);

        return [
            'tanggal' => $data->pluck('tgl'),
            'total' => $data->pluck('total')->map(function ($value) {
                return intval($value);
            }),
            'data_poli' => $data->pluck($poliColumn)->map(function ($value) {
                return intval($value);
            }),
            'base_line' => $data->map(function () use ($poliInfo) {
                return $poliInfo['base_line'];
            }),
            'target' => $data->map(function () use ($poliInfo) {
                return $poliInfo['target'];
            }),
        ];
    }

    private function getAvailableYears()
    {
        return DB::table('dwor_jkp')
            ->select(DB::raw('DISTINCT YEAR(tgl_registrasi) as year'))
            ->orderBy('year', 'desc')
            ->pluck('year');
    }

    private function getMonths()
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


    public function bor()
    {
        $data_a = DB::table('dwor_bor_2')->orderBy('tgl_registrasi', 'asc')->get();
        foreach ($data_a as $item) {
            $tanggal[] = $item->tgl;
            $total[] = intval($item->total);
            $igd[] = intval($item->igd);
            $perinatologi[] = intval($item->perinatologi);
            $poli_anak[] = intval($item->poli_anak);
            $poli_bedah[] = intval($item->poli_bedah);
            $poli_gigi_umum[] = intval($item->poli_gigi_umum);
            $poli_jantung[] = intval($item->poli_jantung);
            $poli_konservasi_gigi[] = intval($item->poli_konservasi_gigi);
            $poli_kulit_kelamin[] = intval($item->poli_kulit_kelamin);
            $poli_kusta[] = intval($item->poli_kusta);
            $poli_mata[] = intval($item->poli_mata);
            $poli_obgyn[] = intval($item->poli_obgyn);
            $poli_orthopedi[] = intval($item->poli_orthopedi);
            $poli_peny_dalam[] = intval($item->poli_peny_dalam);
            $poli_tb[] = intval($item->poli_tb);
            $poli_tht_kl[] = intval($item->poli_tht_kl);
            $poli_umum[] = intval($item->poli_umum);
            $rehab_medik[] = intval($item->rehab_medik);
        }
        return view('dwor.bor', [
            'tanggal' => $tanggal,
            'igd' => $igd,
            'total' => $total,
            'perinatologi' => $perinatologi,
            'poli_anak' => $poli_anak,
            'poli_bedah' => $poli_bedah,
            'poli_gigi_umum' => $poli_gigi_umum,
            'poli_jantung' => $poli_jantung,
            'poli_konservasi_gigi' => $poli_konservasi_gigi,
            'poli_kulit_kelamin' => $poli_kulit_kelamin,
            'poli_kusta' => $poli_kusta,
            'poli_mata' => $poli_mata,
            'poli_obgyn' => $poli_obgyn,
            'poli_orthopedi' => $poli_orthopedi,
            'poli_peny_dalam' => $poli_peny_dalam,
            'poli_tb' => $poli_tb,
            'poli_tht_kl' => $poli_tht_kl,
            'poli_umum' => $poli_umum,
            'rehab_medik' => $rehab_medik,
            'dwor' => $data_a,
            'judul' => 'bor'
        ]);
    }

    public function jri(Request $request)
    {
        // Mendapatkan data tahun dari tabel 'dwor_inap' dengan mengambil tahun dari kolom 'tgl_masuk'
        // dan 'tgl_keluar'. Tahun yang diambil adalah lebih dari 2009 (2009 tidak termasuk).
        $dataTahun = DB::table('dwor_inap')
            ->selectRaw('YEAR(tgl_masuk) as year')->whereYear('tgl_masuk', '>', 2009) // Filter tahun > 2009
            ->union(DB::table('dwor_inap') // menggabungkan hasil dari dua select
                ->selectRaw('YEAR(tgl_keluar) as year'))->whereYear('tgl_keluar', '>', 2009) // Filter tahun > 2009
            ->distinct() // Menghapus duplikat tahun
            ->orderByDesc('year') // Urutkan dari tahun terbesar ke terkecil
            ->pluck('year'); // Mengambil daftar tahun dalam bentuk array

        // Mendapatkan data bulan dari tabel 'dwor_inap' dengan mengambil bulan dari kolom 'tgl_masuk' dan 'tgl_keluar'.
        $dataBulan = DB::table('dwor_inap')
            ->selectRaw('MONTH(tgl_masuk) as month')
            ->union(DB::table('dwor_inap')->selectRaw('MONTH(tgl_keluar) as month'))
            ->distinct() // Menghapus duplikat bulan
            ->orderBy('month') // Urutkan dari bulan terkecil ke terbesar
            ->pluck('month'); // Mengambil daftar bulan dalam bentuk array

        // Mendapatkan tahun dan bulan dari permintaan (request) pengguna, jika tidak diberikan, gunakan tahun terbaru dan bulan saat ini
        $year = $request->input('year', $dataTahun->first()); // Tahun default adalah tahun pertama dalam daftar
        $month = $request->input('month', now()->month); // Bulan default adalah bulan sekarang

        // Membuat rentang tanggal awal dan akhir berdasarkan tahun dan bulan yang dipilih
        $startDate = Carbon::create($year, $month, 1)->startOfMonth(); // Tanggal awal bulan
        $endDate = $startDate->copy()->endOfMonth(); // Tanggal akhir bulan

        // Mengambil data 'tgl_masuk' dan 'tgl_keluar' dari tabel 'dwor_inap' untuk tanggal yang sesuai dengan bulan dan tahun yang dipilih
        $data_a = DB::table('dwor_inap')
            ->select('tgl_masuk', 'tgl_keluar')
            ->where(function ($query) use ($startDate, $endDate) {
                // Ambil data dengan 'tgl_masuk' atau 'tgl_keluar' berada di dalam rentang tanggal yang dipilih
                $query->whereBetween('tgl_masuk', [$startDate, $endDate])
                    ->orWhereBetween('tgl_keluar', [$startDate, $endDate])
                    ->orWhere(function ($q) use ($startDate, $endDate) {
                        // Untuk kasus di mana 'tgl_masuk' sebelum 'startDate' dan 'tgl_keluar' setelah 'endDate' atau null
                        $q->where('tgl_masuk', '<', $startDate)
                            ->where(function ($inner) use ($endDate) {
                                $inner->where('tgl_keluar', '>', $endDate)
                                    ->orWhereNull('tgl_keluar');
                            });
                    });
            })
            ->get(); // Mengambil data yang sesuai dengan query

        // Mempersiapkan rentang tanggal (date range) berdasarkan bulan yang dipilih
        $dateRange = collect(CarbonPeriod::create($startDate, $endDate));

        // Menghitung jumlah pasien (jml) per hari dalam rentang tanggal yang dipilih
        $jml = $dateRange->mapWithKeys(function ($date) use ($data_a) {
            // Untuk setiap tanggal dalam rentang, hitung berapa banyak pasien yang masih dirawat pada tanggal tersebut
            $count = $data_a->filter(function ($item) use ($date) {
                $tgl_masuk = Carbon::parse($item->tgl_masuk)->startOfDay(); // Ubah 'tgl_masuk' menjadi tanggal awal hari
                $tgl_keluar = $item->tgl_keluar ? Carbon::parse($item->tgl_keluar)->startOfDay() : null; // Ubah 'tgl_keluar' menjadi tanggal awal hari, atau null jika belum keluar
                // Hitung jika tanggal berada di antara 'tgl_masuk' dan 'tgl_keluar'
                return $date->greaterThanOrEqualTo($tgl_masuk) &&
                    ($tgl_keluar === null || $date->lessThanOrEqualTo($tgl_keluar));
            })->count(); // Hitung jumlah pasien per tanggal
            return [$date->toDateString() => $count]; // Mengembalikan hasil dengan format [tanggal => jumlah pasien]
        });

        // Mengembalikan data ke tampilan 'dwor.jri' dengan variabel yang diperlukan
        return view('dwor.jri', [
            'tanggal' => $dateRange->map->toDateString(), // Daftar tanggal dalam rentang yang dipilih
            'jml' => $jml, // Jumlah pasien per tanggal
            'dwor' => $data_a, // Data pasien yang diambil
            'judul' => 'jri', // Judul halaman
            'year' => $year, // Tahun yang dipilih
            'month' => $month, // Bulan yang dipilih
            'dataTahun' => $dataTahun, // Daftar tahun untuk dropdown
            'dataBulan' => $dataBulan // Daftar bulan untuk dropdown
        ]);
    }


    public function jkpl()
    {
        $data_a = DB::table('dwor_jkpl')->orderBy('tgl_registrasi', 'asc')->get();
        foreach ($data_a as $item) {
            $tanggal[] = $item->tgl;
            $total[] = intval($item->total);
            $igd[] = intval($item->igd);
            $perinatologi[] = intval($item->perinatologi);
            $poli_anak[] = intval($item->poli_anak);
            $poli_bedah[] = intval($item->poli_bedah);
            $poli_gigi_umum[] = intval($item->poli_gigi_umum);
            $poli_jantung[] = intval($item->poli_jantung);
            $poli_konservasi_gigi[] = intval($item->poli_konservasi_gigi);
            $poli_kulit_kelamin[] = intval($item->poli_kulit_kelamin);
            $poli_kusta[] = intval($item->poli_kusta);
            $poli_mata[] = intval($item->poli_mata);
            $poli_obgyn[] = intval($item->poli_obgyn);
            $poli_orthopedi[] = intval($item->poli_orthopedi);
            $poli_peny_dalam[] = intval($item->poli_peny_dalam);
            $poli_tb[] = intval($item->poli_tb);
            $poli_tht_kl[] = intval($item->poli_tht_kl);
            $poli_umum[] = intval($item->poli_umum);
            $rehab_medik[] = intval($item->rehab_medik);
        }
        return view('dwor.jkpl', [
            'tanggal' => $tanggal,
            'igd' => $igd,
            'total' => $total,
            'perinatologi' => $perinatologi,
            'poli_anak' => $poli_anak,
            'poli_bedah' => $poli_bedah,
            'poli_gigi_umum' => $poli_gigi_umum,
            'poli_jantung' => $poli_jantung,
            'poli_konservasi_gigi' => $poli_konservasi_gigi,
            'poli_kulit_kelamin' => $poli_kulit_kelamin,
            'poli_kusta' => $poli_kusta,
            'poli_mata' => $poli_mata,
            'poli_obgyn' => $poli_obgyn,
            'poli_orthopedi' => $poli_orthopedi,
            'poli_peny_dalam' => $poli_peny_dalam,
            'poli_tb' => $poli_tb,
            'poli_tht_kl' => $poli_tht_kl,
            'poli_umum' => $poli_umum,
            'rehab_medik' => $rehab_medik,
            'dwor' => $data_a,
            'judul' => 'jkpl'
        ]);
    }
    public function jkpb()
    {
        $data_a = DB::table('dwor_jkpb')->orderBy('tgl_registrasi', 'asc')->get();
        foreach ($data_a as $item) {
            $tanggal[] = $item->tgl;
            $total[] = intval($item->total);
            $igd[] = intval($item->igd);
            $perinatologi[] = intval($item->perinatologi);
            $poli_anak[] = intval($item->poli_anak);
            $poli_bedah[] = intval($item->poli_bedah);
            $poli_gigi_umum[] = intval($item->poli_gigi_umum);
            $poli_jantung[] = intval($item->poli_jantung);
            $poli_konservasi_gigi[] = intval($item->poli_konservasi_gigi);
            $poli_kulit_kelamin[] = intval($item->poli_kulit_kelamin);
            $poli_kusta[] = intval($item->poli_kusta);
            $poli_mata[] = intval($item->poli_mata);
            $poli_obgyn[] = intval($item->poli_obgyn);
            $poli_orthopedi[] = intval($item->poli_orthopedi);
            $poli_peny_dalam[] = intval($item->poli_peny_dalam);
            $poli_tb[] = intval($item->poli_tb);
            $poli_tht_kl[] = intval($item->poli_tht_kl);
            $poli_umum[] = intval($item->poli_umum);
            $rehab_medik[] = intval($item->rehab_medik);
        }
        return view('dwor.jkpb', [
            'tanggal' => $tanggal,
            'igd' => $igd,
            'total' => $total,
            'perinatologi' => $perinatologi,
            'poli_anak' => $poli_anak,
            'poli_bedah' => $poli_bedah,
            'poli_gigi_umum' => $poli_gigi_umum,
            'poli_jantung' => $poli_jantung,
            'poli_konservasi_gigi' => $poli_konservasi_gigi,
            'poli_kulit_kelamin' => $poli_kulit_kelamin,
            'poli_kusta' => $poli_kusta,
            'poli_mata' => $poli_mata,
            'poli_obgyn' => $poli_obgyn,
            'poli_orthopedi' => $poli_orthopedi,
            'poli_peny_dalam' => $poli_peny_dalam,
            'poli_tb' => $poli_tb,
            'poli_tht_kl' => $poli_tht_kl,
            'poli_umum' => $poli_umum,
            'rehab_medik' => $rehab_medik,
            'dwor' => $data_a,
            'judul' => 'jkpb'
        ]);
    }
}
