<%
	Err.Clear
	On Error Resume Next
	set conexao = CreateObject("ADODB.Connection")
    conexao.Open("DRIVER=Firebird/InterBase(r) driver;UID=SYSDBA;PWD=laisa22;DBNAME=127.0.0.1:G:\sgbd\fatura.fdb;charSet=ISO8859_1;")
	

    
    sub xopen(x, sql)
        Set x = Server.CreateObject( "ADODB.Recordset" )
        Set x = conexao.Execute( sql )

    end Sub
	
	Function ConverterDataBanco(ConDataBanco)
		ConDataBanco = Year(ConDataBanco) &"-"& Right("0"&Month(ConDataBanco),2) &"-"& Right("0"&Day(ConDataBanco),2)
		ConverterDataBanco = ConDataBanco
	End Function

%>
 <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> 