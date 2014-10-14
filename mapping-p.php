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


	<div class='options'>
      <div>
          <ul class="list-group">
            <li class="list-group-item">
              <label> <input id="paisC" type="checkbox" checked > </label>Pais</li>
            <li class="list-group-item">
              <label> <input id="regionC" type="checkbox" checked> </label>Region</li>
            <li class="list-group-item">
              <label> <input id="zonaC" type="checkbox" checked> </label>Zonas</li>
            <li class="list-group-item">
              <label> <input id="municipioC" type="checkbox" checked> </label>Municipios</li>
            <li class="list-group-item">
              <label> <input id="puntosC" type="checkbox" checked> </label>Puntos</li>
          </ul>
      </div>  

    </div>
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

<!-- pais -->
<?php do { ?>
<script> 
	<?php echo $row_Consultapais['strName']; ?>= new google.maps.<?php echo $row_Consultapais['strTipo']; ?>({
										 paths: [ 
                                        <?php echo $row_Consultapais['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_Consultapais['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_Consultapais['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  
							  	
								<?php echo $row_Consultapais['strName']; ?>.setMap(map);
								

</script>           
									<?php $paisoff[]= $row_Consultapais['strName'].".setMap();";?>
                                    <?php $paison[]= $row_Consultapais['strName'].".setMap(map);";?> 
<?php } while ($row_Consultapais = mysql_fetch_assoc($Consultapais)); ?>	
<!-- fin-pais -->

<!-- Region -->
<?php if ($totalRows_consultaRegion > 0) { // Show if recordset not empty ?>
  <?php do { ?>
  									<?php $regionoff[]= $row_consultaRegion['strName'].".setMap();";?>
                                    <?php $regionon[]= $row_consultaRegion['strName'].".setMap(map);";?> 
    <script> 
		<?php echo $row_consultaRegion['strName']; ?>= new google.maps.<?php echo $row_consultaRegion['strTipo']; ?>({
										 paths: [ 
                                        <?php echo $row_consultaRegion['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_consultaRegion['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_consultaRegion['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  
						
								<?php echo $row_consultaRegion['strName']; ?>.setMap(map);
						

</script>

    <?php } while ($row_consultaRegion = mysql_fetch_assoc($consultaRegion)); ?>
  <?php } // Show if recordset not empty ?>
<!-- fin-Region -->

<!-- zona -->
<?php do { ?>
<script> 
		<?php echo $row_consultazonas['strName']; ?>= new google.maps.<?php echo $row_consultazonas['strTipo']; ?>({
										 paths: [ 
                                        <?php echo $row_consultazonas['textCordenadas']; ?>
										  ],
											strokeColor: '<?php echo $row_consultazonas['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
											fillColor: '<?php echo $row_consultazonas['strBorde']; ?>',
											fillOpacity: 0.35
										  });
							  
								
								<?php echo $row_consultazonas['strName']; ?>.setMap(map);
								

</script>         
									<?php $uno[]= $row_consultazonas['strName'].".setMap();";?>
                                    <?php $dos[]= $row_consultazonas['strName'].".setMap(map);";?>   
<?php } while ($row_consultazonas = mysql_fetch_assoc($consultazonas)); ?>
<!-- fin-zona -->

<!-- Municipio -->
<?php if ($totalRows_consultaMunicipio > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <script> 
		citymap['<?php echo $row_consultaMunicipio['strName']; ?>'] = {
								  	center: <?php echo $row_consultaMunicipio['textCordenadas']; ?>,
								  	population: <?php echo $row_consultaMunicipio['intRadiocirculo']; ?>
								};

</script>
    <?php } while ($row_consultaMunicipio = mysql_fetch_assoc($consultaMunicipio)); ?>
  <?php } // Show if recordset not empty ?>
<!-- fin-Municipio -->

<!-- ruta-->
<?php if ($totalRows_consultaRuta > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <script> 
		<?php echo $row_consultaRuta['strName']; ?>= new google.maps.<?php echo $row_consultaRuta['strTipo']; ?>({
										 path: [ 
                                        <?php echo $row_consultaRuta['textCordenadas']; ?>
										  ],
										  	icons: [{
												icon: lineSymbol,
												offset: '100%'
											  }],
											strokeColor: '<?php echo $row_consultaRuta['strColor']; ?>',
											strokeOpacity: 0.8,
											strokeWeight: 2,
										  });
							  		
								$(document).ready(function() {
								<?php echo $row_consultaRuta['strName']; ?>.setMap(map);
								});	

</script>
									<?php $rutaoff[]= $row_consultaRuta['strName'].".setMap();";?>
                                    <?php $rutaon[]= $row_consultaRuta['strName'].".setMap(map);";?> 
    <?php } while ($row_consultaRuta = mysql_fetch_assoc($consultaRuta)); ?>
  <?php } // Show if recordset not empty ?>
<!-- fin-ruta -->

<!-- Puntos-->
<?php if ($totalRows_consultaPuntos > 0) { // Show if recordset not empty ?>
  <?php do { ?>
    <script> 
					 //si es marker muestra nube								 
			 var contentString<?php echo $row_consultaPuntos['idCordenadas']; ?> = '<div id="content">'+
			'<div id="siteNotice">'+
			'</div>'+
			'<h2 id="firstHeading" class="firstHeading"><?php echo $row_consultaPuntos['strTitle']; ?></h2>'+
			<?php /*?><?php echo nameCordenada($row_consultaPuntos['intPadre'])?><?php */?>
			'<div id="bodyContent">'+
			'<p> <?php echo $row_consultaPuntos['textDescripcion']; ?></p>'+
			'</div>'+
			'</div>';
		
		var infowindow<?php echo $row_consultaPuntos['idCordenadas']; ?> = new google.maps.InfoWindow({
			content: contentString<?php echo $row_consultaPuntos['idCordenadas']; ?>
		});
		
				<?php echo $row_consultaPuntos['strName']; ?>= new google.maps.<?php echo $row_consultaPuntos['strTipo']; ?>({
										position: <?php echo $row_consultaPuntos['textCordenadas']; ?>
										,map: map,
										//icon: image,
										animation: google.maps.Animation.DROP,
      									title: '<?php echo $row_consultaPuntos['strName']; ?>'});
									
								$(document).ready(function() {
								<?php echo $row_consultaPuntos['strName']; ?>.setMap(map);
								});	
								
		// si es marker llama click																			
								google.maps.event.addListener(<?php echo $row_consultaPuntos['strName']; ?>, 'click', function() {
								  infowindow<?php echo $row_consultaPuntos['idCordenadas']; ?>.open(map,<?php echo $row_consultaPuntos['strName']; ?>);
								});							


</script>
									<?php $puntosoff[]= $row_consultaPuntos['strName'].".setMap();";?>
                                    <?php $puntoson[]= $row_consultaPuntos['strName'].".setMap(map);";?>
    <?php } while ($row_consultaPuntos = mysql_fetch_assoc($consultaPuntos)); ?>
  <?php } // Show if recordset not empty ?>
<!-- fin-puntos -->

                          
<!-- funcion para chek zonas-->             


                          <script>

						   function zonasIniOff() {          
            					<?php 								
								echo implode(" \n ",$uno);
						    ?>	  
                          
						   };
						   function zonasIniOn() {          
            				<?php 								
								echo implode(" \n ",$dos);
						    ?>
						   };
						   //
						   function paisIniOff() {          
            					<?php 								
								echo implode(" \n ",$paisoff);
						    ?>	  
                          
						   };
						   function paisIniOn() {          
            				<?php 								
								echo implode(" \n ",$paison);
						    ?>
						   };
						   //
						   <?php if ($totalRows_consultaRegion > 0) { // Show if recordset not empty ?>
						   function regionIniOff() {          
            					<?php 								
								echo implode(" \n ",$regionoff);
						    ?>	  
                          
						   };
						   function regionIniOn() {          
            				<?php 								
								echo implode(" \n ",$regionon);
						    ?>
						   };
						     <?php } // Show if recordset not empty ?>
						   
						   //
						   function municipioIniOff() {          
            					<?php 								
								echo implode(" \n ",$uno);
						    ?>	  
                          
						   };
						   function municipioIniOn() {          
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
						   };
						   //
						   
						   <?php if ($totalRows_consultaRuta > 0) { // Show if recordset not empty ?>
						    function rutaIniOff() {          
            					<?php 								
								echo implode(" \n ",$rutaoff);
						    ?>	  
                          
						   };
						   function rutaIniOn() {          
            				<?php 								
								echo implode(" \n ",$rutaon);
						    ?>
						   };
						   
						   <?php } // Show if recordset not empty ?>
						   //
						   function puntosIniOff() {          
            					<?php 								
								echo implode(" \n ",$puntosoff);
						    ?>	  
                          
						   };
						   function puntosIniOn() {          
            				<?php 								
								echo implode(" \n ",$puntoson);
						    ?>
						   };
						   
						   
						  
                           </script>

              <!-- END funcion para chek zonas-->    
              <script>
			  		var cityCircle;
					
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
				
							
				$(document).ready(function() {
				    google.maps.event.addDomListener(window, 'load', initialize);
					paisIniOn();
					zonasIniOn();
					puntosIniOn();

				});		  
				  

</script>
		<?php include("footer.php"); ?>
<?php
mysql_free_result($consultazonas);

mysql_free_result($consultaPuntos);

mysql_free_result($consultaRuta);

mysql_free_result($Consultapais);

mysql_free_result($consultaRegion);

mysql_free_result($consultaMunicipio);
?>
