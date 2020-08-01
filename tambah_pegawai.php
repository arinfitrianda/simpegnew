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
include "../inc/anggota_check.php";
var_dump($_POST);
//get variable & sanitize
$nip = isset($_POST['nip']) ? trim($_POST['nip']) : '-';
$ktp = isset($_POST['ktp']) ? trim($_POST['ktp']) : '-';
$npwp = isset($_POST['npwp']) ? trim($_POST['npwp']) : '-';
$askes = isset($_POST['askes']) ? trim($_POST['askes']) : '-';
$status_pegawai = isset($_POST['status_pegawai']) ? trim($_POST['status_pegawai']) : '-';
$tmt_pegawai = isset($_POST['tmt_pegawai']) ? trim($_POST['tmt_pegawai']) : '0000-00-00';
$unit_kerja = isset($_POST['unit_kerja']) ? trim($_POST['unit_kerja']) : '1';
$jenis_jabatan = isset($_POST['jenis_jabatan']) ? trim($_POST['jenis_jabatan']) : '-';
$nama_jabatan = isset($_POST['nama_jabatan']) ? trim($_POST['nama_jabatan']) : '-';
$tmt_jabatan = isset($_POST['tmt_jabatan']) ? trim($_POST['tmt_jabatan']) : '0000-00-00';
$prefix = ($_POST['prefix']!="") ? trim($_POST['prefix']) : '-';
$nama_lengkap = isset($_POST['nama_lengkap']) ? trim($_POST['nama_lengkap']) : '-';
$postfix = ($_POST['postfix']!="") ? trim($_POST['postfix']) : '-';
$tempat_lahir = isset($_POST['tempat_lahir']) ? trim($_POST['tempat_lahir']) : '-';
$tanggal_lahir = isset($_POST['tanggal_lahir']) ? trim($_POST['tanggal_lahir']) : '0000-00-00';
$jk = isset($_POST['jk']) ? trim($_POST['jk']) : '-';
$status_perkawinan = isset($_POST['status_perkawinan']) ? trim($_POST['status_perkawinan']) : '-';
$agama = isset($_POST['agama']) ? trim($_POST['agama']) : '-';
$golongan_darah = isset($_POST['golongan_darah']) ? trim($_POST['golongan_darah']) : '-';
$pend_awal = isset($_POST['pendidikan_awal']) ? trim($_POST['pendidikan_awal']) : '-';
$tahun_pend_awal = isset($_POST['tahun_pendidikan_awal']) ? trim($_POST['tahun_pendidikan_awal']) : '0000';
$pend_akhir = isset($_POST['pendidikan_akhir']) ? trim($_POST['pendidikan_akhir']) : '-';
$tahun_pend_akhir = isset($_POST['tahun_pendidikan_akhir']) ? trim($_POST['tahun_pendidikan_akhir']) : '0000';
$alamat = isset($_POST['alamat']) ? trim($_POST['alamat']) : '-';
$prop = isset($_POST['prop']) ? trim($_POST['prop']) : '-';
$kota = isset($_POST['kota']) ? trim($_POST['kota']) : '-';
$kec = isset($_POST['kec']) ? trim($_POST['kec']) : '-';
$kel = isset($_POST['kel']) ? trim($_POST['kel']) : '-';
$kode_pos = isset($_POST['kode_pos']) ? trim($_POST['kode_pos']) : '-';
$email = isset($_POST['email']) ? trim($_POST['email']) : '-';
$telepon = isset($_POST['telepon']) ? trim($_POST['telepon']) : '-';
$wea = isset($_POST['wea']) ? trim($_POST['wea']) : '-';
$full_name="";
try {
  //PEGAWAI
  if(($prefix!='')&&($prefix!="-")){
    $full_name = $prefix.".".$nama_lengkap;
  }else{
    $full_name = $nama_lengkap;
  }
  if(($postfix!='')&&($postfix!="-")){
    $full_name.= ",".$postfix;
  }
  // pegawai
  $peg = $db->prepare("INSERT INTO `pegawai`(`nama`, `nip`, `status`, `foto`, `id_depart`) VALUES (:nama,:nip,:status,:foto,:id_depart)");
  $peg->bindParam(":nama",$full_name,PDO::PARAM_STR);
  $peg->bindParam(":nip",$nip);
  $peg->bindParam(":status",$status_pegawai);
  $peg->bindParam(":foto",$unit_kerja);
  $peg->bindParam(":id_depart",$unit_kerja);
  $peg->execute();
  $id_pegawai = $db->lastInsertId();
  //PROFIL PEGAWAI
  $inst = $db->prepare("INSERT INTO `pegawai_profil`(`id_peg`, `ktp`, `npwp`, `askes`, `nama_lengkap`, `prefix`, `postfix`, `nip`, `tempat_lahir`, `tanggal_lahir`, `jenis_kelamin`, `status_perkawinan`, `agama`,`status_pegawai`, `jenis_jabatan`, `nama_jabatan`, `tmt_jabatan`, `pend_awal`, `tahun_pend_awal`, `pend_akhir`, `tahun_pend_akhir`, `golongan_darah`, `alamat`, `provinsi`, `kabupaten`, `kecamatan`, `kelurahan`, `kode_pos`, `telepon`, `no_wea`, `email_address`) VALUES (:id_peg,:ktp,:npwp,:askes,:nama_lengkap,:prefix,:postfix,:nip,:tempat_lahir,:tanggal_lahir,:jenis_kelamin,:status_perkawinan,:agama,:status_pegawai,:jenis_jabatan,:nama_jabatan,:tmt_jabatan,:pend_awal,:tahun_pend_awal,:pend_akhir,:tahun_pend_akhir,:golongan_darah,:alamat,:provinsi,:kabupaten,:kecamatan,:kelurahan,:kode_pos,:telepon,:no_wea,:email_address)");
  $inst->bindParam(":id_peg",$id_pegawai,PDO::PARAM_INT);
  $inst->bindParam(":ktp",$ktp);
  $inst->bindParam(":npwp",$npwp);
  $inst->bindParam(":askes",$askes);
  $inst->bindParam(":nama_lengkap",$nama_lengkap,PDO::PARAM_STR);
  $inst->bindParam(":prefix",$prefix,PDO::PARAM_STR);
  $inst->bindParam(":postfix",$postfix,PDO::PARAM_STR);
  $inst->bindParam(":nip",$nip,PDO::PARAM_STR);
  $inst->bindParam(":tempat_lahir",$tempat_lahir);
  $inst->bindParam(":tanggal_lahir",$tanggal_lahir);
  $inst->bindParam(":jenis_kelamin",$jk);
  $inst->bindParam(":status_perkawinan",$status_perkawinan);
  $inst->bindParam(":agama",$agama,PDO::PARAM_STR);
  $inst->bindParam(":status_pegawai",$status_pegawai);
  $inst->bindParam(":jenis_jabatan",$jenis_jabatan);
  $inst->bindParam(":nama_jabatan",$nama_jabatan);
  $inst->bindParam(":tmt_jabatan",$tmt_jabatan);
  $inst->bindParam(":pend_awal",$pend_awal);
  $inst->bindParam(":tahun_pend_awal",$tahun_pend_awal);
  $inst->bindParam(":pend_akhir",$pend_akhir);
  $inst->bindParam(":tahun_pend_akhir",$tahun_pend_akhir);
  $inst->bindParam(":golongan_darah",$golongan_darah);
  $inst->bindParam(":alamat",$alamat);
  $inst->bindParam(":provinsi",$prop);
  $inst->bindParam(":kabupaten",$kota);
  $inst->bindParam(":kecamatan",$kec);
  $inst->bindParam(":kelurahan",$kel);
  $inst->bindParam(":kode_pos",$kode_pos);
  $inst->bindParam(":telepon",$telepon);
  $inst->bindParam(":no_wea",$wea);
  $inst->bindParam(":email_address",$email);
  $inst->execute();
echo "<script language=\"JavaScript\">window.location = \"master.php?status=1\"</script>";
} catch (PDOException $e) {
  echo "Error : ".$e->getMessage();
  echo "<script language=\"JavaScript\">window.location = \"form_pegawai.php\"</script>";
}

?>
