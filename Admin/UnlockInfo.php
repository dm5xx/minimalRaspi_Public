<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != "dm5xR2D2")
    return;

?>
<html>
<body>
<div style="font-family:Arial; font-size:50px; color: white">Token: <?php echo $token["Token"];?>
<br>
<br>
<br>
<a style="font-family:Arial; font-size:50px" href="admin.php?p=<?php echo $token["Token"];?>">ADMIN</a>
<br>
<a style="font-family:Arial; font-size:50px" href="../index.php?p=<?php echo $token["Token"];?>">SWITCH</a>

</body>
</html>