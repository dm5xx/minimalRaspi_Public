<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_POST["p"];
if($p != $token["Token"])
    return;

unset($_POST["p"]);

$nameOfFile = $_POST["File"];
$numberOfDataSets = $_POST["DataSets"];
$nameOfFile .= ".json";

unset($_POST["File"]);
unset($_POST["DataSets"]);

$parts = array_chunk($_POST, count($_POST)/$numberOfDataSets, true);

$result = "{\n";

$correctedArray = array();
$FirstKeyValue = array();
$uniqueDatasetNumbers = array();

for($a =0; $a < count($parts); $a++)
{
    $keys = array_keys ($parts[$a]);
    $values = array_values($parts[$a]);

    $FirstKeyValue[$a] = $values[0];

    $itemExplode = explode("_", $keys[$a]);
    array_push($uniqueDatasetNumbers, $itemExplode[1]);

    unset($parts[$a][$keys[0]]);

    for($b = 0; $b < count($parts[$a]); $b++)
    {
        $correctedArray[$a][str_replace("_".$uniqueDatasetNumbers[$a], "", $keys[$b+1])] = $values[str_replace("_".$uniqueDatasetNumbers[$a], "", $b+1)];
    }
}

for($a =0; $a < count($correctedArray); $a++)
{
    $result .= "\t\"".$FirstKeyValue[$a] . "\": ";

    $comma = ",";
    if($a+1 == count($correctedArray))    
        $comma = "";

    $result .= json_encode($correctedArray[$a], JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT) . $comma . "\n";
}

$result .= "}\n";

echo $result;

$fp = fopen($nameOfFile, 'w');
fwrite($fp, $result);
fclose($fp);

header('Location: ' . $_SERVER['HTTP_REFERER']);
?>