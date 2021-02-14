
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

a, a:visited {
    font-size:25px;
    color: white;
}

</style>
<body>
<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;


foreach (glob("../JsonArc/json_*") as $filename) {
    echo "<a href=\"$filename\" download>$filename</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"unzipper.php?p=".$p."&name=$filename\" target=blank> Reload</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"deleteArc.php?p=".$p."&name=$filename\" target=blank> Delete</a><br/>". "\n";
}
?>
</body>