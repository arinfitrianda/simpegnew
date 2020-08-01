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

echo "<br> $nama_pegawai
	  <br> $nama_mitra_bestari
	  <br> $create_at
	  ";

$insert = $db->prepare("INSERT INTO set_asesor(id_pegawai, nama_mitra_bestari, create_at) VALUES (:id_pegawai,:nama_mitra_bestari,:create_at)");
$insert->BindParam(":id_pegawai", $id_pegawai);
$insert->BindParam(":nama_mitra_bestari", $nama_mitra_bestari);
$insert->BindParam(":create_at", $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:master.php?status=112");
}else{		
	header("location:master.php?status=2");
}
?>