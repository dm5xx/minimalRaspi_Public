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

$validKeysAsStrings = array();

$scriptValue = "var config= {\n";
foreach ($json_a as $key => $value){
    $scriptValue .=  '"'. $key . '": {'. "\n";        
    foreach ($value as $key => $value){
        $temp = $value;

        $isArray = is_array($value);
        
        if($isArray)
            $temp = json_encode($value);
    
        if(!$isArray && ($temp == false || $temp == 0))
            $temp = "0";
        $scriptValue .=  "\t\"" . $key . '" : ' . '"'. $temp . '",'. "\n";

        if(!in_array($key, $validKeysAsStrings, true))
            array_push($validKeysAsStrings, $key);
    };
    $scriptValue .= "\t},\n";
};

$scriptValue .= "};\n";

echo $scriptValue;

echo 'var filename = "../JSON/'.$result['file'] . '";'."\n";
echo 'var validKeys = ["'.implode("\",\"",$validKeysAsStrings).'"];'."\n";

?>
</script>
<link rel="stylesheet" href="admin.css">
<body id="body">
    <div id="formcontainer"></div>

<script>
     // Create a form synamically 
const form = document.createElement("form");
form.setAttribute("method", "post"); 
form.setAttribute("name", "form_datasets"); 
form.setAttribute("id", "myForm"); 
form.setAttribute("action", "submitTimer.php"); 

let a = 0;

// create elements <table> and a <tbody>
var masterTable = document.createElement("table");

var masterTblBody = document.createElement("tbody");

var keyCounter = 0;

for (const [mkey, item] of Object.entries(config)) 
{
    var masterRow = document.createElement("tr");
    var masterCell = document.createElement("td");

    // create elements <table> and a <tbody>
    var tbl = document.createElement("table");
    tbl.setAttribute("id", "table_"+keyCounter);
    var tblBody = document.createElement("tbody");

    var mrow = document.createElement("tr");

    var cell = document.createElement("td");
    var elem = document.createElement('a');
    elem.setAttribute("href", "#");
    
    elem.setAttribute('onClick', "deleteEntry("+keyCounter+"); return false;");
    elem.innerHTML = "Action_"+keyCounter +": ";        
    cell.appendChild(elem);
    mrow.appendChild(cell);

    var cell = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    temp.setAttribute("name", mkey+"_"+keyCounter);
    temp.setAttribute("value", mkey);
    cell.appendChild(temp);
    mrow.appendChild(cell);

    tblBody.appendChild(mrow);
    for (const [key, value] of Object.entries(item)) 
    {
        var row = document.createElement("tr");

        for (var i = 0; i < 1; i++) 
        {
            var cell = document.createElement("td");
            var elem = document.createElement('label');
            elem.innerHTML = key + ": ";        
            cell.appendChild(elem);
            row.appendChild(cell);

            var cell = document.createElement("td");
            var temp = document.createElement("input"); 
            temp.setAttribute("type", "text"); 
            temp.setAttribute("name", key+"_"+keyCounter);
            
            if(value == 0)
                temp.setAttribute("value", '0');
            else 
                temp.setAttribute("value", value);
            
            if(key == "IsCurrentlyExec")
                temp.setAttribute("readonly", "readonly");
            
            cell.appendChild(temp);
            row.appendChild(cell);
        }
        tblBody.appendChild(row);
    }

    var mrow = document.createElement("tr");
    var cell = document.createElement("td");
    cell.setAttribute("colspan", "2"); 
    cell.setAttribute("height", "20"); 
    mrow.appendChild(cell);
    tblBody.appendChild(mrow);

    tbl.appendChild(tblBody);

    masterCell.appendChild(tbl);
    masterRow.appendChild(masterCell);
    masterTable.appendChild(masterRow);
    keyCounter++;
}

form.append(masterTable);


var s = document.createElement("input"); 
s.setAttribute("type", "hidden"); 
s.setAttribute("name", "File"); 
s.setAttribute("value", filename); 
form.append(s);  

var f = document.createElement("input"); 
f.setAttribute("type", "hidden");
f.setAttribute("id", "dataSets");
f.setAttribute("name", "DataSets"); 
f.setAttribute("value", dataSets); 
form.append(f); 

