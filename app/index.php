<?php

define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'lager');
define('DATABASE_PASSWORD', 'changethis');
define('DATABASE_NAME', 'lagerdb');

// database connection
$db = mysqli_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
if (mysqli_connect_errno()) {
    die("Connection failed: " . mysqli_connect_error());
}

$stock = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM lager ORDER BY id"), MYSQLI_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == "/edit/item") {
	if (isset($_POST['submit_button'])) {
		// change the values based on the request
		$stmt = mysqli_prepare($db, "UPDATE lager SET name = ?, stock = ?, price = ?, cost = ?, manufacturer = ? WHERE id = ?");
		mysqli_stmt_bind_param($stmt, "siiisi", $_POST['stockName'], $_POST['stockInt'], $_POST['stockPrice'], $_POST['stockCost'], $_POST['stockManufacturer'], $_POST['stockId']);
		mysqli_stmt_execute($stmt);
		header('Location: /edit');
		//mysqli_query($db, "UPDATE lager SET name = $_POST['stockName'], stock = $_POST['stockInt'], price = $_POST['stockPrice'], cost = $_POST['stockCost'], manufacturer = $_POST['stockManufacturer'] WHERE id = $_POST['stockId']");
	}
	elseif (isset($_POST['remove_item'])) {
		// prepare query and add user changed values
		$stmt = mysqli_prepare($db, "DELETE FROM lager WHERE id = ?");
		mysqli_stmt_bind_param($stmt, "i", $_POST['stockId']);
		mysqli_stmt_execute($stmt);
		header('Location: /edit');
	}
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_SERVER['REQUEST_URI'] == "/edit/add") {
	if (isset($_POST['add_button'])) {
		$barcd = $_POST['stockInput'];
		// check if exists
		$result = mysqli_query($db, "SELECT * FROM lager WHERE barcode = $barcd");
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			mysqli_query($db, "UPDATE lager SET stock = stock + 1 WHERE barcode = $barcd");
			header('Location: /edit');
		} else {
			mysqli_query($db, "INSERT INTO lager (stock, barcode) VALUES (1, $barcd)");
			header('Location: /edit');
		}
		} elseif (isset($_POST['delete_button'])) {
		$barcd = $_POST['stockInput'];
		// check if exists
		$result = mysqli_query($db, "SELECT * FROM lager WHERE barcode = $barcd");
		$num_rows = mysqli_num_rows($result);
		if ($num_rows > 0) {
			mysqli_query($db, "UPDATE lager SET stock = stock - 1 WHERE barcode = $barcd");
			header('Location: /edit');
		} else {
			die("Can't remove from item that does not exist.");
		}
	}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lager</title>
    <link href="/styles.css" rel="stylesheet">
    <script src="funcs.js"></script>
</head>

<body class="antialiased bg-gray-100">
  <?php if ($_SERVER['REQUEST_URI'] == '/edit'): ?>
	<section class="py-12">
		<div class="container mx-auto px-4">
			<h2 class="text-2xl font-bold mb-4">Edit Stock</h2>
			<p class="mb-4">Welcome to the admin panel. You can manage stock here.</p>
			<form action="/edit/add" method="post">
				<label for="stockInput">Add stock</label>
				<input type="text" id="stockInput" name="stockInput">
				<input type="submit" class="btn border-solid border-sky-500" name="add_button" value="Add">
				<input type="submit" class="btn border-solid border-sky-500" name="delete_button" value="Remove">
			</form>
			<br>
			<input type="text" id="searchTable" onkeyup="tableSearch()" placeholder="Search names..">
    			<table id="stockTable">
        		<tr class"header">
            		  <th>ID</th>
            		  <th>Name</th>
            		  <th>Stock</th>
            		  <th>Price</th>
            		  <th>Cost</th>
			  <th>Manufacturer</th>
			  <th>Barcode</th>
			  <th>Edit</th>
        		</tr>
        		<?php foreach ($stock as $item): ?>
            		<tr>
                          <td><?php echo $item['id'] ?></td>
                	  <td><?php echo $item['name'] ?></td>
                	  <td><?php echo $item['stock'] ?></td>
                	  <td><?php echo $item['price'] ?></td>
                	  <td><?php echo $item['cost'] ?></td>
			  <td><?php echo $item['manufacturer'] ?></td>
			  <td id="barCode"><?php echo $item['barcode'] ?></td>
			  <td><a href="<?php echo '/edit/' . $item['id'] ?>">Edit</a></td>
			</tr>
			<?php endforeach ?>
		</div>
	</section>
  <?php
	elseif (preg_match('/edit\/(\d+)?/', $_SERVER['REQUEST_URI'], $matches)):
		$intId = (int)$matches[1];
		$stockItem = mysqli_fetch_all(mysqli_query($db, "SELECT * FROM lager WHERE id = $intId"), MYSQLI_ASSOC);
?>
	<?php foreach ($stockItem as $stockValue): ?>
	<form action='/edit/item' method="post">
		<input type="hidden" id="stockId" name="stockId" value="<?php echo $matches[1] ?>">
		<label for="stockName">Name</label>
		<input type="text" id="stockName" name="stockName" value="<?php echo $stockValue['name'] ?>"><br>
		<label for="stockInt">Stock</label>
		<input type="text" id="stockInt" name="stockInt" value="<?php echo $stockValue['stock'] ?>"><br>
		<label for="stockPrice">Price</label>
		<input type="text" id="stockPrice" name="stockPrice" value="<?php echo $stockValue['price'] ?>"><br>
		<label for="stockCost">Cost</label>
		<input type="text" id="stockCost" name="stockCost" value="<?php echo $stockValue['cost'] ?>"><br>
		<label for="stockManufacturer">Manufacturer</label>
		<input type="text" id="stockManufacturer" name="stockManufacturer" value="<?php echo $stockValue['manufacturer'] ?>"><br>
		<input type="submit" name="submit_button" value="Submit"><br>
		<input type="submit" name="remove_item" value="Delete">
	</form>
	<?php endforeach ?>
  <?php else: ?>
    <input type="text" id="searchTable" onkeyup="tableSearch()" placeholder="Search names..">
    <table id="stockTable">
        <tr class"header">
            <th>ID</th>
            <th>Name</th>
            <th>Stock</th>
            <th>Price</th>
            <th>Cost</th>
	    <th>Manufacturer</th>
	    <th>Barcode</th>
        </tr>
        <?php foreach ($stock as $item): ?>
            <tr>
                <td><?php echo $item['id'] ?></td>
                <td><?php echo $item['name'] ?></td>
                <td><?php echo $item['stock'] ?></td>
                <td><?php echo $item['price'] ?></td>
                <td><?php echo $item['cost'] ?></td>
		<td><?php echo $item['manufacturer'] ?></td>
		<td><?php echo $item['barcode'] ?></td>
            </tr>
	<?php endforeach; ?>
	<?php endif; ?>
</body>
</html>
