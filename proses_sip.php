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
$no_sip = $_POST["no_sip"];
$tgl_terbit_sip = $_POST["tgl_terbit_sip"];
$tgl_kadaluarsa_sip = $_POST["tgl_kadaluarsa_sip"];
$pejabat_ttd = $_POST["pejabat_ttd"];
$keterangan = $_POST["keterangan"];
$scan_files = $_FILES['scan_files']['name'];
$namaSementara = $_FILES['scan_files']['tmp_name'];
$created_at = date('Y-m-d H:i:s');


$file_basename = substr($scan_files, 0, strripos($scan_files, '.')); // get file extention
$file_ext = substr($scan_files, strripos($scan_files, '.')); // get file name
$filesize = $_FILES["scan_files"]["size"];
$allowed_file_types = array('.pdf');	
$tgl_doc = date('Y-m-d');
$jam = date('H:i:s');
$tipe_dokumen  = "SIP";

mkdir("../upload_simpeg/$id_pegawai", 0700);

$dir_file = "../upload_simpeg/$id_pegawai/";	

	if (in_array($file_ext,$allowed_file_types) && ($filesize < 2000000))
	{	
		// Rename file
		$newfilename = $id_pegawai."_". $tipe_dokumen."_". $tgl_doc ."_". $jam. $file_ext;
		if (file_exists($dir_file . $newfilename))
		{
			// file already exists error
			header("location:profil_pegawai.php?id=$id_pegawai&status=file_ada");
		}
		else
		{		
			$insert = $db->prepare("INSERT INTO riwayat_sip(id_pegawai, no_sip, tgl_terbit_sip, tgl_kadaluarsa_sip, pejabat_ttd, keterangan, nama_doc, url_doc, create_at) VALUES (:id_pegawai, :no_sip, :tgl_terbit_sip, :tgl_kadaluarsa_sip, :pejabat_ttd, :keterangan, :nama_doc, :url_doc, :create_at)");
			    $insert->BindParam(":id_pegawai", $id_pegawai);
			    $insert->BindParam(":no_sip", $no_sip);
			    $insert->BindParam(":tgl_terbit_sip", $tgl_terbit_sip);
			    $insert->BindParam(":tgl_kadaluarsa_sip", $tgl_kadaluarsa_sip);
			    $insert->BindParam(":pejabat_ttd", $pejabat_ttd);
			    $insert->BindParam(":keterangan", $keterangan);
			    $insert->BindParam(":nama_doc", $newfilename);
			    $insert->BindParam(":url_doc", $dir_file);
			    $insert->BindParam(":create_at", $created_at);
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