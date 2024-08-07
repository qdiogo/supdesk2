<?PHP 
 include "conexao.php"; 
 if (!empty($_POST["CODIGO"])){
   $CODIGO="'".$_POST["CODIGO"]."'";
 }else{
   $CODIGO="NULL";
 } 
 
 $TECNICO="'".$_SESSION["USUARIO"]."'";
 if (!empty($_POST["CLIENTE"])){
   $CLIENTE="'".$_POST["CLIENTE"]."'";
 }else{
   $CLIENTE="NULL";
 } 


  if (!empty($_POST["TITULO"])){
    $TITULO="'".$_POST["TITULO"]."'";
  }else{
    $TITULO="NULL";
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
   $SQL="INSERT INTO FINANCEIROV2 (TECNICO, CLIENTE,TITULO, USUARIO1, DATA_USUARIO1, IP1) VALUES (".$TECNICO.", ".$CLIENTE.", ".$TITULO.", ".$USUARIO.", '".$DATAATUAL."', '".$IP."')";
   $ENVIAR=IBASE_QUERY($conexao, $SQL); 
  
   
   $tabela=ibase_query($conexao,"SELECT FIRST 1 CODIGO FROM FINANCEIROV2 WHERE TECNICO=".$TECNICO." ORDER BY CODIGO DESC"); 
   $MAXIMO=ibase_fetch_assoc($tabela);  
   header('Location: FINANCEIRO.php?ATITUDE=' . $MAXIMO["CODIGO"] . "&data=" . $_POST["DATA"] . "&PROFISSIONAL=" . $_POST["PROFISSIONAL"]);
 }else{ 
   $SQL="UPDATE FINANCEIROV2 SET CLIENTE=".$CLIENTE.",  TITULO=".$TITULO." , USUARIO2=".$USUARIO.", DATA_USUARIO2='".$DATAATUAL."', IP1='".$IP."' WHERE CODIGO=" . $_POST["CODIGO"]; 
   $ENVIAR=IBASE_QUERY($conexao, $SQL); 
   header('Location: FINANCEIRO.php?ATITUDE=' . $_POST["CODIGO"]  . "&data=" . $_POST["DATA"] . "&PROFISSIONAL=" . $_POST["PROFISSIONAL"] ); 

}   
 ?> 
