<?php require_once('Connections/conexionmiura.php'); ?>
<?php
if (!isset($_SESSION)) {
    session_start();
}
$MM_authorizedUsers = "8";
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
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("", $MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {
    $MM_qsChar = "?";
    $MM_referrer = $_SERVER['PHP_SELF'];
    if (strpos($MM_restrictGoTo, "?"))
        $MM_qsChar = "&";
    if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0)
        $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
    $MM_restrictGoTo = $MM_restrictGoTo . $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
    header("Location: " . $MM_restrictGoTo);
    exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {

    function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
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
$query_consultaPaises = "SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria = 1 and tblCordenadas.intActivo=1";
$consultaPaises = mysql_query($query_consultaPaises, $conexionmiura) or die(mysql_error());
$row_consultaPaises = mysql_fetch_assoc($consultaPaises);
$totalRows_consultaPaises = mysql_num_rows($consultaPaises);





mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultacordenada = "SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor, tblCordenadas.textDescripcion, tblCordenadas.strTitle, tblCordenadas.intIcono FROM tblCordenadas , tblCategorias WHERE tblCordenadas.intCategoria = tblCategorias.idCategoria and tblCordenadas.intActivo=1 ";
$consultacordenada = mysql_query($query_consultacordenada, $conexionmiura) or die(mysql_error());
$row_consultacordenada = mysql_fetch_assoc($consultacordenada);
$totalRows_consultacordenada = mysql_num_rows($consultacordenada);
?>
<?php include("headerglobal.php"); ?>
<body>
    <?php include("header.php"); ?>


    <div class='options'>
        <div>
            <?php do { ?> 
                <ul id="menu">
                    <li class="<?php echo $row_consultaPaises['strName']; ?>" ><label>
                    <input class="paisC <?php echo $row_consultaPaises['strName']; ?>" type="checkbox" checked > </label>
                        <div class="btn-group btn-toggle onOff"> 
                            <button class="btn btn-xs btn-primary  active on">ON</button>
                            <button class="btn btn-xs btn-default off">OFF</button>
                        </div>
                        <script>
                            $('.<?php echo $row_consultaPaises['strName']; ?> .onOff .off').click(function() {
                                $('.<?php echo $row_consultaPaises['strName']; ?>').prop('checked', false).change();
                            });	
                            $('.<?php echo $row_consultaPaises['strName']; ?> .onOff .on').click(function() {
                                $('.<?php echo $row_consultaPaises['strName']; ?>').prop('checked', true).change();
                            });						
    														
                            $('.options label input.<?php echo $row_consultaPaises['strName']; ?>').change(function(){
                                if($(this).prop("checked"))
                                {
    <?php echo $row_consultaPaises['strName']; ?>.setMap(map);
    															
                                                                                                     }
                                                                                                     else{
    <?php echo $row_consultaPaises['strName']; ?>.setMap();							
                                                                                                    }								
                                                                                                });	
    								
    								
    											
                        </script>

                        <a href="#"><?php echo $row_consultaPaises['strTitle']; ?></a>

                        <ul style="display: none;">
                            <?php
                            $varPais_consultaRegion = "0";
                            if (isset($row_consultaPaises['idCordenadas'])) {
                                $varPais_consultaRegion = $row_consultaPaises['idCordenadas'];
                            }

                            mysql_select_db($database_conexionmiura, $conexionmiura);
                            $query_consultaRegion = sprintf("SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria =2 and tblCordenadas.intActivo=1 and tblCordenadas.intSuperpadre = %s", GetSQLValueString($varPais_consultaRegion, "int"));
                            $consultaRegion = mysql_query($query_consultaRegion, $conexionmiura) or die(mysql_error());
                            $row_consultaRegion = mysql_fetch_assoc($consultaRegion);
                            $totalRows_consultaRegion = mysql_num_rows($consultaRegion);
                            ?>

                            <?php do { ?>

                                <?php if ($totalRows_consultaRegion > 0) { // Show if recordset not empty ?>
                                    <li class="<?php echo $row_consultaRegion['strName']; ?>">
                                        <div class="btn-group btn-toggle onOff"> 
                                            <button class="btn btn-xs btn-primary  active on">ON</button>
                                            <button class="btn btn-xs btn-default off">OFF</button>
                                        </div>

                                        <label>
                                            <input class="regionC <?php echo $row_consultaRegion['strName']; ?> 
            <?php echo $row_consultaPaises['strName']; ?>" type="checkbox" checked > 
                                        </label>
                                        <script>
                                            $('.<?php echo $row_consultaRegion['strName']; ?> .onOff .off').click(function() {
                                                $('.<?php echo $row_consultaRegion['strName']; ?>').prop('checked', false).change();
                                            });	
                                            $('.<?php echo $row_consultaRegion['strName']; ?> .onOff .on').click(function() {
                                                $('.<?php echo $row_consultaRegion['strName']; ?>').prop('checked', true).change();
                                            });			
            															
                                            $('.options label input.<?php echo $row_consultaRegion['strName']; ?>').change(function(){
                                                if($(this).prop("checked"))
                                                {
                                                    (function() { <?php echo $row_consultaRegion['strName']; ?>.setMap(map) }) ()						
                                                }
                                                else{
                                                    (function() { <?php echo $row_consultaRegion['strName']; ?>.setMap() }) ()
                                                }								
                                            });						
                                        </script>

                                        <a href="#"><?php echo $row_consultaRegion['strTitle']; ?></a>
                                        <ul style="display: none;">

            <?php
            $varPais_consultaZonas = "0";
            if (isset($row_consultaPaises['idCordenadas'])) {
                $varPais_consultaZonas = $row_consultaPaises['idCordenadas'];
            }
            $varRegion_consultaZonas = "0";
            if (isset($row_consultaRegion['idCordenadas'])) {
                $varRegion_consultaZonas = $row_consultaRegion['idCordenadas'];
            }
            mysql_select_db($database_conexionmiura, $conexionmiura);
            $query_consultaZonas = sprintf("SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria=3 and tblCordenadas.intActivo=1 and  tblCordenadas.intSuperpadre = %s and tblCordenadas.intPadre = %s", GetSQLValueString($varPais_consultaZonas, "int"), GetSQLValueString($varRegion_consultaZonas, "int"));
            $consultaZonas = mysql_query($query_consultaZonas, $conexionmiura) or die(mysql_error());
            $row_consultaZonas = mysql_fetch_assoc($consultaZonas);
            $totalRows_consultaZonas = mysql_num_rows($consultaZonas);
            ?>


                                            <?php do { ?> 
                <?php if ($totalRows_consultaZonas > 0) { // Show if recordset not empty  ?>
                                                    <li class="<?php echo $row_consultaZonas['strName']; ?>">  
                                                    	<div class="btn-group btn-toggle onOff"> 
                                                            <button class="btn btn-xs btn-primary  active on">ON</button>
                                                            <button class="btn btn-xs btn-default off">OFF</button>
                                                        </div>
                                                        <label> <input class="zonaC <?php echo $row_consultaZonas['strName']; ?> <?php echo $row_consultaRegion['strName']; ?>
														<?php echo $row_consultaPaises['strName']; ?> " type="checkbox" checked > </label>
                                                        <script>
															 	$('.<?php echo $row_consultaZonas['strName']; ?> .onOff .off').click(function() {
																	$('.<?php echo $row_consultaZonas['strName']; ?>').prop('checked', false).change();
																});	
																$('.<?php echo $row_consultaZonas['strName']; ?> .onOff .on').click(function() {
																	$('.<?php echo $row_consultaZonas['strName']; ?>').prop('checked', true).change();
																});	
																						
																$('.options label input.<?php echo $row_consultaZonas['strName']; ?>').change(function(){
                                                                if($(this).prop("checked"))
                                                                {
                                                                    (function() { <?php echo $row_consultaZonas['strName']; ?>.setMap(map) }) ()						
                                                                }
                                                                else{
                                                                    (function() { <?php echo $row_consultaZonas['strName']; ?>.setMap() }) ()
                                                                }								
                                                            });						
                                                        </script>
                                                        <a href="#"><?php echo $row_consultaZonas['strTitle']; ?></a>
                                                        <ul style="display: none;">
                        <?php
            $varPais_consultaMunicipio = "0";
            if (isset($row_consultaPaises['idCordenadas'])) {
                $varPais_consultaMunicipio = $row_consultaPaises['idCordenadas'];
            }
            $varRegion_consultaMunicipio = "0";
            if (isset($row_consultaZonas['idCordenadas'])) {
                $varRegion_consultaMunicipio = $row_consultaZonas['idCordenadas'];
            }
            mysql_select_db($database_conexionmiura, $conexionmiura);
            $query_consultaMunicipio = sprintf("SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria=4 and tblCordenadas.intActivo=1 and  tblCordenadas.intSuperpadre = %s and tblCordenadas.intPadre = %s", GetSQLValueString($varPais_consultaMunicipio, "int"), GetSQLValueString($varRegion_consultaMunicipio, "int"));
            $consultaMunicipio = mysql_query($query_consultaMunicipio, $conexionmiura) or die(mysql_error());
            $row_consultaMunicipio = mysql_fetch_assoc($consultaMunicipio);
            $totalRows_consultaMunicipio = mysql_num_rows($consultaMunicipio);
            ?>                                
            
            											<?php do { ?> 
                                                         <?php if ($totalRows_consultaMunicipio > 0) { // Show if recordset not empty  ?>
                                                        	<li class="<?php echo $row_consultaMunicipio['strName']; ?>">
                                                            	<div class="btn-group btn-toggle onOff"> 
                                                                    <button class="btn btn-xs btn-primary  active on">ON</button>
                                                                    <button class="btn btn-xs btn-default off">OFF</button>
                                                                </div>
                                                            	<label> <input class="municipioC <?php echo $row_consultaMunicipio['strName']; ?> 
																<?php echo $row_consultaZonas['strName']; ?> <?php echo $row_consultaRegion['strName']; ?>
																<?php echo $row_consultaPaises['strName']; ?> " type="checkbox" checked > </label>
                                                                 <script>		
																 	$('.<?php echo $row_consultaMunicipio['strName']; ?> .onOff .off').click(function() {
																	$('.<?php echo $row_consultaMunicipio['strName']; ?>').prop('checked', false).change();
																	});	
																	$('.<?php echo $row_consultaMunicipio['strName']; ?> .onOff .on').click(function() {
																		$('.<?php echo $row_consultaMunicipio['strName']; ?>').prop('checked', true).change();
																	});	
																 				
																	$('.options label input.<?php echo $row_consultaMunicipio['strName']; ?>').change(function(){
																		if($(this).prop("checked"))
																		{
																			(function() { <?php echo $row_consultaMunicipio['strName']; ?>.setMap(map) }) ()						
																		}
																		else{
																			(function() { <?php echo $row_consultaMunicipio['strName']; ?>.setMap() }) ()
																		}								
																	});						
																</script>
                                                            	<a href="#"><?php echo $row_consultaMunicipio['strTitle']; ?></a>
                                                                <ul class="almacenes" style="display: none;">
                                                                
                                      <?php
            $varPais_consultaAlmacen = "0";
            if (isset($row_consultaPaises['idCordenadas'])) {
                $varPais_consultaAlmacen = $row_consultaPaises['idCordenadas'];
            }
            $varRegion_consultaAlmacen = "0";
            if (isset($row_consultaMunicipio['idCordenadas'])) {
                $varRegion_consultaAlmacen = $row_consultaMunicipio['idCordenadas'];
            }
            mysql_select_db($database_conexionmiura, $conexionmiura);
            $query_consultaAlmacen = sprintf("SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria=7 and tblCordenadas.intActivo=1 and  tblCordenadas.intSuperpadre = %s and tblCordenadas.intPadre = %s", GetSQLValueString($varPais_consultaAlmacen, "int"), GetSQLValueString($varRegion_consultaAlmacen, "int"));
            $consultaAlmacen = mysql_query($query_consultaAlmacen, $conexionmiura) or die(mysql_error());
            $row_consultaAlmacen = mysql_fetch_assoc($consultaAlmacen);
            $totalRows_consultaAlmacen = mysql_num_rows($consultaAlmacen);
            ?>                                                     
           													 <?php do { ?> 
                                                             	<?php if ($totalRows_consultaAlmacen > 0) { // Show if recordset not empty  ?>
                                                                    <li class="<?php echo $row_consultaAlmacen['strName']; ?>">
                                                                    
                                                                    <label> <input class="almacenC <?php echo $row_consultaAlmacen['strName']; ?> 
																	<?php echo $row_consultaMunicipio['strName']; ?> 
																	<?php echo $row_consultaZonas['strName']; ?> <?php echo $row_consultaRegion['strName']; ?>
                                                                    <?php echo $row_consultaPaises['strName']; ?> " type="checkbox" checked > </label>
                                                                    <script>						
																		$('.options label input.<?php echo $row_consultaAlmacen['strName']; ?>').change(function(){
																			if($(this).prop("checked"))
																			{
																				(function() { <?php echo $row_consultaAlmacen['strName']; ?>.setMap(map) }) ()						
																			}
																			else{
																				(function() { <?php echo $row_consultaAlmacen['strName']; ?>.setMap() }) ()
																			}								
																		});						
																	</script>
                                                                        <a href="#"><?php echo $row_consultaAlmacen['strTitle']; ?></a>
                                                                    </li>
                                                              	<?php } // Show if recordset not empty  ?>
                                                             <?php } while ($row_consultaAlmacen = mysql_fetch_assoc($consultaAlmacen)); ?>        
                                                                </ul>
                                                            </li>
                                                             <?php } // Show if recordset not empty  ?>
                                                        <?php } while ($row_consultaMunicipio = mysql_fetch_assoc($consultaMunicipio)); ?>  
                                                        </ul>
                                                    </li>
                <?php } // Show if recordset not empty  ?>
            <?php } while ($row_consultaZonas = mysql_fetch_assoc($consultaZonas)); ?> 

                                        </ul>
                                    </li>
        <?php } // Show if recordset not empty  ?>           
    <?php } while ($row_consultaRegion = mysql_fetch_assoc($consultaRegion)); ?> 

                        </ul>
                    </li>

                </ul>      


<?php } while ($row_consultaPaises = mysql_fetch_assoc($consultaPaises)); ?>

        </div>  

    </div>
    <!--begin map -->  


    <div id="map-canvas">

    </div>
    <!--end map -->




<?php include('footer.php'); ?>


    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
    <script>
        var image = 'img/icnZonaalta.png';
        var imageDos = 'img/icnZonabaja.png';
		var imageTres = 'img/inportafolio.png';
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

<?php do { ?>

        <script> 

    <?php if ($row_consultacordenada['intCategoria'] == 7) {
        ?>	

                                                                                        //si es marker muestra nube								 

                                                                                        var contentString<?php echo $row_consultacordenada['idCordenadas']; ?> = '<div id="content">'+

                                                                                            '<div id="siteNotice">'+

                                                                                            '</div>'+

                                                                                            '<h2 id="firstHeading" class="firstHeading"><?php echo $row_consultacordenada['strTitle']; ?></h2>'+

                                                                                            '<div id="bodyContent">'+

                                                                                            '<p><?php echo $row_consultacordenada['textDescripcion']; ?></p>'+

                                                                                            '</div>'+

                                                                                            '</div>';



                                                                                        var infowindow<?php echo $row_consultacordenada['idCordenadas']; ?> = new google.maps.InfoWindow({

                                                                                            content: contentString<?php echo $row_consultacordenada['idCordenadas']; ?>

                                                                                        });

    <?php } elseif ($row_consultacordenada['intCategoria'] == 4) {
        ?>	

                                                                                        //si es marker muestra nube								 

                                                                                        var contentString<?php echo $row_consultacordenada['idCordenadas']; ?> = '<div id="content">'+


                                                                                       '<h2 id="firstHeading" class="firstHeading"><?php echo $row_consultacordenada['strTitle']; ?></h2></div>';



                                                                                        var infowindow<?php echo $row_consultacordenada['idCordenadas']; ?> = new google.maps.InfoWindow({

                                                                                            content: contentString<?php echo $row_consultacordenada['idCordenadas']; ?>

                                                                                        });

    <?php } ?>

    <?php echo $row_consultacordenada['strName']; ?>= new google.maps.<?php echo $row_consultacordenada['strTipo']; ?>({

    							  

    <?php if ($row_consultacordenada['intCategoria'] == 4) {
        ?>		
        																		

								  position: <?php echo $row_consultacordenada['textCordenadas']; ?>

								  ,map: map,
							  <?php if ($row_consultacordenada['intIcono'] == 1) {  ?>
								  icon: image,
							  <?php } elseif ($row_consultacordenada['intIcono'] == 0) { ?>
								  icon: imageDos,
							  <?php } ?>
								  animation: google.maps.Animation.DROP,

								  title: '<?php echo $row_consultacordenada['strTitle']; ?>'});

								  google.maps.event.addListener(<?php echo $row_consultacordenada['strName']; ?>, 'click', function() {
								  infowindow<?php echo $row_consultacordenada['idCordenadas']; ?>.open(map,<?php echo $row_consultacordenada['strName']; ?>); });

        										

        								

    <?php 
	} elseif ($row_consultacordenada['intCategoria'] == 7) {
        ?>		
        																		

								  position: <?php echo $row_consultacordenada['textCordenadas']; ?>

								  ,map: map,
							  <?php if ($row_consultacordenada['intIcono'] == 1) {  ?>
								  icon: image,
							  <?php } elseif ($row_consultacordenada['intIcono'] == 0) { ?>
								  icon: imageDos,
							  <?php } elseif ($row_consultacordenada['intIcono'] == 6) { ?>
								  icon: imageTres,
							  <?php } ?>							  
								  animation: google.maps.Animation.DROP,

								  title: '<?php echo $row_consultacordenada['strTitle']; ?>'});

								  google.maps.event.addListener(<?php echo $row_consultacordenada['strName']; ?>, 'click', function() {
								  infowindow<?php echo $row_consultacordenada['idCordenadas']; ?>.open(map,<?php echo $row_consultacordenada['strName']; ?>); });

        										

        								

    <?php
    } elseif ($row_consultacordenada['strTipo'] == 'Polygon') {
        ?>

        										

       paths: [ 

        <?php echo $row_consultacordenada['textCordenadas']; ?>

                                                    ],

                                                    strokeColor: '<?php echo $row_consultacordenada['strColor']; ?>',

                                                    strokeOpacity: 0.8,

                                                    strokeWeight: 2,

                                                    fillColor: '<?php echo $row_consultacordenada['strBorde']; ?>',

                                                    fillOpacity: 0.35

                                                });

        							  

        									

    <?php
    } elseif ($row_consultacordenada['strTipo'] == 'Polyline') {
        ?>

        										

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
       }, 1000);


    <?php if ($row_consultacordenada['idCordenadas'] == 7) {
        ?>	

      // si es marker llama click																			

     google.maps.event.addListener(<?php echo $row_consultacordenada['strName']; ?>, 'click', function() {
			infowindow<?php echo $row_consultacordenada['idCordenadas']; ?>.open(map,<?php echo $row_consultacordenada['strName']; ?>); });

    <?php } ?>

        </script>
<?php } while ($row_consultacordenada = mysql_fetch_assoc($consultacordenada)); ?>




    <script>
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>


<?php
mysql_free_result($consultacordenada);
mysql_free_result($consultaPaises);

mysql_free_result($consultaRegion);

mysql_free_result($consultaZonas);
mysql_free_result($consultaMunicipio);
mysql_free_result($consultaAlmacen);


?>