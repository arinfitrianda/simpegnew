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
$id_str = $_POST["id_str"];
$id_pegawai = $_POST["id_pegawai"];
$no_str = $_POST["no_str"];
$tgl_terbit_str = $_POST["tgl_terbit_str"];
$tgl_kadaluarsa_str = $_POST["tgl_kadaluarsa_str"];
$pejabat_ttd = $_POST["pejabat_ttd"];
$keterangan = $_POST["keterangan"];
$scan_files = $_FILES['scan_files']['name'];
$namaSementara = $_FILES['scan_files']['tmp_name'];
$update_at = date('Y-m-d H:i:s');


$file_basename = substr($scan_files, 0, strripos($scan_files, '.')); // get file extention
$file_ext = substr($scan_files, strripos($scan_files, '.')); // get file name
$filesize = $_FILES["scan_files"]["size"];
$allowed_file_types = array('.pdf');	
$tgl_doc = date('Y-m-d');
$jam = date('H:i:s');
$tipe_dokumen  = "STR";

// // tentukan lokasi file akan dipindahkan
$dir_file = "../upload_simpeg/$id_pegawai/";


if (empty($scan_files)){
	$update = $db->prepare("UPDATE riwayat_str SET no_str=:no_str, tgl_terbit_str=:tgl_terbit_str,tgl_kadaluarsa_str=:tgl_kadaluarsa_str, pejabat_ttd=:pejabat_ttd, keterangan=:keterangan, update_at=:update_at WHERE id_str=:id_str AND id_pegawai=:id_pegawai");
	$update->BindParam(":id_str", $id_str);
	$update->BindParam(":id_pegawai", $id_pegawai);
	$update->BindParam(":no_str", $no_str);
	$update->BindParam(":tgl_terbit_str", $tgl_terbit_str);
	$update->BindParam(":tgl_kadaluarsa_str", $tgl_kadaluarsa_str);
	$update->BindParam(":pejabat_ttd", $pejabat_ttd);
	$update->BindParam(":keterangan", $keterangan);
	$update->BindParam(":update_at", $update_at);
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
			$update = $db->prepare("UPDATE riwayat_str SET no_str=:no_str, tgl_terbit_str=:tgl_terbit_str,tgl_kadaluarsa_str=:tgl_kadaluarsa_str, pejabat_ttd=:pejabat_ttd, keterangan=:keterangan, nama_doc=:nama_doc, url_doc=:url_doc,update_at=:update_at WHERE id_str=:id_str AND id_pegawai=:id_pegawai");
			$update->BindParam(":id_str", $id_str);
			$update->BindParam(":id_pegawai", $id_pegawai);
			$update->BindParam(":no_str", $no_str);
			$update->BindParam(":tgl_terbit_str", $tgl_terbit_str);
			$update->BindParam(":tgl_kadaluarsa_str", $tgl_kadaluarsa_str);
			$update->BindParam(":pejabat_ttd", $pejabat_ttd);
			$update->BindParam(":keterangan", $keterangan);
			$update->BindParam(":nama_doc", $newfilename);
			$update->BindParam(":url_doc", $dir_file);
			$update->BindParam(":update_at", $update_at);
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