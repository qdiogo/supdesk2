<?php include "sessaotecnico87588834.php"; ?>
<!DOCTYPE html>
<html lang="en"> 
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
			<h6 class="m-0 font-weight-bold">Relat�rio de Tarefas</h6> 
		  </div>
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
				  <div class="row no-gutters align-items-center">
					<form method="post" action="rel_tarefas.php">
						<div class="row">
							<div class="col-md-6">
								<label class="basic-url">De Data</label>
								<input type="date" name="data1" id="data1" class="form-control" required>
							</div>
							<div class="col-md-6">
								<label class="basic-url">At� Data</label>
								<input type="date" name="data2" id="data2" class="form-control" required>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="basic-url">Empresa</label>
								<select name="Empresa" id="Empresa" class="form-control">
									<option></option>
									<?php
									$SQL1="SELECT CODIGO, FANTASIA, RAZAOSOCIAL FROM EMPRESAS ORDER BY RAZAOSOCIAL ASC";
									$tabelaX=ibase_query($conexao,$SQL1); 
									while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
									   <option value="<?php ECHO $rowX["RAZAOSOCIAL"]?>"><?php ECHO $rowX["RAZAOSOCIAL"]?></option>  
									<?php
									}?>  
								</select>
							</div>
							<div class="col-md-6">
								<label class="basic-url">T�cnicos</label>
								<select name="Tecnico" id="Tecnico" class="form-control">
									<option></option>
									<?php
									$SQL1="SELECT CODIGO, NOME FROM TECNICOS ORDER BY NOME ASC";
									$tabelaX=ibase_query($conexao,$SQL1); 
									while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
									   <option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["NOME"]?></option>  
									<?php
									}?>  
								</select>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="basic-url">Tipo de Relat�rio</label>
								<select name="TIPO" id="TIPO" class="form-control">
									<option value="1">Sint�tico</option>
									<option value="2">Anal�tico</option>
								</select>
							</div>
						</div>
						<br>
						<div class="col-md-12" style="margin-left: -15px;"><button class="btn btn-success" type="submit">Emitir Relat�rio</button></div>
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
