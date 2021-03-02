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

$keys = array_keys( $_POST ); 
$size = sizeof($keys);
$elementIndex = array();
array_push($elementIndex, 0);

$wodd = "0";

for($a = 0; $a < $size; $a++)
{
    $temp = explode("_", $keys[$a]);

    if($temp[1] != $wodd)
    {
        array_push($elementIndex, $a);
        $wodd = $temp[1];
    }
};

$result = "{\n";

for($a = 0; $a < $size; $a++)
{
    $isFirstElement = in_array($a, $elementIndex);
    $isLastElement = in_array($a+1, $elementIndex);

    $isEnd = false;

    if($a+1 == $size)
    {
        $isLastElement = true;
        $isEnd = true;
    }

    if($isFirstElement)
    {
        $result .= "  \"".$_POST[$keys[$a]]. "\" : { \n";
    }
    else
    {
        $result .= "\t\"".getStrippedValue($keys[$a]) . "\": [" . getStrippedValue($_POST[$keys[$a]]) . "]";

        if(!$isLastElement)
            $result .= ",";
        $result .= "\n";
    };

    if($isLastElement)
    {
        $result .= "  }";

        if(!$isFirstElement && !$isEnd)
            $result .= ",";
        $result .= "\n";
    };
};

$result .= "}\n";

//echo $result;

$fp = fopen($nameOfFile, 'w');
fwrite($fp, $result);
fclose($fp);

header('Location: ' . $_SERVER['HTTP_REFERER']);

function getStrippedValue($s)
{
     if(strpos($s, "_") && !strpos($s, ","))
     {
         return (explode("_", $s))[0];
     }
     else
     {
         if(strpos($s, ","))
         {
             $tempArr = explode(",", $s);
             $tempStr = "";
             $cnt = count($tempArr);
             for($a = 0; $a < $cnt; $a++)
             {
                 $tempStr .= "\"".$tempArr[$a]."\"";

                 if($a+1 < $cnt)
                     $tempStr .= ",";
             }

             return $tempStr;
         }
         else
         {
             return "\"".$s."\"";
         }
     }
}


?>