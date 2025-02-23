
<!DOCTYPE html>
<html lang="en">
<head> 
<?php 
include "conexao2.php";
include "css.php"?>
<script> 
function alterar(indice)  
{ 
location.href="clientes.php?ATITUDE=" + indice  + "&GRUPO=" + <?PHP ECHO $_GET["GRUPO"]?>;
} 
function deletar(indice)
{ 
if (confirm("Deseja Realmente fazer essa exclusão?")==true){ 
$.post("DELETE.PHP",
{ 
  TABELA: "CLIENTES",
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
	httproc.open("get", 'user_ajax.php?EMAIL=' + document.getElementById("email").value + "&SENHA=" + document.getElementById("senha").value + "&TIPO=C");
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
<?php
$ACESSO=""; 
$ACESSO="Alteração de Dados"; 

include "controleacesso.php";
$SQL="SELECT C.CODIGO, C.NOME, C.EMAIL, (S.DESCRICAO) AS NOMESETOR, MD5, C.UNIDADE, C.SENHA, C.EMPRESA, C.NIVEL, (N.DESCRICAO) AS NOMENIVEL, C.TELEFONE, C.CELULAR, C.SETOR FROM CLIENTES C ".
"LEFT JOIN SETOR S ON (S.CODIGO=C.SETOR) ".
"LEFT JOIN NIVEL N ON (N.CODIGO=C.NIVEL) ";
$ATITUDE=$_SESSION["USUARIOX"]; 
$SQL=$SQL . " WHERE C.CODIGO=0". $_SESSION["USUARIOX"];
$tabela=ibase_query($conexao,$SQL); 
$row=ibase_fetch_assoc($tabela);
 
?>   
  
<div id="content-wrapper" class="d-flex flex-column">   
<div id="content">     
<?php include "menuh.php" ?>   
<div class="container-fluid">  
    <div class="card shadow mb-4">  
    <div class="card-header py-3 sistema2"> 
        <h6 class="m-0 font-weight-bold"><?php echo $ACESSO?></h6> 
    </div>
    <form method="post" action="cliente_dados2.php">    
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
                <input type="text" name="nome" value="<?php echo $row["NOME"]?>" id="nome" class="form-control" REQUIRED>
            <?PHP }else{ ?>
                <input type="text" name="nome" id="nome" class="form-control" REQUIRED>
            <?PHP } ?>
        </div>
        <div class="col-md-4">
            <label>Email</label>
            <?PHP if (!empty($ATITUDE)) {?>
                <input type="email" name="email" value="<?php echo $row["EMAIL"]?>" id="email" class="form-control" REQUIRED>
                <input type="hidden" name="email2" value="<?php echo $row["EMAIL"]?>" id="email2" class="form-control">
            <?PHP }else{ ?>
                <input type="email" name="email" id="email" class="form-control" REQUIRED>
            <?PHP } ?>
        </div>
        <div class="col-md-4">
            <label>Senha</label>
            <?PHP if (!empty($ATITUDE)) {?>
                <input type="password" name="senha" value="<?php echo $row["SENHA"]?>" id="senha" class="form-control" REQUIRED onblur="BUSCARUSER()">
                <input type="hidden" name="senha2" value="<?php echo $row["SENHA"]?>" id="senha2" class="form-control" onblur="BUSCARUSER()">
            <?PHP }else{ ?>
                <input type="password" name="senha" id="senha" class="form-control" REQUIRED>
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
        <div class="col-md-4">
            <label>Setor</label>
            <select name="wSETOR" id="wSETOR" class="form-control" REQUIRED>
                <?php $SQL="SELECT CODIGO, DESCRICAO FROM SETOR ";
                $tabela1=ibase_query ($conexao, $SQL);							
                while($row1 = ibase_fetch_assoc($tabela1)) {
                    if ($ATITUDE > "0"){
                        if ($row1["CODIGO"]==$row["SETOR"]){?>
                            <option value="<?PHP echo $row1["CODIGO"]?>" selected><?PHP echo $row1["DESCRICAO"]?></option>
                        <?php }else{ ?>
                            <option value="<?PHP echo $row1["CODIGO"]?>"><?PHP echo $row1["DESCRICAO"]?></option>
                        <?php }
                    } else {?>
                        <option value="<?PHP echo $row1["CODIGO"]?>"><?PHP echo $row1["DESCRICAO"]?></option>
                    <?php }
                }?>
            </select>
        </div>
        
        <div class="col-md-12">
            <label>HASH</label>
            <?PHP if (!empty($ATITUDE)) {?>
                <input type="text" name="MD5" value="<?php echo $row["MD5"]?>" id="CELULAR" Readonly class="form-control">
            <?PHP }else{ ?>
                <input type="text" name="MD5" id="MD5" class="form-control" Readonly>
            <?PHP } ?>
        </div>
    </div>
    </div> 
    <div class="modal-footer"> 
    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick='location.href="cliente_chamados"'>Cancelar</button> 
    <button type="submit" id="salvar" class="btn btn-success">Salvar mudanças</button>  
    </div> 
</form> 
    </div> 
</div>
</div> 
	<?php include "rodape.php" ?> 
</body>
</html> 
