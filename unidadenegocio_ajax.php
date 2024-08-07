
<?PHP 
	include "conexao.php" ;
	
	$sql="SELECT CODIGO, RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE GRUPO=0" . $_GET["id"];
	$tabela= ibase_query ($conexao, $sql);
	if (!Empty($tabela))
	{
		while( $linha = ibase_fetch_assoc($tabela) ){
			echo "|" . $linha["CODIGO"] . ":" . $linha["RAZAOSOCIAL"];
		}
	}else{
		echo "|0:sem registro"; 
	}
?>