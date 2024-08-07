<?php 
 include "conexao.php"; 
 if (!empty($_POST["CODIGO"])){
   $CODIGO="'".$_POST["CODIGO"]."'";
 }else{
   $CODIGO="NULL";
 } 
 if (!empty($_POST["DATA"])){
   $DATA="'".$_POST["DATA"]."'";
 }else{
   $DATA="current_date";
 } 
 if (!empty($_POST["HORA"])){
   $HORA="'".$_POST["HORA"]."'";
 }else{
   $HORA="NULL";
 } 
 if (!empty($_POST["TECNICO"])){
   $TECNICO="'".$_POST["TECNICO"]."'";
 }else{
   $TECNICO="NULL";
 } 
 if (!empty($_POST["CLIENTE"])){
   $CLIENTE="'".$_POST["CLIENTE"]."'";
 }else{
   $CLIENTE="NULL";
 } 

 
  if (!empty($_POST["STATUS"])){
    $STATUS="'".$_POST["STATUS"]."'";
  }else{
    $STATUS="NULL";
  }

  if (!empty($_POST["TITULO"])){
    $TITULO="'".$_POST["TITULO"]."'";
  }else{
    $TITULO="NULL";
  }

  if (!empty($_POST["RESPONSAVEL"])){
    $RESPONSAVEL="'".$_POST["RESPONSAVEL"]."'";
  }else{
    $RESPONSAVEL="NULL";
  }

  if (!empty($_POST["OBSERVACAO"])){
    $OBSERVACAO="'".$_POST["OBSERVACAO"]."'";
  }else{
    $OBSERVACAO="NULL";
  }
  if (!empty($_POST["DATA"])){
    $DATA="'".$_POST["DATA"]."'";
  }else{
    $DATA="current_date";
  } 
  if (!empty($_POST["HORA"])){
    $HORA="'".$_POST["HORA"]."'";
  }else{
    $HORA="NULL";
  } 
 if (EMPTY($_POST["CODIGO"])) 
 { 
   $SQL="INSERT INTO MARCACAO (TECNICO, CLIENTE,TITULO, RESPONSAVEL,  STATUS, USUARIO1, DATA_USUARIO1, IP1, OBSERVACAO, DATA, HORA) VALUES (".$TECNICO.", ".$CLIENTE.", ".$TITULO.", ".$RESPONSAVEL.",  ".$STATUS.",  ".$USUARIO.", '".$DATAATUAL."', '".$IP."', ".$OBSERVACAO.", ".$DATA.", ".$HORA.")";
   $ENVIAR=IBASE_QUERY($conexao, $SQL);  
   
   
  header('Location: MARCACAO.php?ATITUDE=' . $MAXIMO["CODIGO"] . "&data=" . $_POST["DATA"] . "&PROFISSIONAL=" . $_POST["PROFISSIONAL"]);
 }else{ 
   $SQL="UPDATE MARCACAO SET CODIGO=".$CODIGO.", TECNICO=".$TECNICO.",  STATUS=".$STATUS.",  RESPONSAVEL=".$RESPONSAVEL.", CLIENTE=".$CLIENTE.", DATA=".$DATA.", HORA=".$HORA.",OBSERVACAO=".$OBSERVACAO.", TITULO=".$TITULO." , USUARIO2=".$USUARIO.", DATA_USUARIO2='".$DATAATUAL."', IP1='".$IP."' WHERE CODIGO=" . $_POST["CODIGO"]; 
   $ENVIAR=IBASE_QUERY($conexao, $SQL); 
   header('Location: MARCACAO.php?ATITUDE=' . $_POST["CODIGO"]  . "&data=" . $_POST["DATA"] . "&PROFISSIONAL=" . $_POST["PROFISSIONAL"] ); 
   
}   
 ?> 
