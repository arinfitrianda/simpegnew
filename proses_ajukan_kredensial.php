<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
if ($tipes[0]!='Simpeg')
{
	unset($_SESSION['tipe']);
	unset($_SESSION['namauser']);
	unset($_SESSION['password']);
	header("location:../index.php?status=2");
	exit;
}

$id_pegawai = $_POST["id_pegawai"];
$nama_mitra_bestari = $_POST["nama_mitra_bestari"];
$create_at = date('Y-m-d H:i:s');

	echo "<br> $id_pegawai
		  <br> $nama_mitra_bestari
		  <br> $create_at
		  ";

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->execute();
$status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);

// $status["pengajuan"];
if($status["pengajuan"] == 1 && $status["penerbitan_rkk"] == 0){
	header("location:pengajuan_kredensial.php?id=$id_pegawai&status=masa_kredensial");
}else{
	$insert = $db->prepare("INSERT INTO kredensial(id_pegawai, nama_mitra_bestari, create_at) VALUES (:id_pegawai,:nama_mitra_bestari,:create_at)");
	$insert->BindParam(":id_pegawai", $id_pegawai);
	$insert->BindParam(":nama_mitra_bestari", $nama_mitra_bestari);
	$insert->BindParam(":create_at", $create_at);
	$insert->execute();
	$last_id = $db->lastInsertId();

	if($insert->rowCount()==0){
		header("location:pengajuan_kredensial.php?id=$id_pegawai&status=112");
	}else{
		$insert_status = $db->prepare("INSERT INTO status_kredensial(id_kredensial, id_pegawai, pengajuan, tgl_pengajuan) VALUES (:id_kredensial, :id_pegawai, 1,:create_at)");
		$insert_status->BindParam(":id_kredensial", $last_id);
		$insert_status->BindParam(":id_pegawai", $id_pegawai);
		$insert_status->BindParam(":create_at", $create_at);
		$insert_status->execute();
		
		if($insert->rowCount()==0){
			header("location:pengajuan_kredensial.php?id=$id_pegawai&status=111");		
		}else{
			header("location:pengajuan_kredensial.php?id=$id_pegawai&status=1");
		}
	}
}
?>