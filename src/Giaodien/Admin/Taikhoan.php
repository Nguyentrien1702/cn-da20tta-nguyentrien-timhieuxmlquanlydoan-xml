<?php
  include("header-admin.php")
?>
<style>
    /* Định dạng màu cho bảng */
    #accountTable {
        background-color: #f0f0f0;
    }

    /* Định dạng cho các dòng tiêu đề */
    .table-header {
        background-color: #333;
        color: #fff;
        font-weight: bold;
    }

    /* Định dạng màu chữ cho nội dung */
    #accountTable td {
        color: #555;
    }
    /* Định dạng màu cho hàng chẵn */
    #accountTable tr:nth-child(even) {
        background-color: #f8f8f8;
    }

    /* Định dạng màu cho hàng lẻ */
    #accountTable tr:nth-child(odd) {
        background-color: #f0f0f0;
    }
</style>
<div class="w3-content">
<h1>Danh sách tài khoản</h1>

<table id="accountTable" class="w3-table w3-bordered w3-striped display" style="width: 70%; margin-top: 10px;">
    <thead>
        <tr>
            <th class="table-header">Tên tài khoản</th>
            <th class="table-header">Mật khẩu</th>
            <th class="table-header">Loại tài khoản</th>
            <th class="table-header">Thao tác</th>
        </tr>
    </thead>
    <tbody>
        <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
    </tbody>
</table>

<div id="pagination">
    <button id="previousPage">Trang trước</button>
    <button id="nextPage">Trang tiếp theo</button>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.js"></script>
<script src="js/frontend.js"></script>
</div>
<?php
  include("footer-admin.php")
?>
