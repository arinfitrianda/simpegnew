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
$id_kredensial = $_POST["id_kredensial"];
$tempat_kredensial = $_POST["tempat_kredensial"];
$waktu_kredensial = $_POST["waktu_kredensial"];
$create_at = date('Y-m-d H:i:s');

$insert = $db->prepare("UPDATE `kredensial` SET `tempat_kredensial`=:tempat_kredensial,`tgl_kredensial`=:waktu_kredensial WHERE id_pegawai= :id_pegawai AND id_kredensial=:id_kredensial");
$insert->BindParam(":id_pegawai", $id_pegawai);
$insert->BindParam(":id_kredensial", $id_kredensial);
$insert->BindParam(":tempat_kredensial", $tempat_kredensial);
$insert->BindParam(":waktu_kredensial", $waktu_kredensial);
$insert->execute();

if($insert->rowCount()==0){
	header("location:jadwal_kredensial.php?id=$id_pegawai&id_kredensial=$id_kredensial&status=112");
}else{
	$update_status = $db->prepare("UPDATE `status_kredensial` SET `set_tempat`=1,`tgl_set_tempat`=:create_at WHERE id_kredensial=:id_kredensial AND id_pegawai=:id_pegawai");
	$update_status->BindParam(":id_pegawai", $id_pegawai);
	$update_status->BindParam(":id_kredensial", $id_kredensial);
	$update_status->BindParam(":create_at", $create_at);
	$update_status->execute();
	
	if($insert->rowCount()==0){
		header("location:jadwal_kredensial.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=111");		
	}else{
		header("location:jadwal_kredensial.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=1");
	}
}
?>