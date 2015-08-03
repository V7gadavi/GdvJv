<?php

session_start();

echo '
<script type="text/javascript">
var checked = false;

function auswahl(checkbox,id)
{
	checked = false;
	';
	echo '
		document.getElementById("btnAus").disabled = true;
		var l = document.getElementsByName("check_list").length;
		for(var i = 0 ; i <= l ; i++){
			if(document.getElementById("check"+i).checked){
				document.getElementById("btnAus").disabled = false;
				break;
			}
		}
		
		';	
	
	echo '
	if (!document.getElementById(id).checked)
    {
	
		document.getElementById(checkbox).innerHTML="Nach Auswahl einer Checkbock erscheint der Preis(wenn vorhanden!)"
	
        document.getElementById(checkbox).innerHTML=xmlhttp.responseText;
        return;
    } else {';
	
	echo '
    	
    }
    if (window.XMLHttpRequest)
    {
        // AJAX nutzen mit IE7+, Chrome, Firefox, Safari, Opera
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // AJAX mit IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById(checkbox).innerHTML=xmlhttp.responseText;
        }
    }
	
	xmlhttp.open("GET","auswerten.php?q="+checkbox,true);
    xmlhttp.send();
}

function auswertung() {
	if (!document.getElementById(id).checked)
    {
        document.getElementById(checkbox).innerHTML="Nach Auswahl einer Checkbock erscheint der Preis(wenn vorhanden!)";
        return;
    }
    if (window.XMLHttpRequest)
    {
        // AJAX nutzen mit IE7+, Chrome, Firefox, Safari, Opera
        xmlhttp=new XMLHttpRequest();
    }
    else
    {
        // AJAX mit IE6, IE5
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    
    xmlhttp.onreadystatechange=function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            document.getElementById(checkbox).innerHTML=xmlhttp.responseText;
        }
    }
	
	xmlhttp.open("GET","auswerten.php?q="+checkbox,true);
    xmlhttp.send();
	
}
</script>
';

// Datei einlesen
// Wenn Datei vorhanden mache weiter

if(isset($_FILES['Datei']['tmp_name'])){
	echo 'Datei vorhanden';
$file = $_FILES['Datei']['tmp_name'];

$row = 0;

if (($handle = fopen($file, "r")) !== FALSE) {
		while(! feof($handle)){
			$curr_data = fgetcsv($handle, 1000, "\t");
			$data[$row] = $curr_data[4];
			$row++;
		}
}
fclose($handle);

$data = array_unique($data);

$_SESSION["data"] = $data; 
} else {
	echo 'Datei nicht vorhanden';
}


// ---------------------------------------------------------------------------//

// Beginne mit Auswertung der Dateien
// Ab hier ist das Tabellenformular verfügbar
$i = 0;



// --------------------------------------------------------------//




// ------------------------------------------------------------------ //

// erstelle Tabelle
echo '
<table>
      <tr>
        <th>Auswahl</th>
        <th>Artikelnummer</th>
        <th>Preis</th>
      </tr>';

	$k = 0;
	                                                                                     
      foreach ($_SESSION["data"] as $key) {
          echo '
          <tr>';
		  echo '<td> <input type="checkbox" name="check_list" value="'.$key.'" id="check'.$k.'" onClick="auswahl(this.value,this.id)"> </td>';
		  echo '<td>'.$key.'</td>';
		  echo '<td> <span id="'.$key.'">Nach Auswahl einer Checkbock erscheint der Preis(wenn vorhanden!)</span> </td>';
          $k++;
echo '
          </tr>
          ';
      }
echo '
    </table>
    <INPUT TYPE=BUTTON VALUE="Zurück" onClick="history.back()">
    <INPUT TYPE=BUTTON id="btnAus" VALUE="Auswerten" disabled="disabled" onClick="auswertung()">
    ';


?>