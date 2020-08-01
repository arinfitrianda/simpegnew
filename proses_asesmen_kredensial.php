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
$mem_id = $r1['mem_id'];

$sub_soal = isset($_POST['sub_soal']) ? $_POST['sub_soal'] : '';
$id_profesi    = isset($_POST['id_profesi']) ? $_POST['id_profesi'] : '';
$id_pegawai    = isset($_POST['id_pegawai']) ? $_POST['id_pegawai'] : '';
$id_kredensial = isset($_POST['id_kredensial']) ? $_POST['id_kredensial'] : '';
$create_at    = date('Y-m-d H:i:s');

//perulangan dengan menggunakan for untuk menangkap isi array
$jumlah = count($sub_soal);
for ($i=0; $i < $jumlah; $i++) { 
  $sub_soalnya = $sub_soal[$i];
  $a = $i + 1;
  $jawaban = isset($_POST['jawaban'.$a]) ? $_POST['jawaban'.$a] : '';

    //simpan dengan data baru
    
    $simpan = $db->prepare("INSERT INTO jawaban_kompetensi(soal, id_profesi, id_pegawai, id_kredensial, jawaban, created_at) VALUES (:sub_soal, :id_profesi, :id_pegawai, :id_kredensial, :jawaban,  :create_at)");
    $simpan->bindParam(":sub_soal",$sub_soalnya,PDO::PARAM_STR);
    $simpan->bindParam(":id_profesi",$id_profesi,PDO::PARAM_STR);
    $simpan->bindParam(":id_pegawai",$id_pegawai,PDO::PARAM_STR);
    $simpan->bindParam(":id_kredensial",$id_kredensial,PDO::PARAM_STR);
    $simpan->bindParam(":jawaban",$jawaban,PDO::PARAM_STR);
    $simpan->bindParam(":create_at",$create_at,PDO::PARAM_STR);
    $simpan->execute();
}
$update_status = $db->prepare("UPDATE `status_kredensial` SET `asesmen_kompetensi`=1,`tgl_asesmen_kompetensi`=:create_at WHERE id_kredensial=:id_kredensial AND id_pegawai=:id_pegawai");
$update_status->BindParam(":id_pegawai", $id_pegawai);
$update_status->BindParam(":id_kredensial", $id_kredensial);
$update_status->BindParam(":create_at", $create_at);
$update_status->execute();

if($update_status->rowCount()==0){
  header("location:asesmen_kredensial.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=111");    
}else{
  header("location:asesmen_kredensial.php?id_pegawai=$id_pegawai&id_kredensial=$id_kredensial&status=1");
}