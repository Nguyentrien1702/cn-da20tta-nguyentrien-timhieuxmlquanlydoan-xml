<?php
  include("header-giangvien.php");
  $user = $_SESSION["user"];
?>
<style>
  .div-content {
    width: 95%;
    margin: auto;
}
h1 {
    font-weight: bold;
    text-transform: uppercase;
    margin-bottom: 40px;
    text-align: center;
    color: blue;
}
td, th{
    text-align: center;
    vertical-align: middle !important;
}
textarea {
      resize: none; /* Ngăn chặn resize tự do của textarea */
}
#btnluudetai{
  margin: 10px 10px;
  padding: 5px;
  background-color: #1a1aff;
  color: white;
  font-size: 16px;
  width: 80px;
  height: 40px;
  border-radius: 7px;
}
#btnluudetai:hover{
  background-color: #0000e6;
}
#radetai{
  padding: 7px;
  background-color: blue;
  border-radius: 5px;
  color: white;
  text-decoration: none;
}
#radetai:hover{
  background-color: #1a1abb;

}
</style>
<!-- Model tạo đề tài -->
  <div id="taodetai" class="w3-modal">
        <div class="w3-modal-content w3-animate-zoom" style="width: 80%; border-radius: 5px;">
            <div class="w3-container" >
                <span onclick="closeModal()" class="w3-button w3-display-topright">&times;</span>
                <h2 style="text-transform: uppercase; color: blue; text-align: center; font-weight: bold;">Tạo đề tài</h2>
                <div style="display: block;"> 
                  <label for="" id="maloai" style="display: none;"></label>
                  <label for="" id="user" style="display: none;"></label>
                  <div style="display: flex;">
                  <label for="">Tên loại: &nbsp;</label>
                  <label for="" id="tenloai" style="display: block;"></label>
                  </div>
                  <div style="display: flex;">
                  <label for="">Ngành: &nbsp</label>
                  <label for="" id="tennganh" style="display: block;"></label>
                  </div>
                  <div style="display: flex;">
                  <label for="">Năm học: &nbsp</label>
                  <label for="" id="namhoc" style="display: block;"></label>
                  </div>
                  <label for="" id="result"></label>
                </div>
                <table id="data-table" class="w3-table w3-bordered w3-striped display">
                  <thead>
                    <tr>
                      <th class="table-header">STT</th>
                      <th class="table-header">Tên đề tài</th>
                      <th class="table-header">Mô tả</th>
                      <th class="table-header">Loại đề tài</th>
                      <th class="table-header"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td><textarea id="tendetai_1" class="w3-input w3-border" placeholder="Tên đề tài"></textarea></td>
                      <td><textarea id="mota_1" class="w3-input w3-border" placeholder="Mô tả"></textarea></td>
                      <td>
                        <select id="loaidetai_1" class="w3-input w3-border">
                        
                        </select>
                      </td>
                      <td>
                        <button onclick="addRow()">+</button>
                      </td>
                      
                    </tr>
                  </tbody>
                </table>
              <div style="text-align: right; margin-top: 10px;">
                <button id="btnluudetai" onclick="xulydulieu()">Lưu</button>
              </div>
              
            </div>
        </div>
    </div>

  <div class="div-content">
    <h1>Các hoạt động</h1>
    <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
        <thead>
            <tr>
                <th class="table-header">STT</th>
                <th class="table-header">Công việc</th>
                <th class="table-header">Người thực hiện</th>
                <th class="table-header">Loại đồ án</th>
                <th class="table-header">Ngành</th>
                <th class="table-header">Năm học</th>
                <th class="table-header">Ngày bắt đầu</th>
                <th class="table-header">Ngày kết thúc</th>
                <th class="table-header">Trạng thái</th>
                <th class="table-header">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <?php
                $xmlFilePath = '../../QuanlyXML/Thoigiantao_dangky.xml';
                $xml = simplexml_load_file($xmlFilePath);
                $xmlFilePath1 = '../../QuanlyXML/Loaidoan.xml';
                $xml1 = simplexml_load_file($xmlFilePath1);
                $xmlFilePath2 = '../../QuanlyXML/Nganh.xml';
                $xml2 = simplexml_load_file($xmlFilePath2);
                $i = 1;
                foreach ($xml->thoigian as $thoigian) {
                  if(($thoigian->ngayketthuc >= date("Y-m-d"))){
                    echo "<tr>";
                    echo "<td id='stt'>".$i++."</td>";
                    $matg = $thoigian["matg"];
                    if($thoigian->quyen == "giangvien"){
                      echo "<td>Ra đề tài</td>";
                      echo "<td>Giảng viên</td>";
                      $gv_sv = 0;
                    }else{
                      echo "<td>Đăng ký đề tài</td>";
                      echo "<td>Sinh viên</td>";
                      $gv_sv = 1;
                    }
                    $maloai = $thoigian->maloaidoan;
                    foreach ($xml1->loaidoan as $loaidoan) {
                      if((string)$loaidoan['maloaidoan'] == (string)$thoigian->maloaidoan){
                        echo "<td>".$loaidoan->tenloai."</td>";
                        $tenloai = $loaidoan->tenloai;
                        break;
                      }
                    }
                    $ma =explode("-", $thoigian->maloaidoan);
                    $manganh = end($ma);
                    foreach ($xml2->nganh as $nganh) {
                        if((string)$nganh['manganh'] == $manganh){
                          echo "<td>".$nganh->tennganh."</td>";
                          $tennganh = $nganh->tennganh;
                          break;
                        }
                      }
                    echo "<td>".$thoigian->namhoc."</td>";
                    $namhoc = $thoigian->namhoc;
                    echo "<td>".date('d-m-Y', strtotime($thoigian->ngaybatdau))."</td>";
                    echo "<td>".date('d-m-Y', strtotime($thoigian->ngayketthuc))."</td>";

                    if(($thoigian->ngaybatdau<= date("Y-m-d")) && ($thoigian->ngayketthuc >= date("Y-m-d"))){
                        echo "<td style='color: green'>Đang diễn ra</td>";
                    }elseif(($thoigian->ngaybatdau > date("Y-m-d"))){
                        echo "<td style='color: blue'>Sắp diễn ra</td>";
                    }else{
                        echo "<td style='color: red'>Đã đóng</td>";
                    }
                    if($gv_sv == 0){
                      echo "<td style='text-align: center;'>
                          <a id='radetai' href='#?matg=$matg' onclick='openModal(\"$maloai\", \"$user\", \"$namhoc\", \"$tenloai\", \"$tennganh\")' style='margin-right: 5px'>Ra đề tài</a>
                              </td>";
                    }else{
                      echo "<td></td>";
                    }
                    echo "</tr>";
                  }
                }
                ?>
        </tbody>
    </table>
