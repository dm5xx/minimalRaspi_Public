<?php
    $json = file_get_contents('http://h.mmmedia-online.de/ubs_updates/updates.json');
    $fp = @fopen('update/installedVersions.txt', 'r');
    if ($fp)
        $installedVersions = explode("\n", fread($fp, filesize('update/installedVersions.txt')));
    $obj = json_decode($json, true);
    if ($_GET['Url']) {
 
        $file = file_get_contents($_GET['Url']);
        $fileVersion = $_GET['Version']; 

        $zip_url = $_GET['Url'];
        $destination_path = "update/update.zip";
        file_put_contents($destination_path, fopen($zip_url, 'r'));
        file_put_contents('update/installedVersions.txt', $fileVersion."\n", FILE_APPEND);
        echo shell_exec('sudo /home/shares/ubs/public/update.sh');
        echo "<script>window.location.replace(\"update.php\");</script>";
    }
?>
<html>
<style>
button {
    width: 100%;
    height: 80px;
    font-size: 40px;
}
</style>
<script>
function LoadWithParams(param, purl)
{
    var execUrl = location.protocol + '//' + location.host + location.pathname + '?Url='+param+'&Version='+purl;
    window.location.assign(execUrl);
}
</script><body>
<div>
<?php
echo "<div class=\"bigtext\">Current installed versions: ";
for ($a = 0; $a < count($installedVersions); $a++) {
    echo "&nbsp;".$installedVersions[$a];
}
echo "</div>";

for ($i = 0; $i < count($obj); $i++) {
    echo "<button ";
    if(in_array($obj[$i]['Version'],$installedVersions))
        echo "disabled";
    else
        echo "";
    
    echo " onclick=\"LoadWithParams('".$obj[$i]['URL']."/update_".$obj[$i]['Version'].".zip','".$obj[$i]['Version']."')\">".$obj[$i]['Version']." - ".$obj[$i]['Description']."</button></br>";
}
echo "<button onclick=\"LoadWithParams('".$obj[0]['URL']."/latest.zip')\"> Latest Version complete</button></br>";

?>
</div>
</body>
</html>