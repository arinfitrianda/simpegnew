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
$nama_perusahaan = $_POST["nama_perusahaan"];
$jabatan = $_POST["jabatan"];
$tgl_mulai_kerja = $_POST["tgl_mulai_kerja"];
$tgl_selesai_kerja = $_POST["tgl_selesai_kerja"];
$alasan_keluar_kerja = $_POST["alasan_keluar_kerja"];
$keterangan = $_POST["keterangan"];
$create_at = date('Y-m-d H:i:s');

$insert= $db->prepare("INSERT INTO riwayat_pekerjaan(id_pegawai, nama_perusahaan, jabatan, tgl_mulai_kerja, tgl_selesai_kerja,alasan_keluar_kerja, keterangan, create_at) VALUES (:id_pegawai, :nama_perusahaan, :jabatan,:tgl_mulai_kerja, :tgl_selesai_kerja, :alasan_keluar_kerja, :keterangan, :create_at)");
$insert->bindParam(":id_pegawai", $id_pegawai);
$insert->bindParam(":nama_perusahaan", $nama_perusahaan);
$insert->bindParam(":jabatan", $jabatan);
$insert->bindParam(":tgl_mulai_kerja", $tgl_mulai_kerja);
$insert->bindParam(":tgl_selesai_kerja", $tgl_selesai_kerja);
$insert->bindParam(":alasan_keluar_kerja", $alasan_keluar_kerja);
$insert->bindParam(":keterangan", $keterangan);
$insert->bindParam(":create_at", $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:profil_pegawai.php?id=$id_pegawai&status=111");
}else{
	header("location:profil_pegawai.php?id=$id_pegawai&status=1");
}