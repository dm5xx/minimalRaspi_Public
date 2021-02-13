<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

exec("sudo tar -xzf ".$_GET['name']." -C ../");

echo "<div>Done. Window can be closed now!</div>";
?>