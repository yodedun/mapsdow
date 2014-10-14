<?php require_once('../Connections/conexionmiura.php'); ?>

<?php

if (!isset($_SESSION)) {

  session_start();

}

$MM_authorizedUsers = "7";

$MM_donotCheckaccess = "false";



// *** Restrict Access To Page: Grant or deny access to this page

function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 

  // For security, start by assuming the visitor is NOT authorized. 

  $isValid = False; 



  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 

  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 

  if (!empty($UserName)) { 

    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 

    // Parse the strings into arrays. 

    $arrUsers = Explode(",", $strUsers); 

    $arrGroups = Explode(",", $strGroups); 

    if (in_array($UserName, $arrUsers)) { 

      $isValid = true; 

    } 

    // Or, you may restrict access to only certain users based on their username. 

    if (in_array($UserGroup, $arrGroups)) { 

      $isValid = true; 

    } 

    if (($strUsers == "") && false) { 

      $isValid = true; 

    } 

  } 

  return $isValid; 

}



$MM_restrictGoTo = "../index.php";

if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   

  $MM_qsChar = "?";

  $MM_referrer = $_SERVER['PHP_SELF'];

  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";

  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 

  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];

  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);

  header("Location: ". $MM_restrictGoTo); 

  exit;

}

?>

<?php include('header.php'); ?>

<div class="col-lg-12">

<div class="panel panel-default">

                <div class="panel-heading"><h3>Administrador</h3></div>

                	<div class="panel-body">

                        <div class="col-lg-4">

                            <div class="panel panel-default">

                                <div class="panel-heading"><h3>Paises</h3></div>

                                <div class="panel-body">

                               	<a class="btn btn-danger" href="list_paises.php">Lista de paises</a>

                                </div>

                            </div>    

                        </div>

                        <div class="col-lg-4">

                            <div class="panel panel-default">

                                	<div class="panel-heading"><h3>Regiones</h3></div>

                                	<div class="panel-body">                                	

                                    <a class="btn btn-danger" href="list_regiones.php">Lista de regiones</a>

                                    </div>

                              </div>

                        </div>

                        <div class="col-lg-4">

                            <div class="panel panel-default">

                                <div class="panel-heading"><h3>Cordenadas </h3></div>

                                <div class="panel-body">

                               	<a class="btn btn-danger" href="list_cordenadas.php">Lista Cordenadas</a>

                                </div>

                            </div>    

                        </div>

                        <div class="col-lg-4">

                            <div class="panel panel-default">

                                <div class="panel-heading"><h3>Zonas</h3></div>

                                <div class="panel-body">

                                	<a class="btn btn-danger" href="list_zonas.php">Lista zonas</a>

                                </div>

                            </div>    

                        </div>

                       

                        

        

                        

                    

                    </div>

</div>                    

</div>



<?php include('footer.php'); ?>