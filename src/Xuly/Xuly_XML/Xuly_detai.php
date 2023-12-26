<?php
$xmlFilePath = '../../QuanlyXML/Detai.xml';

function isMadetaiExists($xmlFilePath, $madetai) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->detai as $detai) {
        if ((string)$detai['madetai'] == $madetai) {
            return true;
        }
    }
    return false;
}

function addDetai($xmlFilePath, $madetai, $tendetai, $mota, $maloaidoan, $maloaidetai, $msgv, $manganh, $namhoc) {
    $xml = simplexml_load_file($xmlFilePath);
    $trangthaixetduyet = 0;
    $newDetai = $xml->addChild('detai');
    $newDetai->addAttribute('madetai', $madetai);
    $newDetai->addChild('tendetai', $tendetai);
    $newDetai->addChild('mota', $mota);
    $newDetai->addChild('trangthaixetduyet', $trangthaixetduyet);
    $newDetai->addChild('maloaidoan', $maloaidoan);
    $newDetai->addChild('maloaidetai', $maloaidetai);
    $newDetai->addChild('msgv', $msgv);
    $newDetai->addChild('manganh', $manganh);
    $newDetai->addChild('namhoc', $namhoc);
    $newDetai->addChild('ghichu', "");

    $dom = new DOMDocument('1.0');
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;
    $dom->loadXML($xml->asXML());
    $dom->save($xmlFilePath);
}

function updateDetai($xmlFilePath, $madetai, $tendetai, $mota, $maloaidoan, $maloaidetai, $msgv, $manganh, $namhoc) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->detai as $detai) {
        if ((string)$detai['madetai'] === $madetai) {
            $detai->tendetai = $tendetai;
            $detai->mota = $mota;
            $detai->maloaidoan = $maloaidoan;
            $detai->maloaidetai = $maloaidetai;
            $detai->msgv = $msgv;
            $detai->manganh = $manganh;
            $detai->namhoc = $namhoc;

            $xml->asXML($xmlFilePath);
            break;
        }
    }
}
function updateDetaimota($xmlFilePath, $madetai, $tendetai, $mota) {
    $xml = simplexml_load_file($xmlFilePath);
    foreach ($xml->detai as $detai) {
        if ((string)$detai['madetai'] === $madetai) {
            $detai->tendetai = $tendetai;
            $detai->mota = $mota;
            
            $xml->asXML($xmlFilePath);
            break;
        }
    }
}

function updateDetaiTrangThai($xmlFilePath, $madetai, $newTrangThai) {
    $xml = simplexml_load_file($xmlFilePath);

    foreach ($xml->detai as $detai) {
        if ((string)$detai['madetai'] === $madetai) {
            $detai->trangthaixetduyet = $newTrangThai;

            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save($xmlFilePath);

            return true; // Cập nhật thành công
        }
    }

    return false; // Không tìm thấy đề tài với mã đề tài cần cập nhật
}
function updateDetaighichu($xmlFilePath, $madetai, $newTrangThai, $ghichu) {
    $xml = simplexml_load_file($xmlFilePath);

    foreach ($xml->detai as $detai) {
        if ((string)$detai['madetai'] === $madetai) {
            $detai->trangthaixetduyet = $newTrangThai;
            $detai->ghichu = $ghichu;

            $dom = new DOMDocument('1.0');
            $dom->preserveWhiteSpace = false;
            $dom->formatOutput = true;
            $dom->loadXML($xml->asXML());
            $dom->save($xmlFilePath);

            return true; // Cập nhật thành công
        }
    }

    return false; // Không tìm thấy đề tài với mã đề tài cần cập nhật
}
function myAlert($msg, $url){
    echo '<script language="javascript">alert("'.$msg.'");</script>';
    echo "<script>document.location = '$url'</script>";
}
function deleteDetai($xmlFilePath, $madetai) {
    $xml = simplexml_load_file($xmlFilePath);
    $detai = $xml->xpath("//detai[@madetai='$madetai']");

    unset($detai[0][0]);

    $xml->asXML($xmlFilePath);
}

?>