<script>
    function mudarprof(codigo)
    {
        document.getElementById("prof").value=codigo;
    }
</script>
<?php


function dia_pascoa($a){
	//retorna a p?scoa
    if ($a<1900){$a+=1900;}
	$c = floor($a/100);
	$n = $a - (19*floor($a/19));
	$k = floor(($c - 17)/25);
	$i = $c - $c/4 - floor(($c-$k)/3) +(19*$n) + 15;
	$i = $i - (30*floor($i/30));
	$i = $i - (floor($i/28)*(1-floor($i/28))*floor(29/($i+1))*floor((21-$n)/11));
	$j = $a + floor($a/4) + $i + 2 -$c + floor($c/4);
	$j = $j - (7* floor($j/7));
	$l = $i - $j;
	$m = 3 + floor(($l+40)/44);
	$d = $l + 28 - (31*floor($m/4));
	$retorno=mktime(0, 0, 0, $m, $d-1, $a);
	return $retorno;
}

function calendario(){

	//Vari?vel de retorno do c?digo em HTML
	$retorno="";

	//Primeira linha do calend?rio
	$arr_dias=Array("Dom","Seg","Ter","Qua","Qui","Sex","Sab");

	//Deseja iniciar pelo s?bado?
	
	$SQLF="SELECT NOME, EXTRACT(DAY FROM DATA) AS DIA, EXTRACT(MONTH FROM DATA) AS MES FROM FERIADOS ";
	$tabelaF=ibase_query($conexao,$SQLF); 

	while ($rowF=ibase_fetch_assoc($tabelaF)){
		//Feriados comuns
		$feriados["".$rowF["DIA"]."-".$rowF["MES"].""]="".$rowF["NOME"]."";
	}

	
	
	//mes e ano do calendario a ser montado
	If($_GET['mes'] and $_GET['ano'])
	{
	   $mes = $_GET['mes'];
	  
	   $ano = $_GET['ano'];
	}
	else
	{
	   $mes = date("m");
	   $ano = date("Y");
	}

	//Feriados com data mutante
	$pascoa=dia_pascoa($ano);
	$feriados[date("j-n", $pascoa)]="Pascoa";
	$feriados[date("j-n", $pascoa-86400*2)]="Paixão";
	$feriados[date("j-n", $pascoa-86400*46)]="Cinzas";
	$feriados[date("j-n", $pascoa-86400*47)]="Carnaval";
	$feriados[date("j-n", $pascoa+86400*60)]="Corpus Christi";

	$cont_mes = 1; 
	if ($ini_sabado){
		$dia_semana = converte_dia(date("w", mktime(0, 0, 0, $mes, 1, $ano))); //dia da semana do primeiro dia do mes
	}else{
		//Comum
		$dia_semana = date("w", mktime(0, 0, 0, $mes, 1, $ano)); 
	}
	$t_mes = date("t", mktime(0, 0, 0, $mes, 1, $ano)); //no. total de dias no mes

	//dados do mes passado
	$dia_semana_ant = ((date("d", mktime(0, 0, 0, $mes, 0, $ano))+1)-$dia_semana); 
	$mes_ant = date("m", mktime(0, 0, 0, $mes, 0, $ano));
	$ano_ant = date("Y", mktime(0, 0, 0, $mes, 0, $ano));

	//dados do mes seguinte
	$dia_semana_post = 1;
	$mes_post = date("m", mktime(0, 0, 0, $mes, $t_mes+1, $ano));  
	$ano_post = date("Y", mktime(0, 0, 0, $mes, $t_mes+1, $ano));  

	

	//titulo do calendario
	$retorno.= "<font style=\"font-family:verdana,arial,serif;font-size:5\"><b>Calend&#225;rio: ".converte_mes($mes)."/".$ano."</b></font><br>";

	//montagem do calendario
	$retorno.= "<table><tr><td>&nbsp;</td><td>";

	$retorno.= "<table border=1 width=10 cellpadding=1 cellspacing=1 style='border-collapse: collapse' id=AutoNumber1 bordercolor=#333333>";
	//primeira linha do calendario
	$retorno.= "<tr style='background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: #fff;'   face=verdana,arial,serif>";
	for($i=0;$i<7;$i++){
		if ($i==0 || $i==6){
			//? domingo ou s?bado
			$retorno.= "<td style='background: red; color: #fff;'><font color=white face=verdana,arial,serif>$arr_dias[$i]</font></td>";
		}else{
			$retorno.= "<td><font style='background-image: linear-gradient(to right top, #504a55, #48444d, #403d46, #39373e, #323137); color: #fff;' face=verdana,arial,serif>$arr_dias[$i]</font></td>";
		}
	}
	
	$cont_cor = 0;
	While ($t_mes >= $cont_mes)
	{
	   $cont_semana = 0;
	   $retorno.= "<tr>";
	   If ($dia_semana == 7)
	   {
		  $dia_semana = 0;
	   }
	   If(($cont_cor%2)!=0) //alterna cor das linhas
	   {
		  $cor = "#F0F0F0";
	   }
	   Else
	   {
		  $cor = "#F8F8F8";
	   }
	   
	   While ($dia_semana < 7)
	   {
		  If ($cont_mes <= $t_mes)
		  {
			 If ($dia_semana == $cont_semana) //celulas de dias do mes
			 {
				$retorno.= "<td valign=top  width=50 height=20>";
                
                $dia=0;
                if ($cont_mes < "10")
                {
                    $dia="0" . $cont_mes;
                }else{
                    $dia=$cont_mes;
				}
				
				$CNPJ=$_SESSION["XLOG_DB"];
				
				if (!($conexao=ibase_connect(str_replace("'", "", $servidor), 'SYSDBA', 's@bia#:)ar@ra2021Ga','UTF8', '100', '1')))
				die('Erro ao conectar: ' .  ibase_errmsg());
				
                $SQL2="SELECT FIRST 1 CODIGO FROM MARCACAO WHERE DATA='".$_GET["ano"]."-".$_GET["mes"]."-".$dia."' and TECNICO='".$_GET["prof"]."'";
				$w_tabela=ibase_query(ibase_connect(str_replace("'", "", "ga.sytes.net/30500:F:\SGBD\SUPDESK\'$CNPJ\pessoal.fdb"), 'SYSDBA', 's@bia#:)ar@ra2021Ga','ISO8859_1', '9000', '1'),$SQL2); 
				$qtabela=ibase_fetch_assoc($w_tabela);

				$stylo="";
				
				$nome_feriado=$feriados[$cont_mes."-".((int)$mes)];
				if ($nome_feriado!=''){
					$wferiado=$wferiado . $dia."-".$nome_feriado . "<br>";
				}
				if ($nome_feriado!="")
				{
					$stylo="style='background:red;  font-size: 15px; color: white; font-weight: bold;";
				}else{
						
					if (!empty($qtabela["CODIGO"]))
					{
						
                
						$stylo="style='background:background: linear-gradient(to bottom, #000000 0%, #ffffff 100%); color: white; font-weight: bold;";
					}
				}
                    $retorno.= "<font onclick='dia(".$dia.")' color: white;' $stylo  style=''color: black;><strong>".$dia."</strong>";
               
				/************************************************************/
				/******** Conteudo do calendario, se tiver, aqui!!!! ********/ 
				/************************************************************/
				if ($nome_feriado!=""){
					//$retorno.= "<br>" . $nome_feriado;
				}
				$retorno.= "</font></td>";
				$cont_mes++;
				$dia_semana++;
				$cont_semana++;
			 }
			 Else //celulas vazias no inicio (mes anterior)
			 {
				$retorno.= "<td valign=top bgcolor=".$cor.">";
				$retorno.= "<font color=#AAAAAA face=verdana,arial,serif size=2>".$dia_semana_ant."</font>";
				$retorno.= "</td>";
				$cont_semana++;    
				$dia_semana_ant++;
			 }
		  }
		  else
		  {
				While ($cont_semana < 7) //celulas vazias no fim (mes posterior)
				{
					$retorno.= "<td valign=top bgcolor=".$cor.">";
					$retorno.= "<font color=#AAAAAA face=verdana,arial,serif size=2>".$dia_semana_post."</font>";
					$retorno.= "</td>";
					$cont_semana++;    
					$dia_semana_post++;
				}
		 break 2;   
		  }
	   }
	   $retorno.= "</tr>";
	   $cont_cor++;
	}

	$retorno.= "</table>";

	$retorno.= "</td></tr></table>";


	$retorno.= "<br>";
	$retorno.= "<b>Feriados do Mês <BR><font style=\"font-family:verdana,arial,serif;font-size:10\">" . $wferiado . "</b>";
    
	//links para mes anterior e mes posterior
	$retorno.= "<table width=20%><tr><td width=70% align=right>";
	$retorno.= "<font style=\"font-family:verdana,arial,serif;font-size:10\"><a href=".$_SERVER['PHP_SELF']."?mes=".$mes_ant."&ano=".$ano_ant." class=estilo1>".converte_mes($mes_ant)."/".$ano_ant."</a></font></td>";
	$retorno.= "<td> | </td><td colspan=6>";
	$retorno.= "<font style=\"font-family:verdana,arial,serif;font-size:10\"><a href=".$_SERVER['PHP_SELF']."?mes=".$mes_post."&ano=".$ano_post." class=estilo1>".converte_mes($mes_post)."/".$ano_post."</a></font>";
	$retorno.= "</td></tr></table>";

	//formulario para escolha de uma data
	$retorno.= "<form method=get action=".$_SERVER['PHP_SELF'].">";
	$retorno.= "<font style=\"font-family:verdana,arial,serif;font-size:10\">M&#234;s: </font><div class='col-md-2'>";
	
	//Variaveis login na pagina apolo
	$retorno.= "<input type=hidden id=prof name=prof value='".$_GET['prof']."' />";?>
    
	<?PHP 
	return $retorno;
}

