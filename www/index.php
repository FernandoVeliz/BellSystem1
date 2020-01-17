<?php
require_once "design.php";
site_header("Home");
?>
<noscript>
<div class="red"><b>WARNING:</b> You don't have Javascript enabled! Please do not use this Web UI until you enable it; otherwise, you may end up with a corrupt XML file.</div>
<br />
</noscript>

Welcome to the Bell System Web <abbr title="User Interface">UI</abbr>. If this is the first time you've ever been to this site, go through the pages in the order they are listed in the menu to setup the bell system.
<br /><br />
<ul>
<li><b>Horarios</b> &mdash; Crea horarios que hacen sonar la campana en una hora específica</li>
<li><b>Calendario</b>  &mdash; Configura cuándo se van a utilizar estos horarios</li>
<li><b>Opciones</b>  &mdash; Configura cuándo inicia/termina la escuela para activar la campana</li>
<li><b>Respaldo</b>    &mdash; Respalda el archivo de configuración de la campana</li>
</ul>

<p>If you have any questions, you can consult the <a href="http://floft.net/wiki/Bells/Docs.html" target="_blank">documentation</a>.</p>
<?php site_footer(); ?>
