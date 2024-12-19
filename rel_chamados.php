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
	
        $SQL="SELECT M.CODIGO, M.ULTIMA_ALTERACAO, M.MONITORADO, CAST(M.FEITO AS VARCHAR(2000)) AS FEITO, (SELECT FIRST 1 DATA || ' ' || HORA FROM HISTORICO_AT_CHAMADOS WHERE CHAMADO=M.CODIGO AND ACAO='FECHADO' ORDER BY DATA DESC) AS FECHADO,  (SELECT FIRST 1 RAZAOSOCIAL FROM UNIDADENEGOCIO WHERE CODIGO=M.UNIDADENEGOCIO) AS UNIDADE2,  E.RAZAOSOCIAL, (U.RAZAOSOCIAL) AS NOMEUNIDADE, (SE.DESCRICAO) AS NOMESETOR, M.DATAHORA, M.EMAIL, M.RESPONSAVEL, CA.DESCRICAO AS NOMECATEGORIA, M.SUBCATEGORIA, S.DESCRICAO AS SUBCATEGORIANOME, CAST(CONTEUDO AS VARCHAR(20000)) AS CONTEUDO, M.CATEGORIA, M.ASSUNTO, M.EMPRESA, C.NOME, UPPER(C.SETOR) AS SETOR, M.USUARIO, (SELECT DESCRICAO FROM MANUTENCAO WHERE CODIGO=M.manutencao) AS MANUTENCAO, (T.NOME) AS NOMETECNICO, M.TECNICO, (SELECT DESCRICAO FROM CATEGORIA WHERE CODIGO=M.CATEGORIA) AS CATEGORIA, M.ASSUNTO, M.AGENDAMENTO, M.PRIORIDADE, M.STATUS FROM CHAMADOS M ".
        "LEFT JOIN EMPRESAS E ON (E.CODIGO=M.EMPRESA) ".
        "LEFT JOIN CLIENTES C ON (C.CODIGO=M.CLIENTE) ".
        "LEFT JOIN UNIDADENEGOCIO U ON (U.CODIGO=C.UNIDADE) ".
        "LEFT JOIN CATEGORIA CA ON (CA.CODIGO=M.CATEGORIA) ".
        "LEFT JOIN SUBCATEGORIAS S ON (S.CODIGO=M.SUBCATEGORIA) ".
        "LEFT JOIN SETOR SE ON (SE.CODIGO=C.SETOR) ".
        "LEFT JOIN TECNICOS T ON (T.CODIGO=M.TECNICO) WHERE (1=1) ";

        if (!empty($_POST["TIPO"])){
            if ($_POST["TIPO"]=="1")
            {
                $SQL=$SQL . " AND (M.STATUS = 'AG' AND M.TECNICO=" . $_POST["USUARIO"]. ")";
				$filtro="Agendados";
            }else if ($_POST["TIPO"]=="2"){		
                $SQL=$SQL . "AND (M.STATUS = 'F') ";
				$filtro="Fechados";
            }else if ($_POST["TIPO"]=="3"){
                $SQL=$SQL . " AND (M.STATUS='PA') ";
				$filtro="Em Pausa";
            }else if ($_POST["TIPO"]=="4"){
                $SQL=$SQL . " AND (M.TECNICO=" . $_POST["USUARIO"] . ")";
            }else{
                $SQL=$SQL . " (M.STATUS IS NULL OR M.STATUS='' OR  M.STATUS='PA' OR M.STATUS='A' OR  M.STATUS='PL' OR M.STATUS='AG')  ";
            }
			
        }else{
                $SQL=$SQL . "AND (M.STATUS <> 'F' OR  M.STATUS IS NULL) ";	
				$filtro="Em Aberto";
        }
		if (!empty($_POST["Empresa"]))
		{
			$SQL=$SQL . " AND UPPER(E.RAZAOSOCIAL) LIKE '%" . strtoupper(TRIM($_POST["Empresa"])) . "%' ";
			$Empresa=$_POST["Empresa"];
		}
		if (!empty($_SESSION["UNIDADENEGOCIO"]))
		{
			//$SQL=$SQL . " AND UNIDADE=" . $_SESSION["UNIDADENEGOCIO"];
		}
		if (!empty($_SESSION["CATEGORIA"]))
		{
			
			$SQL=$SQL . " AND CA.CODIGO=" . $_SESSION["CATEGORIA"];
			
		}
		if (!empty($_POST["usuario"]))
		{
			$SQL=$SQL . " AND UPPER(T.CODIGO) = " . strtoupper(TRIM($_POST["usuario"])) . "";
			$usuario=$_GET["usuario"];
		}
        $SQL=$SQL . " AND CAST((SELECT FIRST 1 DATA FROM HISTORICO_AT_CHAMADOS WHERE CHAMADO=M.CODIGO ORDER BY DATA DESC) AS DATE)>='".$_POST["data1"]."' AND CAST((SELECT FIRST 1 DATA FROM HISTORICO_AT_CHAMADOS WHERE CHAMADO=M.CODIGO ORDER BY DATA DESC) AS DATE)<='".$_POST["data2"]."' ";
        $SQL=$SQL . " ORDER BY E.CODIGO ASC, M.UNIDADENEGOCIO ASC, M.DATAHORA DESC";
        $tabela=ibase_query($conexao,$SQL); 

        $SQLE="SELECT CNPJ, RAZAOSOCIAL, TELEFONE, ENDERECO, FANTASIA, CNPJ,  EMAIL, CELULAR, UF, CEP, TELEFONE FROM EMPRESAS ";
        if (!empty($_SESSION["EMPRESA"])) 
        {
            $SQLE = $SQLE . " WHERE CODIGO=" . $_SESSION["EMPRESA"];
        }
        $EMP=ibase_fetch_assoc(ibase_query($conexao,$SQLE)); 
    ?>
    
   
    </table>
    <?php if ($_POST["sintetico"]!="S") {?>
    <table class="table table-bordered">
        <thead>
			<tr>
				<td colspan=10><img width="400" height="80" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>"></td>
				<td colspan=12><h2><?php echo $_SESSION["UNIDADE"]?></h2></td>
			</tr>
			<tr>
				<td colspan=12 aling="center"><h2><center>Listagem de Chamados </center></h2></td>
			</tr>
			<tr>
				<td colspan=12><h6>Intervalo: De <?php echo date("d/m/Y",strtotime($_POST["data1"]))?> Até <?php echo  date("d/m/Y",strtotime($_POST["data2"]))?>,  Status do chamado: <?php echo $filtro?> </h6></td>
			</tr>
			
			<tr>
				<td>N</td>
				<td>Assunto</td> 
				
				<td>Unidade</td>
				<td>Cliente</td>
				<td>Data / Hora</td>
				<td>Fechado em</td>
				<td>Prioridade</td>
				<td>Tecnico</td>
				<td>Status</td>
				<td>Categoria</td>
				<td>Conteúdo</td> 
				<td>Status</td> 
			</tr>
		</thead>
		<tbody>
			<?php
				while ($xtab=$open=ibase_fetch_assoc($tabela)){ ?>
				
				   <tr style="border: 1px solid black;">
						<td><?php echo $xtab["CODIGO"]?></td>        
						<td><?php echo $xtab["ASSUNTO"]?></td> 
						<td><?php echo $xtab["UNIDADE2"]?></td>        
						<td><?php echo $xtab["RAZAOSOCIAL"]?></td>
						<td><?php echo date("d/m/Y h:i",strtotime($xtab["DATAHORA"]))?></td>
						<td><?php echo date("d/m/Y h:i",strtotime($xtab["FECHADO"]))?></td>
						<td><?php echo $xtab["PRIORIDADE"]?></td>
						<td><?php echo $xtab["NOMETECNICO"]?></td>
						<td><?php echo $xtab["STATUS"]?></td>
						<td><?php echo $xtab["NOMECATEGORIA"]?></td>
						
						<td align="right">
							<?php if ($xtab["MONITORADO"]=="S") { ?>
								Aguardando Liberação
							<?php }else{ ?>
								Liberado
							<?php } ?>
						</td>

					</tr>
					<tr>
						<td COLSPAN=12>Chamado N° <?php echo $xtab["CODIGO"]?> - <?php echo $xtab["CONTEUDO"]?></td>
					</tr>
					<?PHP if (!empty($xtab["FEITO"])){?>
					<tr>
						<td COLSPAN=12 style="color:red; font-weight:bold">Resposta: <?php echo $xtab["FEITO"]?></td>
					</tr>
					<?php } ?>
			<?php } ?>
		</tbody>
    </table>
	<?php }else{?>
		<table width="100%">
			<tr>
				<td colspan=10><img width="400" height="80" class="img-rounded" src="<?PHP ECHO $_SESSION["LOGO"]?>"></td>
				<td colspan=12><h2><?php echo $_SESSION["UNIDADE"]?></h2></td>
			</tr>
			<tr>
				<td colspan=12 aling="center"><h2><center>Listagem de Chamados </center></h2></td>
			</tr>
			
			<tr>
				<th colspan=12><center>Chamados Fechados Por periodo</center></th>
			</tr>
			<tr>
				<td colspan=12><h6>Intervalo: De <?php echo date("d/m/Y",strtotime($_POST["data1"]))?> Até <?php echo  date("d/m/Y",strtotime($_POST["data2"]))?>,  Status do chamado: <?php echo $filtro?> </h6></td>
			</tr>
			<tr>
				<th>Qtde</th>
				<th>Profissional</th>
			</tr>
			<?php
				$SQL=" select COUNT(distinct CHAMADO) AS QTDE , (SELECT NOME FROM TECNICOS WHERE CODIGO=HISTORICO_AT_CHAMADOS.TECNICO) AS NOME from HISTORICO_AT_CHAMADOS
						WHERE (1=1) AND HISTORICO_AT_CHAMADOS.DATA>='".$_POST["data1"]."' AND HISTORICO_AT_CHAMADOS.DATA<='".$_POST["data2"]."' and quem='TECNICO' and ACAO='FECHADO' GROUP BY HISTORICO_AT_CHAMADOS.TECNICO
						order by   COUNT(CHAMADO) desc";
				$tabela=ibase_query($conexao,$SQL); 
				while ($xtab=$open=ibase_fetch_assoc($tabela)){ ?>
				<tr>
					<td><?php echo $xtab["QTDE"]?></td>
					<td><?php echo $xtab["NOME"]?></td>
				</tr>
			<?php } ?>
		</table>
	<?php } ?>
	
</body>
</html>