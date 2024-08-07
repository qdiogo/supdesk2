<?php include "conexao.php" ; ?>
<!DOCTYPE html>
<html lang="en"> 
<head>        
<?php include "css.php"?>  
<script>  
function alterar(indice) 
{ 
location.href="PAINEL.php?ATITUDE=" + indice + "&QUADRO=" + <?PHP ECHO $_GET["QUADRO"]?>;
} 
function deletar(indice)   
{  
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{  
  TABELA: "PAINEL1", 
  CODIGO: indice,    
 },     
 function(data, status){
   if (status=='success'){ 
     location.reload(); 
   }
  })
 } 
} 

function deletar2(indice)   
{  
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{  
  TABELA: "PAINEL2", 
  CODIGO: indice,    
 },     
 function(data, status){
   if (status=='success'){ 
     location.reload(); 
   }
  })
 } 
} 
</script>
<STYLe>
@keyframes fa-blink {
	0% { opacity: 1; }
	50% { opacity: 0.5; }
	100% { opacity: 0; }
}
.fa-blink {
-webkit-animation: fa-blink .75s linear infinite;
-moz-animation: fa-blink .75s linear infinite;
-ms-animation: fa-blink .75s linear infinite;
-o-animation: fa-blink .75s linear infinite;
animation: fa-blink .75s linear infinite;
}
.navx{
	max-height: 800px;
	overflow-y: scroll; 
}
.xresp{
	word-wrap: break-word;
	overflow-wrap: break-word;
	word-wrap: break-word;

	-ms-word-break: break-all;
	word-break: break-all;
	word-break: break-word;

	-ms-hyphens: auto;
	-moz-hyphens: auto;
	-webkit-hyphens: auto;
	hyphens: auto;
	}
</style>
<style>

</style>
<script>
function allowDrop(ev) {
  ev.preventDefault();
 
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
    document.getElementById("p1").value=(ev.target.id);
}

function drop(ev) {
  ev.preventDefault();
  var data = ev.dataTransfer.getData("text");
  ev.target.appendChild(document.getElementById(data));
  document.getElementById("p2").value=(ev.target.id);
  var item=document.getElementById("p1").value; 
  var div= document.getElementById("p2").value;
  mudardrawer(item, div);
}


function mudardrawer(item, div)   
{  

$.post("MUDARPAINEL.PHP",
{  
  ITEM: item, 
  PAINEL: div,    
 },     
 function(data, status){
   if (status=='success'){ 
     location.reload();
   }
  })
 
} 
</script>
</head> 
<body id="page-top"> 
<input type="HIDDEN" id="p1">
<input type="HIDDEN" id="p2">

