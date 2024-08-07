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
location.href="financeiro.php?ATITUDE=" + indice + "&PROFISSIONAL=<?PHP ECHO $_GET["PROFISSIONAL"]?>&data=<?PHP ECHO $_GET["data"]?>";
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "financeiro",
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
		document.getElementById("frame3").src="financeiro2.php?TABELA=financeiro&CODIGO=" + indice;
	}
</script> 
</head>
<body> 
<?php 
 
$SQL="SELECT M.CODIGO, M.DATA,M.HORA, SETOR, M.CATEGORIA, M.STATUS, M.SISTEMA1, M.SISTEMA2, M.SISTEMA3, M.SISTEMA4, M.SISTEMA5, M.SISTEMA6, M.SISTEMA7, M.SISTEMA8, M.SISTEMA9, M.SISTEMA10, CAST(M.OBSERVACAO2 AS VARCHAR(20000)) AS OBSERVACAO2, ".
"(SELECT NOME FROM TECNICOS WHERE CODIGO=M.TECNICO) AS NOMETECNICO,P.EMAIL, CAST(M.OBSERVACAO AS VARCHAR(20000)) AS OBSERVACAO,  M.TECNICO, M.TITULO, M.RESPONSAVEL, M.CLIENTE, ".
"(SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=M.CLIENTE) AS NOMECLIENTE ".
" FROM FINANCEIROV2 M INNER JOIN EMPRESAS P ON (P.CODIGO=M.CLIENTE)  ";
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
		$SQL=$SQL . " AND M.TECNICO=" . $_SESSION["USUARIO"];
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

