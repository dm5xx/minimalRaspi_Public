<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>
<html>
<body>
<a href="server.php?p=<?php echo $p;?>" target=_blank>Admin Server</a><br/>
<a href="admin_config.php?p=<?php echo $p;?>&file=config" target=_blank>Admin Config</a><br/>
<a href="admin_timerprofile.php?p=<?php echo $p;?>&profile=TimerProfile1" target=_blank>Admin TimerProfile</a><br/>
<a href="admin_config.php?p=<?php echo $p;?>&file=BankDef_sc" target=_blank>Admin BankDefinitions</a><br/>
<a href="admin_config.php?p=<?php echo $p;?>&file=Disable_sc" target=_blank>Admin DisableDefinitions</a><br/>
<a href="admin_timerprofile.php?p=<?php echo $p;?>&profile=GroupDef_sc" target=_blank>Admin GroupDefinitions</a><br/>
<a href="showlog.php?p=<?php echo $p;?>" target=_blank>Show Logs</a><br/>
<a href="showCustom.php?p=<?php echo $p;?>" target=_blank>Custom Files</a><br/>
</body>
</html>