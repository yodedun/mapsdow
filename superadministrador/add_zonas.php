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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO tblCordenadas (strName, strTitle, textDescripcion, textCordenadas, intCategoria, intIcono, intPadre, intSuperpadre, intActivo) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['strName'], "text"),
					   GetSQLValueString($_POST['strTitle'], "text"),
					   GetSQLValueString($_POST['textDescripcion'], "text"),
                       GetSQLValueString($_POST['textCordenadas'], "text"),
                       GetSQLValueString($_POST['intCategoria'], "int"),
					   GetSQLValueString($_POST['intIcono'], "int"),					   
					   GetSQLValueString($_POST['intPadre'], "int"),
					   GetSQLValueString($_POST['intSuperpadre'], "int"),
                       GetSQLValueString(isset($_POST['intActivo']) ? "true" : "", "defined","1","0"));

  mysql_select_db($database_conexionmiura, $conexionmiura);
  $Result1 = mysql_query($insertSQL, $conexionmiura) or die(mysql_error());

	$insertGoTo = "list_paises.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaCategorias = "SELECT * FROM tblCategorias";
$consultaCategorias = mysql_query($query_consultaCategorias, $conexionmiura) or die(mysql_error());
$row_consultaCategorias = mysql_fetch_assoc($consultaCategorias);
$totalRows_consultaCategorias = mysql_num_rows($consultaCategorias);

mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaIconos = "SELECT * FROM tblIcon";
$consultaIconos = mysql_query($query_consultaIconos, $conexionmiura) or die(mysql_error());
$row_consultaIconos = mysql_fetch_assoc($consultaIconos);
$totalRows_consultaIconos = mysql_num_rows($consultaIconos);

mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaPadre = "SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.strTitle FROM 	tblCordenadas WHERE 	tblCordenadas.intCategoria =2";
$consultaPadre = mysql_query($query_consultaPadre, $conexionmiura) or die(mysql_error());
$row_consultaPadre = mysql_fetch_assoc($consultaPadre);
$totalRows_consultaPadre = mysql_num_rows($consultaPadre);

mysql_select_db($database_conexionmiura, $conexionmiura);
$query_consultaPais = "SELECT 	tblCordenadas.idCordenadas, 	tblCordenadas.strName, 	tblCordenadas.strTitle FROM 	tblCordenadas WHERE 	tblCordenadas.intCategoria =1";
$consultaPais = mysql_query($query_consultaPais, $conexionmiura) or die(mysql_error());
$row_consultaPais = mysql_fetch_assoc($consultaPais);
$totalRows_consultaPais = mysql_num_rows($consultaPais);
?>
<?php include('header.php'); ?>
<div class="col-lg-12">
					<div class="col-lg-12 text-right">
                       <p><a class="btn btn-danger " href="javascript:window.history.go(-1);">Regresar</a></p>
                      </div>
<div class="panel panel-default">
                <div class="panel-heading"><h3>Insertar zona</h3></div>
                	<div class="panel-body">
                    
                    <div class="col-lg-3">
                      <form action="<?php echo $editFormAction; ?>" method="POST" name="form1">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nombre (sin espacios, ñ, ni tildes):</label>
                            <input class="form-control" type="text" name="strName" value="">
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Titulo:</label>
                            <input class="form-control" type="text" name="strTitle" value="">
                          </div>
                          <div class="form-group none">
                            <label for="exampleInputEmail1">Descripcion:</label>
                            <input class="form-control"  type="hidden" name="textDescripcion" value="">
                          
                          </div>
                          <div class="form-group">
                            <label for="exampleInputEmail1">Cordenadas:</label>
                            <textarea class="form-control" id="action" name="textCordenadas" rows="4"></textarea>
                          </div>
                          <div class="form-group none">
                            <label for="exampleInputEmail1">Categoria></label>
                            <input class="form-control"  type="hidden" name="intCategoria" value="2">
                           
                          </div>
                          <div class="form-group">
                          <label >Pais</label>
                          <select class="form-control" name="intSuperpadre" value="">
                            <?php
