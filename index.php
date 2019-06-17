<?php 
		$server = "tcp:cahyaappserver.database.windows.net";
		$port = 1433;
		$db = "dchyadb";
		$user = "dchya24";
		$pass = "Cahya24!";
	
		try{
			$con = new PDO("sqlsrv:server = $server,1433; Database = $db", "$user", "$pass");
			$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		}catch(PDOException $e){
			print_r($e);
			die;
		}

		if(isset($_GET['delete'])){
			$redirect_back = $_SERVER['HTTP_REFERER'];
			extract($_GET);

			$query = $con->prepare("DELETE FROM keluhan WHERE id=:id");
			$exc = $query->execute([":id" => $id]);

			if($exc){
				header("location: $redirect_back");
			}
		}
?>
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
<div class="row mt-2">
	<div class="col-12">
		<div class="card">
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
							<button type="submit" class="btn btn-block btn-outline-primary" name="submit" value="submit">Submit</button>
						</div>
					</div>

				</form>
			</div>
		</div>
	</div>

	<div class="col-12 mt-3">
		<div class="card">
			<div class="card-header bg-primary text-light">
				<h4> Load Data </h4>
			</div>
			<div class="card-body">
				<table class="table table-striped">
					<thead>
						<tr>
							<th>No</th>
							<th>Name</th>
							<th>Umur</th>
							<th>Keterangan</th>
							<th> Tools </th>	
						</tr>
					</thead>
					<tbody>
						<?php 
							$query = $con->query("SELECT * FROM keluhan");
							$i = 1;
							// if(count($query->fetchAll() == 0)){
							// 	echo "<tr><td colspan=4> No Data Founded. </td></tr>";
							// }
							foreach($query->fetchAll() as $data){
								extract($data);
						?>
						<tr>
							<td> <?php echo $i ?> </td>
							<td> <?php echo $name ?> </td>
							<td> <?php echo $umur ?> </td>
							<td> <?php echo $keterangan ?> </td>
							<td> 
									<a href="?delete&id=<?php echo $id ?>" class="btn btn-danger btn-sm"> Delete </a>
							</td>
						</tr> 
							<?php $i++; } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
</div>

<?php 
	if(isset($_POST['submit'])){
		
		extract($_POST);

		$stmt = $con->prepare("INSERT INTO keluhan(name,umur,keterangan)
			VALUES(?,?,?)");

		$stmt->bindValue(1, $nama);
		$stmt->bindValue(2, $umur);
		$stmt->bindValue(3, $keluhan);
		$stmt->execute();

		echo "<script>  alert('berhasil') </script>";
		echo  "<meta http-equiv='refresh' content='0;'/> ";

	}

?>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>