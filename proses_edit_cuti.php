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
$id_cuti = $_POST["id_cuti"];
$jenis_cuti = $_POST["jenis_cuti"];
$no_surat_cuti = $_POST["no_surat_cuti"];
$tgl_mulai_cuti = $_POST["tgl_mulai_cuti"];
$tgl_akhir_cuti = $_POST["tgl_akhir_cuti"];
$keterangan = $_POST["keterangan"];
$update = date('Y-m-d H:i:s');

echo "<br> $id_pegawai
	  <br> $jenis_cuti
	  <br> $no_surat_cuti
	  <br> $tgl_akhir_cuti
	  <br> $keterangan";

$update = $db->prepare("UPDATE riwayat_cuti SET jenis_cuti=:jenis_cuti, no_surat_cuti=:no_surat_cuti, tgl_mulai_cuti=:tgl_mulai_cuti, tgl_akhir_cuti=:tgl_akhir_cuti, keterangan=:keterangan, update_at=:update_at WHERE id_cuti=:id_cuti AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_cuti", $id_cuti);
$update->BindParam(":jenis_cuti", $jenis_cuti);
$update->BindParam(":no_surat_cuti", $no_surat_cuti);
$update->BindParam(":tgl_mulai_cuti", $tgl_mulai_cuti);
$update->BindParam(":tgl_akhir_cuti", $tgl_akhir_cuti);
$update->BindParam(":keterangan", $keterangan);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=112");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=2");
}
?>