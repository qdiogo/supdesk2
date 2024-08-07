<!DOCTYPE html>
<html lang="en">
<head> 
<?php 
include "conexao.php";
include "css.php"?>

</head> 
<body id="page-top"> 
<?php
	$ACESSO=""; 
	$ACESSO="Acessos Remotos (Salvos)"; 
	
	include "controleacesso.php";
	$SQL="SELECT * FROM GAREMOTE"; 
	$tabela=ibase_query($conexao,$SQL);  
	 
?>   
<div id="wrapper">    
	<?php include "menu.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php" ?>         
		<div class="container-fluid">  
			<div class="card shadow mb-4">  
			<div class="card-header py-3 sistema2"> 
			  <h6 class="m-0 font-weight-bold"><?php echo $ACESSO?></h6> 
			</div>
			<div class="card-body">  
			  <div class="table-responsive"> 
				<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0" style="font-size: 12px;"> 
					  <thead>  
						<tr> 
						  <th>ID</th> 
						  <th>Senha</th> 
						  <th>Targe Maquina</th>	
					  </thead>
				  <tfoot> 
					<tr> 
						<th>ID</th> 
						<th>Senha</th> 
						<th>Targe Maquina</th>	
					</tr>  
				  </tfoot>  
				  <tbody>
					<?php while ($row=$open=ibase_fetch_assoc($tabela)){  
					$sequencia=$row["CODIGO"];?>  
					<tr>  
					  <td><?php ECHO $row["ID"]?></td>
					  <td><?php ECHO $row["SENHA"]?></td>
					  <td><?php ECHO $row["NOMEMAQUINA"]?></td>
					</tr>
					<?php } ?> 
				  </tbody> 
				</table>   
			  </div> 
			</div>   
		  </div> 
		</div> 
	  </div> 
	</div>
</div> 
	<?php include "rodape.php" ?> 
</body>
</html> 
