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
$queryPegawai = $db->query("SELECT * FROM pegawai");
$data = $queryPegawai->fetchAll(PDO::FETCH_ASSOC);

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->bindParam(":id_kredensial",$id_kredensial);
$status_kredensial->execute();
$status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);

$master = $db->prepare("SELECT * FROM `kredensial` kr INNER JOIN pegawai_profil pg ON kr.id_pegawai= pg.id_peg INNER JOIN pegawai peg ON(peg.id_pegawai=pg.id_peg) INNER JOIN profesi as pr ON(pg.nama_profesi = pr.id_profesi) WHERE kr.id_pegawai=:id AND kr.id_kredensial=:id_kredensial");
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
    include 'header.php';
    include "menu_index.php"; ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            LAPORAN HASIL ASESMEN
            <small>Laporan Hasil Asesmen</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Laporan Hasil Asesmen</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
        <!-- left column -->
        <div class="box">
            <div class="box-header">
              <!-- <i class="fa fa-user"></i> -->
              <!-- <h3 class="box-title">Laporan Hasil Asesmen</h3> -->
              <?php
              if($status["laporan_asesmen"] == 1){
                echo "<h3 class='box-title'>Laporan Hasil Asesmen</h3><i style='color:green' class='fa fa-check'></i>";
              }else{
                echo "<i class='fa fa-user'></i><h3 class='box-title'>Laporan Hasil Asesmen</h3>";
              }?>
            </div><!-- /.box-header -->
            <?php
            if($status["laporan_asesmen"] == 0){?>
              <div class="box-body">
              <div class="row">
                <div class="col-md-12">
                  <div class="form-group">
                    <dl>
                      <dt>Nomor Induk Pegawai</dt>
                      <dd><?php echo $m['nip']; ?></dd>
                      <dt>Nama Pegawai</dt>
                      <dd><?php echo $m['nama']; ?></dd>
                      <dt>Profesi</dt>
                      <dd><?php echo $m['nama_profesi']; ?></dd>
                    </dl>
                  </div>
              <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kompetensi</th>
                      <th colspan="2">Disetujui</th>
                      <th colspan="2">Ditolak</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        $queryKompetensi  = $db->prepare("SELECT * FROM `jawaban_kompetensi` WHERE id_kredensial=:id_kredensial AND id_pegawai =:id_pegawai");
                        $queryKompetensi->bindParam(":id_kredensial", $id_kredensial);
                        $queryKompetensi->bindParam(":id_pegawai", $id_pegawai);
                        $queryKompetensi->execute();
                        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
                        $no=1;
                        $nomor=1;
                        foreach ($dataKompetensi as $dk){
                          ?>
                          <input type="hidden" name="id_kompetensi[]" value="<?php echo $dk['id_kompetensi'] ?>">
                          <input type="hidden" name="id_profesi" value="<?php echo $dk['id_profesi'] ?>">
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $dk['soal'] ?></td>
                            <td>
                              <input type="checkbox" id="m1" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'm'){ echo"checked"; } ?> required value="m"><span for="spkk"> Mahir</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ds2" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ds'){ echo"checked"; } ?> required value="ds"><span for="spkk"> Dibawah Supervisi</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ta3" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ta'){ echo"checked"; } ?> required value="ta"><span for="spkk"> Tak Ada Alat</span>
                            </td>
                            <td>
                              <input type="checkbox" id="tk4" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'tk'){ echo"checked"; } ?> required value="tk"><span for="spkk"> Tak Ada Kompetensi</span>
                            </td>
                            <td></td>
                          </tr>
                          <?php
                          $nomor++;
                        }
                      ?>
                  </tbody> 
                </table>
            <form class="" action="proses_laporan_kredensial.php" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
              <input type="hidden" name="id_kredensial" value="<?php echo $id_kredensial; ?>">
              <div class="alert alert-info">
                <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
              </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nama_pegawai">Aspek Negatif dan Positif dalam Asesmen <span style="color:red">*</span></label>
                      <textarea class="form-control" rows="3" name="aspek_kredensial" placeholder="Masukan Aspek Negatif dan Positif dalam Asesmen" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="nama_pegawai">Pencatatan Penolakan Hasil Asesmen <span style="color:red">*</span></label>
                      <textarea class="form-control" rows="3" name="pencatatan_asesmen" placeholder="Masukan Pencatatan Penolakan Hasil Asesmen" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="nama_pegawai">Saran Perbaikan :(Asesor/Personil Terkait)<span style="color:red">*</span></label>
                      <textarea class="form-control" rows="3" name="saran_perbaikan" placeholder="Masukan Pencatatan Penolakan Hasil Asesmen" required></textarea>
                    </div>
                    <div class="form-group">
                      <label for="waktu_kredensial">Waktu Re-Kredensial<span style="color:red">*</span></label>
                      <input type="date" class="form-control" id="re_kredensial" name="re_kredensial" required>
                    </div>
               </div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
                <a href="peserta-kredensial.php" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
            </div>
            </form>
            <?php
          }else{?>
            <div class="box-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <dl>
                          <dt>Nomor Induk Pegawai</dt>
                          <dd><?php echo $m['nip']; ?></dd>
                          <dt>Nama Pegawai</dt>
                          <dd><?php echo $m['nama']; ?></dd>
                          <dt>Profesi</dt>
                          <dd><?php echo $m['nama_profesi']; ?></dd>
                          </dl>
                          <table class="table table-striped table-bordered">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Kompetensi</th>
                      <th colspan="2">Disetujui</th>
                      <th colspan="2">Ditolak</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                      <?php
                        $queryKompetensi  = $db->prepare("SELECT * FROM `jawaban_kompetensi` WHERE id_kredensial=:id_kredensial AND id_pegawai =:id_pegawai");
                        $queryKompetensi->bindParam(":id_kredensial", $id_kredensial);
                        $queryKompetensi->bindParam(":id_pegawai", $id_pegawai);
                        $queryKompetensi->execute();
                        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
                        $no=1;
                        $nomor=1;
                        foreach ($dataKompetensi as $dk){
                          ?>
                          <input type="hidden" name="id_kompetensi[]" value="<?php echo $dk['id_kompetensi'] ?>">
                          <input type="hidden" name="id_profesi" value="<?php echo $dk['id_profesi'] ?>">
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $dk['soal'] ?></td>
                            <td>
                              <input type="checkbox" id="m1" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'm'){ echo"checked"; } ?> required value="m"><span for="spkk"> Mahir</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ds2" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ds'){ echo"checked"; } ?> required value="ds"><span for="spkk"> Dibawah Supervisi</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ta3" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ta'){ echo"checked"; } ?> required value="ta"><span for="spkk"> Tak Ada Alat</span>
                            </td>
                            <td>
                              <input type="checkbox" id="tk4" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'tk'){ echo"checked"; } ?> required value="tk"><span for="spkk"> Tak Ada Kompetensi</span>
                            </td>
                            <td></td>
                          </tr>
                          <?php
                          $nomor++;
                        }
                      ?>
                  </tbody> 
                </table>
                        <dl>
                          <dt>Aspek Negatif dan Positif dalam Asesmen</dt>
                          <dd><?php echo($m['aspek_kredensial']); ?></dd>
                          <dt>Pencatatan Penolakan Hasil Asesmen</dt>
                          <dd><?php echo $m['pencatatan_asesmen']; ?></dd>
                          <dt>Saran Perbaikan :(Asesor/Personil Terkait)</dt>
                          <dd><?php echo($m['saran_perbaikan']); ?></dd>
                        </dl>
                      </div>
                    </div>
              </div>
              <form action="cetak_laporan.php" method="POST" target="_blank" >
                <input type="hidden" name="nama" value="<?php echo $m["nama"] ?>">
                <input type="hidden" name="nama_mitra_bestari" value="<?php echo $r1["nama"] ?>">
                <input type="hidden" name="aspek_kredensial" value="<?php echo $m["aspek_kredensial"] ?>">
                <input type="hidden" name="pencatatan_asesmen" value="<?php echo $m["pencatatan_asesmen"] ?>">
                <input type="hidden" name="saran_perbaikan" value="<?php echo $m["saran_perbaikan"] ?>">
                <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai ?>">
                <input type="hidden" name="id_kredensial" value="<?php echo $id_kredensial ?>">
              <div class="box-footer">
                <input type="submit" value="Cetak" class="btn btn-primary">
                </form>
              </div>
          <?php
          }
          ?>
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
