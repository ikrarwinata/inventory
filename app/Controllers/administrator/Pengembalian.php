<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/
use App\Models\Berita_excel;
use App\Models\Pengembalian_model;
use App\Controllers\BaseController;
use App\Models\Divisi_model;
use App\Models\Master_model;
use App\Models\Pengembalian_excel;
use App\Models\Penjualan_model;

class Pengembalian extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Pengembalian_model(); //Set Default Models Of this Controller
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
            'parent' => 'administrator/Pengembalian',
            'title' => 'Pengembalian',
            'subtitle' => array(
                'Pengembalian',
            ),
            'nav' => array('administrator/Pengembalian'),
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

        $page = $this->request->getGet("page");
        $page = $page<=0?1:$page;
        $keyword = $this->request->getGet("keyword");
        $totalrecord = $this->model->get_data($keyword)->countAllResults();
        $this->model->select("pengembalian.*, pengembalian.id_divisi AS id_divisi, divisi.nama_divisi AS divisi, master_view.*");
        $this->model->join("master_view", "pengembalian.id_master = master_view.kode_barang");
        $this->model->join("divisi", "pengembalian.id_divisi = divisi.id", "left");
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
        return view('administrator/pengembalian/pengembalian_list', $data);
        //endindex
    }

    //READfunction
    public function read($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = "Pengembalian Detail";
        $this->PageData['subtitle'] = array(
            'Pengembalian',
            'Detail'
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
        }
        $data = [
            'data' => $this->model->get_by_id($id), //get_by_id on data
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/pengembalian/pengembalian_read', $data);
    }

    //CREATEfunction
    public function create()
    {
        $penjualan = new Penjualan_model();
        // Table sorting using GET var
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL || $sortorder == NULL){
            if (session()->has("sorting_table")) {
                if (session("sorting_table")==$penjualan->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        }else{
            $sortcolumn = base64_decode($sortcolumn);
        }
        if ($sortcolumn != NULL && $sortorder != NULL) {
            if ($sortorder != "DESC" && $sortorder != "ASC") $sortorder = "ASC";
            if(in_array($sortcolumn, $penjualan->get_fields())){
                $penjualan->order = $sortorder;
                $penjualan->columnIndex = $sortcolumn;
                session()->set('sortcolumn', $sortcolumn);
                session()->set('sortorder', $sortorder);
                session()->set('sorting_table', $penjualan->table);
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
                if (session("paging_table")==$penjualan->table) {
                    $perPage = session("perPage");
                };
            };
        };
        if ($perPage != NULL) {
            // Minimum data per-page = 2
            if ($perPage <= 0) $perPage = 2;
            session()->set('perPage', $perPage);
            session()->set('paging_table', $penjualan->table);
        }else{
            // Default data per-page = 20
            $perPage = 20;
            session()->remove('paging_table');
            session()->remove('perPage');
        }
        $this->PageData["title"] = lang("Text.Return", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.Return", [], $this->PageData['locale']), "Create New Data"];
        $this->PageData['stylesheets'] = ["assets/vendors/sweetalert2/sweetalert2.min.css"];
        $this->PageData["scripts"] = [
            "assets/vendors/sweetalert2/sweetalert2.min.js",
            'assets/build/js/button.js',
            'assets/build/js/pengembalian.js'
        ];
        $page = $this->request->getGet("page");
        $page = $page<=0?1:$page;
        $keyword = $this->request->getGet("keyword");
        $totalrecord = $penjualan->get_data($keyword)->countAllResults();
        $penjualan->select("penjualan.*, penjualan.id_divisi AS id_divisi, divisi.nama_divisi AS divisi, master_view.*");
        $penjualan->join("master_view", "penjualan.id_master = master_view.kode_barang");
        $penjualan->join("divisi", "penjualan.id_divisi = divisi.id", "left");
        $data = [
            'sortcolumn' => $sortcolumn,
            'sortorder' => $sortorder,
            'data' => $penjualan->get_data($keyword)->paginate($perPage),
            'perPage' => $perPage,
            'currentPage' => $page,
            'start' => min(($page*$perPage)-($perPage-1), $totalrecord),
            'end' => min(($perPage*$page), $totalrecord),
            'totalrecord' => $totalrecord,
            'pager' => $penjualan->pager,
            'keyword' => $keyword,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/pengembalian/pengembalian_form', $data);        
    }

	public function create_action(){
		$id = $this->request->getGetPost('id');
		$qty = $this->request->getGetPost('qty');

		$pengembalian = new Pengembalian_model();
		$penjualan = new Penjualan_model();
        $master = new Master_model();

        $penjualan->select("penjualan.*, master.stok");
        $penjualan->join("master", "penjualan.id_master = master.id");
		$target = $penjualan->where("penjualan.id", $id)->first();

		if($target){
            $datainsert = [
                'id' => generateId("RTRN"),
                'id_penjualan' => $target->id,
                'id_master' => $target->id_master,
                'quantity' => $qty,
                'harga' => $target->harga,
                'timestamps' => $target->timestamps,
                'id_divisi' => $target->id_divisi,
                'username' => session("username")
            ];
            $pengembalian->insert($datainsert);
            $master->update($target->id_master, ['stok' => $target->stok + $qty]);
            $penjualan->update($target->id, ['quantity' => $target->quantity - $qty]);
            $result = array("id"=>$id, "status"=>"OK", "qty"=>$qty);
            echo json_encode($result);
		}else{
			throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound(lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
		}
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
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
        } else {
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
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
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
    }

    //TRUNCATE
    public function truncate()
    {
        $this->model->truncate();
        session()->setFlashdata('ci_flash_message', lang("Default.TruncateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
    }

    // FORMVALIDATION
    private function is_request_valid(){
        $res = FALSE;

        $this->validation->setRules([
            'id_master' => 'trim|required|max_length[100]',
            'quantity' => 'trim|required|min_length[1]|max_length[11]',
            'harga' => 'trim|required|min_length[1]|max_length[11]',
            'timestamps' => 'trim|required|max_length[11]',
            'id_divisi' => 'trim|required|max_length[100]',
            'username' => 'trim|required|max_length[50]',
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

    //EXPORTEXXCELfunction
    public function to_excel(){
        $excel = new Pengembalian_excel();
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL && $sortorder == NULL){
            if (session()->has("sorting_table")) {
                if (session("sorting_table")==$this->model->table) {
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

    //ENDFUNCTION
}