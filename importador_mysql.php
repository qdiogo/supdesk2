<?php
$servername = "localhost";
$username = "root";
$password = "";
$conn = mysqli_connect("localhost","root","","idealfisio");
$TIPO="";
function tirarAcentos($string, $TIPO){

   $acentos      =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ-()/,';
   $sem_acentos  =  'AAAAAAACEEEEIIIIDNOOOOOOUUUUYBSAAAAAAACEEEEIIIIDNOOOOOOUUUYYBYRR     .';
   $string = strtr($string, utf8_decode($acentos), $sem_acentos);
	if ($TIPO=="1")
	{
	   $string = str_replace(" ","",$string);
   
	}else{
		$string = str_replace(" "," ",$string);
	}
   return utf8_decode($string);
}

$servidor = "127.0.0.1:C:\SGBD\FATURA.fdb";

	if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1')))
	die('Erro ao conectar: ' .  ibase_errmsg());


if (!empty($_GET["TIPO"]))
{
	if (($_GET["TIPO"]=="1"))
	{
		$sql = "SELECT * FROM `PACIENTE` ";
		$result = mysqli_query($conn, $sql);
		$SQLx="";
		$resultX="";
		while ($row=mysqli_fetch_assoc($result)){
		   $SQLx="INSERT INTO PACIENTE(CODIGOPAC, A_NOME,  OBSERVACAO, SEGURADO, IDENTIDADE, A_CPF, CIDADE, BAIRRO, ENDERECO, NUMERO, COMPLEMENTO, TELEFONE, CELULAR, TELEFONE3, NATURALIDADE, PAI, MAE, gaveta1, gaveta, codigo, a_codigo1, convenio, ativo) VALUES ";
		   $SQLx=$SQLx . "('".tirarAcentos(substr($row["id_paciente"],0,15),"")."','".tirarAcentos(substr($row["nome_paciente"],0,50),"")."', ".
		   "'".tirarAcentos($row["profissao_id_profissao"],"")."', ".
		   "'".tirarAcentos(substr($row["nome_paciente"],0,50),"")."', ".
		   "'".tirarAcentos(substr($row["rg_paciente"],0,15),"1")."', ".
		   "'".tirarAcentos($row["cpf_paciente"],"1")."', ".
		   "'".tirarAcentos(substr($row["cidade_paciente"],0,20),"")."', ". 
		   "'".tirarAcentos(substr($row["bairro_paciente"],0,50),"")."',  ".
		   "'".tirarAcentos(substr($row["endereco_paciente"],0,50),"")."', ".
		   "'".tirarAcentos(substr($row["numero_casa_paciente"],0,8),"")."', ".
		   "'".tirarAcentos(substr($row["complemento_paciente"],0,20),"")."', ".
		   "'".tirarAcentos($row["telefone1_paciente"],"1")."', ".
		   "'".tirarAcentos($row["telefone2_paciente"],"1")."', ".
		   "'".tirarAcentos($row["telefone3_paciente"],"1")."', ".
		   "'".tirarAcentos($row["naturalidade_paciente"],"")."', ". 
		   "'".tirarAcentos(substr($row["nomepai_paciente"],0,50),"")."', ".
		   "'".tirarAcentos(substr($row["nomemae_paciente"],0,50),"")."', 1,1,1,1,1, '".tirarAcentos(substr($row["ativo_paciente"],0,1),"")."')";
		   ECHO $SQLx;
		   $resultX = ibase_query($conexao, $SQLx);
		}
	}
	
 
	if (($_GET["TIPO"]=="2"))
	{
		$sql = "SELECT * FROM `FUNCIONARIO` ";
		$result = mysqli_query($conn, $sql);
		$SQLx="";
		$resultX="";
		while ($row=mysqli_fetch_assoc($result)){
		   $SQLx="INSERT INTO MEDICOS(A_MEDICOS, A_NOME, APELIDO, SEXO, CEP, IDENTIDADE, A_CPF, CIDADE, BAIRRO, ENDERECO, NUMERO, COMPLEMENTO, TELEFONE1, TELEFONE2, TELEFONE3,  a_cremeb, codigo, a_codigo1, ativo, A_GRUPOM) VALUES ";
		   $SQLx=$SQLx . "('".tirarAcentos(substr($row["id_funcionario"],0,40),"")."', '".tirarAcentos(substr($row["nome_funcionario"],0,40),"")."', ".
		   "'".tirarAcentos(substr($row["nome_funcionario"],0,50),"")."', ".
		   "'".tirarAcentos(substr($row["sexo_id_sexo"],0,1),"")."', ".
		   "'".tirarAcentos(substr($row["cep_paciente"],0,8),"")."', ".
		   "'".tirarAcentos(substr($row["rg_funcionario"],0,15),"1")."', ".
		   "'".tirarAcentos($row["cpf_funcionario"],"1")."', ".
		   "'".tirarAcentos(substr($row["cidade_funcionario"],0,20),"")."', ". 
		   "'".tirarAcentos(substr($row["bairro_funcionario"],0,50),"")."',  ".
		   "'".tirarAcentos(substr($row["endereco_funcionario"],0,50),"")."', ".
		   "'".tirarAcentos(substr($row["numero_casa_funcionario"],0,8),"")."', ".
		   "'".tirarAcentos(substr($row["complemento_funcionario"],0,20),"")."', ".
		   "'".tirarAcentos($row["telefone1_funcionario"],"1")."', ".
		   "'".tirarAcentos($row["telefone2_funcionario"],"1")."', ".
		   "'".tirarAcentos($row["telefone2_funcionario"],"1")."', ".
		    "'".tirarAcentos($row["numero_conselho_profissional"],"1")."', ".
		   "1,1, '".tirarAcentos(substr($row["ativo_funcionario"],0,1),"")."',1)";
		   ECHO $SQLx;
		   $resultX = ibase_query($conexao, $SQLx);
		}
	}
	
	if (($_GET["TIPO"]=="3"))
	{
		$sql = "select codigo_procedimento, convenio.descricao_convenio, descricao_procedimento, preco_convenio_procedimento, id_tabelas_convenio_procedimento from convenio_procedimento ".
				"inner join procedimento on procedimento.id_procedimento=convenio_procedimento.id_procedimento_convenio_procedimento ".
				"inner join convenio on convenio.id_convenio=convenio_procedimento.id_convenio_convenio_procedimento ".
				" where preco_convenio_procedimento > 0 AND convenio.descricao_convenio='UNIMEDNORTENORDESTE' ";
		$result = mysqli_query($conn, $sql);
		$SQLx="";
		$resultX="";
		while ($row=mysqli_fetch_assoc($result)){
		   $SQLx="INSERT INTO SERVICOS(A_CODAMB, A_NOME, A_RESUMO, A_TIPO, CH, TABELA) VALUES ";
		   $SQLx=$SQLx . "('".tirarAcentos(substr($row["codigo_procedimento"],0,8),"")."', '".tirarAcentos(substr($row["descricao_procedimento"],0,200),"")."', '".tirarAcentos(substr($row["descricao_procedimento"],0,30),"")."','H',".
		   "'".tirarAcentos(substr($row["preco_convenio_procedimento"],0,10),"")."',109)";
		   ECHO $SQLx;
		   $resultX = ibase_query($conexao, $SQLx);
		}
	}
}
?> 