<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Models\Pembelian_model;
use App\Models\Master_model;
use App\Models\Vendor_model;
use App\Controllers\BaseController;
use App\Models\Pembelian_excel;

class Pembelian extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Pembelian_model(); //Set Default Models Of this Controller
        $this->PageData = $this->defaultPageAttribute(); //Attribute Of this Page
        $this->pager = \Config\Services::pager(); // Pagination
        $this->validation =  \Config\Services::validation();
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
            'parent' => 'administrator/Pembelian',
            'title' => 'Pembelian',
            'subtitle' => array(
                'Pembelian',
            ),
            'nav' => array('Pembelian'),
            'stylesheets' => array(),
            'scripts' => array('assets/build/js/button.js'),
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
        //indexstart
        
        // Table sorting using GET var
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL || $sortorder == NULL){
            if (session()->has("sorting_table")) {
                if (session("sorting_table")==$this->model->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        }else{
            $sortcolumn = base64_decode($sortcolumn);
        }
        if ($sortcolumn != NULL && $sortorder != NULL) {
            if ($sortorder != "DESC" && $sortorder != "ASC") $sortorder = "ASC";
            if(in_array($sortcolumn, $this->model->get_fields())){
                $this->model->order = $sortorder;
                $this->model->columnIndex = $sortcolumn;
                session()->set('sortcolumn', $sortcolumn);
                session()->set('sortorder', $sortorder);
                session()->set('sorting_table', $this->model->table);
            }else{
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
                if (session("paging_table")==$this->model->table) {
                    $perPage = session("perPage");
                };
            };
        };
        if ($perPage != NULL) {
            // Minimum data per-page = 2
            if ($perPage <= 0) $perPage = 2;
            session()->set('perPage', $perPage);
            session()->set('paging_table', $this->model->table);
        }else{
            // Default data per-page = 20
            $perPage = 20;
            session()->remove('paging_table');
            session()->remove('perPage');
        }
        $this->PageData["title"] = lang("Text.Purchase", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.Purchase", [], $this->PageData['locale'])];
        $page = $this->request->getGet("page");
        $page = $page<=0?1:$page;
        $keyword = $this->request->getGet("keyword");
        $totalrecord = $this->model->get_data($keyword)->countAllResults();
        $this->model->select("pembelian.*, pembelian.id_vendor AS id_suplier, vendor.nama_vendor AS suplier, master_view.*");
        $this->model->join("master_view", "pembelian.id_master = master_view.kode_barang");
        $this->model->join("vendor", "pembelian.id_vendor = vendor.id", "left");
        $data = [
            'sortcolumn' => $sortcolumn,
            'sortorder' => $sortorder,
            'data' => $this->model->get_data($keyword)->paginate($perPage),
            'perPage' => $perPage,
            'currentPage' => $page,
            'start' => min(($page*$perPage)-($perPage-1), $totalrecord),
            'end' => min(($perPage*$page), $totalrecord),
            'totalrecord' => $totalrecord,
            'pager' => $this->model->pager,
            'keyword' => $keyword,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/pembelian/pembelian_list', $data);
        //endindex
    }

    //READfunction
    public function read($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = "Pembelian Detail";
        $this->PageData['subtitle'] = array(
            'Pembelian',
            'Detail'
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url('Pembelian'));
        }
        $this->model->select("pembelian.*, pembelian.id_vendor AS id_suplier, vendor.nama_vendor AS suplier, master_view.*");
        $this->model->join("master_view", "pembelian.id_master = master_view.kode_barang");
        $this->model->join("vendor", "pembelian.id_vendor = vendor.id", "left");
        $data = [
            'data' => $this->model->get_by_id($id), //get_by_id on data
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/pembelian/pembelian_read', $data);
    }

    //CREATEfunction
    public function create()
    {
        $this->PageData['title'] = lang("Text.PurchaseTransaction", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            $this->PageData['title'],
            'Create New Data'
        );
        $master = new Master_model();
        $vendor = new Vendor_model();
        if (session()->getFlashdata('pembelian') == "1") {
            $this->PageData['scripts'] = array(
                'assets/vendors/pnotify/dist/pnotify.js',
                'assets/vendors/pnotify/dist/pnotify.buttons.js',
                'assets/vendors/pnotify/dist/pnotify.nonblock.js',
                'assets/vendors/sweetalert2/sweetalert2.all.min.js',
                'assets/build/js/button.js',
                'assets/build/js/transaksi_create_success.js',
            );
            $barcode = NULL;
            $nama = NULL;
        }else{
            $this->PageData['scripts'] = array(
                'assets/vendors/pnotify/dist/pnotify.js',
                'assets/vendors/pnotify/dist/pnotify.buttons.js',
                'assets/vendors/pnotify/dist/pnotify.nonblock.js',
                'assets/vendors/sweetalert2/sweetalert2.all.min.js',
                'assets/build/js/button.js',
            );
            $barcode = set_value('barcode');
            $nama = set_value('nama');
        }        
        $this->PageData['stylesheets'] = array(
            'assets/vendors/pnotify/dist/pnotify.css',
            'assets/vendors/pnotify/dist/pnotify.buttons.css',
            'assets/vendors/pnotify/dist/pnotify.nonblock.css'
        );
        $data = [
            'data' => (object) [
                'id' => generateId("PCHS"),
                'id_master' => set_value('id_master'),
                'barcode' => $barcode,
                'nama' => $nama,
                'quantity' => set_value('quantity', 1),
                'harga' => set_value('harga', 0),
                'timestamps' => set_value('timestamps'),
                'id_vendor' => set_value('id_vendor'),
                'username' => set_value('username'),
            ],
            'masterbarang' => $master->select("id, nama")->findAll(),
            'vendor' => $vendor->select("id, nama_vendor")->findAll(),
            'action' => site_url($this->PageData['parent'].'/create_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/pembelian/pembelian_form', $data);
    }
    
    //ACTIONCREATEfunction
    public function create_action()
    {
        if($this->is_request_valid() == FALSE){
            return $this->create();
        };

        $master = new Master_model();
        if($this->request->getPost("selectmethod")=="manual"){
            $datamaster = [
                'id' => $this->request->getPost('id_master'),
                'barcode' => $this->request->getPost('barcode'),
                'nama' => $this->request->getPost('nama'),
                'stok' => $this->request->getPost('stok') + $this->request->getPost('quantity'),
                'harga' => $this->request->getPost('harga'),
                'kategori' => $this->request->getPost('kategori'),
                'satuan' => $this->request->getPost('satuan'),
                'berat' => $this->request->getPost('berat'),
                'kadaluarsa' => strtotime(formatDate($this->request->getPost('kadaluarsa'))),
                'gedung' => $this->request->getPost('gedung'),
                'ruangan' => $this->request->getPost('ruangan'),
                'posisi' => $this->request->getPost('posisi'),
                'id_vendor' => $this->request->getPost('id_vendor'),
            ];
            if ($foto = $this->request->getFile('foto')) {
                if ($foto->isValid()) {
                    if (! $foto->hasMoved()) {
                        $fotonewName = $foto->getRandomName();
                        $foto->move('./writable/uploads/product', $fotonewName);
                    }
                    $datamaster['foto'] = './writable/uploads/product/'.$foto->getName();
                }else{
                    session()->setFlashdata('ci_flash_message_foto', $foto->getErrorString().' ('.$foto->getError().')');
                    session()->setFlashdata('ci_flash_message_foto_type', ' text-danger ');
                };
            };
            $master->insert($datamaster);
        }else {
            $datamaster = [
                'stok' => $this->request->getPost('stok') + $this->request->getPost('quantity'),
                'harga' => $this->request->getPost('harga'),
                'kadaluarsa' => strtotime(formatDate($this->request->getPost('kadaluarsa'))),
            ];
            $master->update($this->request->getPost('id_master'), $datamaster);
        }

        $data = [
            'id' => $this->request->getPost('id'),
            'id_master' => $this->request->getPost('id_master'),
            'quantity' => $this->request->getPost('quantity'),
            'harga' => $this->request->getPost('harga'),
            'timestamps' => strtotime(date("d-m-Y H:i:s")),
            'id_vendor' => $this->request->getPost('id_vendor'),
            'username' => session("username"),
        ];

        $this->model->insert($data);
        session()->setFlashdata('pembelian', "1");
        return $this->create();
    }

    //DELETE
    public function delete($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $row = $this->model->get_by_id($id);

        if ($row && $id != NULL) {
            
            
            $this->model->delete($id);
            session()->setFlashdata('ci_flash_message', lang("Default.DeleteSuccess", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-success ');
            return redirect()->to(base_url($this->PageData['parent']));
        } else {
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent']));
        }
    }

    //DELETEBATCH
    public function delete_batch()
    {
        $arr = $this->request->getPost("removeme");
        $res = 0;
        if ($arr!=NULL) {
            if (count($arr)>=1) {
                foreach ($arr as $key => $id) {
                    $row = $this->model->get_by_id($id);
                    if (! $row || $id == NULL) continue;
                    
                    $this->model->delete($id);
                    $res++;
                }
            }
        }

        session()->setFlashdata('ci_flash_message', lang("Default.BatchDeleteSuccess", ['total'=>$res], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent']));
    }

    //TRUNCATE
    public function truncate()
    {
        $this->model->truncate();
        session()->setFlashdata('ci_flash_message', lang("Default.TruncateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent']));
    }

    // FORMVALIDATION
    private function is_request_valid(){
        $res = FALSE;

        $this->validation->setRules([
            'id' => 'trim|required|max_length[100]',
            'id_master' => 'trim|required|max_length[100]',
            'quantity' => 'trim|required|min_length[1]|max_length[11]',
            'harga' => 'trim|required|min_length[1]|max_length[11]',
            'id_vendor' => 'trim|required|max_length[100]',
        ]);

        if ($this->validation->withRequest($this->request)->run() == TRUE) {
            $res = TRUE;
        }else{
            $errors = $this->validation->getErrors();
            foreach ($errors as $key => $value) {
                session()->setFlashdata('ci_flash_message_'.$key, $value);
                session()->setFlashdata('ci_flash_message_'.$key.'_type', ' alert-danger ');
            }
        }
        return $res;
    }


    public function to_excel()
    {
        $excel = new Pembelian_excel();
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL && $sortorder == NULL) {
            if (session()->has("sorting_table")) {
                if (session("sorting_table") == $this->model->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        };
        if ($sortcolumn != NULL && $sortorder != NULL) {
            $excel->order = $sortorder;
            $excel->columnIndex = $sortcolumn;
        };
        $excel->export();
        exit();
    }

    public function to_word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=data pembelian " . date("Y") . ".doc");

        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL && $sortorder == NULL) {
            if (session()->has("sorting_table")) {
                if (session("sorting_table") == $this->model->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        };
        if ($sortcolumn != NULL && $sortorder != NULL) {
            $this->model->order = $sortorder;
            $this->model->columnIndex = $sortcolumn;
        };
        $data = array(
            'data_pembelian' => $this->model->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/pembelian/pembelian_word', $data);
    }

    public function print_all()
    {
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL && $sortorder == NULL) {
            if (session()->has("sorting_table")) {
                if (session("sorting_table") == $this->model->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        };
        if ($sortcolumn != NULL && $sortorder != NULL) {
            $this->model->order = $sortorder;
            $this->model->columnIndex = $sortcolumn;
        };
        $data = array(
            'data_pembelian' => $this->model->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/pembelian/pembelian_print', $data);
    }
}