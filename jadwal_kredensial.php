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
$id_pegawai = isset($_GET['id_pegawai']) ? $_GET['id_pegawai'] : '';
$id_kredensial = isset($_GET['id_kredensial']) ? $_GET['id_kredensial'] : '';

$queryPegawai = $db->query("SELECT * FROM pegawai ");
$data = $queryPegawai->fetchAll(PDO::FETCH_ASSOC);

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->bindParam(":id_kredensial",$id_kredensial);
$status_kredensial->execute();
$status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);

$master = $db->prepare("SELECT pg.nama as nama_mitra, kr.nama_mitra_bestari, pf.nama_profesi, pg_prof.nama_lengkap, kr.id_pegawai, pg_prof.nama_lengkap, kr.id_kredensial, pg.nip, pg.nama, kr.tgl_kredensial, kr.tempat_kredensial FROM status_kredensial as sk INNER JOIN kredensial as kr ON(sk.id_kredensial=kr.id_kredensial) INNER JOIN pegawai as pg ON kr.nama_mitra_bestari = pg.id_pegawai INNER JOIN pegawai_profil as pg_prof ON kr.id_pegawai = pg_prof.id_peg INNER JOIN profesi pf ON (pg_prof.nama_profesi = pf.id_profesi) WHERE kr.id_pegawai=:id AND kr.id_kredensial=:id_kredensial");
$master->bindParam(":id",$id_pegawai);
$master->bindParam(":id_kredensial",$id_kredensial);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);
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
            PERSETUJUAN ASESMEN
            <small>Persetujuan Asesmen</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Persetujuan Asesmen</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
              <!-- general form elements -->
        <!-- left column -->
        <?php
        if($status["set_tempat"] == 1){?>
          <div class="box">
            <div class="box-header">
              <!-- <i class="fa fa-user"></i> -->
              <h3 class="box-title">Jadwal Kredensial</h3><i style='color:green' class='fa fa-check'></i>
            </div><!-- /.box-header -->
              <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <dl class="dl-horizontal">
                          <dt>Nomor Induk Pegawai</dt>
                          <dd><?php echo $m['nip']; ?></dd>
                          <dt>Nama Pegawai</dt>
                          <dd><?php echo $m['nama_lengkap']; ?></dd>
                          <dt>Profesi</dt>
                          <dd><?php echo $m['nama_profesi']; ?></dd>
                          </dl>
                        <dl class="dl-horizontal">
                          <dt>Jadwal Kredensial</dt>
                          <dd><?php echo($m['tgl_kredensial']); ?></dd>
                          <dt>Tempat Kredensial</dt>
                          <dd><?php echo $m['tempat_kredensial']; ?></dd>
                        </dl>
                      </div>
                    </div>
              </div>
              <form action="cetak_jadwal.php" method="POST" target="_blank">
                  <input type="hidden" name="nama_mitra_bestari" value="<?php echo $m["nama_mitra"]?>">
                  <input type="hidden" name="nama" value="<?php echo $m["nama_lengkap"] ?>">
                  <input type="hidden" name="tgl_kredensial" value="<?php echo $m["tgl_kredensial"]?>">
                  <input type="hidden" name="tempat_kredensial" value="<?php echo $m["tempat_kredensial"] ?>">
              <div class="box-footer">
                  <input type="submit" value="Cetak Formulir Kredensial" class="btn btn-primary"></form>
                  <a href="asesmen_kredensial.php?id_pegawai=<?php echo $id_pegawai?>&id_kredensial=<?php echo $id_kredensial ?>" class="btn bg-navy pull-right"></i>Asesmen Kegiatan</a>
                  <!-- <a href="peserta_kredensial.php" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a> -->
              </div>
        </div><!-- /.left column -->
        <?php }else{?>
        <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Form Persetujuan Asesmen</h3>
            </div><!-- /.box-header -->
                <form class="" action="proses_set_jadwal_kredensial.php" method="post">
              <div class="box-body">
                <div class="alert alert-info">
                  <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
                </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                        <input type="hidden" name="id_kredensial" value="<?php echo $id_kredensial; ?>">
                        <label for="waktu_kredensial">Waktu Kredensial<span style="color:red">*</span></label>
                        <input type="datetime-local" class="form-control" id="waktu_kredensial" name="waktu_kredensial" required>
                      </div>
                      <div class="form-group">
                        <label for="tempat_kredensial">Tempat Kredensial<span style="color:red">*</span></label>
                        <input type="text" class="form-control" id="tempat_kredensial" name="tempat_kredensial" placeholder="Masukan Tempat Pelaksanaan Kredensial" required>
                      </div>
                    </div>
              </div>
              <div class="box-footer">
                  <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                  <a href="peserta_kredensial.php" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
              </div>
              </form>
        </div><!-- /.left column -->
        <?php
        }
        ?>
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
    <script type="text/javascript">
      function changeDate($tanggal){
        $tgl_baru = date('d/m/y H:i:s',strtotime($tanggal));
        return $tgl_baru; 
    }
    </script>

  </body>
</html>
