<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

exec("sudo rm ".$_GET['name']);
echo "<div>Arc deleted. Window can be closed now!</div>";
?>