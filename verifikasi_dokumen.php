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

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->bindParam(":id_kredensial",$id_kredensial);
$status_kredensial->execute();
$status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);

$verifikasi_bukti = $db->prepare("SELECT * FROM verifikasi_bukti WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$verifikasi_bukti->bindParam(":id",$id_pegawai);
$verifikasi_bukti->bindParam(":id_kredensial",$id_kredensial);
$verifikasi_bukti->execute();
$verif =  $verifikasi_bukti->fetch(PDO::FETCH_ASSOC);

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
            VERIFIKASI BUKTI PELENGKAP KREDENSIAL
            <!-- <small>Set Mitra Bestari</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Verifikasi Bukti Pelengkap Kredensial</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
        <!-- left column -->
        <div class="box">
            <div class="box-header">
              <!-- <i class="fa fa-user"></i> -->
              <?php
              if($status["verifikasi_bukti"] == 1){
                echo "<h3 class='box-title'>Verifikasi Bukti Pelengkap Kredensial</h3><i style='color:green' class='fa fa-check'></i> <small> Terverifikasi : ".$status['tgl_verifikasi_bukti']."</small>";
              }else{
                echo "<i class='fa fa-user'></i><h3 class='box-title'>Verifikasi Bukti Pelengkap Kredensial</h3>";
              }?>
            </div><!-- /.box-header -->
            <?php
            if($status["verifikasi_bukti"] == "0"){?>
            <form class="" action="proses_verifikasi_dokumen.php" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
              <input type="hidden" name="id_kredensial" value="<?php echo $id_kredensial; ?>">
            <div class="box-body">
              <div class="alert alert-info">
                <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
              </div>
                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>No</th>
                        <th>Bukti Pendukung</th>
                        <th colspan="2">Kelengkapan Bukti</th>
                      </tr>
                    </thead>
                    <tbody>
                      <form action="proses_verifikasi_dokumen.php" method="POST">
                      <tr>
                        <th>1</th>
                        <th>STR / SIP / SIB / SIK</th>
                        <th>
                          <label><input type="radio" id="ada" name="str" value="ada"><label for="str">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="str" value="tidak_ada"><label for="str">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>2</th>
                        <th>Ijazah</th>
                        <th>
                          <label><input type="radio" id="ada" name="ijazah" value="ada"><label for="ijazah">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="ijazah" value="tidak_ada"><label for="ijazah">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>3</th>
                        <th>Transkrip Nilai</th>
                        <th>
                          <label><input type="radio" id="ada" name="transkrip" value="ada"><label for="transkrip">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="transkrip" value="tidak_ada"><label for="transkrip">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>4</th>
                        <th>Sertifikat Pelatihan / Seminar</th>
                        <th>
                          <label><input type="radio" id="ada" name="sertif_pelatihan" value="ada"><label for="sertif_pelatihan">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="sertif_pelatihan" value="tidak_ada"><label for="sertif_pelatihan">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>5</th>
                        <th>Training Record</th>
                        <th>
                          <label><input type="radio" id="ada" name="training_record" value="ada"><label for="training_record">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="training_record" value="tidak_ada"><label for="training_record">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>6</th>
                        <th>Log Book</th>
                        <th>
                          <label><input type="radio" id="ada" name="log_book" value="ada"><label for="log_book">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="log_book" value="tidak_ada"><label for="log_book">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>7</th>
                        <th>Clinical Privilege</th>
                        <th>
                          <label><input type="radio" id="ada" name="clinical_privilege" value="ada"><label for="clinical_privilege">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="clinical_privilege" value="tidak_ada"><label for="clinical_privilege">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>8</th>
                        <th>SPKK Sebelumnya</th>
                        <th>
                          <label><input type="radio" id="ada" name="spkk_sebelumnya" value="ada"><label for="spkk_sebelumnya">Ada</label>
                        </th>
                        <th><label><input type="radio" id="tidak_ada" name="spkk_sebelumnya" value="tidak_ada"><label for="spkk_sebelumnya">Tidak Ada</label>
                      </tr>
                    </tbody>
                  </table>
                </div>
              <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="peserta_kredensial.php ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
            </div>
            </form>
            <?php
          }else{?>
            <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>No</th>
                        <th>Bukti Pendukung</th>
                        <th colspan="2">Kelengkapan Bukti</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <th>1</th>
                        <th>STR / SIP / SIB / SIK</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="str" value="ada" <?php if($verif['str'] == 'ada'){ echo"checked"; }?> ><label for="str">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="str" value="tidak_ada" <?php if($verif['str'] == 'tidak_ada'){ echo"checked"; }?> ><label for="str">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>2</th>
                        <th>Ijazah</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="ijazah" value="ada" <?php if($verif['ijazah'] == 'ada'){ echo"checked"; }?> ><label for="ijazah">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="ijazah" value="tidak_ada" <?php if($verif['ijazah'] == 'tidak_ada'){ echo"checked"; }?> ><label for="ijazah">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>3</th>
                        <th>Transkrip Nilai</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="transkrip" value="ada" <?php if($verif['transkrip'] == 'ada'){ echo"checked"; }?> ><label for="transkrip">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="transkrip" value="tidak_ada" <?php if($verif['transkrip'] == 'tidak_ada'){ echo"checked"; }?> ><label for="transkrip">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>4</th>
                        <th>Sertifikat Pelatihan / Seminar</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="sertif_pelatihan" value="ada" <?php if($verif['sertif_pelatihan'] == 'ada'){ echo"checked"; }?> ><label for="sertif_pelatihan">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="sertif_pelatihan" value="tidak_ada" <?php if($verif['sertif_pelatihan'] == 'tidak_ada'){ echo"checked"; }?> ><label for="sertif_pelatihan">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>5</th>
                        <th>Training Record</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="training_record" value="ada" <?php if($verif['training_record'] == 'ada'){ echo"checked"; }?> ><label for="training_record">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="training_record" value="tidak_ada" <?php if($verif['str'] == 'tidak_ada'){ echo"checked"; }?> ><label for="training_record">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>6</th>
                        <th>Log Book</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="log_book" value="ada" <?php if($verif['log_book'] == 'ada'){ echo"checked"; }?> ><label for="log_book">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="log_book" value="tidak_ada" <?php if($verif['log_book'] == 'tidak_ada'){ echo"checked"; }?> ><label for="log_book">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>7</th>
                        <th>Clinical Privilege</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="clinical_privilege" value="ada" <?php if($verif['clinical_privilege'] == 'ada'){ echo"checked"; }?> ><label for="clinical_privilege">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="clinical_privilege" value="tidak_ada" <?php if($verif['clinical_privilege'] == 'tidak_ada'){ echo"checked"; }?> ><label for="clinical_privilege">Tidak Ada</label>
                      </tr>
                      <tr>
                        <th>8</th>
                        <th>SPKK Sebelumnya</th>
                        <th>
                          <label><input type="checkbox" id="ada" name="spkk_sebelumnya" value="ada" <?php if($verif['spkk_sebelumnya'] == 'ada'){ echo"checked"; }?> ><label for="spkk_sebelumnya">Ada</label>
                        </th>
                        <th><label><input type="checkbox" id="tidak_ada" name="spkk_sebelumnya" value="tidak_ada" <?php if($verif['spkk_sebelumnya'] == 'tidak_ada'){ echo"checked"; }?> ><label for="spkk_sebelumnya">Tidak Ada</label>
                      </tr>
                    </tbody>
                  </table>
                  <div class="box-footer">
                    <a href="jadwal_kredensial.php?id_pegawai=<?php echo$id_pegawai?>&id_kredensial=<?php echo $id_kredensial ?>" class="btn bg-navy"></i>Jadwal Kredensial</a>
                  </div>
                </div>
          <?php  
        }?>
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
