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
$no_ktp_ortu = $_POST["no_ktp_ortu"];
$nama_ortu = $_POST["nama_ortu"];
$jk_ortu = $_POST["jk_ortu"];
$tempat_lahir_ortu = $_POST["tempat_lahir_ortu"];
$tgl_lahir_ortu = $_POST["tgl_lahir_ortu"];
$pendidikan_ortu = $_POST["pendidikan_ortu"];
$pekerjaan_ortu = $_POST["pekerjaan_ortu"];
$keterangan = $_POST["keterangan"];
$create_at = date('Y-m-d H:i:s');

$insert=$db->prepare("INSERT INTO riwayat_ortu(id_pegawai, no_ktp_ortu, nama_ortu, jk_ortu, tempat_lahir_ortu, tgl_lahir_ortu, pendidikan_ortu, pekerjaan_ortu, keterangan, create_at) VALUES (:id_pegawai, :no_ktp_ortu, :nama_ortu, :jk_ortu, :tempat_lahir_ortu, :tgl_lahir_ortu, :pendidikan_ortu, :pekerjaan_ortu, :keterangan, :create_at)");

$insert->bindParam(":id_pegawai", $id_pegawai);
$insert->bindParam(":no_ktp_ortu", $no_ktp_ortu);
$insert->bindParam(":nama_ortu", $nama_ortu);
$insert->bindParam(":jk_ortu", $jk_ortu);
$insert->bindParam(":tempat_lahir_ortu", $tempat_lahir_ortu);
$insert->bindParam(":tgl_lahir_ortu", $tgl_lahir_ortu);
$insert->bindParam(":pendidikan_ortu", $pendidikan_ortu);
$insert->bindParam(":pekerjaan_ortu", $pekerjaan_ortu);
$insert->bindParam(":keterangan", $keterangan);
$insert->bindParam(":create_at", $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:profil_pegawai.php?id=$id_pegawai&status=111");
}else{
	header("location:profil_pegawai.php?id=$id_pegawai&status=1");
}
?>