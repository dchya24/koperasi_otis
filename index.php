<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>Tulis Keluhan Anda</title>
</head>
<body>
<div class="container">

	<div class="card mt-2 w-50">
		<div class="card-header bg-primary text-light">
			<h4>Isi Keluhan Anda</h4>
		</div>
		<div class="card-body">
			<form method="POST">
				<div class="form-group row">
					<label for="inputName" class="col-6 col-form-label">Nama Panjang </label>
					<div class="col-6">
						<input type="text" class="form-control" name="nama" id="inputName" placeholder="Nama Anda..." required>
					</div>
				</div>

				<div class="form-group row">
						<label for="umur" class="col-6 col-form-label">Umur Anda </label>
						<div class="col-6">
							<input type="number" class="form-control" name="umur" id="umur" placeholder="Umur Anda..." required>
						</div>
					</div>

				<div class="form-group row">
					<label for="keluhan" class="col-6 col-form-label">Keluhan Penyakit </label>
					<div class="col-6">
						<textarea class="form-control" name="keluhan" id="keluhan" placeholder=" Keluhan Anda Selama Ini..." required></textarea>
					</div>
				</div>

				<div class="form-group row">
					<div class="offset-6 col-6">
						<button type="submit" class="btn btn-block btn-outline-primary" name="submit">Submit</button>
					</div>
				</div>

			</form>
		</div>
	</div>

</div>

<?php 
	$server = "tcp:cahyaappserver.database.windows.net";
	$port = 1433;
	$db = "dchyadb";
	$user = "dchya24";
	$pass = "cahya24";

	die(print_r(PDO::getAvailableDrivers()));

	try{
		$con = new PDO("sqlsrv:server = $server; Database = $db", "$user", "$pass");
		$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	}catch(PDOException $e){
		print_r($e);
		die;
	}
	
	if(isset($_POST['submit'])){
		extract($_POST);

	}

?>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>