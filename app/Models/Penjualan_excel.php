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

class Penjualan_excel extends Model
{
    protected $table      = 'penjualan';
    protected $primaryKey = 'id';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['id', 'id_master', 'quantity', 'harga', 'timestamps', 'id_divisi', 'username'];

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
        ->setTitle('Pengeluaran Data')
        ->setSubject('Pengeluaran Data')
        ->setDescription('Pengeluaran Data '.date("Y"))
        ->setKeywords('Pengeluaran')
        ->setCategory('Pengeluaran');

        // subtitle on row 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', 'Penjualan Data'.date("Y"));
        $spreadsheet->getActiveSheet()->mergeCells('A3:E3');
        // date on row 4
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', date("d M Y H:i"));
        $spreadsheet->getActiveSheet()->mergeCells('A4:E4');

        // columnHeader
        $startRowHeader = 6;
        $highestColumn = "I";
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$startRowHeader, 'No')
        ->setCellValue('B'.$startRowHeader, 'ID Transaksi')
        ->setCellValue('C'.$startRowHeader, 'Kode Barang')
        ->setCellValue('D'.$startRowHeader, 'Tanggal')
        ->setCellValue('E'.$startRowHeader, 'ID Divisi')
        ->setCellValue('F'.$startRowHeader, 'Quantity')
        ->setCellValue('G'.$startRowHeader, 'Harga')
        ->setCellValue('H'.$startRowHeader, 'Subtotal')
        ->setCellValue('I'.$startRowHeader, 'Username')
        ;
        // set column header style
        $spreadsheet->getActiveSheet()->getStyle("A".$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('B'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('C'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('D'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('E'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('F'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('G'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('H'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('I' . $startRowHeader)->applyFromArray($this->headerStyle);
        // set column header autosize
        $spreadsheet->getActiveSheet()->getColumnDimension("A")->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);

        // merge top row as title
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$highestColumn.'1');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "Penjualan Data");
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$highestColumn.'1')->applyFromArray($this->headerStyle);

        $startRowBody = $startRowHeader+1;
        $index = 0;
        $data_penjualan = $this->orderBy($this->columnIndex, $this->order)->findAll();
        foreach ($data_penjualan as $key => $penjualan) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$startRowBody, ++$index);
            if(isset($penjualan->id))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$startRowBody, $penjualan->id);
            if(isset($penjualan->id_master))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$startRowBody, $penjualan->id_master);
            if(isset($penjualan->timestamps))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D'.$startRowBody, date("d-m-Y", $penjualan->timestamps));
            if(isset($penjualan->id_vendor))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$startRowBody, $penjualan->id_divisi);
            if (isset($penjualan->quantity))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $startRowBody, $penjualan->quantity);
            if (isset($penjualan->harga))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $startRowBody, $penjualan->harga);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $startRowBody, '=(F' . $startRowBody . '*G' . $startRowBody . ')');
            if(isset($penjualan->username))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I'.$startRowBody, $penjualan->username);
            $startRowBody++;
        };
        if($startRowBody > ($startRowHeader + 1)) {
            $spreadsheet->getActiveSheet()->mergeCells('A'. $startRowBody.':E' . $startRowBody);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $startRowBody, 'TOTAL');
            $spreadsheet->getActiveSheet()->getStyle('A' . $startRowBody .':E' . $startRowBody)->applyFromArray($this->headerStyle);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('F' . $startRowBody, '=SUM(F' . ($startRowHeader + 1) . ':F' . ($startRowBody - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('F' . $startRowBody)->applyFromArray($this->headerStyle);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $startRowBody, '=SUM(H' . ($startRowHeader + 1) . ':H' . ($startRowBody - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('H' . $startRowBody)->applyFromArray($this->headerStyle);
        }

        $spreadsheet->getActiveSheet()->setTitle('Pengeluaran Data '.date('Y'));
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Pengeluaran '.date("Y").'.xlsx"');
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