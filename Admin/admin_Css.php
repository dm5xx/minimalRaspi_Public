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
    echo "<div>";
    $subsize = count($nodeKeyInfo[$x]);

    for($b = 0; $b < $subsize; $b++)
    {
        $idToChange = $x."_".$b;
        echo "\t<div id=\"".$nodeKeyInfo[$x][$b]."\">".$nodeKeyInfo[$x][$b]." = <a id=\"".$idToChange."\" href=\"#\" onclick=\"update('".$idToChange."','".$nodeKeyInfo[$x][$b]."')\">". $json_a[$validKeysAsStrings[$x]][$nodeKeyInfo[$x][$b]] . "</a>";

        if(strpos($nodeKeyInfo[$x][$b], 'color') !== false)
            echo "\t<span onclick=\"window.open('https://htmlcolorcodes.com/')\" style=\"cursor: pointer; background-color:".$json_a[$validKeysAsStrings[$x]][$nodeKeyInfo[$x][$b]]."\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>";

        echo "</div>\n";
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
    const url ="submitCss.php";

    let info = {
        "FileName" : "../JSON/Custom_css",
        "p" : <?php echo "\"".$p."\"" ?>
    }

    config.push(info);
    let mystr = JSON.stringify(config);

    fetch(url, {
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

function refresh()
{
    location.reload();
}
</script>
</body>
</html>
