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
$id_pekerjaan = $_POST["id_pekerjaan"];
$nama_perusahaan = $_POST["nama_perusahaan"];
$jabatan = $_POST["jabatan"];
$tgl_mulai_kerja = $_POST["tgl_mulai_kerja"];
$tgl_selesai_kerja = $_POST["tgl_selesai_kerja"];
$alasan_keluar_kerja = $_POST["alasan_keluar_kerja"];
$keterangan = $_POST["keterangan"];
$update = date('Y-m-d H:i:s');`

$update = $db->prepare("UPDATE riwayat_pekerjaan SET nama_perusahaan=:nama_perusahaan, jabatan=:jabatan, tgl_mulai_kerja=:tgl_mulai_kerja, tgl_selesai_kerja=:tgl_selesai_kerja, alasan_keluar_kerja=:alasan_keluar_kerja, keterangan=:keterangan, update_at=:update_at WHERE id_pekerjaan=:id_pekerjaan AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_pekerjaan", $id_pekerjaan);
$update->BindParam(":nama_perusahaan", $nama_perusahaan);
$update->BindParam(":jabatan", $jabatan);
$update->BindParam(":tgl_mulai_kerja", $tgl_mulai_kerja);
$update->BindParam(":tgl_selesai_kerja", $tgl_selesai_kerja);
$update->BindParam(":alasan_keluar_kerja", $alasan_keluar_kerja);
$update->BindParam(":keterangan", $keterangan);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=112");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=2");
}
?>