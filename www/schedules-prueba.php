<?php
require_once "design-prueba.php";
site_header("Schedules");

$columns = 3;

$saved = false;
$schedules = array();

if (isset($_REQUEST['save'])) {
	$names = $_REQUEST['name'];
	$hours = (isset($_REQUEST['hour']))?$_REQUEST['hour']:null;
	$minutes = (isset($_REQUEST['minute']))?$_REQUEST['minute']:null;

	if (($hours == null && $minutes == null) || (is_array($hours) && is_array($minutes) && count($hours) == count($minutes))) {
		$config = array();

		$dom = dom_import_simplexml($xml->schedules);
		$dom->parentNode->removeChild($dom);
		$xml->addChild("schedules");

		foreach ($names as $name_key => $name) {
			$times = array();

			if (isset($hours[$name_key]) && $hours[$name_key] != null )
				foreach ($hours[$name_key] as $hour_key => $hour)
					$times[] = $hours[$name_key][$hour_key] . ":" . $minutes[$name_key][$hour_key];

			$new = $xml->schedules->addChild("schedule");
			$new["id"] = $name_key;
			$new["name"] = addslashes(html_entity_decode(preg_replace("/[^A-Za-z0-9 \-]/", "", $name)));

			foreach ($times as $time)
				$new->addChild("time", $time);
		}

		config_save($xml);
		$saved = true;
	}
}

foreach ($xml->schedules->schedule as $schedule) {
	$id    = $schedule["id"];
	$name  = $schedule["name"];
	$times = array();

	foreach ($schedule->time as $time)
		$times[] = $time;

	$schedules[] = array($id, $name, $times);
}

$total = count($schedules);

function add_time($id, $key, $hour, $minute, $sep="'") {
	echo "<div class=\"time\" id=\"time_${id}_${key}\"><span title=\"Reordenar\">::</span>";
	time_select("[$id][$key]", $hour, $minute);
	echo " <a href=\"javascript:void(0)\" onclick=\"return remove_time($sep$id$sep, $sep$key$sep)\" title=\"Borrar\">x</a></div>";
}

?>
<script type="text/javascript">
<!--
window.onload = function() {
	//http://forums.devshed.com/javascript-development-115/javascript-get-all-elements-of-class-abc-24349.html
	if (document.getElementsByClassName == undefined) {
		document.getElementsByClassName = function(className) {
			var hasClassName = new RegExp("(?:^|\\s)" + className + "(?:$|\\s)");
			var allElements = document.getElementsByTagName("*");
			var results = [];

			var element;
			for (var i = 0; (element = allElements[i]) != null; i++) {
				var elementClass = element.className;
				if (elementClass && elementClass.indexOf(className) != -1 && hasClassName.test(elementClass))
					results.push(element);
			}

			return results;
		}
	}

	get_ids()
	setTimeout("document.getElementById('saved').style.display = 'none'", 1500)
};

function get_ids() {
	divs  = document.getElementsByClassName("schedule")
	lists = new Array()
	window.schedule_times = new Array()

	for (i=0;i<divs.length;i++) {
		if (divs[i].id != "new_schedule") {
			//schedule ids
			id = divs[i].id.split("_")[1]
			lists.push(id)

			//time ids
			children = document.getElementById("sortable_" + id).getElementsByTagName("li")
			window.schedule_times[id]=(children.length-1)
		}
	}

	//get biggest schedule id
	biggest=1

	for (i=0;i<lists.length;i++) {
		if (parseInt(lists[i]) > biggest) biggest = lists[i]
	}

	window.maxid=biggest
}

$(function() {
<?php
for ($i=0; $i < $total; ++$i) {
	$id=$schedules[$i][0];
	echo "\t$( \"#sortable_$id\" ).sortable();\n\t\$( \"#sortable_$id\" ).disableSelection();\n";
}
?>
});

function remove_schedule(id) {
	window.needToConfirm = true

	elem = document.getElementById("schedule_" + id)
	elem.parentNode.removeChild(elem)

	return false
}

function remove_time(id, key) {
	window.needToConfirm = true

	elem = document.getElementById("time_" + id + "_" + key).parentNode
	elem.parentNode.removeChild(elem)

	return false
}

