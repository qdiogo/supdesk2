<!DOCTYPE html>
<html lang="en">
<head> 
<?php 
include "conexao.php";
include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="controlevalidade.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "CONTROLE_VALIDADE",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
 }   
}
 function abrirlista2(indice)
{
	window.open('unidadenegocio.php?GRUPO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
}  
$(document).ready(function() {
	$('#dataTable').DataTable( {
		"order": [[ 0, "desc"], [3, "asc"], [4, "asc" ]],
		"language": {
			"lengthMenu": " _MENU_ Registros",
			"zeroRecords": "Nenhum registro encontrado!",
			"info": "Páginas _PAGE_ até _PAGES_",
			"infoEmpty": "Nenhum registro encontrado!",
			"infoFiltered": "(filtro de _MAX_ total registros)"
		}
	});
} );
function abrirlista(indice, email)
{
	if (confirm("Deseja Realemnte Enviar esse E-mail ?")==true)
	{
		window.open('enviarchavecliente.php?email='+email+'&CODIGO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	}
}  
</script> 
</head> 
<body id="page-top"> 
<?php
	$ACESSO=""; 
	$ACESSO="MONITOR DE RESPOSTAS"; 
	
	include "controleacesso.php";
	$SQL="SELECT DISTINCT CH.CODIGO, CH.ASSUNTO, E.RAZAOSOCIAL, UPPER(T.NOME) AS NOME,  CAST(FEITO AS VARCHAR(30000)) AS FEITO FROM CHAMADOS CH ".
		 "INNER JOIN EMPRESAS E ON (E.CODIGO=CH.EMPRESA) ".
		 "INNER JOIN TECNICOS T ON (T.CODIGO=CH.TECNICO) ".
		 "INNER JOIN HISTORICO_AT_CHAMADOS  H ON (H.CHAMADO=CH.CODIGO) ";
		 if (!empty($_SESSION["UNIDADENEGOCIO"]))
		{
			$SQL=$SQL . " AND UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
		}
		$SQL=$SQL . "ORDER BY H.DATA DESC "; 
	$tabela=ibase_query($conexao,$SQL);  
	 
?>   
<div id="wrapper">    
	<?php include "menu.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php" ?>         
		<div class="container-fluid">  
			<div class="card shadow mb-4">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold"><?php echo $ACESSO?></h6> 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;"> 
					  <thead>  
						<tr> 
						 <th>Código</th> 
						  <th>Razão social</th> 
						  <th>Técnicos</th>	
						  <th>Assunto</th>		
						  <th>Resposta</th>	</tr>    
					  </thead>
				  <tfoot> 
					<tr> 
					  <th>Código</th> 
					  <th>Razão social</th> 
					  <th>Técnicos</th>	
					  <th>Assunto</th>		
					  <th>Resposta</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php ECHO $row["RAZAOSOCIAL"]?></td>
					  <td><?php ECHO $row["NOME"]?></td>
					  <td><?php ECHO $row["ASSUNTO"]?></td>
					  <td><?php ECHO $row["FEITO"]?></td>
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
	<?php include "rodape.php" ?> 
</body>
</html> 
