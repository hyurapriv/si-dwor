<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dwor;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonInterval;

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

    

    public function index()
    {
        
        $data_a = DB::table('dwor_jkp')->orderBy('tgl_registrasi','asc')->get();////Dwor::all();
        foreach ($data_a as $item)
        { $tanggal[]=$item->tgl;
           $total[]=intval($item->total);
           $base_line[]=117;
           $target[]=136;
        }
   // dd($total);
         return view('dwor.dwor',['tanggal' => $tanggal,'total' => $total,
         'dwor' => $data_a, 'judul' => 'index', 'xjudul' => "Secara Total",'base_line' => $base_line,'target' => $target]);     
    }

    public function utama($poli)
    {
       

        if($poli=="igd")
        {
           

            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','igd')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->igd);
                $nama_poli='IGD';
                $base_line[]=5;
                $target[]=7;
            }
            
        }
        else   if($poli=="anak")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_anak')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_anak);
                $nama_poli='Poli Anak';
                $base_line[]=1;
                $target[]=1;
            }
        }
        else   if($poli=="bedah")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_bedah')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_bedah);
                $nama_poli='Poli Bedah';
                $base_line[]=4;
                $target[]=4;
            }
        }
        else   if($poli=="gigi_umum")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_gigi_umum')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_gigi_umum);
                $nama_poli='Poli Gigi Umum';
                $base_line[]=1;
                $target[]=1;
            }
        }
        else   if($poli=="jantung")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_jantung')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_jantung);
                $nama_poli='Poli Jantung';
                $base_line[]=7;
                $target[]=8;
            }
        }
        else   if($poli=="konservasi")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_konservasi_gigi')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_konservasi_gigi);
                $nama_poli='Poli Konservasi Gigi';
                $base_line[]=1;
                $target[]=1;
            }
        }
        else   if($poli=="kulit")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_kulit_kelamin')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_kulit_kelamin);
                $nama_poli='Poli Kulit Kelamin';
                $base_line[]=12;
                $target[]=14;
            }
        }
        else   if($poli=="kusta")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_kusta')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_kusta);
                $nama_poli='Poli Kusta';
                $base_line[]=4;
                $target[]=5;
            }
        }
        else   if($poli=="mata")
        {
            
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_mata')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_mata);
                $nama_poli='Poli Mata';
                $base_line[]=62;
                $target[]=74;
            }
        }
        else   if($poli=="obgyn")
        {  
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_obgyn')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_obgyn);
                $nama_poli='Poli Obgyn';
                $base_line[]=2;
                $target[]=2;
            }
        }
        else   if($poli=="orthopedi")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_orthopedi')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_orthopedi);
                $nama_poli='Poli Orthopedi';
                $base_line[]=4;
                $target[]=5;
            }
        }
        else   if($poli=="penyakit_dalam")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_peny_dalam')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_peny_dalam);
                $nama_poli='Poli Penyakit Dalam';
                $base_line[]=13;
                $target[]=15;
            }
        }
        else   if($poli=="tht_kl")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_tht_kl')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_tht_kl);
                $nama_poli='Poli THT KL';
                $base_line[]=4;
                $target[]=4;
            }
        }
        else   if($poli=="umum")
        {
            $data_a = DB::table('dwor_jkp') ->select('tgl', 'total','poli_umum')->orderBy('tgl_registrasi','asc')->get();
            foreach ($data_a as $item)
            { 
                $tanggal[]=$item->tgl;
                $total[]=intval($item->total);
                $data_poli[]=intval($item->poli_umum);
                $nama_poli='Poli Umum';
                $base_line[]=2;
                $target[]=2;
            }
        }
    
         return view('dwor.dwor_poli',['tanggal' => $tanggal,'total' => $total,
         'data_poli' => $data_poli, 'judul' => 'index', 'xjudul' => $nama_poli,'base_line' => $base_line,'target' =>$target]);  

    }

    public function bor()
    {
        $data_a = DB::table('dwor_bor_2')->orderBy('tgl_registrasi','asc')->get();
        foreach ($data_a as $item)
        { $tanggal[]=$item->tgl;
           $total[]=intval($item->total);
           $igd[]=intval($item->igd);
            $perinatologi[]=intval($item->perinatologi);
            $poli_anak[]=intval($item->poli_anak);
            $poli_bedah[]=intval($item->poli_bedah);
            $poli_gigi_umum[]=intval($item->poli_gigi_umum);
            $poli_jantung[]=intval($item->poli_jantung);
            $poli_konservasi_gigi[]=intval($item->poli_konservasi_gigi);
            $poli_kulit_kelamin[]=intval($item->poli_kulit_kelamin);
            $poli_kusta[]=intval($item->poli_kusta);
            $poli_mata[]=intval($item->poli_mata);
            $poli_obgyn[]=intval($item->poli_obgyn);
            $poli_orthopedi[]=intval($item->poli_orthopedi);
            $poli_peny_dalam[]=intval($item->poli_peny_dalam);
            $poli_tb[]=intval($item->poli_tb);
            $poli_tht_kl[]=intval($item->poli_tht_kl);
            $poli_umum[]=intval($item->poli_umum);
            $rehab_medik[]=intval($item->rehab_medik);
        }
        return view('dwor.bor',['tanggal' => $tanggal,'igd' => $igd,'total' => $total,
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
        'dwor' => $data_a, 'judul' => 'bor']);
    }

    public function jri()
    {
        $data_a = DB::table('dwor_inap_14hari')->get();
        foreach ($data_a as $item)
        { $tanggal[]=$item->tgl;
           $jml[]=intval($item->jml);}
        return view('dwor.jri',['tanggal' => $tanggal,'jml' => $jml,'dwor' => $data_a, 'judul' => 'jri']);
    }

    public function jkpl()
    {
        $data_a = DB::table('dwor_jkpl')->orderBy('tgl_registrasi','asc')->get();
        foreach ($data_a as $item)
        { $tanggal[]=$item->tgl;
           $total[]=intval($item->total);
           $igd[]=intval($item->igd);
            $perinatologi[]=intval($item->perinatologi);
            $poli_anak[]=intval($item->poli_anak);
            $poli_bedah[]=intval($item->poli_bedah);
            $poli_gigi_umum[]=intval($item->poli_gigi_umum);
            $poli_jantung[]=intval($item->poli_jantung);
            $poli_konservasi_gigi[]=intval($item->poli_konservasi_gigi);
            $poli_kulit_kelamin[]=intval($item->poli_kulit_kelamin);
            $poli_kusta[]=intval($item->poli_kusta);
            $poli_mata[]=intval($item->poli_mata);
            $poli_obgyn[]=intval($item->poli_obgyn);
            $poli_orthopedi[]=intval($item->poli_orthopedi);
            $poli_peny_dalam[]=intval($item->poli_peny_dalam);
            $poli_tb[]=intval($item->poli_tb);
            $poli_tht_kl[]=intval($item->poli_tht_kl);
            $poli_umum[]=intval($item->poli_umum);
            $rehab_medik[]=intval($item->rehab_medik);
        }
        return view('dwor.jkpl',['tanggal' => $tanggal,'igd' => $igd,'total' => $total,
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
        'dwor' => $data_a, 'judul' => 'jkpl']);
    }
    public function jkpb()
    {
        $data_a = DB::table('dwor_jkpb')->orderBy('tgl_registrasi','asc')->get();
        foreach ($data_a as $item)
        { $tanggal[]=$item->tgl;
           $total[]=intval($item->total);
           $igd[]=intval($item->igd);
            $perinatologi[]=intval($item->perinatologi);
            $poli_anak[]=intval($item->poli_anak);
            $poli_bedah[]=intval($item->poli_bedah);
            $poli_gigi_umum[]=intval($item->poli_gigi_umum);
            $poli_jantung[]=intval($item->poli_jantung);
            $poli_konservasi_gigi[]=intval($item->poli_konservasi_gigi);
            $poli_kulit_kelamin[]=intval($item->poli_kulit_kelamin);
            $poli_kusta[]=intval($item->poli_kusta);
            $poli_mata[]=intval($item->poli_mata);
            $poli_obgyn[]=intval($item->poli_obgyn);
            $poli_orthopedi[]=intval($item->poli_orthopedi);
            $poli_peny_dalam[]=intval($item->poli_peny_dalam);
            $poli_tb[]=intval($item->poli_tb);
            $poli_tht_kl[]=intval($item->poli_tht_kl);
            $poli_umum[]=intval($item->poli_umum);
            $rehab_medik[]=intval($item->rehab_medik);
        }
        return view('dwor.jkpb',['tanggal' => $tanggal,'igd' => $igd,'total' => $total,
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
        'dwor' => $data_a, 'judul' => 'jkpb']);
    }
}
