<?php include '../API/testConnect.php' ?>
<?php include 'header.php' ?>
<?php
	$isConnect = testConnect($configElasticPath, $indexName);
	if($isConnect){
		header("Location: ".$configPath."PHP/home.php");
		exit();
	}else{
?>
<div id="p4_errorConn" class="text-center">
	<br><br>
	<h3>Terjadi Kesalahan dengan Koneksi Data</h3>
</div>

<?php include 'footer.php'; }?>