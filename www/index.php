<?php
require_once "design.php";
site_header("Home");
?>
<noscript>
<div class="red"><b>ADVERTENCIA:</b> Javascript no se encuentra activado. Favor de activarlo para evitar fallas en el sistema.</div>
<br />
</noscript>

Bienvenido al interfaz del timbre. <abbr title="User Interface">UI</abbr>. Se recomienda que vaya en orden por cada una de las categorías para configurar el timbre correctamente.
<br /><br />
<ul>
<li><b>Horarios</b> &mdash; Crea horarios que hacen sonar el timbre en una hora específica</li>
<li><b>Calendario</b>  &mdash; Configura cuándo se van a utilizar estos horarios</li>
<li><b>Opciones</b>  &mdash; Configura cuándo inicia/termina la escuela para activar el timbre</li>
<li><b>Respaldo</b>    &mdash; Respalda el archivo de configuración del timbre</li>
</ul>


<?php site_footer(); ?>
