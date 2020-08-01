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
$id_pegawai = isset($_POST['id_pegawai']) ? $_POST['id_pegawai'] : '';
$tingkat_pendidikan = isset($_POST['tingkat_pendidikan']) ? $_POST['tingkat_pendidikan'] : '';
$fakultas = isset($_POST['fakultas']) ? $_POST['fakultas'] : '';
$jurusan = isset($_POST['jurusan']) ? $_POST['jurusan'] : '';
$nomor_sttb = isset($_POST['nomor_sttb']) ? $_POST['nomor_sttb'] : '';
$tanggal_sttb = isset($_POST['tanggal_sttb']) ? $_POST['tanggal_sttb'] : '';
$nama_kepsek = isset($_POST['nama_kepsek']) ? $_POST['nama_kepsek'] : '';
$nama_sekolah = isset($_POST['nama_sekolah']) ? $_POST['nama_sekolah'] : '';
$lokasi_sekolah = isset($_POST['lokasi_sekolah']) ? $_POST['lokasi_sekolah'] : '';
$nama_perguruan_tinggi = isset($_POST['nama_perguruan_tinggi']) ? $_POST['nama_perguruan_tinggi'] : '';
$created_at = date('Y-m-d');

// print_r($_POST);
// print_r($_FILES);
//ftp connection 2
$ftp_server = "192.168.1.17";
$ftp_user_name = "rskia";
$ftp_user_pass = "rskia2016";
$conn_id = ftp_connect($ftp_server);
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);
//target dir
$target_dir = "/dist/img/dokumen_files/";
$dir = "/dist/img/dokumen_files/".$id_pegawai;
$nama_file = basename($_FILES["files"]["name"]);
$target_file = $dir."/". basename($_FILES["files"]["name"]);
// $target_file = $target_dir . basename($_FILES["scan"]["name"]);
$folder_exists = is_dir("ftp://rskia:rskia2016@192.168.1.17/dist/img/dokumen_files/".$id_pegawai);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//ftp upload file
if($folder_exists){
  // echo "ketemu";
  $upload = ftp_put($conn_id, $target_file, $_FILES["files"]["tmp_name"], FTP_BINARY);

  if($upload){
    $up ="ya";
    // echo "Upload berhasil";
  }else{
    $up ="tidak";
    // echo "gagal upload";
  }
}else{
  //tidak ketemu
  if(ftp_mkdir($conn_id,$dir)){
    // echo "berhasil dibuat";
    $upload = ftp_put($conn_id, $target_file, $_FILES["files"]["tmp_name"], FTP_BINARY);

    if($upload){
      $up="ya";
      // echo "Upload berhasil";
    }else{
      $up ="tidak";
      // echo "gagal upload";
    }
  }else{
    $up="tidak";
    // echo "gagal dibuat";
  }
}
if($up=='ya'){
  //input data in here
  $ins = $db->prepare("INSERT INTO `pegawai_pend_formal`(`id_pegawai`,`tingkat_pendidikan`, `fakultas`, `jurusan`, `nomor_sttb`, `tanggal_sttb`, `nama_kepsek`, `nama_sekolah`, `lokasi_sekolah`,`url_doc`,`nama_doc`, `nama_perguruan_tinggi`, `created_at`) VALUES (:id_pegawai,:tingkat_pendidikan,:fakultas,:jurusan,:nomor_sttb,:tanggal_sttb,:nama_kepsek,:nama_sekolah,:lokasi_sekolah,:url_doc,:nama_doc,:nama_perguruan_tinggi,:created_at)");
	$ins->bindParam(":id_pegawai",$id_pegawai,PDO::PARAM_STR);
  $ins->bindParam(":tingkat_pendidikan",$tingkat_pendidikan,PDO::PARAM_STR);
  $ins->bindParam(":fakultas",$fakultas,PDO::PARAM_STR);
  $ins->bindParam(":jurusan",$jurusan,PDO::PARAM_STR);
  $ins->bindParam(":nomor_sttb",$nomor_sttb,PDO::PARAM_STR);
  $ins->bindParam(":tanggal_sttb",$tanggal_sttb,PDO::PARAM_STR);
  $ins->bindParam(":nama_kepsek",$nama_kepsek,PDO::PARAM_STR);
  $ins->bindParam(":nama_sekolah",$nama_sekolah,PDO::PARAM_STR);
  $ins->bindParam(":lokasi_sekolah",$lokasi_sekolah,PDO::PARAM_STR);
	$ins->bindParam(":url_doc",$dir,PDO::PARAM_STR);
	$ins->bindParam(":nama_doc",$nama_file,PDO::PARAM_STR);
  $ins->bindParam(":nama_perguruan_tinggi",$nama_perguruan_tinggi,PDO::PARAM_STR);
  $ins->bindParam(":created_at",$created_at,PDO::PARAM_STR);
  $ins->execute();
  echo "Upload Berhasil";
}else{
  echo "Upload & simpan data gagal dilakukan";
}
