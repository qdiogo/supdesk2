<?PHP 
 include "sessaotecnico87588834.php";

 include "conexao.php"; 
 if (!empty($_POST["CODIGO"])){
   $CODIGO="'".$_POST["CODIGO"]."'";
 }else{
   $CODIGO="NULL";
 } 
 if (!empty($_POST["VALOR"])){
   $VALOR="'".$_POST["VALOR"]."'";
 }else{
   $VALOR="NULL";
 } 
 if (!empty($_POST["USUARIO"])){
   $USUARIO="'".$_POST["USUARIO"]."'";
 }else{
   $USUARIO="NULL";
 } 
 if (!empty($_POST["PARAMETRO"])){
   $PARAMETRO="'".$_POST["PARAMETRO"]."'";
 }else{
   $PARAMETRO="NULL";
 } 
 if (!empty($_POST["DESCRICAO"])){
   $DESCRICAO="'".$_POST["DESCRICAO"]."'";
 }else{
   $DESCRICAO="NULL";
 } 
 if (EMPTY($_POST["CODIGO"])) 
 { 
   $SQL="INSERT INTO PARAMETROS (CODIGO,VALOR,USUARIO,PARAMETRO,DESCRICAO) VALUES (".$CODIGO.",".$VALOR.",".$USUARIO.",".$PARAMETRO.",".$DESCRICAO.")";
 }else{ 
   $SQL="UPDATE PARAMETROS SET CODIGO=".$CODIGO.",VALOR=".$VALOR.",USUARIO=".$USUARIO.",PARAMETRO=".$PARAMETRO.",DESCRICAO=".$DESCRICAO." WHERE CODIGO=" . $_POST["CODIGO"]; 
 }  
 $ENVIAR=IBASE_QUERY($conexao, $SQL);  
 header('Location: PARAMETROS.php?GRUPO=' . $USUARIO); 
 ?> 
