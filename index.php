<?php

$string = file_get_contents("JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

header("Location: go.php?p=".$p);

?>