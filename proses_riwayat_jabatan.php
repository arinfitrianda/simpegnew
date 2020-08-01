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
$nama_jabatan = $_POST["nama_jabatan"];
$gol_ruang = $_POST["gol_ruang"];
$no_sk = $_POST["no_sk"];
$tgl_sk = $_POST["tgl_sk"];
$pejabat_sk = $_POST["pejabat_sk"];
$tgl_tmt_sk = $_POST["tgl_tmt_sk"];
$unit_kerja = $_POST["unit_kerja"];
$create_at = date('Y-m-d H:i:s');

$insert= $db->prepare("INSERT INTO riwayat_jabatan(id_pegawai, nama_jabatan, gol_ruang, no_sk, tgl_sk, pejabat_sk, tmt_sk, unit_kerja, create_at) VALUES (:id_pegawai, :nama_jabatan, :gol_ruang,:no_sk, :tgl_sk, :pejabat_sk, :tgl_tmt_sk, :unit_kerja, :create_at)");
$insert->bindParam(":id_pegawai", $id_pegawai);
$insert->bindParam(":nama_jabatan", $nama_jabatan);
$insert->bindParam(":gol_ruang", $gol_ruang);
$insert->bindParam(":no_sk", $no_sk);
$insert->bindParam(":tgl_sk", $tgl_sk);
$insert->bindParam(":pejabat_sk", $pejabat_sk);
$insert->bindParam(":tgl_tmt_sk", $tgl_tmt_sk);
$insert->bindParam(":unit_kerja", $unit_kerja);
$insert->bindParam(":create_at", $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:profil_pegawai.php?id=$id_pegawai&status=112");
}else{
	header("location:profil_pegawai.php?id=$id_pegawai&status=2");
}