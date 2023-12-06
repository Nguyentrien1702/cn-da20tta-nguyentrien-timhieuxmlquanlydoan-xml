<?php
  include("header-sinhvien.php")
?>
    <div class="w3-container">
    <h2>Danh sách đề tài</h2>

    <input type="text" id="searchInput" class="w3-input w3-border" placeholder="Tìm kiếm...">

    <div class="w3-responsive">
        <table class="w3-table w3-striped w3-bordered w3-border">
            <!-- Table header -->
            <tr class="w3-light-grey">
                <th>Tên đề tài</th>
                <th>Mô tả</th>
                <th>Mã loại đồ án</th>
                <th>Mã học kỳ - niên khóa</th>
                <th>MSGV</th>
                <th>Mã ngành</th>
                <th>Ngày ra đề tài</th>
            </tr>

            <?php
            $file_path = '../../QuanlyXML/Detai.xml';
            $limit_rows = 20;

            // Load XML file
            $xml = simplexml_load_file($file_path);

            // Lấy danh sách đề tài từ XML
            $danh_sach_detai = $xml->xpath('//detai');

            // Tìm kiếm nếu có từ khóa
            $search_keyword = isset($_GET['search']) ? strtolower($_GET['search']) : '';
            if ($search_keyword) {
                $filtered_detai = array_filter($danh_sach_detai, function ($detai) use ($search_keyword) {
                    return stripos((string)$detai->tendetai, $search_keyword) !== false;
                });
            } else {
                $filtered_detai = $danh_sach_detai;
            }

            // Giới hạn số dòng hiển thị
            $filtered_detai = array_slice($filtered_detai, 0, $limit_rows);

            // Hiển thị bảng HTML
            foreach ($filtered_detai as $detai) :
                ?>
                <tr>
                    <td><?= htmlentities($detai->tendetai) ?></td>
                    <td><?= htmlentities($detai->mota) ?></td>
                    <td><?= htmlentities($detai->maloaidoan) ?></td>
                    <td><?= htmlentities($detai->mahk_nk) ?></td>
                    <td><?= htmlentities($detai->msgv) ?></td>
                    <td><?= htmlentities($detai->manganh) ?></td>
                    <td><?= htmlentities($detai->ngayradetai) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<script>
    // Lấy ô nhập liệu văn bản và bảng
    var searchInput = document.getElementById('searchInput');
    var detaiTable = document.getElementById('detaiTable');

    // Lắng nghe sự kiện "input" trên ô nhập liệu văn bản
    searchInput.addEventListener('input', function () {
        var filter = searchInput.value.toLowerCase();
        var rows = detaiTable.getElementsByTagName('tr');

        // Duyệt qua từng hàng của bảng và ẩn hoặc hiển thị dựa trên từ khóa tìm kiếm
        for (var i = 1; i < rows.length; i++) {
            var cells = rows[i].getElementsByTagName('td');
            var shouldShow = false;

            for (var j = 0; j < cells.length; j++) {
                var cellText = cells[j].textContent.toLowerCase();

                if (cellText.indexOf(filter) > -1) {
                    shouldShow = true;
                    break;
                }
            }

            rows[i].style.display = shouldShow ? '' : 'none';
        }
    });
</script>
<?php
  include("footer-sinhvien.php")
?>