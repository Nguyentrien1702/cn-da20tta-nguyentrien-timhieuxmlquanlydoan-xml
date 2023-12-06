<?php

require '../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

function addDataFromExcelToXml($excelFile) {
    $xmlFile = '../../QuanlyXML/Sinhvien.xml';

    // Load XML file
    $xml = simplexml_load_file($xmlFile);

    // Đọc dữ liệu từ tệp Excel
    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile);
    $worksheet = $spreadsheet->getActiveSheet();
    
    // Lấy số dòng cuối cùng có dữ liệu
    $lastRow = $worksheet->getHighestRow();

    // Nếu có ít nhất một dòng dữ liệu
    if ($lastRow >= 3) {
        // Đọc dữ liệu từ dòng A3 đến dòng cuối cùng
        $excelData = $worksheet->rangeToArray('A3:F' . $lastRow, null, true, true, true);

        // Lấy mã ngành hiện có từ XML
        $existingCodes = [];
        foreach ($xml->sinhvien as $sinhvien) {
            $existingCodes[] = (string) $sinhvien['mssv'];
        }

        // Mảng để lưu trữ mã ngành đã tồn tại
        $existingsinhvien = [];

        // Lặp qua dữ liệu Excel
        foreach ($excelData as $row) {
            $mssv = isset($row['A']) ? $row['A'] : '';
            $tensinhvien = isset($row['B']) ? $row['B'] : '';
            $gioitinh = isset($row['C']) ? $row['C'] : '';
            $sodienthoai = isset($row['D']) ? $row['D'] : '';
            $email = isset($row['E']) ? $row['E'] : '';
            $malop = isset($row['F']) ? $row['F'] : '';

            // Kiểm tra mã ngành hợp lệ
            if (!empty($mssv) && !in_array($mssv, $existingCodes)) {
                // Tạo phần tử 'nganh' mới
                $newsinhvien = $xml->addChild('sinhvien');
                $newsinhvien->addAttribute('mssv', $mssv);
                $newsinhvien->addChild('tensinhvien', $tensinhvien);
                $newsinhvien->addChild('gioitinh', $gioitinh);
                $newsinhvien->addChild('sodienthoai', $sodienthoai);
                $newsinhvien->addChild('email', $email);
                $newsinhvien->addChild('malop', $malop);

                // Thêm phần tử 'nganh' vào gốc
                $dom = dom_import_simplexml($xml)->ownerDocument;
                $dom->formatOutput = true;
                $dom->save($xmlFile);

                // Thêm mã ngành vào danh sách đã tồn tại
                $existingCodes[] = $mssv;
            } else {
                // Thêm mã ngành vào danh sách đã tồn tại để xuất ra Excel
                $existingsinhvien[] = ['mssv' => $mssv, 'tensinhvien' => $tensinhvien, 'gioitinh' => $gioitinh, 'sodienthoai' => $sodienthoai, 'email' => $email, 'malop' => $malop,];
            }
        }

        // Lưu thay đổi vào tệp XML
        $dom = new DOMDocument('1.0');
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        $dom->save($xmlFile);

        // Xuất danh sách mã ngành đã tồn tại ra Excel và tải về
        if (!empty($existingsinhvien)) {
            // Tạo tiêu đề chính
            $mainHeader = ['Danh sách mã giảng viên đã tồn tại'];

            // Tạo tiêu đề danh sách đã tồn tại
            $existingsinhvien = array_merge([$mainHeader], [['Mã Giảng Viên', 'Tên Giảng Viên', 'Giới Tính', 'Số Điện Thoại', 'Email', 'Phòng']], $existingsinhvien);

            $spreadsheet = new Spreadsheet();
            $spreadsheet->getActiveSheet()->fromArray($existingsinhvien, NULL, 'A1');

            // Định dạng khoảng cách cách cột với nhau
            $spreadsheet->getActiveSheet()->mergeCells('A1:F1');
            $spreadsheet->getActiveSheet()->getStyle('A1:B1')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A2:F2')->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setWrapText(true);
            $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getAlignment()->setVertical(Alignment::VERTICAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A1:F1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('DDDDDD');

            // AutoFitColumns cho cả cột A và B
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            // Tạo khung viền
            $spreadsheet->getActiveSheet()->getStyle('A1:F' . ($lastRow +0))->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
            $writer = new Xlsx($spreadsheet);
            $outputFilePath = 'existing_sinhvien_' . date('YmdHis') . '.xlsx';

            // Tải về tệp Excel
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename='.$outputFilePath);
            header('Cache-Control: max-age=0');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $writer->save('php://output');

            
        }
    } else {
        echo '<script type="text/javascript">';
        echo 'console.log("Debug message");';
        echo 'alert("Không có dữ liệu trong tệp Excel.");';
        echo 'window.location.href  = "../../Giaodien/Admin/sinhvien.php";';
        echo '</script>';
    }
}

if(isset($_POST["nhap_excel"])){
    if (isset($_FILES['excelFile'])) {
        $file = $_FILES['excelFile'];

        // Kiểm tra xem có lỗi khi tải lên không
        if ($file['error'] === UPLOAD_ERR_OK) {
            $fileType = pathinfo($file['name'], PATHINFO_EXTENSION);

            // Kiểm tra định dạng tệp có phải là Excel không
            if ($fileType === 'xlsx' || $fileType === 'xls' || $fileType === 'csv') {
                addDataFromExcelToXml($file['tmp_name']);
                echo '<script type="text/javascript">';
                echo 'console.log("Debug message");';
                echo 'alert("Thêm thành công");';
                echo 'window.location.href  = "../../Giaodien/Admin/sinhvien.php";';
                echo '</script>';
                exit;
            } else {
                echo '<script type="text/javascript">';
                echo 'console.log("Debug message");';
                echo 'alert("Định dạng tệp không hợp lệ. Vui lòng chọn tệp Excel.");';
                echo 'window.location.href  = "../../Giaodien/Admin/sinhvien.php";';
                echo '</script>';
            }
        } else {
            echo '<script type="text/javascript">';
            echo 'console.log("Debug message");';
            echo 'alert("Có lỗi khi tải lên tệp.");';
            echo 'window.location.href  = "../../Giaodien/Admin/sinhvien.php";';
            echo '</script>';
        }
    }
}
?>
