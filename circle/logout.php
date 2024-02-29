<?php
session_start();
$_SESSION = array();
session_destroy();
echo '<meta http-equiv=REFRESH CONTENT=0;url=index.html>';
?>