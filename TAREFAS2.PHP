
<!DOCTYPE html>
<html lang="en">
<head> 
<meta name="viewport" content="width=device-width,initial-scale=1">

<?php include "css.php"?>

<script> 
function alterar(indice)  
{ 
location.href="tarefas2.php?ATITUDE=" + indice+"&GRUPO="+<?PHP ECHO $_GET["GRUPO"]?>;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclus?o?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "tarefas2",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
 }   
}  
function feito(indice)
{ 
if (confirm("Deseja concluir esse processo?")==true){ 
$.post("FEITO.PHP",
{ 
  FEITO: "S",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
    location.reload();  
   }  
  })
 }   
}  
function nfeito(indice)
{ 
if (confirm("Deseja reabrir esse processo?")==true){ 
$.post("FEITO.PHP",
{ 
  FEITO: "N",
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
</head> 
<body id="page-top"> 
<?php
$ACESSO=""; 
$ACESSO="Tarefas"; 
include "conexao.php";
include "controleacesso.php";
$SQL="SELECT CODIGO, FEITO, (SELECT NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS USUARIO, CAST(OBSERVACAO AS VARCHAR(2000)) AS OBSERVACAO, DATAALTERACAO, HORAALTERACAO, MANUTENCAO, GRUPO, CLIENTE FROM TAREFAS2 WHERE GRUPO=" . $_GET["GRUPO"]; 
if (ISSET($_GET["ATITUDE"]))
{ 
	$ATITUDE=$_GET["ATITUDE"]; 
$SQL=$SQL . " AND CODIGO=0". $_GET["ATITUDE"];
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
	echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{ 
	$tabela=ibase_query($conexao,$SQL);  
}   
?>   
<div id="wrapper">    
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<div class="modal fade bd-example-modal-lg" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		  <div class="modal-dialog modal-lg" role="document"> 
			<div class="modal-content" WIDTH="100%">   
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">   
				<h5 class="modal-title" id="TituloModalCentralizado" align="center"><?php echo $ACESSO ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>  
			  <form method="post" action="tarefas2_dados.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>" enctype="multipart/form-data" name="cadastro" >    
				  <div class="modal-body">  
					<?php if (isset($_GET["ATITUDE"])){?>  
						<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
					<?php }else{ ?>
						<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
					<?php } ?>  
					
					<div class="row">   
						<div class="col-md-12">
							<label>Descrição do Problema</label>
							<?php if (isset($_GET["ATITUDE"])){?>  
								<textarea type="text" name="OBSERVACAO" id="editor" rows="10" cols="100%" maxlength="2000" class="form-control"><?php ECHO $row["OBSERVACAO"]?></textarea> 
							<?php }else{ ?>
								<textarea type="text" name="OBSERVACAO" id="editor" rows="10" cols="100%" maxlength="2000" class="form-control"></textarea>
							<?php } ?>  
						</div>   
					</div> 
					
					<div class="modal-footer"> 
						<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=tarefas2.php?GRUPO=<?PHP ECHO $_GET["GRUPO"]?>'>Fechar</button> 
						<button type="submit" class="btn btn-success">Salvar mudan?as</button>  
					</div> 
				</form> 
			</DIV> 
			</div>   
		  </div>   
		</div>    
		<div class="container-fluid">  
			<div class="card shadow mb-4">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold"><?PHP ECHO $ACESSO?></h6> 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;"> 
				  <thead>  
					<tr> 
					  <th>Código</th>
					  <th>Observação</th> 
					  <th>Usuário</th> 
					  <th>Data</th>
					  <th><button class="btn btn-success" type="button" onclick="alterar('0')">Incluir</button></th>  
					</tr>    
				  </thead>
				  <tfoot> 
					<tr> 
					  <th>Código</th> 
					  <th>Observação</th>
					  <th>Usuário</th>
					  <th>Data</th>
					  <th>Ação</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
			    	$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php echo $row["CODIGO"]?></td> 
					  <td><?php echo $row["OBSERVACAO"]?></td>
					  <td><?php echo $row["USUARIO"]?></td>
					  <td><?php echo formatardata($row["DATAALTERACAO"],1)?> - <?php echo substr($row["DATAALTERACAO"], 10) ?></td> 
					  
                      <td>
                        <div class="btn-group btn-group-justified" role="group" aria-label="...">
                            <div class="btn-group" role="group">
                                <?php include "acao.php" ?>

                                <?PHP if ($row["FEITO"]!="S"){ ?>
                                    <button class="button buttoninfo" type="button" onclick="feito('<?PHP ECHO $sequencia?>')"><i class="fas fa-print"></i></button>
                                <?php }else{ ?>
                                    <button class="button buttondelet" type="button" onclick="nfeito('<?PHP ECHO $sequencia?>')"><i class="fas fa-print"></i></button>
                                <?php } ?>
                            </div>
                        </div>
                      </td> 
					</tr>
					<?php } ?> 
				  </tbody> 
				</table>   
			  </div> 
			</div>   
		  </div> 
		</div> 
	  </div> 
	</div>
</div> 
	<script>
		initSample();
	</script>
	<?php include "rodape.php" ?> 
</body>
</html> 
