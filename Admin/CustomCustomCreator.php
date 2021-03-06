<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

$result = $_GET;
$string = file_get_contents("../JSON/".$result["file"] . ".json");

$decodedJson = json_decode($string, true);

$config = file_get_contents("../JSON/config.json");
$decodedconfigJson = json_decode($config, true);

$decodedJson["numberOfBoards"] = $decodedconfigJson["NumberOfBanks"];

$level1keys = array_keys($decodedJson);

header('Content-Type: application/javascript');

for($a = 0; $a < count($level1keys); $a++)
{
    $value = $decodedJson[$level1keys[$a]];

    if(!is_int($value))
        $value  = "\"".$value."\"";

    echo "const " . $level1keys[$a] ."= ". $value .";\n";
}
?>

function getYourRemoteIP()
{
    if(!useRemoteURL)
    {
        console.log("useRemoteURL is not switched on staying local...");
        console.log("initsteps called...");
        initSteps();
        return;
    }

    var remoteCon = useThisDynDNS + ":" + useRemotePort;
    console.log("Declared useThisDynDNS is: " + useThisDynDNS);
    console.log("Remote is now " + remoteCon);
    url = remoteCon;
    window.setInterval(GetMessages, MessageRequestInterval);
    console.log("initsteps called...");
    initSteps(GetDataPollinterval);
}

function RiseCallback(data)
{
    if(data.Callback == "Reset")
        OpenAdminPage();    
}

function OpenAdminPage()
{
    var win = window.open('Admin/admin.php?p=<?php echo $p;?>', '_blank');
    win.focus();
}