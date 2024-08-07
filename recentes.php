<?php
    error_reporting(0);
    try
    {
        $SQL1="ALTER TABLE EMPRESAS ADD CIDADE VARCHAR(40) ";
		$tabelaX=ibase_query($conexao,$SQL1);
    }
    catch (Throwable $t)
    {
        
    }

    try
    {
        $SQL1="ALTER TABLE CONTROLE_VALIDADE ADD CIDADE VARCHAR(40) ";
		$tabelaX=ibase_query($conexao,$SQL1);
    }
    catch (Throwable $t)
    {
        
    }

    try
    {
        $SQL1="ALTER TABLE CONTROLE_VALIDADE ADD FANTASIA VARCHAR(100) ";
		$tabelaX=ibase_query($conexao,$SQL1);
    }
    catch (Throwable $t)
    {
        
    }
	
	try
    {
        $SQL1="ALTER TABLE EMPRESAS ADD OBSERVACAO BLOB SUB_TYPE TEXT SEGMENT SIZE 80 CHARACTER SET ISO8859_1 ";
		$tabelaX=ibase_query($conexao,$SQL1);
    }
    catch (Throwable $t)
    {
        
    }

?>