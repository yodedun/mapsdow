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
$query_consultaPaises = "SELECT * FROM tblCordenadas WHERE tblCordenadas.intCategoria = 1";
$consultaPaises = mysql_query($query_consultaPaises, $conexionmiura) or die(mysql_error());
$row_consultaPaises = mysql_fetch_assoc($consultaPaises);
$totalRows_consultaPaises = mysql_num_rows($consultaPaises);


mysql_select_db($database_conexionmiura, $conexionmiura);

$query_consultacordenada = "SELECT tblCordenadas.idCordenadas, tblCordenadas.strName, tblCordenadas.textCordenadas, tblCordenadas.intCategoria, tblCordenadas.intActivo, tblCategorias.strTipo, tblCategorias.strBorde, tblCategorias.strColor, tblCordenadas.textDescripcion, tblCordenadas.strTitle, tblCordenadas.intIcono FROM tblCordenadas , tblCategorias WHERE tblCordenadas.intCategoria = tblCategorias.idCategoria";

$consultacordenada = mysql_query($query_consultacordenada, $conexionmiura) or die(mysql_error());

$row_consultacordenada = mysql_fetch_assoc($consultacordenada);

$totalRows_consultacordenada = mysql_num_rows($consultacordenada);


?>
<?php include("headerglobal.php"); ?>
        <body>
	<?php include("header.php"); ?>


	<div class='options'>
      <div>
      
           <div class="col-sm-12">
            <div class="panel-group" id="accordion">
              <?php do { ?>       
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                        <label> <input class="paisC" data-map="<?php echo $row_consultaPaises['strName']; ?>" type="checkbox" checked > </label>
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $row_consultaPaises['idCordenadas']; ?>">
                        <?php echo $row_consultaPaises['strTitle']; ?> </a>
                        </h4>
                    </div>
                    <div id="collapse<?php echo $row_consultaPaises['idCordenadas']; ?>" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-pencil text-primary"></span><a href="http://www.jquery2dotnet.com">Articles</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-flash text-success"></span><a href="http://www.jquery2dotnet.com">News</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-file text-info"></span><a href="http://www.jquery2dotnet.com">Newsletters</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-comment text-success"></span><a href="http://www.jquery2dotnet.com">Comments</a>
                                        <span class="badge">42</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
      <?php } while ($row_consultaPaises = mysql_fetch_assoc($consultaPaises)); ?>
            </div>
        </div>
        
          <ul class="list-group">

            <li class="list-group-item">
              
            </li>
              
           
        </ul>
      </div>  

    </div>
<!--begin map -->  


    <div id="map-canvas">

    </div>
<!--end map -->




<?php include('footer.php'); ?>


<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=true"></script>
<script>
	
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

								}, 1000);


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

				}, 800);

							

						  

				  google.maps.event.addDomListener(window, 'load', initialize);



						  

</script>

                                        
<?php

mysql_free_result($consultacordenada);
mysql_free_result($consultaPaises);


?>