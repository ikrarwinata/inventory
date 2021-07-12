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

class Master_view_excel extends Model
{
    protected $table      = 'master_view';
    protected $primaryKey = 'kode_barang';

    //To help protect against Mass Assignment Attacks, the Model class requires 
    //that you list all of the field names that can be changed during inserts and updates
    // https://codeigniter4.github.io/userguide/models/model.html#protecting-fields
    protected $allowedFields = ['kode_barang', 'barcode', 'nama', 'stok', 'harga', 'subtotal', 'berat', 'kadaluarsa', 'nama_kategori', 'nama_satuan', 'nama_vendor'];

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
        ->setTitle('Stok Barang Data')
        ->setSubject('Stok Barang Data')
        ->setDescription('Stok Barang Data '.date("Y"))
        ->setKeywords('Stok Barang')
        ->setCategory('Stok Barang');

        // subtitle on row 3
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A3', 'Stok Barang Data'.date("Y"));
        $spreadsheet->getActiveSheet()->mergeCells('A3:E3');
        // date on row 4
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A4', date("d M Y H:i"));
        $spreadsheet->getActiveSheet()->mergeCells('A4:E4');

        // columnHeader
        $startRowHeader = 6;
        $highestColumn = "O";
        $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A'.$startRowHeader, 'No')
        ->setCellValue('B'.$startRowHeader, 'Kode Barang')
        ->setCellValue('C'.$startRowHeader, 'Barcode')
        ->setCellValue('D'.$startRowHeader, 'Nama')
        ->setCellValue('E'.$startRowHeader, 'Kategori')
        ->setCellValue('F'.$startRowHeader, 'Satuan')
        ->setCellValue('G'.$startRowHeader, 'Stok')
        ->setCellValue('H'.$startRowHeader, 'Harga')
        ->setCellValue('I'.$startRowHeader, 'Subtotal')
        ->setCellValue('J'.$startRowHeader, 'Berat (g)')
        ->setCellValue('K'.$startRowHeader, 'Kadaluarsa')
        ->setCellValue('L'.$startRowHeader, 'Gedung')
        ->setCellValue('M'.$startRowHeader, 'Ruangan')
        ->setCellValue('N'.$startRowHeader, 'Posisi')
        ->setCellValue('O'.$startRowHeader, 'Vendor')
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
        $spreadsheet->getActiveSheet()->getStyle('J'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('K'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('L'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('M'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('N'.$startRowHeader)->applyFromArray($this->headerStyle);
        $spreadsheet->getActiveSheet()->getStyle('O'.$startRowHeader)->applyFromArray($this->headerStyle);
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
        $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

        // merge top row as title
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$highestColumn.'1');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A1', "Stok Barang Data");
        $spreadsheet->getActiveSheet()->getStyle('A1:'.$highestColumn.'1')->applyFromArray($this->headerStyle);

        $startRowBody = $startRowHeader+1;
        $index = 0;
        $data_master_view = $this->orderBy($this->columnIndex, $this->order)->findAll();
        foreach ($data_master_view as $key => $master_view) {
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A'.$startRowBody, ++$index);
            if(isset($master_view->kode_barang))
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit('B'.$startRowBody, $master_view->kode_barang, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if(isset($master_view->barcode))
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit('C'.$startRowBody, $master_view->barcode, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if(isset($master_view->nama))
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit('D'.$startRowBody, $master_view->nama, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if (isset($master_view->nama_kategori))
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit('E' . $startRowBody, $master_view->nama_kategori, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if (isset($master_view->nama_satuan))
                $spreadsheet->setActiveSheetIndex(0)->setCellValueExplicit('F' . $startRowBody, $master_view->nama_satuan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            if(isset($master_view->stok))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('G'.$startRowBody, $master_view->stok);
            if(isset($master_view->harga))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('H'.$startRowBody, $master_view->harga);
            if(isset($master_view->subtotal))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('I'.$startRowBody, $master_view->subtotal);
            if(isset($master_view->berat))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('J'.$startRowBody, $master_view->berat);
            if(isset($master_view->kadaluarsa))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('K'.$startRowBody, date("d-m-Y", $master_view->kadaluarsa));
            if(isset($master_view->gedung))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('L'.$startRowBody, $master_view->gedung);
            if(isset($master_view->ruangan))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('M'.$startRowBody, $master_view->ruangan);
            if(isset($master_view->posisi))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('N'.$startRowBody, $master_view->posisi);
            if(isset($master_view->nama_vendor))
                $spreadsheet->setActiveSheetIndex(0)->setCellValue('O'.$startRowBody, $master_view->nama_vendor);
            $startRowBody++;
        };
        if ($startRowBody > ($startRowHeader + 1)) {
            $spreadsheet->getActiveSheet()->mergeCells('A' . $startRowBody . ':F' . $startRowBody);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('A' . $startRowBody, 'TOTAL');
            $spreadsheet->getActiveSheet()->getStyle('A' . $startRowBody . ':F' . $startRowBody)->applyFromArray($this->headerStyle);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('G' . $startRowBody, '=SUM(G' . ($startRowHeader + 1) . ':G' . ($startRowBody - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('G' . $startRowBody)->applyFromArray($this->headerStyle);
            $spreadsheet->setActiveSheetIndex(0)->setCellValue('I' . $startRowBody, '=SUM(I' . ($startRowHeader + 1) . ':I' . ($startRowBody - 1) . ')');
            $spreadsheet->getActiveSheet()->getStyle('I' . $startRowBody)->applyFromArray($this->headerStyle);
        }

        $spreadsheet->getActiveSheet()->setTitle('Stok Barang Data '.date('Y'));
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Stok Barang '.date("Y").'.xlsx"');
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


    public function import($filepath)
    {
        $master = new Master_model();
        $kategori = new Kategori_master_model();
        $satuan = new Satuan_master_model();
        $vendor = new Vendor_model();

        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $reader->setReadDataOnly(true);

        $spreadsheet = $reader->load($filepath);
        $sheet = $spreadsheet->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        $startImport = FALSE;
        $doInsert = FALSE;
        $startColumnIndex = 0;
        $counter = 0;
        for ($row = 1; $row <= $highestRow; $row++) {                  //  Read a row of data into an array                 
            $cellData = $sheet->rangeToArray(
                'A' . $row . ':' . $highestColumn . $row,
                NULL,
                TRUE,
                FALSE
            );

            // Sesuaikan key array dengan nama kolom di database
            if ($cellData == NULL) continue;
            if ((!isset($cellData[0][0])) && (!isset($cellData[0][1])) && ($cellData[0][0] == NULL) && ($cellData[0][1] == NULL)) continue;
            
            $doInsert = FALSE;
            if ($startImport == TRUE) {
                $insertData = [];
                
                if (isset($cellData[0][$startColumnIndex])) {
                    if ($master->get_by_id($cellData[0][$startColumnIndex])) {
                        $doInsert = FALSE;
                        continue;
                    }
                    $insertData["id"] = $cellData[0][$startColumnIndex];
                }else {
                    $insertData["id"] = generateId("ASST").$counter;
                }
                if (isset($cellData[0][$startColumnIndex + 1])){
                    if($master->get_row_by("barcode", $cellData[0][$startColumnIndex + 1])){
                        $insertData["barcode"] = NULL;
                        $doInsert = TRUE;
                    }else{
                        $insertData["barcode"] = $cellData[0][$startColumnIndex + 1];
                        $doInsert = TRUE;
                    }
                };
                if (isset($cellData[0][$startColumnIndex + 2])){
                    $insertData["nama"] = $cellData[0][$startColumnIndex + 2];
                    $doInsert = TRUE;
                }else {
                    $doInsert = FALSE;
                }
                if (isset($cellData[0][$startColumnIndex + 3])){
                    $kt = $kategori->get_row_by("nama_kategori", $cellData[0][$startColumnIndex + 3]);
                    if(isset($kt->id) && $kt->id != NULL) {
                        $insertData["kategori"] = $kt->id;
                        $doInsert = TRUE;
                    }else{
                        $newId = $kategori->select("MAX(id) AS id")->first()->id;
                        $kategori->insert(["nama_kategori"=> $cellData[0][$startColumnIndex + 3]]);
                        $insertData["kategori"] = $newId;
                        $doInsert = TRUE;
                    }
                } else {
                    $doInsert = FALSE;
                }
                if (isset($cellData[0][$startColumnIndex + 4])) {
                    $st = $satuan->get_row_by("nama_satuan", $cellData[0][$startColumnIndex + 4]);
                    if (isset($st->id) && $st->id != NULL) {
                        $insertData["satuan"] = $st->id;
                        $doInsert = TRUE;
                    } else {
                        $newId = $satuan->select("MAX(id) AS id")->first()->id;
                        $satuan->insert(["nama_satuan" => $cellData[0][$startColumnIndex + 4]]);
                        $insertData["satuan"] = $newId;
                        $doInsert = TRUE;
                    }
                } else {
                    $doInsert = FALSE;
                }
                if (isset($cellData[0][$startColumnIndex + 5])){
                    $insertData["stok"] = $cellData[0][$startColumnIndex + 5];
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 6])){
                    $insertData["harga"] = $cellData[0][$startColumnIndex + 6];
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 7])){
                    $insertData["berat"] = $cellData[0][$startColumnIndex + 7];
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 8])){
                    $insertData["kadaluarsa"] = strtotime(formatDate($cellData[0][$startColumnIndex + 8], TRUE));
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 9])){
                    $insertData["gedung"] = $cellData[0][$startColumnIndex + 9];
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 10])){
                    $insertData["ruangan"] = $cellData[0][$startColumnIndex + 10];
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 11])){
                    $insertData["posisi"] = $cellData[0][$startColumnIndex + 11];
                    $doInsert = TRUE;
                }
                if (isset($cellData[0][$startColumnIndex + 12])) {
                    $vd = $vendor->get_row_by("nama_vendor", $cellData[0][$startColumnIndex + 12]);
                    if (isset($vd->id) && $vd->id != NULL) {
                        $insertData["id_vendor"] = $vd->id;
                        $doInsert = TRUE;
                    }
                } else {
                    $doInsert = FALSE;
                };
                if($doInsert){
                    $master->insert($insertData);
                    $counter++;
                }
            } else {
                if (
                    strtolower($cellData[0][0]) == "no" &&
                    strtolower($cellData[0][1]) == "kode barang" &&
                    strtolower($cellData[0][2]) == "barcode" &&
                    (strtolower($cellData[0][3]) == "nama" || strtolower($cellData[0][3]) == "nama barang" || strtolower($cellData[0][3]) == "nama item") &&
                    strtolower($cellData[0][4]) == "kategori" &&
                    strtolower($cellData[0][5]) == "satuan" &&
                    strtolower($cellData[0][6]) == "stok" &&
                    strtolower($cellData[0][7]) == "harga" &&
                    (strtolower($cellData[0][8]) == "berat" || strtolower($cellData[0][8]) == "berat (g)") &&
                    strtolower($cellData[0][9]) == "kadaluarsa" &&
                    strtolower($cellData[0][10]) == "gedung" &&
                    strtolower($cellData[0][11]) == "ruangan" &&
                    strtolower($cellData[0][12]) == "posisi" &&
                    (strtolower($cellData[0][13]) == "id_vendor" || strtolower($cellData[0][13]) == "vendor" || strtolower($cellData[0][13]) == "id vendor")
                ) {
                    $startImport = TRUE;
                    $startColumnIndex = 1;
                } elseif
                (
                    strtolower($cellData[0][0]) == "kode barang" &&
                    strtolower($cellData[0][1]) == "barcode" &&
                    (strtolower($cellData[0][2]) == "nama" || strtolower($cellData[0][3]) == "nama barang" || strtolower($cellData[0][3]) == "nama item") &&
                    strtolower($cellData[0][3]) == "kategori" &&
                    strtolower($cellData[0][4]) == "satuan" &&
                    strtolower($cellData[0][5]) == "stok" &&
                    strtolower($cellData[0][6]) == "harga" &&
                    (strtolower($cellData[0][7]) == "berat" || strtolower($cellData[0][7]) == "berat (g)") &&
                    strtolower($cellData[0][8]) == "kadaluarsa" &&
                    strtolower($cellData[0][9]) == "gedung" &&
                    strtolower($cellData[0][10]) == "ruangan" &&
                    strtolower($cellData[0][11]) == "posisi" &&
                    (strtolower($cellData[0][12]) == "id_vendor" || strtolower($cellData[0][12]) == "vendor" || strtolower($cellData[0][12]) == "id vendor")
                ) {
                    $startImport = TRUE;
                    $startColumnIndex = 0;
                }
            };
        };

        return $counter;
    }
}