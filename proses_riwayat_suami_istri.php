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
$no_ktp_pasutri = $_POST["no_ktp_pasutri"];
$nama_suami_istri = $_POST["nama_suami_istri"];
$ket_pasangan = $_POST["ket_pasangan"];
$tempat_lahir_suami_istri = $_POST["tempat_lahir_suami_istri"];
$tgl_lahir_suami_istri = $_POST["tgl_lahir_suami_istri"];
$tgl_nikah = $_POST["tgl_nikah"];
$pendidikan_pasutri = $_POST["pendidikan_pasutri"];
$pekerjaan_pasutri = $_POST["pekerjaan_pasutri"];
$keterangan = $_POST["keterangan"];
$create_at = date('Y-m-d H:i:s');

echo "<br> $id_pegawai
	  <br> $no_ktp_pasutri
	  <br> $nama_suami_istri
	  <br> $tempat_lahir_suami_istri
	  <br> $tgl_lahir_suami_istri
	  <br> $tgl_nikah
	  <br> $pendidikan_pasutri
	  <br> $pekerjaan_pasutri
	  <br> $keterangan
";

$insert= $db->prepare("INSERT INTO riwayat_suami_istri(id_pegawai, no_ktp_pasutri, nama_pasutri, ket_pasangan, tempat_lahir_pasutri, tgl_lahir_pasutri, tgl_nikah, pendidikan_pasutri, pekerjaan_pasutri, keterangan, create_at) VALUES (:id_pegawai, :no_ktp_pasutri, :nama_suami_istri, :ket_pasangan, :tempat_lahir_suami_istri, :tgl_lahir_suami_istri, :tgl_nikah, :pendidikan_pasutri, :pekerjaan_pasutri, :keterangan, :create_at)");
$insert->bindParam(':id_pegawai', $id_pegawai);
$insert->bindParam(':no_ktp_pasutri', $no_ktp_pasutri);
$insert->bindParam(':nama_suami_istri', $nama_suami_istri);
$insert->bindParam(':ket_pasangan', $ket_pasangan);
$insert->bindParam(':tempat_lahir_suami_istri', $tempat_lahir_suami_istri);
$insert->bindParam(':tgl_lahir_suami_istri', $tgl_lahir_suami_istri);
$insert->bindParam(':tgl_nikah', $tgl_nikah);
$insert->bindParam(':pendidikan_pasutri', $pendidikan_pasutri);
$insert->bindParam(':pekerjaan_pasutri', $pekerjaan_pasutri);
$insert->bindParam(':keterangan', $keterangan);
$insert->bindParam(':create_at', $create_at);
$insert->execute();

if($insert->rowCount()==0){
	header("location:profil_pegawai.php?id=$id_pegawai&status=111");
}else{
	header("location:profil_pegawai.php?id=$id_pegawai&status=1");
}
?>