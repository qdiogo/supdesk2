<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>

<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<!-- AdminLTE -->
<script src="<?php echo base_url('assets/js/adminlte.min.js') ?> "></script>
<!-- Select -->
<script src="<?php echo base_url('assets/js/select2.full.min.js') ?> "></script>
<!-- Input Mask -->
<script src="<?php echo base_url('assets/js/jquery.inputmask.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.inputmask.date.extensions.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.inputmask.extensions.js') ?>"></script>
<!-- Data tables -->
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.bootstrap.min.js') ?>"></script>
<!-- iCheck -->
<script src="<?php echo base_url('assets/plugins/iCheck/icheck.min.js') ?>"></script>
<!-- jquery-confirm-master -->
<script src="<?php echo base_url('assets/plugins/jquery-confirm-master/dist/jquery-confirm.min.js') ?>"></script>
<!--Custon-->
<script src="<?php echo base_url('assets/js/custon.js') ?>"></script>




<script type="text/javascript">
// Vem do custon.js
    //entrar(1,2,3);
// Multiselect    
    $('#select').select2({
      theme: "classic" 
    });
    $('#select2').select2({
      theme: "classic" 
    });
// Mascara    
    $(document).ready(function(){
    $("#cpf").inputmask("999.999.999-99");
    });
// Data tables
    $(function () {
    $('#tabela').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true,
      'select'      : true,
      'scrollX'     : true,
      'language'    : { "url": "<?php echo base_url('assets/plugins/data_tables/Portuguese-Brasil.json') ?>" }
    });
      $('#tabela').removeClass( 'display' )
      .addClass('table table-hover table-bordered');
  });

  $(function () {
    $('#tabela_info').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : true,
      'ordering'    : true,
      'info'        : false,
      'autoWidth'   : true,
      'select'      : true,
      'scrollX'     : true,
      'language'    : { "url": "<?php echo base_url('assets/plugins/data_tables/Portuguese-Brasil.json') ?>" }
    });
      $('#tabela_info').removeClass( 'display' )
      .addClass('table table-hover table-bordered');
  });

  //iCheck for checkbox and radio inputs
    $(document).ready(function(){
  $('input').iCheck({
    checkboxClass: 'icheckbox_flat-red',
    radioClass: 'iradio_flat-red'
    });
  });


 </script>

 </body>
</html>

   

