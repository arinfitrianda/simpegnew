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
$nama_mitra_bestari = isset($_GET['nama_mitra_bestari']) ? $_GET['nama_mitra_bestari'] : '';
$profesi = isset($_GET['nama_profesi']) ? $_GET['nama_profesi'] : '';

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->bindParam(":id_kredensial",$id_kredensial);
$status_kredensial->execute();
$status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);

$master = $db->prepare("SELECT * FROM `kredensial` kr INNER JOIN pegawai_profil pg ON kr.id_pegawai= pg.id_peg INNER JOIN pegawai peg ON(peg.id_pegawai=pg.id_peg)  WHERE kr.id_pegawai=:id AND kr.id_kredensial=:id_kredensial");
$master->bindParam(":id",$id_pegawai);
$master->bindParam(":id_kredensial",$id_kredensial);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);

function tgl_indo($tanggal){
  $bulan = array (
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );
  $pecahkan = explode('-', $tanggal);
  
  // variabel pecahkan 0 = tanggal
  // variabel pecahkan 1 = bulan
  // variabel pecahkan 2 = tahun
 
  return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
}
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
            PENGATURAN NOMOR SURAT PERMOHONAN KREDENSIAL
            <small>Pengaturan Nomor Surat Permohonan Kredensial</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pengaturan Nomor Surat Permohonan Kredensial</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
        <!-- left column -->
        <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Pengaturan Nomor Surat Permohonan Kredensial</h3>
            </div><!-- /.box-header -->
            <form action="proses_surat_permohonan.php" method="POST">
            <div class="box-body">
              <div class="alert alert-info">
                <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
              </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="hidden" name="nama_mitra_bestari" value="<?php echo $nama_mitra_bestari; ?>">
                      <input type="hidden" name="profesi" value="<?php echo $profesi; ?>">
                    <div class="form-group">
                      <label for="no_permohonan">Nomor Surat Permohonan Kredensial<span style="color:red">*</span></label>
                       <input type="text" class="form-control" id="no_surat_permohonan" name="no_surat_permohonan" placeholder="Masukan Nomor Surat Permohonan Kredensial" required>
                    </div>
                    <div class="form-group">
                      <label for="tgl_surat">Tanggal Surat Permohonan Kredensial<span style="color:red">*</span></label>
                       <input type="date" class="form-control" id="tgl_surat_permohonan" name="tgl_surat_permohonan" required>
                    </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
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
