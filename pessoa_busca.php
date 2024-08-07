	<?php include "conexao.php"?>
	<?php
		$SQL="SELECT NOME, CODIGO,  SEXO FROM PESSOA where (1=1) "; 
		if (!empty($_GET["tipo"]))
		{
			if (($_GET["tipo"]=="C"))
			{
				$SQL=$SQL . " AND CODIGO LIKE '%".$_GET["buscar"]."%'";
			}
			
			if (($_GET["tipo"]=="N"))
			{
				$SQL=$SQL . " AND UPPER(NOME) LIKE '%".strtoupper($_GET["buscar"])."%'";
			}
		}
		$tabela=ibase_query($conexao,$SQL); 
	?>
	<table class="table table-striped">
	<thead>
		<tr>
			<th></th>
			<th>Código</th>
			<th>Nome</th>
			<th>Sexo</th>
		</tr>
	</thead>
	<tbody>
		<?php if ($tabela){
			while ($row=$open=ibase_fetch_assoc($tabela)) {?>
			<tr>
				<td class="npc">
					<button type="button" class="btn btn-success" name="botaoAlterar" id="<?php echo $row["CODIGO"]?>" onclick="Selecionar(this)">
						<span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Selecionars
					</button>
				</td>
				<td class="npc"><?php echo $row["CODIGO"]?></td>
				<td class="npe"><?php echo $row["NOME"]?></td>
				<td class="npe"><?php echo $row["SEXO"]?></td>
			</tr>
		<?php }
		}?>
	</tbody>
</table>