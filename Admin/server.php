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
body{
    background-color: black;
}

#info {
    background-color: #333333;
    color:#ffffff;
    font-family:Arial;
	font-size:16px;
    text-decoration:none;
    border: 1px solid cornflowerblue;
    padding: 2px
}

.glow-on-hover {
    width: 300px;
    height: 60px;
    font-size: 20px;
    border: none;
    outline: none;
    color: #fff;
    background: #555;
    cursor: pointer;
    position: relative;
    z-index: 0;
    border-radius: 10px;
    margin-top: 10px;
    margin-left: 5px;
}

.glow-on-hover:before {
    content: '';
    background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-on-hover:active {
    color: #333
}

.glow-on-hover:active:after {
    background: transparent;
}

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #222;
    left: 0;
    top: 0;
    border-radius: 10px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
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
        $r = shell_exec('sudo /home/shares/ubs/public/Shell/start.sh');
        $a = explode("\n", $r);
        foreach($a as $key => $value)
        {
            echo "$value</br>";
        }
        
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
    exec("sudo chmod 777 -R /home/shares/ubs/public/JSON");
    exec("sudo chmod 777 -R /home/shares/ubs/public/Log");
    exec("sudo chmod 777 -R /home/shares/ubs/public/Shell");
    exec("Changemod executed!");
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
        echo "$value</br>";
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
?>
</div>
<div>
<?php
    if($number_array < 1)
        echo "<button class=\"glow-on-hover\" onclick=\"LoadWithParams('start')\">Start Server!</button>";
    if($number_array > 0)
        echo "<button  class=\"glow-on-hover\" onclick=\"LoadWithParams('stop')\">Stop Server!</button>";
?>
<button class="glow-on-hover" onclick="resetSwitcher()">Reset Switcher</button>
<button class="glow-on-hover" onclick="arcInput()">Archive JSONS</button>
<button class="glow-on-hover" onclick="showArc()">Show archived JSONS</button>
<button class="glow-on-hover" onclick="LoadWithParams('chmod')">Changemod JSON</button>
<button class="glow-on-hover" onclick="LoadWithParams('unix')">ConvertShell2Unix</button>
<button class="glow-on-hover" onclick="LoadWithParams('status')">Dockerstatus </button>
<button class="glow-on-hover" onclick="LoadWithParams('updatePublicFiles')">Update PublicFiles </button>
<button class="glow-on-hover" onclick="LoadWithParams('updateDocker')">Update Server </button>
<button class="glow-on-hover" onclick="LoadWithParams('reboot')">Reboot Raspi! </button>
<button class="glow-on-hover" onclick="LoadWithParams('shutdown')">Shutdown Raspi! </button>
</div>
</body>
</html>