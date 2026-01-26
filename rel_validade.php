<html>
    <head>
        <?php 
		include "conexao.php";
		include "css.php"; ?>
        <style>
            body{
                margin-left: 20px;
                margin-right: 20px;
            }
            .xtable{
            border: 1px solid black;
            }
            tr:nth-child(even) {
            background-color: #f2f2f2;
            }
        </style>
    </head>

<body>
   <?php 
 
		$SQL="SELECT CODIGO, CLIENTE, VALIDADE, FANTASIA, CIDADE, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, EMAIL, CNPJ  FROM CONTROLE_VALIDADE WHERE (1=1)  ";
		if (!empty($_POST["data1"]))
		{
			$SQL=$SQL . " AND VALIDADE>='" . $_POST["data1"]."' AND VALIDADE<='" . $_POST["data2"]."'";
		}
		$SQL=$SQL . " ORDER BY VALIDADE ASC "; 
		$tabela=ibase_query($conexao,$SQL);?>
    
  
    
    <table class="table">
        <thead>
			<tr>
				<td><img width="400" height="100" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>"></td>
				<td colspan=3><br><h2><?php echo $_SESSION["UNIDADE"]?></h2></td>
			</tr>
			<tr>
				<td colspan=12 aling="center"><h2><center>Listagem de Licenças </center></h2></td>
			</tr>
			<tr>
				<th width=1>Código</th>
				<th>Razão Social</th>
				<th>Fantasia</th>
				<th>Validade</th> 
			</tr>
		</thead>
		<tbody>
			<?php 
				while ($row=ibase_fetch_assoc($tabela)){
				$sequencia=$row["CODIGO"];?>
				<tr> 
					<td width=1><?php echo $row["CODIGO"]?></td>
					<td><?php echo $row["CLIENTE"]?></td>
					<td><?php echo $row["FANTASIA"]?></td>
					<td><?php echo date("d/m/Y",strtotime($row["VALIDADE"]))?></td>
				</tr>  
			<?php 
			} ?> 
		</tbody>
    </table>
</body>
</html>