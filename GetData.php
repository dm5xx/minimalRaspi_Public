<?php

$string = file_get_contents("JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

?>

var myHeaders = new Headers();
myHeaders.append('Content-Type', 'application/json');
myHeaders.append("Authorization", "<?php echo "Basic ". base64_encode("admin:".$p);?>");
myHeaders.append('Connection', 'close');

function GetStatus()
{
    console.log("GetStatus is requested");
            
    fetch('http://'+url+'/Get/', { headers: myHeaders, timeout : 2000})
        .then((response) => { return response.json()})
        .then((data) => {            
            if(data.Callback != undefined)
                RiseCallback(data);
            else
                UpdateUI(data);
            console.log(data);
        })
        .catch((err) => {
            console.log("Client Error: "+err);
        });
}

function loadProfile(profileNr)
{
    console.log("LoadProfile "+profileNr);

    var currentProfile = window["Profile"+profileNr];

    subMitValue(0, currentProfile.Bank0);
    subMitValue(1, currentProfile.Bank1);
    subMitValue(2, currentProfile.Bank2);
    subMitValue(3, currentProfile.Bank3);
}
