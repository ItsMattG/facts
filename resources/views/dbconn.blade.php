<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Laravel@ mysql db connection </title>
</head>
<body>
	<div>
	<?php
		use Illuminate\Support\Facades\DB;

		if(DB::connection()->getPdo()){
			echo "Successfully connected to DB and DB name is " . DB::connection()->getDatabaseName();
		}
	?>
	</div>
</body>
</html>