<?php

$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>
<html>
<style>
a, a:visited {
    font-size:25px;
    color: white;
}

body{
    background-color: black;
}
</style>
<body>
<a href="server.php?p=<?php echo $p;?>" target=_blank>Admin - Server: Start,Stop,Kill,Restore JSON, Archive JSON, Shutdown Server...</a><br/>
<a href="admin_basic.php?p=<?php echo $p;?>&file=config" target=_blank>Admin - Config: Configure the Server_Configuration parts (GPIO, Big32, Watchdogs, logging)...</a><br/>
<a href="admin_basic.php?p=<?php echo $p;?>&file=Token" target=_blank>Admin - Token: Edit the Securitytoken...</a><br/>
<a href="admin_switchbuilderDef.php?p=<?php echo $p;?>&file=SwitchBuilderDef" target=_blank>Admin - Create Switches: Configure the different Switches you want to use...</a><br/>
<a href="admin_basic.php?p=<?php echo $p;?>&file=Custom_sc" target=_blank>Admin - WebConfig: Configure the RemoteSwitching_Configuration parts...</a><br/>
<a href="admin_timerprofile.php?p=<?php echo $p;?>&file=TimerProfile1" target=_blank>Admin - TimerProfile: Set and Update the Timer jobs...</a><br/>
<a href="admin_extended.php?p=<?php echo $p;?>&file=BankDef_sc" target=_blank>Admin - Bank: Configure your BankLabels...</a><br/>
<a href="admin_extended.php?p=<?php echo $p;?>&file=Disable_sc" target=_blank>Admin - Disable: Configure all buttons who should be disbaled...</a><br/>
<a href="admin_lockDef.php?p=<?php echo $p;?>&file=LockDef_sc" target=_blank>Admin - Lock: Define all the pins over banks, who should be slotlocked</a><br/>
<a href="admin_groupDef.php?p=<?php echo $p;?>&file=GroupDef_sc" target=_blank>Admin - Groups: Define the grouped together pins of a Bank</a><br/>
<a href="showlog.php?p=<?php echo $p;?>" target=_blank>Show Logs</a><br/>
<a href="admin_message.php?p=<?php echo $p;?>" target=_blank>Send message</a><br/>
</body>
</html>