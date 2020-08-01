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

$id_pegawai = $_GET["id_pegawai"];
$id_str = $_GET["id_str"];
$update = date('Y-m-d H:i:s');

$update = $db->prepare("UPDATE riwayat_str SET status='1', update_at=:update_at WHERE id_str=:id_str AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_str", $id_str);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=113");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=3");
}
?>