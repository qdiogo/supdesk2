<html>
	<head>
		<link rel="stylesheet" href="/css/xcss.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	</head>
<body>
	<?php
		if (!empty($_GET["HYGT"]))
		{
			
			if ($_GET["HYGT"]=="87878765")
			{
				$servidor = "gasuporte.sytes.net/30500:F:\SGBD\SUPDESK\GA\PESSOAL.FDB";

				if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
				die('Erro ao conectar: ' .  ibase_errmsg());
				$HTMLX="";
				$SQLE="SELECT CODIGO, CLIENTE, VALIDADE, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, EMAIL, CNPJ FROM CONTROLE_VALIDADE WHERE EMAIL IS NOT NULL AND CODIGO=" . $_GET["TOKEN"];
				$VALIDADE=ibase_query($conexao,$SQLE); 
				$TR=ibase_fetch_assoc($VALIDADE);
				?>
				
				<center><img align="center" src="/img/<?PHP ECHO $_SESSION["UNIDADE"]?>" width="200px" height="200px"/></center> 
				<h2 align="center">Uma nova chave foi Gerada <br> Copie à Licença abaixo <br> Empresa: <?php echo $TR["CLIENTE"]?> <BR> Chave valida até: <?php echo date("d/m/Y",strtotime($TR["VALIDADE"]))?> </h2>
				<center><textarea type="date" name="CONTEUDO" value="<?php echo $TR["CONTEUDO"]?>" id="CONTEUDO" rows="10" cols="100%;" class="form-control" style="font-size: 18px; font-weight: bold;"><?php echo $TR["CONTEUDO"]?></textarea></center>
				<br> 
				<center><img align="center" src="/img/chave.png" width="880px" height="800px"/></center> 
			<?php } ?>
		<?PHP }ELSE{
			Header("Location: http://www.google.com.br");	
		}
	?>
</body>
</html>
