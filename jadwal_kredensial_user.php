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
$id_pegawai = isset($_GET['id']) ? $_GET['id'] : '';
// $id_kredensial = isset($_GET['id_kredensial']) ? $_GET['id_kredensial'] : '';
// echo " ini tanfffffff $id_pegawai";
$master = $db->prepare("SELECT * FROM `kredensial` kr INNER JOIN pegawai_profil pg ON kr.id_pegawai= pg.id_peg INNER JOIN pegawai peg ON(peg.id_pegawai=pg.id_peg) INNER JOIN departemen dp ON(pg.nama_profesi=dp.id_dept)  WHERE kr.id_pegawai=:id");
$master->bindParam(":id",$id_pegawai);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);
// print_r($m);
// $id_kredensial = $m["id_kredensial"];
// if (is_null($m["id_kredensial"])){
//   $id_kredensial = 0;
// }else{
//   $id_kredensial = $m["id_kredensial"];
// }

// echo count($m);
if(empty($m)){
  $id_kredensial = 0;
}else{
  $id_kredensial = $m["id_kredensial"];
  $queryPegawai = $db->query("SELECT * FROM pegawai ");
  $data = $queryPegawai->fetchAll(PDO::FETCH_ASSOC);

  $status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
  $status_kredensial->bindParam(":id",$id_pegawai);
  $status_kredensial->bindParam(":id_kredensial",$id_kredensial);
  $status_kredensial->execute();
  $status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);
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
            JADWAL KREDENSIAL
            <small>Jadwal Kredensial</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Jadwal Kredensial</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <?php
          if(empty($m)){?>
            <div class="box">
              <div class="box-header">
                <i class="fa fa-user"></i>
                <h3 class="box-title">Jadwal Kredensial</h3>
              </div><!-- /.box-header -->
                <div class="box-body">
                  <div class="alert alert-info">
                    <strong>Info!</strong>Kredensial Belum Diajukan
                  </div>
              </div><!-- /.left column -->
          <?php
          }else{
            if($status["set_tempat"] == 1){?>
          <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Jadwal Kredensial</h3>
            </div><!-- /.box-header -->
                <form class="" action="proses_set_jadwal_kredensial.php" method="post">
              <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <dl class="dl-horizontal">
                          <dt>Nomor Induk Pegawai</dt>
                          <dd><?php echo $m['nip']; ?></dd>
                          <dt>Nama Pegawai</dt>
                          <dd><?php echo $m['nama']; ?></dd>
                          <dt>Profesi</dt>
                          <dd><?php echo $m['nama_dept']; ?></dd>
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
              </form>
        </div><!-- /.left column -->
        <?php }else{?>
        <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Jadwal Kredensial</h3>
            </div><!-- /.box-header -->
              <div class="box-body">
                <div class="alert alert-info">
                  <strong>Info!</strong>Jadwal Kredensial Belum Ada 
                </div>
            </div><!-- /.left column -->
        <?php
          }
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
