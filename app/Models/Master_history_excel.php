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

class Master_history_excel extends Model
{
    protected $table      = 'master_history';
    protected $primaryKey = 'id_master';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['id_master', 'id', 'harga', 'operators', 'quantity', 'timestamps', 'username', 'id_suplier', 'Riwayat'];

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
    public $columnIndex = "id_master";

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
        ->setTitle('Riwayat Barang Data')
        ->setSubject('Riwayat Barang Data')
        ->setDescription('Riwayat Barang Data '.date("Y"))
        ->setKeywords('Riwayat Barang')
        ->setCategory('Riwayat Barang');

        // subtitle on row 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', 'Riwayat Barang'.date("Y"));
        $spreadsheet->getActiveSheet()->mergeCells('A3:E3');
        // date on row 4
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', date("d M Y H:i"));
        $spreadsheet->getActiveSheet()->mergeCells('A4:E4');

        // columnHeader
        $startRowHeader = 6;
        $highestColumn = "J";
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$startRowHeader, 'No')
        ->setCellValue('B'.$startRowHeader, 'ID Transaksi')
        ->setCellValue('C'.$startRowHeader, 'Kode Barang')
        ->setCellValue('D'.$startRowHeader, 'Quantity')
        ->setCellValue('E'.$startRowHeader, 'Harga')
        ->setCellValue('F'.$startRowHeader, 'Tanggal Transaksi')
        ->setCellValue('G'.$startRowHeader, 'ID Vendor/Divisi')
        ->setCellValue('H' . $startRowHeader, 'Username')
        ->setCellValue('I'.$startRowHeader, 'Riwayat')
        ->setCellValue('J' . $startRowHeader, 'Subtotal')
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
        $spreadsheet->getActiveSheet()->getStyle('I'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('J' . $startRowHeader)->applyFromArray($this->headerStyle);
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
        $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);

        // merge top row as title
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$highestColumn.'1');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "Riwayat Barang Data");
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$highestColumn.'1')->applyFromArray($this->headerStyle);

        $startRowBody = $startRowHeader+1;
        $index = 0;
        $data_master_history = $this->orderBy($this->columnIndex, $this->order)->findAll();
        foreach ($data_master_history as $key => $master_history) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$startRowBody, ++$index);
            if(isset($master_history->id))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('B'.$startRowBody, $master_history->id);
            if(isset($master_history->id_master))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('C'.$startRowBody, $master_history->id_master);
            if (isset($master_history->quantity))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $startRowBody, $master_history->quantity);
            if(isset($master_history->harga))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('E'.$startRowBody, $master_history->harga);
            if(isset($master_history->timestamps))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('F'.$startRowBody, date("d-m-Y", $master_history->timestamps));
            if(isset($master_history->id_suplier))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$startRowBody, $master_history->id_suplier);
            if (isset($master_history->username))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H' . $startRowBody, $master_history->username);
            if(isset($master_history->Riwayat))
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit('I'.$startRowBody, $master_history->operators.$master_history->quantity, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $startRowBody, '=(D' . $startRowBody . '*E' . $startRowBody. ')');
            $startRowBody++;
        };
        if ($startRowBody > ($startRowHeader + 1)) {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $startRowBody . ':C' . $startRowBody);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $startRowBody, 'TOTAL');
            $spreadsheet->getActiveSheet()->getStyle('A' . $startRowBody . ':C' . $startRowBody)->applyFromArray($this->headerStyle);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('D' . $startRowBody, '=SUM(D' . ($startRowHeader + 1) . ':D' . ($startRowBody - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('D' . $startRowBody)->applyFromArray($this->headerStyle);

            $spreadsheet->setActiveSheetIndex(0)->setCellValue('J' . $startRowBody, '=SUM(J' . ($startRowHeader + 1) . ':J' . ($startRowBody - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('J' . $startRowBody)->applyFromArray($this->headerStyle);
        }

        $spreadsheet->getActiveSheet()->setTitle('Data Riwayat Barang '.date('Y'));
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Riwayat Barang '.date("Y").'.xlsx"');
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