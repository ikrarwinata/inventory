<?php
namespace App\Models;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/
use CodeIgniter\Model;

class Pengembalian_model extends Model
{
    protected $table      = 'pengembalian';
    protected $primaryKey = 'id';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['id', 'id_penjualan', 'id_master', 'quantity', 'harga', 'timestamps', 'id_divisi', 'username'];

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
    public $columnIndex = "id";

    public function get_fields(){
        return $this->allowedFields;
    }

    // GET BY ID
    public function get_by_id($id)
    {
        return $this->where($this->table . '.' . $this->primaryKey, $id)->sort()->first();
    }

    public function get_row_by($key, $val)
    {
        return $this->where($key, $val)->sort()->first();
    }

    public function get_by($key, $val)
    {
        return $this->where($key, $val)->sort()->findAll();
    }

    public function total_rows($arr = NULL)
    {
        if ($arr == NULL) {
            return $this->countAllResults();
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
            return $this->sort();
        };
        $this
            ->groupStart()
            ->like('id_penjualan', $keyword)
            ->like('id_master', $keyword)
            ->orLike('quantity', $keyword)
            ->orLike('harga', $keyword)
            ->orLike('timestamps', $keyword)
            ->orLike('id_divisi', $keyword)
            ->orLike('username', $keyword)
            ->groupEnd();
        return $this->sort();
    }

    public function sort($columnIndex = NULL, $sortDirection = NULL)
    {
        if($columnIndex == NULL){
            if (strpos($this->columnIndex, ".") !== FALSE) {
                $columnIndex = $this->columnIndex;
            }else{
                $columnIndex = $this->table . '.' . $this->columnIndex;
            }
        };
        if($sortDirection == NULL){
            $sortDirection = $this->order;
        };
        return $this->orderBy($columnIndex, $sortDirection);
    }

    public function truncate(){
        $this->query('TRUNCATE '.$this->table);
        return TRUE;
    }
}