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
$query_consultaDistribuidor = "SELECT * FROM tbldistribuidor";
$consultaDistribuidor = mysql_query($query_consultaDistribuidor, $conexionmiura) or die(mysql_error());
$row_consultaDistribuidor = mysql_fetch_assoc($consultaDistribuidor);
$totalRows_consultaDistribuidor = mysql_num_rows($consultaDistribuidor);
?>
<?php include('header.php'); ?>
<div class="col-lg-12">
<div class="panel panel-default">
                <div class="panel-heading"><h3>Distribuidores</h3></div>
                	<div class="panel-body">
                      <div class="col-lg-12">
                      
                      	<a class="btn btn-danger" href="add_distribuidor.php">Insertar Distribuidor</a> - <a class="btn btn-danger" href="view_distribuidores.php">Previsualizar Distribuidores</a> - <a class="btn btn-danger" href="index.php">Regresar</a>
                      </div>
                      <table class="table">
                        <thead>
                          		<tr>
                                	<th>
                                    	Distribuidor
                                    </th>
                                    <th>
                                    	IdDistribuidor
                                    </th>
                                    <th>
                                    	Activo
                                    </th>
                                     <th>
                                    	Previsualizar
                                    </th>
                                    <th>
                                    	Editar
                                    </th>
                                    <th>
                                    	Eliminar
                                    </th>
                                </tr>
                        </thead>
                          <tbody>
                          		<?php do { ?>
                       		    <tr>
                          		    <td>
                          		      <?php echo $row_consultaDistribuidor['strName']; ?>
                       		        </td>
                          		    
                          		    <td class="col-lg-1">
                          		      <?php echo $row_consultaDistribuidor['idDistribuidor']; ?>
                        		      </td>
                          		    
                          		    <td class="col-lg-1">
                          		      <?php echo $row_consultaDistribuidor['intActivo']; ?>
                        		      </td>
                                      <td class="col-lg-1">
                       		      	  <a href="view_distribuidor.php?coddis=<?php echo $row_consultaDistribuidor['idDistribuidor']; ?>">Previsualizar</a></td>
                          		    <td class="col-lg-1">
                          		      	Editar
                        		      </td>
                                      
                          		    <td class="col-lg-1">
                          		      	Eliminar
                        		      </td>
                        		    </tr>
                          		  <?php } while ($row_consultaDistribuidor = mysql_fetch_assoc($consultaDistribuidor)); ?>
                          </tbody>	
                      </table>
                       
                        
                        
                        
        
                        
                    
      </div>
</div>                    
</div>

<style type="text/css"> #map-canvas {width: 100%; margin: 0; padding: 0; height: 550px }</style>
<div id="map-canvas"></div>                  
</div>


<?php include('footer.php'); ?>

<?php
mysql_free_result($consultaDistribuidor);
?>
