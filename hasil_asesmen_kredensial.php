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
$id_profesi = isset($_GET['id_profesi']) ? $_GET['id_profesi'] : '';

$status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
$status_kredensial->bindParam(":id",$id_pegawai);
$status_kredensial->bindParam(":id_kredensial",$id_kredensial);
$status_kredensial->execute();
$status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);
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
              <?php
              if($status["asesmen_kompetensi"] == 1){
                echo "<h3 class='box-title'>Form Kompetensi</h3><i style='color:green' class='fa fa-check'></i>";
              }else{
                echo "<i class='fa fa-user'></i><h3 class='box-title'>Form Kompetensi</h3>";
              }?>
              <!-- <a href="tampil_jawaban.php"><button class="btn btn-info">Tampil Jawaban</button></a> -->
            </div>
            <div class="box-body">
              
              <form action="proses_asesmen_kredensial.php" method="post">
                <table class="table">
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
                    if($status["asesmen_kompetensi"] == 0){
                        $queryKompetensi  = $db->prepare("SELECT * FROM asesi_pribadi WHERE id_profesi=:id_profesi AND id_pegawai=:id_pegawai");
                        $queryKompetensi->bindParam(":id_pegawai", $id_pegawai);
                        $queryKompetensi->bindParam(":id_profesi", $id_profesi);
                        $queryKompetensi->execute();
                        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
                        $no=1;
                        $nomor=1;
                        foreach ($dataKompetensi as $dk){
                          ?>
                          <input type="hidden" name="sub_soal[]" value="<?php echo  $dk['sub_soal'] ?>">
                          <input type="hidden" name="id_profesi" value="<?php echo $dk['id_profesi'] ?>">
                          <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai ?>">
                          <input type="hidden" name="id_kredensial" value="<?php echo $id_kredensial ?>">
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $dk['sub_soal'] ?></td>
                            <td>
                              <?php 
                              if($dk["jawaban_asesi"] == "1"){
                                echo "Mahir";
                              }else if ($dk["jawaban_asesi"] == "2") {
                                echo "Dibawah Supervisi";
                              }else{
                                echo "Tidak Ada Kompetensi";
                              }
                              ?></td>

                            </td>
                            <td>
                              <input type="radio" id="m1" name="jawaban<?php echo $nomor ?>" value="m"><span for="spkk"> Mahir</span>
                            </td>
                            <td>
                              <input type="radio" id="ds2" name="jawaban<?php echo $nomor ?>" value="ds"><span for="spkk"> Dibawah Supervisi</span>
                            </td>
                            <td>
                              <input type="radio" id="ta3" name="jawaban<?php echo $nomor ?>" value="ta"><span for="spkk"> Tak Ada Alat</span>
                            </td>
                            <td>
                              <input type="radio" id="tk4" name="jawaban<?php echo $nomor ?>" value="tk"><span for="spkk"> Tak Ada Kompetensi</span>
                            </td>
                            <td><button id="blue-button" type="button" class="btn btn-sm btn-success bg-navy" data-toggle="modal" data-target="#modalPokokBahasan" data-color="peter" id="<?php echo $row["id_kompetensi"]; ?>">Lihat Pokok Bahasan Kewenangan Klinis</button></td>
                          </tr>
                          <?php
                          $nomor++;
                        }
                      }else{
                        $queryKompetensi  = $db->prepare("SELECT * FROM `jawaban_kompetensi` as jk INNER JOIN asesi_pribadi as ap ON jk.soal = ap.sub_soal WHERE jk.id_kredensial=:id_kredensial AND jk.id_pegawai=:id_pegawai");
                        $queryKompetensi->bindParam(":id_kredensial", $id_kredensial);
                        $queryKompetensi->bindParam(":id_pegawai", $id_pegawai);
                        $queryKompetensi->execute();
                        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
                        $no=1;
                        $nomor=1;
                        foreach ($dataKompetensi as $dk){
                          ?>
                          <tr>
                            <td><?php echo $no++ ?></td>
                            <td><?php echo $dk['soal'] ?></td>
                            <td> <?php 
                              if($dk["jawaban_asesi"] == "1"){
                                echo "Mahir";
                              }else if ($dk["jawaban_asesi"] == "2") {
                                echo "Dibawah Supervisi";
                              }else{
                                echo "Tidak Ada Kompetensi";
                              }
                              ?></td>
                            <td>
                              <input type="checkbox" id="m1" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'm'){ echo"checked"; } ?>  value="m"><span for="spkk"> Mahir</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ds2" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ds'){ echo"checked"; } ?>  value="ds"><span for="spkk"> Dibawah Supervisi</span>
                            </td>
                            <td>
                              <input type="checkbox" id="ta3" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'ta'){ echo"checked"; } ?>  value="ta"><span for="spkk"> Tak Ada Alat</span>
                            </td>
                            <td>
                              <input type="checkbox" id="tk4" name="jawaban<?php echo $nomor ?>" <?php if($dk['jawaban'] == 'tk'){ echo"checked"; } ?>  value="tk"><span for="spkk"> Tak Ada Kompetensi</span>
                            </td>
                            <td><button id="blue-button" type="button" class="btn btn-sm btn-success bg-navy" data-toggle="modal" data-target="#modalPokokBahasan" data-color="peter" id="<?php echo $row["id_kompetensi"]; ?>">Lihat Pokok Bahasan Kewenangan Klinis</button></td>
                          </tr>
                          <?php
                          $nomor++;
                        }
                      }
                      ?>
                  </tbody> 
                </table>
                <!-- <button class="btn btn-primary">SIMPAN</button> -->
                <?php
                if($status["asesmen_kompetensi"] == 0){?>
                  <div class="box-footer">
                    <input type="submit" value="Simpan" class="btn btn-primary">
                  </div>
                <?php
                }else{?>
                  <div class="box-footer">
                    <a href="laporan_hasil_asesmen.php?id_pegawai=<?php echo$id_pegawai?>&id_kredensial=<?php echo $id_kredensial ?>" class="btn bg-navy"></i>Laporan Hasil Asesmen</a>
                  </div>
                <?php
                }
                ?>
                
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
