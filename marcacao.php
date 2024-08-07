<!DOCTYPE html>
<html lang="en"> 
<head> 

<?php 
include "conexao.php";
include "css.php";?>
<script> 
function alterar(indice)  
{ 
location.href="MARCACAO.php?ATITUDE=" + indice + "&PROFISSIONAL=<?PHP ECHO $_GET["PROFISSIONAL"]?>&data=<?PHP ECHO $_GET["data"]?>";
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclus?o?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "MARCACAO",
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



</script> 
</head>
<body> 
<?php 
$ACESSO=""; 
$ACESSO="MAPA";
include "controleacesso.php";
 
$SQL="SELECT M.CODIGO, M.DATA,M.HORA,  M.STATUS, ".
"(SELECT NOME FROM TECNICOS WHERE CODIGO=M.TECNICO) AS NOMETECNICO,P.EMAIL, CAST(M.OBSERVACAO AS VARCHAR(2000)) AS OBSERVACAO,  M.TECNICO, M.TITULO, M.RESPONSAVEL, M.CLIENTE, ".
"(SELECT FANTASIA FROM EMPRESAS WHERE CODIGO=M.CLIENTE) AS NOMECLIENTE ".
" FROM MARCACAO M INNER JOIN EMPRESAS P ON (P.CODIGO=M.CLIENTE) WHERE M.DATA='".$_GET["data"]."' AND M.TECNICO='".$_GET["PROFISSIONAL"]."' ";
if (ISSET($_GET["ATITUDE"])) 
{
	$ATITUDE=$_GET["ATITUDE"];
    $SQL=$SQL . " AND  M.CODIGO=0". $_GET["ATITUDE"]; 
	$tabela=ibase_query($conexao,$SQL); 
	$row=$open=ibase_fetch_assoc($tabela); 
    echo "<script> window.onload=function e(){ $('#ExemploModalCentralizado').modal(); } </script>";
}else{
	$tabela=ibase_query($conexao,$SQL);
} 

	

?> 
<div id="content-wrapper" class="d-flex flex-column">   
	<div class="modal fade bd-example-modal-lg" width="1200px" id="ExemploModalCentralizado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">  
		<div class="modal-dialog modal-lg" role="document" width="1200px"> 
		<div class="modal-content" width="1200px">
			<div class="modal-header"  width="100%" style="background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: white; font-weight: bold; font-size: 70px;">  
			<h5 class="modal-title" id="TituloModalCentralizado" align="center">AGENDAMENTO - <?PHP ECHO $_GET["ATITUDE"]?></h5> 
			<button type="button" class="close" data-dismiss="modal" aria-label="Fechar"> 
				<span aria-hidden="true">&times;</span> 
			</button>
			</div> 
			<form method="post" action='MARCACAO2.php'> 
				<div class="modal-footer"> 
					<button type="button" class="btn btn-success" data-dismiss="modal" onclick='location.href=location.href="MARCACAO.php?ATITUDE=0&data=<?PHP ECHO $_GET["data"]?>&ATITUDE=<?PHP ECHO $_GET["ATITUDE"]?>"'>+</button>
					<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href=location.href="marcacao.php?data=<?PHP ECHO $_GET["data"]?>&PROFISSIONAL=<?PHP ECHO $_GET["PROFISSIONAL"]?>"'>Voltar</button>
					<button type="submit" class="btn btn-success">Salvar mudanças</button>
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
								<label>TItulo</label>  
								<?php if (!empty($_GET["ATITUDE"])){?> 
									<input type="texto" name="TITULO" value="<?php ECHO $row["TITULO"]?>" id="TITULO" maxlength="100" class="form-control"> 
								<?php }else{ ?>
									<input type="texto" name="TITULO"  id="TITULO" maxlength="100" class="form-control">
								<?php } ?>
							</TD> 
						</TR>
						<TR>
							<TD>
								<label>Data</label>  
								<?php if (!empty($_GET["ATITUDE"])){?> 
									<input type="date" name="DATA" value="<?php ECHO $row["DATA"]?>" id="DATA" maxlength="4" class="form-control"> 
								<?php }else{ ?>
									<input type="date" name="DATA" value="<?php echo formatardata($_GET["data"],2)?>" id="DATA" maxlength="4" class="form-control">
								<?php } ?>
							</TD> 
							<TD> 
								<label>Hora</label>  
								<?php if (!empty($_GET["ATITUDE"])){?> 
									<input type="time" name="HORA" value="<?php ECHO $row["HORA"]?>" id="HORA" maxlength="4" class="form-control"> 
								<?php }else{ ?>
									<input type="time" name="HORA" value="<?php ECHO date('H:i')?>" id="HORA" maxlength="4" class="form-control">
								<?php } ?> 	
							</TD>
							<TD>
								<label>Status</label>
								<select name="STATUS" id="STATUS" class="form-control">
								<?php
								$SQL1="SELECT CODIGO, NOME FROM STATUS ";
								$tabelaX=ibase_query($conexao,$SQL1); 
								while ($rowX=$open=ibase_fetch_assoc($tabelaX)){ ?>
									<?php if (isset($_GET["ATITUDE"])){
										if (TRIM($row["STATUS"]) <> TRIM($rowX["CODIGO"])){ ?>  
											<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["NOME"]?></option>  
										<?php }else{ ?>
											<option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["NOME"]?></option>  
										<?php } ?>
									<?php }else{ ?>
										<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["NOME"]?></option>  
									<?php } 
								}?>  
								</select> 
							</TD>
							<TD colspan=6>
								<label>Técnicos</label>
								<?php $SQL="SELECT CODIGO, NOME FROM TECNICOS ";
								$tabelaX=ibase_query($conexao,$SQL); ?>
								<select name="TECNICO" id="TECNICO" class="form-control" AUTOFOCUS>
									<?php while ($rowX=$open=ibase_fetch_assoc($tabelaX)){
									if (!empty($_GET["ATITUDE"])){
										if ($row["TECNICO"] <> $rowX["CODIGO"]){ ?>  
											<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["CODIGO"]?>-<?php ECHO $rowX["NOME"]?></option>  
										<?php }else{ ?>
											<option value="<?php ECHO $rowX["CODIGO"]?>" SELECTED><?php ECHO $rowX["CODIGO"]?>-<?php ECHO $rowX["NOME"]?></option>  
										<?php } ?>
									<?php }else{ 
										if ($_GET["PROFISSIONAL"]==$rowX["CODIGO"]){?>
										<option value="<?php ECHO $rowX["CODIGO"]?>" selected><?php ECHO $rowX["CODIGO"]?>-<?php ECHO $rowX["NOME"]?></option>  
									<?php 
									}else{?>
										<option value="<?php ECHO $rowX["CODIGO"]?>"><?php ECHO $rowX["CODIGO"]?>-<?php ECHO $rowX["NOME"]?></option>  
									<?php } 
									}
								}?>  
								</select>
							</TD>
						</TR>
						<TR>
						
						</TR>
						<TR>
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
							<TD colspan=12>
								<label>Responsável</label>  
								<?php if (!empty($_GET["ATITUDE"])){?> 
									<input type="texto" name="RESPONSAVEL" value="<?php ECHO $row["RESPONSAVEL"]?>" id="RESPONSAVEL" maxlength="100" class="form-control"> 
								<?php }else{ ?>
									<input type="texto" name="RESPONSAVEL"  id="RESPONSAVEL" maxlength="100" class="form-control">
								<?php } ?>
							</TD> 
						</TR>
						<br> 
						<tr>
							<td COLSPAN=12>
								<div class="card-header py-3 sistema2">
									<h6 class="m-0 font-weight-bold">Conteúdo do Agendamento</h6> 
								</div> 
								<?php if (isset($_GET["ATITUDE"])){?> 
									<TEXTAREA type="text" name="OBSERVACAO" REQUIRED rows="5" id="OBSERVACAO" maxlength="20000" class="form-control"><?php ECHO $row["OBSERVACAO"]?></TEXTAREA> 
								<?php }else{ ?>
									<TEXTAREA type="text" name="OBSERVACAO" REQUIRED rows="5" id="OBSERVACAO" maxlength="20000" class="form-control"></TEXTAREA>
								<?php } ?>   
							</td>
						</tr>
						</TABLE> 
						<div class="col-md-2">
							<div class="form-group">
								<div class="input-group">
									<?php if (isset($_GET["ATITUDE"])){?>  
										<input type="hidden" name="PROFISSIONAL" onFocus="PRX(this)" value="<?php ECHO $_GET["PROFISSIONAL"]?>" id="PROFISSIONAL" maxlength="10" class="form-control" onblur="buscarprof()">  
									<?php }else{ ?>
										<input type="hidden" name="PROFISSIONAL" value="<?php ECHO $row["PROFISSIONAL"]?>" onFocus="PRX(this)" onfocus="" id="PROFISSIONAL" maxlength="10" class="form-control" onblur="buscarprof()"> 
									<?php } ?>
								</div>
							</div>
						</div> 
					</div>  
				</div>   
			</form> 
		</div> 
		</div> 
	</div>
	<div class="container-fluid"> 
		<div class="card shadow mb-4">
		<div class="card-header py-3 sistema2">
			<h6 class="m-0 font-weight-bold"><?php echo formatardata($_GET["data"],1)?></h6> 
		</div> 
		<div class="card-body"> 
			<div class="table-responsive">
			<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 8px"> 
			<thead>
				<tr> 
					<th>CÓDIGO</th>
					<th>TÉCNICO</th> 
					<th>CLIENTE</th> 
					<th>DATA</th> 
					<th>HORA</th> 
					<th><button class="btn btn-success" type="button" onclick="alterar('0')"><i class="fas fa-plus-square"></i></button></th> 
				</tr>
				</thead>
				<tfoot>
				<tr> 
					<th>CÓDIGO</th>
					<th>TÉCNICO</th> 
					<th>CLIENTE</th> 
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
					<td><?php echo $row["CODIGO"]?><br>
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
					</td>
					<td><?php echo $row["NOMETECNICO"]?></td>
					<td><?php echo $row["NOMECLIENTE"]?></td>
					<td><?php echo formatardata($row["DATA"],1)?></td>
					<td><?php echo $row["HORA"]?></td>
					<td><?php echo $row["PROCEDIMENTONOME"]?></td>
					<td>
					<div class="btn-group" role="group" aria-label="Basic example">
						<button class="button buttoned " type="button" onclick="alterar('<?PHP ECHO $sequencia?>')"><i class="fas fa-edit"></i></button>
						<button class="button buttondelet" type="button" onclick="deletar('<?PHP ECHO $sequencia?>')"><i class="fas fa-trash-alt"></i></button>
						<button class="button buttoninfo" type="button" onclick="comprovante('<?PHP ECHO $sequencia?>')"><i class="fas fa-print"></i></button>
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
				<img height="30"  width="30" src="img/marcado.png"> Marcados
			</td>
		</table>
	</div>  
	</div>  
<?php include "rodape.php" ?>
</body> 
</html> 
