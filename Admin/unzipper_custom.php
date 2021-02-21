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

div {
    font-size:18px;
    color: white;
}

</style>
<body>
<?php
        $r = shell_exec('sudo /home/shares/ubs/public/Shell/update.sh');
        $a = explode("\n", $r);
        foreach($a as $key => $value)
        {
            echo "<div>$value</div>";
        }
        exec("sudo chmod 777 -R /home/shares/ubs/public/JsonArc");
?>
</body>
</html>