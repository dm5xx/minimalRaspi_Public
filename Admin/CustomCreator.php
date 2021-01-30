<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

$result = $_GET;
$string = file_get_contents("../JSON/".$result["file"] . ".json");
$variableName = $result["var"];

header('Content-Type: application/javascript');
echo "var " . $variableName . "= " . $string;

?>
