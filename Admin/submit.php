<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_POST["p"];
if($p != $token["Token"])
    return;

unset($_POST["p"]);

$nameOfFile = $_POST["File"];
$nameOfFile .= ".json";

unset($_POST["File"]);

// if(array_key_exists ("Unknown", $_POST)
// {
//     $value = $_POST["Unknown"]
// }


$result = json_encode($_POST, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);
$result = str_replace(" \"[", " [", $result);
$result = str_replace("]\"", "]", $result);

echo $result;

$fp = fopen($nameOfFile, 'w');
fwrite($fp, $result);
fclose($fp);

header('Location: ' . $_SERVER['HTTP_REFERER']);

?>