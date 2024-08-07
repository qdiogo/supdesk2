<?PHP 
	//include "sessaotecnico87588834.php";

include "conexao.php"; 

 $dataURL = $_GET["image"]; 
 $dataURL = str_replace('data:image/png;base64,', '', $dataURL); 
 $dataURL = str_replace(' ', '+', $dataURL); 
 $image = base64_decode($dataURL); 
 $filename = 'assinatura'.$_GET["TIPO"].''.$_GET["GRUPO"].'sad54sad45asdsa45.png'; 
 file_put_contents('arquivos/' . $filename, $image); 

$query = "INSERT INTO DOCUMENTOS (NOME, ID, TABELA, ASSINATURA, TIPO) VALUES ('".$_GET["NOME"]."', '".$_GET["GRUPO"]."', '".$_GET["TABELA"]."', 'arquivos/".$filename."', '".$_GET["TIPO"]."')";
$prepared = ibase_prepare($conexao, $query);
if (!ibase_execute($prepared, $blob))
{
	echo "erro de insert";
	
	return 0;
}
	 else { echo "Processo concluido, caso assinatura nao atualize. por favor atualize a pagina.";}

  
  
  
?> 