do {  
?>
                            <option value="<?php echo $row_consultaPais['idCordenadas']?>"><?php echo $row_consultaPais['strName']?></option>
                            <?php
} while ($row_consultaPais = mysql_fetch_assoc($consultaPais));
  $rows = mysql_num_rows($consultaPais);
  if($rows > 0) {
      mysql_data_seek($consultaPais, 0);
	  $row_consultaPais = mysql_fetch_assoc($consultaPais);
  }
?>
                          </select>
                          </div>
                          
                          <div class="form-group ">
                            <label>Region</label>
                             <select class="form-control" name="intPadre" value="">
                               <?php
do {  
?>
                               <option value="<?php echo $row_consultaPadre['idCordenadas']?>"><?php echo $row_consultaPadre['strName']?></option>
                               <?php
} while ($row_consultaPadre = mysql_fetch_assoc($consultaPadre));
  $rows = mysql_num_rows($consultaPadre);
  if($rows > 0) {
      mysql_data_seek($consultaPadre, 0);
	  $row_consultaPadre = mysql_fetch_assoc($consultaPadre);
  }
?>
                             </select>
                           
                          </div>
                          
                          <div class="form-group none">
                            <label for="exampleInputEmail1">Icono:</label>
                            <input class="form-control"  type="hidden" name="intIcono" value="">
                        
                          </div>
                          
                          <div class="checkbox">
                            <label>
                              <input type="checkbox" name="intActivo" value="" checked> Activo
                            </label>
                          </div>
                          
                          <button type="submit" class="btn btn-default">Insertar registro</button>
                        <input type="hidden" name="MM_insert" value="form1">
                      </form>
                      
                      </div>
                      <div class="col-lg-9">
                      		<div id="map_canvas"></div>
                      </div>
                    </div>
                    <style type="text/css">#map_canvas {width: 100%; margin: 0; padding: 0; height: 550px }</style>
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&libraries=drawing"></script>

    

    <script type="text/javascript">
var myOptions = {
  center: new google.maps.LatLng(11.26461221250444, -79.3212890625),
  zoom: 5,
  mapTypeId: google.maps.MapTypeId.ROADMAP
};

var drawingManager = new google.maps.drawing.DrawingManager({
      drawingMode: google.maps.drawing.OverlayType.POLYGON,
      drawingControl: true,
      drawingControlOptions: {
        position: google.maps.ControlPosition.TOP_CENTER,
        drawingModes: [google.maps.drawing.OverlayType.POLYGON ]
      },
      polylineOptions: {
        strokeWeight: 2,
        strokeColor: '#ee9900',
        clickable: false,
        zIndex: 1,
        editable: false
      },
      polygonOptions: {
        editable:false
      }
    });

    var map;

      function initialize() {

        map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
        google.maps.event.addListener(map, 'click', function(event) {
          alert(event.latLng);
        });


        drawingManager.setMap(map);
 
      

     

        google.maps.event.addDomListener(drawingManager, 'polygoncomplete', function(polygon) {
            path = polygon.getPath();
            document.getElementById("action").value += "";
            for(var i = 0; i < path.length; i++) {
              document.getElementById("action").value +=  ' new google.maps.LatLng'+ path.getAt(i) + ',\n';
            }
        });
      }

      google.maps.event.addDomListener(window, 'load', initialize);
      google.maps.event.addDomListener(document.getElementById("map_canvas"), 'ready', function() { drawingManager.setMap(map) } );



    </script>
                    
</div>                    
</div>

<?php include('footer.php'); ?>
<?php
mysql_free_result($consultaCategorias);

mysql_free_result($consultaIconos);

mysql_free_result($consultaPadre);

mysql_free_result($consultaPais);
?>
