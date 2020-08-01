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

$queryKompetensi  = $db->query("SELECT * FROM asesmen_kompetensi");
$dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->bindParam(":id_kredensial",$id_kredensial);
$status_kredensial->execute();
$data =  $status_kredensial->fetch(PDO::FETCH_ASSOC); 
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

      <!-- static header -->
    <?php 
    include "header.php";
    include "menu_index.php";

    ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            LAPORAN STATUS KREDENSIAL
            <!-- <small>Set Mitra Bestari</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Laporan Status Kredensial</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
        <!-- left column -->
        <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Laporan Status Kredensial</h3>
            </div><!-- /.box-header -->
            <form class="" action="proses_verifikasi_dokumen.php" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
              <input type="hidden" name="id_anak" value="<?php echo $id_anak; ?>">
            <div class="box-body">
              <!-- <div class="alert alert-info">
                <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
              </div> -->
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead class="bg-blue">
                      <tr>
                        <th>No</th>
                        <th>Tahap Kredensial</th>
                        <!-- <th>Waktu Mulai Tahapan</th> -->
                        <th>Waktu Selesai Tahapan</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                      <tbody>
                      <tr>
                        <th>1</th>
                        <th>Pengajuan Permohonan Kredensial</th>
                        <?php
                          if($data["pengajuan"] == 1){?>
                            <th><?php echo ($data["tgl_pengajuan"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>2</th>
                        <th>Verifikasi Bukti Pendukung Kredensial</th>
                        <?php
                          if($data["verifikasi_bukti"] == 1){?>
                            <th><?php echo ($data["tgl_verifikasi_bukti"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>3</th>
                        <th>Formulir Persetujuan Asesmen dan Kerahasiaan</th>
                        <?php
                          if($data["set_tempat"] == 1){?>
                            <th><?php echo ($data["tgl_set_tempat"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>4</th>
                        <th>Asesmen Kompetensi Profesi</th>
                        <?php
                          if($data["asesmen_kompetensi"] == 1){?>
                            <th><?php echo ($data["tgl_asesmen_kompetensi"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>5</th>
                        <th>Laporan Hasil Asesmen Kompetensi Profesi</th>
                        <?php
                          if($data["laporan_asesmen"] == 1){?>
                            <th><?php echo ($data["tgl_laporan_asesmen"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>6</th>
                        <th>Set Tanggal Re-Kredensial</th>
                        <?php
                          if($data["laporan_asesmen"] == 1){?>
                            <th><?php echo ($data["tgl_laporan_asesmen"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>7</th>
                        <th>Surat Laporan Hasil Asesmen</th>
                        <?php
                          if($data["surat_laporan_asesmen"] == 1){?>
                            <th><?php echo ($data["tgl_surat_laporan_asesmen"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>8</th>
                        <th>Input Nomer SK Kewenangan Klinis</th>
                        <?php
                          if($data["input_no_sk"] == 1){?>
                            <th><?php echo ($data["tgl_input_no_sk"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                      <tr>
                        <th>9</th>
                        <th>Penerbitan Kewenangan Klinis</th>
                        <?php
                          if($data["penerbitan_rkk"] == 1){?>
                            <th><?php echo ($data["tgl_tgl_penerbitan_rkk"]); ?></th>
                            <th>Tahapan Selesai</th>
                        <?php
                          }else{?>
                            <th>-</th>
                            <th>Tahapan Belum Selesai</th>
                        <?php  
                          }
                        ?>
                      </tr>
                    </tbody> 
                  </table>
                </div>
              <!-- <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="peserta_kredensial.php ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
            </div> -->
            </form>
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

    function tgl_hyung($tanggal){
      $tanggal = date('d/m/y H:i:s',strtotime($tanggal));
      return $tanggal; 
    }
    </script>
  </body>
</html>
