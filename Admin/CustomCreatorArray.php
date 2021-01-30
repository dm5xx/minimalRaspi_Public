<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;


$result = $_GET;

$string = file_get_contents("../JSON/".$result["file"] . ".json");

$decodedJson = json_decode($string, true);
$level1keys = array_keys($decodedJson);

header('Content-Type: application/javascript');

for($a = 0; $a < count($level1keys); $a++)
{
    $level2keys = array_keys($decodedJson[$level1keys[$a]]);
    echo "var " . $level1keys[$a] . "= {\n";
    for($b = 0; $b < count($level2keys); $b++)
    {
        echo "\t\"" . $level2keys[$b] . "\" : ";
        $contentLevel2 = $decodedJson[$level1keys[$a]][$level2keys[$b]];
        $temp = json_encode($contentLevel2);
        
        if($b+1 < count($level2keys))
            echo $temp . ",\n";
        else
            echo $temp;
    }
    echo "\n};\n";
}

?>
