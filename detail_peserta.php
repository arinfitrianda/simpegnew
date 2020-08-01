<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];


$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
$parts = $tipes[2];
if($role=='operator'){
	$parts = explode("_",$tipes[2]);
	$id_dept = $parts[1];
}else{
	$id_dept = 0;
}
if ($tipes[0]!='Simpeg')
{
	unset($_SESSION['tipe']);
	unset($_SESSION['namauser']);
	unset($_SESSION['password']);
	header("location:../index.php?status=2");
	exit;
}
include "../inc/anggota_check.php";

$nama_mitra_bestari = $_GET["nama_mitra_bestari"];
// echo $nama_mitra_bestari;

$peg = $db->prepare("SELECT * FROM status_kredensial as sk INNER JOIN kredensial as kr ON(sk.id_kredensial=kr.id_kredensial) INNER JOIN pegawai as pg ON kr.id_pegawai = pg.id_pegawai INNER JOIN pegawai_profil as pg_prof ON pg.id_pegawai = pg_prof.id_peg INNER JOIN profesi pf ON (pg_prof.nama_profesi = pf.id_profesi) WHERE kr.nama_mitra_bestari =:nama_mitra_bestari ");
$peg->bindParam(":nama_mitra_bestari",$nama_mitra_bestari);
$peg->execute();
$pegawai = $peg->fetchAll(PDO::FETCH_ASSOC);

