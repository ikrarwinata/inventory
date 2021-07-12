<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Models\Profil_perusahaan_model;
use App\Controllers\BaseController;

class Profil_perusahaan extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Profil_perusahaan_model(); //Set Default Models Of this Controller
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
            'parent' => 'administrator/Profil_perusahaan',
            'title' => 'Profil_perusahaan',
            'subtitle' => array(
                'Profil_perusahaan',
            ),
            'nav' => array('administrator/Profil_perusahaan'),
            'stylesheets' => array(),
            'scripts' => array(),
            'locale' => 'id',
            'access' => array('superadmin')
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
        $data = [
            'nama_perusahaan' => $this->model->get_by_id("nama_perusahaan")->values_data,
            'telepon_perusahaan' => $this->model->get_by_id("telepon_perusahaan")->values_data,
            'alamat_perusahaan' => $this->model->get_by_id("alamat_perusahaan")->values_data,
            'pengingat_kadaluarsa' => $this->model->get_by_id("pengingat_kadaluarsa")->values_data,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/profil_perusahaan/profil_perusahaan_list', $data);
        //endindex
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

        $data = [
            'values_data' => $this->request->getPost('v'),
        ];
            
        $this->model->update($id, $data);
        session()->setFlashdata('ci_flash_message', lang("Default.UpdateSuccess", [], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-success ');
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
    }
}