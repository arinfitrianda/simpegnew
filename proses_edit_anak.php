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
$id_anak = $_POST["id_anak"];
$no_ktp_anak = $_POST["no_ktp_anak"];
$nama_anak = $_POST["nama_anak"];
$jk_anak = $_POST["jk_anak"];
$tempat_lahir_anak = $_POST["tempat_lahir_anak"];
$tgl_lahir_anak = $_POST["tgl_lahir_anak"];
$status_perkawinan_anak = $_POST["status_perkawinan_anak"];
$pendidikan_anak = $_POST["pendidikan_anak"];
$pekerjaan_anak = $_POST["pekerjaan_anak"];
$keterangan = $_POST["keterangan"];
$update = date('Y-m-d H:i:s');

echo "<br> $id_pegawai
	  <br> $no_ktp_anak
	  <br> $nama_anak
	  <br> $tempat_lahir_anak
	  <br> $tgl_lahir_anak
	  <br> $pendidikan_anak
	  <br> $keterangan";

$update = $db->prepare("UPDATE riwayat_anak SET no_ktp_anak=:no_ktp_anak, nama_anak=:nama_anak, jk_anak=:jk_anak, tempat_lahir_anak=:tempat_lahir_anak, tgl_lahir_anak=:tgl_lahir_anak, status_perkawinan_anak=:status_perkawinan_anak, pendidikan_anak=:pendidikan_anak, pekerjaan_anak=:pekerjaan_anak, keterangan=:keterangan, update_at=:update_at WHERE id_anak=:id_anak AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_anak", $id_anak);
$update->BindParam(":no_ktp_anak", $no_ktp_anak);
$update->BindParam(":nama_anak", $nama_anak);
$update->BindParam(":jk_anak", $jk_anak);
$update->BindParam(":tempat_lahir_anak", $tempat_lahir_anak);
$update->BindParam(":tgl_lahir_anak", $tgl_lahir_anak);
$update->BindParam(":status_perkawinan_anak", $status_perkawinan_anak);
$update->BindParam(":pendidikan_anak", $pendidikan_anak);
$update->BindParam(":pekerjaan_anak", $pekerjaan_anak);
$update->BindParam(":keterangan", $keterangan);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=112");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=2");
}
?>