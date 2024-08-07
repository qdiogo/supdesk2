<?PHP 
error_reporting(0);
session_start();
if ((empty($_SESSION["TECNICO"]) || ($_SESSION["TECNICO"]=="")))
{
   
	echo "<script>location.href='/login.php';</script>";
}
?>