<?php
require_once "design-prueba.php";


$saved = false;
$error = "";
define("MAX_SIZE", 1048576);

$error_messages = array(
	1=>'El archivo subido excede el tamaño especificado en max_filesize en php.ini.',
	2=>'El archivo subido excede el tamaño MAX_FILE_SIZE especificado en el formulario HTML.',
	3=>'Solo se subió parcialmente el archivo.',
	4=>'No se subió ningún archivo.',
	6=>'Falta una carpeta temporal.',
	7=>'Error al grabar archivo en la unidad de almacenamiento.',
	8=>'Una extensión PHP detuvo la subida del archivo.'
);

if (isset($_REQUEST['backup']))
{
	header('Content-type: "text/xml"; charset="utf8"');
	header('Content-disposition: attachment; filename="bellsystem-config-'.date("YmdHi").'.xml"');

	$xml = config_load();
	echo $xml->saveXML();
	exit(0);
}
else if (isset($_FILES['restore']))
{
	if ($_FILES['restore']['error'] != UPLOAD_ERR_OK)
	{
		$error=$error_messages[$_FILES['restore']['error']];
	}
	else
	{
		if ($xml = simplexml_load_file($_FILES['restore']['tmp_name']))
		{
			config_save($xml);
			$saved = true;
		}
		else
		{
			$error = "Invalid XML";
		}
	}
}

site_header("Backup/Restore");
?>
<script type="text/javascript">
<!--
window.onload = function() {
	setTimeout("document.getElementById('saved').style.display = 'none'", 1000)
}
// -->
</script>
<form enctype="multipart/form-data" action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<?php echo saved($saved); ?>

<div class="section">Respaldo de configuración</div>
<a href="<?php echo $_SERVER["PHP_SELF"]; ?>?backup">Descargar archivo de configuración</a>
<br /><br />

<div class="section">Restaurar configuración</div>
<input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MAX_SIZE; ?>" />
<input type="file"   name="restore" class="file" />
</form>

<?php if ($error != "") echo "<br /><div class='red'>Error: $error</div>"; ?>
<html>
<title>W3.CSS Template</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=1024">
<link rel="stylesheet" href="css/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="css/all.css">
<style>
body, h1,h2,h3,h4,h5,h6 {font-family: "Montserrat", sans-serif}
.w3-row-padding img {margin-bottom: 12px}
/* Set the width of the sidebar to 120px */
.w3-sidebar {width: 120px;background: #222;}
/* Add a left margin to the "page content" that matches the width of the sidebar (120px) */
#main {margin-left: 0px}
/* Remove margins from "page content" on small screens */
@media only screen and (max-width: 600px) {#main {margin-left: 0}}
</style>
<body class="w3-white">

<!-- Icon Bar (Sidebar - hidden on small screens) -->
<nav class="w3-sidebar w3-bar-block w3-small w3-hide-small w3-center">
  <a href="index.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="fas fa-home w3-xxlarge"></i>
    <p>INICIO</p>
  </a>
  <a href="schedules.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="far fa-clock w3-xxlarge"></i>
    <p>HORARIOS</p>
  </a>
  <a href="calendar.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="far fa-calendar-alt w3-xxlarge"></i>
    <p>CALENDARIO</p>
  </a>
  <a href="settings.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="fas fa-sliders-h w3-xxlarge"></i>
    <p>OPCIONES</p>
  </a>
    <a href="backup.php" class="w3-bar-item w3-button w3-padding-large w3-black w3-text-white">
    <i class="fas fa-history w3-xxlarge"></i>
    <p>RESPALDO</p>
  </a>
      <a href="index.php?logout" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="fas fa-door-open w3-xxlarge"></i>
    <p>SALIR</p>
  </a>
</nav>

<!-- Navbar on small screens (Hidden on medium and large screens) -->
<div class="w3-top w3-hide-large w3-hide-medium" id="myNavbar">
  <div class="w3-bar w3-black w3-opacity w3-hover-opacity-off w3-center w3-small">
    <a href="#" class="w3-bar-item w3-button" style="width:25% !important">INICIO</a>
    <a href="#about" class="w3-bar-item w3-button" style="width:25% !important">ABOUT</a>
    <a href="#photos" class="w3-bar-item w3-button" style="width:25% !important">PHOTOS</a>
    <a href="#contact" class="w3-bar-item w3-button" style="width:25% !important">CONTACT</a>
  </div>
</div>
</html>

<?php site_footer(); ?>
