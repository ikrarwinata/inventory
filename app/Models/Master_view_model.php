<?php
namespace App\Models;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/
use CodeIgniter\Model;

class Master_view_model extends Model
{
    protected $table      = 'master_view';
    protected $primaryKey = 'kode_barang';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['kode_barang', 'barcode', 'nama', 'stok', 'harga', 'kategori', 'satuan', 'berat', 'kadaluarsa', 'foto', 'gedung', 'ruangan', 'posisi', 'id_vendor'];

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
    public $columnIndex = "kode_barang";

    public function get_fields(){
        return $this->allowedFields;
    }

    // GET BY ID
    public function get_by_id($id)
    {
        return $this->where($this->table . "." . $this->primaryKey, $id)->orderBy($this->table . "." . $this->columnIndex, $this->order)->first();
    }

    public function get_row_by($key, $val)
    {
        return $this->where($key, $val)->orderBy($this->table . "." . $this->columnIndex, $this->order)->first();
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
        $order = $this->columnIndex;
        if(strpos($this->columnIndex, ".") !== FALSE) {
            $order = $this->columnIndex;
        }else {
            $order = $this->table . '.' . $this->columnIndex;
        }
        if ($keyword == null) {
            return $this->orderBy($order, $this->order);
        };
        $this
            ->groupStart()
            ->like($this->table.'.kode_barang', $keyword)
            ->orLike($this->table.'.barcode', $keyword)
            ->orLike($this->table.'.nama', $keyword)
            ->orLike($this->table.'.stok', $keyword)
            ->orLike($this->table.'.harga', $keyword)
            ->orLike($this->table.'.nama_kategori', $keyword)
            ->orLike($this->table.'.nama_satuan', $keyword)
            ->orLike($this->table.'.berat', $keyword)
            ->orLike($this->table.'.kadaluarsa', $keyword)
            ->orLike($this->table.'.id_vendor', $keyword)
            ->groupEnd()
        ->orderBy($order, $this->order);

        return $this;
    }

    public function sort($columnIndex = NULL, $sortDirection = NULL)
    {
        return $this->orderBy(($columnIndex == NULL ? $this->columnIndex : $columnIndex), ($sortDirection == NULL ? $this->order : $sortDirection));
    }
}