</div>


<script>
  function openModal(maloai, user, namhoc, tenloai, tennganh) {
    document.getElementById('maloai').innerHTML =maloai;
    document.getElementById('user').innerHTML =user;
    document.getElementById('tenloai').innerHTML =tenloai;
    document.getElementById('tennganh').innerHTML =tennganh;
    document.getElementById('namhoc').innerHTML =namhoc;
    uploadButtonClicked = true;
    document.getElementById('taodetai').style.display = 'block';
  }

  function closeModal() {
      uploadButtonClicked = false;
      document.getElementById('taodetai').style.display = 'none';
  }

  document.addEventListener('input', function (e) {
    if (e.target.tagName.toLowerCase() === 'textarea') {
      autoResizeTextarea(e.target);
    }
  });

  function autoResizeTextarea(textarea) {
    textarea.style.height = 'auto';
    textarea.style.height = textarea.scrollHeight + 'px';
  }

  function loadXMLData(loaidetai_vitri) {
      var xmlhttp = new XMLHttpRequest();
      xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          parseXML(this.responseText, loaidetai_vitri);
        }
      };
      xmlhttp.open("GET", "../../QuanlyXML/Loaidetai.xml", true);
      xmlhttp.send();
    }
    function parseXML(xmlString, loaidetai_vitri) {
      var parser = new DOMParser();
      var xmlDoc = parser.parseFromString(xmlString, "text/xml");

      // Assuming the XML structure has <option> elements under a root <options> element
      var options = xmlDoc.getElementsByTagName("loaidetai");

      var selectElement = document.getElementById(loaidetai_vitri);

      for (var i = 0; i < options.length; i++) {
        var optionValue = options[i].getAttribute("maloaidetai");
        var optionText = options[i].textContent;

        var optionElement = document.createElement("option");
        optionElement.value = optionValue;
        optionElement.text = optionText;

        selectElement.appendChild(optionElement);
      }
      selectElement.setAttribute("size", 1);
    }

    // Call the function to load XML data
    loadXMLData("loaidetai_1");

  var rowIndex = 2;
  function addRow() {
    var table = document.getElementById("data-table").getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.rows.length);

    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
    var cell4 = newRow.insertCell(3);
    var cell5 = newRow.insertCell(4);

    cell1.innerHTML =  table.rows.length;
    cell2.innerHTML = '<textarea id="tendetai_'+ table.rows.length +'" class="w3-input w3-border" placeholder="Tên đề tài"></textarea>';
    cell3.innerHTML = '<textarea id="mota_'+ table.rows.length +'" class="w3-input w3-border" placeholder="Mô tả"></textarea>';
    cell4.innerHTML = '<td> <select id="loaidetai_'+ table.rows.length +'" class="w3-input w3-border"></select></td>';
    cell5.innerHTML = '<button onclick="addRow()">+</button> <button class="delete-btn" onclick="deleteRow(this)">-</button>';
    loadXMLData("loaidetai_"+ table.rows.length );
  }

  function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    row.parentNode.removeChild(row);
  }

  function xulydulieu() {
    var table = document.getElementById("data-table");
    var data = [];
    var user =document.getElementById('user').innerHTML;
    var maloai = document.getElementById('maloai').innerHTML;
    var namhoc = document.getElementById('namhoc').innerHTML;

    for (var i = 1; i < table.rows.length; i++) {
      var tendetai = document.getElementById("tendetai_" + i).value;
      var mota = document.getElementById("mota_" + i).value;
      var loaidetai = document.getElementById("loaidetai_" + i).value;
      if (tendetai.trim() !== '' ) {
        data.push({ user: user, maloai: maloai, namhoc: namhoc, tendetai: tendetai, mota: mota, loaidetai: loaidetai });
      }
    }

    // Sử dụng Fetch API để gửi dữ liệu đến một tệp PHP
    fetch('../../Xuly/Xuly_XML/Xuly_formdetai.php', {
          method: 'POST',
          headers: {
              'Content-Type': 'application/json',
          },
          body: JSON.stringify({ data: data })
      })
      window.location.reload();
  }

</script>
<?php
  include("footer-giangvien.php")
?>