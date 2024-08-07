<?php
   include "conexao.php";
   $query = "SELECT DOCUMENTO, CAMINHO, TIPO FROM DOCUMENTOS WHERE (1=1)";
   if (!empty($_GET["CODIGO"]))
   {
        $query=$query . " AND CODIGO=" . $_GET["CODIGO"];
   }
   if (!empty($_GET["GRUPO"]))
   {
        $query=$query . " AND GRUPO=" . $_GET["GRUPO"];
   }
   if (!empty($_GET["TABELA"]))
   {
        $query=$query . " AND TABELA='" . $_GET["TABELA"] . "'";
   }
   $res = ibase_query($conexao, $query);

   $registro = ibase_fetch_assoc($res, IBASE_TEXT);
   $conteudo_blob = $registro["DOCUMENTO"];
   $img_blob = imagecreatefromstring($conteudo_blob);

   // as 2 linhas abaixo criam o arquivo, salvando-o em disco
   //$arq_destino = 'foto3.jpg';
   //imagejpeg($img_blob, $arq_destino)or die('Não foi possível criar o arquivo ' . $arq_destino . '.');

   // as 2 linhas abaixo exibem o arquivo no browser
   // para obter a imagem em outro arquivo <img src="este_programa.php">
   if ($registro["TIPO"]='')
   {
        if ($registro["TIPO"]=="application/pdf")
        {
             header("Content-type: APPLICATION/PDF");
        }else{
            header("Content-type: image/jpeg");
        }
   }else{
    header("Location: /arquivos/".$registro["CAMINHO"]."");
   }
   echo $conteudo_blob;
?>