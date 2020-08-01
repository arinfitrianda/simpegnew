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

$nama_mitra_bestari = $_POST["nama_mitra_bestari"];
$no_surat_permohonan = $_POST["no_surat_permohonan"];
$tgl_surat_permohonan = $_POST["tgl_surat_permohonan"];
$create_at = date('Y-m-d H:i:s');

$insert = $db->prepare("UPDATE `kredensial` SET `no_surat_permohonan`=:no_surat_permohonan ,`tgl_surat_permohonan`=:tgl_surat_permohonan WHERE nama_mitra_bestari= :nama_mitra_bestari AND status=0");
$insert->BindParam(":nama_mitra_bestari", $nama_mitra_bestari);
$insert->BindParam(":no_surat_permohonan", $no_surat_permohonan);
$insert->BindParam(":tgl_surat_permohonan", $tgl_surat_permohonan);
$insert->execute();

if($insert->rowCount()==0){
	header("location:peserta_kredensial.php?status=114");
}else{
	header("location:peserta_kredensial.php?status=4");
}
?>