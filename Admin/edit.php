<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

$nameOfFile = $_GET["file"];

if(strpos($nameOfFile, "minimal_custom") && strpos($nameOfFile, "_c.js"))
{
    $contentOfFile = file_get_contents($nameOfFile);
    echo "<html><body>"
    echo nl2br($contentOfFile);    
    echo "</body></html>";
}
?>