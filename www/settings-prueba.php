<?php
require_once "design-prueba.php";
site_header("Settings");

$saved = false;

//also specified in the daemon
define("min_length", 1);
define("max_length", 10);

if (isset($_REQUEST['save'])) {
	$length = $_REQUEST['length'];
	$start  = $_REQUEST['start'];
	$end    = $_REQUEST['end'];
	$method = $_REQUEST['method'];
	$gpio_pin    = $_REQUEST['gpio_pin'];

	$xml->settings->length = $length;
	$xml->settings->start  = str_replace("/","",$start);
	$xml->settings->end    = str_replace("/","",$end);
	$xml->settings->method = $method;

	// Don't set the command from the web interface at the moment for security
	//$command = $_REQUEST['command'];
	//$xml->settings->command = $command;

	if (count($gpio_pin) > 1) {
		$gpio_pin_string = $gpio_pin[0];
		for ($i=1; $i < count($gpio_pin); $i++) {
			$gpio_pin_string .= ("," . $gpio_pin[$i]);
		}
	} else if (count($gpio_pin) == 1) {
		$gpio_pin_string = $gpio_pin[0];
	} else {
		$gpio_pin_string = "";
	}

	$xml->settings->gpio_pin = $gpio_pin_string;

	config_save($xml);
	$saved = true;
}

$length = 3;
$device = "";
$method = "";
$command = "";
$gpio_pin = 4;
$start = "";
$end = "";

foreach ($xml->settings->children() as $setting) {
	$name = $setting->getName();

	if ($name == "length")
		$length = $setting;
	else if ($name == "start")
		$start  = $setting;
	else if ($name == "end")
		$end    = $setting;
	else if ($name == "device")
		$device = $setting;
	else if ($name == "method")
		$method = $setting;
	else if ($name == "command")
		$command = $setting;
	else if ($name == "gpio_pin")
		$gpio_pin = $setting;
}
?>
<script type="text/javascript">
<!--
window.onload = function() {
<?php
//$fields = array("start", "end");
$fields = array("end", "start");

foreach ($fields as $field)
	echo jsDatePick($field);
?>

	setTimeout("document.getElementById('saved').style.display = 'none'", 1000)
};

function check() {
	start = document.getElementById("start").value
	end   = document.getElementById("end").value

	if ( /[^0-9\/]/.test(start) ||
	     /[^0-9\/]/.test(end)   ||
	     start.length != 10     ||
	     end.length   != 10     )
	{
		alert("Please use valid values (e.g. 2000/01/01)")
		return false
	}

	return true
}
// -->
</script>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post" onsubmit="return check()">
<?php echo saved($saved); ?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
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
  <a href="index-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="fas fa-home w3-xxlarge"></i>
    <p>INICIO</p>
  </a>
  <a href="schedules-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="far fa-clock w3-xxlarge"></i>
    <p>HORARIOS</p>
  </a>
  <a href="calendar-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="far fa-calendar-alt w3-xxlarge"></i>
    <p>CALENDARIO</p>
  </a>
  <a href="settings-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-black w3-text-white">
    <i class="fas fa-sliders-h w3-xxlarge"></i>
    <p>OPCIONES</p>
  </a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="fas fa-history w3-xxlarge"></i>
    <p>RESPALDO</p>
  </a>
      <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-text-white">
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

<!-- Page Content -->
<div class="w3-padding-large" id="main">
  <!-- Header/Home -->
  <header class="w3-container w3-padding-32 w3-center w3-white" id="home">
    <h1 class="w3-jumbo"><span class="w3-hide-small">Jardín de niños</span> Ninfa Gutiérrez de Solís</h1>
  </header>

  <!-- About Section -->
  <div class="w3-content w3-justify w3-text-grey w3-padding-64" id="about">
    <h2 class="w3-text-black">Control de timbre</h2>
    <hr style="width:200px" class="w3-opacity">
    <p>Bienvenido al interfaz del timbre. Se recomienda que visite cada una de las categorías en orden para configurar el timbre correctamente.</p><br>
	<ul>
	<li><b>Horarios</b> &mdash; Crea horarios que hacen sonar el timbre en una hora específica</li>
	<li><b>Calendario</b>  &mdash; Configura cuándo se van a utilizar estos horarios</li>
	<li><b>Opciones</b>  &mdash; Configura cuándo inicia/termina la escuela para activar el timbre</li>
	<li><b>Respaldo</b>    &mdash; Respalda el archivo de configuración del timbre</li>
	</ul>



<!-- END PAGE CONTENT -->
</div>

</body>
<table><tr>
	<td class="head">Inicio de periodo escolar<sup>1</sup></td>
	<td>
		<input type="text" name="start" id="start" value="<?php echo from_date($start, "Y/m/d"); ?>" />
	</td>
</tr><tr>
	<td class="head">Fin de periodo escolar<sup>1</sup></td>
	<td>
		<input type="text" name="end" id="end" value="<?php echo from_date($end, "Y/m/d"); ?>" />
	</td>
</tr><tr>
	<td class="head">Duración del timbre</td>
	<td><select name="length" onchange="window.needToConfirm=true"><?php
		for ($i = min_length; $i <= max_length; ++$i)
			echo "<option value='$i'" . (($i==$length)?" selected=\"selected\"":"") . ">$i</option>";
	?></select> segundos</td>
</tr><tr>
	<td class="head">Dispositivo<sup>2</sup></td>
	<td><input type="text" name="device" value="<?php echo $device; ?>" disabled="disabled" /></td>
</tr><tr>
	<td class="head">Comando<sup>2</sup></td>
	<td><input type="text" name="command" value="<?php echo htmlentities($command); ?>" disabled="disabled" /></td>
</tr><tr>
	<td class="head">Método:</td>
	<td><select name="method" onchange="window.needToConfirm=true"/>
	  <?php echo "<option value=\"none\">None</option>" ?>
	  <?php echo "<option value=\"gpio\" " . ($method=="gpio" ? "selected=true" : "") . ">GPIO</option>" ?>
	  <?php echo "<option value=\"serial\" " . ($method=="serial" ? "selected=true" : "") . ">Serial</option>" ?>
	  <?php echo "<option value=\"command\" " . ($method=="command" ? "selected=true" : "") . ">Command</option>" ?>
	</select></td>
</tr>
</table><table>
<tr>
	<td class="head">Pin GPIO</td>
	<?php foreach (array(4, 17, 22, 23, 24, 25) as $value) {
		echo "<td><label><input type=\"checkbox\" name=\"gpio_pin[]\" value=" . $value . " " . (in_array($value, explode(",",$gpio_pin)) ? "checked" : "" ) . ">" . $value . "</label></td>";
	}
	unset($value);
	?>
</tr>
</table>
</form>

<br />
<p>
<sup>1</sup> El sistema del timbre estará activado entre estas fechas.<br />
<sup>2</sup> Esto es solo para referencia; no puede cambiar estos valores desde el interfaz web. Edite manualmente el archivo XML, contacte a un administrador.
</p>
<?php site_footer(); ?>
