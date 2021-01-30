<?php
$string = file_get_contents("../JSON/Token.json");
$token = json_decode($string, true);

$p = $_GET["p"];
if($p != $token["Token"])
    return;
?>

<html>
<script type="text/javascript">
<?php
$result = $_GET;

if(count($result) < 1 || $result['file'] == null)
    return;

$string = file_get_contents("../JSON/".$result['file'] . ".json");
$json_a = json_decode($string, true);

echo "var dataSets= " . count($json_a) . ";"."\n";
$validKeysAsStrings = array_keys($json_a) ;

$size = count($validKeysAsStrings);

echo "var config = " . $string . ";\n";
echo "var configKeys = Object.keys(config);\n";

echo 'var filename = "../JSON/'.$result['file'] . '";'."\n";
echo 'var nextDataSetNumber = '. $size .";\n";

$nodeKeyInfo = array();

for($a = 0; $a < $size; $a++)
{

    $nodeKeyInfo[] = array_keys($json_a[$validKeysAsStrings[$a]]);

}

echo "var nodeKeyInfo= " . json_encode($nodeKeyInfo, JSON_PRETTY_PRINT). ";\n";

?>
</script>
<link rel="stylesheet" href="admin.css">
<body id="body" style="color: white">

<div id="container">
<?php

$size = count($validKeysAsStrings);

for($x = 0; $x < $size; $x++)
{
    echo "<div><a href='#' onclick='deleteNode(".$x.")' id=\"".$validKeysAsStrings[$x]."\">". $validKeysAsStrings[$x] ."</a>\n";
    $subsize = count($nodeKeyInfo[$x]);

    for($b = 0; $b < $subsize; $b++)
    {
        $idToChange = $x."_".$b;
        echo "\t<div id=\"".$nodeKeyInfo[$x][$b]."\">".$nodeKeyInfo[$x][$b]." = <a id=\"".$idToChange."\" href=\"#\" onclick=\"update('".$idToChange."','".$nodeKeyInfo[$x][$b]."')\">". $json_a[$validKeysAsStrings[$x]][$nodeKeyInfo[$x][$b]] . "</a></div>\n";
    }

    echo "</div><br/><br/>\n";
}
?>
</div>

<div id="myModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <label for="modal_value" id="modal_label"></label>
    <input type="text" id="modal_input" name="modal_input" value="" style="width: 200px"><button id="modal_save">save</button><br><br>
  </div>
</div>

<div>
<button onclick="add('MCP')">add - MCP</button>
<button onclick="add('BIG')">add - Big32</button>
<button onclick="add('LAN')">add - LAN</button>
<button onclick="refresh()">undo</button>
<button onclick="fireSubmit()">save</button>
</div>

<script>

function update(id, labelname)
{
    let element = document.getElementById(id);
    let modalSaveButton = document.getElementById("modal_save");
    
    modalSaveButton.onclick = function() { executeUpdate(id); };

    document.getElementById("modal_input").value = element.innerHTML;

    let modal = document.getElementById("myModal");
    let span = document.getElementsByClassName("close")[0];
    let modal_label = document.getElementById("modal_label");
    modal_label.innerHTML  = labelname +": ";
    modal.style.display = "block";

    span.onclick = function() {
        modal.style.display = "none";
    }
}

function executeUpdate(id)
{
    let modal = document.getElementById("myModal");
    modal.style.display = "none";

    let targetValue = document.getElementById("modal_input").value;

    let targetElement = document.getElementById(id);
    targetElement.innerHTML = targetValue;

    updateConfigNode(id, targetValue);
}

function updateConfigNode(id, value)
{
    let res = id.split("_");

    let levelOneKey = configKeys[res[0]];
    let levelTwoKey = nodeKeyInfo[res[0]][res[1]];


    config[levelOneKey][levelTwoKey] = value;
}

function fireSubmit()
{
    const url ="submitSwitchBuilderDef.php";
    config.File = "../JSON/SwitchBuilderDef";
    config.p = <?php echo "\"".$p."\"" ?>;

    let mystr = JSON.stringify(config);

    fetch('submitSwitchBuilderDef.php', {
        method: 'POST', // or 'PUT'
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'PayLoad='+mystr

    })
    .then(response => response)
    .then(data => {
        console.log('Success:', data);
        refresh();
    })
    .catch((error) => {
        console.error('Error:', error);
    });

}

function add(type)
{
    let getLastfromLastEntry = config["S"+(nextDataSetNumber-1)].LastBankNr;

    let newMCP = {
        Name : "S"+nextDataSetNumber,
        Type : type,
        NumberOfBanks : 0,
        FirstBankNr : getLastfromLastEntry+1,
        LastBankNr : 0
    };

    let keys = Object.keys(newMCP);

    if(type == "LAN")
        newMCP.Ip_Port = "192.168.0.0";
    
    let x = nextDataSetNumber;
    let b = 0;

    let cont = document.getElementById("container");

    let titleDiv = document.createElement("div");
    titleDiv.setAttribute("id", newMCP.Name);
    titleDiv.innerHTML = newMCP.Name;

    let labels = [ "Type", "NumberOfBanks", "FirstBankNr", "LastBankNr"];

    if(type == "LAN")
    {
        labels[4] = "Ip_Port";
        keys.push("Ip_Port");
    }


    for(let a = 0; a < labels.length; a++)
    {
        let idToChange = x+"_"+b;
        let d = document.createElement("div"); 
        d.setAttribute("id", labels[a]);

        d.innerHTML = labels[a]+" = <a id=\""+idToChange+"\" href=\"#\" onclick=\"update('"+idToChange+"', '"+labels[a]+"')\">"+newMCP[keys[a+1]]+"</a></div>";

        titleDiv.appendChild(d);
        b++;
    }
    cont.appendChild(titleDiv);
    let br = document.createElement("br");
    cont.appendChild(br);
    let bb = document.createElement("br");
    cont.appendChild(bb);

    delete newMCP["Name"];
    config["S"+nextDataSetNumber] = newMCP;
    configKeys.push("S"+nextDataSetNumber);
    nodeKeyInfo.push(labels);

    nextDataSetNumber++;
}

function refresh()
{
    location.reload();
}

function deleteNode(id)
{
    if(nextDataSetNumber == 1)
    {
        alert("Last element cannot be removed!");
        return;
    }

    delete config["S"+id];
    delete configKeys.splice(id,1);
    delete nodeKeyInfo.splice(id,1);

    nextDataSetNumber--;
    fireSubmit();
}

</script>
</body>
</html>
