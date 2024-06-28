<footer class="main-footer" style="background: linear-gradient(to right, #fff, #afeae2);">
        <div class="footer-left">
          <a href="#">DELIVERYAPP</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="<?=base_url(); ?>public/assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="<?=base_url(); ?>public/assets/bundles/apexcharts/apexcharts.min.js"></script>
  <!-- Page Specific JS File -->
  <script src="<?=base_url(); ?>public/assets/js/page/index.js"></script>
  <!-- Template JS File -->
  <script src="<?=base_url(); ?>public/assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="<?=base_url(); ?>public/assets/js/custom.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/jquery-pwstrength/jquery.pwstrength.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/jquery-selectric/jquery.selectric.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js"></script>
  
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/datatables.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/export-tables/dataTables.buttons.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/export-tables/buttons.flash.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/export-tables/jszip.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/export-tables/pdfmake.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/export-tables/vfs_fonts.js"></script>
  <script src="<?=base_url(); ?>public/assets/bundles/datatables/export-tables/buttons.print.min.js"></script>
  <script src="<?=base_url(); ?>public/assets/js/page/datatables.js"></script>
  <script>
    
    $(document).ready(function() {
    $('#add_menu_form').validate({
        rules: {
            menu_name: {
                required: true,
            },
            url_location: {
                required: true,
            }
        },
        messages: {
            menu_name: {
                required: 'Please enter the menu name.',
            },
            url_location: {
                required: 'Please enter the URL location.',
            }
        },
        errorPlacement: function(error, element) {
            if (element.attr("name") == "url_location") {
                error.appendTo("#menu_nameError");
            } else {
                error.insertAfter(element);
            }
        }
    });
});
    function confirmDelete(id) {
        if (confirm('Are you sure you want to delete this record?')) {
            document.getElementById('deleteForm' + id).submit();
        }
    }
</script>
</body>


<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>