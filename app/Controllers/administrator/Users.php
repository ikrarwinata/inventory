<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Models\Users_model;
use App\Controllers\BaseController;

class Users extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Users_model(); //Set Default Models Of this Controller
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
            'parent' => 'administrator/Users',
            'title' => 'Users',
            'subtitle' => array(
                'Users',
            ),
            'nav' => array('Users'),
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
        return view('administrator/users/users_list', $data);
        //endindex
    }

    //READfunction
    public function read($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("username"):$id;
        $dataFind = $this->model->get_by_id($id);
        $this->PageData['title'] = "Users Detail";
        $this->PageData['subtitle'] = array(
            'Users',
            'Detail'
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url('Users'));
        }
        $data = [
            'data' => $this->model->get_by_id($id), //get_by_id on data
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/users/users_read', $data);
    }

    //CREATEfunction
    public function create()
    {
        $this->PageData['title'] = "Create Users";
        $this->PageData['subtitle'] = array(
            'Users',
            'Create New Data'
        );

        $data = [
            'data' => (object) [
                'username' => set_value('username'),
                'password' => set_value('password'),
                'password2' => set_value('password2'),
                'nama' => set_value('nama'),
                'level' => set_value('level'),
            ],
            'action' => site_url($this->PageData['parent'].'/create_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/users/users_form', $data);
    }
    
    //ACTIONCREATEfunction
    public function create_action()
    {
        if($this->is_request_valid() == FALSE){
            return $this->create();
        };

        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'level' => $this->request->getPost('level'),
        ];

        if ($this->request->getPost('password') != NULL && $this->request->getPost('password2') != NULL) {
            if ($this->request->getPost('password') == $this->request->getPost('password2')) {
                $data["password"] = md5($this->request->getPost('password'));
            }else{
                session()->setFlashdata('ci_flash_message_password', lang("Errors.errorPasswordConfirmMismatch", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_password_type', ' alert-danger ');
                return $this->create();
            }
        }

        $check = $this->model->get_by_id($this->request->getPost('username'));

        if ($check) {
            session()->setFlashdata('ci_flash_message_username', lang("Errors.errorUsernameExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_username_type', ' alert-danger ');
            return $this->create();
        }
            
        $this->model->insert($data);
        session()->setFlashdata('ci_flash_message', lang("Default.CreateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent']));
    }
    
    //UPDATEfunction
    public function update($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("username"):$id;
        $dataFind = $this->model->find($id);
        $this->PageData['title'] = "Update Users";
        $this->PageData['subtitle'] = array(
            'Users',
            'Update Data'
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent']));
        }
        $data = [
            'data' => (object) [
                'username' => set_value('username', $dataFind->username),
                'password' => set_value('password'),
                'password2' => set_value('password2'),
                'nama' => set_value('nama', $dataFind->nama),
                'level' => set_value('level', $dataFind->level),
            ],
            'action' => site_url($this->PageData['parent'].'/update_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/users/users_form', $data);
    }
    
    //ACTIONUPDATEfunction
    public function update_action()
    {
        $id = $this->request->getPostGet('oldusername');
        $dataFind = $this->model->get_by_id($id);

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent']));
        };

        if($this->is_request_valid(0) == FALSE){
            return $this->update($id);
        };

        $data = [
            'username' => $this->request->getPost('username'),
            'nama' => $this->request->getPost('nama'),
            'level' => $this->request->getPost('level'),
        ];


        if ($this->request->getPost('password') != NULL && $this->request->getPost('password2') != NULL) {
            if ($this->request->getPost('password') == $this->request->getPost('password2')) {
                $data["password"] = md5($this->request->getPost('password'));
            }else{
                session()->setFlashdata('ci_flash_message_password', lang("Errors.errorPasswordConfirmMismatch", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_password_type', ' alert-danger ');
                return $this->create();
            }
        }

        if ($id != $this->request->getPost('username')) {
            $dataFind = $this->model->get_by_id($this->request->getPost('username'));
            if ($dataFind) {
                session()->setFlashdata('ci_flash_message_username', lang("Errors.errorUsernameExist", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_username_type', ' alert-danger ');
                return $this->create();
            }
        }
            
        $this->model->update($id, $data);
        session()->setFlashdata('ci_flash_message', lang("Default.UpdateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        if (session("username")==$this->request->getPost('username')) session()->set($data);
        return redirect()->to(base_url($this->PageData['parent']));
    }

    //DELETE
    public function delete($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("username"):$id;
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
                    if($row->username==session("username"))continue;
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
    private function is_request_valid($reqPassword = 1){
        $res = FALSE;

        if ($reqPassword == 1) {
            $this->validation->setRules([
                'username' => 'trim|required|max_length[50]',
                'password' => 'trim|required|max_length[100]',
                'nama' => 'trim|required|max_length[50]',
                'level' => 'trim|required|max_length[10]',
            ]);
        }else{
            $this->validation->setRules([
                'username' => 'trim|required|max_length[50]',
                'nama' => 'trim|required|max_length[50]',
                'level' => 'trim|required|max_length[10]',
            ]);
        }

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

    //ENDFUNCTION
}