<?php
namespace App\Models;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/
use CodeIgniter\Model;

class Profil_perusahaan_model extends Model
{
    protected $table      = 'profil_perusahaan';
    protected $primaryKey = 'key_name';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['key_name', 'values_data'];

    protected $useAutoIncrement = false;

    // protected $returnType     = 'array';
    protected $returnType     = 'object';
    protected $useSoftDeletes = false;

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    protected $validationRules    = [];
    protected $validationMessages = [];
    protected $skipValidation     = false;

    public $order = "DESC";
    public $columnIndex = "key_name";

    public function get_fields(){
        return $this->allowedFields;
    }

    // GET BY ID
    public function get_by_id($id)
    {
        return $this->where($this->primaryKey, $id)->orderBy($this->columnIndex, $this->order)->first();
    }

    public function get_row_by($key, $val)
    {
        return $this->where($key, $val)->orderBy($this->columnIndex, $this->order)->first();
    }

    public function get_by($key, $val)
    {
        return $this->orderBy($this->columnIndex, $this->order)->where($key, $val)->findAll();
    }

    public function total_rows($arr = NULL)
    {
        if ($arr == NULL) {
            return $this->orderBy($this->columnIndex, $this->order)->countAllResults();
        }else{
            foreach ($arr as $key => $value) {
                $this->where($key, $value);
            };
            return $this->countAllResults();
        }
    }

    public function get_data($keyword = null)
    {
        if ($keyword == null) {
            return $this->orderBy($this->columnIndex, $this->order);
        };
        $this
            ->groupStart()
            ->like('key_name', $keyword)
            ->orLike('values_data', $keyword)
            ->groupEnd()
        ->orderBy($this->columnIndex, $this->order);

        return $this;
    }

    public function truncate(){
        $this->query('TRUNCATE '.$this->table);
        return TRUE;
    }
}