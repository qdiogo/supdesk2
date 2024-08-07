<!DOCTYPE html>
<html lang="en">
<head> 
	<?php 
	include "conexao.php";
	include "css.php"?>
	<script>
		function dia(dia)
		{
			document.getElementById("agenda").src="marcacao.php?data=<?php echo $_GET["ano"]?>-<?php echo $_GET["mes"]?>-"+dia+"&PROFISSIONAL=" + document.getElementById("PROFISSIONAL").value;
		}
	</script>
</HEAD>
<BODY>

<?php
$ACESSO=""; 
$ACESSO="CADASTRO DE DATAS"; 

//gera calendario
?>
<?php include "calendario.php"?>
<div id="wrapper">    
	<?php include "menu.php"?>   
	<div id="content-wrapper" class="d-flex flex-column">     
	  <div id="content"> 
		<?php include "menuh.php"?>
		<div class="row">
			<div class="col-md-12">
			<table width="100%">
			<td><div class="col-md-12"><?php echo calendario();?></div></td>
			<td colspan=4>
				<div class="col-md-12">
					<label>TÉCNICOS</label>
					<?php
					$SQL="SELECT CODIGO, NOME FROM TECNICOS ";
					$tabelaSI=ibase_query($conexao,$SQL); 
					?>
						<select name="PROFISSIONAL" id="PROFISSIONAL" class="form-control" onchange='mudarprof(this.value)'>
						<OPTION SELECTED></OPTION>
						<?php while ($rowXA=$open=ibase_fetch_assoc($tabelaSI)){?>
							<?php if ($_GET["prof"]==$rowXA["CODIGO"])
							{?>
								<option value="<?php ECHO $rowXA["CODIGO"]?>" selected><?php ECHO $rowXA["CODIGO"]?>-<?php ECHO $rowXA["NOME"]?></option>  
							<?php }else{ ?>
								<option value="<?php ECHO $rowXA["CODIGO"]?>"><?php ECHO $rowXA["CODIGO"]?>-<?php ECHO $rowXA["NOME"]?></option>  
							<?php }
							?>
							
						<?php 
						}?>    
					</select>
					</div>
					<div class="col-md-12">
						<label>MÊS</label>
						<select class='form-control' name=mes>
							<?php
								For($cont=1;$cont<=12;$cont++)
								{
								if ($_GET["mes"]==$cont)
								{?>
									<option selected value=<?php echo $cont?>><?php echo converte_mes($cont)?></option>
								<?php }else{ ?>
									<option value=<?php echo $cont?>><?php echo converte_mes($cont)?></option>    
								<?php } ?>
							<?php } ?>
						</select>
					</div>
					<div class="col-md-12">
						<label>ANO</label>
						<select class='form-control' name=ano>
							<?php
								For($cont=date("Y");$cont<=date("Y")+5;$cont++) {?>
								
									<option value=<?php echo $cont?>><?php echo $cont?></option>
							<?php } ?>
						</select>
					</div>
				</div>
				<div class="col-md-12"><br>
					<button class='btn btn-success btn-lg btn-block' type=submit>Filtrar </button>
				</div>
				</form>
				</td>
				</table>
				<div  style="left: -25px;">
					<iframe src="marcacao.php" frameborder=0 id="agenda" width="100%" height="700px">
						Esse navegador n?o suporta frame!
					</iframe>
				</div>
					
			</div>
		</div>
	 
	  </div>
	</div>
</div>
<?php include "rodape.php" ?>
</BODY>

</HTML>
