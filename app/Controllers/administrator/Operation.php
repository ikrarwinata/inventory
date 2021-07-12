<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Controllers\BaseController;
use App\Models\Kategori_master_model;
use App\Models\Master_model;
use App\Models\Master_view_model;
use App\Models\Pembelian_model;
use App\Models\Pembelian_subtotal_model;
use App\Models\Penjualan_model;
use App\Models\Penjualan_subtotal_model;
use App\Models\Profil_perusahaan_model;
use App\Models\Satuan_master_model;
use App\Models\Users_model;
use App\Models\Vendor_model;
use App\Models\Barcode_generator_model;
use App\Models\Divisi_model;
use App\Models\Pengembalian_model;

class Operation extends BaseController
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
    }
    
    //ATRIBUTE THIS PAGE
    private function defaultPageAttribute()
    {
        return  [
            'parent' => 'administrator/Operation',
            'title' => 'Operasi',
            'subtitle' => array(
                'Operasi',
            ),
            'nav' => array('Operasi'),
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
        return redirect()->to('/administrator/Dashboard/index');
    }

    public function pricing()
    {
        $data = [
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/Operation/pricing', $data);        
    }

    public function pricing_action(){
        $master = new Master_model();
        $result = 0;
        switch ($this->request->getPost("intval")) {
            case '+':
                $master->query("UPDATE master SET harga = harga + " . $this->request->getPost("change_value") . " WHERE id <> ''");
                $result = $master->where("id <> ''", NULL, FALSE)->countAllResults();
                break;
            case '-':
                $master->query("UPDATE master SET harga = harga - " . $this->request->getPost("change_value") . " WHERE id <> ''");
                $result = $master->where("id <> ''", NULL, FALSE)->countAllResults();
                break;
            case 'set':
                $master->query("UPDATE master SET harga = " . $this->request->getPost("change_value") . " WHERE id <> ''");
                $result = $master->where("id <> ''", NULL, FALSE)->countAllResults();
                break;
            default:
                $result = 0;
                break;
        };

        session()->setFlashdata('ci_flash_message', lang("Default.PricingSuccess", ['total' => $result], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');

        return redirect()->to(base_url($this->PageData['parent'] . '/pricing'));
    }

    public function truncate()
    {
        $data = [
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/Operation/truncate', $data);
    }

    public function truncate_action($table)
    {
        $result = 0;

        switch ($table) {
            case 'pembelian':
                $pembelian = new Pembelian_model();
                $result = $pembelian->total_rows();
                $pembelian->truncate();
                break;
            case 'penjualan':
                $penjualan = new Penjualan_model();
                $result = $penjualan->total_rows();
                $penjualan->truncate();
                break;
            case 'pengembalian':
                $pengembalian = new Pengembalian_model();
                $result = $pengembalian->total_rows();
                $pengembalian->truncate();
                break;
            case 'kategori':
                $kategori = new Kategori_master_model();
                $result = 0;
                foreach ($kategori->findAll() as $key => $value) {
                    $kategori->delete($value->id);
                    $result++;
                };
                break;
            case 'satuan':
                $satuan = new Satuan_master_model();
                $result = 0;
                foreach ($satuan->findAll() as $key => $value) {
                    $satuan->delete($value->id);
                    $result++;
                };
                break;
            case 'master':
                $master = new Master_model();
                $result = 0;
                foreach ($master->findAll() as $key => $value) {
                    $master->delete($value->id);
                    $result++;
                };
                break;
            case 'vendor':
                $vendor = new Vendor_model();
                $result = 0;
                foreach ($vendor->findAll() as $key => $value) {
                    $vendor->delete($value->id);
                    $result++;
                };
                break;
            case 'divisi':
                $divisi = new Divisi_model();
                $result = 0;
                foreach ($divisi->findAll() as $key => $value) {
                    $divisi->delete($value->id);
                    $result++;
                };
                break;
            case 'users':
                $users = new Users_model();
                $result = 0;
                $s = session("username");
                foreach ($users->findAll() as $key => $value) {
                    if($value->username == $s) continue;
                    $users->delete($value->username);
                    $result++;
                };
                break;
            default:
                # code...
                break;
        }

        session()->setFlashdata('ci_flash_message', lang("Default.TruncateDataSuccess", ['total'=>$result, 'table' => $table], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');

        return redirect()->to(base_url($this->PageData['parent'] . '/truncate'));
    }


    //INDEX 
    public function kadaluarsa()
    {
        //indexstart
        $master_view = new Master_view_model();

        $tglKadaluarsa = strtotime("+" . session("pengingat_kadaluarsa") . " day", strtotime(date("d-m-Y 24:59:59")));
        session()->set("barang_kadaluarsa", $master_view->select("COUNT(*) AS total")->where("kadaluarsa < " . $tglKadaluarsa, NULL, FALSE)->first()->total);

        // Table sorting using GET var
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL || $sortorder == NULL) {
            if (session()->has("sorting_table")) {
                if (session("sorting_table") == $master_view->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        } else {
            $sortcolumn = base64_decode($sortcolumn);
        }
        if ($sortcolumn != NULL && $sortorder != NULL) {
            if ($sortorder != "DESC" && $sortorder != "ASC") $sortorder = "ASC";
            if (in_array($sortcolumn, $master_view->get_fields())) {
                $master_view->order = $sortorder;
                $master_view->columnIndex = $sortcolumn;
                session()->set('sortcolumn', $sortcolumn);
                session()->set('sortorder', $sortorder);
                session()->set('sorting_table', $master_view->table);
            } else {
                $sortcolumn = NULL;
                $sortorder = NULL;
                session()->remove('sortcolumn');
                session()->remove('sortorder');
                session()->remove('sorting_table');
            }
        }

        // How many data shows each page
        $perPage = $this->request->getPostGet("perPage");
        if ($perPage == NULL) {
            if (session()->has("paging_table")) {
                if (session("paging_table") == $master_view->table) {
                    $perPage = session("perPage");
                };
            };
        };
        if ($perPage != NULL) {
            // Minimum data per-page = 2
            if ($perPage <= 0) $perPage = 2;
            session()->set('perPage', $perPage);
            session()->set('paging_table', $master_view->table);
        } else {
            // Default data per-page = 20
            $perPage = 20;
            session()->remove('paging_table');
            session()->remove('perPage');
        }
        $tglKadaluarsa = strtotime("+" . session("pengingat_kadaluarsa") . " day", strtotime(date("d-m-Y 24:59:59")));
        $this->PageData["title"] = lang("Text.Expire", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.Expire", [], $this->PageData['locale'])];
        $this->PageData["scripts"] = ['assets/build/js/button.js'];
        $page = $this->request->getGet("page");
        $page = $page <= 0 ? 1 : $page;
        $keyword = $this->request->getGet("keyword");
        $totalrecord = $master_view->where("kadaluarsa < " . $tglKadaluarsa, NULL, FALSE)->get_data($keyword)->countAllResults();

        $data = [
            'sortcolumn' => $sortcolumn,
            'sortorder' => $sortorder,
            'data' => $master_view->where("kadaluarsa < " . $tglKadaluarsa, NULL, FALSE)->get_data($keyword)->paginate($perPage),
            'perPage' => $perPage,
            'currentPage' => $page,
            'start' => min(($page * $perPage) - ($perPage - 1), $totalrecord),
            'end' => min(($perPage * $page), $totalrecord),
            'totalrecord' => $totalrecord,
            'pager' => $master_view->where("kadaluarsa < " . $tglKadaluarsa, NULL, FALSE)->pager,
            'keyword' => $keyword,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/operation/kadaluarsa', $data);
    }

    //DELETEBATCH
    public function kadaluarsa_delete_batch()
    {
        $arr = $this->request->getPost("removeme");
        $res = 0;
        if ($arr != NULL) {
            if (count($arr) >= 1) {
                foreach ($arr as $key => $id) {
                    $row = $this->model->get_by_id($id);
                    if (!$row || $id == NULL) continue;

                    $this->model->delete($id);
                    $res++;
                }
            }
        }

        session()->setFlashdata('ci_flash_message', lang("Default.BatchDeleteSuccess", ['total' => $res], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/kadaluarsa'));
    }

    //TRUNCATE
    public function kadaluarsa_truncate()
    {
        $master = new Master_model();
        $tglKadaluarsa = strtotime("+" . session("pengingat_kadaluarsa") . " day", strtotime(date("d-m-Y 24:59:59")));
        foreach ($master->where("kadaluarsa < " . $tglKadaluarsa, NULL, FALSE)->findAll() as $key => $value) {
            $master->delete($value->id);
        };
        session()->setFlashdata('ci_flash_message', lang("Default.TruncateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/kadaluarsa'));
    }

    //DELETE
    public function kadaluarsa_delete($id = NULL)
    {
        $id = ($id == NULL ? $this->request->getPostGet("id") : $id);
        $master = new Master_model();
        $row = $master->get_by_id($id);

        if ($row && $id != NULL) {


            $master->delete($id);
            session()->setFlashdata('ci_flash_message', lang("Default.DeleteSuccess", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-success ');
            return redirect()->to(base_url($this->PageData['parent'] . '/kadaluarsa'));
        } else {
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/kadaluarsa'));
        }
    }

    public function barcode(){
        $barcode = new Barcode_generator_model();
        $this->PageData["title"] = lang("Text.Barcode", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.Barcode", [], $this->PageData['locale'])];
        $this->PageData["stylesheets"] = [];
        $this->PageData["scripts"] = ['assets/js/jQuery.print.min.js','assets/build/js/barcode_generator.js'];
        
        if($this->request->getPost('judul') != NULL && $this->request->getPost('barcode') != NULL){
            $insertb = [];
            $insert = FALSE;
            if($barcode->get_row_by("judul", $this->request->getPost('judul'))){
                $insertb["judul"] = NULL;
            }else{
                $insertb["judul"] = $this->request->getPost('judul');
                $insert = TRUE;
            }
            
            if($barcode->get_row_by("barcode_text", $this->request->getPost('barcode'))){
                $insertb["barcode_text"] = NULL;
            }else{
                $insertb["barcode_text"] = $this->request->getPost('barcode');
                $insert = TRUE;
            }
            if($insert)$barcode->insert($insertb);
        }

        $data = [
            'judul' => $this->request->getPost('judul'),
            'barcode' => $this->request->getPost('barcode'),
            'repeat' => $this->request->getPost('repeat')==NULL?10:$this->request->getPost('repeat'),
            'listjudul' => $barcode->select("DISTINCT(judul) AS judul")->findAll(),
            'listbarcode_text' => $barcode->select("DISTINCT(barcode_text) AS barcode_text")->findAll(),
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/operation/barcode', $data);
    }
}