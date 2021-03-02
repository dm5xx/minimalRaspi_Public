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
ksort ( $json_a); 

echo "var dataSets= " . count($json_a) . ";"."\n";

$validKeysAsStrings = array_keys($json_a) ;

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
        $scriptValue .=  "\t\"" . $key . '" : ' . ''. $temp . ','. "\n";
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
form.setAttribute("action", "submitLabelDef.php"); 

let a = 0;

// create elements <table> and a <tbody>
var masterTable = document.createElement("table");

var masterTblBody = document.createElement("tbody");

var keyCounter = 0;

for (const [mkey, item] of Object.entries(config)) 
{
    var masterRow = document.createElement("tr");
    var masterCell = document.createElement("td");

    var tbl = document.createElement("table");
    tbl.setAttribute("id", "table_"+keyCounter);
    var tblBody = document.createElement("tbody");
    var mrow = document.createElement("tr");
        
    var cell = document.createElement("td");
    var elem = document.createElement('a');
    elem.setAttribute("href", "#");
    
    elem.setAttribute('onClick', "deleteMainEntry("+keyCounter+"); return false;");
    elem.innerHTML = "Bank_"+keyCounter +": ";        
    cell.appendChild(elem);
    mrow.appendChild(cell);

    var cell = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    //temp.setAttribute("readonly", "readonly"); 
    temp.setAttribute("name", mkey+"_"+keyCounter);
    if(mkey.startsWith("label"))
    {
        temp.setAttribute("islabel", true);
        let tempValue = removeIllegalChars(mkey);
        tempValue = tempValue.replace("label", "");

        temp.setAttribute("value", tempValue);
    }
    else
    {
        temp.setAttribute("value", mkey);
    }
    cell.appendChild(temp);
    mrow.appendChild(cell);

    tblBody.appendChild(mrow);

    let objectEntries = Object.entries(item);
    let size = objectEntries.length;
    let indexer = 0;

    for (const [key, value] of objectEntries) 
    {
        var replecedKey = key.replace("p","");

        var row = document.createElement("tr");
        row.setAttribute("id", "row"+keyCounter+"_"+replecedKey);
                
        var cell = document.createElement("td");
        
        if(key.startsWith("pin"))
        {
            var elem = document.createElement('div');
            elem.innerHTML = key + ": ";        
            cell.appendChild(elem);
        }
        else
        {
            var elem = document.createElement('a');
            elem.setAttribute("href", "#");
            if(indexer+1 == size || size < 2)
                elem.setAttribute('onClick', "addEntry("+keyCounter+","+replecedKey+"); return false;");
            else
                elem.setAttribute('onClick', "deleteEntry("+keyCounter+","+replecedKey+"); return false;");
            elem.innerHTML = key + ": ";        
            cell.appendChild(elem);
        }
        row.appendChild(cell);

        var cell = document.createElement("td");
        var temp = document.createElement("input"); 
        temp.setAttribute("type", "text"); 
        temp.setAttribute("name", key+"_"+keyCounter);            
        temp.setAttribute("value", value);
                        
        cell.appendChild(temp);
        row.appendChild(cell);
        tblBody.appendChild(row);
        indexer++;
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
b.setAttribute('onClick', "addMainEntry(); return false;");
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

function addEntry(number, index)
{
    var tabletoadd = document.getElementById("table_"+number);
    var tbodyRef = tabletoadd.getElementsByTagName('tbody')[0];
        
    var cell1 = document.createElement("td");
    var elem = document.createElement('label');
    elem.innerHTML = "p"+(index+1) +": ";        
    cell1.appendChild(elem);
    
    var cell2 = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    temp.setAttribute("name", "p"+(index+1)+"_"+number);
    temp.setAttribute("value", "[]");
    cell2.appendChild(temp);
    
    var newRow = tbodyRef.insertRow(tabletoadd.rows.length-1);
    newRow.appendChild(cell1);
    newRow.appendChild(cell2);

    document.getElementById('dataSets').value = dataSets;
}

function addMainEntry()
{
    var newtbl = document.createElement("table");
    newtbl.setAttribute("border", 1);
    newtbl.setAttribute("id", "table_"+keyCounter);
    var newtblBody = document.createElement("tbody");

    var mrow = document.createElement("tr");

    var cell = document.createElement("td");
    var elem = document.createElement('a');
    elem.setAttribute("href", "#");
    elem.setAttribute('onClick', "deleteMainEntry("+(keyCounter)+"); return false;");
    elem.innerHTML = "Bank_"+keyCounter +": ";        
    cell.appendChild(elem);
    mrow.appendChild(cell);

    var cell = document.createElement("td");
    var temp = document.createElement("input"); 
    temp.setAttribute("type", "text"); 
    temp.setAttribute("name", "label"+dataSets + "_"+keyCounter);
    temp.setAttribute("value", "label"+keyCounter);
    cell.appendChild(temp);
    mrow.appendChild(cell);

    newtblBody.appendChild(mrow);

    for(let a = 0; a < 16; a++)
    {
        var row = document.createElement("tr");
        var cell = document.createElement("td");
        var elem = document.createElement('label');
        elem.innerHTML = "p"+a+": ";        
        cell.appendChild(elem);
        row.appendChild(cell);

        var cell = document.createElement("td");
        var temp = document.createElement("input"); 
        temp.setAttribute("type", "text"); 
        temp.setAttribute("name", "pin"+a+"_"+keyCounter);      
        temp.setAttribute("value", 'Channel '+keyCounter+',Device '+a);

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

function deleteMainEntry(tableNr)
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

function deleteEntry(keyCounter, key)
{
    var toDelete = document.getElementById('row'+keyCounter+"_"+key);
    toDelete.remove();
}


function submitValue()
{
    var inputFields = document.forms["form_datasets"].getElementsByTagName("input");

    let isValid = true;

    for(let a = 0; a < inputFields.length; a++)
    {
        if(inputFields[a].hasAttribute('islabel'))
        {
            let context = inputFields[a].value;
            let getNumber = parseInt(context, 10)

            if(!isNaN(getNumber))
            {
                inputFields[a].setAttribute("hidden", true);
                inputFields[a].value = "label"+context;
            }
            else
            {
                isValid = false;
                alert("Name of a bank is not just a number!");
            }
        }
    }
    // basic error handling

    if(isValid)
    {
        document.getElementById("myForm").submit();
        return;
    }
    alert("Validation not successful");
    location.reload();

}

function removeIllegalChars(s)
{
    return s.trim().replace(/[\s`~!@#$%^&*()_|+\-=?;:'",.<>\{\}\[\]\\\/]/gi, '')
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
