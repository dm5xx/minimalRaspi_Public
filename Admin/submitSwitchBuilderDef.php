<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$request = json_decode($_POST["PayLoad"], true);

$p = $request["p"];
if($p != $token["Token"])
    return;

unset($request["p"]);

$nameOfFile = $request["File"];
$nameOfFile .= ".json";

unset($request["File"]);

foreach ($request as $key => $value) {
    if(isset($value["PinMap"]))
    {
        if(!is_array($value["PinMap"]))
        {
            $request[$key]["PinMap"] = explode(",",$value["PinMap"]);
        }
    }
}

$result = json_encode($request, JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT);

echo $result;

$fp = fopen($nameOfFile, 'w');
fwrite($fp, $result);
fclose($fp);

header("HTTP/1.1 200 OK");
header('Location: ' . $_SERVER['HTTP_REFERER']);

?>