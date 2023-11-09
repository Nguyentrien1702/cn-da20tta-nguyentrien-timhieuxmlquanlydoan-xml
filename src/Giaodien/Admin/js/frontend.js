$(document).ready(function() {
    const xmlFilePath = '../../QuanlyXML/Taikhoan.xml';

    // Tạo bảng DataTable
    const table = $('#accountTable').DataTable({
        paging: false, // Vô hiệu hóa phân trang mặc định
        language: {
            info: "Hiển thị _START_ đến _END_ của _TOTAL_ mục"
        }
    });

    // Hàm để nạp dữ liệu vào bảng
    function loadData() {
        const xml = $.ajax({
            url: xmlFilePath,
            dataType: "xml",
            success: function(data) {
                table.clear().draw();
                $(data).find('Taikhoan').each(function() {
                    const username = $(this).attr('Tentaikhoan');
                    const password = $(this).find('Matkhau').text();
                    const accountType = $(this).find('Loaitaikhoan').text();
                    table.row.add([username, password, accountType, `<a href="edit.php?username=${username}">Sửa</a> | <a href="delete.php?username=${username}">Xóa</a>`]).draw(false);
                });
                // Cập nhật thông tin phân trang
                const currentPage = table.page.info().page + 1;
                const totalEntries = table.page.info().recordsDisplay;
                $('#paginationInfo').text(`Hiển thị 1 đến ${totalEntries} trong tổng số ${totalEntries} mục`);
            },
            error: function() {
                console.error("Không thể tải tài liệu XML.");
            }
        });
    }

    // Gọi hàm loadData để nạp dữ liệu ban đầu
    loadData();

    // Thêm xử lý sự kiện cho nút "Trang trước"
    $('#previousPage').click(function() {
        table.page('previous').draw('page');
    });

    // Thêm xử lý sự kiện cho nút "Trang tiếp theo"
    $('#nextPage').click(function() {
        table.page('next').draw('page');
    });
});
