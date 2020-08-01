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
$id_penempatan = isset($_POST['id_penempatan']) ? $_POST['id_penempatan'] : '';
$id_pegawai = isset($_POST['reg']) ? $_POST['reg'] : '';
try {

  $stmt = $db->prepare("DELETE FROM pegawai_penempatan WHERE id_penempatan=:id");
  $stmt->bindParam(":id",$id_penempatan,PDO::PARAM_INT);
  $stmt->execute();
  $feedback = array(
    "code"=>'success',
		"title"=>"Berhasil",
    "msg"=>'Data Riwayat Penempatan Berhasil dihapus!',
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
