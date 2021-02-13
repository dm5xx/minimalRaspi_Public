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
    width: 400px;
    height: 80px;
    font-size: 40px;
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
function LoadWithParams(param)
{
    var execUrl = location.protocol + '//' + location.host + location.pathname + '?'+param+"=true&p=<?php echo $p;?>";
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
</script>
<body>
<div>
<?php
echo "<div id=\"info\">";
$result = shell_exec('sudo /home/shares/ubs/public/Shell/show.sh');
$array = explode("\n", $result);

$number_array = count($array);

echo "Count of Entries: $number_array";
foreach($array as $key => $value)
{
    echo "<div>$value</div>";
}
echo "</div>";

echo "<div style=\"color:white\">";
if ($_GET['start']) {
    if($number_array < 3)
    {
        echo shell_exec('sudo /home/shares/ubs/public/Shell/start.sh');
        echo "<script>setTimeout(ReloadPage, 2000);</script>";
    }
}

if ($_GET['stop']) {
    if($number_array > 2)
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
    echo shell_exec('sudo /home/shares/ubs/public/Shell/arc.sh');
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
    if($number_array < 3)
        echo "<button onclick=\"LoadWithParams('start')\">Start Server! </button></br>";
    if($number_array > 2)
        echo "<button onclick=\"LoadWithParams('stop')\">Stop Server! </button></br>";
?>
</br>
</br>
<button onclick="resetSwitcher()">Reset Switcher</button></br>
</br>
</br>
<button onclick="LoadWithParams('default')">Restore JSONS</button></br>
</br>
</br>
</br>
<button onclick="LoadWithParams('arc')">Archive JSONS</button></br>
</br>
</br>
<button onclick="LoadWithParams('chmod')">Changemod JSON</button></br>
</br>
</br>
<button onclick="LoadWithParams('unix')">ConvertShell2Unix</button></br>
</br>
</br>
<button onclick="LoadWithParams('status')">Show Serverstatus </button></br>
</br>
</br>
<button onclick="LoadWithParams('reboot')">Reboot Raspi! </button></br>
</br>
</br>
<button onclick="LoadWithParams('shutdown')">Shutdown Raspi! </button></br>
</div>
</body>
</html>