$getDataKomite = $db->prepare("SELECT DISTINCT kr.nama_mitra_bestari, pg.id_pegawai, kr.id_kredensial, pf.nama_profesi FROM kredensial as kr INNER JOIN pegawai as pg ON kr.id_pegawai = pg.id_pegawai INNER JOIN pegawai_profil as pg_prof ON pg.id_pegawai = pg_prof.id_peg INNER JOIN profesi pf ON (pg_prof.nama_profesi = pf.id_profesi)");
$getDataKomite->execute();
$data_komite = $getDataKomite->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>SIMRS <?php echo $version; ?> | <?php echo $tipes[0]; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.2 -->
    <link href="../bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
		<!-- Font Awesome Icons -->
		<link href="../plugins/font-awesome/4.3.0/font-awesome.min.css" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="../plugins/ionicons/2.0.0/ionicon.min.css" rel="stylesheet" type="text/css" />
    <!-- DATA TABLES -->
    <link href="../plugins/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
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
		<style media="screen">
		.dataTables_wrapper .dataTables_processing {
				position: absolute;
				top: 30%;
				left: 50%;
				width: 30%;
				height: 40px;
				margin-left: -20%;
				margin-top: -25px;
				padding-top: 20px;
				text-align: center;
				font-size: 1.2em;
				background:none;
		}
		</style>
  </head>
  <body class="skin-black">
    <div class="wrapper">
	  <?php include("header.php"); ?>
	  <?php include "menu_index.php"; ?>
      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
		<!-- pesan feedback -->
	    <?php if (isset($_GET['status']) && ($_GET['status'] == "1")) { ?><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center><h4><i class="icon fa fa-check"></i>Berhasil</h4>Data Pegawai Berhasil ditambahkan.</center></div>
			<?php } else if (isset($_GET['status']) && ($_GET['status'] == "2")) { ?><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center><h4><i class="icon fa fa-check"></i>Berhasil</h4>Data pasien telah diproses</center></div>
			<?php } else if (isset($_GET['status']) && ($_GET['status'] == "3")) { ?><div class="alert alert-danger alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center><h4><i class="icon fa fa-ban"></i>Peringatan!</h4>Data pasien gagal diubah</center></div>
	    <?php } ?>
	    <!-- end pesan -->
        <section class="content-header">
          <h1>
            Data Peserta Kredensial
            <!-- <small>pegawai</small> -->
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Peserta Kredensial</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-user"></i>
                </div><!-- /.box-header -->

                <div class="box-body">
                  <?php
                  if($parts == "Sub_Komite"){?>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>#</th>
                        <th>Nama Mitra Bestari</th>
                        <th>Nama Peserta</th>
                        <th>Profesi</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no=1;
                    foreach ($pegawai as $f) {
                    	$id = $f["id_pegawai"];
                      $id_kredensial = $f["id_kredensial"];
                    	echo "<tr>
                    	<td>".$no++."</td>
                      <td>".$f['nama_mitra_bestari']."</td>
                    	<td>".$f['nama']."</td>
                    	<td>".$f['nama_profesi']."</td>
                    	<td><a  target='_blank' href='asesmen_kredensial.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs bg-maroon'><i class='fa fa-edit'></i>Hasil Asesmen Kompetensi</a>
                    		<a  target='_blank' href='surat_laporan_asesmen.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs bg-purple'><i class='fa  fa-desktop')'></i>Cetak Surat Pengantar Hasil Kredensial</a>
                    		<a  target='_blank' href='status_kredensial.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs btn-info'><i class='fa fa-trash')'></i>Laporan Status Kredensial</a>
                    	</tr>";
                    }
	                    ?>
	                </tbody>
                  </table>
                  <?php
                  }else if($parts == "Mitra_Bestari"){?>
                    <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Profesi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no=1;
                    foreach ($pegawai as $f) {
                      $id = $f["id_pegawai"];
                      $id_kredensial = $f["id_kredensial"];
                      $pengajuan = $f["pengajuan"];
                      $verifikasi_bukti = $f["verifikasi_bukti"];
                      $set_tempat = $f["set_tempat"];
                      $asesmen_kompetensi = $f["asesmen_kompetensi"];
                      $laporan_asesmen = $f["laporan_asesmen"];
                      $surat_laporan_asesmen = $f["surat_laporan_asesmen"];
                      $input_no_sk = $f["input_no_sk"];
                      $penerbitan_rkk = $f["penerbitan_rkk"];

                      echo "<tr>
                      <td>".$no++."</td>
                      <td>".$f['nama']."</td>
                      <td>".$f['nama_profesi']."</td>";
                      if ($pengajuan == 1 && $verifikasi_bukti==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Pengajuan Permohonan Kredensial</span></td>
                      <?php
                      }else if($verifikasi_bukti == 1 && $set_tempat==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Verifikasi Bukti Pendukung Kredensial</span></td>
                      <?php
                      }else if($set_tempat == 1 && $asesmen_kompetensi==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Formulir Persetujuan Asesmen dan Kerahasiaan</span></td>
                      <?php
                      }else if($asesmen_kompetensi == 1 && $laporan_asesmen==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Asesmen Kompetensi Profesi </span></td>
                      <?php
                      }else if($laporan_asesmen == 1 && $input_no_sk==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Laporan Hasil Asesmen Kompetensi Profesi</span></td>
                      <?php
                      }else if($input_no_sk == 1 && $penerbitan_rkk==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Proses Penerbitan Rincian Kewenangan Klinis</span></td>
                      <?php
                      }else if($penerbitan_rkk==1) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Rincian Kewenangan Klinis Telah Terbit</span></td>
                      <?php
                      }
                      echo "<td><a  target='_blank' href='verifikasi_dokumen.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs bg-maroon'><i class='fa fa-edit'></i> Verifikasi Dokumen</a>
                        <a  target='_blank' href='jadwal_kredensial.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs bg-purple'><i class='fa  fa-desktop')></i> Jadwal Kredensial</a>
                        <a  target='_blank' href='asesmen_kredensial.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs btn-info'><i class='fa fa-indent')'></i> Asesmen Kompetensi</a>
                        <a  target='_blank' href='laporan_hasil_asesmen.php?id_pegawai=$id&id_kredensial=$id_kredensial' class='btn btn-block btn-xs bg-navy'><i class='fa  fa-file')'></i> Laporan Hasil Asesmen</a></td>
                      </tr>";
                    }
                      ?>
                  </tbody>
                  </table>
                  <?php
                    }else{
                  ?>
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>#</th>
                        <th>Nama</th>
                        <th>Profesi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $no=1;
                    foreach ($pegawai as $f) {
                      $id = $f["id_pegawai"];
                      $id_kredensial = $f["id_kredensial"];
                      $pengajuan = $f["pengajuan"];
                      $verifikasi_bukti = $f["verifikasi_bukti"];
                      $set_tempat = $f["set_tempat"];
                      $asesmen_kompetensi = $f["asesmen_kompetensi"];
                      $laporan_asesmen = $f["laporan_asesmen"];
                      $surat_laporan_asesmen = $f["surat_laporan_asesmen"];
                      $input_no_sk = $f["input_no_sk"];
                      $penerbitan_rkk = $f["penerbitan_rkk"];

                      echo "<tr>
                      <td>".$no++."</td>
                      <td>".$f['nama']."</td>
                      <td>".$f['nama_profesi']."</td>";
                      if ($pengajuan == 1 && $verifikasi_bukti==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Pengajuan Permohonan Kredensial</span></td>
                      <?php
                      }else if($verifikasi_bukti == 1 && $set_tempat==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Verifikasi Bukti Pendukung Kredensial</span></td>
                      <?php
                      }else if($set_tempat == 1 && $asesmen_kompetensi==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Formulir Persetujuan Asesmen dan Kerahasiaan</span></td>
                      <?php
                      }else if($asesmen_kompetensi == 1 && $laporan_asesmen==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Asesmen Kompetensi Profesi </span></td>
                      <?php
                      }else if($laporan_asesmen == 1 && $input_no_sk==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Laporan Hasil Asesmen Kompetensi Profesi</span></td>
                      <?php
                      }else if($input_no_sk == 1 && $penerbitan_rkk==0) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Proses Penerbitan Rincian Kewenangan Klinis</span></td>
                      <?php
                      }else if($penerbitan_rkk==1) {?>
                        <td> <span class='label label-default' style='font-size:13px'>Rincian Kewenangan Klinis Telah Terbit</span></td>
                      <?php
                      }?>
                      <td><a  target='_blank' href='data_pribadi_nakes.php?id_pegawai=<?php echo$id?>' class='btn btn-block btn-xs bg-navy'><i class='fa fa-edit'></i> Data Pribadi Peserta</a>
                        <a  target='_blank' href='hasil_kewenangan_klinis.php?id_pegawai=<?php echo $id?>&id_kredensial=<?php echo$id_kredensial?>' class='btn btn-block btn-xs bg-purple'><i class='fa  fa-desktop')></i> Hasil Kewenangan Klinis</a>
                        <a  target='_blank' href='input_no_sk.php?id_pegawai=<?php echo $id?>&id_kredensial=<?php echo $id_kredensial?>' class='btn btn-block btn-xs bg-maroon'><i class='fa fa-edit'></i>Set Nomer SK Kewenangan Klinis</a>
                      </tr>
                    <?php
                      }
                    ?>
                  </tbody>
                  </table>
                <?php
                }
                ?>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
            </div><!-- /.col -->
          </div><!-- /.row -->
        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
      <!-- static footer -->
	  <?php include("footer.php"); ?><!-- /.static footer -->
    </div><!-- ./wrapper -->

    <!-- jQuery 2.1.3 -->
    <script src="../plugins/jQuery/jQuery-2.1.3.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- DATA TABES SCRIPT -->
    <script src="../plugins/datatables/jquery.dataTables.min.js" type="text/javascript"></script>
    <script src="../plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
    <!-- SlimScroll -->
    <script src="../plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
  </body>
</html>
