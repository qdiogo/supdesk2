<?php include "sessaotecnico87588834.php"; ?>
<!DOCTYPE html>
<html lang="pt-BR"> 
<head>        
<?php include "css.php"?>  
<style>
	.filtro-card{
		border-radius: 10px;
	}
	.filtro-header{
		background: linear-gradient(90deg,#0066cc,#004a99);
		color:#fff;
		padding: 14px 20px;
		border-radius: 10px 10px 0 0;
		display:flex;
		align-items:center;
		gap:10px;
	}
	.filtro-header h6{
		margin:0;
		font-weight:bold;
		font-size:1rem;
		color:#fff;
	}
	.filtro-header .filtro-icon{
		font-size:1.3rem;
		opacity:.9;
		display:inline-flex;
		align-items:center;
	}
	.filtro-body{
		padding: 22px 24px;
		background:#fff;
	}
	.filtro-label{
		font-size:.72rem;
		font-weight:700;
		letter-spacing:.05em;
		text-transform:uppercase;
		color:#5a6a7a;
		margin-bottom:4px;
	}
	.filtro-body .form-control{
		border-radius:6px;
		height:40px;
		font-size:.9rem;
	}
	.filtro-body .form-control:focus{
		border-color:#0066cc;
		box-shadow: 0 0 0 .2rem rgba(0,102,204,.15);
	}
	.filtro-footer{
		background:#f4f7fb;
		padding: 16px 24px;
		border-top:1px solid #dde5ee;
		border-radius: 0 0 10px 10px;
		display:flex;
		justify-content:flex-end;
		gap:10px;
	}
	.filtro-footer .btn{
		display:inline-flex;
		align-items:center;
		justify-content:center;
		gap:8px;
		height:42px;
		padding: 0 26px;
		font-weight:bold;
		font-size:.9rem;
		letter-spacing:.03em;
		border-radius:6px;
		line-height:1;
	}
	.filtro-footer .btn i{
		font-size:1rem;
		line-height:1;
		display:inline-flex;
		align-items:center;
		margin:0;
	}
	.filtro-footer .btn-emitir{
		background:#0066cc;
		border:none;
		color:#fff;
		box-shadow:0 2px 6px rgba(0,102,204,.35);
	}
	.filtro-footer .btn-emitir:hover{
		background:#004a99;
		color:#fff;
	}
	.filtro-footer .btn-limpar{
		background:#fff;
		border:1px solid #c4d3e3;
		color:#5a6a7a;
	}
	.filtro-footer .btn-limpar:hover{
		background:#eef4fb;
		color:#004a99;
	}
</style>
</head> 
<body id="page-top"> 

<div id="wrapper">
	<?php include "menu.php"?> 
	<?php include "conexao.php"?> 
<div id="content-wrapper" class="d-flex flex-column">  
	  <div id="content">    
		<?php include "menuh.php" ?>  

		<div class="container-fluid">
			<div class="col-xl-12 col-md-12 mb-4">
				<div class="card filtro-card border-0 shadow">
					<div class="filtro-header">
						<i class="fa fa-filter filtro-icon"></i>
						<h6>Relatório de Relação de Chamados</h6>
					</div>

					<form method="post" action="rel_chamados.php" id="formRelChamados">
						<div class="filtro-body">
							<div class="row">

								<div class="col-md-6 mb-3">
									<label class="filtro-label">De Data</label>
									<input type="date" name="data1" id="data1" class="form-control" required>
								</div>

								<div class="col-md-6 mb-3">
									<label class="filtro-label">Até Data</label>
									<input type="date" name="data2" id="data2" class="form-control" required>
								</div>

								<div class="col-md-6 mb-3">
									<label class="filtro-label">Tipo</label>
									<select name="TIPO" id="TIPO" class="form-control">
										<option value="">Abertos</option>
										<option value="2">Fechado</option>
										<option value="3">Em Pause</option>
									</select>
								</div>

								<div class="col-md-6 mb-3">
									<label class="filtro-label">Empresa</label>
									<select name="Empresa" id="Empresa" class="form-control">
										<option></option>
										<?php
										$SQL1="SELECT CODIGO, FANTASIA, RAZAOSOCIAL FROM EMPRESAS ORDER BY RAZAOSOCIAL ASC";
										$tabelaX=ibase_query($conexao,$SQL1); 
										while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
										   <option value="<?php ECHO $rowX["RAZAOSOCIAL"]?>"><?php ECHO $rowX["FANTASIA"]?></option>  
										<?php
										}?>  
									</select>
								</div>

								<div class="col-md-6 mb-3">
									<label class="filtro-label">Unidade</label>
									<select name="UNIDADENEGOCIO" id="UNIDADENEGOCIO" class="form-control">
										<option></option>
										<?php
										$SQL1="SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO ORDER BY RAZAOSOCIAL ASC";
										$tabelaX=ibase_query($conexao,$SQL1); 
										while ($rowX=ibase_fetch_assoc($tabelaX)){ ?>
										   <option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["RAZAOSOCIAL"]?></option>  
										<?php
										}?>  
									</select>
								</div>

								<div class="col-md-6 mb-3">
									<label class="filtro-label">Técnicos</label>
									<select name="usuario" id="usuario" class="form-control">
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

								<div class="col-md-6 mb-3">
									<label class="filtro-label">Sintético</label>
									<select name="sintetico" id="sintetico" class="form-control">
										<option value="S">Sim</option>
										<option value="N" selected>Não</option>
									</select>
								</div>

							</div>
						</div>

						<div class="filtro-footer">
							<button type="reset" class="btn btn-limpar">
								<i class="fa fa-eraser"></i> Limpar
							</button>
							<button type="submit" class="btn btn-emitir">
								<i class="fa fa-file-text-o"></i> Emitir Relatório
							</button>
						</div>
					</form>

				</div>
			</div>
		</div>

	  </div>  
	</div>  
</div>
	<?php include "rodape.php" ?>

	<script>
		document.getElementById("formRelChamados").addEventListener("submit", function(e){
			var d1 = document.getElementById("data1").value;
			var d2 = document.getElementById("data2").value;
			if (d1 && d2 && d1 > d2){
				e.preventDefault();
				alert("A data inicial não pode ser maior que a data final.");
			}
		});
	</script>
</body> 
</html>