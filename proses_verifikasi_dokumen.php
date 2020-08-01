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
$str = $_POST["str"];
$ijazah = $_POST["ijazah"];
$transkrip = $_POST["transkrip"];
$sertif_pelatihan = $_POST["sertif_pelatihan"];
$training_record = $_POST["training_record"];
$log_book = $_POST["log_book"];
$clinical_privilege = $_POST["clinical_privilege"];
$spkk_sebelumnya = $_POST["spkk_sebelumnya"];
$create_at = date('Y-m-d H:i:s');

// $query = 
$insert = $db->prepare("INSERT INTO `verifikasi_bukti`(`id_pegawai`, `id_kredensial`, `str`, `ijazah`, `transkrip`, `sertif_pelatihan`, `training_record`, `log_book`, `clinical_privilege`, `spkk_sebelumnya`) VALUES (:id_pegawai, :id_kredensial, :str, :ijazah, :transkrip, :sertif_pelatihan, :training_record, :log_book, :clinical_privilege, :spkk_sebelumnya)");
$insert->BindParam(":id_pegawai", $id_pegawai);
$insert->BindParam(":id_kredensial", $id_kredensial);
$insert->BindParam(":str", $str);
$insert->BindParam(":ijazah", $ijazah);
$insert->BindParam(":transkrip", $transkrip);
$insert->BindParam(":sertif_pelatihan", $sertif_pelatihan);
$insert->BindParam(":training_record", $training_record);
$insert->BindParam(":log_book", $log_book);
$insert->BindParam(":clinical_privilege", $clinical_privilege);
$insert->BindParam(":spkk_sebelumnya", $spkk_sebelumnya);
$insert->execute();

if($insert->rowCount()==0){
	header("location:peserta_kredensial.php?id=$id_pegawai&status=112");
}else{
	// $query_update = "UPDATE `status_kredensial` SET `verifikasi_bukti`= 1,`tgl_verifikasi_bukti`=:create_at WHERE id_pegawai=:id_pegawai AND id_kredensial=:id_kredensial";
	$update_status = $db->prepare("UPDATE `status_kredensial` SET `verifikasi_bukti`=1,`tgl_verifikasi_bukti`=:create_at WHERE id_kredensial=:id_kredensial AND id_pegawai=:id_pegawai");
	$update_status->BindParam(":id_pegawai", $id_pegawai);
	$update_status->BindParam(":id_kredensial", $id_kredensial);
	$update_status->BindParam(":create_at", $create_at);
	$update_status->execute();
	
	if($update_status->rowCount()==0){
		header("location:verifikasi_dokumen.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=111");		
	}else{
		header("location:verifikasi_dokumen.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=1");
	}
}
?>