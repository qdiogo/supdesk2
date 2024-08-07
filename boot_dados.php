<?php 
 include "conexao.php"; 
 
 
 function retiraAcentos($string){
   $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
   $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
   $string = strtr($string, utf8_decode($acentos), $sem_acentos);
   $string = str_replace(" ","-",$string);
   return utf8_decode($string);
}
 
 if (!empty($_POST["CODIGO"])){
   $CODIGO="'".retiraAcentos($_POST["CODIGO"])."'";
 }else{
   $CODIGO="NULL";
 } 
 if (!empty($_POST["CONTEUDO"])){
   $CONTEUDO="'".$_POST["CONTEUDO"]."'";
 }else{
   $CONTEUDO="NULL";
 } 
 
 if (EMPTY($_POST["INDICE"])) 
 { 
   $SQL="INSERT INTO BOOT (CODIGO, CONTEUDO) VALUES (".$CODIGO.",".$CONTEUDO.")";
 }else{ 
   $SQL="UPDATE BOOT SET CODIGO=".$CODIGO.",CONTEUDO=".$CONTEUDO." WHERE INDICE='" . $_POST["INDICE"]."'"; 
 }  
 $ENVIAR=IBASE_QUERY($conexao, $SQL);  
 header('Location: BOOT.php'); 
 ?> 
