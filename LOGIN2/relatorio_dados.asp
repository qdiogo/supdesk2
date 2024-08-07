  
<!-- #INCLUDE virtual="common.asp" -->
<%Session("paginaatual") = "atendimento\TRIAGEM_dados"
nometabela    = "PRONTUARIO_PERGUNTA"
chaveprimaria = "ID_PRONT_PERG"
retorno       = "construcaopront.asp?ID_PRONT_GRUPO" &request.querystring("grupo")

timestamp = year(now) & "-" & right("0" & month(now),2) & "-" & right("0" & day(now),2) & " " & right("0" & hour(now),2) & ":" & right("0" & minute(now),2) & ":" & right("0" & second(now),2)
usuario   = Session("USUARIO")
versao    = Session("VERSAO")
ip        = Session("IP")
	TITULO=PREPARADADOS(RemoveAcentos(REQUEST.FORM("TITULO")))
	xCAMPO=PREPARADADOS(REQUEST.FORM("CAMPO"))
	SCRIPT=PREPARADADOS(REQUEST.FORM("SCRIPT"))
	XORDEM=PREPARADADOS(REQUEST.FORM("ORDEM"))
	If Request.querystring("TIPO")="1" THEN
		If Request.Querystring("ID")="0" Then
			Sql="INSERT INTO  RELATORIOS1(SEQUENCIA, INDICE, CAMPO, ORDEM, TITULO, USER1, DATAUSER1, VERSAO, IP) " &_
			 "VALUES (9999999, " &_
			 REQUEST.QUERYSTRING("GRUPO") & "," &_
			  XORDEM & "," &_
			
			 xCAMPO & "," &_
			 TITULO & "," &_
			 usuario &_
			",'" & timestamp & "'," &_
			"'" & versao & "'," &_
			"'" & ip & "')"
		Else
			Sql="UPDATE RELATORIOS1 SET " &_
			"TITULO=" & TITULO  & "," &_
			"ORDEM=" & XORDEM  & "," &_
			"CAMPO=" & xCAMPO  & "," &_
			"USER2=" & usuario & "," &_
			"DATAUSER2='"  & timestamp & "'," &_
			"VERSAO1='" & versao & "'," &_
			"IP1='"     & ip & "'" &_
			" WHERE SEQUENCIA=" & Request.querystring("ID")
		end if
		OPENRS TABELA, SQL
	
	Else
		If Request.Querystring("ID")="0" OR Request.Querystring("ID")="" Then
			Sql="INSERT INTO  RELATORIOS(INDICE, RELATORIO, SCRIPT, USER1, DATAUSER1, VERSAO, IP) " &_
			 "VALUES (9999999, " &_
			 TITULO & "," &_
			 SCRIPT & "," &_
			 usuario &_
			",'" & timestamp & "'," &_
			"'" & versao & "'," &_
			"'" & ip & "')"
			OPENRS TABELA, SQL
			ID=MaximoRegistro("RELATORIOS", "INDICE", "GEN_RELATORIO", "FATURA" )
		Else
			Sql="UPDATE RELATORIOS SET " &_
			"RELATORIO=" & TITULO  & "," &_
			"SCRIPT=" & SCRIPT  & "," &_
			"USER2=" & usuario & "," &_
			"DATAUSER2='"  & timestamp & "'," &_
			"VERSAO1='" & versao & "'," &_
			"IP1='"     & ip & "'" &_
			" WHERE INDICE=" & Request.querystring("ID")
			ID=Request.querystring("ID")
		end if
		OPENRS TABELA, SQL
	
		RESPONSE.REDIRECT "/ATENDIMENTO/RELATORIOS/FILTRO_CRIACAO.ASP?ID=" & ID
	End if
%>
  