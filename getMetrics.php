<?php
	include_once 'config.php';

	
	$SECONDSHOUR = 3600;
	$SECONDSDAY = 86400;
	
	$dbh = new PDO('mysql:host=localhost;dbname='.$db_name, $db_user, $db_pass);
	
	$StmHumidity = $dbh->prepare("SELECT AVG(humidity) FROM tbl_sensorData WHERE time > (CURRENT_TIMESTAMP - INTERVAL 1 HOUR)");
	$StmHumidity->execute();
	$humHour = $StmHumidity->fetchColumn ();
	
	$StmHumidity = $dbh->prepare("SELECT AVG(humidity) FROM tbl_sensorData WHERE time > (CURRENT_TIMESTAMP - INTERVAL 1 DAY)");
	$StmHumidity->execute();
	$humDay = $StmHumidity->fetchColumn ();
	
	$StmTemperature = $dbh->prepare("SELECT AVG(temperature) FROM tbl_sensorData WHERE time > (CURRENT_TIMESTAMP - INTERVAL 1 HOUR)");
	$StmTemperature->execute(array($SECONDSHOUR));
	$tempHour =$StmTemperature->fetchColumn ();
	
	$StmTemperature = $dbh->prepare("SELECT AVG(temperature) FROM tbl_sensorData WHERE time > (CURRENT_TIMESTAMP - INTERVAL 1 DAY)");	
	$StmTemperature->execute(array($SECONDSDAY));
	$tempDay = $StmTemperature->fetchColumn ();
	
	$StmHumidity = $dbh->prepare("SELECT AVG(humidity) FROM tbl_sensorData");
	$StmTemperature = $dbh->prepare("SELECT AVG(temperature) FROM tbl_sensorData");
	$StmHumidity->execute();
	$StmTemperature->execute();
	$humTotal = $StmHumidity->fetchColumn();
	$tempTotal = $StmTemperature->fetchColumn();
	
	
	$output = array('humidity'=>array('hour'=>$humHour,'day'=>$humDay,'total'=>$humTotal),'temperature'=>array('hour'=>$tempHour,'day'=>$tempDay,'total'=>$tempTotal));
	
	echo json_encode($output);

?>