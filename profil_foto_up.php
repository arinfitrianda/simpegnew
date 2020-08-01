<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
include("../inc/ip_server.php");
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
$storeFolder = '../dist/img/pegawai';
$directory = $storeFolder.'/';
$location_compress = '../dist/img/pegawai/compress/';
$url_default='../dist/img/pegawai/';
// Compress image
function compressImage($source, $destination, $quality) {
    $info = getimagesize($source);
    if ($info['mime'] == 'image/jpeg'){
      $image = imagecreatefromjpeg($source);
    }elseif ($info['mime'] == 'image/gif'){
      $image = imagecreatefromgif($source);
    }elseif ($info['mime'] == 'image/png'){
      $image = imagecreatefrompng($source);
    }
    imagejpeg($image, $destination, $quality);
}
if(!empty($_POST['task'])){
	$task = $_POST['task'];
	$id_pegawai = $_POST['id_pegawai'];
		if($task=='tambah'){
			if(!empty($_FILES)){
				//check folder
				$temp_file = $_FILES['file']['tmp_name'];
				$filename = $_FILES['file']['name'];
			 	if (!file_exists($directory)) {
			    mkdir($directory, 0777);
				}
        if (!file_exists($location_compress)) {
			    mkdir($location_compress, 0777);
				}
				// Location
				$location_compress = $location_compress.$filename;
				$location_original = $directory.$filename;
        compressImage($temp_file,$location_original,60);
				// move_uploaded_file($temp_file,$location_original );
			 //query update nama file gambar
			 $stmt = $db->prepare("UPDATE pegawai SET url_foto=:url,nama_file=:gambar WHERE id_pegawai=:id");
			 $stmt->bindParam(":url",$directory,PDO::PARAM_STR);
			 $stmt->bindParam(":gambar",$_FILES['file']['name'],PDO::PARAM_STR);
			 $stmt->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
			 $stmt->execute();
       echo 'Gambar Berhasil di Upload, Lanjutkan dengan klik tombol simpan';
			}
		}else if($task=='hapus'){
			if(!empty($_FILES)){
			 $filename = $_FILES['file']['name'];
			 $temp_file = $_FILES['file']['tmp_name'];
			 $location_original = $directory. $_FILES['file']['name'];
			 if (file_exists($location_original)) {
				 unlink($location_original);
			 }
			 echo 'File Gambar Berhasil dibatalkan dan dihapus';
			 $default_name = 'dev.jpg';
			 $stmt = $db->prepare("UPDATE pegawai SET url_foto=:url,nama_file=:gambar WHERE id_pegawai=:id");
			 $stmt->bindParam(":url",$url_default,PDO::PARAM_STR);
			 $stmt->bindParam(":gambar",$default_name,PDO::PARAM_STR);
			 $stmt->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
			 $stmt->execute();
     }else{
       $default_name = 'dev.jpg';
			 $get_file = $db->query("SELECT nama FROM pegawai WHERE id_pegawai='".$id_pegawai."'");
			 $file = $get_file->fetch(PDO::FETCH_ASSOC);
			 $filename = $file['nama_file'];
			 $location_original = $directory.$filename;
			 if (file_exists($location_original)) {
				 echo 'ada';
				 // unlink($location_original);
			 }
			 // $stmt = $db->prepare("UPDATE pegawai SET url_foto=:url,nama_file=:gambar WHERE id_pegawai=:id");
			 // $stmt->bindParam(":url",$url_default,PDO::PARAM_STR);
			 // $stmt->bindParam(":gambar",$default_name,PDO::PARAM_STR);
			 // $stmt->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
			 // $stmt->execute();
     }
		}else{

		}
}