<div id="content-wrapper" class="d-flex flex-column">   
	<div class="modal fade bd-example-modal-lg" width="1200px" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		<div class="modal-dialog modal-lg" role="document" width="1200px"> 
		<div class="modal-content" width="1200px">
			<div class="modal-header"  width="100%" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">  
			<h5 class="modal-title" id="TituloModalCentralizado" align="center">Tarefa - <?PHP ECHO $_GET["ATITUDE"]?></h5> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Fechar" onclick='location.href=location.href="financeiro.php"'> 
				<span aria-hidden="true" >&times;</span> 
			</button>
			</div> 
			<ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                <a class="nav-link sistema2 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Dados Gerais</a>
                </li>
                <li class="nav-item">
                
				<li class="nav-item">
                <a class="nav-link sistema2" id="contact-tab" data-toggle="tab" href="#documentos" role="tab" onclick="fram4(<?php echo $_GET["ATITUDE"]?>)" aria-controls="contact" aria-selected="false" onclick="fram6(<?php echo $_GET["ATITUDE"]?>)"> Lançamentos </a>
            </ul>
                
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    
                <form method="post" action='financeiro_dados.php'> 
                    <div class="modal-footer"> 
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick='location.href=location.href="financeiro.php?ATITUDE=0"'>+</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="financeiro.php"'>Fechas</button>
                        <button type="submit" class="btn btn-success">Salvar mudanças</button>
						<?php if (($_GET["ATITUDE"] > "0")){?> 
							<button class="button buttoninfo" type="button" onclick="abrirficha_visita('<?PHP ECHO $_GET["ATITUDE"]?>')"><i class="fas fa-print"></i></button>
						<?php } ?> 
                    </div>
                    <div class="modal-body">  
                        <?php if (isset($_GET["ATITUDE"])){?>
                            <input type="hidden" name="CODIGO" value="<?php ECHO $_GET["ATITUDE"]?>" id="CODIGO" maxlength="4" class="form-control"> 
                        <?php }else{ ?> 
                            <input type="hidden" name="CODIGO" value="0" id="CODIGO" maxlength="4" class="form-control">  
                        <?php } ?>  
                        <TD>
                            <div class="col-md-2" >  
                                <?php if (isset($_GET["ATITUDE"])){?> 
                                    <input type="hidden" READONLY REQUIRED name="CODIGO_OP" value="<?php ECHO $row["CODIGO_OP"]?>" id="CODIGO_OP" maxlength="4" class="form-control"> 
                                <?php }else{ ?>
                                    <input type="hidden" READONLY REQUIRED name="CODIGO_OP" id="CODIGO_OP" maxlength="4" class="form-control">
                                <?php } ?> 
                            </div>
                        </TD>
                        <div class="row">   
                            <TABLE>    
                            <TR>
                                <TD colspan=12>
                                    <label>Tipo de Despesa</label>  
                                    <?php if (!empty($_GET["ATITUDE"])){?> 
                                        <input type="texto" name="TITULO" value="<?php ECHO $row["TITULO"]?>" id="TITULO" maxlength="100" class="form-control"> 
                                    <?php }else{ ?>
                                        <input type="texto" name="TITULO"  id="TITULO" maxlength="100" class="form-control">
                                    <?php } ?>
                                </TD> 
                            
                                <TD>
                                    <label>Cliente</label>
                                    <select name="CLIENTE" id="CLIENTE" class="form-control" required>
                                        <option></option>
                                        <?php
                                        $SQL1="SELECT CODIGO, FANTASIA FROM EMPRESAS ORDER BY FANTASIA ASC";
                                        $tabelaX=ibase_query($conexao,$SQL1); 
                                        while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
                                            <?php if (isset($_GET["ATITUDE"])){
                                                if (TRIM($row["CLIENTE"]) <> TRIM($rowX["CODIGO"])){ ?>  
                                                    <option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["FANTASIA"]?></option>  
                                                <?php }else{ ?>
                                                    <option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["FANTASIA"]?></option>  
                                                <?php } ?>
                                            <?php }else{ ?>
                                                <option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["FANTASIA"]?></option>  
                                            <?php } 
                                        }?>  
                                    </select>
                                    
                                </TD>
                               
                            </TR>
							
                            
                            </TABLE> 
                            <div class="col-md-12">
                                <div class="progress">
                                    <?PHP 
                                    $SQLW="select * from CALCULO_TAREFAS('".$_GET["ATITUDE"]."');";
                                    $tabelaX=ibase_query($conexao,$SQLW); 
                                    $XROW=ibase_fetch_assoc($tabelaX); ?>
                                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: <?PHP ECHO $XROW["MEDIATAREFA"]?>%"><?PHP ECHO $XROW["MEDIATAREFA"]?></div>
                                </div>
                            </div> 
                        </div>  
                    </div>   
                </form> 
            </div> 
           
			<div id="documentos" class="tab-pane fade">
				<iframe frameborder=0 id="frame3" src="/financeiro2.php?CODIGO=<?PHP ECHO $_GET["ATITUDE"]?>&TABELA=financeiro" width="100%" height="1000px"></iframe>
			</div>
            </div> 
		</div> 
		</div> 
		<script>
			initSample();
		</script>
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
					<th>Código</th>
					<th>Responsável</th> 
					<th>Tipo de despesas</th>  
					<th>Ref.</th> 
					<th width=1><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
				</tr>
				</thead>
				<tfoot>
				<tr> 
					<th>Código</th>
					<th>Responsável</th> 
					<th>Tipo de despesas</th> 
					<th>Ref.</th> 
					<th width=1>Ação</th> 
				</tr> 
				</tfoot>
				<tbody> 
				<?php 
				while ($row=$open=ibase_fetch_assoc($tabela)){
				$sequencia=$row["CODIGO"];?>
				<tr> 
					<td><?php echo $row["CODIGO"]?></td>
					
                    <td><?php echo $row["NOMETECNICO"]?></td>
					<td><?php echo $row["NOMECLIENTE"]?></td>
					<td><?php echo $row["TITULO"]?></td>
					<td width=1>
						<div class="btn-group" role="group" aria-label="Basic example">
							<button class="button buttoned " title="Editar" type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
							<button class="button buttondelet" title="Deletar" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
							<button class="button buttoninfo" title="Imprimir" type="button" onclick="abrirficha_visita('<?PHP ECHO $sequencia?>')"><i class="fas fa-print"></i></button>
							
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
<?php include "rodape.php" ?>
</body> 
</html> 
