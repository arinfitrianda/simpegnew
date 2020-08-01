<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
$parts = $tipes[2];
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
  </head>
  <body class="skin-black fixed">
    <div class="wrapper">
      <?php 
      include "header.php";
      include "menu_index.php"; ?>
      <div class="content-wrapper">

        <?php 
        if (isset($_GET['status']) && ($_GET['status'] == "1")) { ?><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center><h4><i class="icon fa fa-check"></i>Berhasil</h4>Jawaban Berhasil Disimpan!!</center></div>
        <?php }

        else if (isset($_GET['status']) && ($_GET['status'] == "2")) { ?><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center><h4><i class="icon fa fa-check"></i>Berhasil</h4>Jawaban Berhasil Diupdate!!</center></div>
        <?php }
        ?>
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Data Kompetensi
            <small>Form Kompetensi</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Form Kompetensi</li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
              <h3 class="box-title">Form Kompetensi</h3>
            </div>
            <div class="box-body">
              <form action="update_jawaban.php" method="post">
                <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kompetensi</th>
                      <th>Diminta</th>
                      <th colspan="2">Disetujui</th>
                      <th colspan="2">Ditolak</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        include("../inc/pdo.conf.php");
                        $queryKompetensi  = $db->query("SELECT *, jawaban_kompetensi.* FROM asesmen_kompetensi JOIN jawaban_kompetensi ON asesmen_kompetensi.`id_kompetensi` = jawaban_kompetensi.`id_kompetensi` ");
                        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
                        $no=1;
                        $nomor=1;
                        foreach ($dataKompetensi as $dk){
                          ?>
                          <input type="hidden" name="id_kompetensi[]" value="<?php echo $dk['id_kompetensi'] ?>">
                          <input type="hidden" name="id_profesi" value="<?php echo $dk['id_profesi'] ?>">
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $dk['sub_soal'] ?></td>
                            <td></td>
                            <td>
                              <input type="radio" id="m1" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'm'){ echo"checked"; } ?> required value="m"><span for="spkk"> Mahir</span>
                            </td>
                            <td>
                              <input type="radio" id="ds2" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ds'){ echo"checked"; } ?> required value="ds"><span for="spkk"> Dibawah Supervisi</span>
                            </td>
                            <td>
                              <input type="radio" id="ta3" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ta'){ echo"checked"; } ?> required value="ta"><span for="spkk"> Tak Ada Alat</span>
                            </td>
                            <td>
                              <input type="radio" id="tk4" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'tk'){ echo"checked"; } ?> required value="tk"><span for="spkk"> Tak Ada Kompetensi</span>
                            </td>
                            <td></td>
                          </tr>
                          <?php
                          $nomor++;
                        }
                      ?>
                  </tbody> 
                </table>
                <button class="btn btn-primary">UPDATE</button>
              </form>
            </div>
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
  </body>
</html>
