<html>
<head>
  <!--meta http-equiv="refresh" content="10"-->
</head> 
<style>
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

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

exec("sudo rm /home/shares/ubs/public/JsonArc/".$_GET['name']);
echo "<div>Arc deleted. Window can be closed now!</div>";
?>
</body>
</html>