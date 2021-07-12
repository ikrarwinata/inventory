<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Models\Vendor_model;
use App\Controllers\BaseController;
use App\Models\Vendor_excel;

class Vendor extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Vendor_model(); //Set Default Models Of this Controller
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
            'parent' => 'administrator/Vendor',
            'title' => 'Vendor',
            'subtitle' => array(
                'Vendor',
            ),
            'nav' => array('Vendor'),
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
        $this->PageData["title"] = lang("Text.Vendor", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.Vendor", [], $this->PageData['locale'])];
        $page = $this->request->getGet("page");
        $page = $page<=0?1:$page;
        $keyword = $this->request->getGet("keyword");
        $totalrecord = $this->model->get_data($keyword)->countAllResults();

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
        return view('administrator/vendor/vendor_list', $data);
        //endindex
    }

    //READfunction
    public function read($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = lang("Text.VendorDetail", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            "Vendor",
            $this->PageData['title']
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url('Vendor'));
        }
        $data = [
            'data' => $this->model->get_by_id($id), //get_by_id on data
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/vendor/vendor_read', $data);
    }

    //CREATEfunction
    public function create()
    {
        $this->PageData['title'] = lang("Text.CreateVendor", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            $this->PageData['title']
        );

        $data = [
            'data' => (object) [
                'id' => set_value('id', generateId("VNDR")),
                'nama_vendor' => set_value('nama_vendor'),
                'kota' => set_value('kota'),
                'alamat' => set_value('alamat'),
                'telepon' => set_value('telepon'),
                'keterangan' => set_value('keterangan'),
            ],
            'action' => site_url($this->PageData['parent'].'/create_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/vendor/vendor_form', $data);
    }
    
    //ACTIONCREATEfunction
    public function create_action()
    {
        if($this->is_request_valid() == FALSE){
            return $this->create();
        };

        $check = $this->model->get_by_id($this->request->getPost('id'));
        if($check) {
            session()->setFlashdata('ci_flash_message_id', lang("Errors.errorDataDuplicate", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_id_type', ' alert-danger ');
            return $this->create();
        }

        $data = [
            'id' => $this->request->getPost('id'),
            'nama_vendor' => $this->request->getPost('nama_vendor'),
            'kota' => $this->request->getPost('kota'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
            
        $this->model->insert($data);
        session()->setFlashdata('ci_flash_message', lang("Default.CreateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent']));
    }
    
    //UPDATEfunction
    public function update($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = lang("Text.UpdateVendor", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            $this->PageData['title']
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent']));
        }
        $data = [
            'data' => (object) [
                'id' => set_value('id', $dataFind->id),
                'nama_vendor' => set_value('nama_vendor', $dataFind->nama_vendor),
                'kota' => set_value('kota', $dataFind->kota),
                'alamat' => set_value('alamat', $dataFind->alamat),
                'telepon' => set_value('telepon', $dataFind->telepon),
                'keterangan' => set_value('keterangan', $dataFind->keterangan),
            ],
            'action' => site_url($this->PageData['parent'].'/update_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/vendor/vendor_form', $data);
    }
    
    //ACTIONUPDATEfunction
    public function update_action()
    {
        $id = $this->request->getPostGet('oldid');
        $dataFind = $this->model->get_by_id($id);

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent']));
        };

        if($this->is_request_valid() == FALSE){
            return $this->update($id);
        };

        if($this->request->getPost("id") != $this->request->getPost("oldid")){
            $check = $this->model->get_by_id($this->request->getPost('id'));
            if ($check) {
                session()->setFlashdata('ci_flash_message_id', lang("Errors.errorDataDuplicate", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_id_type', ' alert-danger ');
                return $this->update($this->request->getPost("oldid"));
            }
        }

        $data = [
            'id' => $this->request->getPost('id'),
            'nama_vendor' => $this->request->getPost('nama_vendor'),
            'kota' => $this->request->getPost('kota'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
            
        $this->model->update($id, $data);
        session()->setFlashdata('ci_flash_message', lang("Default.UpdateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent']));
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
        foreach ($this->model->findAll() as $key => $value) {
            $this->model->delete($value->id);
        };
        session()->setFlashdata('ci_flash_message', lang("Default.TruncateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent']));
    }

    // FORMVALIDATION
    private function is_request_valid(){
        $res = FALSE;

        $this->validation->setRules([
            'id' => 'trim|required|max_length[100]',
            'nama_vendor' => 'trim|required|max_length[255]',
            'kota' => 'trim|required|max_length[100]',
            'alamat' => 'trim|max_length[65535]',
            'telepon' => 'trim|max_length[50]',
            'keterangan' => 'trim|max_length[65535]',
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
        $excel = new Vendor_excel();
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
        header("Content-Disposition: attachment;Filename=data vendor " . date("Y") . ".doc");

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
            'data_vendor' => $this->model->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/vendor/vendor_word', $data);
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
            'data_vendor' => $this->model->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/vendor/vendor_print', $data);
    }
}