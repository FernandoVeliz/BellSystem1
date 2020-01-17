<?php
require_once "design.php";
site_header("Home");
?>
<noscript>
<div class="red"><b>WARNING:</b> You don't have Javascript enabled! Please do not use this Web UI until you enable it; otherwise, you may end up with a corrupt XML file.</div>
<br />
</noscript>

Welcome to the Bell System Web <abbr title="User Interface">UI</abbr>. Si esta es la primera vez que visita el sitio, vaya en orden por cada una de las categorías para configurar el timbre.
<br /><br />
<ul>
<li><b>Horarios</b> &mdash; Crea horarios que hacen sonar el timbre en una hora específica</li>
<li><b>Calendario</b>  &mdash; Configura cuándo se van a utilizar estos horarios</li>
<li><b>Opciones</b>  &mdash; Configura cuándo inicia/termina la escuela para activar el timbre</li>
<li><b>Respaldo</b>    &mdash; Respalda el archivo de configuración del timbre</li>
</ul>


<?php site_footer(); ?>
