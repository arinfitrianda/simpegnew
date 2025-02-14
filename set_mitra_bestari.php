<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
$parts= $tipes[2];
if ($tipes[0]!='Simpeg')
{
  unset($_SESSION['tipe']);
  unset($_SESSION['namauser']);
  unset($_SESSION['password']);
  header("location:../index.php?status=2");
  exit;
}
include "../inc/anggota_check.php";
$queryPegawai = $db->query("SELECT * FROM pegawai ");
$data = $queryPegawai->fetchAll(PDO::FETCH_ASSOC);
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
     <!-- Select2 -->
     <link href="../plugins/select2/select2.min.css" rel="stylesheet">

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
            PENGATURAN MITRA BESTARI
            <small>Set Mitra Bestari</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pengaturan Mitra Bestari</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
        <!-- left column -->
        <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Form Setting Mitra Bestari</h3>
            </div><!-- /.box-header -->
            <form action="proses_set_mitra_bestari.php" method="POST">
            <div class="box-body">
              <div class="alert alert-info">
                <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
              </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="id_pegawai">Nama Pegawai<span style="color:red">*</span></label>
                      <select class="form-control select2" name="id_pegawai" required>
                        <option value="">Pilih Pegawai</option>
                        <?php
                        foreach ($data as $pegawai) {
                            echo "<option value='".$pegawai['id_pegawai']."'>".$pegawai['nama']."</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="nama_mitra_bestari">Nama Mitra Bestari<span style="color:red">*</span></label>
                      <select class="form-control select2" name="nama_mitra_bestari" required>
                        <option value="">Pilih Mitra Bestari</option>
                        <?php
                        foreach ($data as $pegawai) {
                            echo "<option value='".$pegawai['nama']."'>".$pegawai['nama']."</option>";
                          }
                        ?>
                      </select>
                    </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="master.php" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
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
    <!-- Select2 -->
    <script src="../plugins/select2/select2.full.min.js"></script>
    <!-- function provinsi,kecamatan, dll -->
    <script src="ajax_daerah.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      $(".select2").select2();
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
