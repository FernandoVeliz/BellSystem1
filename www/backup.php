<?php
require_once "design.php";

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
<?php site_footer(); ?>
