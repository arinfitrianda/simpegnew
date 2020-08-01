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
$id_pasutri = $_POST["id_pasutri"];
$no_ktp_pasutri = $_POST["no_ktp"];
$nama_pasutri = $_POST["nama_pasutri"];
$tempat_lahir_pasutri = $_POST["tempat_lahir_pasutri"];
$tgl_lahir_pasutri = $_POST["tgl_lahir_pasutri"];
$tgl_nikah = $_POST["tgl_nikah"];
$pendidikan_pasutri = $_POST["pendidikan_pasutri"];
$keterangan = $_POST["keterangan"];
$update = date('Y-m-d H:i:s');

echo "<br> $id_pegawai
	  <br> $no_ktp_pasutri
	  <br> $nama_pasutri
	  <br> $tempat_lahir_pasutri
	  <br> $tgl_lahir_pasutri
	  <br> $pendidikan_pasutri
	  <br> $keterangan";

$update = $db->prepare("UPDATE riwayat_suami_istri SET no_ktp_pasutri=:no_ktp_pasutri, nama_pasutri=:nama_pasutri, tempat_lahir_pasutri=:tempat_lahir_pasutri, tgl_lahir_pasutri=:tgl_lahir_pasutri, tgl_nikah=:tgl_nikah, pendidikan_pasutri=:pendidikan_pasutri, keterangan=:keterangan, update_at=:update_at WHERE id_riwayat_pasutri=:id_pasutri AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_pasutri", $id_pasutri);
$update->BindParam(":no_ktp_pasutri", $no_ktp_pasutri);
$update->BindParam(":nama_pasutri", $nama_pasutri);
$update->BindParam(":tempat_lahir_pasutri", $tempat_lahir_pasutri);
$update->BindParam(":tgl_lahir_pasutri", $tgl_lahir_pasutri);
$update->BindParam(":tgl_nikah", $tgl_nikah);
$update->BindParam(":pendidikan_pasutri", $pendidikan_pasutri);
$update->BindParam(":keterangan", $keterangan);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=112");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=2");
}
?>