Function converte_dia($dia_semana) //funcao para comecar a montar o calendario pela quarta-feira
{
   If($dia_semana == 0)
   {
      $dia_semana = 1;
   }
   ElseIf ($dia_semana == 1)
   {
      $dia_semana = 2;
   }
   ElseIf ($dia_semana == 2)
   {
      $dia_semana = 3;
   }
   ElseIf ($dia_semana == 3)
   {
      $dia_semana = 4;
   }
   ElseIf ($dia_semana == 4)
   {
      $dia_semana = 5;
   }
   ElseIf ($dia_semana == 5)
   {
      $dia_semana = 6;
   }
   ElseIf ($dia_semana == 6)
   {
      $dia_semana = 0;
   }

   return $dia_semana; 

}

Function converte_mes($mes)
{
         If($mes == 1)
         {
          $mes = "Janeiro";
         }
         ElseIf($mes == 2)
         {
          $mes = "Fevereiro";
         }
         ElseIf($mes == 3)
         {
          $mes = "Março";
         }
         ElseIf($mes == 4)
         {
          $mes = "Abril";
         }
         ElseIf($mes == 5)
         {
          $mes = "Maio";
         }
         ElseIf($mes == 6)
         {
          $mes = "Junho";
         }
         ElseIf($mes == 7)
         {
          $mes = "Julho";
         }
         ElseIf($mes == 8)
         {
          $mes = "Agosto";
         }
         ElseIf($mes == 9)
         {
          $mes = "Setembro";
         }
         ElseIf($mes == 10)
         {
          $mes = "Outubro";
         }
         ElseIf($mes == 11)
         {
          $mes = "Novembro";
         }
         ElseIf($mes == 12)
         {
          $mes = "Dezembro";
         }
         return $mes;
}

?>