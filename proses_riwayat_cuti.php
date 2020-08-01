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
$jenis_cuti = $_POST["jenis_cuti"];
$no_surat_cuti = $_POST["no_surat_cuti"];
$tgl_mulai_cuti = $_POST["tgl_mulai_cuti"];
$tgl_selesai_cuti = $_POST["tgl_selesai_cuti"];
$keterangan = $_POST["keterangan"];
$create_at = date('Y-m-d H:i:s');

$insert= $db->prepare("INSERT INTO riwayat_cuti(id_pegawai, jenis_cuti, no_surat_cuti, tgl_mulai_cuti, tgl_akhir_cuti, keterangan, create_at) VALUES (:id_pegawai, :jenis_cuti, :no_surat_cuti,:tgl_mulai_cuti, :tgl_selesai_cuti, :keterangan, :create_at)");
$insert->bindParam(":id_pegawai", $id_pegawai);
$insert->bindParam(":jenis_cuti", $jenis_cuti);
$insert->bindParam(":no_surat_cuti", $no_surat_cuti);
$insert->bindParam(":tgl_mulai_cuti", $tgl_mulai_cuti);
$insert->bindParam(":tgl_selesai_cuti", $tgl_selesai_cuti);
$insert->bindParam(":keterangan", $keterangan);
$insert->bindParam(":create_at", $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:profil_pegawai.php?id=$id_pegawai&status=111");
}else{
	header("location:profil_pegawai.php?id=$id_pegawai&status=1");
}