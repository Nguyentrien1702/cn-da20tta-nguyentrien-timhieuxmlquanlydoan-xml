<?php
    include("header-giangvien.php")
?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<style>
    #div1{
        width: 95%;
        margin: auto;
    }
    h1{
        font-weight: bold;
        color: red;
        text-align: center;
    }
    .btnthem{
        margin-bottom: 10px;
        padding: 10px;
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        margin-right: 15px;
    }
    .btnthem:hover {
    background-color: blue !important;
    }

    #stt{
        width: 20px;
    }
    #trangthai{
        width: 5%;
    }
    th{
        text-align: center !important;
    }
    td, th{
    
    vertical-align: middle !important;
    }
    .mota {
    width: 20%;
    white-space: pre-line;
    margin-top: 0px;
    }
</style>
<div class="w3-content">
<!-- Form thêm đề tài -->
<div id="form" class="form-them-sua" style="display: block;">
    <h2 class="w3-container w3-red">Thêm Đề Tài Mới</h2>

    <form class="w3-container" action="../../Xuly/Xuly_XML/Xuly_formdetai.php" method="post">
        <label for="tendetai">Tên Đề Tài:</label>
        <input class="w3-input w3-border" type="text" id="tendetai" name="txttendetai" required>

        <label for="mota">Mô Tả:</label>
        <textarea class="w3-input w3-border" id="mota" name="txtmota" style="resize: none;" rows="4" required></textarea>

        <label for="maloaidoan">Mã Loại Đoàn:</label>
        <select class="w3-select w3-border" id="maloaidoan" name="txtmaloaidoan" required>
            <!-- Thêm các option từ XML hoặc cơ sở dữ liệu nếu có -->
            <option value="CSN-TT">CSN-TT</option>
            <option value="CN-TT">CN-TT</option>
            <!-- Thêm các option khác nếu cần -->
        </select>

        <button class='w3-btn w3-green' type='submit' name='sbmthem'>Thêm</button>
        <button class="w3-btn w3-red" type="submit" name="sbmhuy"
            onclick="window.location.href='../../Giaodien/Admin/detai.php'">Hủy</button>
    </form>
</div>
</div>

<div id="div1">
<h1>Danh sách đề tài</h1>

<button id="themmoi" class="w3-button w3-green btnthem" onclick="toggleForm()">Thêm mới</button>
<button id="nhapexcel" onclick="openModal()" class="w3-button w3-green btnthem">Nhập File</button>
    <div class="custom-datatable-style">
        <table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 100%; margin-top: 10px;">
            <thead>
                <tr>
                    <th class="table-header" style="text-align: center;">STT</th>
                    <th class="table-header" style="text-align: center;">Tên đề tài</th>
                    <th class="table-header">Mô tả</th>
                    <th class="table-header">Trạng thái xét duyệt</th>
                    <th class="table-header">Loại đồ án</th>
                    <th class="table-header">MSGV</th>
                    <th class="table-header">Mã ngành</th>
                    <th class="table-header">Năm học</th>
                    <th class="table-header">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $xmlFilePath = '../../QuanlyXML/Detai.xml';
                $xml = simplexml_load_file($xmlFilePath);
                $xmlFilePath1 = '../../QuanlyXML/Giangvien.xml';
                $xml1 = simplexml_load_file($xmlFilePath1);
                $xmlFilePath2 = '../../QuanlyXML/Nganh.xml';
                $xml2 = simplexml_load_file($xmlFilePath2);
                $i = 1;
                foreach ($xml->detai as $detai) {
                    echo "<tr>";
                    echo "<td id='stt'>".$i++."</td>";
                    echo "<td class='mota'>{$detai->tendetai}</td>";
                    echo "<td class='mota'>" . $detai->mota . "</td>";
                    echo "<td id='trangthai'>";
                    if($detai->trangthaixetduyet == 0){
                        echo "Chưa duyệt";
                    }else{
                        echo "Đã duyệt";
                    }
                    "</td>";
                    $manganhParts = explode('-', $detai->maloaidoan);

                    // Lấy phần mã ngành đến trước dấu "-"
                    $manganhBeforeDash = trim($manganhParts[0]);
                    $manganhAfterDash = trim($manganhParts[1]);
                    echo "<td>{$manganhBeforeDash}</td>";
                    echo "<td>";
                    foreach ($xml1->giangvien as $giangvien) {
                        if((String)$detai->msgv == (String)$giangvien['msgv']){
                            echo "{$giangvien->tengiangvien}";
                            break;
                        }
                    }
                    "</td>";
                                        
                    echo "<td>";
                    foreach ($xml2->nganh as $nganh) {
                        if((String)$manganhAfterDash == (String)$nganh['manganh']){
                            echo "{$nganh->tennganh}";
                            break;
                        }
                    }
                    "</td>";
                    echo "<td>{$detai->namhoc}</td>";
                    if((String)$_SESSION['user'] == (String)$detai->msgv){
                    echo "<td style='text-align: center;'>
                            <a id='sua' href='#'>Sửa</a>
                            <a onclick=\"return confirm('Bạn có thật sự muốn xóa đề tài này hay không?')\" id='xoa' href='#'>Xóa</a>
                          </td>";}
                          else{
                            echo "<td></td>";
                          }
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
<script>
    function toggleForm() {
        var form = document.getElementById('form');
        form.style.display = (form.style.display === 'none') ? 'block' : 'none';

        var themmoiBtn = document.getElementById('themmoi');
        themmoiBtn.style.display = (form.style.display === 'none') ? 'block' : 'none';

        $('#malop').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });

    }

    $(document).ready(function() {
        $('#accountTable').DataTable({
            paging: true,
            pageLength: 20, // Số dòng giới hạn của bảng
            searching: true, // Thanh tìm kiếm
            language: {
                info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục",
                lengthMenu: "Hiển thị _MENU_ mục",
                search: "Tìm kiếm:",
                paginate: {
                    previous: "Trang trước",
                    next: "Trang tiếp theo",
                }
            }

        });
        $('#malop').select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                return undefined;
            },
            maximumSelectionLength: 1,
        });
    });

    function openModal() {
        uploadButtonClicked = true;
        document.getElementById('uploadModal').style.display = 'block';
    }

    function closeModal() {
        uploadButtonClicked = false;
        document.getElementById('uploadModal').style.display = 'none';
    }
    </script>
</div>
<?php
    include("footer-giangvien.php")
?>