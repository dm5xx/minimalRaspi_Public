<?php

$string = file_get_contents("JSON/Token.json");
$token = json_decode($string, true);

$webConfigFile = file_get_contents("JSON/Custom_sc.json");
$webConfig = json_decode($webConfigFile, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;

?>
<link rel="stylesheet" type="text/css" href="style.css" media="screen"/>
<link rel="stylesheet" type="text/css" href="Admin/CustomCssCreator.php?p=<?php echo $p;?>" media="screen"/>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/init.js"></script>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/ShortCut.js"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCustomCreator.php?p=<?php echo $p;?>&file=Custom_sc"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCreatorArray.php?p=<?php echo $p;?>&file=Profile_sc"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCreator.php?p=<?php echo $p;?>&file=Disable_sc&var=disable"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCreatorArray.php?p=<?php echo $p;?>&file=Label_sc"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCreator.php?p=<?php echo $p;?>&file=BankDef_sc&var=BankLabel"></script>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/Globals.js"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCreatorArray.php?p=<?php echo $p;?>&file=LockDef_sc"></script>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/Lock.js"></script>
<script language="javascript" type="text/javascript" src="Admin/CustomCreatorArray.php?p=<?php echo $p;?>&file=GroupDef_sc"></script>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/Group.js"></script>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/UiHandler.js"></script>
<script language="javascript" type="text/javascript" src="GetData.php?p=<?php echo $p;?>"></script>
<script language="javascript" type="text/javascript" src="SetData.js"></script>
<script language="javascript" type="text/javascript" src="http://h.mmmedia-online.de/minimal63/Helper.js"></script>
<script>
     var url = "<?php

    function startsWith ($string, $startString) 
    { 
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString); 
    } 
    
    if(startsWith($_SERVER['REMOTE_ADDR'], "192.168.") || 
        str_starts_with($_SERVER['REMOTE_ADDR'], "10.") || 
        str_starts_with($_SERVER['REMOTE_ADDR'], "172.16."))
    {
        echo $_SERVER['SERVER_ADDR'].":3000";
    }
    else
    {
        if($webConfig['useRemoteURL'] == 1)
        {
            echo $webConfig['useThisDynDNS'].":".$webConfig['useRemotePort'];
        }
        else
        {
            echo "255.255.255.0";
        }
    }
     ?>";
</script>
<html>
<body>
    <div class="grid-container" id="container">
    </div>
</body>
<script>
    (() => {
        init();
    })()
</script>
</html>