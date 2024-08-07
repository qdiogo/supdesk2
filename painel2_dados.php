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
 if (!empty($_GET["NUMERO"])){
   $NUMERO="'".$_GET["NUMERO"]."'";
 }else{
   $NUMERO="NULL";
 }
 if (!empty($_POST["DATA"])){
  $DATA="'".$_POST["DATA"]."'";
  }else{
    $DATA="NULL";
  } 
 if (EMPTY($_POST["CODIGO"])) 
 { 
   $SQL="INSERT INTO PAINEL2 (CODIGO,ASSUNTO,DESCRICAO, USUARIO, DATA, NUMERO, DATA_USUARIO1) VALUES (".$CODIGO.",".$ASSUNTO.",".$DESCRICAO.",".$_SESSION["USUARIO"].", ".$DATA.", ".$NUMERO.", '".date('Y-m-d H:i:s')."')";
 }else{ 
   $SQL="UPDATE PAINEL2 SET CODIGO=".$CODIGO.",ASSUNTO=".$ASSUNTO.",USUARIO2=".$_SESSION["USUARIO"]." , DESCRICAO=".$DESCRICAO." ,DATA=".$DATA.", DATA_USUARIO2='".date('Y-m-d H:i:s')."' WHERE CODIGO=" . $_POST["CODIGO"]; 
 }  
 $ENVIAR=IBASE_QUERY($conexao, $SQL);  
 header('Location: PAINEL.php?QUADRO=' . $_GET["QUADRO"]); 
 ?> 
