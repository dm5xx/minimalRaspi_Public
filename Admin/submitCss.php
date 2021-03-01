<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$request = json_decode($_POST["PayLoad"], true);

$positionOfInfoItem = count($request)-1;

$p = $request[$positionOfInfoItem]["p"];
if($p != $token["Token"])
    return;

$nameOfFile = $request[$positionOfInfoItem]["FileName"];
$nameOfFile .= ".json";

unset($request[$positionOfInfoItem]);

$result = json_encode($request, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);

echo $result;

$fp = fopen($nameOfFile, 'w');
fwrite($fp, $result);
fclose($fp);

header("HTTP/1.1 200 OK");
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>