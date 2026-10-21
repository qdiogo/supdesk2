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
	var tabela = $('#dataTable').DataTable( {
		"order": [[ 0, "desc"], [3, "asc"], [4, "asc" ]],
		"language": {
			"lengthMenu": " _MENU_ Registros",
			"zeroRecords": "Nenhum registro encontrado!",
			"info": "Páginas _PAGE_ até _PAGES_",
			"infoEmpty": "Nenhum registro encontrado!",
			"infoFiltered": "(filtro de _MAX_ total registros)"
		}
	});
    $('#filtro_codigo').on('keyup change', function() {
        var valor = $.fn.dataTable.util.escapeRegex($(this).val());
        tabela.column(0).search(valor ? '^' + valor + '$' : '', true, false).draw();
    });
    $('#filtro_data').on('keyup change', function() { tabela.column(2).search(this.value).draw(); });
    $('#filtro_empresa').on('keyup change', function() { tabela.column(1).search(this.value).draw(); });
    $('#filtro_tecnico').on('keyup change', function() { tabela.column(3).search(this.value).draw(); });
    $('#filtro_assunto').on('keyup change', function() { tabela.column(4).search(this.value).draw(); });
    $('#filtro_resposta').on('keyup change', function() { tabela.column(5).search(this.value).draw(); });
} );
function abrirlista(indice, email)
{
	if (confirm("Deseja Realemnte Enviar esse E-mail ?")==true)
	{
		window.open('enviarchavecliente.php?email='+email+'&CODIGO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	}
}  
</script> 
<style>
/* Melhorias visuais somente: sem alterar consultas, filtros ou comportamento. */
#content .card.shadow.mb-4 { border:0; border-radius:12px; overflow:hidden; box-shadow:0 8px 24px rgba(27,39,71,.10)!important; }
#content .card-header.sistema2 { padding:18px 22px; background:linear-gradient(110deg,#253b80,#456bd1); color:#fff; }
#content .card-header.sistema2 h6 { color:#fff; font-size:16px; letter-spacing:.2px; }
#content .card-body { padding:22px; }
#content form[method="get"] { padding:16px; background:#f5f7fb; border:1px solid #e4e9f2; border-radius:10px; }
#content form[method="get"] label { margin-bottom:6px; color:#34415c; font-size:13px; font-weight:600; }
#content input[type="date"], #content input[type="text"] { min-height:38px; padding:8px 11px; border:1px solid #ccd4e2; border-radius:7px; background:#fff; color:#26334d; outline:none; transition:border-color .15s,box-shadow .15s; }
#content input[type="date"]:focus, #content input[type="text"]:focus { border-color:#4c6fd5; box-shadow:0 0 0 3px rgba(76,111,213,.14); }
#content button[type="submit"] { min-height:38px; padding:8px 15px; border:0; border-radius:7px; background:#365fc5; color:#fff; font-weight:600; cursor:pointer; }
#content button[type="submit"]:hover { background:#294da8; }
#content form[method="get"] a { display:inline-block; margin-left:8px; color:#52627d; font-size:13px; text-decoration:none; }
#content form[method="get"] a:hover { color:#294da8; text-decoration:underline; }
#content .card-body > div[style*="display:flex"] { margin-top:12px; }
#content .table-responsive { border:1px solid #e3e8f0; border-radius:9px; }
#dataTable { margin-bottom:0; border-color:#e3e8f0; font-size:13px!important; }
#dataTable thead th { padding:11px 10px; border-color:#dfe5ef; background:#edf2fb; color:#293956; white-space:nowrap; vertical-align:middle; }
#dataTable tbody td { padding:10px; border-color:#e7ebf2; color:#35415a; vertical-align:top; }
#dataTable tbody tr:nth-child(even) { background:#f8faff; }
#dataTable tbody tr:hover { background:#eef4ff; }
#dataTable tfoot th { padding:9px 10px; background:#f5f7fb; color:#64718a; }
.dataTables_wrapper .dataTables_filter input, .dataTables_wrapper .dataTables_length select { padding:6px 9px; border:1px solid #ccd4e2; border-radius:6px; }
@media (max-width:700px) {
  #content .card-body { padding:14px; }
  #content form[method="get"] { align-items:stretch!important; }
  #content form[method="get"] > div { width:100%; }
  #content input[type="date"], #content input[type="text"] { width:100%; }
}
</style>
</head> 
<body id="page-top"> 
<?php
	$ACESSO=""; 
	$ACESSO="MONITOR DE RESPOSTAS"; 
	$hoje = date('Y-m-d');
	$dataInicio = isset($_GET['data_inicio']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['data_inicio']) ? $_GET['data_inicio'] : '';
	$dataFim = isset($_GET['data_fim']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $_GET['data_fim']) ? $_GET['data_fim'] : '';
	if ($dataInicio === '' && $dataFim === '') { $dataInicio = $hoje; $dataFim = $hoje; }
	elseif ($dataInicio !== '' && $dataFim === '') { $dataFim = $dataInicio; }
	elseif ($dataInicio === '' && $dataFim !== '') { $dataInicio = $dataFim; }
	
	include "controleacesso.php";
	$SQL="SELECT DISTINCT CH.CODIGO, CH.ASSUNTO, E.RAZAOSOCIAL, UPPER(T.NOME) AS NOME,  CAST(FEITO AS VARCHAR(30000)) AS FEITO FROM CHAMADOS CH ".
		 "INNER JOIN EMPRESAS E ON (E.CODIGO=CH.EMPRESA) ".
		 "INNER JOIN TECNICOS T ON (T.CODIGO=CH.TECNICO) ".
		 "INNER JOIN HISTORICO_AT_CHAMADOS  H ON (H.CHAMADO=CH.CODIGO) ";
		 if (!empty($_SESSION["UNIDADENEGOCIO"]))
			{
				$SQL=$SQL . " AND UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
			}
			$SQL .= " WHERE EXISTS (SELECT 1 FROM HISTORICO_AT_CHAMADOS HC WHERE HC.CHAMADO=CH.CODIGO AND HC.QUEM='TECNICO' AND HC.ACAO='FECHADO'";
			$SQL .= " AND CAST(H.DATA AS DATE) >= '" . $dataInicio . "'";
			$SQL .= " AND CAST(H.DATA AS DATE) <= '" . $dataFim . "') ";
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
				  <form method="get" style="display:flex; flex-wrap:wrap; gap:8px; align-items:end; margin-bottom:12px;">
					<div><label for="data_inicio">Período de</label><br><input type="date" id="data_inicio" name="data_inicio" value="<?php echo htmlspecialchars($dataInicio, ENT_QUOTES, 'UTF-8'); ?>"></div>
					<div><label for="data_fim">Período até</label><br><input type="date" id="data_fim" name="data_fim" value="<?php echo htmlspecialchars($dataFim, ENT_QUOTES, 'UTF-8'); ?>"></div>
					<div><button type="submit">Filtrar período</button> <a href="<?php echo htmlspecialchars(basename($_SERVER['PHP_SELF']), ENT_QUOTES, 'UTF-8'); ?>">Limpar período</a></div>
				  </form>
				  <div style="display:flex; flex-wrap:wrap; gap:8px; margin-bottom:12px;">
<input type="text" id="filtro_codigo" placeholder="Filtrar nº do chamado" style="min-width:150px;">
<input type="text" id="filtro_data" placeholder="Filtrar data de fechamento" style="min-width:170px;">
<input type="text" id="filtro_empresa" placeholder="Filtrar empresa" style="min-width:150px;">
<input type="text" id="filtro_tecnico" placeholder="Filtrar técnico" style="min-width:150px;">
<input type="text" id="filtro_assunto" placeholder="Filtrar assunto" style="min-width:150px;">
<input type="text" id="filtro_resposta" placeholder="Filtrar resposta" style="min-width:150px;">
</div>
<div class="table-responsive"> 
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;"> 
					  <thead>  
						<tr> 
						<th>Código</th> 
						<th>Fechado Em</th> 
						<th>Razão social</th> 
						<th>Técnicos que fechou</th>	
						<th>Assunto</th>		
						<th>Resposta</th>	</tr>    
					  </thead>
				  <tfoot> 
					<tr> 
					  <th>Código</th> 
					  <th>Fechado Em</th> 
					  <th>Razão social</th> 
					  <th>Técnicos que fechou</th>	
					  <th>Assunto</th>		
					  <th>Resposta</th>
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];
					$SQL1x="select CODIGO, CHAMADO, (SELECT FIRST 1 NOME FROM TECNICOS WHERE CODIGO=TECNICO) AS TECNICO, DATA, HORA, ACAO, QUEM, ".
							"(SELECT FIRST 1 NOME FROM CLIENTES WHERE CODIGO=CLIENTE) AS CLIENTE ".
							"from HISTORICO_AT_CHAMADOS WHERE  CHAMADO=".$row["CODIGO"]." and quem='TECNICO' and ACAO='FECHADO' ";
					$tabelaXx=ibase_query($conexao,$SQL1x); 
					$openx=ibase_fetch_assoc($tabelaXx);?>  
					<tr>  
					  <td><?php ECHO $row["CODIGO"]?></td>
					  <td><?php if (!empty($openx["DATA"])) {
							ECHO date("d-m-Y",strtotime($openx["DATA"]));
						} ?></td>
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
