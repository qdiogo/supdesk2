<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $titulo ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css') ?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css') ?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/AdminLTE.min.css') ?>">
  <!-- iCheck -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/blue.css') ?>">
  <!-- jquery-confirm-master -->
  <link rel="stylesheet" href="<?php echo base_url('assets/plugins/jquery-confirm-master/dist/jquery-confirm.min.css') ?>">
    <!-- custon -->
    <link rel="stylesheet" href="<?php echo base_url('assets/css/custon.css') ?>">
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNINC: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

</head>

<body class="hold-transition login-page fadeIn">
<div class="login-box">
  <div class="login-logo">
      <b>DR Oncall</b><br>
  </div>
  <!-- /.login-logo -->
<!-- Conteudo-->

        <!-- login-box-body -->
  <div class="login-box-body">
    <p class="login-box-msg">Faça Login para Iniciar uma nova sessão</p>

    <?php if (isset($_SESSION['msg'])) {
    echo $_SESSION['msg'];
} ?>

<?php echo form_open('login') ?>

<div class="form-group has-feedback <?php if (form_error('email')) {echo " has-error ";};?>">
    <input type="email" class="form-control" placeholder="Email" name="email" value=<?php echo set_value( 'email') ?>>
    <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
    <?php echo form_error('email'); ?>
</div>
<div class="form-group has-feedback <?php if (form_error('senha')) {echo " has-error ";};?>">
    <input type="password" class="form-control" placeholder="Password" name="senha">
    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
    <?php echo form_error('senha'); ?>
</div>
<div class="row">
    <div class="col-xs-12">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Entrar</button>
    </div>
    <!-- /.col -->
</div>
<?php echo form_close() ?>
<br>
<p>Não tem conta? <a href="<?php echo base_url('usuario') ?>">Crie agora!</a></p>
</div>
<!-- /.login-box-body -->
</div>

<!-- /.login-box -->

<!-- footer -->
<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/js/jquery.min.js') ?>"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
<!-- jquery-confirm-master -->
<script src="<?php echo base_url('assets/plugins/jquery-confirm-master/dist/jquery-confirm.min.js') ?>"></script>
<!-- Input Mask -->
<script src="<?php echo base_url('assets/js/jquery.inputmask.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.inputmask.date.extensions.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.inputmask.extensions.js') ?>"></script>
<!--Custon-->
<script src="<?php echo base_url('assets/js/custon.js') ?>"></script>
</body>
</html>

<script>
    // Vem do custon.js
    confirma(<?= isset($status) ?>);
    // Mascara
    $(document).ready(function () {
        $("#cpf").inputmask("999.999.999-99");
    });
</script>