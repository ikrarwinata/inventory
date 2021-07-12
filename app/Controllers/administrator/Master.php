<?php
namespace App\Controllers\administrator;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/

use App\Models\Master_model;
use App\Controllers\BaseController;
use App\Models\Kategori_master_model;
use App\Models\Master_history_excel;
use App\Models\Master_view_excel;
use App\Models\Master_view_model;
use App\Models\Satuan_master_model;
use App\Models\Vendor_model;

class Master extends BaseController
{
    /**
     * Class constructor.
     */ 
    protected $model; //Default Models Of this Controler

    public function __construct()
    {
        $this->model = new Master_model(); //Set Default Models Of this Controller
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
            'parent' => 'administrator/Master',
            'title' => 'Master',
            'subtitle' => array(
                'Master',
            ),
            'nav' => array('Barang'),
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
        $master_view = new Master_view_model();

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
            if(in_array($sortcolumn, $master_view->get_fields())){
                $master_view->order = $sortorder;
                $master_view->columnIndex = $sortcolumn;
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
        $this->PageData["title"] = lang("Text.Assets", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.Assets", [], $this->PageData['locale'])];
        $page = $this->request->getGet("page");
        $page = $page<=0?1:$page;
        $keyword = $this->request->getGet("keyword");
        $totalrecord = $master_view->get_data($keyword)->countAllResults();

        $data = [
            'sortcolumn' => $sortcolumn,
            'sortorder' => $sortorder,
            'data' => $master_view->get_data($keyword)->paginate($perPage),
            'perPage' => $perPage,
            'currentPage' => $page,
            'start' => min(($page*$perPage)-($perPage-1), $totalrecord),
            'end' => min(($perPage*$page), $totalrecord),
            'totalrecord' => $totalrecord,
            'pager' => $master_view->pager,
            'keyword' => $keyword,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/master/master_list', $data);
        //endindex
    }

    //INDEX 
    public function history()
    {
        $master_view = new Master_view_model();
        
        // Table sorting using GET var
        $sortcolumn = $this->request->getGetPost("sortcolumn");
        $sortorder = $this->request->getGetPost("sortorder");
        if ($sortcolumn == NULL || $sortorder == NULL) {
            if (session()->has("sorting_table")) {
                if (session("sorting_table") == $this->model->table) {
                    $sortcolumn = session("sortcolumn");
                    $sortorder = session("sortorder");
                };
            };
        } else {
            $sortcolumn = base64_decode($sortcolumn);
        }
        if ($sortcolumn != NULL && $sortorder != NULL) {
            if ($sortorder != "DESC" && $sortorder != "ASC") $sortorder = "ASC";
            if ($sortcolumn == "master_history.timestamps") {
                $master_view->order = $sortorder;
                $master_view->columnIndex = $sortcolumn;
                session()->set('sortcolumn', $sortcolumn);
                session()->set('sortorder', $sortorder);
                session()->set('sorting_table', $this->model->table);
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
                if (session("paging_table") == $this->model->table) {
                    $perPage = session("perPage");
                };
            };
        };
        if ($perPage != NULL) {
            // Minimum data per-page = 2
            if ($perPage <= 0) $perPage = 2;
            session()->set('perPage', $perPage);
            session()->set('paging_table', $this->model->table);
        } else {
            // Default data per-page = 20
            $perPage = 20;
            session()->remove('paging_table');
            session()->remove('perPage');
        }

        $this->PageData["title"] = lang("Text.AssetsHistory", [], $this->PageData['locale']);
        $this->PageData["subtitle"] = [lang("Text.AssetsHistory", [], $this->PageData['locale']), "History"];

        $this->PageData['scripts'] = array(
            'assets/build/js/button.js',
        );
        $page = $this->request->getGet("page");
        $page = $page <= 0 ? 1 : $page;
        $keyword = $this->request->getGet("keyword");
        $master_view->join("master_history", "master_view.kode_barang = master_history.id_master");
        $master_view->columnIndex = "master_history.timestamps";
        $totalrecord = $master_view->get_data($keyword)->countAllResults();
        $master_view->join("master_history", "master_view.kode_barang = master_history.id_master");
        $master_view->columnIndex = "master_history.timestamps";
        $data = [
            'sortcolumn' => "master_history.timestamps",
            'sortorder' => $sortorder,
            'data' => $master_view->get_data($keyword)->paginate($perPage),
            'perPage' => $perPage,
            'currentPage' => $page,
            'start' => min(($page * $perPage) - ($perPage - 1), $totalrecord),
            'end' => min(($perPage * $page), $totalrecord),
            'totalrecord' => $totalrecord,
            'pager' => $master_view->pager,
            'keyword' => $keyword,
            'PageAttribute' => $this->PageData,
        ];
        return view('administrator/master/master_history', $data);
    }

    //READfunction
    public function read($id=NULL)
    {
        $id = $id==NULL?$this->request->getPostGet("id"):$id;
        $master_view = new Master_view_model();
        $dataFind = $master_view->get_by_id($id);
        $this->PageData['title'] = lang("Text.AssetDetail", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            lang("Text.Assets", [], $this->PageData['locale']),
            $this->PageData['title']
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'].'/index'));
        }
        $data = [
            'data' => $master_view->get_by_id($id), //get_by_id on data
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/master/master_read', $data);
    }

    //CREATEfunction
    public function create()
    {
        $this->PageData['title'] = lang("Text.CreateAssets", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            $this->PageData['title']
        );

        $vendor = new Vendor_model();
        $satuan = new Satuan_master_model();
        $kategori = new Kategori_master_model();
        $data = [
            'data' => (object) [
                'oldid' => NULL,
                'id' => set_value('id', generateId("ASST")),
                'barcode' => set_value('barcode'),
                'nama' => set_value('nama'),
                'stok' => set_value('stok'),
                'harga' => set_value('harga'),
                'satuan' => set_value('satuan'),
                'kategori' => set_value('kategori'),
                'berat' => set_value('berat'),
                'kadaluarsa' => set_value('kadaluarsa', (date("Y") + 1).date("-m-d")),
                'gedung' => set_value('gedung'),
                'ruangan' => set_value('ruangan'),
                'posisi' => set_value('posisi'),
                'foto' => NULL,
                'id_vendor' => set_value('id_vendor'),
            ],
            'vendor'=>$vendor->select('id, nama_vendor')->findAll(),
            'satuan' => $satuan->select('id, nama_satuan')->findAll(),
            'kategori' => $kategori->select('id, nama_kategori')->findAll(),
            'gedung' => $this->model->select("DISTINCT(gedung) AS gedung")->findAll(),
            'ruangan' => $this->model->select("DISTINCT(ruangan) AS ruangan")->findAll(),
            'posisi' => $this->model->select("DISTINCT(posisi) AS posisi")->findAll(),
            'action' => site_url($this->PageData['parent'].'/create_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/master/master_form', $data);
    }
    
    //ACTIONCREATEfunction
    public function create_action()
    {
        if($this->is_request_valid() == FALSE){
            return $this->create();
        };

        $this->model->where("id", $this->request->getPost("id"));
        $check = $this->model->first();
        if($check) {
            session()->setFlashdata('ci_flash_message_id', lang("Errors.errorDataDuplicate", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_id_type', ' alert-danger ');
            return $this->create();
        }
        if ($this->request->getPost("barcode") != NULL) {
            $this->model->where("barcode", $this->request->getPost("barcode"));
            $check = $this->model->first();
            if ($check) {
                session()->setFlashdata('ci_flash_message_barcode', lang("Errors.errorDataDuplicate", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_barcode_type', ' alert-danger ');
                return $this->create();
            }
        }

        $data = [
            'id' => $this->request->getPost('id'),
            'barcode' => $this->request->getPost('barcode'),
            'nama' => $this->request->getPost('nama'),
            'stok' => $this->request->getPost('stok'),
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
                $data['foto'] = './writable/uploads/product/'.$foto->getName();
            }else{
                session()->setFlashdata('ci_flash_message_foto', $foto->getErrorString().' ('.$foto->getError().')');
                session()->setFlashdata('ci_flash_message_foto_type', ' text-danger ');
            };
        };
        
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
        $this->PageData['title'] = lang("Text.UpdateAssets", [], $this->PageData['locale']);
        $this->PageData['subtitle'] = array(
            $this->PageData['title']
        );

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
        }

        $vendor = new Vendor_model();
        $satuan = new Satuan_master_model();
        $kategori = new Kategori_master_model();
        $data = [
            'data' => (object) [
                'oldid' => $dataFind->id,
                'oldfoto' => isset($dataFind->foto)?$dataFind->foto:NULL,
                'id' => set_value('id', $dataFind->id),
                'barcode' => set_value('barcode', $dataFind->barcode),
                'nama' => set_value('nama', $dataFind->nama),
                'stok' => set_value('stok', $dataFind->stok),
                'harga' => set_value('harga', $dataFind->harga),
                'kategori' => set_value('kategori', $dataFind->kategori),
                'satuan' => set_value('satuan', $dataFind->satuan),
                'berat' => set_value('berat', $dataFind->berat),
                'kadaluarsa' => set_value('kadaluarsa', date("Y-m-d", $dataFind->kadaluarsa)),
                'gedung' => set_value('gedung', $dataFind->gedung),
                'ruangan' => set_value('ruangan', $dataFind->ruangan),
                'posisi' => set_value('posisi', $dataFind->posisi),
                'foto' => $dataFind->foto,
                'id_vendor' => set_value('id_vendor', $dataFind->id_vendor),
            ],
            'vendor' => $vendor->select('id, nama_vendor')->findAll(),
            'satuan' => $satuan->select('id, nama_satuan')->findAll(),
            'kategori' => $kategori->select('id, nama_kategori')->findAll(),
            'gedung' => $this->model->select("DISTINCT(gedung) AS gedung")->findAll(),
            'ruangan' => $this->model->select("DISTINCT(ruangan) AS ruangan")->findAll(),
            'posisi' => $this->model->select("DISTINCT(posisi) AS posisi")->findAll(),
            'action' => site_url($this->PageData['parent'].'/update_action'),
            'PageAttribute' => $this->PageData
        ];
        return view('administrator/master/master_form', $data);
    }
    
    //ACTIONUPDATEfunction
    public function update_action()
    {
        $id = $this->request->getPostGet('oldid');
        $dataFind = $this->model->find($id);

        if($dataFind == false || $id == NULL){
            session()->setFlashdata('ci_flash_message', lang("Errors.errorDataNotExist", [], $this->PageData['locale']));
            session()->setFlashdata('ci_flash_message_type', ' alert-danger ');
            return redirect()->to(base_url($this->PageData['parent'] . '/index'));
        };

        if($this->is_request_valid() == FALSE){
            return $this->update($id);
        };

        if ($this->request->getPost("id") != $this->request->getPost("oldid")) {
            $this->model->where("id", $this->request->getPost("id"));
            $check = $this->model->first();

            if ($check) {
                session()->setFlashdata('ci_flash_message_id', lang("Errors.errorDataDuplicate", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_id_type', ' alert-danger ');
                return $this->update($this->request->getPost("oldid"));
            }
        }
        if ($this->request->getPost("barcode") != $this->request->getPost("oldbarcode")) {
            $this->model->where("barcode", $this->request->getPost("barcode"));
            $check = $this->model->first();

            if ($check) {
                session()->setFlashdata('ci_flash_message_barcode', lang("Errors.errorDataDuplicate", [], $this->PageData['locale']));
                session()->setFlashdata('ci_flash_message_barcode_type', ' alert-danger ');
                return $this->update($this->request->getPost("oldid"));
            }
        }

        $data = [
            'id' => $this->request->getPost('id'),
            'barcode' => $this->request->getPost('barcode'),
            'nama' => $this->request->getPost('nama'),
            'stok' => $this->request->getPost('stok'),
            'kategori' => $this->request->getPost('kategori'),
            'harga' => $this->request->getPost('harga'),
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
                $data['foto'] = './writable/uploads/product/'.$foto->getName();
                safeUnlink($this->request->getPost('oldfoto'));
            }else{
                session()->setFlashdata('ci_flash_message_foto', $foto->getErrorString().' ('.$foto->getError().')');
                session()->setFlashdata('ci_flash_message_foto_type', ' text-danger ');
            };
        };
            
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
            if (isset($row->foto)) {
                safeUnlink($row->foto);
            }
            
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
                    
                    if (isset($row->foto)) {
                        safeUnlink($row->foto);
                    }
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
            if (isset($value->foto)) {
                safeUnlink($value->foto);
            }
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
            'nama' => 'trim|required|max_length[255]',
            'stok' => 'trim|required|min_length[1]|max_length[11]',
            'harga' => 'trim|required|min_length[1]|max_length[11]',
            'kategori' => 'trim|required|max_length[11]',
            'satuan' => 'trim|required|max_length[11]',
            'berat' => 'trim|required|min_length[1]|max_length[11]',
            'kadaluarsa' => 'trim|max_length[11]',
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
        $excel = new Master_view_excel();
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

    public function from_excel()
    {
        $filename = NULL;
        if ($excelfile = $this->request->getFile('excel_file')) {
            if ($excelfile->isValid()) {
                if (!$excelfile->hasMoved()) {
                    $fotonewName = $excelfile->getRandomName();
                    $excelfile->move(WRITEPATH . 'uploads', $fotonewName);
                }
                $filename = WRITEPATH . 'uploads/' . $excelfile->getName();
            } else {
                session()->setFlashdata('ci_flash_message', $excelfile->getErrorString() . ' (' . $excelfile->getError() . ')');
                session()->setFlashdata('ci_flash_message_type', ' text-danger ');
                return $this->index();
            };
        };
        $excel = new Master_view_excel();
        $result = $excel->import($filename);
        session()->setFlashdata('ci_flash_message', lang("Default.ImportedData", ['total'=>$result], $this->PageData['locale']));
        session()->setFlashdata('ci_flash_message_type', ' alert-primary ');
        safeUnlink($filename);
        return redirect()->to(base_url($this->PageData['parent'] . '/index'));
    }

    public function to_word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=data stok " . date("Y") . ".doc");

        $master_view = new Master_view_model();
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
            $master_view->order = $sortorder;
            $master_view->columnIndex = $sortcolumn;
        };
        $data = array(
            'data_master' => $master_view->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/master/master_word', $data);
    }

    public function print_all()
    {
        $master_view = new Master_view_model();
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
            $master_view->order = $sortorder;
            $master_view->columnIndex = $sortcolumn;
        };
        $data = array(
            'data_master' => $master_view->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/master/master_print', $data);
    }

    public function history_excel()
    {
        $excel = new Master_history_excel();
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

    public function history_word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=history stok " . date("Y") . ".doc");

        $master_view = new Master_view_model();
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
            $master_view->order = $sortorder;
            $master_view->columnIndex = $sortcolumn;
        };
        $master_view->join("master_history", "master_view.kode_barang = master_history.id_master");
        $master_view->columnIndex = "master_history.timestamps";
        $data = array(
            'data_master' => $master_view->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/master/master_history_word', $data);
    }

    public function history_print_all()
    {
        $master_view = new Master_view_model();
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
            $master_view->order = $sortorder;
            $master_view->columnIndex = $sortcolumn;
        };
        $master_view->join("master_history", "master_view.kode_barang = master_history.id_master");
        $master_view->columnIndex = "master_history.timestamps";
        $data = array(
            'data_master' => $master_view->sort()->findAll(),
            'start' => 0
        );

        return view('administrator/master/master_history_print', $data);
    }
}