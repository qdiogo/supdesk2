<!DOCTYPE html>
<html lang="pt"> 
<head> 
<?php 
include "conexao.php"; 
include "css.php";
?>
<script> 
function alterar(indice)  
{ 
location.href="REGISTRO_TAREFAS.php?ATITUDE=" + indice + "&PROFISSIONAL=<?PHP ECHO $_GET["PROFISSIONAL"]?>&data=<?PHP ECHO $_GET["data"]?>";
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "REGISTRO_TAREFAS",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
	 location.reload(); 
   }  
  })
 }   
}
function email(indice)
{ 
if (confirm("Deseja realmente enviar esse email?")==true){ 
$.post("POP.PHP?CODIGO=" + indice,
{ 
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
	 alert(data);
   }  
  })
 }   
}

function createRequestObject()
{
	var ro;
	var browser = navigator.appName;
	if(browser == "Microsoft Internet Explorer")
	{
		ro = new ActiveXObject("Microsoft.XMLHTTP");
	}
	else
	{
		ro = new XMLHttpRequest();
	}
	return ro;
}
function fram5(indice)
{
    document.getElementById("fram5").src="tarefas2.php?GRUPO=" + indice;
}
function abrirpac(indice)
{
	document.getElementById('CLIENTE').focus();
	document.getElementById('CLIENTE').select();
	window.open('CONSULTA_PESSOA.php','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
}

function whats(telefone, mensagem)
{
	window.open('https://api.whatsapp.com/send?phone='+telefone+'&text='+mensagem+'','page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	window.close();
}
function PACX(xproc)
{
	var wproc = localStorage.getItem('pegapssoa');
	if (wproc!=null)
	{
		xproc.value = wproc;
		localStorage.removeItem('pegapssoa');
	}
}
var httproc = createRequestObject();
function BUSCAPAC() {
	httproc.open("get", 'pessoa_ajax.php?CODIGO=' + document.getElementById("CLIENTE").value);
	httproc.onreadystatechange = Xpac;
	httproc.send(null);
}

function Xpac()
{
	if(httproc.readyState == 4)
	{
		var response = httproc.responseText;
		var update = new Array();
		update = response.split('|');
		if (update[0]!=null)
		{
			document.getElementById("NOMECLIENTE").value = update[0];
		}else{
			document.getElementById("NOMECLIENTE").value = "N?O ENCONTRADO";
		}
	}
}

$(document).ready(function() {
		$('#dataTable').DataTable( {
			"order": [[ 0, "desc"]],
			"language": {
				"lengthMenu": " _MENU_ Registros",
				"zeroRecords": "Nenhum registro encontrado!",
				"info": "Páginas _PAGE_ até _PAGES_",
				"infoEmpty": "Nenhum registro encontrado!",
				"infoFiltered": "(filtro de _MAX_ total registros)"
			}
		});
	} );
	
	function abrirficha_visita(indice)
	{
		window.open('VISITATECNICA.php?329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498=329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498&LOGADO=N&CODIGO=' + indice,'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	} 
	function assinar(indice)
	{
		window.open('VISITATECNICA.php?329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498=329874389743894739847394873438748742938498329874389743894739847394873438748742938498329874389743894739847394873438748742938498&LOGADO=N&CODIGO=' + indice + "&ASSINAR=S",'page','toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=900,height=900');
	} 
	function fram4(indice)
	{
		document.getElementById("frame3").src="documentos.php?TABELA=REGISTRO_TAREFAS&GRUPO=" + indice;
	}
</script> 
</head>
<body> 
<?php 
 
$SQL="SELECT first 100 M.CODIGO, M.DATA,M.HORA, SETOR, M.CATEGORIA, M.STATUS, M.SISTEMA1, M.SISTEMA2, M.SISTEMA3, M.SISTEMA4, M.SISTEMA5, M.SISTEMA6, M.SISTEMA7, M.SISTEMA8, M.SISTEMA9, M.SISTEMA10, CAST(M.OBSERVACAO2 AS VARCHAR(20000)) AS OBSERVACAO2, ".
"(SELECT NOME FROM TECNICOS WHERE CODIGO=M.TECNICO) AS NOMETECNICO,P.EMAIL, CAST(M.OBSERVACAO AS VARCHAR(20000)) AS OBSERVACAO,  M.TECNICO, M.TITULO, M.RESPONSAVEL, M.CLIENTE, ".
"(SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=M.CLIENTE) AS NOMECLIENTE ".
" FROM REGISTRO_TAREFAS M INNER JOIN EMPRESAS P ON (P.CODIGO=M.CLIENTE)  ";
if (ISSET($_GET["ATITUDE"])) 
{
	$ATITUDE=$_GET["ATITUDE"];
    $SQL=$SQL . " AND  M.CODIGO=0". $_GET["ATITUDE"]; 
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
    echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$SQL=$SQL . " AND M.UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
	}
    $SQL=$SQL . " ORDER BY M.DATA DESC "; 
	$tabela=ibase_query($conexao,$SQL);
} 

	

?> 

<div id="wrapper">    
	
<?php include "menu.php"?>   
<div id="content-wrapper" class="d-flex flex-column">     
<div id="content"> 
<?php include "menuh.php" ?>      
	<div class="modal fade" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
		<div class="modal-dialog modal-xl modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-content">

			  <!-- Header -->
			  <div class="modal-header" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">  
				<h5 class="modal-title text-center" id="TituloModalCentralizado">Tarefa - <?php echo $_GET["ATITUDE"] ?></h5> 
				<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href="REGISTRO_TAREFAS.php"'> 
				  <span aria-hidden="true">&times;</span> 
				</button>
			  </div> 

			  <!-- Abas -->
			  <ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
				  <a class="nav-link sistema2 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados Gerais</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link sistema2" id="tarefas-tab" data-toggle="tab" href="#home2" role="tab" aria-controls="home2" aria-selected="false" onclick="fram5(<?php echo $_GET['ATITUDE'] ?>)">Tarefas Solicitadas</a>
				</li>
				<li class="nav-item">
				  <a class="nav-link sistema2" id="documentos-tab" data-toggle="tab" href="#documentos" role="tab" aria-controls="documentos" aria-selected="false" onclick="fram4(<?php echo $_GET['ATITUDE'] ?>); fram6(<?php echo $_GET['ATITUDE'] ?>)">Documentos</a>
				</li>
			  </ul>

			  <div class="tab-content" id="myTabContent">

				<!-- Dados Gerais -->
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
				  <form method="post" action='REGISTRO_TAREFAS_dados.php'> 
					<div class="modal-footer"> 
					  <button type="button" class="btn btn-success" data-dismiss="modal" onclick='location.href="REGISTRO_TAREFAS.php?ATITUDE=0"'>+</button>
					  <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="REGISTRO_TAREFAS.php"'>Fechar</button>
					  <button type="submit" class="btn btn-success">Salvar mudanças</button>
					  <?php if (($_GET["ATITUDE"] > "0")) { ?> 
						<button class="button buttoninfo" type="button" onclick="abrirficha_visita('<?php echo $_GET["ATITUDE"] ?>')"><i class="fas fa-print"></i></button>
					  <?php } ?> 
					</div>

					<div class="modal-body">
					  <input type="hidden" name="CODIGO" value="<?php echo isset($_GET["ATITUDE"]) ? $_GET["ATITUDE"] : '0'; ?>" id="CODIGO" class="form-control">
					  <input type="hidden" readonly required name="CODIGO_OP" value="<?php echo isset($row['CODIGO_OP']) ? $row['CODIGO_OP'] : ''; ?>" id="CODIGO_OP" class="form-control">

					  <div class="table-responsive">
						<table class="table table-borderless">

						  <!-- Titulo -->
						  <tr>
							<td colspan="12">
							  <label>Titulo</label>
							  <input type="text" name="TITULO" value="<?php echo isset($row['TITULO']) ? $row['TITULO'] : ''; ?>" id="TITULO" maxlength="100" class="form-control">
							</td>
						  </tr>

						  <!-- Data, Hora, Status, Tecnico -->
						  <tr>
							<td><label>Data</label><input type="date" name="DATA" value="<?php echo !empty($row['DATA']) ? $row['DATA'] : date('Y-m-d'); ?>" class="form-control"></td>
							<td><label>Hora</label><input type="time" name="HORA" value="<?php echo !empty($row['HORA']) ? $row['HORA'] : date('H:i'); ?>" class="form-control"></td>
							<td>
							  <label>Status</label>
							  <select name="STATUS" class="form-control">
								<?php
								  $SQL1="SELECT CODIGO, NOME FROM STATUS";
								  $tabelaX=ibase_query($conexao,$SQL1);
								  while ($rowX=ibase_fetch_assoc($tabelaX)) {
									$selected = (isset($row['STATUS']) && trim($row['STATUS']) == trim($rowX['CODIGO'])) ? 'SELECTED' : '';
									echo "<option value='{$rowX['CODIGO']}' {$selected}>{$rowX['NOME']}</option>";
								  }
								?>
							  </select>
							</td>
							<td colspan="6">
							  <label>Técnicos</label>
							  <select name="TECNICO" class="form-control">
								<?php
								  $SQL="SELECT CODIGO, NOME FROM TECNICOS";
								  $tabelaX=ibase_query($conexao,$SQL);
								  while ($rowX=ibase_fetch_assoc($tabelaX)) {
									$selected = (!empty($row['TECNICO']) && $row['TECNICO'] == $rowX['CODIGO']) || ($_SESSION["USUARIO"]==$rowX["CODIGO"] && empty($row['TECNICO'])) ? 'SELECTED' : '';
									echo "<option value='{$rowX['CODIGO']}' {$selected}>{$rowX['CODIGO']}-{$rowX['NOME']}</option>";
								  }
								?>
							  </select>
							</td>
						  </tr>

						  <!-- Sistemas Checkboxes -->
						  <tr>
							<?php
							  $labels = ["SYSHOSP","SYSMEDIC","ESTOQUE","LAUDOS","FINANCEIRO","PATRIMONIO","CONTABIL","FOLHA","MÉDICO","OUTROS"];
							  for ($i=1; $i<=10; $i++) {
								$checked = (!empty($row["SISTEMA$i"]) && $row["SISTEMA$i"]=="S") ? "checked" : "";
								echo "<td><label>{$labels[$i-1]}</label><br><input type='checkbox' name='SISTEMA$i' value='S' {$checked}></td>";
							  }
							?>
						  </tr>

						  <!-- Cliente e Responsavel -->
						  <tr>
							<td>
							  <label>Cliente</label>
							  <select name="CLIENTE" class="form-control" required>
								<option></option>
								<?php
								  $SQL1="SELECT CODIGO, FANTASIA FROM EMPRESAS ORDER BY FANTASIA ASC";
								  $tabelaX=ibase_query($conexao,$SQL1);
								  while ($rowX=ibase_fetch_assoc($tabelaX)) {
									$selected = (isset($row['CLIENTE']) && trim($row['CLIENTE']) == trim($rowX['CODIGO'])) ? 'SELECTED' : '';
									echo "<option value='{$rowX['CODIGO']}' {$selected}>{$rowX['FANTASIA']}</option>";
								  }
								?>
							  </select>
							</td>
							<td colspan="12">
							  <label>Responsável</label>
							  <input type="text" name="RESPONSAVEL" value="<?php echo isset($row['RESPONSAVEL']) ? $row['RESPONSAVEL'] : ''; ?>" class="form-control">
							</td>
						  </tr>

						  <!-- Categoria e Setor -->
						  <tr>
							<td colspan="6">
							  <label>Categoria</label>
							  <select name="categoria" class="form-control" required onchange="getValor(this.value)">
								<option></option>
								<?php
								  $SQL1="SELECT CODIGO, DESCRICAO FROM CATEGORIA ORDER BY DESCRICAO ASC";
								  $tabelaX=ibase_query($conexao,$SQL1);
								  while ($rowX=ibase_fetch_assoc($tabelaX)) {
									$selected = (isset($row['CATEGORIA']) && trim($row['CATEGORIA']) == trim($rowX['CODIGO'])) ? 'SELECTED' : '';
									echo "<option value='{$rowX['CODIGO']}' {$selected}>{$rowX['DESCRICAO']}</option>";
								  }
								?>
							  </select>
							</td>
							<td colspan="6">
							  <label>Setor</label>
							  <input type="text" name="SETOR" value="<?php echo isset($row['SETOR']) ? $row['SETOR'] : ''; ?>" class="form-control">
							</td>
						  </tr>

						  <!-- OBSERVACAO -->
						  <tr>
							<td colspan="12">
							  <div class="card-header py-3 sistema2">
								<h6 class="m-0 font-weight-bold">Descrição do Problema</h6>
							  </div>
							  <textarea name="OBSERVACAO" id="editor" rows="5" maxlength="20000" class="form-control"><?php echo isset($row['OBSERVACAO']) ? $row['OBSERVACAO'] : ''; ?></textarea>
							</td>
						  </tr>

						  <!-- OBSERVACAO2 -->
						  <tr>
							<td colspan="12">
							  <div class="card-header py-3 sistema2">
								<h6 class="m-0 font-weight-bold">Descrição do Serviço</h6>
							  </div>
							  <textarea name="OBSERVACAO2" id="editor2" rows="5" maxlength="20000" class="form-control"><?php echo isset($row['OBSERVACAO2']) ? $row['OBSERVACAO2'] : ''; ?></textarea>
							</td>
						  </tr>

						</table>
					  </div>

					  <!-- Progress Bar -->
					  <div class="col-md-12 mt-3">
						<div class="progress">
						  <?php
							$SQLW="select * from CALCULO_TAREFAS('".$_GET["ATITUDE"]."');";
							$tabelaX=ibase_query($conexao,$SQLW);
							$XROW=ibase_fetch_assoc($tabelaX);
						  ?>
						  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?php echo $XROW["MEDIATAREFA"] ?>%"><?php echo $XROW["MEDIATAREFA"] ?>%</div>
						</div>
					  </div>

					</div>
				  </form>
				</div>

				<!-- Tarefas Solicitadas -->
				<div id="home2" class="tab-pane fade">
				  <div class="embed-responsive embed-responsive-16by9">
					<iframe frameborder="0" id="fram5" src="/tarefas2.PHP?GRUPO=<?php echo $_GET["ATITUDE"] ?>" class="embed-responsive-item"></iframe>
				  </div>
				</div>

				<!-- Documentos -->
				<div id="documentos" class="tab-pane fade">
				  <div class="embed-responsive embed-responsive-16by9">
					<iframe frameborder="0" id="frame3" src="/documentos.php?GRUPO=<?php echo $_GET["ATITUDE"] ?>&TABELA=REGISTRO_TAREFAS" class="embed-responsive-item"></iframe>
				  </div>
				</div>

			  </div>
			</div>
		  </div>

		  <script>
			initSample();
		  </script>
		</div>
	</div>

	<div class="container-fluid"> 
		<div class="card shadow mb-4">
		<div class="card-header py-3 sistema2">
			<h6 class="m-0 font-weight-bold">Registros de Tarefas</h6> 
		</div> 
		<div class="card-body"> 
			<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 8px"> 
			<thead>
				<tr> 
					<th>CÓDIGO</th>
					<th>STATUS</th>
					<th>TÉCNICO</th> 
					<th>CLIENTE</th>
					<th>TITULO</th> 
					<th>DATA</th> 
					<th>HORA</th> 
					<th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
				</tr>
				</thead>
				<tfoot>
				<tr> 
					<th>CÓDIGO</th>
					<th>STATUS</th>
					<th>TÉCNICO</th> 
					<th>CLIENTE</th> 
					<th>TITULO</th> 
					<th>DATA</th> 
					<th>HORA</th> 
					<th>A??o</th> 
				</tr> 
				</tfoot>
				<tbody> 
				<?php 
				while ($row=$open=ibase_fetch_assoc($tabela)){
				$sequencia=$row["CODIGO"];?>
				<tr> 
					<td><?php echo $row["CODIGO"]?></td>
					<td>
						<CENTER>
						<?php if ($row["STATUS"]=="1"){?>
							<img height="30"  width="30" src="img/compareceu.png">
						<?php } ?>
						
						<?php if ($row["STATUS"]=="2"){?>
							<img height="30"  width="30" src="img/faltou.png">
						<?php } ?>
						<?php if ($row["STATUS"]=="3"){?>
							<img height="30"  width="30" src="img/cancelado.png">
						<?php } ?>
						
						<?php if (($row["STATUS"]=="4") || ($row["STATUS"]=='')){?>
							<img height="30"  width="30" src="img/marcado.png">
						<?php } ?>
                        <div class="col-md-12">
                            <div class="progress">
                                <?PHP 
                                $SQLW="select * from CALCULO_TAREFAS('".$row["CODIGO"]."');";
                                $tabelaX=ibase_query($conexao,$SQLW); 
                                $XROW=ibase_fetch_assoc($tabelaX); 
                                ?>
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP ECHO $XROW["MEDIATAREFA"]?>%"><?PHP ECHO $XROW["MEDIATAREFA"]?></div>
                            </div>
                        </div> 
						</CENTER>
					</td>
                    <td><?php echo $row["NOMETECNICO"]?></td>
					<td><?php echo $row["NOMECLIENTE"]?></td>
					<td><?php echo $row["TITULO"]?></td>
					<td><?php echo formatardata($row["DATA"],1)?></td>
					<td><?php echo $row["HORA"]?></td>
					<td>
					<div class="btn-group" role="group" aria-label="Basic example">
						<button class="button buttoned " title="Editar" type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
						<button class="button buttondelet" title="Deletar" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
						<button class="button buttoninfo" title="Imprimir" type="button" onclick="abrirficha_visita('<?PHP ECHO $sequencia?>')"><i class="fas fa-print"></i></button>
						<button class="button buttoninfo" title="Assinar" type="button" onclick="assinar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
						<?PHP if ($row["WHATSAPP"]!='')
							{?><button class="button buttoned" type="button" onclick="whats('55<?PHP ECHO $row["CELULAR"]?>', 'Ol?  Sr(a) <?php echo $row["NOMEPACIENTE"]?>, tudo bem contigo? Confirmando ? nossa audi?ncia  para dia o <?php echo date("d-m-Y",strtotime($row["DATA"]))?>  ? partir das  <?php echo $row["HORA"]?>. ')"><i class="fas fa-send"></i></button>
						<?php } ?>
						<?PHP if ($row["EMAIL"]!='')
							{?><button class="button buttoninfo" type="button" onclick="email(<?PHP ECHO $sequencia?>)"><i class="fas fa-send"></i></button>
						<?php } ?>
					</div>
					</td> 
				</tr>      
				<?php } ?>  
				</tbody>            
			</table>     
			</div>    
		</div>   
		</div>  
		<table>
			<td class="col-md-2">
				<img height="30"  width="30" src="img/compareceu.png"> Finalizado
			</td>
			
			<td class="col-md-2">
				<img height="30"  width="30" src="img/faltou.png"> Remarcou
			</td>
			<td class="col-md-2">
				<img height="30"  width="30" src="img/cancelado.png"> Cancelados
			</td>
			
			<td class="col-md-2">
				<img height="30"  width="30" src="img/marcado.png"> Executando
			</td>
		</table>
	</div>  
</div>  
</div>  
<?php include "rodape.php" ?>
</body> 
</html> 
