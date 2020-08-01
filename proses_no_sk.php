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
$no_sk = $_POST["no_sk"];
$tgl_sk = $_POST["tgl_sk"];
$create_at = date('Y-m-d H:i:s');

$insert = $db->prepare("UPDATE `kredensial` SET `no_sk`=:no_sk ,`tgl_sk`=:tgl_sk, status=1 WHERE id_pegawai= :id_pegawai AND id_kredensial=:id_kredensial");
$insert->BindParam(":id_pegawai", $id_pegawai);
$insert->BindParam(":id_kredensial", $id_kredensial);
$insert->BindParam(":no_sk", $no_sk);
$insert->BindParam(":tgl_sk", $tgl_sk);
$insert->execute();

if($insert->rowCount()==0){
	header("location:input_no_sk.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=112");
}else{
	$update_status = $db->prepare("UPDATE `status_kredensial` SET `input_no_sk`=1,`tgl_input_no_sk`=:create_at WHERE id_kredensial=:id_kredensial AND id_pegawai=:id_pegawai");
	$update_status->BindParam(":id_pegawai", $id_pegawai);
	$update_status->BindParam(":id_kredensial", $id_kredensial);
	$update_status->BindParam(":create_at", $create_at);
	$update_status->execute();
	
	if($insert->rowCount()==0){
		header("location:input_no_sk.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=111");		
	}else{
		header("location:input_no_sk.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=1");
	}
}
?>