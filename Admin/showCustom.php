<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;


foreach (glob("minimal_custom/*_c.js") as $filename) {
    echo "<a href=\"edit.php?p=".$p."&file=$filename\" target=blank>$filename</a><br/>". "\n";
}
?>