<?PHP 
	include "conexao.php" ;
?>
<!DOCTYPE html>
<html lang="en">
<head> 
<?php include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="TECNICOS.php?ATITUDE=" + indice;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "TECNICOS",
  CODIGO: indice,
 }, 
 function(data, status){  
   if (status=='success'){  
     location.reload(); 
   }  
  })
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

var httproc = createRequestObject();
function BUSCARUSER() {
	httproc.open("get", 'user_ajax.php?EMAIL=' + document.getElementById("email").value + "&SENHA=" + document.getElementById("senha").value + "&TIPO=T");
	httproc.onreadystatechange = xuser;
	httproc.send(null);
}

function xuser()
{
	if(httproc.readyState == 4)
	{
		var response = httproc.responseText;
		var update = new Array();
		update = response.split('|');
		if ((update[0]=='S') && (update[1]!=document.getElementById("senha2").value) && (update[2]!=document.getElementById("email2").value))
		{
			alert('Esse usuário já está sendo utilizado por outra pessoa \n O Botão salvar sera desablitado até a correção do Email ou Senha!');
			document.getElementById("salvar").disabled = true; 
		}else{
			document.getElementById("salvar").disabled = false; 
		}
	}
}
</script> 
</head> 
<body id="page-top"> 
<?PHP if (!empty($_SESSION["XNIVEL"])){
	if (($_SESSION["XNIVEL"])!="4"){
		echo "<script>alert('Você não tem acesso a essa página!');history.go(-1);</script>";
	}
}?>
<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE TECNICOS"; 
include "controleacesso.php";
$SQL="SELECT T.CODIGO, T.NOME, T.EMAIL, TODASUNIDADES, CELULAR, TELEFONE, (N.DESCRICAO) AS NOMENIVEL, CATEGORIA, COALESCE(ATIVO,'S') AS ATIVO, (S.DESCRICAO) AS NOMESETOR, T.SENHA, T.EMPRESA, NIVEL, COALESCE(PODEMONITORAR,'N') AS PODEMONITORAR FROM TECNICOS T ".
"LEFT JOIN NIVEL N ON (N.CODIGO=T.NIVEL) ".
"LEFT JOIN SETOR S ON (S.CODIGO=T.SETOR) "; 
$ATITUDE=$_SESSION["USUARIO"]; 
$SQL=$SQL . " WHERE T.CODIGO=0".$_SESSION["USUARIO"];
$tabela=ibase_query($conexao,$SQL); 
$row=$open=ibase_fetch_assoc($tabela);  
?>  
<div id="wrapper">    
	<?php include "menu.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php" ?>     
		<form method="post" action="tecnico_dados2">    
			<div class="modal-body">  
			<?php if (isset($ATITUDE)){?>  
				<input type="hidden" name="CODIGO" value="<?php ECHO $row["CODIGO"]?>" id="CODIGO" maxlength="4" class="form-control">  
			<?php }else{ ?>
				<input type="hidden" name="CODIGO" id="CODIGO" maxlength="4" class="form-control"> 
			<?php } ?>  
			<div class="row">
				<div class="col-md-4">
					<label>Nome</label>
					<?PHP if (!empty($ATITUDE)) {?>
						<input type="text" name="nome" autofocus value="<?php echo $row["NOME"]?>" id="nome" class="form-control" required>
					<?PHP }else{ ?>
						<input type="text" name="nome" autofocus id="nome" class="form-control" required>
					<?PHP } ?>
				</div>
				<div class="col-md-4">
					<label>Email</label>
					<?PHP if (!empty($ATITUDE)) {?>
						<input type="text" name="email" value="<?php echo $row["EMAIL"]?>" id="email" class="form-control" required>
						<input type="hidden" name="email2" value="<?php echo $row["EMAIL"]?>" id="email2" class="form-control">
					<?PHP }else{ ?>
						<input type="text" name="email" id="email" class="form-control" required>
					<?PHP } ?>
				</div>
				<div class="col-md-4">
					<label>Senha</label>
					<?PHP if (!empty($ATITUDE)) {?>
						<input type="password" name="senha" value="<?php echo $row["SENHA"]?>" id="senha" class="form-control" onblur="BUSCARUSER()" required>
						<input type="hidden" name="senha2" value="<?php echo $row["SENHA"]?>" id="senha2" class="form-control" onblur="BUSCARUSER()">
					<?PHP }else{ ?>
						<input type="password" name="senha" id="senha" class="form-control" onblur="BUSCARUSER()" required>
					<?PHP } ?>
				</div>
				<div class="col-md-4">
					<label>Telefone</label>
					<?PHP if (!empty($ATITUDE)) {?>
						<input type="number" name="TELEFONE" value="<?php echo $row["TELEFONE"]?>" id="TELEFONE" class="form-control">
					<?PHP }else{ ?>
						<input type="number" name="TELEFONE" id="TELEFONE" class="form-control">
					<?PHP } ?>
				</div>
				<div class="col-md-4">
					<label>Celular</label>
					<?PHP if (!empty($ATITUDE)) {?>
						<input type="number" name="CELULAR" value="<?php echo $row["CELULAR"]?>" id="CELULAR" class="form-control">
					<?PHP }else{ ?>
						<input type="number" name="CELULAR" id="CELULAR" class="form-control">
					<?PHP } ?>
				</div>
			</div>
			</div>  
			<div class="modal-footer"> 
			<button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="chamados"'>Cancelar</button> 
			<button type="submit" id="salvar" class="btn btn-success">Salvar mudanças</button>  
			</div> 
		</form>   
	  </div> 
	</div>
</div> 
	<?php include "rodape.php" ?> 
</body>
</html> 
