<?php
require_once "design-prueba.php";
site_header("Home");
?>
<noscript>
<div class="red"><b>WARNING:</b> You don't have Javascript enabled! Please do not use this Web UI until you enable it; otherwise, you may end up with a corrupt XML file.</div>
<br />
</noscript>

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
  <a href="schedules-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="far fa-clock w3-xxlarge"></i>
    <p>HORARIOS</p>
  </a>
  <a href="calendar-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
    <i class="far fa-calendar-alt w3-xxlarge"></i>
    <p>CALENDARIO</p>
  </a>
  <a href="settings-prueba.php" class="w3-bar-item w3-button w3-padding-large w3-text-white">
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
</html>
<?php site_footer(); ?>
