</div>

  <footer class="w3-container w3-padding-16 w3-center w3-opacity w3-gray w3-xlarge"> 
      <p class="w3-medium">Copyright &copy; Nguyễn Triến</p>
      <p class="w3-medium">Đồ án chuyên ngành</p>
  </footer>
<!-- End page content -->
</div>

<script>
    // Script to open and close sidebar
    function w3_open() {
        document.getElementById("mySidebar").style.display = "block";
        document.getElementById("myOverlay").style.display = "block";
    }
     
    function w3_close() {
        document.getElementById("mySidebar").style.display = "none";
        document.getElementById("myOverlay").style.display = "none";
    }
    function toggleSubMenu() {
        var subMenu = document.getElementById("subMenu");
        subMenu.style.display = (subMenu.style.display === "none") ? "block" : "none";
    }
    function toggleSubMenu2() {
        var subMenu = document.getElementById("subMenu2");
        subMenu.style.display = (subMenu.style.display === "none") ? "block" : "none";
    }
</script>
</body>
</html>