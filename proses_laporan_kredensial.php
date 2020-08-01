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
$aspek_kredensial = $_POST["aspek_kredensial"];
$pencatatan_asesmen = $_POST["pencatatan_asesmen"];
$saran_perbaikan = $_POST["saran_perbaikan"];
$re_kredensial = $_POST["re_kredensial"];
$create_at = date('Y-m-d H:i:s');

echo "$aspek_kredensial <br>
	  $pencatatan_asesmen <br>
	  $saran_perbaikan <br>
	  $id_pegawai<br>
	  $id_kredensial<br>
";

$insert = $db->prepare("UPDATE kredensial SET aspek_kredensial=:aspek_kredensial, pencatatan_asesmen=:pencatatan_asesmen, saran_perbaikan=:saran_perbaikan, re_kredensial=:re_kredensial  WHERE id_pegawai=:id_pegawai AND id_kredensial=:id_kredensial");
$insert->BindParam(":id_pegawai", $id_pegawai);
$insert->BindParam(":id_kredensial", $id_kredensial);
$insert->BindParam(":aspek_kredensial", $aspek_kredensial);
$insert->BindParam(":pencatatan_asesmen", $pencatatan_asesmen);
$insert->BindParam(":saran_perbaikan", $saran_perbaikan);
$insert->BindParam(":re_kredensial", $re_kredensial);
$insert->execute();

if($insert->rowCount()==0){
	header("location:laporan_hasil_asesmen.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=111");
}else{
	$update_status = $db->prepare("UPDATE status_kredensial SET laporan_asesmen=1,tgl_laporan_asesmen=:create_at WHERE id_kredensial=:id_kredensial AND id_pegawai=:id_pegawai");
	$update_status->BindParam(":id_pegawai", $id_pegawai);
	$update_status->BindParam(":id_kredensial", $id_kredensial);
	$update_status->BindParam(":create_at", $create_at);
	$update_status->execute();
	
	if($update_status->rowCount()==0){
		header("location:laporan_hasil_asesmen.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=111");		
	}else{
		header("location:laporan_hasil_asesmen.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=1");
	}
}
?>