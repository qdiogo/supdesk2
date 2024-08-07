<!DOCTYPE html>
<html lang="pt">
    <head>
       

	<script>
		
		function registror(reg){
			if (confirm("Deseja Realmente fazer essa alteração?")==true){
				$.post("/atendimento/relatorio_dados.asp?ID=" +reg + "&GRUPO=<%=REQUEST.QUERYSTRING("ID")%>&TIPO=1",
				{
					CAMPO: $("#campo"+reg).val(),
					TITULO: $("#titulo"+reg).val(),
					ORDEM: $("#ordem"+reg).val()
				},
				function(data, status){
					if (status=='success'){
						location.reload();
					}
				})
			}
		}
	
		function deletar2(registro)
		{
			if (confirm("Confirma a Exclusão do Registro") == true) 
			{
				location.href="/deletar.asp?TABELA=RELATORIOS1&CHAVE=SEQUENCIA&ID=" + registro;
			}
		}
	</script>
    </head>
<body>
	<!-- #INCLUDE virtual="conexao.asp" -->
   <%
	    nometabela    = "filtro_criacao"
	    chaveprimaria = "filtro_criacao"
        Acesso        = "Construcão de prontuários"
	    titulo        = "Construcão de prontuários"
	    retorno       = "construcaopront.asp"
	    Session("Caminho") = "Cadastro > ..."

	    atitude = Request.QueryString(chaveprimaria)
    SQL1="SELECT INDICE,  CAST(SCRIPT AS VARCHAR(20000)) AS SCRIPT, RELATORIO FROM RELATORIOS  "
	xopen tabela2, SQL1 
		
    IF REQUEST.QUERYSTRING("MENU") <> "N" THEN%>
	
	<%END IF%>
    <div class="container">
		<%IF  REQUEST.QUERYSTRING("id") <> "" THEN
			 SQL1="SELECT INDICE, RELATORIO, CAST(SCRIPT AS VARCHAR(20000)) AS SCRIPT, RELATORIO FROM RELATORIOS  WHERE INDICE=" & REQUEST.QUERYSTRING("ID")
			xopen tabela3, SQL1 
			SCRIPT=tabela3("SCRIPT")
			XTITULO=tabela3("RELATORIO")
		End if%>
        <form name="<%=nometabela%>" action="/atendimento/relatorio_dados.asp?ID=<%=REQUEST.QUERYSTRING("ID")%>" method="post">
            <nav class="navbar navbar-default" style="position: relative; top:8px; right:8px;">
				<div class="container-fluid">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
							<span class="sr-only">Opções</span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
							<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<%If (atitude="0") Then%>
								Inclusão de <%=Titulo%> 
							<%Else%>
								Alteração de <%=Titulo & " - registro " & atitude%>
							<%End If%>
						</a>
					</div>
					<li style="margin-top: -15px;">
						<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
							<ul class="nav navbar-nav navbar-right">
								<%if (atitude <> "0") OR (request.querystring("INDICE") = "") then%>
									<li>
										<%if SESSION("MODULO") = "WEBMEDICAL"  THEN
												PASTA="Atendimento"
											Else
												PASTA=SESSION("MODULO")
											End if

											if Nomearquivo <> "" then
												Arquivo=NomeArquivo
											Else
												Arquivo=NomeTabela
											End if
										%>

										<button type="button" name="xincluir" title="Incluir Novo" style="position: relative; right:10px; top:8px;" id="xincluir"  Readonly class="btn btn-default" onclick="location.href='/<%=PASTA%>/relatorios/<%=Arquivo%>.asp?ID=0'">
											<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
										</button>
									</li>
								<%end if%>
								<button class=" btn-primary" title=""><i class="fas fa-calendar-alt"></i></button>
										
								<button type="button" name="voltar" id="voltar" class="btn btn-primary" style="position: relative; right:8px; top:8px;" onclick="window.location.assign('<%=retorno%>')">
									<span class="glyphicon glyphicon-arrow-left" aria-hidden="true"></span> Voltar
								</button>
							</ul>
						</div>
					</li>
				</div>
			</nav>
				<tr>
					<label>Relatório</label>
					<td width="1200px"><input type="text" class="form-control" maxlength="50" id="TITULO" name="TITULO" value="<%=XTITULO%>"></td>
				</tr>
				<br><br>
				<div class="alert alert-info">SQL DO RELATÓRIO</div>
				<textarea class="form-control" id="SCRIPT" name="SCRIPT"><%=SCRIPT%></textarea>
				<br><br><br><br><br>
			</form>
        </form>
		<%If (atitude<>"0") Then%>
			<table width="100%">
				<tr>
					<th class="cantoesquerdo">Relatório</th>
					<th class="cantodireito" COLSPAN=2><center>Ação</center></th>
				</tr>
				<%
				do while not tabela2.eof
				IF InStr(tabela2("SCRIPT"), ":data1")  > "0" THEN
					MODAL=TRUE
					DATA1=TRUE
				ELSEIF InStr(tabela2("SCRIPT"), ":especialidade")  > "0" THEN
					MODAL=TRUE
					ESPECIALIDADE=TRUE
				ELSEIF InStr(tabela2("SCRIPT"), ":convenio")  > "0" THEN
					MODAL=TRUE
					CONVENIO=TRUE
				ELSEIF InStr(tabela2("SCRIPT"), ":medico")  > "0" THEN
					MODAL=TRUE
					MEDICO=TRUE
				ELSE
					MODAL=FALSE
					DATA1=FALSE
					ESPECIALIDADE=FALSE
					CONVENIO=FALSE
					MEDICO=FALSE
				END IF%>
				<tr>
					<td width="1200px"><input type="text" class="form-control" maxlength="10" id="ordem<%=Tabela2("INDICE")%>" value="<%=Tabela2("RELATORIO")%>"></td>
					<td><a href="filtro_criacao.asp?ID=<%=Tabela2("INDICE")%>"><button class="btn btn-info" id="0"> CAMPOS </button></a></td>
					<td>
						<%if MODAL = true then%>
							<button type="button" class="btn btn-info" data-toggle="modal" data-target="#modal2<%=Tabela2("INDICE")%>"> IMPRIMIR </button>
						<%Else%>
							<a href="/relatorios.asp?indice=<%=Tabela2("INDICE")%>"><button type="button" class="btn btn-info"> IMPRIMIR </button></a>
						<%End if%>
					</td>
					<div id="modal2<%=Tabela2("INDICE")%>" class="modal fade" role="dialog">
						<form method="post" action="relatorios.asp?INDICE=<%=Tabela2("INDICE")%>">
							<div class="modal-dialog">
								<div class="modal-content">
								  <div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title alert alert-info">Filtro do Relatório</h4>
								  </div>
								  <div class="modal-body">
									<%IF DATA1 = TRUE THEN%>
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-6">
													<Strong>DE DATA</strong>   <input type="date" name="DATA1" ID="DATA1" class="form-control" value="<%=CONVERTERDATABANCO(DATE-30)%>">
												</DIV>
												<div class="col-md-6">
													<Strong>ATÉ DATA</strong>  <input type="date" name="DATA2" ID="DATA2" class="form-control" value="<%=CONVERTERDATABANCO(DATE)%>">
												</div>
											</div>
										</div>
									<%END IF%>
									<%IF ESPECIALIDADE = TRUE THEN%>
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-12">
													<label>Especialidade</label>
													<SELECT NAME="ESPECIALIDADE" VALUE="ESPECIALIDADE" class="form-control">
														<%xopen TABEALAUX, "SELECT CODESP, NOME FROM ESPECIALIDADE  ORDER BY NOME ASC "
															DO WHILE NOT TABEALAUX.EOF %>
																<option value="<%=TABEALAUX("CODESP")%>"><%=TABEALAUX("NOME")%></OPTION>
															<%TABEALAUX.Movenext
														LOOP%>
													</SELECT>
												</div>
											</div>
										</div>
									<%END IF%>
									<%IF CONVENIO = TRUE THEN%>
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-12">
													<label>Convênio</label>
													<SELECT NAME="CONVENIO" VALUE="CONVENIO" class="form-control">
														<%xopen TABEALAUX, "SELECT CONVENIO, A_NOME FROM CONVENIO ORDER BY A_NOME ASC "
															DO WHILE NOT TABEALAUX.EOF %>
																<option value="<%=TABEALAUX("CONVENIO")%>"><%=TABEALAUX("A_NOME")%></OPTION>
															<%TABEALAUX.Movenext
														LOOP%>
													</SELECT>
												</DIV>
											</div>
										</div>
									<%END IF%>
									<%IF MEDICO = TRUE THEN%>
										<div class="row">
											<div class="col-md-12">
												<div class="col-md-12">
													<label>Convênio</label>
													<SELECT NAME="MEDICO" VALUE="MEDICO" class="form-control">
														<%xopen TABEALAUX, "SELECT A_MEDICOS, A_NOME FROM MEDICOS ORDER BY A_NOME ASC "
															DO WHILE NOT TABEALAUX.EOF %>
																<option value="<%=TABEALAUX("A_MEDICOS")%>"><%=TABEALAUX("A_NOME")%></OPTION>
															<%TABEALAUX.Movenext
														LOOP%>
													</SELECT>
												</DIV>
											</div>
										</div>
									<%END IF%>
									</div>
								  <div class="modal-footer">
									<br><br><br>
									<button type="subimit" class="btn btn-success">Confirmar</button>
									<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
								  </div>
								</div>
							</div>
						</form>
					</div>
				</tr>
				<%tabela2.Movenext
				loop%>
			</table>
			<%IF  REQUEST.QUERYSTRING("id") <> "" THEN%>
			
			<div class="alert alert-info">Campos</div>
			<table width="100%">
				<tr>
					<th class="cantoesquerdo">Grupo</th>
					<th>Ordem</th>
					<th>Campo</th>
					<th>Titulo</th>
					<th class="cantodireito" colspan=2>Ação</th>
				</tr>
				<%xopen tabelar2, "SELECT SEQUENCIA, ORDEM,  CAMPO, TITULO FROM RELATORIOS1  WHERE INDICE=" & REQUEST.QUERYSTRING("ID")
				Do while not tabelar2.eof%>
				<tr>
					<td width=100><input type="text" class="form-control" maxlength="10" id="ID" Readonly value="<%=tabelar2("INDICE")%>"></td>
					<td><input type="text" class="form-control" maxlength="200" value="<%=Tabelar2("ORDEM")%>" id="ordem<%=tabelar2("SEQUENCIA")%>"></td>
					<td><input type="text" class="form-control" maxlength="200" value="<%=Tabelar2("CAMPO")%>" id="campo<%=tabelar2("SEQUENCIA")%>"></td>
					<td><input type="text" class="form-control" maxlength="200" value="<%=Tabelar2("TITULO")%>" id="titulo<%=tabelar2("SEQUENCIA")%>"></td>
					<td width=1><button class="btn btn-success" id="<%=tabelar2("SEQUENCIA")%>" onclick="registror(<%=tabelar2("SEQUENCIA")%>)"> <span class="glyphicon glyphicon-ok"></span></button></td>
					<td><button class="btn btn-danger" id="0" onclick="deletar2(<%=tabelar2("SEQUENCIA")%>)"> <span class="glyphicon glyphicon-trash"></span></button></td>
				</tr>
				<%tabelar2.Movenext
				loop%>
				<tr>
					<td width=100><input type="text" class="form-control" maxlength="10" id="ID" Readonly value="<%=REQUEST.QUERYSTRING("ID")%>"></td>
					<td><input type="text" class="form-control" maxlength="200" id="campo0"></td>
					<td><input type="text" class="form-control" maxlength="200" id="ordem0"></td>
					<td><input type="text" class="form-control" maxlength="200" id="titulo0"></td>
					<td><button class="btn btn-success" id="0" onclick="registror(0)"> <span class="glyphicon glyphicon-ok"></span></button></td>
				</tr>
			</table>
			<%END IF
		End if%>
    </div>
</body>
</html>

