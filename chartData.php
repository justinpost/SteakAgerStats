<?php

include_once "config.php";

//date_default_timezone_set('America/Curacao');

$dbh = new PDO('mysql:host=localhost;dbname='.$db_name, $db_user, $db_pass);

$output = array("cols"=>array(), "rows"=>array());
array_push($output['cols'], array('id'=>"ti", 'label'=>"Time", 'type'=>"date"));
if ($_GET['data']=="humidity"){
array_push($output['cols'], array('id'=>"h", 'label'=>"Humidity", 'type'=>"number"));
}  else if($_GET['data']=="temperature") {
array_push($output['cols'], array('id'=>"t", 'label'=>"Temperature", 'type'=>"number"));
} else {
	array_push($output['cols'], array('id'=>"h", 'label'=>"Humidity", 'type'=>"number"));
	array_push($output['cols'], array('id'=>"t", 'label'=>"Temperature", 'type'=>"number"));
}

$stmt = $dbh->prepare("SELECT * FROM tbl_sensorData where steakagerID = ?");
if ($stmt->execute(array($_GET['id']))) {
  while ($row = $stmt->fetch()) {
	  
	$date = new DateTime($row['time'], new DateTimeZone('Europe/Amsterdam'));
	$date1 = $date->format('U');

	  
	//$date1 = strtotime($row['time']);
	$date2 = "Date(".date('Y', $date1).", ".((int) date('m', $date1)-1).", ".date('d', $date1).", ".date('H', $date1).", ".date('i', $date1).", ".date('s', $date1).")";
  
	$temp = array();
    $temp[] = array('v' => (string) $date2, 'f'=>date('d-m-Y H:i',$date1));
    if ($_GET['data']=="humidity"){
	$temp[] = array('v' => (float) $row['humidity']);
	}  else if($_GET['data']=="temperature") {
    $temp[] = array('v' => (float) $row['temperature']);
	} else {
		$temp[] = array('v' => (float) $row['humidity']);
		$temp[] = array('v' => (float) $row['temperature']);
	}
	
    array_push($output['rows'], array('c'=> $temp));

  }
}

echo json_encode($output);

?>