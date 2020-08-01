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
$id_pendFormal = $_POST["id_pendFormal"];
$tingkat_pendidikan = $_POST["tingkat_pendidikan"];
$fakultas = $_POST["fakultas"];
$jurusan = $_POST["jurusan"];
$no_sttb = $_POST["nomor_sttb"];
$tanggal_sttb = $_POST["tanggal_sttb"];
$nama_kepsek = $_POST["nama_kepsek"];
$nama_sekolah = $_POST["nama_sekolah"];
$lokasi_sekolah = $_POST["lokasi_sekolah"];
$nama_perguruan_tinggi = $_POST["nama_pt"];
$scan_files = $_FILES['scan_files']['name'];
$update = date('Y-m-d H:i:s');

echo $scan_files;

// // tentukan lokasi file akan dipindahkan
$dir_file = "../upload_simpeg/$id_pegawai/";


if (empty($scan_files)){
	$update = $db->prepare("UPDATE pegawai_pend_formal SET tingkat_pendidikan=:tingkat_pendidikan, fakultas=:fakultas, jurusan=:jurusan, nomor_sttb=:no_sttb, tanggal_sttb=:tanggal_sttb, nama_kepsek=:nama_kepsek, nama_sekolah=:nama_sekolah, lokasi_sekolah=:lokasi_sekolah, nama_perguruan_tinggi=:nama_perguruan_tinggi, update_at=:update_at WHERE id_pend_formal=:id_pendFormal AND id_pegawai=:id_pegawai");
	$update->BindParam(":id_pegawai", $id_pegawai);
	$update->BindParam(":id_pendFormal", $id_pendFormal);
	$update->BindParam(":tingkat_pendidikan", $tingkat_pendidikan);
	$update->BindParam(":fakultas", $fakultas);
	$update->BindParam(":jurusan", $jurusan);
	$update->BindParam(":no_sttb", $no_sttb);
	$update->BindParam(":nama_kepsek", $nama_kepsek);
	$update->BindParam(":nama_sekolah", $nama_sekolah);
	$update->BindParam(":lokasi_sekolah", $lokasi_sekolah);
	$update->BindParam(":nama_perguruan_tinggi", $nama_perguruan_tinggi);
	$update->BindParam(":update_at", $update_at);
	$update->BindParam(":tanggal_sttb", $tanggal_sttb);
	$update->execute();

	if($update->rowCount()==0){
		header("locatio:profil_pegawai.php?id=$id_pegawai&status=112");
	}else{		
		header("location:profil_pegawai.php?id=$id_pegawai&status=2");
	}
}else{
	$file_basename = substr($scan_files, 0, strripos($scan_files, '.')); // get file extention
	$file_ext = substr($scan_files, strripos($scan_files, '.')); // get file name
	$filesize = $_FILES["scan_files"]["size"];
	$allowed_file_types = array('.doc','.docx','.rtf','.pdf');	
	$tipe_inputan = "__pendidikan_formal__";
	$tgl_doc = date('Y-m-d');

// mkdir("../upload_simpeg/$id_pegawai", 0700);
$dir_file = "../upload_simpeg/$id_pegawai/";	

	if (in_array($file_ext,$allowed_file_types) && ($filesize < 2000000))
	{	
		// Rename file
		$newfilename = $id_pegawai . $tipe_inputan . $tgl_doc . $file_ext;
		if (file_exists($dir_file . $newfilename))
		{
			// file already exists error
			header("location:profil_pegawai.php?id=$id_pegawai&status=file_ada");
		}
		else
		{
			$update = $db->prepare("UPDATE pegawai_pend_formal SET tingkat_pendidikan=:tingkat_pendidikan, fakultas=:fakultas, jurusan=:jurusan, nomor_sttb=:no_sttb, tanggal_sttb=:tanggal_sttb, nama_kepsek=:nama_kepsek, nama_sekolah=:nama_sekolah, lokasi_sekolah=:lokasi_sekolah, url_doc=:dir_file, nama_doc =:scan_files, nama_perguruan_tinggi=:nama_perguruan_tinggi, update_at=:update_at WHERE id_pend_formal=:id_pendFormal AND id_pegawai=:id_pegawai");
			$update->BindParam(":id_pegawai", $id_pegawai);
			$update->BindParam(":id_pendFormal", $id_pendFormal);
			$update->BindParam(":tingkat_pendidikan", $tingkat_pendidikan);
			$update->BindParam(":fakultas", $fakultas);
			$update->BindParam(":jurusan", $jurusan);
			$update->BindParam(":no_sttb", $no_sttb);
			$update->BindParam(":nama_kepsek", $nama_kepsek);
			$update->BindParam(":nama_sekolah", $nama_sekolah);
			$update->BindParam(":lokasi_sekolah", $lokasi_sekolah);
			$update->BindParam(":nama_perguruan_tinggi", $nama_perguruan_tinggi);
			$update->BindParam(":dir_file", $dir_file);
			$update->BindParam(":scan_files", $newfilename);
			$update->BindParam(":update_at", $update_at);
			$update->BindParam(":tanggal_sttb", $tanggal_sttb);
			$update->execute();
			    move_uploaded_file($_FILES["scan_files"]["tmp_name"], $dir_file . $newfilename);
			    if($update->rowCount()==0){
					header("location:profil_pegawai.php?id=$id_pegawai&status=111");
				}else{
					header("location:profil_pegawai.php?id=$id_pegawai&status=1");
				}
		}
	}
	elseif (empty($file_basename))
	{	
		// file selection error
		header("location:profil_pegawai.php?id=$id_pegawai&status=file_kosong");
	} 
	elseif ($filesize > 2000000)
	{	
		// file size error
		header("location:profil_pegawai.php?id=$id_pegawai&status=file_besar");
	}
	else
	{
		// file type error
		header("location:profil_pegawai.php?id=$id_pegawai&status=file_not_pdf");
	}
}

// mkdir("../upload_simpeg/$id_pegawai", 0700);

?>