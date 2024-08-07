<?PHP 
error_reporting(0);
session_start();
if (!empty($_SESSION["CLIENTE"]))
{
	
}else{
	echo "<script>location.href='/areacliente.php';</script>";
}
?>