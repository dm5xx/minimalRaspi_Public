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

div {
    font-size:18px;
    color: white;
}

</style>
<body>

<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$r = shell_exec("sudo unzip -o /home/shares/ubs/public/JsonArc/".$_GET['name']." -d /home/shares/ubs/public/JSON");
$a = explode("\n", $r);
foreach($a as $key => $value)
{
    echo "<div>$value</div>";
}
exec("sudo chmod 777 -R /home/shares/ubs/public/JSON");    
echo "</br></br><div>....Done. Window can be closed now!</div>";
?>
</body>