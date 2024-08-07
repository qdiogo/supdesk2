<?php 
 include "sessaotecnico87588834.php";
 include "conexao.php"; 
 if (!empty($_POST["CODIGO"])){
   $CODIGO="'".$_POST["CODIGO"]."'";
 }else{
   $CODIGO="NULL";
 } 
 if (!empty($_POST["ASSUNTO"])){
   $ASSUNTO="'".$_POST["ASSUNTO"]."'";
 }else{
   $ASSUNTO="NULL";
 } 
 if (!empty($_POST["DESCRICAO"])){
   $DESCRICAO="'".$_POST["DESCRICAO"]."'";
 }else{
   $DESCRICAO="NULL";
 }
 if (!empty($_POST["DATA"])){
  $DATA="'".$_POST["DATA"]."'";
  }else{
    $DATA="NULL";
  } 
 if (EMPTY($_POST["CODIGO"])) 
 { 
   $SQL="INSERT INTO QUADROS (CODIGO,ASSUNTO,DESCRICAO, USUARIO, DATA) VALUES (".$CODIGO.",".$ASSUNTO.",".$DESCRICAO.",".$_SESSION["USUARIO"].", ".$DATA.")";
 }else{ 
   $SQL="UPDATE QUADROS SET CODIGO=".$CODIGO.",ASSUNTO=".$ASSUNTO.",DESCRICAO=".$DESCRICAO.",USUARIO2=".$_SESSION["USUARIO"]." ,DATA=".$DATA." WHERE CODIGO=" . $_POST["CODIGO"]; 
 }  
 $ENVIAR=IBASE_QUERY($conexao, $SQL);  
 header('Location: QUADROS.php'); 
 ?> 