<?php 
$ACESSO=""; 
$ACESSO="PAINEL1/LEMBRETE";
include "controleacesso.php";
$SQL="SELECT CODIGO,ASSUNTO, DATA, CAST(DESCRICAO AS VARCHAR(20000)) AS DESCRICAO, (SELECT ASSUNTO FROM QUADROS WHERE CODIGO=PAINEL1.QUADRO) AS ASSUNTOQUADRO FROM PAINEL1 WHERE (1=1) AND QUADRO='".$_GET["QUADRO"]."' ";
if (ISSET($_GET["ATITUDE"])) 
{
	$ATITUDE=$_GET["ATITUDE"];
	$SQL=$SQL . " AND CODIGO=0". $_GET["ATITUDE"]; 
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
	echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{
	$SQL=$SQL . " ORDER BY CODIGO ASC ";
	$tabela=ibase_query($conexao,$SQL); 
	$openX=ibase_fetch_assoc($tabela);
} 
?> 
<div id="wrapper">
	<?php include "menu.php"?>
	<div id="content-wrapper" class="d-flex flex-column">  
	  <div id="content"> 
	  <?php include "menuh.php"?>     
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content">
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">  
				<h5 class="modal-title" id="TituloModalCentralizado" align="center">Quadros</h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"> 
				  <span aria-hidden="true">&times;</span> 
				</button>
			  </div> 
			  <div class="alert alert-success"></div> 
				<form method="post" action='PAINEL_dados.php?QUADRO=<?PHP ECHO $_GET["QUADRO"]?>'> 
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>
						 <input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
					<?php }else{ ?> 
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control">  
					<?php } ?>  
					<div class="row">   
						<div class="col-md-4">  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
							<?php }else{ ?>
								<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
					<div class="row">   
						<div class="col-md-6">  
							<label>DATA</label>  
							<?php if (!empty($_GET["ATITUDE"])){?>  
								<input type="date" name="DATA" value="<?php ECHO $row["DATA"]?>" id="DATA" maxlength="4" class="form-control">  
							<?php }else{ ?>
								<input type="date" name="DATA" value="<?php echo date("Y-m-d");?>" id="DATA" maxlength="4" class="form-control"> 
							<?php } ?>
						</div>
						<div class="col-md-6">  
							<label>ASSUNTO</label>  
							<?php if (isset($_GET["ATITUDE"])){?> 
								<input type="text" name="ASSUNTO" value="<?php ECHO $row["ASSUNTO"]?>" id="ASSUNTO" maxlength="50" class="form-control"> 
							<?php }else{ ?>
								<input type="text" name="ASSUNTO" id="ASSUNTO" maxlength="50" class="form-control">
							<?php } ?> 
						</div>  
					</div>  
					<div class="row">   
						<div class="col-md-12">  
							<label>CONTEÚDO</label>  
							<?php if (!empty($_GET["ATITUDE"])){?> 
								<textarea type="text" name="DESCRICAO" rows="10" value="<?php ECHO $row["DESCRICAO"]?>" id="DESCRICAO" maxlength="2000" class="form-control"><?php ECHO $row["DESCRICAO"]?></textarea>
							<?php }else{ ?>
								<textarea type="text" name="DESCRICAO" rows="10" id="DESCRICAO" maxlength="2000" class="form-control"></textarea>
							<?php } ?> 
						</div>  
					</div>  
				  </div> 
			  <div class="modal-footer"> 
				<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="PAINEL.php?QUADRO=<?PHP ECHO $_GET["QUADRO"]?>"'>Fechar</button>
				<button type="submit" class="btn btn-success">Salvar mudanças</button>
			  </div>  
				</form> 
			</div> 
		  </div> 
		</div>
		<div class="container-fluid"> 
			<div class="card shadow mb-4">
			<div class="card-header py-3 sistema2">
			  <h6 class="m-0 font-weight-bold"><?php echo $openX["ASSUNTOQUADRO"]?></h6> 
			</div> 
			<div class="card-body"> 
			  <div class="table-responsive">
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"> 
				  <thead>
					<tr> 
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')">Incluir Novo Painel</button></th> 
					  
					  <?php
					  
					  $tabela2=ibase_query($conexao,$SQL); 
					  while ($open=ibase_fetch_assoc($tabela2)){
						 ECHO "<TH></TH>"; 
					  }?>
					  
					</tr>
				  </thead>

				  <tbody> 
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){
			   		 $sequencia=$row["CODIGO"];		?>
						
						<td WIDTH=100 class="align-baseline">
							<table style="width: 340px" >
								<p style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: #FFF;" align="center">
									<?php echo $row["ASSUNTO"]?><br>
									<button class="button buttoninfo " type="button" data-toggle="modal" data-target="#myModal1<?php echo $row["CODIGO"]?>"><i class="fas fa-plus-square"></i></i></button>
									<button class="button buttoninfo " type="button" onclick="alterar('<?php echo $sequencia?>')"><i class="fas fa-edit"></i></button>
									<button class="button buttondelet " type="button" onclick="deletar('<?php echo $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
								</p> 
										
								<div class="navx" id="<?PHP ECHO $sequencia?>" ondrop="drop(event)" style="width: 350px;height: 300px;paddinC: 10px;border: 1px solid #aaaaaa;" ondragover="allowDrop(event)">
									
									<?php
									$SQLCx="SELECT CODIGO, ASSUNTO, DATA, DATA_USUARIO1, DATA_USUARIO2, CAST(DESCRICAO AS VARCHAR(20000)) AS DESCRICAO FROM PAINEL2 WHERE NUMERO=" . $row["CODIGO"] . " ORDER BY CODIGO DESC";
									$tabelaCx= ibase_query ($conexao, $SQLCx);
									if (!empty($tabelaCx))
									{
										while ($xtabCx = ibase_fetch_assoc($tabelaCx)){?>
										
										
										<li class="list-group-item xresp" draggable="true" ondragstart="drag(event)" id="<?PHP ECHO $xtabCx["CODIGO"]?>" width="88" height="31" style="border: 2px solid black;">
											<CENTER>
												<button type="button" class="button buttoned" data-toggle="modal" data-target="#myModalXX<?PHP ECHO $xtabCx["CODIGO"]?>"><i class="fas fa-edit"></i></button>
												<button class="button buttondelet" type="button" onclick="deletar2('<?PHP ECHO $xtabCx["CODIGO"]?>')"><i class="fas fa-trash-alt"></i></button>
												<BR>
												<?PHP ECHO $xtabCx["ASSUNTO"]?><br>
												<?php
												$datetime1 ="";
												$datetime2 ="";
												$interval ="";
												$datetime1= date("d/m/Y",strtotime($xtabCx["DATA_USUARIO1"]));
												if (!empty($xtabCx["DATA"]))
												{
													$datetime2= date("d/m/Y",strtotime($xtabCx["DATA"]));
												}else{
													$datetime2= date("d/m/Y",strtotime($xtabCx["DATA_USUARIO2"]));
												}
												
												echo "Inicio: " . $datetime1 . "<br> Prazo: " . $datetime2;
												?>
												<p>
											
											</CENTER>
											
											<?PHP ECHO $xtabCx["DESCRICAO"]?>
												<div id="myModalXX<?php echo $xtabCx["CODIGO"]?>" class="modal fade" role="dialog">
												  <div class="modal-dialog">

													<!-- Modal content-->
													<div class="modal-content">
													  <div class="modal-header alert alert-info" style="text-align:center">
														
														<h4 class="modal-title"><center><?php ECHO $xtabCx["ASSUNTO"]?></center></h4>
													  </div>
													  <div class="modal-body">
														<form method="post" action='PAINEL2_dados.php?QUADRO=<?PHP ECHO $_GET["QUADRO"]?>'> 
														  <div class="modal-body">  
															<input type="hidden" name="CODIGO" value="<?php ECHO $xtabCx["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
															<div class="row">   
																<div class="col-md-4">  
																	<input type="hidden" name="CODIGO" value="<?php ECHO $xtabCx["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control"> 
																</div>  
															</div>  
															<div class="row">   
																<div class="col-md-6">  
																	<label>PRAZO</label>  
																	<input type="date" name="DATA" value="<?php ECHO $xtabCx["DATA"]?>" id="DATA" maxlength="4" class="form-control">  
																	
																</div>
																<div class="col-md-6">  
																	<label>ASSUNTO</label>  
																	<input type="text" name="ASSUNTO" value="<?php ECHO $xtabCx["ASSUNTO"]?>" id="ASSUNTO" maxlength="50" class="form-control"> 
																	
																</div>  
															</div>  
															<div class="row">   
																<div class="col-md-12">  
																	<label>CONTEÚDO</label>  
																	<textarea type="text" name="DESCRICAO" rows="10" value="<?php ECHO $xtabCx["DESCRICAO"]?>" id="DESCRICAO" maxlength="2000" class="form-control"><?php ECHO $xtabCx["DESCRICAO"]?></textarea>
																	
																</div>  
															</div>  
														  </div> 
														  <div class="modal-footer"> 
															<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="PAINEL.php?QUADRO=<?PHP ECHO $_GET["QUADRO"]?>"'>Fechar</button>
															<button type="submit" class="btn btn-success">Salvar mudanças</button>
														  </div>  
														</form> 
													  </div>
													  
													</div>

												  </div>
												</div>
											<br>
										</li><br><br>	
										
									<?php }
									}else {?>
									
									<?php } ?>	
									
									
								</DIV>
							</table>
						</td>
						
						<div id="myModal1<?php echo $row["CODIGO"]?>" class="modal fade" role="dialog">
						  <div class="modal-dialog">

							<!-- Modal content-->
							<div class="modal-content">
							   <div class="modal-header alert alert-info" style="text-align:center">
								
								<h4 class="modal-title"><center><?php ECHO $row["ASSUNTO"]?></center></h4>
							  </div>
							  <div class="modal-body">
								<form method="post" action='PAINEL2_dados.php?NUMERO=<?PHP ECHO $row["CODIGO"]?>&QUADRO=<?PHP ECHO $_GET["QUADRO"]?>'> 
								  <div class="modal-body">  
									<input type="hidden" name="CODIGO" value="0" id="CODIGO" maxlength="4" class="form-control"> 
									<div class="row">   
										<div class="col-md-4">  
											<input type="hidden" name="CODIGO" value="0" id="CODIGO" maxlength="4" class="form-control"> 
										</div>  
									</div>  
									<div class="row">   
										<div class="col-md-6">  
											<label>PRAZO</label>  
											<input type="date" name="DATA" value="" id="DATA" maxlength="4" class="form-control">  
											
										</div>
										<div class="col-md-6">  
											<label>ASSUNTO</label>  
											<input type="text" name="ASSUNTO" value="" id="ASSUNTO" maxlength="50" class="form-control"> 
											
										</div>  
									</div>  
									<div class="row">   
										<div class="col-md-12">  
											<label>CONTEÚDO</label>  
											<textarea type="text" name="DESCRICAO" rows="10" value="" id="DESCRICAO" maxlength="2000" class="form-control"><?php ECHO $xtabCx["DESCRICAO"]?></textarea>
											
										</div>  
									</div>  
								  </div> 
								  <div class="modal-footer"> 
									<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="PAINEL.php?QUADRO=<?PHP ECHO $_GET["QUADRO"]?>"'>Fechar</button>
									<button type="submit" class="btn btn-success">Salvar mudanças</button>
								  </div>  
								</form>
							  </div>
							 
							</div>

						  </div>
						</div>
						
						
				      
					<?php } ?>  
					<td></td>
				  </tbody>      
				</table>     
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
