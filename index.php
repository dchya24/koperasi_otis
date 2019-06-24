<?php

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateBlobBlockOptions;

define("BASE_DIR", __DIR__);
	define("ACCOUNT_NAME",  "dchyawebapp");
	define("ACCOUNT_KEY",  "Kopn5QCtMmkQm0M4VeIpmu9F0KTslhDD+RFyw8FLplnQQfd9kLZxZcHZr/Tk5+ri8sQHStMt0Yi2hIMWkuMkNg==");

	require 'core/randomString.php';
	require_once 'vendor/autoload.php';

	$connectionString = "DefaultEndpointsProtocol=https;AccountName=".ACCOUNT_NAME.";AccountKey=".ACCOUNT_KEY . ";EndpointSuffix=core.windows.net";

	// $containerName = "blockblobs". getRandomString(10);
	$containerName = "blockblobsdbfpceyhip";
	
	$blobClient = BlobRestProxy::createBlobService($connectionString);
	$createCointainerOptions = new CreateContainerOptions();

	$createCointainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

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
<div class="container-fluid">

	<div class="row mt-2">
		<div class="col-lg-6 mb-2">
			<div class="card">

				<div class="card-header bg-primary text-light">
					<h4>Submission Terakhir</h4>
				</div>

				<div class="card-body">

					<form action="" method="post" enctype="multipart/form-data" class="form">
						<div class="form-group row">
							<label for="" class="col-4"> Pilih File </label>
							<div class="col-6">
								<input type="file" class="form-control-file" accept="image/*" name="file" id="" placeholder="" aria-describedby="fileHelpId" required>
								<small id="fileHelpId" class="form-text text-muted">satu file saja</small>
							</div>
						</div>	
						<div class="form-group row">
							<div class="offset-4 col-6">
								<button type="submit" class="btn btn-primary" name='submit'> Upload </button>
							</div>
						</div>
					</form>

				</div>

			</div>
		</div>

		<div class="col-lg-6">
			<div class="card">
				<div class="card-header bg-primary text-light">
					<h4> List Of Blobs</h4>
				</div>
				<div class="card-body">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No </th>
								<th>Nama </th>
								<th> Aksi </th>
							</tr>
						</thead>
						<tbody>
						<?php
							$int = 1; 
							do{
										$result = $blobClient->listBlobs($containerName, $listBlobsOptions);
										if(count($result->getBlobs()) == 0){
											echo "<tr> <td colspan='3'> No Data </td> </tr>";
										}
										foreach ($result->getBlobs() as $blob)
										{
						?>
							<tr>
								<td> <?php echo $int; ?> </td>
								<td><?php echo $blob->getName()?></td>
								<td>
									<button onclick="detailBlob('<?php echo $blob->getName() . 'ASDA' . $blob->getUrl(); ?>')" class="btn btn-success btn-sm">Detail </button>
									<a href="?action=delete&q=<?php echo $blob->getName(); ?>" class="btn btn-sm btn-outline-danger"> Delete </a>
								</td>
							</tr>
						<?php $int++;
								}
								
										// $listBlobsOptions->setContinuationToken($result->getContinuationToken());
								} while($result->getContinuationToken());
						?>
						</tbody>
					</table>

				</div>
			</div>
		</div>

	</div>

	<div class="row">
		<div class="col-lg-12 my-2 d-none" id="detail">
			<div class="card">
				<div class="card-header bg-primary text-light">
					<h4> Detail Blob</h4>						
				</div>
				<div class="card-body row">
					<div class="col-12">
							<div class="form-group row">
								<label for="inputName" class="col-4 col-sm-1-12 col-form-label">Blob Name</label>
								<div class="col-6 col-sm-1-12" id="blob_name">

								</div>
							</div>

							<div class="form-group row">
								<label for="inputName" class="col-4 col-sm-1-12 col-form-label">Blob Link</label>
								<div class="col-6 col-sm-1-12" id="blob_name">
									<input type="text" class="form-control" name="" id="link_blob">
								</div>
							</div>
							<div class="form-group row">
								<div class="offset-4 col-6 col-sm-1-12">
									<button class="btn btn-sm btn-outline-primary" onclick="analyzeGambar()"> Analyze Gambar </button>
								</div>
							</div>
						</div>

						<div class="col-lg-6 text-center">
							<img src="" alt="" id="image" class="img-fluid img-thumbnail">
						</div>
						<div class="form-group col-lg-6">
							Keterangan : 
							<textarea class="form-control" name="" id="keterangan" rows="25" disabled></textarea>
						</div>
				</div>
			</div>
		</div>
	</div>
</div>

<?php 
	if(isset($_POST['submit'])){
		// die(print_r($_FILES['file']));
		$file = $_FILES['file'];
		$filename = $file['name'];

		$content = fopen($file['tmp_name'], "r");
		
		// Mengunggah blob
		try{
			$blobClient->createBlockBlob($containerName, $filename, $content);

			$url = $_SERVER['HTTP_REFERER'];
			echo "<script>  alert('berhasil') </script>";
			echo "<script>  window.location.href = '$url' </script>";

		}catch(Exception $r){
			print_r($r);
		}
	}

	if($_GET['action'] == 'delete'){
		extract($_GET);
		
		$delete = $blobClient->deleteBlob($containerName, $q);
		$delete =true;
		if($delete){
			$url = $_SERVER['HTTP_REFERER'];
			echo "<script>  alert('berhasil') </script>";
			echo "<script>  window.location.href = '$url' </script>";
		}
	}

?>
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>
	function detailBlob(data){
		var arr = data.split("ASDA");
		console.log(arr);
		$("#detail").removeClass("d-none");
		$("#image").attr("src", arr[1])
		document.getElementById("blob_name").innerHTML = arr[0];
		document.getElementById("link_blob").value = arr[1];
	}

	function analyzeGambar(){
		let url_data = $("#link_blob").val()

		// config for computer vision
		let subscriptionKey = "514bf117c2dd4530ae614f3667940eff";
		let uriBase = "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";

		let params = {
			"visualFeatures": "Categories,Description,Color",
			"details" : "",
			"language" : "en"
		}

		$.ajax({
			url: uriBase + '?' + $.param(params),

			beforeSend: function(xhrObj){
				xhrObj.setRequestHeader("Content-Type", "application/json")
				xhrObj.setRequestHeader(
					"Ocp-Apim-Subscription-Key", subscriptionKey
				)
			},
			type: "POST",
			data: `{ "url" : '${url_data}' }`
		}).done((data) => {
			$("#keterangan").parent().siblings().removeClass('d-none')
			$("#keterangan").val(JSON.stringify(data, null, 2))
		}).fail(function(jqXHR, textStatus, errorThrown) {
				// Display error message.
				var errorString = (errorThrown === "") ? "Error. " :
						errorThrown + " (" + jqXHR.status + "): ";
				errorString += (jqXHR.responseText === "") ? "" :
						jQuery.parseJSON(jqXHR.responseText).message;
				alert(errorString);
		})
	}
</script>
</body>
</html>