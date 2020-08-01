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
$id_pegawai = isset($_GET['id']) ? $_GET['id'] : '';
$master = $db->prepare("SELECT * FROM pegawai peg INNER JOIN pegawai_profil peg_pro ON (peg.id_pegawai=peg_pro.id_peg)  INNER JOIN profesi pf ON (peg_pro.nama_profesi = pf.id_profesi) WHERE peg.id_pegawai=:id");
$master->bindParam(":id",$id_pegawai);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);
$id_profesi = $m["id_profesi"];
// echo "ini $id_profesi";

$queryPegawai = $db->query("SELECT * FROM pegawai ");
$data = $queryPegawai->fetchAll(PDO::FETCH_ASSOC);

$cek_asesi = $db->prepare("SELECT * FROM cek_asesi WHERE id_pegawai=:id");
$cek_asesi->bindParam(":id",$id_pegawai);
$cek_asesi->execute();
$status =  $cek_asesi->fetch(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>"
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
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            Data Kompetensi
            <small>Form Kompetensi</small>
          </h1>
          <ol class="breadcrumb">
           <!--  <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Form Kompetensi</li> -->

          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <div class="box">
            <div class="box-header">
              <i class='fa fa-user'></i><h3 class='box-title'>Form Kompetensi</h3>
              <!-- <a href="tampil_jawaban.php"><button class="btn btn-info">Tampil Jawaban</button></a> -->

            </div>
            <div class="box-body">
              <div class="alert alert-info">
              <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
            </div>
              <div class="form-group">
                <dl class="dl-horizontal">
                  <dt>Nomor Induk Pegawai</dt>
                  <dd><?php echo $m['nip']; ?></dd>
                  <dt>Nama Pegawai</dt>
                  <dd><?php echo $m['nama']; ?></dd>
                  <dt>Profesi</dt>
                  <dd><?php echo $m['nama_profesi']; ?></dd>
                </dl>
              </div>
              <form action="proses_asesi_pribadi.php" method="post">
                <table class="table" >
                  <thead>
                    <tr>
                       <td colspan="6"><center><span class='label label-default' style='font-size:13px'>1 = Mampu melakukan secara mandiri</span>
                        <span class='label label-default' style='font-size:13px'>2 = Mampu melakukan dibawah supervise</span>
                      <span class='label label-default' style='font-size:13px'>3 = Tidak Mampu</span></center></td>
                    </tr>
                    <tr>
                      <th>No</th>
                      <th>Rincian Kewenangan Klinis</th>
                      <th colspan="3">Permohonan Kemampuan Klinis</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php
                        include("../inc/pdo.conf.php");
                        $queryKompetensi  = $db->prepare("SELECT * FROM `asesi_pribadi` ap INNER JOIN asesmen_kompetensi ak ON (ap.id_kompetensi = ak.id_kompetensi)");
                        $queryKompetensi->bindParam(":id_profesi", $id_profesi);
                        $queryKompetensi->execute();
                        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
                        $no=1;
                        $nomor=1;
                        foreach ($dataKompetensi as $dk){
                          ?>
                          <input type="hidden" name="id_kompetensi[]" value="<?php echo $dk['id_kompetensi'] ?>">
                          <input type="hidden" name="id_profesi" value="<?php echo $dk['id_profesi'] ?>">
                          <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai ?>">
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $dk['sub_soal'] ?></td>
                            <td>
                              <input type="checkbox" id="m1" name="jawaban<?php echo $nomor ?>" value="1" <?php if($dk['jawaban'] == '1'){ echo"checked"; } ?>><span for="spkk"> 1</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ds2" name="jawaban<?php echo $nomor ?>" value="2"<?php if($dk['jawaban'] == '2'){ echo"checked"; } ?>><span for="spkk"> 2</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ta3" name="jawaban<?php echo $nomor ?>" value="3"<?php if($dk['jawaban'] == '3'){ echo"checked"; } ?>><span for="spkk"> 3</span>
                            </td>
                            <td>
                              <button id="blue-button" type="button" class="btn btn-sm btn-success bg-navy" data-toggle="modal" data-target="#modalPokokBahasan" data-color="peter">Lihat Pokok Bahasan Kewenangan Klinis</button>
                            </td>
      
                          </tr>
                          <?php
                          $nomor++;
                        }?>
                  </tbody> 
                </table>
  
                <!-- <button class="btn btn-primary">SIMPAN</button> -->
                  <div class="box-footer">
                    <input type="submit" value="Simpan" class="btn btn-primary">
                  </div>
              </form>
            </div>
          </div><!-- /.left column -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- static footer -->
    <?php include("footer.php");?><!-- /.static footer -->
<div id="modalPokokBahasan" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Pokok Bahasan Kewenangan Klinis</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

      <!-- /.modal -->
      <!-- <div id="modal-backdrop" class="modal-backdrop-transparent modal-transition"></div>
      <div id="notif-backdrop" class="modal-backdrop-transparent modal-transition"></div> -->
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
