
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

if ($handle = opendir('../JsonArc/')) {

    while (false !== ($filename = readdir($handle))) {
        if ($filename != "." && $filename != "..") {
            echo "<a href=\"../JsonArc/".$filename."\" download>$filename</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"unzipper_json.php?p=".$p."&name=$filename\" target=blank>Load</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"deleteArc.php?p=".$p."&name=$filename\" target=blank> Delete</a><br/>". "\n";
        }
    }
    closedir($handle);
}
?>
</body>