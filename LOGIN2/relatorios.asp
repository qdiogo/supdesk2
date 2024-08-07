<!DOCTYPE html>
<html lang="pt">
	<head>
		<meta http-equiv="Content-Type" content="text/html">
			<link rel="stylesheet" href="/css/tabelarel.css">
		<style>
			.xtitulo{
				background:  #778899;
				font-size: 18px;
				color: #fff;
			}
			table{
				font-size: 15px;
			}
		</style>
	</head>
	<body>
		<!--#include virtual="CONEXAO.asp"-->
		<%
		titulo="Relatório estatístico de solicitação de exames"
		Acesso  = "Estatística por solicitação de exames"
		data1=converterdatabanco(request.form("data1"))
		data2=converterdatabanco(request.form("data2"))
		
		SQL1="SELECT INDICE, RELATORIO, CAST(SCRIPT AS VARCHAR(20000)) AS SCRIPT FROM RELATORIOS  "&_
		"WHERE INDICE=" & REQUEST.QUERYSTRING("INDICE")
		xopen wtabela, SQL1 
	
		%>
		<h3 align="center"><%=wtabela("RELATORIO")%></h3>
		<table class="table table-striped">
			<%IF REQUEST.FORM("DATA1") <> "" THEN
				Response.write "De: " & formatdatetime(REQUEST.FORM("DATA1"),2) & " até: " & formatdatetime(REQUEST.FORM("DATA2"),2)
			END IF
			IF REQUEST.FORM("ESPECIALIDADE") <> "" THEN
				Response.write "Especialidade: " & REQUEST.FORM("ESPECIALIDADE")
			END IF
			IF REQUEST.FORM("MEDICO") <> "" THEN
				Response.write "Médico: " & REQUEST.FORM("MEDICO")
			END IF
			IF REQUEST.FORM("CONVENIO") <> "" THEN
				Response.write "Convênio: " & REQUEST.FORM("CONVENIO")
			END IF%>
			<thead>
				<tr>
					<%
					xdata1=replace(WTABELA("SCRIPT"),":data1","'"&REQUEST.FORM("DATA1")&"'")
					CONSULTA=replace(xdata1,":data2","'"&REQUEST.FORM("DATA2")&"'")
					CONSULTA=replace(CONSULTA,":especialidade1","'"&REQUEST.FORM("ESPECIALIDADE")&"'")
					CONSULTA=replace(CONSULTA,":MEDICO","'"&REQUEST.FORM("MEDICO")&"'")
					CONSULTA=replace(CONSULTA,":CONVENIO","'"&REQUEST.FORM("CONVENIO")&"'")
					xopen tabela1, replace(CONSULTA, "+ 0.9","")	
					
					
					xopen WTABELA2, "SELECT TITULO FROM RELATORIOS1 WHERE INDICE=" & wtabela("INDICE") & " ORDER BY ORDEM ASC "
					DO WHILE NOT WTABELA2.EOF
					   Response.Write "<th " & alinhamento & ">" & wtabela2.fields.item("TITULO").value & "</th>"
					   WTABELA2.movenext
					loop 
					%>
				</tr>
			</thead>
			<tbody>
				<%if not tabela1.eof then
				DO WHILE NOT TABELA1.EOF
					RESPONSE.WRITE "<TR>"
						xopen WTABELA3, "SELECT CAMPO FROM RELATORIOS1 WHERE INDICE=" & wtabela("INDICE")  & " ORDER BY ORDEM ASC "
						DO WHILE NOT WTABELA3.EOF
							RESPONSE.WRITE  "<TD>" & TABELA1(""&WTABELA3("CAMPO")&"") & "</TD>"
							WTABELA3.MOVENEXT
						LOOP
					RESPONSE.WRITE "</TR>"
					TABELA1.MOVENEXT
				LOOP
				end if
				%>
			</tbody>
		</table>
	</body>
</html>
