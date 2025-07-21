<?php
	if(!isset($_GET["request"]))
		die("no request");
	
	if($_GET["request"] == "date")
		echo date("Y-m-d H:i:s");
	elseif($_GET["request"] == "rand")
		echo mt_rand(10000, 99999);
	elseif($_GET["request"] == "auction") {
		session_start();
		if(!isset($_SESSION["price"]))
			$_SESSION["price"] = 20;

		$meta = mktime(0, 0, 0, 4, 13, 2014);
		$hoje = time();

		$init = $meta - $hoje;
		$hours = floor($init / 3600);
		$minutes = floor( intval($init / 60) % 60);
		$seconds = $init % 60;
		//$timer = substr(printf("%02d:%02d:%02d", $hours, $minutes, $seconds), 0, 0);
		$timer = gmdate("H:i:s", $init);

		if(mt_rand(0,5) === 3)
			$_SESSION["price"] += 0.50;
		$price = number_format($_SESSION["price"], 2);

		header("Content-Type: application/json");
		echo json_encode(array("price" => $price, "timer" => $timer));
	}
?>