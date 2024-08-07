<?php
	$SQLE="SELECT CNPJ, RAZAOSOCIAL, TELEFONE, ENDERECO, EMAIL, CELULAR FROM EMPRESAS ";
	if (!empty($_SESSION["CNPJ"]))
	{
		$SQLE=$SQLE . " WHERE CNPJ=" . $_SESSION["CNPJ"];
	} 
	$EMP=ibase_fetch_assoc(ibase_query($conexao,$SQLE));

	$XSQLW="SELECT FIRST 1 CAMINHO, TABELA FROM DOCUMENTOS WHERE TABELA='EMPRESAS' ORDER BY CODIGO DESC "; 
	$EMPRESA=ibase_fetch_assoc(ibase_query($conexao,$XSQLW));
?>
<table>    
  <thead>
    <tr>
		<th>
			<img width="80" height="80" src="/arquivos/<?PHP ECHO $EMPRESA["CAMINHO"]?>">
			<br><br><br>
			<th>
				<h4><?PHP ECHO $EMP["RAZAOSOCIAL"]?></h4>
				<p style="font-size: 13px;  margin-top: -15px; text-align: left;">TELEFONE:<?PHP ECHO $EMP["TELEFONE"]?><br>
				   CNPJ:<?PHP ECHO $EMP["CNPJ"]?><br>
				   EMAIL:<?PHP ECHO $EMP["EMAIL"]?><br>
				   ENDEREÇO:<?PHP ECHO $EMP["ENDERECO"]?><br>
				</p>
			</th>
		</th>
	</tr>
  </thead>    
  <tbody>
     <!-- Page content -->
  </tbody>   
</table>