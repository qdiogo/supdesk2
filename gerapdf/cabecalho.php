<?php

$data  = $data.  "<table width='100%'>  ".
	
	"<tr> ".
	"	<td class='".$base64."' width='1%'> ".
	"		<IMG src='logo.jpg' width=125 height=80 onclick='history.back(-1);'> ".
	"	</td> ".
	"	<td align='left'> ".
	"		<table style='font-size: 10px;'> ".
	"			<tr> ".
	"				<td class='centro'><span class='titulo' >". $TabE['APELIDO']."</span></td> ".
	"				<td class='direito'>CNPJ: <span >". $TabE['CNPJ']."</span></td> ".
	"			</tr> ".
	"			<tr> ".
	"				<td class='centro'><span >". $TabE['ENDERECO']."</span></td> ".
	"				<td class='direito'>Telefone: <span >". $TabE['TELEFONE']."</span></td> ".
	"			</tr> ".
	"			<tr> ".
	"				<td class='centro'><span >". $TabE['CEP']."</span></td> ".
	"				<td class='direito'><span ></span></td> ".
	"			</tr> ".
	"			<tr> ".
	"				<td class='centro'><span >". $TabE['CIDADE']."-". $TabE['UF']."</span></td> ".
	"				<td class='direito'><span></span></td> ".
	"			</tr> ".
	"		</table> ".
	"	</td> ".
	"</tr> ".
    "</table> ";
	
?>