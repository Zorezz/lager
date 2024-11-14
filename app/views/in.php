<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lager</title>
    <link href="/styles.css" rel="stylesheet">
		<script src="funcs.js"></script>
	</head>
	<body class="antialiased bg-gray-100">
		<section class="py-12">
			<div class="container mx-auto px-4">
				<input type="text" id="itemCheckin" placeholder="Type EAN code or scan...">
				<button id="butCheckin" onclick="checkIn()">Submit</button><br><br>
				<form action="/in/edit" id="form1" style="display:none;" method="post">
					<input type="hidden" id="hiddenEanval" name="hiddenEanval" value="">
					<input type="text" id="itemAmount" name="itemAmount" placeholder="Amount...">
					<input type="submit" value="Submit">
				</form>
			</div>
		</section>
	</body>
</html>
