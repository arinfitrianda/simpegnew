<?php
session_start();
include("../inc/pdo.conf.php"); // ini buat include konfigurasi database
include("../inc/version.php"); //versi app
$namauser = $_SESSION['namauser']; //nama user
$password = $_SESSION['password']; //password
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
$tingkat_pendidikan = $_POST["tingkat_pendidikan"];
$fakultas = $_POST["fakultas"];
$jurusan = $_POST["jurusan"];
$no_sttb = $_POST["nomor_sttb"];
$tanggal_sttb = $_POST["tanggal_sttb"];
$nama_kepsek = $_POST["nama_kepsek"];
$nama_sekolah = $_POST["nama_sekolah"];
$lokasi_sekolah = $_POST["lokasi_sekolah"];
$nama_perguruan_tinggi = $_POST["nama_perguruan_tinggi"];
$scan_files = $_FILES['scan_files']['name'];
$namaSementara = $_FILES['scan_files']['tmp_name'];
$created_at = date('Y-m-d H:i:s');


$file_basename = substr($scan_files, 0, strripos($scan_files, '.')); // get file extention
$file_ext = substr($scan_files, strripos($scan_files, '.')); // get file name
$filesize = $_FILES["scan_files"]["size"];
$allowed_file_types = array('.pdf');	
$tgl_doc = date('Y-m-d');
$jam = date('H:i:s');


mkdir("../upload_simpeg/$id_pegawai", 0700);

$dir_file = "../upload_simpeg/$id_pegawai/";	

	if (in_array($file_ext,$allowed_file_types) && ($filesize < 2000000))
	{	
		// Rename file
		$newfilename = $id_pegawai."_". $tingkat_pendidikan."_". $tgl_doc ."_". $jam. $file_ext;
		if (file_exists($dir_file . $newfilename))
		{
			// file already exists error
			header("location:profil_pegawai.php?id=$id_pegawai&status=file_ada");
		}
		else
		{		
			$insert = $db->prepare("INSERT INTO pegawai_pend_formal(id_pegawai, tingkat_pendidikan, fakultas, jurusan, nomor_sttb, tanggal_sttb, nama_kepsek, nama_sekolah, lokasi_sekolah, url_doc, nama_doc, nama_perguruan_tinggi, created_at) VALUES (:id_pegawai, :tingkat_pendidikan, :fakultas, :jurusan, :no_sttb, :tanggal_sttb, :nama_kepsek, :nama_sekolah, :lokasi_sekolah, :dir_file, :scan_files, :nama_perguruan_tinggi, :created_at)");
			    $insert->BindParam(":id_pegawai", $id_pegawai);
			    $insert->BindParam(":tingkat_pendidikan", $tingkat_pendidikan);
			    $insert->BindParam(":fakultas", $fakultas);
			    $insert->BindParam(":jurusan", $jurusan);
			    $insert->BindParam(":no_sttb", $no_sttb);
			    $insert->BindParam(":nama_kepsek", $nama_kepsek);
			    $insert->BindParam(":nama_sekolah", $nama_sekolah);
			    $insert->BindParam(":lokasi_sekolah", $lokasi_sekolah);
			    $insert->BindParam(":nama_perguruan_tinggi", $nama_perguruan_tinggi);
			    $insert->BindParam(":created_at", $created_at);
			    $insert->BindParam(":dir_file", $dir_file);
			    $insert->BindParam(":scan_files", $newfilename);
			    $insert->BindParam(":tanggal_sttb", $tanggal_sttb);
			    $insert->execute();
			    move_uploaded_file($_FILES["scan_files"]["tmp_name"], $dir_file . $newfilename);
			    
			    if($insert->rowCount()==0){
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