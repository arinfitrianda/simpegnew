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
$id_ortu = $_POST["id_ortu"];
$no_ktp_ortu = $_POST["no_ktp_ortu"];
$nama_ortu = $_POST["nama_ortu"];
$jk_ortu = $_POST["jk_ortu"];
$tempat_lahir_ortu = $_POST["tempat_lahir_ortu"];
$tgl_lahir_ortu = $_POST["tgl_lahir_ortu"];
$pendidikan_ortu = $_POST["pendidikan_ortu"];
$pekerjaan_ortu = $_POST["pekerjaan_ortu"];
$keterangan = $_POST["keterangan"];
$update = date('Y-m-d H:i:s');

echo "<br> $id_pegawai
	  <br> $no_ktp_ortu
	  <br> $nama_ortu
	  <br> $tempat_lahir_ortu
	  <br> $tgl_lahir_ortu
	  <br> $pendidikan_ortu
	  <br> $keterangan";

$update = $db->prepare("UPDATE riwayat_ortu SET no_ktp_ortu=:no_ktp_ortu, nama_ortu=:nama_ortu, jk_ortu=:jk_ortu, tempat_lahir_ortu=:tempat_lahir_ortu, tgl_lahir_ortu=:tgl_lahir_ortu, pendidikan_ortu=:pendidikan_ortu, pekerjaan_ortu=:pekerjaan_ortu, keterangan=:keterangan, update_at=:update_at WHERE id_ortu=:id_ortu AND id_pegawai=:id_pegawai");
$update->BindParam(":id_pegawai", $id_pegawai);
$update->BindParam(":id_ortu", $id_ortu);
$update->BindParam(":no_ktp_ortu", $no_ktp_ortu);
$update->BindParam(":nama_ortu", $nama_ortu);
$update->BindParam(":jk_ortu", $jk_ortu);
$update->BindParam(":tempat_lahir_ortu", $tempat_lahir_ortu);
$update->BindParam(":tgl_lahir_ortu", $tgl_lahir_ortu);
$update->BindParam(":pendidikan_ortu", $pendidikan_ortu);
$update->BindParam(":pekerjaan_ortu", $pekerjaan_ortu);
$update->BindParam(":keterangan", $keterangan);
$update->BindParam(":update_at", $update_at);
$update->execute();

if($update->rowCount()==0){
	header("locatio:profil_pegawai.php?id=$id_pegawai&status=111");
}else{		
	header("location:profil_pegawai.php?id=$id_pegawai&status=1");
}
?>