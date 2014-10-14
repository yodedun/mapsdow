<?php require_once('Connections/conexionmiura.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "1";
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

$MM_restrictGoTo = "index.php";
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

$varClave_consultacordenada = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varClave_consultacordenada = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultacordenada = sprintf("SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.idCategoria, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor, tblCordenadas.textDescripcion, tblCordenadas.strTitle, tblCordenadas.intIcono, tblCordenadas.intRadiocirculo, tblCordenadas.intPadre  FROM tblCordenadas , tblCategorias WHERE tblCordenadas.intCategoria = tblCategorias.idCategoria AND  tblCordenadas.intActivo=1 AND tblCordenadas.idCordenadas = %s UNION SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.idCategoria, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor, tblCordenadas.textDescripcion, tblCordenadas.strTitle, tblCordenadas.intIcono, tblCordenadas.intRadiocirculo, tblCordenadas.intPadre  FROM tblCordenadas , tblCategorias WHERE tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo=1 AND tblCordenadas.intPadre = %s UNION SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.idCategoria, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor, tblCordenadas.textDescripcion, tblCordenadas.strTitle, tblCordenadas.intIcono, tblCordenadas.intRadiocirculo, tblCordenadas.intPadre  FROM tblCordenadas , tblCategorias WHERE tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo=1 AND tblCordenadas.intSuperpadre = %s", GetSQLValueString($varClave_consultacordenada, "int"),GetSQLValueString($varClave_consultacordenada, "int"),GetSQLValueString($varClave_consultacordenada, "int"));
$consultacordenada = mysql_query($query_consultacordenada, $conexionmiura) or die(mysql_error());
$row_consultacordenada = mysql_fetch_assoc($consultacordenada);
$totalRows_consultacordenada = mysql_num_rows($consultacordenada);

$varClave2_consultazonas = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varClave2_consultazonas = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultazonas = sprintf("SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.textCordenadas, 	tblCordenadas.intCategoria, 	tblCordenadas.intActivo, 	tblCategorias.idCategoria, 	tblCategorias.strTipo, 	tblCategorias.strBorde, 	tblCategorias.strColor, 	tblCordenadas.textDescripcion, 	tblCordenadas.strTitle, 	tblCordenadas.intIcono, 	tblCordenadas.intRadiocirculo, 	tblCordenadas.intPadre FROM 	tblCordenadas, 	tblCategorias WHERE 	tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo = 1 AND tblCordenadas.intSuperpadre= %s and tblCordenadas.intCategoria=3", GetSQLValueString($varClave2_consultazonas, "int"));
$consultazonas = mysql_query($query_consultazonas, $conexionmiura) or die(mysql_error());
$row_consultazonas = mysql_fetch_assoc($consultazonas);
$totalRows_consultazonas = mysql_num_rows($consultazonas);

$varPuntos_consultaPuntos = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varPuntos_consultaPuntos = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaPuntos = sprintf("SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.textCordenadas, 	tblCordenadas.intCategoria, 	tblCordenadas.intActivo, 	tblCategorias.idCategoria, 	tblCategorias.strTipo, 	tblCategorias.strBorde, 	tblCategorias.strColor, 	tblCordenadas.textDescripcion, 	tblCordenadas.strTitle, 	tblCordenadas.intIcono, 	tblCordenadas.intRadiocirculo, 	tblCordenadas.intPadre FROM 	tblCordenadas, 	tblCategorias WHERE 	tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo = 1 AND tblCordenadas.intSuperpadre= %s and tblCordenadas.intCategoria=7", GetSQLValueString($varPuntos_consultaPuntos, "int"));
$consultaPuntos = mysql_query($query_consultaPuntos, $conexionmiura) or die(mysql_error());
$row_consultaPuntos = mysql_fetch_assoc($consultaPuntos);
$totalRows_consultaPuntos = mysql_num_rows($consultaPuntos);

$varRuta_consultaRuta = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varRuta_consultaRuta = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaRuta = sprintf("SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.textCordenadas, 	tblCordenadas.intCategoria, 	tblCordenadas.intActivo, 	tblCategorias.idCategoria, 	tblCategorias.strTipo, 	tblCategorias.strBorde, 	tblCategorias.strColor, 	tblCordenadas.textDescripcion, 	tblCordenadas.strTitle, 	tblCordenadas.intIcono, 	tblCordenadas.intRadiocirculo, 	tblCordenadas.intPadre FROM 	tblCordenadas, 	tblCategorias WHERE 	tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo = 1 AND tblCordenadas.intSuperpadre= %s and tblCordenadas.intCategoria=5", GetSQLValueString($varRuta_consultaRuta, "int"));
$consultaRuta = mysql_query($query_consultaRuta, $conexionmiura) or die(mysql_error());
$row_consultaRuta = mysql_fetch_assoc($consultaRuta);
$totalRows_consultaRuta = mysql_num_rows($consultaRuta);

$varPais_Consultapais = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varPais_Consultapais = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_Consultapais = sprintf("SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.textCordenadas, 	tblCordenadas.intCategoria, 	tblCordenadas.intActivo, 	tblCategorias.idCategoria, 	tblCategorias.strTipo, 	tblCategorias.strBorde, 	tblCategorias.strColor, 	tblCordenadas.textDescripcion, 	tblCordenadas.strTitle, 	tblCordenadas.intIcono, 	tblCordenadas.intRadiocirculo, 	tblCordenadas.intPadre FROM 	tblCordenadas, 	tblCategorias WHERE 	tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo = 1 AND tblCordenadas.intSuperpadre= %s and tblCordenadas.intCategoria=1", GetSQLValueString($varPais_Consultapais, "int"));
$Consultapais = mysql_query($query_Consultapais, $conexionmiura) or die(mysql_error());
$row_Consultapais = mysql_fetch_assoc($Consultapais);
$totalRows_Consultapais = mysql_num_rows($Consultapais);

$varRegion_consultaRegion = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varRegion_consultaRegion = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaRegion = sprintf("SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.textCordenadas, 	tblCordenadas.intCategoria, 	tblCordenadas.intActivo, 	tblCategorias.idCategoria, 	tblCategorias.strTipo, 	tblCategorias.strBorde, 	tblCategorias.strColor, 	tblCordenadas.textDescripcion, 	tblCordenadas.strTitle, 	tblCordenadas.intIcono, 	tblCordenadas.intRadiocirculo, 	tblCordenadas.intPadre FROM 	tblCordenadas, 	tblCategorias WHERE 	tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo = 1 AND tblCordenadas.intSuperpadre= %s and tblCordenadas.intCategoria=2", GetSQLValueString($varRegion_consultaRegion, "int"));
$consultaRegion = mysql_query($query_consultaRegion, $conexionmiura) or die(mysql_error());
$row_consultaRegion = mysql_fetch_assoc($consultaRegion);
$totalRows_consultaRegion = mysql_num_rows($consultaRegion);

$varMun_consultaMunicipio = "0";
if (isset($_SESSION['MM_idCordenadaclave'])) {
  $varMun_consultaMunicipio = $_SESSION['MM_idCordenadaclave'];
}
mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaMunicipio = sprintf("SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.textCordenadas, 	tblCordenadas.intCategoria, 	tblCordenadas.intActivo, 	tblCategorias.idCategoria, 	tblCategorias.strTipo, 	tblCategorias.strBorde, 	tblCategorias.strColor, 	tblCordenadas.textDescripcion, 	tblCordenadas.strTitle, 	tblCordenadas.intIcono, 	tblCordenadas.intRadiocirculo, 	tblCordenadas.intPadre FROM 	tblCordenadas, 	tblCategorias WHERE 	tblCordenadas.intCategoria = tblCategorias.idCategoria AND tblCordenadas.intActivo = 1 AND tblCordenadas.intSuperpadre= %s and tblCordenadas.intCategoria=4", GetSQLValueString($varMun_consultaMunicipio, "int"));
$consultaMunicipio = mysql_query($query_consultaMunicipio, $conexionmiura) or die(mysql_error());
$row_consultaMunicipio = mysql_fetch_assoc($consultaMunicipio);
$totalRows_consultaMunicipio = mysql_num_rows($consultaMunicipio);


?>
<?php include("headerglobal.php"); ?>
        <body>
	<?php include("header.php"); ?>

<!--begin map -->  

    <div id="map-canvas">

    </div>
<!--end map -->
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

var citymap = {};
var cargarpais = {};	 
var lineSymbol = {
				  path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
				};


    </script>
     <?php do { ?><script> 
	 

	 
<?php if ($row_consultacordenada['idCategoria'] == '7')  
									{ ?>	
									
	 //si es marker muestra nube								 
	 var contentString<?php echo $row_consultacordenada['idCordenadas']; ?> = '<div id="content">'+
    '<div id="siteNotice">'+
    '</div>'+
    '<h2 id="firstHeading" class="firstHeading"><?php echo nameCordenada($row_consultacordenada['intPadre'])?></h2>'+
    '<div id="bodyContent">'+
    '<p> <?php echo $row_consultacordenada['textDescripcion']; ?></p>'+
    '</div>'+
    '</div>';

var infowindow<?php echo $row_consultacordenada['idCordenadas']; ?> = new google.maps.InfoWindow({
    content: contentString<?php echo $row_consultacordenada['idCordenadas']; ?>
});
<?php } ?>
								<?php if ($row_consultacordenada['idCategoria'] == '4') 
																	{ ?>	
																
									citymap['<?php echo $row_consultacordenada['strName']; ?>'] = {
								  	center: <?php echo $row_consultacordenada['textCordenadas']; ?>,
								  	population: <?php echo $row_consultacordenada['intRadiocirculo']; ?>
								};
								
								<?php } ?>
                          
							  
							  <?php if ($row_consultacordenada['idCategoria'] == '7')  
									{ ?>
										<?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
										position: <?php echo $row_consultacordenada['textCordenadas']; ?>
										,map: map,
										//icon: image,
										animation: google.maps.Animation.DROP,
      									title: '<?php echo $row_consultacordenada['strName']; ?>'});
									
								$(document).ready(function() {
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								});		
								
									<?php }
								
								elseif ($row_consultacordenada['idCategoria'] == '1') 
									{ ?>
										<?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
										 paths: [ 
                                        <?php echo $row_consultacordenada['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_consultacordenada['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  
							  	$(document).ready(function() {
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								});	
									
									<?php }	
									
								elseif ($row_consultacordenada['idCategoria'] == '2') 
									{ ?>
										<?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
										 paths: [ 
                                        <?php echo $row_consultacordenada['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_consultacordenada['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  
								$(document).ready(function() {
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								});		
									
									<?php }
								elseif ($row_consultacordenada['idCategoria'] == '3') 
									{ ?>
										<?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
										 paths: [ 
                                        <?php echo $row_consultacordenada['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_consultacordenada['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  	$(document).ready(function() {
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								});	
									
									<?php }	
								elseif ($row_consultacordenada['idCategoria'] == '5') 
									{ ?>
										<?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
										 path: [ 
                                        <?php echo $row_consultacordenada['textCordenadas']; ?>
										  ],
										  	icons: [{
												icon: lineSymbol,
												offset: '100%'
											  }],
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
										  });
							  		
								$(document).ready(function() {
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								});	
									
									<?php } ?>
									
									
									
                               
							  
							  
								
						
								<?php if ($row_consultacordenada['idCategoria'] == '7') 
																	{ ?>	
								// si es marker llama click																			
								google.maps.event.addListener(<?php echo $row_consultacordenada['strName']; ?>, 'click', function() {
								  infowindow<?php echo $row_consultacordenada['idCordenadas']; ?>.open(map,<?php echo $row_consultacordenada['strName']; ?>);
								});
								
								
								<?php } ?>
								
								
							  
                          </script>
                      
                          <?php } while ($row_consultacordenada = mysql_fetch_assoc($consultacordenada)); ?>
                          
             <!-- funcion para chek zonas-->             
                         
                           <?php do { ?>
                           			<?php $uno[]= $row_consultazonas['strName'].".setMap();";?>
                                    <?php $dos[]= $row_consultazonas['strName'].".setMap(map);";?>
						   <?php } while ($row_consultazonas = mysql_fetch_assoc($consultazonas)); ?>
						   
                           
                           <script>

						  
						 
						  
						   </script>
                          <script>

						   function zonasIniOff() {          
            					<?php 								
								echo implode(" \n ",$uno);
						    ?>	  
                          
						   };
						  
                           </script>
                            <script>
						  
						   function zonasIniOn() {          
            				<?php 								
								echo implode(" \n ",$dos);
						    ?>
						   };
						  
                           </script>
              <!-- END funcion para chek zonas-->    
              <script>
			  		var cityCircle;
						 setTimeout(function () { 
						  for (var city in citymap) {
							// Construct the circle for each value in citymap. We scale population by 20.
							var populationOptions = {
							  strokeColor: "#FF0000",
							  strokeOpacity: 0.8,
							  strokeWeight: 2,
							  fillColor: "#FF0000",
							  fillOpacity: 0.35,
							  map: map,
							  center: citymap[city].center,
							  radius: citymap[city].population / 20
							};
							cityCircle = new google.maps.Circle(populationOptions);
						  }  
				}, 300);
							
				$(document).ready(function() {
				    google.maps.event.addDomListener(window, 'load', initialize);
				});		  
				  

</script>
		<?php include("footer.php"); ?>
<?php
mysql_free_result($consultacordenada);

mysql_free_result($consultazonas);

mysql_free_result($consultaPuntos);

mysql_free_result($consultaRuta);

mysql_free_result($Consultapais);

mysql_free_result($consultaRegion);

mysql_free_result($consultaMunicipio);
?>
