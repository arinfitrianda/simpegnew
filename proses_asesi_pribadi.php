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

$id_kompetensi = isset($_POST['id_kompetensi']) ? $_POST['id_kompetensi'] : '';
$sub_soal = isset($_POST['sub_soal']) ? $_POST['sub_soal'] : '';
$id_profesi    = isset($_POST['id_profesi']) ? $_POST['id_profesi'] : '';
$id_pegawai    = isset($_POST['id_pegawai']) ? $_POST['id_pegawai'] : '';
$create_at    = date('Y-m-d H:i:s');

// echo" 
// ini id_profesi $id_profesi <br>
// ini id_pegawai $id_pegawai <br> 
// ";

//perulangan dengan menggunakan for untuk menangkap isi array
$jumlah = count($id_kompetensi);
for ($i=0; $i < $jumlah; $i++) { 
  $id_kompetensinya = $id_kompetensi[$i];
  $sub_soalnya = $sub_soal[$i];
  $a = $i + 1;
  $jawaban = isset($_POST['jawaban'.$a]) ? $_POST['jawaban'.$a] : '';
  echo $jawaban;
//     //simpan dengan data baru
    
    $simpan = $db->prepare("INSERT INTO asesi_pribadi(id_kompetensi, id_profesi, id_pegawai,sub_soal, jawaban_asesi, create_at) VALUES (:id_kompetensi, :id_profesi, :id_pegawai, :sub_soal, :jawaban, :create_at)");
    $simpan->bindParam(":id_kompetensi",$id_kompetensinya,PDO::PARAM_STR);
    $simpan->bindParam(":id_profesi",$id_profesi,PDO::PARAM_STR);
    $simpan->bindParam(":id_pegawai",$id_pegawai,PDO::PARAM_STR);
    $simpan->bindParam(":sub_soal",$sub_soalnya,PDO::PARAM_STR);
    $simpan->bindParam(":jawaban",$jawaban,PDO::PARAM_STR);
    $simpan->bindParam(":create_at",$create_at,PDO::PARAM_STR);
    $simpan->execute();
}
$update_status = $db->prepare("INSERT INTO cek_asesi(id_pegawai, id_profesi, status_asesi, tgl_asesi) VALUES (:id_pegawai, :id_profesi, 1, :create_at)");
$update_status->BindParam(":id_pegawai", $id_pegawai);
$update_status->BindParam(":id_profesi", $id_profesi);
$update_status->BindParam(":create_at", $create_at);
$update_status->execute();

if($update_status->rowCount()==0){
  header("location:asesmen_asesi.php?id=$id_pegawai&status=111");    
}else{
  header("location:asesmen_asesi.php?id=$id_pegawai&status=1");
}