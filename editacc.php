<?php
//get var
$id_pegawai=$_POST["id_pegawai"];
$kelompok=$_POST["kelompok"];
//conn
session_start();
include("../inc/cek.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
if ($tipes[0]!='Simpeg')
{
	session_start();
	unset($_SESSION['tipe']);
	unset($_SESSION['namauser']);
	unset($_SESSION['password']);
	header("location:../index.php?status=2");
	exit;
}
include "../inc/koneksi.inc.php";
//update
$result = mysql_query("UPDATE pegawai SET foto='$kelompok' WHERE id_pegawai='$id_pegawai'");
//action
if ($result) {
echo "<script language=\"JavaScript\">window.location = \"master.php?status=1\"</script>";
} else {
echo "gagal";
}
?>
