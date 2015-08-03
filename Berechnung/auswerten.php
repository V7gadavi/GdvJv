<?php
session_start();

$pw = $_GET['q'];

$data = $_SESSION["data"];

$sql["host"] = "127.0.0.1";
$sql["user"] = "root";
$sql["pass"] = "";
$sql["db"] = "test";

$con = mysql_connect($sql["host"], $sql["user"], $sql["pass"]);

// Check connection
if (mysqli_connect_errno()){

    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die('Mysql connection error');
}else{
	mysql_select_db($sql["db"], $con) or die ("Die Datenbank existiert nicht.");
	// Formuliere Abfrage
// Dies ist die beste Art, eine SQL Abfrage duerchzuführen
// Für weitere Beispiele, siehe: mysql_real_escape_string()


		$firstname = $pw;
		$abfrage = sprintf("SELECT preis FROM table1 
    			WHERE Artikelnr='%s'",
    			mysql_real_escape_string($firstname));
				
		$ergebnis = mysql_query($abfrage);
		
		if (!$ergebnis) {
    		$message  = 'Ungültige Abfrage: ' . mysql_error() . "\n";
    		$message .= 'Gesamte Abfrage: ' . $query;
    		die($message);
		}
		
		$num_rows = mysql_num_rows($ergebnis);
		
		if($num_rows > 0){
			
			while ($row = mysql_fetch_assoc($ergebnis)) {
				$received_data = $row['preis'];
				echo $received_data;
			}
		} else {
			echo 'Kein Preis in der aktuellen Datenkbank';
		}
}
?>