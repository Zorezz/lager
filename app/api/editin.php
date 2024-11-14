<?php
	require __DIR__ . '/modules/db.php';

	// create a DB connection
	$db = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
	// check connection to DB
	if ($db->connect_errno) {
		echo "Failed to connect to DB: " . $db->connect_error;
		exit();
	}

	// check that incoming request is a POST request
	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$ean = $_POST['hiddenEanval'];
		$amnt = (int) $_POST['itemAmount'];

		// check if item already exists.
		$res = $db->query("SELECT * FROM lager WHERE barcode = $ean");
		$num_rows = $res->num_rows;
		if ($num_rows > 0) {
			
		}
	} else {
		echo "Incorrect request type";
	}
?>
