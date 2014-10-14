<?php 
if (!isset($_SESSION)) {
  session_start();
}
?>
<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_conexionmiura = "grupoextrema.net";
$database_conexionmiura = "grupoext_mapDOW";
$username_conexionmiura = "grupoext_mapDow";
$password_conexionmiura = "yo6890298.";
$conexionmiura = mysql_pconnect($hostname_conexionmiura, $username_conexionmiura, $password_conexionmiura) or trigger_error(mysql_error(),E_USER_ERROR); 
mysql_query("SET NAMES 'utf8'"); 
?>
<?php 
if (is_file("includes/funtions.php"))
{
	include("includes/funtions.php");
}
else
{
	include("../includes/funtions.php");
}
?>