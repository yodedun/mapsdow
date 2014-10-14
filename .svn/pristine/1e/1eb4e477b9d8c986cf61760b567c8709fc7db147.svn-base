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
$query_consultacordenada = "SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor, tblCordenadas.textDescripcion, tblCordenadas.strTitle, tblCordenadas.intIcono FROM tblCordenadas , tblCategorias WHERE tblCordenadas.intCategoria = tblCategorias.idCategoria";
$consultacordenada = mysql_query($query_consultacordenada, $conexionmiura) or die(mysql_error());
$row_consultacordenada = mysql_fetch_assoc($consultacordenada);
$totalRows_consultacordenada = mysql_num_rows($consultacordenada);

mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultazonas = "SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria=3";
$consultazonas = mysql_query($query_consultazonas, $conexionmiura) or die(mysql_error());
$row_consultazonas = mysql_fetch_assoc($consultazonas);
$totalRows_consultazonas = mysql_num_rows($consultazonas);

 $namepais = $row_consultacordenada['strName']; ?>

<?php include('header.php'); ?>
<div class="col-lg-12">
<div class="panel panel-default">
                <div class="panel-heading"><h3><?php echo $namepais ?></h3></div>
                	<div class="panel-body">
                      <div class="col-lg-12">
                      	<a class="btn btn-danger" href="list_cordenadas.php">Regresar</a>
                        
                       
                      </div>
                    
                       
                        
                        
                        
        
                        
                    
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

var citymap = {};	 
var lineSymbol = {
				  path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW
				};


    </script>
     <?php do { ?><script> 
	 
	
	 
<?php if ($row_consultacordenada['strTipo'] == 'Marker') 
									{ ?>	
	 //si es marker muestra nube								 
	 var contentString<?php echo $row_consultacordenada['idCordenadas']; ?> = '<div id="content">'+
    '<div id="siteNotice">'+
    '</div>'+
    '<h2 id="firstHeading" class="firstHeading"><?php echo $row_consultacordenada['strName']; ?></h2>'+
    '<div id="bodyContent">'+
    '<p><?php echo $row_consultacordenada['textDescripcion']; ?></p>'+
    '</div>'+
    '</div>';

var infowindow<?php echo $row_consultacordenada['idCordenadas']; ?> = new google.maps.InfoWindow({
    content: contentString<?php echo $row_consultacordenada['idCordenadas']; ?>
});
<?php } ?>
                          <?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({
							  
							  <?php if ($row_consultacordenada['strTipo'] == 'Marker') 
									{ ?>
										
										position: <?php echo $row_consultacordenada['textCordenadas']; ?>
										,map: map,
										//icon: image,
										animation: google.maps.Animation.DROP,
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
										  	icons: [{
												icon: lineSymbol,
												offset: '100%'
											  }],
											strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
										  });
							  
									
									<?php }
								
									?>
									
									
									
                               
							  
							  setTimeout(function () { 
								<?php echo $row_consultacordenada['strName']; ?>.setMap(map);
								}, 300);
								
						
								<?php if ($row_consultacordenada['strTipo'] == 'Marker') 
																	{ ?>	
								// si es marker llama click																			
								google.maps.event.addListener(<?php echo $row_consultacordenada['strName']; ?>, 'click', function() {
								  infowindow<?php echo $row_consultacordenada['idCordenadas']; ?>.open(map,<?php echo $row_consultacordenada['strName']; ?>);
								});
								
								citymap['<?php echo $row_consultacordenada['strName']; ?>'] = {
								  center: <?php echo $row_consultacordenada['textCordenadas']; ?>,
								  population: 203500
								};
								
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
							
						  
				  google.maps.event.addDomListener(window, 'load', initialize);

						  
			  </script>
                                        
                          <?php
mysql_free_result($consultacordenada);

mysql_free_result($consultazonas);
?>