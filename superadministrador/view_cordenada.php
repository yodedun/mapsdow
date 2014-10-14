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

$Idcor_consultacordenada = "0";
if (isset($_GET['idCor'])) {
  $Idcor_consultacordenada = $_GET['idCor'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultacordenada = sprintf("SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor FROM tblCordenadas , tblCategorias WHERE tblCordenadas.idCordenadas = %s AND tblCordenadas.intCategoria = tblCategorias.idCategoria", GetSQLValueString($Idcor_consultacordenada, "int"));
$consultacordenada = mysql_query($query_consultacordenada, $conexionmiura) or die(mysql_error());
$row_consultacordenada = mysql_fetch_assoc($consultacordenada);
$totalRows_consultacordenada = mysql_num_rows($consultacordenada);

 $namepais = $row_consultacordenada['strName']; ?>

<?php include('header.php'); ?>
<div class="col-lg-12">
<div class="col-lg-12 text-right">
                       <p><a class="btn btn-danger " href="javascript:window.history.go(-1);">Regresar</a></p>
                      </div>
<div class="panel panel-default">
                <div class="panel-heading"><h3><?php echo $namepais ?></h3></div>
                	<div class="panel-body">
                    
                    
                       
                        
                        
                        
        
                        
                    
      </div>
</div>  
<style type="text/css"> #map-canvas {width: 100%; margin: 0; padding: 0; height: 550px }</style>
<div id="map-canvas"></div>                  
</div>


<?php include('footer.php'); ?>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp"></script>
<script>
// This example creates a simple polygon representing the Bermuda Triangle.


var map;

 function initialize() {
  var mapOptions = {
    zoom: 5,
    center: new google.maps.LatLng(11.26461221250444, -79.3212890625),//segun pais
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };

 

 map = new google.maps.Map(document.getElementById('map-canvas'),
      mapOptions);


//name.setMap(map); //llamar con botones--bermudaTriangle.setMap();para quitar en blanco
  //bermudaTriangle2.setMap(map);// llamar con botones
  //marker.setMap(map);

 
  

}

google.maps.event.addDomListener(window, 'load', initialize);

    </script>
     <?php do { ?><script> 
                          <?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
							  
							  <?php if ($row_consultacordenada['strTipo'] == 'Marker') 
									{ ?>
										
										position: <?php echo $row_consultacordenada['textCordenadas']; ?>
										,map: map,
      									title: '<?php echo $row_consultacordenada['strName']; ?>'});
								
									<?php }
								elseif ($row_consultacordenada['strTipo'] == 'Polygon') 
									{ ?>
										
										 paths: [ 
                                        <?php echo $row_consultacordenada['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_consultacordenada['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  
									
									<?php }
								elseif ($row_consultacordenada['strTipo'] == 'Polyline') 
									{ ?>
										
										 path: [ 
                                        <?php echo $row_consultacordenada['textCordenadas']; ?>
										  ],
										  	geodesic: true,
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
										  });
							  
									
									<?php }
									
									?>
                               
							  
							  setTimeout(function () { 
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								}, 100);
							  
                          </script>
                          <?php } while ($row_consultacordenada = mysql_fetch_assoc($consultacordenada)); ?>
						  
                          <?php
mysql_free_result($consultacordenada);
?>