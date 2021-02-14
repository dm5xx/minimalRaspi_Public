<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

?>
<html>
<head>
  <!--meta http-equiv="refresh" content="10"-->
</head> 
<style>
button {
    width: 350px;
    height: 60px;
    font-size: 30px;
}
body{
    background-color: black;
}

#info {
    background-color: cornflowerblue;
    color:#ffffff;
    font-family:Arial;
    font-weight: bold;
	font-size:16px;
    text-decoration:none;
}

</style>
<script>
var arcname = "";

function LoadWithParams(param)
{
    var execUrl = location.protocol + '//' + location.host + location.pathname + '?'+param+"=true&p=<?php echo $p;?>";
    window.location.assign(execUrl);
}

function arcInput()
{
    let tarcname = prompt("Please enter a name for the archive", "");

    arcname =  tarcname.replace(/[^a-z0-9]/ig, '');

    if(arcname != null && arcname != '')
        arcname += "-";

    arcname +=  new Date().toISOString().substr(0, 10);
    
    LoadArchive(arcname);
}

function LoadArchive(param)
{
    var execUrl = location.protocol + '//' + location.host + location.pathname + '?arc=true&p=<?php echo $p;?>&arcname='+arcname;
    window.location.assign(execUrl);
}


function ReloadPage()
{
    var execUrl = location.protocol + '//' + location.host + location.pathname + "?p=<?php echo $p;?>";
    window.location.assign(execUrl);
}

function resetSwitcher()
{
    var execUrl = location.protocol + '//' + location.host + ":3000/ResetSwitcher";
    window.location.assign(execUrl);
}

function showArc() { 
            window.open('showArc.php?p=<?php echo $p ?>', '_blank'); 
} 
</script>
<body>
<div>
<?php

echo "<div id=\"info\">";
$result = shell_exec('sudo /home/shares/ubs/public/Shell/show.sh');
$array = explode("\n", $result);

$number_array = count($array)-2;

$publicversionumber = file_get_contents("publicversion.txt");
echo "Publicfiles: $publicversionumber </br>";

echo "Instances: $number_array";
foreach($array as $key => $value)
{
    echo "<div>$value</div>";
}
echo "</div>";

echo "<div style=\"color:white\">";
if ($_GET['start']) {
    if($number_array < 1)
    {
        echo shell_exec('sudo /home/shares/ubs/public/Shell/start.sh');
        echo "<script>setTimeout(ReloadPage, 2000);</script>";
    }
}

if ($_GET['stop']) {
    if($number_array > 0)
    {
        echo shell_exec('sudo /home/shares/ubs/public/Shell/stop.sh');
        echo "<script>setTimeout(ReloadPage, 2000);</script>";
    }
}

if ($_GET['default']) {
    echo shell_exec('sudo /home/shares/ubs/public/Shell/default.sh');
    echo "<script>setTimeout(ReloadPage, 2000);</script>";
}

if ($_GET['arc']) {
    echo shell_exec('sudo /home/shares/ubs/public/Shell/arc.sh '.$_GET['arcname']);
    echo "<script>setTimeout(ReloadPage, 2000);</script>";
}

if ($_GET['chmod']) {
    echo shell_exec('sudo /home/shares/ubs/public/Shell/chmodjson.sh');
    echo "<script>setTimeout(ReloadPage, 2000);</script>";
}

if ($_GET['unix']) {
    echo shell_exec('sudo /home/shares/ubs/public/Shell/convertScriptsToUnix.sh');
    echo "<script>setTimeout(ReloadPage, 2000);</script>";
}


if ($_GET['status']) {
    $r = shell_exec('sudo /home/shares/ubs/public/Shell/status.sh');
    $a = explode("\n", $r);
    foreach($a as $key => $value)
    {
        echo "<div>$value</div>";
    }
    echo "<script>setTimeout(ReloadPage, 10000);</script>";
}

if ($_GET['updateDocker']) {
    echo "<script>alert('Please check Serverstatus. This may take some time since all is updated... (bigbig download)'); setTimeout(ReloadPage, 2000);</script>";
    shell_exec('/usr/bin/nohup sudo /home/shares/ubs/public/Shell/updatedocker.sh  >/dev/null 2>&1 &');
}

if ($_GET['updatePublicFiles']) {
    echo "<script>alert('Please check your config files.'); setTimeout(ReloadPage, 2000);</script>";
    shell_exec('/usr/bin/nohup sudo /home/shares/ubs/public/Shell/updatepublicfiles.sh  >/dev/null 2>&1 &');
}


if ($_GET['reboot']) {
    echo shell_exec('sudo /home/shares/ubs/public/Shell/reboot.sh');
    echo "<script>setTimeout(ReloadPage, 2000);</script>";
}
if ($_GET['shutdown']) {
    echo shell_exec('sudo /home/shares/ubs/public/Shell/shutdown.sh');
    echo "<script>setTimeout(ReloadPage, 2000);</script>";
}
echo "</div>";
?>
</div>
<div>
</br>
<?php
    if($number_array < 1)
        echo "<button onclick=\"LoadWithParams('start')\">Start Server! </button></br>";
    if($number_array > 0)
        echo "<button onclick=\"LoadWithParams('stop')\">Stop Server! </button></br>";
?>
</br>
<button onclick="resetSwitcher()">Reset Switcher</button></br>
</br>
<button onclick="arcInput()">Archive JSONS</button></br>
</br>
<button onclick="showArc()">Show archived JSONS</button></br>
</br>
<button onclick="LoadWithParams('chmod')">Changemod JSON</button></br>
</br>
<button onclick="LoadWithParams('unix')">ConvertShell2Unix</button></br>
</br>
<button onclick="LoadWithParams('status')">Dockerstatus </button></br>
</br>
<button onclick="LoadWithParams('updatePublicFiles')">Update PublicFiles </button></br>
</br>
<button onclick="LoadWithParams('updateDocker')">Update Server </button></br>
</br>
<button onclick="LoadWithParams('reboot')">Reboot Raspi! </button></br>
</br>
<button onclick="LoadWithParams('shutdown')">Shutdown Raspi! </button></br>
</div>
</body>
</html>