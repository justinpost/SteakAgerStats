<?php
include_once 'config.php';

function parametersOutOfBounds($steakagerId, $humidity, $temprature){
	$control_data = parse_ini_file('controlData.ini', true);
	$steakager_bounds = $control_data[$steakagerId];
	
	$output = "";
	$output = $output.humidityOutOfBounds($humidity, $steakager_bounds);
	$output = $output.tempratureOutOfBounds($temprature, $steakager_bounds);
	return $output;
}

function humidityOutOfBounds($humidity, $bounds){
	if($humidity < $bounds['humidity_low']){
		return "Humidity too low | ".$humidity."% \r\n";
	} else if($humidity > $bounds['humidity_high']){
		return "Humidity too high | ".$humidity."% \r\n";
	} else {
		return "";
	}
}

function tempratureOutOfBounds($temprature, $bounds){
	if((float)$temprature < (float) $bounds['temperature_low']){
		return "Temperature too low | ".$temprature." Celsius.\r\n";
	} else if((float) $temprature > (float) $bounds['temperature_high']){
		return "Temperature too high | ".$temprature." Celsius. \r\n";
	} else {
		return "";
	}
}

function sendMail($steakagerId, $message){
	// In case any of our lines are larger than 70 characters, we should use wordwrap()
	$message = wordwrap($message, 70, "\r\n");
	
	$control_data = parse_ini_file('controlData.ini', true);
	$steakager_data = $control_data[$steakagerId];
	
	//echo "Mail: ".$steakager_data['owner_mail'];
	
	$headers = 'From: steakager@example.com' . "\r\n";
	// Send
	mail($steakager_data['owner_mail'], 'SteakAger in Trouble!', $message, $headers);
}

?>