<?php
$xmlFilePath = '../../QuanlyXML/Dangky.xml';

function issinhvienExists($xmlFilePath, $mssv, $namhoc) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->dangky as $dangky) {
        if ((string)$dangky->mssv === $mssv && (string)$dangky->namhoc === $namhoc) {
            return true;
        }
    }
    return false;
}

function isMadetaiExists($xmlFilePath, $madetai) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->dangky as $dangky) {
        if ((string)$dangky->madetai === $madetai) {
            return true;
        }
    }
    return false;
}

function addDangky($xmlFilePath, $madetai, $mssv, $msgv_hd, $namhoc) {
    $xml = simplexml_load_file($xmlFilePath);
    $ngaydangky = new DateTime();
    $ngayhienTai = $ngaydangky->format('Y-m-d');
    $newDangky = $xml->addChild('dangky');
    $newDangky->addChild('madetai', $madetai);
    $newDangky->addChild('mssv', $mssv);
    $newDangky->addChild('msgv_hd', $msgv_hd);
    $newDangky->addChild('namhoc', $namhoc);
    $newDangky->addChild('ngaydangky', $ngayhienTai);

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($xmlFilePath);
}

function updateGv_hd($xmlFilePath, $madetai, $msgv_hd) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->dangky as $dangky) {
        if ((string)$dangky->madetai === $madetai) {
            $dangky->msgv_hd = $msgv_hd;

            $xml->asXML($xmlFilePath);
            break;
        }
    }
}
function deletedangky($xmlFilePath, $madetai) {
    $xml = simplexml_load_file($xmlFilePath);
    $dangky = $xml->xpath("//dangky[madetai='$madetai']");

    unset($dangky[0][0]);

    $xml->asXML($xmlFilePath);
}
function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}
?>