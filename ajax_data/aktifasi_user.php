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
$id_pegawai = isset($_POST['id']) ? $_POST['id'] : '';
$status_akun = isset($_POST['status_akun']) ? $_POST['status_akun'] : 'tidak';
$status_pegawai = isset($_POST['status_pegawai']) ? $_POST['status_pegawai'] : 't';

try {
	if($status_pegawai=='y'){
		$new_stat = "y";
		$msg = "Aktifasi Akun Berhasil dilakukan";
		$err = "Aktifasi Akun Gagal dilakukan";
	}else{
		$new_stat = "t";
		$msg = "Penonaktifan Akun Berhasil dilakukan";
		$err = "Penonaktifan Akun Gagal dilakukan";
	}
	if($status_akun=='ya'){
		$new_opt = "ya";
	}else{
		$new_opt = "tidak";
	}
  $update = $db->prepare("UPDATE anggota SET aktif=:aktif WHERE tipe='Pegawai-User' AND id_pegawai=:id");
	$update->bindParam(":aktif",$new_opt,PDO::PARAM_STR);
	$update->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
	$update->execute();

	$up_peg = $db->prepare("UPDATE pegawai SET aktif=:aktif WHERE id_pegawai=:id");
	$up_peg->bindParam(":aktif",$new_stat,PDO::PARAM_STR);
	$up_peg->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
	$up_peg->execute();
  $feedback = array(
    "code"=>'Sukses',
    "msg"=>$msg,
    "id_peg"=>$id_pegawai
  );
} catch (PDOException $e) {
  $feedback = array(
    "code"=>'Gagal',
    "msg"=>$err,
    "id_peg"=>$id_pegawai
  );
}
echo json_encode($feedback);
