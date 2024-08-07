<!DOCTYPE html>
<html lang="en"> 
<head>        
<?php include "css.php"?>  

</head> 
<body id="page-top"> 
<?php 
	$ACESSO=""; 
	$ACESSO="Relatório de Clientes";
	include "conexao.php";
	include "controleacesso.php"; 
?> 
<div id="wrapper">
	<?php include "menu.php"?> 
	<div id="content-wrapper" class="d-flex flex-column">  
	  <div id="content">    
		<?php include "menuh.php" ?>  
		 <div class="col-xl-12 col-md-12 mb-12">
		  <div class="card-header py-3 sistema2"> 
			<h6 class="m-0 font-weight-bold"><?php echo $ACESSO?></h6> 
		  </div>
		  <div class="card border-left-success shadow h-100 py-2">
			<div class="card-body">
			  <div class="row no-gutters align-items-center">
				<form method="post" action="listagem_pacientes.php">
					<div class="row">
						<div class="col-md-6">
							<label class="basic-url">De Data</label>
							<input type="date" name="data1" value="<?php echo formatardata(date('Y/m/d'),2)?>" id="data1" class="form-control">
						</div>
						<div class="col-md-6">
							<label class="basic-url">Até Data</label>
							<input type="date" name="data2" id="data2" value="<?php echo formatardata(date('Y/m/d'),2)?>" class="form-control">
						</div>
					</div>
					<br>
					<div class="col-md-2" style="margin-left: -15px;"><button class="btn btn-success" type="submit">Emitir Relatório</button></div>
				</form>
			  </div>
			</div>
		  </div>
		</div>
	  </div>  
	</div>  
</div>
	<?php include "rodape.php" ?>
</body> 
</html> 
