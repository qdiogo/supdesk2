<?php $data = $data . ' <table> '.
	"	<tr> ".
	"		<td><H1 style='font-weight: bold;'>FICHA DE CLASSIFICAÇÃO DE RISCO</H1></TD> ".
	"	</tr> ".
	"</table> ".
	"<table> ".
	"	<tr> "; 
			$data = $data . "<td class='border' width=260>Nome Paciente<BR><span> ". $Tabela['CODIGOPAC'] . '-' . $Tabela['NOMEPACIENTE']."</span></td>"  ; 
			$data = $data . "<td class='border'>Data - Hora<BR><span>".  date('d/mm/Y',strtotime($Tabela['A_DATAFAT'])) . '-' . date('H:i:s',strtotime($Tabela['A_HORA']))."</span></td> "; 
			$data = $data . "<td class='border'>" ; ?> 
             
            <?php
                $wsql='SELECT DATAUSER1, DATAUSER2 FROM CPSOBS WHERE CODIGOCPS=' .$Tabela['CODIGOCPS'];

                $tabela2W= ibase_query ($conexao, $wsql);
                $CPSOBS=ibase_fetch_assoc($tabela2W);

				if (!empty($CPSOBS)) {
					if (!empty($CPSOBS)) { 
						$data = $data . "Inicio Data/Hora:<span><BR><STRONG>".  date('d/mm/Y',strtotime($CPSOBS['DATAUSER1'])) . "/" .  date('H:i:s',strtotime($CPSOBS['DATAUSER1'])). "</STRONG></span>";
                    } 
                }
				$data = $data . "</td>";
				$data = $data . "<td class='border' width=280>"; ?>
					<?php if (!empty($CPSOBS['DATAUSER2'])) { 
						$data = $data . "Alteração Data/Hora:<span><BR><STRONG>".  date('d/mm/Y',strtotime($CPSOBS['DATAUSER2'])) . "/".  date('H:i:s',strtotime($CPSOBS['DATAUSER2']))."</STRONG></span>";
					} ?>
			
            <?php $data = $data . "</td>";
			$data = $data . "<td class='border'>Atendimento<BR><span>".  $Tabela['CODIGOCPS']."</span></td>"; ?>
		<?php $data = $data . " </tr> ".
	"</table> ".
	"<table>  ".
	"	<tr> ".
	"		<td class='border'>Cartão Nacional de Saúde(CNS]<BR><span>".  $Tabela['MATRICULA']."</span></td> ".
	"		<td class='border'>Documento<BR><span>".  $Tabela['IDENTIDADE']."</span></td> ".
	"		<td class='border'>Data de Nascimento<BR><span>".  $Tabela['NASC']  ."</span></td> ".
	"	</tr> ".
	"</table> ".
	"<table>  ".
	"	<tr> ".
	"		<td class='border'>Nome da Mãe<BR><span>".  $Tabela['MAE'] ."</span></td> ".
	"		<td class='border'>Telefone de Contato<BR><span>".  $Tabela['TELEFONE']."</span></td> ".
	"		<td class='border'>Idade<BR><span>". $Tabela['NASC']."</span></td> ".
	"	</tr> ".
	"</table> ".

	"<table>  ".
	"	<tr> ".
	"		<td class='border'>Endereço<BR><span>".  $Tabela['ENDERECO'] ."</span></TD> ".
	"		<td class='border'>Número<BR><span>".  $Tabela['NUMERO']."</span></TD> ".
	"		<td class='border'>Bairro<BR><span>".  $Tabela['BAIRRO'] ."</span></TD> ".
	"	</tr> ".
	"</table> ".
	
	"<table> ".
	"	<tr> ".
	"		<td class='border'>Cidade/UF<BR><span>". $Tabela['CIDADE'] . '/' . $Tabela['UF'] ."</span></TD> ".
	"		<td class='border'>CEP<BR><span>".  $Tabela['CEP']."</span></td> ".
	"		<td class='border'>Periodo do Atendimento</td> ".
	"	</tr> ".
	"</table> ".
	"<table>  ".
	"	<tr> ".
	"		<td class='border'>CID<br><span>".  $Tabela['A_CID'] . ' - ' . $Tabela['NOMECID'] ."</span></td> ".
	"		<td class='border'>Código do Serviço<br><span>".  $Tabela['GRUPOSUS'] . $Tabela['PRINCIPAL'] ."</span></td> ".
	"	</tr> ".
    "</table> " .
      "<table> ".
	 "	<tr> ".
	 "		<td class='border'>Entrada<br>Data:<span>".  date('d/mm/Y',strtotime($Tabela['A_DATAFAT'])) ."</span>  Hora:<span>". date('H:i:s',strtotime($Tabela['A_HORA'])) ."</span></td> ".
     "		<td class='border'>Saida<br>Data:<span>
             
               </table>".
   

	      "<table> ".
          "	<tr>".
        "		<td class='border'>Nome do Profissional Assistente<br><span>". $Tabela['NOMEPROFISSIONAL']."</span></td>".
         "		<td class='border>".  $Tabela['TIPOCONSELHO']."  <br><span>".   $Tabela['A_CREMEB']. "</span></td>".
        "		<td class='border'>U.F.<br><span>". $Tabela['UFCREMEB']. " </span></td>".
         "	</tr>".
          "</table>".
	
	     "<h3>Sinais Vitais</h3> ".
	    "<table> ".
	    "	<tr> ".
	    "		<td class='border'>PA(mmHg]<BR><span class='fontmaior'>".  $Tab['PA']."</span></td> ".
	    "		<td class='border'>Fc(bpm]<BR><span class='fontmaior'>".  $Tab['FC1']."</span></td> ".
	    "		<td class='border'>Fr(ipm]<BR><span class='fontmaior'><strong>".  $Tab['RF']."</span></td> ".
	    "		<td class='border'>Spo2(%]<BR><span class='fontmaior'>".  $Tab['SP02']."</span></td> ".
	    "	</tr> ".
	    "	<tr> ".
        "		<td class='border'>Temp(Cº]<BR><span class='fontmaior'>".  $Tab['TEMP']."</span></td> ".
        "		<td class='border'>HTG(mg/dl]<BR><span class='fontmaior'>".  $Tab['HTG']."</span></td> ".
        "		<td class='border'>Peso(Kg]<BR><span class='fontmaior'>".  $Tab['PESO']."</span></td> ".
        "		<td class='border'>Altura(cm]<BR><span class='fontmaior'>".  $Tab['ALTURA']."</span></td> ".
        "	</tr> ".
        "</table> ".
    
	
        "<h3><strong>Sintoma do paciente</strong></h3>".
        "<strong>".  $Tab['CG_SINTOMA']."</strong>".
	
        "<h3><strong>Medicação em Uso</strong></h3>".
        "<strong>".  $Tab['CG_MEDICACAOUSO']."</strong>".
	
        "<h3 class='w_med'><strong>Alergia Medicamentosa</strong></h3>".
        "<strong class='w_med'>".  $Tab['CG_ALERGIA']."</strong>".

        "<h3>Habito de Vida</h3>".
        "<table>".
		"<tr>".
        "<td class='border'>Tabagismo<BR><SPAN> ";
            if  ($Tab['CG_HABITOVIDA']=='S') {
                $data = $data .  'SIM';
           }else{ 
             $data = $data .  'NÃO'; 
           } 
           $data = $data . "   </span>
        </td> ". 
            "	<td class='border'>Etilismo<BR><SPAN> ";
                if  ($Tab['HABITOVIDA2']=='S') {
                    $data = $data .  'SIM';
                }else{ 
                    $data = $data .  'NÃO'; 
                } 
                $data = $data . "    </span></td> ".
                "<td class='border'>Drogas ilícitas<BR> ".
                 "<SPAN> "; ?>
                        <?php if ($Tab['HABITOVIDA2']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } 
                        $data = $data . "</span> ".
                         "</td> ".
                         "	<td class='border'>Alcoolismo<BR><SPAN> ";
                             if ($Tab['HABITOVIDA3']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; }  
                        $data = $data . "</span></td> ".
                        "	<td class='border'> " .
                          "Classificação Risco</br>";
                ?>
				<?php if  ($Tabela['GRAVIDADE']=='Z') { ?>
                    <?php $data = $data . "<center><img src='/figuras1/azul1.png' width='40' height='40'></center><strong><center>Azul</center></strong> " ?>
				<?php }else if ($Tabela['GRAVIDADE']=='E') { ?>
					<?php $data = $data . " <center><img src='/figuras1/verde1.png' width='40' height='40'></center><strong><center>Verde</center></strong> " ?>
                <?php } elseif ($Tabela['GRAVIDADE']=='A') { ?>
				    <?php $data = $data . " <center><img src='/figuras1/amarelo1.png' width='40' height='40'></center><strong><center>Amarelo</center></strong> " ?>
                <?php } else if ($Tabela['GRAVIDADE']=='L') { ?>
				    <?php $data = $data . " <center><img src='/figuras1/laranja1.png' width='40' height='40'></center><strong><center>Laranja</center></strong> " ?>
                <?php } else if ($Tabela['GRAVIDADE']=='O') { ?>
					<?php $data = $data . " <center><img src='/figuras1/vermelho1.png' width='40' height='40'></center><strong><center>Vermelho</center></strong> " ?>
                <?php } else if ($Tabela['GRAVIDADE']=='B') { ?>
					<?php $data = $data . " <center><img src='/figuras1/branco1.png' width='40' height='40'></center><strong><center>Branco</center></strong> " ?>
                <?php } ?>
                <?php $data = $data ." </td> "; ?>
                <?php $data = $data . "<td class='border'> "; ?>
				<?php $data = $data . "Escala de dor<br> "; ?>
				<?php if ($Tab['CG_ESCALADEDOR']=='0') { ?>
					<?php $data = $data . "<img src='/figuras1/dor0.png'><br><span>Sem dor</span>"; ?>
                 <?php } else if ($Tab['CG_ESCALADEDOR']=='1') { ?>
					<?php $data = $data . "<img src='/figuras1/dor1.png'><br><span>Dor leve</span>"; ?>
                    <?php } else if ($Tab['CG_ESCALADEDOR']=='2') { ?>
                        <?php $data = $data . "<img src='/figuras1/dor2.png'><br><span>Pequena dor</span>"; ?>
                    <?php } else if ($Tab['CG_ESCALADEDOR']=='3') { ?>
                        <?php $data = $data . "<img src='/figuras1/dor3.png'><br><span>Dor média</span>"; ?>
                    <?php } else if ($Tab['CG_ESCALADEDOR']=='4') { ?>
                        <?php $data = $data . "<img src='/figuras1/dor4.png'><br><span>Dor Intensa</span>"; ?>
                    <?php } else if ($Tab['CG_ESCALADEDOR']=='5') { ?>
                        <?php $data = $data . "<img src='/figuras1/dor5.png'><br><span>Insuportável</span>"; ?>
                    <?php } ?>
                    <?php $data = $data . "</td> ".
		"</tr>  ".
        "</table>  ".
        "<h3>Cormobidades</h3>  ".
        "<table>  "?>
    <?php $data = $data . "<tr> "; ?>
        <?php $data = $data . "<td class='border'>HAS<BR>"; ?>
                <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['HAS']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . "</td>"; ?>
			
                    <?php $data = $data . "<td class='border'>DM<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['DM']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>ICC<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['ICC']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>ARRITIMIA<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['ARRITIMIA']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>AVCP<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['AVCP']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>IAMp<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['IAMP']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>
                    <?php $data = $data . "</tr>"; ?>
					<?php $data = $data . "<tr>"; ?>
					<?php $data = $data . "<td class='border'>DLP<BR>"; ?>
					<?php $data = $data . "<SPAN>"; ?>
					<?php if ( $Tab['DLP']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
					<?php $data = $data . "</span>"; ?>
					<?php $data = $data . " </td>"; ?>
            
           	 		<?php $data = $data . "<td class='border'>TVD<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['TVD']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>DPOC<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['DPOC']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>EPLEPSIA<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['EPLEPSIA']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>DEPRESSAO<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['DEPRESSAO']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>

                    <?php $data = $data . "<td class='border'>HIV<BR>"; ?>
                    <?php $data = $data . "<SPAN>"; ?>
                    <?php if ( $Tab['HIV']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
                    <?php $data = $data . "</span>"; ?>
                    <?php $data = $data . " </td>"; ?>
                    <?php $data = $data . ""; ?>
		<?php $data = $data . "<tr>"; ?>
            <?php $data = $data . "<td class='border'>Asma<BR>"; ?>
            <?php $data = $data . "<SPAN>"; ?>
            <?php if ( $Tab['ASMA']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
            <?php $data = $data . "</span>"; ?>
            <?php $data = $data . " </td>"; ?>
            <?php $data = $data . ""; ?>
            
            <?php $data = $data . "<td class='border'>Ins. Renal<BR>"; ?>
            <?php $data = $data . "<SPAN>"; ?>
            <?php if ( $Tab['INSUFICIENCIARENAL']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
            <?php $data = $data . "</span>"; ?>
            <?php $data = $data . " </td>"; ?>
            <?php $data = $data . ""; ?>

            <?php $data = $data . "<td class='border'>CA/Neoplasia<BR>"; ?>
            <?php $data = $data . "<SPAN>"; ?>
            <?php if ( $Tab['CA']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
            <?php $data = $data . "</span>"; ?>
            <?php $data = $data . " </td>"; ?>
            <?php $data = $data . ""; ?>

            <?php $data = $data . "<td class='border'>Deficiência Mental<BR>"; ?>
            <?php $data = $data . "<SPAN>"; ?>
            <?php if ( $Tab['DEFMENTAL']=='S') { $data = $data .  'SIM'; }else{ $data = $data .  'NÃO'; } ?>
            <?php $data = $data . "</span>"; ?>
            <?php $data = $data . " </td>"; ?>
            <?php $data = $data . ""; ?>

            <?php $data = $data . " "; ?>
		 <?php $data = $data . "<tr> "; ?>
         <?php $data = $data . "<td colspan=6> "; ?>
            <?php $wsql = $data . $Tab['OUTROS'] . "</td> "; ?>
            <?php $data = $data . "</tr> "; ?>
            <?php $data = $data . "</table> "; ?>
            <?php $data = $data . "<table> "; ?>
            <?php $data = $data . "<td><P class='centro'>_______________________________________________<BR>Assinatura Profissional</P></td>"; ?>
		 <?php $data = $data . "<td><P class='centro'>_______________________________________________<BR>Assinatura do Paciente</P></td>"; ?>
         <?php $data = $data . "</table> "; ?>
	
         <?php $data = $data . "</body> "; ?>
         <?php $data = $data . "</html> "; 
		$pagina= $pagina + 1;?>