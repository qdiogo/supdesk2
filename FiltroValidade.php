<?php include "sessaotecnico87588834.php"; ?>
<!DOCTYPE html>
<html lang="´pt"> 
<head>        
	<?php include "css.php"?>  
</head> 
<body id="page-top"> 

<div id="wrapper">
	<?php include "menu.php"?> 
	<?php include "conexao.php"?> 
<div id="content-wrapper" class="d-flex flex-column">  
	  <div id="content">    
		<?php include "menuh.php" ?>  
		<div class="col-xl-12 col-md-12 mb-12">
		  <div class="card-header py-3 sistema2"> 
			<h6 class="m-0 font-weight-bold">Relatório de Tarefas</h6> 
		  </div>
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
				  <div class="row no-gutters align-items-center">
					<form method="post" action="rel_validade.php">
						<div class="row">
							<div class="col-md-6">
								<label class="basic-url">De Data</label>
								<input type="date" name="data1" id="data1" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="basic-url">Até Data</label>
								<input type="date" name="data2" id="data2" class="form-control" required>
							</div>
						</div>
						<br>
						<div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-success" type="submit">Emitir Relatório</button></div>
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
