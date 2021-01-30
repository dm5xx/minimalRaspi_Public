<?php



$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

$nameOfFile = $_GET["file"];

if(strpos($nameOfFile, "roll-") || strpos($nameOfFile, ".json"))
{
    $contentOfFile = file_get_contents($nameOfFile);
    echo nl2br($contentOfFile);    
}
?>