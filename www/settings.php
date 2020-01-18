<?php
require_once "design.php";
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
	<td class="head">Duración</td>
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
