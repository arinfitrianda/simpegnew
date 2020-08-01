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
$id_pegawai=isset($_GET["id_pegawai"]) ? $_GET['id_pegawai'] : '';
$id_sip = isset($_GET['id_sip']) ? $_GET['id_sip'] : '';

$getData = $db->prepare("SELECT * FROM riwayat_sip WHERE id_sip=:id_sip AND id_pegawai=:id_pegawai");
$getData->bindParam(":id_pegawai",$id_pegawai);
$getData->bindParam(":id_sip",$id_sip);
$getData->execute();
$data = $getData->fetch(PDO::FETCH_ASSOC);
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

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
            DATA SURAT IZIN PRAKTEK
            <small>Form Edit Data Surat Izin Praktek</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Form Edit Data Surat Izin Praktek</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
			  <!-- left column -->
			  <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
    				  <h3 class="box-title">Form Edit Data Surat Izin Praktek</h3>
            </div><!-- /.box-header -->
            <form class="" action="proses_edit_sip.php" enctype="multipart/form-data" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
              <input type="hidden" name="id_sip" value="<?php echo $id_sip; ?>">
            <div class="box-body">
							<div class="alert alert-info">
							  <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
							</div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="no_sip">Nomor Surat Izin Praktek<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="no_sip" name="no_sip" value="<?php echo $data["no_sip"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="tgl_terbit_sip">Tanggal Terbit Surat Izin Praktek<span style="color:red">*</span></label>
                      <input type="date" class="form-control" id="tgl_terbit_sip" name="tgl_terbit_sip" value="<?php echo $data["tgl_terbit_sip"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="tgl_kadaluarsa_sip">Tanggal Terbit Surat Izin Praktek<span style="color:red">*</span></label>
                      <input type="date" class="form-control" id="tgl_kadaluarsa_sip" name="tgl_kadaluarsa_sip" value="<?php echo $data["tgl_kadaluarsa_sip"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="pejabat_ttd">Jabatan Penandatanganan STR<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="pejabat_ttd" name="pejabat_ttd" value="<?php echo $data["pejabat_ttd"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="keterangan">Keterangan<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="keterangan" name="keterangan" value="<?php echo $data["keterangan"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nama_pt">Dokumen Terupload</label><br>
                      <a target='_blank' href="<?php echo $data['url_doc']."/".$data['nama_doc']?>"><?php echo $data['nama_doc']?></a>
                    </div>
                    <div class="form-group">
                      <label for="scan_files">Dokumen</label><br>
                      <input type="file" class="form-control" id="scan_files" name="scan_files">
                      <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
                    </div>
                  </div>
                </div>
            </div>
                 
            <div class="box-footer">
                <input type="submit" name="submit" value="Simpan" class="btn btn-success">
								<a href="profil_pegawai.php?id=<?php echo $id_pegawai ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
            </div>
            </form>
			  </div><!-- /.left column -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- static footer -->
	  <?php include("footer.php");?><!-- /.static footer -->
    </div><!-- ./wrapper -->
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
	<!-- typeahead -->
    <script src="../plugins/typeahead/typeahead.bundle.js" type="text/javascript"></script>
	<!-- iCheck 1.0.1 -->
    <script src="../plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
    <!-- function provinsi,kecamatan, dll -->
    <script src="ajax_daerah.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      //Flat red color scheme for iCheck
      $('input[type="radio"].flat-blue').iCheck({
        radioClass: 'iradio_flat-blue'
      });
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

  </body>
</html>