var p = document.createElement("input"); 
p.setAttribute("type", "hidden"); 
p.setAttribute("name", "p"); 
p.setAttribute("value", "<?php echo $p;?>"); 
form.append(p); 

var b = document.createElement('button');
b.setAttribute('onClick', "addEntry(); return false;");
b.setAttribute('class', 'glow-on-hover');  
b.textContent = 'add Entry';
form.append(b);

var c = document.createElement('button');
c.setAttribute('onClick', "refresh(); return false;");
c.setAttribute('class', 'glow-on-hover');  
c.textContent = 'undo';
form.append(c);

var s = document.createElement("button"); 
s.setAttribute('onClick', "submitValue(); return false;");
s.setAttribute('class', 'glow-on-hover');
s.textContent = 'Submit';
form.append(s);


document.getElementById('formcontainer').appendChild(form);

function addEntry()
{
    var newtbl = document.createElement("table");
    newtbl.setAttribute("border", 1);
    var newtblBody = document.createElement("tbody");

    var mrow = document.createElement("tr");

    var cell = document.createElement("td");
    var elem = document.createElement('a');
    elem.innerHTML = "Action_"+keyCounter +": ";        
    cell.appendChild(elem);
    mrow.appendChild(cell);

    var cell = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    temp.setAttribute("name", "Action_"+keyCounter);
    temp.setAttribute("value", "Action");
    cell.appendChild(temp);
    mrow.appendChild(cell);

    newtblBody.appendChild(mrow);

    for(a = 0; a < validKeys.length; a++)
    {
        var row = document.createElement("tr");

        var cell = document.createElement("td");
        var elem = document.createElement('label');
        elem.innerHTML = validKeys[a] +": ";        
        cell.appendChild(elem);
        row.appendChild(cell);

        var cell = document.createElement("td");
        var temp = document.createElement("input"); 
        temp.setAttribute("type", "text"); 
        temp.setAttribute("name", validKeys[a]+"_"+keyCounter);
        
        temp.setAttribute("value", '0');

        cell.appendChild(temp);
        row.appendChild(cell);
        newtblBody.appendChild(row);
    }

    var mrow = document.createElement("tr");
    var cell = document.createElement("td");
    cell.setAttribute("colspan", "2"); 
    cell.setAttribute("height", "20"); 
    mrow.appendChild(cell);
    newtblBody.appendChild(mrow);

    newtbl.appendChild(newtblBody);
    masterTable.append(newtbl);

    keyCounter++;
    dataSets+=1;
    document.getElementById('dataSets').value = dataSets;
}

function deleteEntry(tableNr)
{
    if(dataSets == 1)
    {
        alert("Last item cannot be removed!");
        return;
    }

    var toDelete = document.getElementById('table_'+tableNr);
    toDelete.remove();

    dataSets-=1;
    document.getElementById('dataSets').value = dataSets;
}

function submitValue()
{
    var inputFields = document.forms["form_datasets"].getElementsByTagName("input");

    var inputValues = [];

    for(let a = 0; a < inputFields.length; a = a + (validKeys.length+1))
    {
        var blu = inputFields[a].type;
        if(blu != "hidden")
        {
            if(hasWhiteSpace(inputFields[a].value))
            {
                alert("Action title \""+inputFields[a].value+"\" contains space! Please correct.");
                return;
            }

            inputValues.push(inputFields[a].value);
        }
        else
            continue;
    }

    var dupe = hasDuplicates(inputValues);

    if(dupe == true)
    {
        alert("Doublicate action titles detected. Title of action must be unique.");
        return;
    }

    document.getElementById("myForm").submit();
}

function refresh()
{
    location.reload();
}

function hasDuplicates(array) {
    var valuesSoFar = Object.create(null);
    for (var i = 0; i < array.length; ++i) {
        var value = array[i];
        if (value in valuesSoFar) {
            return true;
        }
        valuesSoFar[value] = true;
    }
    return false;
}

function hasWhiteSpace(s) {
    return s.indexOf(' ') >= 0;
}
</script>
</body>
</html>
