<?php
session_start();
include("../../inc/pdo.conf.php");
include("../../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
if ($tipes[0]!='Simpeg')
{
	unset($_SESSION['tipe']);
	unset($_SESSION['namauser']);
	unset($_SESSION['password']);
	header("location:../../index.php?status=2");
	exit;
}
include "../../inc/anggota_check.php";
$id_pegawai = isset($_POST['id_pegawai']) ? $_POST['id_pegawai'] : '';
$tanggal_awal = isset($_POST['tanggal_awal']) ? $_POST['tanggal_awal'] : '';
$tanggal_akhir = isset($_POST['tanggal_akhir']) ? $_POST['tanggal_akhir'] : '';
$lokasi = isset($_POST['lokasi']) ? $_POST['lokasi'] : '';
$jabatan = isset($_POST['jabatan']) ? $_POST['jabatan'] : '';
try {

  $stmt = $db->prepare("INSERT INTO `pegawai_penempatan`(`id_pegawai`, `tanggal_awal`, `tanggal_akhir`, `jabatan`, `lokasi`)VALUES (:id_pegawai,:tanggal_awal,:tanggal_akhir,:jabatan,:lokasi)");
  $stmt->bindParam(":id_pegawai",$id_pegawai,PDO::PARAM_INT);
  $stmt->bindParam(":tanggal_awal",$tanggal_awal,PDO::PARAM_STR);
	$stmt->bindParam(":tanggal_akhir",$tanggal_akhir,PDO::PARAM_STR);
	$stmt->bindParam(":jabatan",$jabatan,PDO::PARAM_STR);
	$stmt->bindParam(":lokasi",$lokasi,PDO::PARAM_STR);
  $stmt->execute();
  $feedback = array(
    "code"=>'success',
		"title"=>"Berhasil",
    "msg"=>'Data Riwayat Penempatan Berhasil disimpan!',
    "id_peg"=>$id_pegawai
  );
} catch (PDOException $e) {
  $feedback = array(
		"code"=>'error',
		"title"=>"Gagal",
    "msg"=>'Terjadi Kesalahan pada sistem ('.$e->getMessage().')',
    "id_peg"=>$id_pegawai
  );
}
echo json_encode($feedback);
