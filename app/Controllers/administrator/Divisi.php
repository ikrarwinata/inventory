<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/
use App\Models\Berita_excel;
use App\Models\Divisi_model;
use App\Controllers\BaseController;

class Divisi extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Divisi_model(); //Set Default Models Of this Controller
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
            'parent' => 'administrator/Divisi',
            'title' => 'Divisi',
            'subtitle' => array(
                'Divisi',
            ),
            'nav' => array('administrator/Divisi'),
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
        return view('administrator/divisi/divisi_list', $data);
        //endindex
    }

    //READfunction
    public function read($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = "Divisi Detail";
        $this->PageData['subtitle'] = array(
            'Divisi',
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
        return view('administrator/divisi/divisi_read', $data);
    }

    //CREATEfunction
    public function create()
    {
        $this->PageData['title'] = "Create Divisi";
        $this->PageData['subtitle'] = array(
            'Divisi',
            'Create New Data'
        );

        $data = [
            'data' => (object) [
                'id' => set_value('id', generateId("DIVS")),
                'nama_divisi' => set_value('nama_divisi'),
                'kota' => set_value('kota'),
                'alamat' => set_value('alamat'),
                'telepon' => set_value('telepon'),
                'keterangan' => set_value('keterangan'),
            ],
            'action' => site_url($this->PageData['parent'].'/create_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/divisi/divisi_form', $data);
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
            'nama_divisi' => $this->request->getPost('nama_divisi'),
            'kota' => $this->request->getPost('kota'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
            
        $this->model->insert($data);
        session()->setFlashdata('ci_flash_message', lang("Default.CreateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
    }
    
    //UPDATEfunction
    public function update($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = "Update Divisi";
        $this->PageData['subtitle'] = array(
            'Divisi',
            'Update Data'
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
        }
        $data = [
            'data' => (object) [
                'id' => set_value('id', $dataFind->id),
                'nama_divisi' => set_value('nama_divisi', $dataFind->nama_divisi),
                'kota' => set_value('kota', $dataFind->kota),
                'alamat' => set_value('alamat', $dataFind->alamat),
                'telepon' => set_value('telepon', $dataFind->telepon),
                'keterangan' => set_value('keterangan', $dataFind->keterangan),
            ],
            'action' => site_url($this->PageData['parent'].'/update_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/divisi/divisi_form', $data);
    }
    
    //ACTIONUPDATEfunction
    public function update_action()
    {
        $id = $this->request->getPostGet('oldid');
        $dataFind = $this->model->get_by_id($id);

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
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
            'nama_divisi' => $this->request->getPost('nama_divisi'),
            'kota' => $this->request->getPost('kota'),
            'alamat' => $this->request->getPost('alamat'),
            'telepon' => $this->request->getPost('telepon'),
            'keterangan' => $this->request->getPost('keterangan'),
        ];
            
        $this->model->update($id, $data);
        session()->setFlashdata('ci_flash_message', lang("Default.UpdateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
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
        foreach ($this->model->findAll() as $key => $value) {
            $this->model->delete($value->id);
        };
        session()->setFlashdata('ci_flash_message', lang("Default.TruncateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
    }

    // FORMVALIDATION
    private function is_request_valid(){
        $res = FALSE;

        $this->validation->setRules([
            'id' => 'trim|required|max_length[100]',
            'nama_divisi' => 'trim|required|max_length[255]',
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

    //EXPORTEXXCELfunction
    public function to_excel(){
        $excel = new Berita_excel();
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