<?PHP 
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
  if (!empty($_POST["OBSERVACAO2"])){
    $OBSERVACAO2="'".$_POST["OBSERVACAO2"]."'";
  }else{
    $OBSERVACAO2="NULL";
  } 
  if (!empty($_POST["SETOR"])){
    $SETOR="'".$_POST["SETOR"]."'";
  }else{
    $SETOR="NULL";
  } 
  
  if (!empty($_POST["SISTEMA1"])){
    $SISTEMA1="'".$_POST["SISTEMA1"]."'";
  }else{
    $SISTEMA1="NULL";
  }
  
  if (!empty($_POST["SISTEMA2"])){
    $SISTEMA2="'".$_POST["SISTEMA2"]."'";
  }else{
    $SISTEMA2="NULL";
  }
  
  if (!empty($_POST["SISTEMA3"])){
    $SISTEMA3="'".$_POST["SISTEMA3"]."'";
  }else{
    $SISTEMA3="NULL";
  }
  
  if (!empty($_POST["SISTEMA4"])){
    $SISTEMA4="'".$_POST["SISTEMA4"]."'";
  }else{
    $SISTEMA4="NULL";
  }
  if (!empty($_POST["SISTEMA5"])){
    $SISTEMA5="'".$_POST["SISTEMA5"]."'";
  }else{
    $SISTEMA5="NULL";
  }
  if (!empty($_POST["SISTEMA6"])){
    $SISTEMA6="'".$_POST["SISTEMA6"]."'";
  }else{
    $SISTEMA6="NULL";
  }
  if (!empty($_POST["SISTEMA7"])){
    $SISTEMA7="'".$_POST["SISTEMA7"]."'";
  }else{
    $SISTEMA7="NULL";
  }
  
  if (!empty($_POST["SISTEMA8"])){
    $SISTEMA8="'".$_POST["SISTEMA8"]."'";
  }else{
    $SISTEMA8="NULL";
  } 
  if (!empty($_POST["SISTEMA9"])){
    $SISTEMA9="'".$_POST["SISTEMA9"]."'";
  }else{
    $SISTEMA9="NULL";
  } 
  if (!empty($_POST["SISTEMA10"])){
    $SISTEMA10="'".$_POST["SISTEMA10"]."'";
  }else{
    $SISTEMA10="NULL";
  } 
  if (!empty($_POST["categoria"])){
    $categoria="'".$_POST["categoria"]."'";
  }else{
    $categoriaVV="NULL";
  }
  
  $UNIDADE="";
	if (!empty($_SESSION["UNIDADENEGOCIO"]))
	{
		$UNIDADE=$_SESSION["UNIDADENEGOCIO"];
	}else{
		$UNIDADE="NULL";
	}
  
 if (EMPTY($_POST["CODIGO"])) 
 { 
   $SQL="INSERT INTO REGISTRO_TAREFAS (TECNICO, CLIENTE,TITULO, RESPONSAVEL, SETOR, OBSERVACAO2,  STATUS, SISTEMA1, SISTEMA2, SISTEMA3, SISTEMA4, SISTEMA5, SISTEMA6, SISTEMA7, SISTEMA8, SISTEMA9, SISTEMA10, categoria, USUARIO1, DATA_USUARIO1, IP1, OBSERVACAO, DATA, HORA, UNIDADE) VALUES (".$TECNICO.", ".$CLIENTE.", ".$TITULO.", ".$RESPONSAVEL.", ".$SETOR.", ".$OBSERVACAO2.",  ".$STATUS.", ".$SISTEMA1.", ".$SISTEMA2.", ".$SISTEMA3.", ".$SISTEMA4.", ".$SISTEMA5.", ".$SISTEMA6.", ".$SISTEMA7.",  ".$SISTEMA8.", ".$SISTEMA9.", ".$SISTEMA10.", ".$categoria.",".$USUARIO.", '".$DATAATUAL."', '".$IP."', ".$OBSERVACAO.", ".$DATA.", ".$HORA.", ".$UNIDADE.")";
   $ENVIAR=IBASE_QUERY($conexao, $SQL);  
   
   $tabela=ibase_query($conexao,"SELECT FIRST 1 CODIGO FROM REGISTRO_TAREFAS ORDER BY CODIGO DESC"); 
   $MAXIMO=ibase_fetch_assoc($tabela);  
   header('Location: REGISTRO_TAREFAS.php?ATITUDE=' . $MAXIMO["CODIGO"] . "&data=" . $_POST["DATA"] . "&PROFISSIONAL=" . $_POST["PROFISSIONAL"]);
 }else{ 
   $SQL="UPDATE REGISTRO_TAREFAS SET CODIGO=".$CODIGO.", SISTEMA1=".$SISTEMA1.", categoria=".$categoria.", SISTEMA2=".$SISTEMA2.", SISTEMA3=".$SISTEMA3.", SISTEMA4=".$SISTEMA4.", SISTEMA5=".$SISTEMA5.", SISTEMA6=".$SISTEMA6.", SISTEMA7=".$SISTEMA7.", SISTEMA8=".$SISTEMA8.", SISTEMA10=".$SISTEMA10.", SISTEMA9=".$SISTEMA9.", TECNICO=".$TECNICO.", STATUS=".$STATUS.",  SETOR=".$SETOR.", OBSERVACAO2=".$OBSERVACAO2.",   RESPONSAVEL=".$RESPONSAVEL.", CLIENTE=".$CLIENTE.", DATA=".$DATA.", HORA=".$HORA.",OBSERVACAO=".$OBSERVACAO.", TITULO=".$TITULO." , USUARIO2=".$USUARIO.", DATA_USUARIO2='".$DATAATUAL."', IP1='".$IP."' WHERE CODIGO=" . $_POST["CODIGO"]; 
   $ENVIAR=IBASE_QUERY($conexao, $SQL); 
   header('Location: REGISTRO_TAREFAS.php?ATITUDE=' . $_POST["CODIGO"]  . "&data=" . $_POST["DATA"] . "&PROFISSIONAL=" . $_POST["PROFISSIONAL"] ); 

}   
 ?> 
