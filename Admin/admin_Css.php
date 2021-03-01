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
<style>
div, a, a:visited {
    font-size:25px;
    color: white;
}

.glow-on-hover {
    width: 300px;
    height: 60px;
    font-size: 20px;
    border: none;
    outline: none;
    color: #fff;
    background: #555;
    cursor: pointer;
    position: relative;
    z-index: 0;
    border-radius: 10px;
    margin-top: 10px;
    margin-left: 5px;
}

.glow-on-hover:before {
    content: '';
    background: linear-gradient(45deg, #ff0000, #ff7300, #fffb00, #48ff00, #00ffd5, #002bff, #7a00ff, #ff00c8, #ff0000);
    position: absolute;
    top: -2px;
    left:-2px;
    background-size: 400%;
    z-index: -1;
    filter: blur(5px);
    width: calc(100% + 4px);
    height: calc(100% + 4px);
    animation: glowing 20s linear infinite;
    opacity: 0;
    transition: opacity .3s ease-in-out;
    border-radius: 10px;
}

.glow-on-hover:active {
    color: #333
}

.glow-on-hover:active:after {
    background: transparent;
}

.glow-on-hover:hover:before {
    opacity: 1;
}

.glow-on-hover:after {
    z-index: -1;
    content: '';
    position: absolute;
    width: 100%;
    height: 100%;
    background: #222;
    left: 0;
    top: 0;
    border-radius: 10px;
}

@keyframes glowing {
    0% { background-position: 0 0; }
    50% { background-position: 400% 0; }
    100% { background-position: 0 0; }
}

</style>
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
<button button class="glow-on-hover" onclick="refresh()">undo</button>
<button button class="glow-on-hover" onclick="fireSubmit()">save</button>
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
