<?PHP 
 include "sessaotecnico87588834.php";
 include "conexao.php"; 
 if (!empty($_POST["CODIGO"])){
   $CODIGO="'".$_POST["CODIGO"]."'";
 }else{
   $CODIGO="NULL";
 } 
 if (!empty($_POST["NOME"])){
   $NOME="'".$_POST["NOME"]."'";
 }else{
   $NOME="NULL";
 } 
 if (!empty($_POST["NASCIMENTO"])){
   $NASCIMENTO="'".$_POST["NASCIMENTO"]."'";
 }else{
   $NASCIMENTO="NULL";
 } 
 if (!empty($_POST["ENDERECO"])){
   $ENDERECO="'".$_POST["ENDERECO"]."'";
 }else{
   $ENDERECO="NULL";
 } 
 if (!empty($_POST["BAIRRO"])){
   $BAIRRO="'".$_POST["BAIRRO"]."'";
 }else{
   $BAIRRO="NULL";
 } 
 if (!empty($_POST["CIDADE"])){
   $CIDADE="'".$_POST["CIDADE"]."'";
 }else{
   $CIDADE="NULL";
 } 
 if (!empty($_POST["UF"])){
   $UF="'".$_POST["UF"]."'";
 }else{
   $UF="NULL";
 }
 if (!empty($_POST["COMPLEMENTO"])){
  $COMPLEMENTO="'".$_POST["COMPLEMENTO"]."'";
 }else{
  $COMPLEMENTO="NULL";
 } 
 if (!empty($_POST["NUMERO"])){
  $NUMERO="'".$_POST["NUMERO"]."'";
 }else{
  $NUMERO="NULL";
 }
 if (!empty($_POST["IBGE"])){
   $IBGE="'".$_POST["IBGE"]."'";
 }else{
   $IBGE="NULL";
 } 
 if (!empty($_POST["SEXO"])){
   $SEXO="'".$_POST["SEXO"]."'";
 }else{
   $SEXO="NULL";
 } 
 if (!empty($_POST["MAE"])){
   $MAE="'".$_POST["MAE"]."'";
 }else{
   $MAE="NULL";
 } 
 if (!empty($_POST["PAI"])){
   $PAI="'".$_POST["PAI"]."'";
 }else{
   $PAI="NULL";
 } 
 if (!empty($_POST["TELEFONE"])){
   $TELEFONE="'".$_POST["TELEFONE"]."'";
 }else{
   $TELEFONE="NULL";
 } 
 if (!empty($_POST["CELULAR"])){
   $CELULAR="'".$_POST["CELULAR"]."'";
 }else{
   $CELULAR="NULL";
 } 
 if (!empty($_POST["CEP"])){
   $CEP="'".$_POST["CEP"]."'";
 }else{
   $CEP="NULL";
 } 
 if (!empty($_POST["NATURALIDADE"])){
   $NATURALIDADE="'".$_POST["NATURALIDADE"]."'";
 }else{
   $NATURALIDADE="NULL";
 } 
 if (!empty($_POST["NACIONALIDADE"])){
   $NACIONALIDADE="'".$_POST["NACIONALIDADE"]."'";
 }else{
   $NACIONALIDADE="NULL";
 } 
 if (!empty($_POST["IDENTIDADE"])){
   $IDENTIDADE="'".$_POST["IDENTIDADE"]."'";
 }else{
   $IDENTIDADE="NULL";
 } 
 if (!empty($_POST["CPF"])){
   $CPF="'".$_POST["CPF"]."'";
 }else{
   $CPF="NULL";
 } 
 if (!empty($_POST["EMAIL"])){
    $EMAIL="'".$_POST["EMAIL"]."'";
  }else{
    $EMAIL="NULL";
  }
  if (!empty($_POST["WHATSAPP"])){
    $WHATSAPP="'".$_POST["WHATSAPP"]."'";
  }else{
    $WHATSAPP="NULL";
  }
  if (!empty($_POST["PROFISSAO"])){
    $PROFISSAO="'".$_POST["PROFISSAO"]."'";
  }else{
    $PROFISSAO="NULL";
  }
  if (!empty($_POST["CNPJ"])){
    $CNPJ="'".$_POST["CNPJ"]."'";
  }else{
    $CNPJ="NULL";
  }
  if (!empty($_POST["TIPO"])){
    $TIPO="'".$_POST["TIPO"]."'";
  }else{
    $TIPO="NULL";
  }
  if (!empty($_POST["PESSOA"])){
    $PESSOA="'".$_POST["PESSOA"]."'";
  }else{
    $PESSOA="NULL";
  }
 if (EMPTY($_POST["CODIGO"])) 
 { 
   $SQL="INSERT INTO PESSOA (CODIGO,NOME,NASCIMENTO,ENDERECO,BAIRRO,CIDADE,UF,IBGE,SEXO,MAE,PAI,TELEFONE,CELULAR,CEP,NATURALIDADE,NACIONALIDADE,IDENTIDADE,CPF, NUMERO, COMPLEMENTO, EMAIL, WHATSAPP, USUARIO1, DATA_USUARIO1, IP1, PROFISSAO, CNPJ, TIPO, PESSOA) VALUES (".$CODIGO.",".$NOME.",".$NASCIMENTO.",".$ENDERECO.",".$BAIRRO.",".$CIDADE.",".$UF.",".$IBGE.",".$SEXO.",".$MAE.",".$PAI.",".$TELEFONE.",".$CELULAR.",".$CEP.",".$NATURALIDADE.",".$NACIONALIDADE.",".$IDENTIDADE.",".$CPF.",".$NUMERO.",".$COMPLEMENTO.",".$EMAIL.", ".$WHATSAPP.", ".$USUARIO.", '".$DATAATUAL."', '".$IP."', ".$PROFISSAO.", ".$CNPJ.", ".$TIPO.", ".$PESSOA.")";
 }else{ 
   $SQL="UPDATE PESSOA SET CODIGO=".$CODIGO.", EMAIL=".$EMAIL.", COMPLEMENTO=".$COMPLEMENTO.", NUMERO=".$NUMERO." ,NOME=".$NOME.",NASCIMENTO=".$NASCIMENTO.",ENDERECO=".$ENDERECO.",BAIRRO=".$BAIRRO.",CIDADE=".$CIDADE.",UF=".$UF.",IBGE=".$IBGE.",SEXO=".$SEXO.",MAE=".$MAE.",PAI=".$PAI.",TELEFONE=".$TELEFONE.",CELULAR=".$CELULAR.",CEP=".$CEP.",NATURALIDADE=".$NATURALIDADE.",WHATSAPP=".$WHATSAPP.", NACIONALIDADE=".$NACIONALIDADE.",IDENTIDADE=".$IDENTIDADE.",CPF=".$CPF.", PESSOA=".$PESSOA.", USUARIO2=".$USUARIO.", PROFISSAO=".$PROFISSAO.", CNPJ=".$CNPJ.", TIPO=".$TIPO.", DATA_USUARIO2='".$DATAATUAL."', IP1='".$IP."' WHERE CODIGO=" . $_POST["CODIGO"]; 
 }  
 $ENVIAR=IBASE_QUERY($conexao, $SQL);  
 header('Location: PESSOA.php'); 
 ?> 
