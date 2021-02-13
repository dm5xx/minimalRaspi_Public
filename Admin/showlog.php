<?php
phpinfo();

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;


foreach (glob("../../roll-*") as $filename) {
    echo "<a href=\"show.php?p=".$p."&file=$filename\" target=blank>$filename</a><br/>". "\n";
}
?>