function add_time(id) {
	window.needToConfirm = true
	++window.schedule_times[id]
	new_id = window.schedule_times[id]

	container = document.getElementById("sortable_" + id)
	li = document.createElement('li')
	li.innerHTML = '<?php add_time("'+id+'", "'+new_id+'", 0, 0, ""); ?>'
	container.appendChild(li)

	return false
}

function add_schedule() {
	window.needToConfirm = true
	++window.maxid
	id=window.maxid

	window.schedule_times[id] = 0

	container = document.getElementsByClassName("schedules")[0]

	schedule = document.createElement('div')
	container.appendChild(schedule)
	schedule.className = "schedule"
	schedule.id    = "schedule_" + id

	namediv = document.createElement('div')
	schedule.appendChild(namediv)
	namediv.className = "name"

	input = document.createElement('input')
	namediv.appendChild(input)
	input.type = "text"
	input.name = "name[" + id + "]"
	input.title = "Nombre del horario"

	remove = document.createElement('a')
	namediv.appendChild(remove)
	remove.href = "javascript:void(0)"
	remove.onclick = (function(id){
		return function() { return remove_schedule(id); }
	})(id)
	remove.innerHTML = " x"
	remove.title = "Borrar este horario"

	times = document.createElement('div')
	schedule.appendChild(times)
	times.className = "times"

	ul = document.createElement('ul')
	times.appendChild(ul)
	ul.id = "sortable_" + id

	new_link = document.createElement('div')
	schedule.appendChild(new_link)
	new_link.className = "new"

	link = document.createElement('a')
	new_link.appendChild(link)
	link.href = "javascript:void(0)"
	link.onclick = (function(id){
		return function() { return add_time(id); }
	})(id)
	link.innerHTML = "+"
	link.title = "Agregar una hora al horario"

	$(function() {
		$( "#sortable_" + id ).sortable();
		$( "#sortable_" + id ).disableSelection();
	});

	return false
}
// -->
</script>
<form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
<?php echo saved($saved); ?>
<div class="schedules">
<?php
for ($q=0; $q < $total; ++$q) {
	$id    = $schedules[$q][0];
	$name  = $schedules[$q][1];
	$times = $schedules[$q][2];

	echo <<<EOF
<div class='schedule' id='schedule_$id'>
	<div class="name">
		<input type="text" name="name[$id]" value="$name" onchange="window.needToConfirm=true" /> <a href="javascript:void(0)" onclick="return remove_schedule('$id')" title="Borrar este horario">x</a>
	</div>
	<div class="times">
	<ul id="sortable_$id">
EOF;
	foreach ($times as $key=>$time) {
		$parts = explode(":", $time);
		echo "\n\t\t<li>";
		add_time($id, $key, $parts[0], $parts[1]);
		echo "</li>\n";
	}
echo <<<EOF
	</ul>
	<div class="new"><a href="javascript:void(0)" onclick="return add_time('$id')" title="Agregar una hora al horario">+</a></div>
	</div>
</div>
EOF;
}
?>
</div>
<div class="new_schedule"><div class="schedule" id='new_schedule'><a href="javascript:void(0)" onclick="return add_schedule()" title="Crear un nuevo horario">+</a></div></div>
</form>

<html>
<title>W3.CSS Template</title>
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
  <a href="index-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-black w3-text-white">
    <i class="fas fa-home w3-xxlarge"></i>
    <p>INICIO</p>
  </a>
  <a href="schedules-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-text-white">
    <i class="far fa-clock w3-xxlarge"></i>
    <p>HORARIOS</p>
  </a>
  <a href="#photos" class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-text-white">
    <i class="far fa-calendar-alt w3-xxlarge"></i>
    <p>CALENDARIO</p>
  </a>
  <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-text-white">
    <i class="fas fa-sliders-h w3-xxlarge"></i>
    <p>OPCIONES</p>
  </a>
    <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-text-white">
    <i class="fas fa-history w3-xxlarge"></i>
    <p>RESPALDO</p>
  </a>
      <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hover-black w3-text-white">
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

<?php site_footer(); ?>
