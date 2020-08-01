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
$id_jabatan = $_POST["id_jabatan"];
$gol_ruang = $_POST["gol_ruang"];
$no_sk = $_POST["no_sk"];
$tgl_sk = $_POST["tgl_sk"];
$pejabat_sk = $_POST["pejabat_sk"];
$tmt_sk = $_POST["tmt_sk"];
$unit_kerja = $_POST["unit_kerja"];
$update = date('Y-m-d H:i:s');

echo "<br> $id_pegawai
	  <br> $gol_ruang
	  <br> $no_sk
	  <br> $pejabat_sk
	  <br> $tmt_sk
	  <br> $unit_kerja";

$update = $db->prepare("UPDATE riwayat_jabatan SET gol_ruang=:gol_ruang, no_sk=:no_sk, tgl_sk=:tgl_sk, pejabat_sk=:pejabat_sk, tmt_sk=:tmt_sk, unit_kerja=:unit_kerja, update_at=:update_at WHERE id_jabatan=:id_jabatan AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_jabatan", $id_jabatan);
$update->BindParam(":gol_ruang", $gol_ruang);
$update->BindParam(":no_sk", $no_sk);
$update->BindParam(":tgl_sk", $tgl_sk);
$update->BindParam(":pejabat_sk", $pejabat_sk);
$update->BindParam(":tmt_sk", $tmt_sk);
$update->BindParam(":unit_kerja", $unit_kerja);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=112");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=2");
}
?>