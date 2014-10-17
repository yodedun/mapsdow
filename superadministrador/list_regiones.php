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
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

mysql_select_db($database_conexionmiura, $conexionmiura);
$query_ConsultaCordenadas = "SELECT
	consultauno.idCordenadas,
	consultauno.strName,
	consultauno.textCordenadas,
	consultauno.intCategoria,
	cordenadasDos.strName AS namePais
FROM
	(
		SELECT
			tblCordenadas.idCordenadas,
			tblCordenadas.strName,
			tblCordenadas.textCordenadas,
			tblCordenadas.intCategoria,
			tblCordenadas.intActivo,
			tblCordenadas.intSuperpadre,
			tblCategorias.strTipo,
			tblCordenadas.strTitle
		FROM
			tblCordenadas,
			tblCategorias
		WHERE
			tblCordenadas.intCategoria = tblCategorias.idCategoria
		AND tblCordenadas.intCategoria = 2
	) AS consultauno,
	tblCordenadas AS cordenadasDos
WHERE
	consultauno.intSuperpadre = cordenadasDos.idCordenadas";
$ConsultaCordenadas = mysql_query($query_ConsultaCordenadas, $conexionmiura) or die(mysql_error());
$row_ConsultaCordenadas = mysql_fetch_assoc($ConsultaCordenadas);
$totalRows_ConsultaCordenadas = mysql_num_rows($ConsultaCordenadas);
?>
<?php include('header.php'); ?>
<div class="col-lg-12">
<div class="col-lg-12 text-right">
                       <p><a class="btn btn-danger" href="add_region.php">Insertar region</a> - <a class="btn btn-danger" href="index.php">Regresar</a></p>
 </div>
<div class="panel panel-default">
                <div class="panel-heading"><h3>Cordenadas</h3></div>
                	<div class="panel-body">
                      <div class="col-lg-12">
                      
                      	
                      </div>

                      <table class="table">
                        <thead>
                            <tr>
                              <th>
                                Id
                                </th>
                              <th>
                                Cordenada
                                </th>
                              
                                <th>
                                 Pais
                                </th>
                            
                              <th>
                                Previsualizar
                                </th>
                              <th>
                                Editar
                                </th>
                              
                              </tr>
                        </thead>
                          <tbody>
                        <?php do { ?>                          
                            <tr>
                                  <td class="col-lg-1">
                                    <?php echo $row_ConsultaCordenadas['idCordenadas']; ?>
                                    </td>
                                  
                                  <td>
                                    <?php echo $row_ConsultaCordenadas['strName']; ?>
                                  </td>
                                
                                  
                                  <td>
                                    <?php echo $row_ConsultaCordenadas['namePais']; ?>
                                  </td>
                                  
                              
                                  <td class="col-lg-1">
                                    <a href="view_cordenada.php?idCor=<?php echo $row_ConsultaCordenadas['idCordenadas']; ?>">Previsualizar</a></td>
                                  <td class="col-lg-1">
                                    <a href="edit_region.php?idCor=<?php echo $row_ConsultaCordenadas['idCordenadas']; ?>">Editar</a>
                                  </td>
                                  
                             </tr>
                        <?php } while ($row_ConsultaCordenadas = mysql_fetch_assoc($ConsultaCordenadas)); ?>                            
                        </tbody>	
                      </table>

                       
                        
                        
                        
        
                        
                    
      </div>
</div>                    
</div>
              
</div>


<?php include('footer.php'); ?>
<?php
mysql_free_result($ConsultaCordenadas);
?>
