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
$no_ktp_anak = $_POST["no_ktp_anak"];
$nama_anak = $_POST["nama_anak"];
$jk_anak = $_POST["jk_anak"];
$tempat_lahir_anak = $_POST["tempat_lahir_anak"];
$tgl_lahir_anak = $_POST["tgl_lahir_anak"];
$status_perkawinan_anak = $_POST["status_perkawinan_anak"];
$pendidikan_anak = $_POST["pendidikan_anak"];
$pekerjaan_anak = $_POST["pekerjaan_anak"];
$keterangan = $_POST["keterangan"];
$create_at = date('Y-m-d H:i:s');

echo " <br> $id_pegawai
	   <br> $no_ktp_anak
	   <br> $nama_anak
	   <br> $jk_anak
	   <br> $tempat_lahir_anak
	   <br> $tgl_lahir_anak
	   <br> $status_perkawinan_anak
	   <br> $pendidikan_anak
	   <br> $keterangan
	   <br> $create_at
";
$insert= $db->prepare("INSERT INTO riwayat_anak (id_pegawai, no_ktp_anak, nama_anak, jk_anak, tempat_lahir_anak, tgl_lahir_anak, status_perkawinan_anak, pendidikan_anak, pekerjaan_anak, keterangan, create_at) VALUES (:id_pegawai, :no_ktp_anak, :nama_anak, :jk_anak, :tempat_lahir_anak, :tgl_lahir_anak, :status_perkawinan_anak, :pendidikan_anak,:pekerjaan_anak, :keterangan, :create_at)");
$insert->bindParam(":id_pegawai", $id_pegawai);
$insert->bindParam(":no_ktp_anak", $no_ktp_anak);
$insert->bindParam(":nama_anak", $nama_anak);
$insert->bindParam(":jk_anak", $jk_anak);
$insert->bindParam(":tempat_lahir_anak", $tempat_lahir_anak);
$insert->bindParam(":tgl_lahir_anak", $tgl_lahir_anak);
$insert->bindParam(":status_perkawinan_anak", $status_perkawinan_anak);
$insert->bindParam(":pendidikan_anak", $pendidikan_anak);
$insert->bindParam(":pekerjaan_anak", $pekerjaan_anak);
$insert->bindParam(":keterangan", $keterangan);
$insert->bindParam(":create_at", $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:profil_pegawai.php?id=$id_pegawai&status=111");
}else{
	header("location:profil_pegawai.php?id=$id_pegawai&status=1");
}