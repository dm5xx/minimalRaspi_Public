<?php


$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>

<html>
<script type="text/javascript">
</script>
<link rel="stylesheet" href="admin.css">
<body id="body">

<form action="http://<?php echo $_SERVER['SERVER_ADDR'];?>:3000/Message" id="usrform"  method="post">
    <textarea name="Message" rows="4" cols="120"></textarea>
    </br>
    <input type="submit">
</form>

</script>
</body>
</html>
