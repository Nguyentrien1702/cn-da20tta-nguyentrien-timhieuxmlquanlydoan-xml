<?php

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

function addDataFromExcelToXml($excelFile) {
    $xmlFile = '../../QuanlyXML/Nganh.xml';

    // Load XML file
    $xml = simplexml_load_file($xmlFile);

    // Đọc dữ liệu từ tệp Excel bắt đầu từ dòng A3
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
    $worksheet = $spreadsheet->getActiveSheet();
    
    // Lấy số dòng cuối cùng có dữ liệu
    $lastRow = $worksheet->getHighestRow();

    // Nếu có ít nhất một dòng dữ liệu
    if ($lastRow >= 3) {
        // Đọc dữ liệu từ dòng A3 đến dòng cuối cùng
        $excelData = $worksheet->rangeToArray('A3:B' . $lastRow, null, true, true, true);

        // Lấy mã ngành hiện có từ XML
        $existingCodes = [];
        foreach ($xml->nganh as $nganh) {
            $existingCodes[] = (string) $nganh['manganh'];
        }

        // Mảng để lưu trữ mã ngành đã tồn tại
        $existingNganhs = [];

        // Lặp qua dữ liệu Excel
        foreach ($excelData as $row) {
            $manganh = isset($row['A']) ? $row['A'] : '';
            $tennganh = isset($row['B']) ? $row['B'] : '';

            // Kiểm tra mã ngành hợp lệ
            if (!empty($manganh) && !in_array($manganh, $existingCodes)) {
                // Tạo phần tử 'nganh' mới
                $newNganh = $xml->addChild('nganh');
                $newNganh->addAttribute('manganh', $manganh);
                $newNganh->addChild('tennganh', $tennganh);

                // Thêm phần tử 'nganh' vào gốc
                $dom = dom_import_simplexml($xml)->ownerDocument;
                $dom->formatOutput = true;
                $dom->save($xmlFile);

                // Thêm mã ngành vào danh sách đã tồn tại
                $existingCodes[] = $manganh;
            } else {
                // Thêm mã ngành vào danh sách đã tồn tại để xuất ra Excel
                $existingNganhs[] = ['manganh' => $manganh, 'tennganh' => $tennganh];
            }
        }

        // Lưu thay đổi vào tệp XML
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        $dom->save($xmlFile);

        // Xuất danh sách mã ngành đã tồn tại ra Excel và tải về
        if (!empty($existingNganhs)) {
            // Tạo tiêu đề chính
            $mainHeader = ['Danh sách ngành đã tồn tại'];

            // Tạo tiêu đề danh sách đã tồn tại
            $existingNganhs = array_merge([$mainHeader], [['Mã Ngành', 'Tên Ngành']], $existingNganhs);

            $spreadsheet = new Spreadsheet();
            $spreadsheet->getActiveSheet()->fromArray($existingNganhs, NULL, 'A1');

            // Định dạng khoảng cách cách cột với nhau
            $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

            // AutoFitColumns cho cả cột A và B
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            // Tạo khung viền
            $spreadsheet->getActiveSheet()->getStyle('A1:B' . ($lastRow +0))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $outputFilePath = 'existing_data_' . date('YmdHis') . '.xlsx';

            ob_start();
            // Tải về tệp Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='.$outputFilePath);
            header('Cache-Control: max-age=0');
            
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');
            ob_end_flush();
            // Đặt biến để xác định đã xuất Excel
            $excelExported = true;
            
        }
    } else {
        echo "Không có dữ liệu trong tệp Excel.";
    }
}

if(isset($_POST["nhap_excel"])){
    if (isset($_FILES['excelFile'])) {
        $file = $_FILES['excelFile'];

        // Kiểm tra xem có lỗi khi tải lên không
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Kiểm tra định dạng tệp có phải là Excel không
            if ($fileType === 'xlsx' || $fileType === 'xls') {
                addDataFromExcelToXml($file['tmp_name']);
                
                if ($excelExported) {
                    // Chuyển hướng sau khi xuất Excel
                    header("Location: ../../Giaodien/Admin/nganh.php");
                    exit;
                }
            } else {
                echo "Định dạng tệp không hợp lệ. Vui lòng chọn tệp Excel.";
            }
        } else {
            echo "Có lỗi khi tải lên tệp.";
        }
    }
}
?>
