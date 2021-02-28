<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

$result = $_GET;
$string = file_get_contents("../JSON/Custom_css.json");

header('Content-type: text/css');

$dataresult = json_decode($string);

for($int = 0; $int < count($dataresult); $int++ )
{
    $arr = get_object_vars($dataresult[$int]);
    $keys = array_keys($arr);
    $counter = count($keys);
    
    for($a = 0; $a < $counter; $a++)
    {
        if($a == 0)
            echo $arr[$keys[0]]." { \n";
        else
        {
            echo "\t".$keys[$a].": ".$arr[$keys[$a]];

            if($a+1<$counter)
                echo ";";
            echo "\n";
        }
    }
    echo "}\n";
}


?>


