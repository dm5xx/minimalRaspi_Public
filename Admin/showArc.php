<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;


foreach (glob("../JsonArc/json_*") as $filename) {
    echo "<a href=\"unzipper.php?p=".$p."&name=$filename\" target=blank>$filename</a><br/>". "\n";
}
?>