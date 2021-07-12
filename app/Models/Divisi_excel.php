<?php
namespace App\Models;
require_once(APPPATH.'ThirdParty'.DIRECTORY_SEPARATOR.'phpspreadsheet'.DIRECTORY_SEPARATOR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php');
use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
/**
* THIS CONTROLER CODEIGNITER 4
* Codeigniter Version 4.x
**/
use CodeIgniter\Model;

class Divisi_excel extends Model
{
    protected $table      = 'divisi';
    protected $primaryKey = 'id';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['id', 'nama_divisi', 'kota', 'alamat', 'telepon', 'keterangan'];

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

    public $headerStyle = array(
                'font' => array('bold' => true), // Set font nya jadi bold
                'alignment' => array(
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
                ),
                'borders' => array(
                    'top' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border top dengan garis tipis
                    'right' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN],  // Set border right dengan garis tipis
                    'bottom' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN], // Set border bottom dengan garis tipis
                    'left' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN] // Set border left dengan garis tipis
                )
            );

    public function export()
    {
        $spreadsheet = new Spreadsheet();
        // Set document properties
        $spreadsheet->getProperties()->setCreator('shouts')
        ->setLastModifiedBy('shouts')
        ->setTitle('Divisi Data')
        ->setSubject('Divisi Data')
        ->setDescription('Divisi Data '.date("Y"))
        ->setKeywords('Divisi')
        ->setCategory('Divisi');

        // subtitle on row 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', 'Divisi Data'.date("Y"));
        $spreadsheet->getActiveSheet()->mergeCells('A3:E3');
        // date on row 4
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', date("d M Y H:i"));
        $spreadsheet->getActiveSheet()->mergeCells('A4:E4');

        // columnHeader
        $startRowHeader = 6;
        $highestColumn = "G";
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$startRowHeader, 'No')
        ->setCellValue('B'.$startRowHeader, 'Id')
        ->setCellValue('C'.$startRowHeader, 'Nama Divisi')
        ->setCellValue('D'.$startRowHeader, 'Kota')
        ->setCellValue('E'.$startRowHeader, 'Alamat')
        ->setCellValue('F'.$startRowHeader, 'Telepon')
        ->setCellValue('G'.$startRowHeader, 'Keterangan')
        ;
        // set column header style
        $spreadsheet->getActiveSheet()->getStyle("A".$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('B'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('C'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('E'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startRowHeader)->applyFromArray($this->headerStyle);
        // set column header autosize
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);

        // merge top row as title
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$highestColumn.'1');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "Divisi Data");
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$highestColumn.'1')->applyFromArray($this->headerStyle);

        $startRowBody = $startRowHeader+1;
        $index = 0;
        $data_divisi = $this->orderBy($this->columnIndex, $this->order)->findAll();
        foreach ($data_divisi as $key => $divisi) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$startRowBody, ++$index);
            if(isset($divisi->id))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$startRowBody, $divisi->id);
            if(isset($divisi->nama_vendor))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$startRowBody, $divisi->nama_divisi);
            if(isset($divisi->kota))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$startRowBody, $divisi->kota);
            if(isset($divisi->alamat))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$startRowBody, $divisi->alamat);
            if(isset($divisi->telepon))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$startRowBody, $divisi->telepon);
            if(isset($divisi->keterangan))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$startRowBody, $divisi->keterangan);
            $startRowBody++;
        };

        $spreadsheet->getActiveSheet()->setTitle('Divisi Data '.date('Y'));
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Divisi '.date("Y").'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }
}