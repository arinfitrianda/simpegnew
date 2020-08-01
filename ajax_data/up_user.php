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
$username = isset($_POST['user']) ? $_POST['user'] : '';
$password = isset($_POST['pass']) ? $_POST['pass'] : '';
try {
  $get_pegawai = $db->query("SELECT * FROM pegawai WHERE id_pegawai='".$id_pegawai."'");
  $peg = $get_pegawai->fetch(PDO::FETCH_ASSOC);
  $empty ="-";
  $tipe = "Pegawai-User";
  $tanggal = date('d/m/Y');
  $status = 1;
  $aktif='tidak';

  $stmt = $db->prepare("INSERT INTO `anggota`(`nama`, `alamat`, `telp`, `email`, `tipe`, `user`, `password`, `tanggal`, `status`, `aktif`, `id_pegawai`)VALUES (:nama,:alamat,:telp,:email,:tipe,:user,:pass,:tanggal,:status,:aktif,:id_pegawai)");
  $stmt->bindParam(":nama",$peg['nama'],PDO::PARAM_STR);
  $stmt->bindParam(":alamat",$empty,PDO::PARAM_STR);
  $stmt->bindParam(":telp",$empty,PDO::PARAM_STR);
  $stmt->bindParam(":email",$empty,PDO::PARAM_STR);
  $stmt->bindParam(":tipe",$tipe,PDO::PARAM_STR);
  $stmt->bindParam(":user",$username,PDO::PARAM_STR);
  $stmt->bindParam(":pass",$password,PDO::PARAM_STR);
  $stmt->bindParam(":tanggal",$tanggal,PDO::PARAM_STR);
  $stmt->bindParam(":status",$status,PDO::PARAM_STR);
  $stmt->bindParam(":aktif",$aktif,PDO::PARAM_STR);
  $stmt->bindParam(":id_pegawai",$id_pegawai,PDO::PARAM_STR);
  $stmt->execute();
  $feedback = array(
    "code"=>'Sukses',
    "msg"=>'Update/penambahan akun berhasil dilakukan',
    "id_peg"=>$id_pegawai
  );
} catch (PDOException $e) {
  $feedback = array(
    "code"=>'Gagal',
    "msg"=>'Update/penambahan akun Gagal dilakukan',
    "id_peg"=>$id_pegawai
  );
}
echo json_encode($feedback);
