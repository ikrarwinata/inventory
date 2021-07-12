<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Controllers\BaseController;
use App\Models\Master_model;
use App\Models\Master_view_model;
use App\Models\Pembelian_model;
use App\Models\Pembelian_subtotal_model;
use App\Models\Penjualan_subtotal_model;
use App\Models\Profil_perusahaan_model;

class Dashboard extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->PageData = $this->defaultPageAttribute(); //Attribute Of this Page
    }

    protected function onLoad(){
        parent::onLoad();
        $this->getLocale();
        
        // check access level
        if (! $this->access_allowed()) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Errors.errorAccessDenied", [], $this->PageData['locale']));
        };
        
        $profil = new Profil_perusahaan_model();
        $sess["nama_perusahaan"] = $profil->get_row_by("key_name", "nama_perusahaan")->values_data;
        $sess["alamat_perusahaan"] = $profil->get_row_by("key_name", "alamat_perusahaan")->values_data;
        $sess["telepon_perusahaan"] = $profil->get_row_by("key_name", "telepon_perusahaan")->values_data;
        $sess["pengingat_kadaluarsa"] = $profil->get_row_by("key_name", "pengingat_kadaluarsa")->values_data;
        session()->set($sess);
    }
    
    //ATRIBUTE THIS PAGE
    private function defaultPageAttribute()
    {
        return  [
            'parent' => 'administrator/Dashboard',
            'title' => 'Dashboard',
            'subtitle' => array(
                'Dashboard',
            ),
            'nav' => array('Dashboard'),
            'stylesheets' => array(),
            'scripts' => array(
                ''
            ),
            'locale' => 'id',
            'access' => array('administrator', 'admin', 'superadmin')
        ];
    }
    
    private function access_allowed(){
        $allowed = FALSE;
        if (count($this->PageData["access"])==0) return TRUE;
        if (! session()->has("level"))  return FALSE;
        foreach ($this->PageData["access"] as $key => $value) {
            if(session("level")==$value){
                $allowed=TRUE;
                break;
            }
        };
        return $allowed;
    }
    
    //INDEX 
    public function index()
    {
        $master_view = new Master_view_model();
        $pembelian = new Pembelian_model();
        $pembelian_subtotal = new Pembelian_subtotal_model();
        $penjualan_subtotal = new Penjualan_subtotal_model();

        $tglKadaluarsa = strtotime("+".session("pengingat_kadaluarsa")." day", strtotime(date("d-m-Y 24:59:59")));
        session()->set("barang_kadaluarsa", $master_view->select("COUNT(*) AS total")->where("kadaluarsa < " . $tglKadaluarsa, NULL, FALSE)->first()->total);

        $tglAwal = strtotime(date('1-m-Y 00:00:00'));
        $tglAkhir = strtotime(date('t-m-Y 24:59:59'));
        $prevAwal = strtotime("-1 month", $tglAwal);
        $prevAkhir = strtotime("-1 month", $tglAkhir);
        $total_barang_sekarang = $pembelian->select("SUM(quantity) AS total")->where("timestamps BETWEEN " . $tglAwal . " AND " . $tglAkhir, NULL, FALSE)->first()->total;
        $total_barang_lalu = $pembelian->select("SUM(quantity) AS total")->where("timestamps BETWEEN " . $prevAwal . " AND " . $prevAkhir, NULL, FALSE)->first()->total;
        $total_jenis_sekarang = $pembelian->select("COUNT(quantity) AS total")->where("timestamps BETWEEN " . $tglAwal . " AND " . $tglAkhir, NULL, FALSE)->first()->total;
        $total_jenis_lalu = $pembelian->select("COUNT(quantity) AS total")->where("timestamps BETWEEN " . $prevAwal . " AND " . $prevAkhir, NULL, FALSE)->first()->total;
        $total_nilai = $master_view->select("SUM(subtotal) AS total")->first()->total;
        $total_pembelian_sekarang = $pembelian_subtotal->select("SUM(subtotal) AS total")->where("timestamps BETWEEN " . $tglAwal . " AND " . $tglAkhir, NULL, FALSE)->first()->total;
        $total_pembelian_lalu = $pembelian_subtotal->select("SUM(subtotal) AS total")->where("timestamps BETWEEN " . $prevAwal . " AND " . $prevAkhir, NULL, FALSE)->first()->total;
        $total_penjualan_sekarang = $penjualan_subtotal->select("SUM(subtotal) AS total")->where("timestamps BETWEEN " . $tglAwal . " AND " . $tglAkhir, NULL, FALSE)->first()->total;
        $total_penjualan_lalu = $penjualan_subtotal->select("SUM(subtotal) AS total")->where("timestamps BETWEEN " . $prevAwal . " AND " . $prevAkhir, NULL, FALSE)->first()->total;
        $this->PageData['scripts'] = [
            'assets/vendors/Chart.js/dist/Chart.min.js',
            'assets/vendors/Flot/jquery.flot.js',
            'assets/vendors/Flot/jquery.flot.time.js',
            'assets/vendors/Flot/jquery.flot.resize.js',
            'assets/vendors/flot.orderbars/js/jquery.flot.orderBars.js',
            'assets/vendors/flot-spline/js/jquery.flot.spline.min.js',
            'assets/vendors/flot.curvedlines/curvedLines.js',
            'assets/vendors/DateJS/build/date.js',
        ];

        $arr_pembelian = array();
        $arr_penjualan = array();
        $tahun = date("Y");
        for ($i=0; $i < 12; $i++) {
            $tglAwal = strtotime("1-" . ($i + 1) . "-" . $tahun . " 00:00:00");
            $lastday = date("t", $tglAwal);
            $tglAkhir = strtotime($lastday . "-" . ($i + 1) ."-" . $tahun . " 24:59:59");
            $arr_pembelian[$i] = (object) [
                'total' => $pembelian_subtotal->select("SUM(subtotal) AS total")->where("timestamps BETWEEN " . ($tglAwal) . " AND " . ($tglAkhir), NULL, FALSE)->first()->total,
                'tahun' => $tahun,
                'bulan' => ($i + 1)
            ];
            $arr_penjualan[$i] = (object) [
                'total' => $penjualan_subtotal->select("SUM(subtotal) AS total")->where("timestamps BETWEEN " . ($tglAwal) . " AND " . ($tglAkhir), NULL, FALSE)->first()->total,
                'tahun' => $tahun,
                'bulan' => ($i + 1)
            ];
        }

        if($total_pembelian_sekarang > $total_penjualan_sekarang){
            $pembelian_banding = 100;
            if($total_penjualan_sekarang > 0){
                $penjualan_banding = progressValue($total_penjualan_sekarang, $total_pembelian_sekarang);
            }else {
                $penjualan_banding = 0;
            }            
        }else {
            $penjualan_banding = 100;
            if ($total_pembelian_sekarang > 0) {
                $pembelian_banding = progressValue($total_pembelian_sekarang, $total_penjualan_sekarang);
            } else {
                $pembelian_banding = 0;
            }           
        }

        $data = [
            'total_barang_sekarang' => $total_barang_sekarang > 0 ? $total_barang_sekarang : 0,
            'total_barang_lalu' => $total_barang_lalu > 0 ? $total_barang_lalu : 0,
            'total_jenis_sekarang' => $total_jenis_sekarang > 0 ? $total_jenis_sekarang : 0,
            'total_jenis_lalu' => $total_jenis_lalu > 0 ? $total_jenis_lalu : 0,
            'total_nilai' => $total_nilai > 0 ? $total_nilai : 0,
            'total_pembelian_sekarang' => $total_pembelian_sekarang > 0 ? $total_pembelian_sekarang : 0,
            'total_pembelian_lalu' => $total_pembelian_lalu > 0 ? $total_pembelian_lalu : 0,
            'total_penjualan_sekarang' => $total_penjualan_sekarang > 0 ? $total_penjualan_sekarang : 0,
            'total_penjualan_lalu' => $total_penjualan_lalu > 0 ? $total_penjualan_lalu : 0,
            'pembelian_banding' => $pembelian_banding,
            'penjualan_banding' => $penjualan_banding,
            'pembelian' => $arr_pembelian,
            'penjualan' => $arr_penjualan,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/dashboard', $data);
    }

}