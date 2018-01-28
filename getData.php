<?php
	include_once "config.php";
	include_once 'control.php';
	
	//$id = $_GET['id'];
	$id = "<steakagerID>";
	$url = "https://thesteakager.com/status.php?id=".$id;
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$data = curl_exec($ch);
	curl_close($ch);
	$json = json_decode($data , true); 
	
	//var_dump($json);
	$humidity = (float) $json["h"];
	$temp = (float) $json["c"];
	$time = time();
	
	echo "Time: ".date(DATE_RFC2822, $time)."<br/>";
	echo "Humidity: ".$json["h"]."<br />";
	echo "Temp.: ".$json["c"]."<br />";
	
	$warning = parametersOutOfBounds($id, $humidity, $temp);
	if(!$warning==""){
		sendMail($id, $warning);
	}
	echo $warning;
	$dbh = new PDO('mysql:host=localhost;dbname='.$db_name, $db_user, $db_pass);
	
	$stmt = $dbh->prepare("INSERT INTO tbl_sensorData (steakagerID, humidity, temperature) VALUES (:steakagerID, :humidity, :temperature)");
	$stmt->bindParam(':steakagerID', $id);
	$stmt->bindParam(':humidity', $humidity);
	$stmt->bindParam(':temperature', $temp);
	
	$stmt->execute();
	
?>