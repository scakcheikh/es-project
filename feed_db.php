<?php
		$lat = 59.8586;
		$long = 17.6389;
			
		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=chark_db;charset=utf8', 'root', 'root');
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
		        die('Error While connecting to DB : ' . $e->getMessage());
		}

		for ($i=0; $i < 120 ; $i++) { 
			$result = $bdd->prepare("INSERT INTO path(`Lat`, `Long`) VALUES (?, ?)");

			$result->bindParam(1, $lat);
			$result->bindParam(2, $long);
			$lat += 0.0011;
			$long += 0.0041;
			$result->execute();
			sleep(10);
		}
	
 ?>

