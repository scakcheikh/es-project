<?php
		
		$dom = new DOMDocument("1.0");
		$node = $dom->createElement("points");
		$parnode = $dom->appendChild($node);

		try
		{
			$bdd = new PDO('mysql:host=localhost;dbname=chark_db;charset=utf8', 'root', 'root');
			$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
		        die('Error While connecting to DB : ' . $e->getMessage());
		}

			$result = $bdd->prepare("SELECT * FROM path ORDER BY id DESC LIMIT 1");
			$result->execute();

			header("Content-type: text/xml");

			while ($point = $result->fetch(PDO::FETCH_ASSOC)) {
				$node = $dom->createElement("point");
				$newnode = $parnode->appendChild($node);
				$newnode->setAttribute("id",$point['id']);
				$newnode->setAttribute("lat",$point['Lat']);
				$newnode->setAttribute("long",$point['Long']);
			}

			echo $dom->saveXML();


 ?>

