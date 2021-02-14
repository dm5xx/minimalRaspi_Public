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
    font-size:25px;
    color: white;
}

</style>
<body>

<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

exec("sudo tar -xzf ".$_GET['name']." -C ../");

echo "<div>Done. Window can be closed now!</div>";
?>
</body>