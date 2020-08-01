	<?php
	session_start();
	include("../inc/pdo.conf.php");
	include("../inc/version.php");
	include("../inc/ip_server.php");
	$namauser = $_SESSION['namauser'];
	$password = $_SESSION['password'];
	$id_pegawai = $_SESSION['id_pegawai'];
	$tipes = explode('-',$_SESSION['tipe']);
	$role = $tipes[1];
	$parts = $tipes[2];
	// echo $role;
	if ($tipes[0]!='Simpeg')
	{
	unset($_SESSION['tipe']);
	unset($_SESSION['namauser']);
	unset($_SESSION['password']);
	header("location:../index.php?status=2");
	exit;
	}
	include "../inc/anggota_check.php";
	$id=isset($_GET["id"]) ? $_GET['id'] : '';
	//data header

	$peg = $db->prepare("SELECT pro.*,peg.url_foto,peg.nama_file,d.nama_dept FROM pegawai_profil pro LEFT JOIN pegawai peg ON(peg.id_pegawai=pro.id_peg) LEFT JOIN departemen d ON(peg.id_depart=d.id_dept) WHERE pro.id_peg=:id_peg");  
	$peg->bindParam(":id_peg",$id);
	$peg->execute();
	$pegawai = $peg->fetch(PDO::FETCH_ASSOC);

	$full_name="";
	if(($pegawai['prefix']!="-")&&($pegawai['prefix']!="")){
	$full_name .= $pegawai['prefix'].".".ucwords($pegawai['nama_lengkap']);
	}else{
	$full_name .= ucwords($pegawai['nama_lengkap']);
	}

	if(($pegawai['postfix']!="-")&&($pegawai['postfix']!="")){
	$full_name .= ", ".$pegawai['postfix'];
	}

	$status_notif = isset($_GET['status']) ? $_GET['status'] : '';

	//data pribadi
	$pribadi = $db->prepare("SELECT *,pro.name as 'provinsi',kab.name as 'kabupaten',kec.name as 'kecamatan',kel.name as 'kelurahan' FROM pegawai_profil peg LEFT JOIN provinsi pro ON(pro.id=peg.provinsi) LEFT JOIN kota kab ON(kab.id=peg.kabupaten) LEFT JOIN kecamatan kec ON(kec.id=peg.kecamatan) LEFT JOIN kelurahan kel ON(kel.id=peg.kelurahan) WHERE id_peg=:id");
	$pribadi->bindParam(":id",$id);
	$pribadi->execute();
	$dp = $pribadi->fetch(PDO::FETCH_ASSOC);
	//data formal
	$formal_list = $db->query("SELECT * FROM pegawai_pend_formal WHERE status=0 AND id_pegawai='".$id."'" );
	$formal = $formal_list->fetchAll(PDO::FETCH_ASSOC);

	//data non formal
	$nonformal_list = $db->query("SELECT * FROM pegawai_pend_nonformal WHERE status=0 AND id_pegawai='".$id."'" );
	$nonformal = $nonformal_list->fetchAll(PDO::FETCH_ASSOC);

	//data riwayat suami / istri
	$getRiwayatPasutri = $db->query("SELECT * FROM riwayat_suami_istri WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatPasutri = $getRiwayatPasutri->fetchAll(PDO::FETCH_ASSOC);

	//data riwayat anak
	$getRiwayatAnak = $db->query("SELECT * FROM riwayat_anak WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatAnak = $getRiwayatAnak->fetchAll(PDO::FETCH_ASSOC);

	//data riwayat orang tua
	$getRiwayatOrtu = $db->query("SELECT * FROM riwayat_ortu WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatOrtu = $getRiwayatOrtu->fetchAll(PDO::FETCH_ASSOC);

	//data riwayat jabatan
	$getRiwayatJabatan = $db->query("SELECT * FROM riwayat_jabatan WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatJabatan = $getRiwayatJabatan->fetchAll(PDO::FETCH_ASSOC);

	//data riwayat cuti
	$getRiwayatCuti = $db->query("SELECT * FROM riwayat_cuti WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatCuti = $getRiwayatCuti->fetchAll(PDO::FETCH_ASSOC);

	//data riwayat pekerjaan
	$getRiwayatPekerjaan = $db->query("SELECT * FROM riwayat_pekerjaan WHERE status=0 AND id_pegawai='".$id."'");
	$riwayatPekerjaan= $getRiwayatPekerjaan->fetchAll(PDO::FETCH_ASSOC);  

	$getRiwayatSTR = $db->query("SELECT * FROM riwayat_str WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatSTR= $getRiwayatSTR->fetchAll(PDO::FETCH_ASSOC);  

	$getRiwayatSIP = $db->query("SELECT * FROM riwayat_sip WHERE status=0 AND id_pegawai='".$id."'");
	$RiwayatSIP= $getRiwayatSIP->fetchAll(PDO::FETCH_ASSOC);  

	$getRiwayatPelatihan = $db->query("SELECT * FROM diklat_p WHERE id_pegawai='".$id."'");
	$RiwayatPelatihan= $getRiwayatPelatihan->fetchAll(PDO::FETCH_ASSOC);  
	?>

	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="UTF-8">
	<title>SIMRS <?php echo $version; ?> | <?php echo $r1["tipe"]; ?></title>
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<!-- Bootstrap 3.3.2 -->
	<link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="../plugins/font-awesome/4.3.0/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="../plugins/ionicons/2.0.0/ionicon.min.css" rel="stylesheet" type="text/css" />
	<!-- daterange picker -->
	<link href="../plugins/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />
	<!-- DATA TABLES -->
	<link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
	<!-- iCheck for checkboxes and radio inputs -->
	<link href="../plugins/iCheck/all.css" rel="stylesheet" type="text/css" />
	<!-- Theme style -->
	<link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	     folder instead of downloading all of them to reduce the load. -->
	<link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<!-- dropzone -->
		<link href="../plugins/dropzone/dropzone.css" rel="stylesheet" type="text/css" />

	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
	    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
	<![endif]-->
		<style>
		.modal {
		  overflow-y:auto;
		}
	  .example-modal .modal {
	    position: relative;
	    top: auto;
	    bottom: auto;
	    right: auto;
	    left: auto;
	    display: block;
	    z-index: 1050;
	  }

	  .example-modal .modal {
	    background: transparent !important;
			}
				.modal-backdrop {
				  background-color: transparent;
				}
				.modal-backdrop-transparent {
					position: fixed;
					top: 0;
					right: 0;
					bottom: 0;
					left: 0;
					background-color: transparent;
					opacity: 0;
					width: 100%;
					height: 100%;
					z-index: -1000;
				}
				.notif-backdrop {
				  background-color: transparent;
				}
				.notif-backdrop-transparent {
					position: fixed;
					top: 0;
					right: 0;
					bottom: 0;
					left: 0;
					background-color: transparent;
					opacity: 0;
					width: 100%;
					height: 100%;
					z-index: -1000;
				}
				.notif-backdrop-peter {
				  position: fixed;
				  top: 0;
				  right: 0;
				  bottom: 0;
				  left: 0;
				  background-color: #2c3e50;
				  opacity: 0.7;
				  width: 100%;
				  height: 100%;
				  z-index: 1900;
				}
				.modal-backdrop-peter {
				  position: fixed;
				  top: 0;
				  right: 0;
				  bottom: 0;
				  left: 0;
				  background-color: #3498db;
				  opacity: 1;
				  width: 100%;
				  height: 100%;
				  z-index: 1040;
				}
				.modal-transition {
				  transition: all 0.4s ease;
				}
				/* //custom notification */
				.notifyjs-foo-base {
				    opacity: 1;
				    width: 420px;
						height: auto;
				    background: #27ae60;
				    padding: 5px;
				    border-radius: 10px;
			    }
			    .notifyjs-foo-base .notif {
				    width: 400px;
				    float: left;
				    /* border: 1px solid green; */
			    }
			    .notifyjs-foo-base .title {
				    padding : 10px 0 0 10px;
				    text-align: left;
				    color:#FFF;
						font-weight: bold;
						font-size: 16px;
				    /* border: 1px solid black; */
			    }
			    .notifyjs-foo-base .subTitle {
			      margin: 5px 0 0 5px;
			      text-align: left;
						color: #FFF;
			      /* border: 1px solid pink; */
			    }

			    .notifyjs-foo-base .buttons {
			      width: 10px;
			      float: left;
			      font-size: 20px;
			      /* border: 1px solid white; */
			    }

			    .notifyjs-foo-base button {
				    /* font-size: 9px;
				    padding: 5px;
				    margin: 2px;
				    width: 60px; */
						font-size: 24px;
			    }
	</style>
	</head>
	<body class="skin-black">
	<div class="wrapper"> 
	  <?php 
	include "header.php";
	include "menu_index.php"; ?>
	  <div class="content-wrapper">
	    <!-- Content Header (Page header) -->
	    <section class="content-header">
	      <h1>
	        PEGAWAI
	        <small>PROFIL PEGAWAI</small>
	      </h1>
	      <ol class="breadcrumb">
	        <li><a href="index.php"><i class="fa fa-dashboard"></i> BERANDA</a></li>
	        <li class="active">DATA PEGAWAI</li>
	      </ol>
	    </section>

	    <!-- Main content -->
	    <section class="content">
	      <?php
	      if($status_notif==1){?>
	      <div class="alert alert-success alert-dismissible">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
	        Data Berhasil Di Tambahkan
	      </div>
	      <?php
	      }else if($status_notif==111){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          Data Gagal Di Tambahkan
	        </div>
	      <?php
	      }else if($status_notif==2){?>
	      <div class="alert alert-success alert-dismissible">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
	        Data Berhasil Di Update
	      </div>
	      <?php
	      }else if($status_notif==112){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          Data Gagal Di Update
	        </div>
	      <?php
	      }else if($status_notif==3){?>
	      <div class="alert alert-success alert-dismissible">
	        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	        <h4><i class="icon fa fa-check"></i> Sukses!</h4>
	        Data Berhasil Di Hapus
	      </div>
	      <?php
	      }else if($status_notif==113){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          Data Gagal Di Hapus
	        </div>
	      <?php
	      }else if($status_notif=="file_ada"){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          File Sudah Di Upload Sebelumnya
	        </div>
	      <?php
	      }else if($status_notif=="file_kosong"){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          File Tidak Terinput
	        </div>
	      <?php
	      }else if($status_notif=="file_besar"){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          Ukuran File Terlalu Besar
	        </div>
	      <?php
	      }else if($status_notif=="file_not_pdf"){?>
	        <div class="alert alert-danger alert-dismissible">
	          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	          <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
	          File Bukan PDF
	        </div>
	      <?php
	      }?>  
	          <!-- general form elements -->
			  <!-- left column -->
			  <div class="box box-primary">
	        <div class="box-header">
	          <i class="fa fa-user"></i>
					  <h3 class="box-title">Profil <?php echo $full_name; ?></h3>
							<p class="pull-right">Terakhir diupdate : <?php echo $pegawai['last_update']; ?></p>
	        </div><!-- /.box-header -->
	        <div class="box-body">
							<div class="row">
								<div class="col-md-4">
									<p style="text-align:center;">
										<?php
										$link = $pegawai['url_foto'].$pegawai['nama_file'];
											if(file_exists($link)){
												echo "<img src=\"".$link."\" alt=\"foto pegawai\" style=\"height:150px;width:125px;\" class=\"img-responsive img-thumbnail\">";
											}else{
												echo "<img src=\"../dist/img/dev.jpg\" alt=\"foto pegawai\"  style=\"height:150px;width:125px;\" class=\"img-responsive img-thumbnail\">";
											}
										?>
										<!-- <form class="form-horizontal" action="profil_up_foto.php" method="post" id="formPendidikanFormal">
											<div class="input-group input-group-sm col-md-8" style="padding-left:30px;">
												<input type="file" class="form-control" name="file" required>
												<div class="input-group-btn">
													<button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-edit"></i></button>
												</div>
											</div>
										</form> -->
										<br>
										<button type="button" id="btnClearGambar" class="btn btn-warning btn-xs"><i class="fa fa-trash"></i></button>
										<button type="button" id="btnGambar" class="btn btn-info btn-xs" data-toggle="modal" data-backdrop="static" data-target="#myModal"><i class="fa fa-gear"></i> Ganti Gambar</button>
										<div id="myModal" class="modal fade" role="dialog">
										  <div class="modal-dialog">

										    <!-- Modal content-->
										    <div class="modal-content">
										      <div class="modal-header">
										        <button type="button" class="close" data-dismiss="modal">&times;</butto6n>
										        <h4 class="modal-title">Upload Image File</h4>
										      </div>
											      <div class="modal-body">
															<form action="profil_foto_up.php" class="dropzone" id="dropzoneForm" method="post" enctype="multipart/form-data">
																<input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $id; ?>">
															  <div class="fallback">
															    <input id="file" name="file" type="file" required/>
															  </div>
															</form>
											      </div>
											      <div class="modal-footer">
															<button type="submit" id="uploadBtn" class="btn btn-primary pull-left" data-dismiss="modal"><i class="fa fa-save"></i> Simpan</button>
											        <button type="button" id="closeBtn" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
											      </div>
										    </div>

										  </div>
										</div>
									</p>

								</div>
								<div class="col-md-8">
										<table class="table table-hover table-striped table-bordered">
											<thead>
												<tr>
													<th class="info">NIP</th>
													<th><?php echo $pegawai['nip']; ?></th>
												</tr>
												<tr>
													<th class="info">Unit Kerja</th>
													<th><?php echo $pegawai['nama_dept']; ?></th>
												</tr>
												<tr>
													<th class="info">Nama Lengkap</th>
													<th><?php echo $full_name; ?></th>
												</tr>
											</thead>
										</table>
										<div class="form-group">
											<a href="form_edit_pegawai.php?d=<?php echo $id; ?>" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> Edit Data Master</a>
										</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12">
									<div class="nav-tabs-custom">
				            <ul class="nav nav-tabs pull-right">
	                  
	                  <li class="dropdown">
	                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                      Data Kredensial<span class="caret"></span>
	                    </a>
	                    <ul class="dropdown-menu">
	                      <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#pendidikanFormal">Formal</a></li>
	                      <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#pendidikanNonFormal">Non-Formal</a></li>
	                    </ul>
	                  </li>
	                  <li class="dropdown">
	                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                      Data Profesi<span class="caret"></span>
	                    </a>
	                    <ul class="dropdown-menu">
	                      <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#suratTandaRegistrasi">Surat Tanda Registrasi</a></li>
	                      <li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#suratIzinPraktek">Surat Izin Praktek</a></li>
	                    </ul>
	                  </li>
	                  <li class="dropdown">
	                  	<a class="dropdown-toggle" data-toggle="dropdown" href="#">Data Riwayat <span class="caret"></span></a>
	                  	<ul class="dropdown-menu">
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#riwayatSuamiIstri">Riwayat Suami/Istri</a></li>
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#riwayatAnak">Riwayat Anak</a></li>
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#riwayatOrangTua">Riwayat Orang Tua</a></li>
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#riwayatJabatan">Riwayat Jabatan</a></li>
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#riwayatCuti">Riwayat Cuti</a></li>
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#riwayatPekerjaan">Riwayat Pekerjaan</a></li>
	                  	</ul>
	                  </li>
	                  <li class="dropdown">
	                  	<a class="dropdown-toggle" data-toggle="dropdown" href="#">
	                  		Data Pendidikan <span class="caret"></span>
	                  	</a>
	                  	<ul class="dropdown-menu">
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#pendidikanFormal">Formal</a></li>
	                  		<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="tab" href="#pendidikanNonFormal">Non-Formal</a></li>
	                  	</ul>
	                  </li>
	                  <li class="active"><a href="#dataPribadi" data-toggle="tab">Data Pribadi</a></li>
	                  <li class="pull-left header"><i class="fa fa-th"></i> Menu</li>
	              		</ul>
				            <div class="tab-content">
				              <div class="tab-pane active" id="dataPribadi">
												<table class="table table-bordered">
													<tbody>
														<tr>
															<td class="info">Tempat, Tanggal Lahir</td>
															<td colspan="5"><?php echo $dp['tempat_lahir'].", ".$dp['tanggal_lahir']; ?></td>
														</tr>
														<tr>
															<td class="info">Jenis Kelamin</td>
															<td colspan="5"><?php  if($dp['jenis_kelamin']=='P'){ echo "Perempuan";}else{echo "Laki-Laki";} ?></td>
														</tr>
														<tr>
															<td class="info">Status Perkawinan</td>
															<td colspan="5"><?php echo $dp['status_perkawinan']; ?></td>
														</tr>
														<tr>
															<td class="info">Agama</td>
															<td colspan="5"><?php echo ucwords($dp['agama']); ?></td>
														</tr>
														<tr>
															<td class="info">Status Pegawai</td>
															<td><?php echo $dp['status_pegawai']; ?></td>
															<td class="info">TMT Pegawai</td>
															<td colspan="3"><?php echo $dp['tmt_pegawai']; ?></td>
														</tr>
														<tr>
															<td class="info">Pendidikan Awal</td>
															<td><?php echo $dp['pend_awal']; ?></td>
															<td class="info">Tahun Pendidikan Awal</td>
															<td colspan="3"><?php echo $dp['tahun_pend_awal']; ?></td>
														</tr>
														<tr>
															<td class="info">Pendidikan Akhir</td>
															<td><?php echo $dp['pend_akhir']; ?></td>
															<td class="info">Tahun Pendidikan Akhir</td>
															<td colspan="3"><?php echo $dp['tahun_pend_akhir']; ?></td>
														</tr>
														<tr>
															<td class="info">Nama Jabatan</td>
															<td><?php echo $dp['nama_jabatan']; ?></td>
															<td class="info">TMT Jabatan</td>
															<td colspan="3"><?php echo $dp['tmt_jabatan']; ?></td>
														</tr>
														<tr>
															<td class="info">Nama Profesi</td>
								                            <td colspan="5"><?php echo $pegawai['nama_profesi']; ?></td>
								                        </tr>
														<tr>
															<td class="info">No.Askes</td>
															<td colspan="5"><?php echo $dp['askes']; ?></td>
														</tr>
														<tr>
															<td class="info">No.KTP</td>
															<td><?php echo $dp['ktp']; ?></td>
															<td class="info">NPWP</td>
															<td colspan="3"><?php echo $dp['npwp']; ?></td>
														</tr>
														<tr>
															<td class="info">Golongan Darah</td>
															<td colspan="5"><?php echo $dp['golongan_darah']; ?></td>
														</tr>
														<tr>
															<td class="info">Alamat Rumah</td>
															<td colspan="5"><?php echo $dp['alamat']; ?></td>
														</tr>
														<tr>
															<td class="info">Provinsi</td>
															<td><?php echo $dp['provinsi']; ?></td>
															<td class="info">Kab/Kota</td>
															<td colspan="3"><?php echo $dp['kabupaten']; ?></td>
														</tr>
														<tr>
															<td class="info">Kecamatan</td>
															<td><?php echo $dp['kecamatan']; ?></td>
															<td class="info">Kelurahan</td>
															<td colspan="3"><?php echo $dp['kelurahan']; ?></td>
														</tr>
														<tr>
															<td class="info">Kode Pos</td>
															<td colspan="5"><?php echo $dp['kode_pos']; ?></td>
														</tr>
														<tr>
															<td class="info">Telepon</td>
															<td><?php echo $dp['telepon']; ?></td>
															<td class="info">No.WA</td>
															<td colspan="3"><?php echo $dp['no_wea']; ?></td>
														</tr>
														<tr>
															<td class="info">Email</td>
															<td colspan="5"><?php echo $dp['email_address']; ?></td>
														</tr>
													</tbody>
												</table>
				              </div>
				              <!-- /.tab-pane -->
				              <div class="tab-pane" id="pendidikanFormal">
												<div class="row">
													<div class="col-md-12">
														<h4 class="pull-left">Data Pendidikan Formal</h4>
														<button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalPendidikanFormal" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table id="pendidikanFormal1" class="table table-bordered table-striped" width="100%">
																<thead>
																	<tr>
																		<th rowspan="2">No</th>
																		<th rowspan="2">Tingkat Pendidikan</th>
																		<th rowspan="2">Fakultas</th>
																		<th rowspan="2">Jurusan</th>
																		<th colspan="3" class="text-center">STTB/Ijazah</th>
																		<th colspan="2" class="text-center">Sekolah/Perguruan Tinggi</th>
																		<th rowspan="2">Dokumen</th>
																		<th rowspan="2">Pilihan</th>
																	</tr>
																	<tr>
																		<th>Nomor</th>
																		<th>Tanggal</th>
																		<th>Kepala Sekolah/ Rektor</th>
																		<th>Nama</th>
																		<th>Lokasi</th>
																	</tr>
																</thead>
																<tbody>
																	<?php
																	$no=1;
																		foreach ($formal as $f) {
																			$id_pendFormal = $f["id_pend_formal"];
																			echo "<tr>
																							<td>".$no++."</td>
																							<td>".$f['tingkat_pendidikan']."</td>
																							<td>".$f['fakultas']."</td>
																							<td>".$f['jurusan']."</td>
																							<td>".$f['nomor_sttb']."</td>
																							<td>".$f['tanggal_sttb']."</td>
																							<td>".$f['nama_kepsek']."</td>
																							<td>".$f['nama_sekolah']."</td>
																							<td>".$f['lokasi_sekolah']."</td>
																							<td><a  target='_blank' href='".$f['url_doc']."/".$f['nama_doc']."' class='btn btn-xs btn-info'><i class='fa fa-file'></i> Lihat File</a></td>
																							<td>
											                                                <a  target='_blank' href='form_edit_pend_formal.php?id_pegawai=$id&id_pendFormal=$id_pendFormal' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
											                                                <a href='proses_hapus_pend_formal.php?id_pegawai=$id&id_pendFormal=$id_pendFormal' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()'><i class='fa fa-trash'></i> Hapus Data</a>
											                                              </td>
																						</tr>";
																		}
																	?>
																</tbody>
															</table>
														</div>
													</div>
												</div>
				              </div>
				              <!-- /.tab-pane -->
				              <div class="tab-pane" id="pendidikanNonFormal">
												<div class="row">
													<div class="col-md-12">
														<h4 class="pull-left">Data Pendidikan Non Formal</h4>
														<button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalPendidikanNonFormal" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
													</div>
												</div>
												<div class="row">
													<div class="col-md-12">
														<div class="table-responsive">
															<table id="pendidikanNonFormal1" class="table table-bordered table-striped" width="100%">
	                            <thead>
	                              <tr>
	                                <th rowspan="2">No</th>
	                                <th rowspan="2">Tingkat Pendidikan</th>
	                                <th rowspan="2">Fakultas</th>
	                                <th rowspan="2">Jurusan</th>
	                                <th colspan="3" class="text-center">STTB/Ijazah</th>
	                                <th colspan="2" class="text-center">Sekolah/Perguruan Tinggi</th>
	                                <th rowspan="2">Dokumen</th>
	                                <th rowspan="2">Pilihan</th>
	                              </tr>
	                              <tr>
	                                <th>Nomor</th>
	                                <th>Tanggal</th>
	                                <th>Kepala Sekolah/ Rektor</th>
	                                <th>Nama</th>
	                                <th>Lokasi</th>
	                              </tr>
	                            </thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($nonformal as $f) {
	                                  $id_pendNonformal = $f["id_pend_nonformal"];
	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$f['tingkat_pendidikan']."</td>
	                                          <td>".$f['fakultas']."</td>
	                                          <td>".$f['jurusan']."</td>
	                                          <td>".$f['nomor_sttb']."</td>
	                                          <td>".$f['tanggal_sttb']."</td>
	                                          <td>".$f['nama_kepsek']."</td>
	                                          <td>".$f['nama_sekolah']."</td>
	                                          <td>".$f['lokasi_sekolah']."</td>
	                                          <td><a  target='_blank' href='".$f['url_doc']."/".$f['nama_doc']."' class='btn btn-xs btn-info'><i class='fa fa-file'></i> Lihat File</a></td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_pend_nonformal.php?id_pegawai=$id&id_pendNonformal=$id_pendNonformal' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a href='proses_hapus_pend_nonformal.php?id_pegawai=$id&id_pendNonformal=$id_pendNonformal' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()'><i class='fa fa-trash'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
														</div>
													</div>
												</div>
				              </div>
											<div class="tab-pane" id="riwayatSuamiIstri">
												<div class="row">
													<div class="col-md-12">
														<h4 class="pull-left">Riwayat Suami / Istri</h4>
														<button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalRiwayatSuamiIstri" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
													</div>
													<div class="col-md-12">
														<div class="table-responsive">
															<table id="riwayatSuamiIstri1" class="table table-bordered table-striped">
																<thead>
																	<tr>
																		<th>No</th>
																		<th>KTP</th>
																		<th>Nama Suami/Istri</th>
																		<th>Keterangan Pasangan</th>
																		<th>Tempat dan Tanggal Lahir</th>
																		<th>Tanggal Nikah</th>
																		<th>Pendidikan</th>
																		<th>Pekerjaan</th>
																		<th>Keterangan</th>
																		<th>Pilihan</th>
																	</tr>
																</thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatPasutri as $data_pasutri) {
	                                  $id_pasutri = $data_pasutri['id_riwayat_pasutri'];
	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_pasutri['no_ktp_pasutri']."</td>
	                                          <td>".$data_pasutri['nama_pasutri']."</td>
	                                          <td>".$data_pasutri['ket_pasangan']."</td>
	                                          <td>".$data_pasutri['tempat_lahir_pasutri'].", ".$data_pasutri['tgl_lahir_pasutri']."</td>
	                                          <td>".$data_pasutri['tgl_nikah']."</td>
	                                          <td>".$data_pasutri['pendidikan_pasutri']."</td>
	                                          <td>".$data_pasutri['pekerjaan_pasutri']."</td>
	                                          <td>".$data_pasutri['keterangan']."</td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_pasutri.php?id_pegawai=$id&id_pasutri=$id_pasutri' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a href='proses_hapus_pasutri.php?id_pegawai=$id&id_pasutri=$id_pasutri' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()'><i class='fa fa-trash'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
															</table>
														</div>
													</div>
												</div>
				              </div>
											<div class="tab-pane" id="riwayatAnak">
												<div class="row">
													<div class="col-md-12">
														<h4 class="pull-left">Riwayat Anak</h4>
														<button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalRiwayatAnak" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
													</div>
													<div class="col-md-12">
														<div class="table-responsive">
															<table id="riwayatAnak1" class="table table-bordered table-striped">
																<thead>
																	<tr>
																		<th>No</th>
																		<th>KTP</th>
																		<th>Nama Anak</th>
																		<th>Jenis Kelamin</th>
																		<th>Tempat dan Tanggal Lahir</th>
																		<th>Status Perkawinan</th>
																		<th>Pendidikan</th>
																		<th>Pekerjaan</th>
																		<th>Keterangan</th>
																		<th>Pilihan</th>
																	</tr>
																</thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatAnak as $data_anak) {
	                                  $id_anak = $data_anak["id_anak"];
	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_anak['no_ktp_anak']."</td>
	                                          <td>".$data_anak['nama_anak']."</td>
	                                          <td>".$data_anak['jk_anak']."</td>
	                                          <td>".$data_anak['tempat_lahir_anak'].", ".$data_anak['tgl_lahir_anak']."</td>
	                                          <td>".$data_anak['status_perkawinan_anak']."</td>
	                                          <td>".$data_anak['pendidikan_anak']."</td>
	                                          <td>".$data_anak['pekerjaan_anak']."</td>
	                                          <td>".$data_anak['keterangan']."</td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_anak.php?id_pegawai=$id&id_anak=$id_anak' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='proses_hapus_anak.php?id_pegawai=$id&id_anak=$id_anak' class='btn btn-block btn-xs btn-danger'><i class='fa fa-trash' onclick='return deleteconfig()'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
															</table>
														</div>
													</div>
												</div>
				              </div>
	                  <div class="tab-pane" id="riwayatOrangTua">
	                    <div class="row">
	                      <div class="col-md-12">
	                        <h4 class="pull-left">Riwayat Orang Tua</h4>
	                        <button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalRiwayatOrtu" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
	                      </div>
	                      <div class="col-md-12">
	                        <div class="table-responsive">
	                          <table id="riwayatSuamiIstri1" class="table table-bordered table-striped">
	                            <thead>
	                              <tr>
	                                <th>No</th>
	                                <th>KTP</th>
	                                <th>Nama Orang Tua</th>
	                                <th>Jenis Kelamin</th>
	                                <th>Tempat dan Tanggal Lahir</th>
	                                <th>Pendidikan</th>
	                                <th>Pekerjaan</th>
	                                <th>Keterangan</th>
	                                <th>Pilihan</th>
	                              </tr>
	                            </thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatOrtu as $data_ortu) {
	                                  $id_ortu = $data_ortu["id_ortu"];
	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_ortu['no_ktp_ortu']."</td>
	                                          <td>".$data_ortu['nama_ortu']."</td>
	                                          <td>".$data_ortu['jk_ortu']."</td>
	                                          <td>".$data_ortu['tempat_lahir_ortu'].", ".$data_ortu['tgl_lahir_ortu']."</td>
	                                          <td>".$data_ortu['pendidikan_ortu']."</td>
	                                          <td>".$data_ortu['pekerjaan_ortu']."</td>
	                                          <td>".$data_ortu['keterangan']."</td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_ortu.php?id_pegawai=$id&id_ortu=$id_ortu' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='proses_hapus_ortu.php?id_pegawai=$id&id_ortu=$id_ortu' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()'><i class='fa fa-trash'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="tab-pane" id="riwayatJabatan">
	                    <div class="row">
	                      <div class="col-md-12">
	                        <h4 class="pull-left">Riwayat Jabatan</h4>
	                        <button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalRiwayatJabatan" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
	                      </div>
	                      <div class="col-md-12">
	                        <div class="table-responsive">
	                          <table id="riwayatSuamiIstri1" class="table table-bordered table-striped">
	                            <thead>
	                              <tr>
	                                <th>No</th>
	                                <th>Nama Jabatan</th>
	                                <th>Gol.Ruang</th>
	                                <th>Nomor SK</th>
	                                <th>Tanggal SK</th>
	                                <th>Jabatan Penandatanganan SK</th>
	                                <th>TMT SK</th>
	                                <th>Unit Kerja</th>
	                                <th>Pilihan</th>
	                              </tr>
	                            </thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatJabatan as $data_jabatan) {
	                                  $id_jabatan = $data_jabatan["id_jabatan"];
	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_jabatan['nama_jabatan']."</td>
	                                          <td>".$data_jabatan['gol_ruang']."</td>
	                                          <td>".$data_jabatan['no_sk']."</td>
	                                          <td>".$data_jabatan['tgl_sk']."</td>
	                                          <td>".$data_jabatan['pejabat_sk']."</td>
	                                          <td>".$data_jabatan['tmt_sk']."</td>
	                                          <td>".$data_jabatan['unit_kerja']."</td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_jabatan.php?id_pegawai=$id&id_jabatan=$id_jabatan' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='proses_hapus_jabatan.php?id_pegawai=$id&id_jabatan=$id_jabatan' class='btn btn-block btn-xs btn-danger'><i class='fa fa-trash' onclick='return deleteconfig()'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="tab-pane" id="riwayatPekerjaan">
	                    <div class="row">
	                      <div class="col-md-12">
	                        <h4 class="pull-left">Riwayat Pekerjaan</h4>
	                        <button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalRiwayatPekerjaan" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
	                      </div>
	                      <div class="col-md-12">
	                        <div class="table-responsive">
	                          <table id="riwayatPekerjaan" class="table table-bordered table-striped">                            
	                                <th>Nama Perusahaan</th>
	                                <th>Jabatan</th>
	                                <th>Tanggal Mulai Kerja</th>
	                                <th>Tanggal Selesai Kerja</th>
	                                <th>Alasan Keluar Kerja</th>
	                                <th>Keterangan</th>
	                                <th>Pilihan</th>
	                              </tr>
	                            </thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($riwayatPekerjaan as $data_pekerjaan) {
	                                  $id_pekerjaan = $data_pekerjaan["id_pekerjaan"];

	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_pekerjaan['nama_perusahaan']."</td>
	                                          <td>".$data_pekerjaan['jabatan']."</td>
	                                          <td>".$data_pekerjaan['tgl_mulai_kerja']."</td>
	                                          <td>".$data_pekerjaan['tgl_selesai_kerja']."</td>
	                                          <td>".$data_pekerjaan['alasan_keluar_kerja']."</td>
	                                          <td>".$data_pekerjaan['keterangan']."</td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_pekerjaan.php?id_pegawai=$id&id_pekerjaan=$id_pekerjaan' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='proses_hapus_pekerjaan.php?id_pegawai=$id&id_pekerjaan=$id_pekerjaan' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()'><i class='fa fa-trash'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="tab-pane" id="riwayatCuti">
	                    <div class="row">
	                      <div class="col-md-12">
	                        <h4 class="pull-left">Riwayat Cuti</h4>
	                        <button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalRiwayatCuti" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
	                      </div>
	                      <div class="col-md-12">
	                        <div class="table-responsive">
	                          <table id="riwayatSuamiIstri1" class="table table-bordered table-striped">
	                            <thead>
	                              <tr>
	                                <th>No</th>
	                                <th>Jenis Cuti</th>
	                                <th>No. Surat</th>
	                                <th>Tanggal Mulai</th>
	                                <th>Tanggal Selesai</th>
	                                <th>Lama Cuti</th>
	                                <th>Keterangan</th>
	                                <th>Pilihan</th>
	                              </tr>
	                            </thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatCuti as $data_cuti) {
	                                  $tgl_awal = $data_cuti["tgl_mulai_cuti"];
	                                  $tgl_akhir = $data_cuti["tgl_akhir_cuti"];
	                                  $id_cuti = $data_cuti["id_cuti"];
	                                  $diff = date_diff(date_create($tgl_akhir), date_create($tgl_awal));

	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_cuti['jenis_cuti']."</td>
	                                          <td>".$data_cuti['no_surat_cuti']."</td>
	                                          <td>".$data_cuti['tgl_mulai_cuti']."</td>
	                                          <td>".$data_cuti['tgl_akhir_cuti']."</td>
	                                          <td>".$lama_cuti = $diff->format('%d Hari')."</td>
	                                           <td>".$data_cuti['keterangan']."</td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_cuti.php?id_pegawai=$id&id_cuti=$id_cuti' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='proses_hapus_cuti.php?id_pegawai=$id&id_cuti=$id_cuti' class='btn btn-block btn-xs btn-danger'><i class='fa fa-trash' onclick='return deleteconfig()'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="tab-pane" id="suratIzinPraktek">
	                    <div class="row">
	                      <div class="col-md-12">
	                        <h4 class="pull-left">Surat Izin Praktek</h4>
	                        <button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalSIP" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
	                      </div>
	                      <div class="col-md-12">
	                        <div class="table-responsive">
	                          <table id="riwayatSuamiIstri1" class="table table-bordered table-striped">
	                            <thead>
	                              <tr>
	                                <th>No</th>
	                                <th>Nomor SIP</th>
	                                <th>Tanggal Terbit SIP</th>
	                                <th>Tanggal Kadaluarsa SIP</th>
	                                <th>Jabatan Penandatanganan SIP</th>
	                                <th>Keterangan</th>
	                                <th>Dokumen</th>
	                                <th>Pilihan</th>
	                              </tr>
	                            </thead>
	                             <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatSIP as $data_sip) {
	                                  $id_sip = $data_sip["id_sip"];

	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_sip['no_sip']."</td>
	                                          <td>".$data_sip['tgl_terbit_sip']."</td>
	                                          <td>".$data_sip['tgl_kadaluarsa_sip']."</td>
	                                          <td>".$data_sip['pejabat_ttd']."</td>
	                                          <td>".$data_sip['keterangan']."</td>
	                                          <td><a  target='_blank' href='".$f['url_doc']."/".$f['nama_doc']."' class='btn btn-xs btn-info'><i class='fa fa-file'></i> Lihat File</a></td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_sip.php?id_pegawai=$id&id_sip=$id_sip' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='form_edit_sip.php?id_pegawai=$id&id_sip=$id_sip' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()'><i class='fa fa-trash'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
	                  <div class="tab-pane" id="suratTandaRegistrasi">
	                    <div class="row">
	                      <div class="col-md-12">
	                        <h4 class="pull-left">Surat Tanda Registrasi</h4>
	                        <button id="blue-button" type="button" class="btn btn-sm btn-success pull-right" data-toggle="modal" data-target="#modalSTR" data-color="peter"><i class="fa fa-plus"></i> Tambah Data</button>
	                      </div>
	                      <div class="col-md-12">
	                        <div class="table-responsive">
	                          <table id="riwayatSuamiIstri1" class="table table-bordered table-striped">
	                            <thead>
	                              <tr>
	                                <th>No</th>
	                                <th>Nomor STR</th>
	                                <th>Tanggal Terbit STR</th>
	                                <th>Tanggal Kadaluarsa STR</th>
	                                <th>Jabatan Penandatanganan STR</th>
	                                <th>Keterangan</th>
	                                <th>Dokumen</th>
	                                <th>Pilihan</th>
	                              </tr>
	                            </thead>
	                            <tbody>
	                              <?php
	                              $no=1;
	                                foreach ($RiwayatSTR as $data_str) {
	                                  $id_str = $data_str["id_str"];
	                                  // print_r($id_str);

	                                  echo "<tr>
	                                          <td>".$no++."</td>
	                                          <td>".$data_str['no_str']."</td>
	                                          <td>".$data_str['tgl_terbit_str']."</td>
	                                          <td>".$data_str['tgl_kadaluarsa_str']."</td>
	                                          <td>".$data_str['pejabat_ttd']."</td>
	                                          <td>".$data_str['keterangan']."</td>
	                                          <td><a  target='_blank' href='".$f['url_doc']."/".$f['nama_doc']."' class='btn btn-xs btn-info'><i class='fa fa-file'></i> Lihat File</a></td>
	                                          <td>
	                                            <a  target='_blank' href='form_edit_str.php?id_pegawai=$id&id_str=$id_str' class='btn btn-block btn-xs btn-warning'><i class='fa fa-edit'></i> Ubah Data</a>
	                                            <a  target='_blank' href='proses_hapus_str.php?id_pegawai=$id&id_str=$id_str' class='btn btn-block btn-xs btn-danger' onclick='return deleteconfig()' ><i class='fa fa-trash'></i> Hapus Data</a>
	                                          </td>
	                                        </tr>";
	                                }
	                              ?>
	                            </tbody>
	                          </table>
	                        </div>
	                      </div>
	                    </div>
	                  </div>
				              <!-- /.tab-pane -->
				            </div>
				            <!-- /.tab-content -->
				          </div>

								  </div>
								</div>
							</div>
	        </div>
			  </div><!-- /.left column -->

	    </section><!-- /.content -->
	  </div><!-- /.content-wrapper -->
	  <!-- static footer -->
	  <?php include("footer.php");?><!-- /.static footer -->
	</div><!-- ./wrapper -->

		<!-- Modal Pendidikan Formal -->
		<div class="example-modal modal fade" style="overflow-y:auto;" id="modalPendidikanNonFormal" role="dialog">
			<div class="modal">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span></button>
							<h4 class="modal-title">Form Tambah Data Pendidikan Non Formal</h4>
						</div>
						<div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_pendidikan_nonformal.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tingkat_pendidikan">Tingkat Pendidikan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="tingkat_pendidikan" id="tingkat_pendidikan" required>
	                    <option value="">Pilih Tingkat Pendidikan</option>
	                    <option value="SD">SD</option>
	                    <option value="SLTP">SLTP</option>
	                    <option value="SLTA">SLTA</option>
	                    <option value="D1">D1</option>
	                    <option value="D2">D2</option>
	                    <option value="D3">D3</option>
	                    <option value="S1/D4">S1/D4</option>
	                    <option value="S2">S2</option>
	                    <option value="S3">S3</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="fakultas">Fakultas<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="fakultas" name="fakultas" placeholder="Masukan Nama Fakultas" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jurusan">Jurusan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukan Nama Jurusan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nomor_sttb">Nomor Ijazah/STTB<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nomor_sttb" name="nomor_sttb" placeholder="Masukan Nomor STTB" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tanggal_sttb">Tanggal Ijazah/STTB<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tanggal_sttb" name="tanggal_sttb" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_kepsek">Nama Kepala Sekolah/Rektor<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" placeholder="Masukan Kepala Sekolah/Rektor" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_sekolah">Nama Sekolah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="Masukan Nama Sekolah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="lokasi_sekolah">Lokasi Sekolah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="lokasi_sekolah" name="lokasi_sekolah" placeholder="Masukan Lokasi Sekolah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_perguruan_tinggi">Nama Perguruan Tinggi<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_perguruan_tinggi" name="nama_perguruan_tinggi" placeholder="Nama Perguruan Tinggi" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="scan_files">Dokumen<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <!-- <input type="file" class="form-control" id="scan_files" name="scan_files"> -->
	                  <div class="dropzone" id="myDropzone" name="scan_files"></div>
	                  <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
	                </div>
	              </div>
	        </div>
						<div class="modal-footer">
							<button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
							<!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" id="submitAll" class="btn btn-success">
	          </div>
	        </form>
						</div>
					</div>
					<!-- /.modal-content -->
				</div>
				<!-- /.modal-dialog -->
			</div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalPendidikanFormal" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Pendidikan Formal</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_pendidikan_formal.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tingkat_pendidikan">Tingkat Pendidikan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="tingkat_pendidikan" id="tingkat_pendidikan" required>
	                    <option value="">Pilih Tingkat Pendidikan</option>
	                    <option value="SD">SD</option>
	                    <option value="SLTP">SLTP</option>
	                    <option value="SLTA">SLTA</option>
	                    <option value="D1">D1</option>
	                    <option value="D2">D2</option>
	                    <option value="D3">D3</option>
	                    <option value="S1/D4">S1/D4</option>
	                    <option value="S2">S2</option>
	                    <option value="S3">S3</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="fakultas">Fakultas<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="fakultas" name="fakultas" placeholder="Masukan Nama Fakultas" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jurusan">Jurusan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukan Nama Jurusan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nomor_sttb">Nomor Ijazah/STTB<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nomor_sttb" name="nomor_sttb" placeholder="Masukan Nomor STTB" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tanggal_sttb">Tanggal Ijazah/STTB<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tanggal_sttb" name="tanggal_sttb" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_kepsek">Nama Kepala Sekolah/Rektor<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" placeholder="Masukan Kepala Sekolah/Rektor" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_sekolah">Nama Sekolah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="Masukan Nama Sekolah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="lokasi_sekolah">Lokasi Sekolah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="lokasi_sekolah" name="lokasi_sekolah" placeholder="Masukan Lokasi Sekolah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_perguruan_tinggi">Nama Perguruan Tinggi<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_perguruan_tinggi" name="nama_perguruan_tinggi" placeholder="Nama Perguruan Tinggi" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="scan_files">Dokumen<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="file" class="form-control" id="scan_files" name="scan_files">
	                  <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalRiwayatSuamiIstri" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Riwayat Suami / Istri</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_riwayat_suami_istri.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_ktp_pasutri">No KTP<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_ktp_pasutri" name="no_ktp_pasutri" placeholder="Masukan Nomor KTP" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_suami_istri">Nama Suami / Istri<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_suami_istri" name="nama_suami_istri" placeholder="Masukan Nama Suami / Istri" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_suami_istri">Keterangan Suami / Istri<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="ket_pasangan" id="ket_pasangan" required>
	                    <option value="">Pilih Keterangan Pasangan</option>
	                    <option value="Suami">Suami</option>
	                    <option value="Istri">Istri</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tempat_lahir_suami_istri">Tempat Lahir<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="tempat_lahir_suami_istri" name="tempat_lahir_suami_istri" placeholder="Masukan Tempat Lahir" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_lahir_suami_istri">Tanggal Lahir Suami/Istri<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_lahir_suami_istri" name="tgl_lahir_suami_istri" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_nikah">Tanggal Nikah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_nikah" name="tgl_nikah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pendidikan_pasutri">Pendidikan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="pendidikan_pasutri" id="pendidikan_pasutri" required>
	                    <option value="">Pilih Pendidikan</option>
	                    <option value="SD">SD</option>
	                    <option value="SLTP">SLTP</option>
	                    <option value="SLTA">SLTA</option>
	                    <option value="D1">D1</option>
	                    <option value="D2">D2</option>
	                    <option value="D3">D3</option>
	                    <option value="S1/D4">S1/D4</option>
	                    <option value="S2">S2</option>
	                    <option value="S3">S3</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pekerjaan_pasutri">Pekerjaan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="pekerjaan_pasutri" name="pekerjaan_pasutri" placeholder="Masukan Pekerjaan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" id="buttonBatal" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalRiwayatAnak" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Anak</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_riwayat_anak.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_ktp_anak">No KTP<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_ktp_anak" name="no_ktp_anak" placeholder="Masukan Nomor KTP" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_anak">Nama Anak<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_anak" name="nama_anak" placeholder="Masukan Nama Anak" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jk_anak">Jenis Kelamin<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="jk_anak" id="jk_anak" required>
	                    <option value="">Pilih Jenis Kelamin</option>
	                    <option value="Perempuan">Perempuan</option>
	                    <option value="Laki-laki">Laki-laki</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tempat_lahir_anak">Tempat Lahir<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="tempat_lahir_anak" name="tempat_lahir_anak" placeholder="Masukan Tempat Lahir" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_lahir_anak">Tanggal Lahir Anak<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_lahir_anak" name="tgl_lahir_anak" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="status_perkawinan_anak">Status Perkawinan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                 <select class="form-control" name="status_perkawinan_anak" id="status_perkawinan_anak" required>
	                    <option value="">Pilih Status Perkawinan</option>
	                    <option value="Kawin">Kawin</option>
	                    <option value="Belum Kawin">Belum Kawin</option>
	                    <option value="Janda">Janda</option>
	                    <option value="Duda">Duda</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pendidikan_anak">Pendidikan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="pendidikan_anak" id="pendidikan_anak" required>
	                    <option value="">Pilih Pendidikan</option>
	                    <option value="SD">SD</option>
	                    <option value="SLTP">SLTP</option>
	                    <option value="SLTA">SLTA</option>
	                    <option value="D1">D1</option>
	                    <option value="D2">D2</option>
	                    <option value="D3">D3</option>
	                    <option value="S1/D4">S1/D4</option>
	                    <option value="S2">S2</option>
	                    <option value="S3">S3</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pekerjaan_anak">Pekerjaan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="pekerjaan_anak" name="pekerjaan_anak" placeholder="Masukan Pekerjaan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" id="buttonBatal" class="btn btn-danger pull-left" data-dismiss="modal" id="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalRiwayatOrtu" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Orang Tua</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_riwayat_ortu.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_ktp_ortu">No KTP<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_ktp_ortu" name="no_ktp_ortu" placeholder="Masukan Nomor KTP" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_ortu">Nama Orang Tua<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_ortu" name="nama_ortu" placeholder="Masukan Nama Orang Tua" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jk_ortu">Jenis Kelamin<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="jk_ortu" id="jk_ortu" required>
	                    <option value="">Pilih Jenis Kelamin</option>
	                    <option value="Perempuan">Perempuan</option>
	                    <option value="Laki-laki">Laki-laki</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tempat_lahir_ortu">Tempat Lahir<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="tempat_lahir_ortu" name="tempat_lahir_ortu" placeholder="Masukan Tempat Lahir" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_lahir_ortu">Tanggal Lahir Orang Tua<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_lahir_ortu" name="tgl_lahir_ortu" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pendidikan_ortu">Pendidikan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="pendidikan_ortu" id="pendidikan_ortu" required>
	                    <option value="">Pilih Pendidikan</option>
	                    <option value="SD">SD</option>
	                    <option value="SLTP">SLTP</option>
	                    <option value="SLTA">SLTA</option>
	                    <option value="D1">D1</option>
	                    <option value="D2">D2</option>
	                    <option value="D3">D3</option>
	                    <option value="S1/D4">S1/D4</option>
	                    <option value="S2">S2</option>
	                    <option value="S3">S3</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pekerjaan_ortu">Pekerjaan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="pekerjaan_ortu" name="pekerjaan_ortu" placeholder="Masukan Pekerjaan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" id="buttonBatal" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalRiwayatJabatan" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Jabatan</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_riwayat_jabatan.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_jabatan">Nama Jabatan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_jabatan" name="nama_jabatan" placeholder="Masukan Nama Jabatan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="gol_ruang">Gol. Ruang<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="gol_ruang" name="gol_ruang" placeholder="Masukan Gol.Ruang" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_sk">No Surat Keputusan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_sk" name="no_sk" placeholder="Masukan Jenis Kelamin" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_sk">Tanggal Surat Keputusan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_sk" name="tgl_sk" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pejabat_sk">Jabatan Penandatanganan Surat Keputusan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="pejabat_sk" name="pejabat_sk" placeholder="Masukan Jabatan Penandatanganan Surat Keputusan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_tmt_sk">TMT SK<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_tmt_sk" name="tgl_tmt_sk" placeholder="Masukan Tanggal TMT Surat Keputusan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="unit_kerja">Unit Kerja<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="unit_kerja" name="unit_kerja" placeholder="Masukan Unit Kerja" required>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" id="buttonBatal" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalRiwayatCuti" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Cuti</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_riwayat_cuti.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jenis_cuti">Jenis Cuti<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="jenis_cuti" name="jenis_cuti" placeholder="Masukan Jenis Cuti" required>
	              </div>
	            </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_surat_cuti">No Surat Cuti<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_surat_cuti" name="no_surat_cuti" placeholder="Masukan Nomer Surat Cuti" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_mulai_cuti">Tanggal Mulai Cuti<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_mulai_cuti" name="tgl_mulai_cuti" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_selesai_cuti">Tanggal Selesai Cuti<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_selesai_cuti" name="tgl_selesai_cuti" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_selesai_cuti">Tanggal Masa Cuti<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control pull-right" id="reservationtime">
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" id="buttonBatal" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" onclick="cekCuti()" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>

	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalRiwayatPekerjaan" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Riwayat Pekerjaan</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_riwayat_pekerjaan.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_perusahaan">Nama Perusahaan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" placeholder="Masukan Nama Perusahaan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jabatan">Jabatan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="Masukan jabatan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_mulai_">Tanggal Mulai Bekerja<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_mulai_kerja" name="tgl_mulai_kerja" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_selesai_kerja">Tanggal Selesai Bekerja<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_selesai_kerja" name="tgl_selesai_kerja" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="alasan_keluar_kerja">Alasan Keluar Kerja<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="alasan_keluar_kerja" name="alasan_keluar_kerja" placeholder="Masukan Alasan Kerja" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" id="buttonBatal" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.mo
	        dal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalPendidikanNonFormal" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Pendidikan Non Formal</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_pendidikan_nonformal.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tingkat_pendidikan">Tingkat Pendidikan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <select class="form-control" name="tingkat_pendidikan" id="tingkat_pendidikan" required>
	                    <option value="">Pilih Tingkat Pendidikan</option>
	                    <option value="SD">SD</option>
	                    <option value="SLTP">SLTP</option>
	                    <option value="SLTA">SLTA</option>
	                    <option value="D1">D1</option>
	                    <option value="D2">D2</option>
	                    <option value="D3">D3</option>
	                    <option value="S1/D4">S1/D4</option>
	                    <option value="S2">S2</option>
	                    <option value="S3">S3</option>
	                  </select>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="fakultas">Fakultas<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="fakultas" name="fakultas" placeholder="Masukan Nama Fakultas" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="jurusan">Jurusan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="jurusan" name="jurusan" placeholder="Masukan Nama Jurusan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nomor_sttb">Nomor Ijazah/STTB<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nomor_sttb" name="nomor_sttb" placeholder="Masukan Nomor STTB" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tanggal_sttb">Tanggal Ijazah/STTB<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tanggal_sttb" name="tanggal_sttb" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_kepsek">Nama Kepala Sekolah/Rektor<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" placeholder="Masukan Kepala Sekolah/Rektor" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_sekolah">Nama Sekolah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" placeholder="Masukan Nama Sekolah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="lokasi_sekolah">Lokasi Sekolah<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="lokasi_sekolah" name="lokasi_sekolah" placeholder="Masukan Lokasi Sekolah" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="nama_perguruan_tinggi">Nama Perguruan Tinggi<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="nama_perguruan_tinggi" name="nama_perguruan_tinggi" placeholder="Nama Perguruan Tinggi" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="scan_files">Dokumen<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <!-- <input type="file" class="form-control" id="scan_files" name="scan_files"> -->
	                  <div class="dropzone" id="myDropzone" name="scan_files"></div>
	                  <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <!-- <input type="submit" name="submit" value="Simpan" class="btn btn-success"> -->
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" id="submitAll" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalSTR" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Surat Tanda Registrasi</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_str.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_str">Nomor Surat Tanda Registrasi<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_str" name="no_str" placeholder="Masukan Nomor Surat Tanda Registrasi" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_terbit_str">Tanggal Terbit Surat Tanda Registrasi<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_terbit_str" name="tgl_terbit_str" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_kadaluarsa_str">Tanggal Akhir Masa Berlaku Surat Tanda Registrasi<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_kadaluarsa_str" name="tgl_kadaluarsa_str" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pejabat_ttd">Jabatan Penandatanganan STR<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="pejabat_ttd" name="pejabat_ttd" placeholder="Masukan Jabatan Penandatanganan STR" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="scan_files">Dokumen<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="file" class="form-control" id="scan_files" name="scan_files">
	                  <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
	<div class="example-modal modal fade" style="overflow-y:auto;" id="modalSIP" role="dialog">
	  <div class="modal">
	    <div class="modal-dialog modal-lg">
	      <div class="modal-content">
	        <div class="modal-header">
	          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	            <span aria-hidden="true">&times;</span></button>
	          <h4 class="modal-title">Form Tambah Data Surat Izin Praktek</h4>
	        </div>
	        <div class="modal-body">
	          <div class="alert alert-info">
	            <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
	          </div>
	          <form action="proses_sip.php" class="form-horizontal" enctype="multipart/form-data" id="formInput" method="POST">
	            <input type="hidden" id="id_pegawai" name="id_pegawai" value="<?php echo $id; ?>">
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="no_sip">Nomor Surat Izin Praktek<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="no_sip" name="no_sip" placeholder="Masukan Nomor Surat Izin Praktek" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_terbit_sip">Tanggal Terbit Surat Izin Praktek<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_terbit_sip" name="tgl_terbit_sip" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="tgl_kadaluarsa_sip">Tanggal Akhir Masa Berlaku Surat Izin Praktek<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="date" class="form-control" id="tgl_kadaluarsa_sip" name="tgl_kadaluarsa_sip" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="pejabat_ttd">Jabatan Penandatanganan SIP<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="pejabat_ttd" name="pejabat_ttd" placeholder="Masukan Jabatan Penandatanganan STR" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="keterangan">Keterangan<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="text" class="form-control" id="keterangan" name="keterangan" placeholder="Masukan Keterangan" required>
	                </div>
	              </div>
	              <div class="form-group">
	                <label class="control-label col-sm-3" for="scan_files">Dokumen<span style="color:red">*</span></label>
	                <div class="col-sm-9">
	                  <input type="file" class="form-control" id="scan_files" name="scan_files">
	                  <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
	                </div>
	              </div>
	        </div>
	        <div class="modal-footer">
	          <button type="button" class="btn btn-danger pull-left" data-dismiss="modal" onclick="hapusForm()"> Batal</button>
	          <div class="form-group">
	            <input type="submit" name="submit" value="Simpan" class="btn btn-success">
	          </div>
	        </form>
	        </div>
	      </div>
	      <!-- /.modal-content -->
	    </div>
	    <!-- /.modal-dialog -->
	  </div>
	</div>
			<!-- /.modal -->
			<!-- <div id="modal-backdrop" class="modal-backdrop-transparent modal-transition"></div>
			<div id="notif-backdrop" class="modal-backdrop-transparent modal-transition"></div> -->
		</div>
	<!-- jQuery 2.1.3 -->
	<script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
	<!-- Bootstrap 3.3.2 JS -->
	<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
	<!-- DATA TABES SCRIPT -->
	<script src="../plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
	<script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
	<!-- SlimScroll -->
	<script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
	<!-- date-picker -->
	<script src="../plugins/datepicker/bootstrap-datepicker.js" type="text/javascript"></script>
		<script type="text/javascript" src="../plugins/notify/js/notify.js"></script>
	<!-- typeahead -->
	<script src="../plugins/typeahead/typeahead.bundle.js" type="text/javascript"></script>
	<!-- iCheck 1.0.1 -->
	<script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
	<!-- FastClick -->
	<script src='../plugins/fastclick/fastclick.min.js'></script>
	<!-- AdminLTE App -->
	<script src="../dist/js/app.min.js" type="text/javascript"></script>
		<script src="../plugins/dropzone/dropzone.js"></script>
	<!-- page script -->
		<script type="text/javascript">
		$('[id$="-button"]').on("click", function (e) {
			var color = $(this).attr('data-color');
			var colorBackdrop = 'modal-backdrop-' + color;
			// alert(color);
			$('#modal-backdrop').addClass(colorBackdrop);
			});
			// $('#submitForm').on("click", function (e) {
			// 	// alert(color);
			// 	$('#notif-backdrop').addClass('notif-backdrop-peter');
			// });
			$('.btn-close, .modal').on("click", function (e) {
			var color = $('.in').attr('data-color');
			var activeBackdrop = 'modal-backdrop-' + color;
			$('#modal-backdrop').removeClass(activeBackdrop);
		});
		</script>
		<script type="text/javascript">
		$(document).ready(function () {
			function changePage(){
				window.location = window.location.href;
			}
			var closeBtn = document.querySelector('#closeBtn');
			closeBtn.addEventListener("click",function(){
				var id_pegawai = document.querySelector('#id_pegawai').value;
				pindah_halaman(id_pegawai);
			});
	$("#submitForm").click(function (event) {
	    //stop submit the form, we will post it manually.
	    event.preventDefault();
				// Create an FormData object
	    var data = new FormData();
				var tingkat_pendidikan = $('#tingkat_pendidikan').val();
				var fakultas = $('#fakultas').val();
				var jurusan = $('#jurusan').val();
				var nomor_sttb = $('#nomor_sttb').val();
				var tanggal_sttb = $('#tanggal_sttb').val();
				var nama_kepsek = $('#nama_kepsek').val();
				var nama_sekolah = $('#nama_sekolah').val();
				var lokasi_sekolah = $('#lokasi_sekolah').val();
				var nama_perguruan_tinggi = $('#nama_perguruan_tinggi').val();
				var id_pegawai = $('#id_pegawai').val();
				var fileInput = document.getElementById('scan_files');
				var uploadButton = document.getElementById('submitForm');
				if(tingkat_pendidikan.trim()==''){
					alert('Tingkat Pendidikan Belum diisi');
					tingkat_pendidikan.focus();
					 return false;
				 }else if(fakultas.trim()==''){
					 alert('Fakultas Belum diisi');
						fakultas.focus();
						 return false;
				 }else if(jurusan.trim()==''){
					 alert('Jurusan Belum diisi');
						jurusan.focus();
						 return false;
				 }else if(nomor_sttb.trim()==''){
					 alert('nomor STTB Belum diisi');
	 					nomor_sttb.focus();
						 return false;

				 }else if(tanggal_sttb.trim()==''){
					 alert('Tanggal STTB Belum diisi');
						tanggal_sttb.focus();
						 return false;
				 }else if(nama_kepsek.trim()==''){
					 alert('Nama Kepala Sekolah Belum diisi');
						nama_kepsek.focus();
						 return false;
				 }else if(nama_sekolah.trim()==''){
					 alert('Nama Sekolah Belum diisi');
						nama_sekolah.focus();
						 return false;
				 }else if(lokasi_sekolah.trim()==''){
					 alert('Lokasi Sekolah Belum diisi');
						lokasi_sekolah.focus();
						 return false;
				 }else if(nama_perguruan_tinggi.trim()==''){
					 alert('Nama Perguruan Tinggi Belum diisi');
						nama_perguruan_tinggi.focus();
						 return false;
				 }else{
					 var files = fileInput.files;
					 // Loop through each of the selected files.
						var file = fileInput.files[0];
						var fileType = fileInput.files[0].type;
						var fileSize = fileInput.files[0].size / 1024 / 1024;
						if(fileType!='application/pdf'){
							alert("file tidak boleh selain PDF");
							fileInput.focus();
							return false;
						}else if(fileSize > 1){
							alert('Ukuran File tidak boleh lebih dari 1 Mb');
							fileInput.focus();
							return false;
						}
					 // If you want to add an extra field for the FormData
						 	data.append("id_pegawai",id_pegawai);
				        data.append("tingkat_pendidikan", tingkat_pendidikan);
							data.append("fakultas", fakultas);
							data.append("jurusan", jurusan);
							data.append("nomor_sttb", nomor_sttb);
							data.append("tanggal_sttb", tanggal_sttb);
							data.append("nama_kepsek", nama_kepsek);
							data.append("nama_sekolah", nama_sekolah);
							data.append("lokasi_sekolah", lokasi_sekolah);
							data.append("nama_perguruan_tinggi", nama_perguruan_tinggi);

							$('#notif-backdrop').addClass('notif-backdrop-peter');

						  // // Check the file type.
						  // if (!file.type.match('image.*')) {
						  //   continue;
						  // }
						  // Add the file to the request.
						  data.append('files', file);
						// disabled the submit button
				        $("#submitForm").prop("disabled", true);
								$("#buttonBatal").prop("disabled", true);

				        $.ajax({
				            type: "POST",
				            enctype: 'multipart/form-data',
				            url: "submit_pendidikan_formal.php",
				            data: data,
				            processData: false,
				            contentType: false,
				            cache: false,
				            timeout: 600000,
				            success: function (data) {
				                console.log("SUCCESS : ", data);
											// alert(data);
											// call notification
											$.notify({
								        title: '<i class="fa fa-check"></i> Informasi',
												content: 'Data Berhasil disimpan & File Berhasil diunggah.'
								      }, {
								        style: 'foo',
								        autoHide: false,
												globalPosition:'bottom right',
												// whether to hide the notification on click
											  clickToHide: false,
											  // whether to auto-hide the notification
											  autoHide: false,
								      });
											setTimeout(changePage,3000);
				            },
				            error: function (e) {
				                // $("#result").text(e.responseText);
				                console.log("ERROR : ", e);
				                $("#btnSubmit").prop("disabled", false);
				            }
				        });
					 }
		    });
			});
			</script>

				<script type="text/javascript">
				function pindah_halaman(id){
					window.location.href="profil_pegawai.php?id="+id;
				}
				$(function(){
					$('#btnClearGambar').on('click',function(){
						var id_pegawai = document.querySelector('#id_pegawai').value;
						var fd = new FormData();
						fd.append("task", "hapus");
						fd.append("id_pegawai", id_pegawai);
							$.ajax({
								type: 'POST',
								url: 'profil_foto_up.php',
								data: fd,
								contentType: false,
								cache: false,
								processData:false,
								success: function(msg){
								 pindah_halaman(id_pegawai);
								}
							});
					});
					var closeBtn = document.querySelector('#closeBtn');
					closeBtn.addEventListener("click",function(){
						var id_barang = document.querySelector('#id_barang').value;
						pindah_halaman(id_barang);
					});
					Dropzone.options.dropzoneForm ={
						paranName : "file",
						maxFilesize : 10,
						maxFiles: 1,
						autoProcessQueue : true,
						acceptedFiles:".png,.jpg,.gif,.bmp,.jpeg",
						init: function(){
							console.log('initialize');
							var submitButton = document.querySelector('#uploadBtn');
							var id_pegawai = document.querySelector('#id_pegawai').value;
							myDropzone = this;
							submitButton.addEventListener("click",function(){
								pindah_halaman(id_pegawai);
							});
							// batasi jumlah upload file
							myDropzone.on("maxfilesexceeded", function(file) {
								alert('Hanya diperbolehkan mengupload satu file gambar');
								this.removeFile(file);
							});
							myDropzone.on("error",function(file,message){
								alert(message);
								var _this = this;
								this.removeFile(file);
							});
							myDropzone.on("addedfile", function(file,formData) {
								// Create the remove button
				        var removeButton = Dropzone.createElement("<button style='cursor:pointer;' class='btn btn-sm btn-warning'><i class='fa fa-trash'></i> Remove file</button>");
				        // Capture the Dropzone instance as closure.
				        var _this = this;
				        // Listen to the click event
				        removeButton.addEventListener("click", function(e) {
				          // Make sure the button click doesn't submit the form:
				          e.preventDefault();
				          e.stopPropagation();
				          // Remove the file preview.
				          _this.removeFile(file);
				          // If you want to the delete the file on the server as well,
				          // you can do the AJAX request here.
									var fd = new FormData();
									fd.append("task", "hapus");
									fd.append("id_pegawai", id_pegawai);
									fd.append("file", file);
										$.ajax({
											type: 'POST',
											url: 'profil_foto_up.php',
											data: fd,
											contentType: false,
											cache: false,
											processData:false,
											success: function(msg){
											 alert(msg);
											}
										});
				        });

				        // Add the button to the file preview element.
				        file.previewElement.appendChild(removeButton);
							});
							myDropzone.on("sending", function(file, xhr, formData) {
								// Will send the filesize along with the file as POST data.
								formData.append("task", "tambah");
								formData.append("id_pegawai", id_pegawai);
								formData.append("file", file);
									$.ajax({
										type: 'POST',
										url: 'profil_foto_up.php',
										data: formData,
										contentType: false,
										cache: false,
										processData:false,
										success: function(msg){
										 alert(msg);
										}
									});
							});

							myDropzone.on("success", function(file,responseText){
								// Handle the responseText here. For example, add the text to the preview element:
					      // file.previewTemplate.appendChild(document.createTextNode(responseText));
							});
						}
					}
				});
			</script>
			<script type="text/javascript">
	     $(document).ready(function(){
	       //add a new style 'foo'
				 $.notify.addStyle('foo', {
		        html:
		          "<div>" +
		            "<div class='clearfix'>" +
		            "<div class='notif'>" +
		              "<div class='title' data-notify-html='title'/>" +
								"<div class='subTitle' data-notify-html='content'/>" +
		            "</div>" +
		            "<div class='buttons'>" +
								"<button class='close'><span aria-hidden=\"true\">&times;</span></button>"+
		            "</div>" +
		            "</div>" +
		          "</div>"
		      });

	      //listen for click events from this style
	      $(document).on('click', '.notifyjs-foo-base .close', function() {
	        //programmatically trigger propogating hide event
	        $(this).trigger('notify-hide');
					window.location = window.location.href;
	      });
	      // $(document).on('click', '.notifyjs-foo-base .yes', function() {
	      //   //show button text
	      //   alert($(this).text() + " clicked!");
	      //   //hide notification
	      //   $(this).trigger('notify-hide');
	      // });

	      // call notification
	      // $.notify({
	      //   title: '<i class="fa fa-check"></i> Informasi',
				// 	content: 'Data Berhasil disimpan & File Berhasil diunggah.'
	      // }, {
	      //   style: 'foo',
	      //   autoHide: false,
				// 	globalPosition:'bottom right',
				// 	// whether to hide the notification on click
				//   clickToHide: false,
				//   // whether to auto-hide the notification
				//   autoHide: false,
				//   // if autoHide, hide after milliseconds
				//   autoHideDelay: 5000,
	      // });
	     });
	    </script>
		<script type="text/javascript">
	  $(function () {
	    $("#pendidikanFormal1").dataTable();
				$("#pendidikanNonFormal1").dataTable();
				$("#riwayatSuamiIstri1").dataTable();
				$("#riwayatAnak1").dataTable();
				$("#example1").dataTable();
	    $('#example2').dataTable({
	      "bPaginate": true,
	      "bLengthChange": false,
	      "bFilter": false,
	      "bSort": true,
	      "bInfo": true,
	      "bAutoWidth": false
	    });
	  });
	</script>
	<script type="text/javascript">

	  //Flat red color scheme for iCheck
	  // $('input[type="radio"].flat-blue').iCheck({
	  //   radioClass: 'iradio_flat-blue'
	  // });
	  //Date range picker
	  $('#tanggaldaftar').datepicker({
	    format: 'dd/mm/yyyy',
		todayHighlight: true,
		autoclose: true
	  });
	  //Date range picker
	  $('#tanggalb').datepicker({
	    format: 'dd/mm/yyyy',
		todayHighlight: true,
		autoclose: true
	  });
	</script>
	<script type="text/javascript">
	    function deleteconfig(){
	    var tujuan=$(this).attr('id');
	    var hapusin=confirm("Apakah Anda yakin ingin menghapus data ini?");
	    if(hapusin==true){
	        window.location.href=tujuan;
	        }
	        else{
	        alert("Data Batal dihapus");
	        }
	        return hapusin;
	        }
	</script>
	<script type="text/javascript">
	  function hapusForm() {
	    document.getElementById("formInput").reset();
	  }
	</script>
	<script type="text/javascript">
	  Dropzone.options.myDropzone= {
	    url: 'upload.php',
	    autoProcessQueue: true,
	    uploadMultiple: false,
	    parallelUploads: 5,
	    maxFiles: 1,
	    maxFilesize: 1,
	    acceptedFiles: '.pdf',
	    addRemoveLinks: true,
	    init: function() {
	    dzClosure = this; // Makes sure that 'this' is understood inside the functions below.

	    // for Dropzone to process the queue (instead of default form behavior):
	    document.getElementById("submit-all").addEventListener("click", function(e) {
	        // Make sure that the form isn't actually being sent.
	        e.preventDefault();
	        e.stopPropagation();
	        dzClosure.processQueue();
	    });

	    //send all the form data along with the files:
	    this.on("sendingmultiple", function(data, xhr, formData) {
	        formData.append("firstname", jQuery("#firstname").val());
	        formData.append("lastname", jQuery("#lastname").val());
	    });
	}
	}
	</script>
	<script type="text/javascript">
		function cekCuti(){
			var tgl1 = document.getElementById('tgl_mulai_cuti');
			var tgl2 = document.getElementById('tgl_selesai_cuti');
			tgl_mulai = new Date(tgl1.value);
			tgl_selesai = new Date(tgl2.value);
			var tujuan=$(this).attr('id');
			if(tgl_mulai >= tgl_selesai){
				alert("Lama Cuti Minimal 1 Hari");
			}else{
				window.location.href=tujuan;
			}
		}
	</script> 
	</body>
	</html>
