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
$status_notif = isset($_GET['status']) ? $_GET['status'] : '';
//data formal
$formal_list = $db->query("SELECT * FROM pegawai_pend_formal WHERE status=0 AND id_pegawai='".$id_pegawai."'" );
$formal = $formal_list->fetchAll(PDO::FETCH_ASSOC);
// $cek_formal = $formal->rowCount(); 
$cek_formal = count($formal);
//data riwayat pekerjaan
$getRiwayatPekerjaan = $db->query("SELECT * FROM riwayat_pekerjaan WHERE status=0 AND id_pegawai='".$id_pegawai."'");
$riwayatPekerjaan= $getRiwayatPekerjaan->fetchAll(PDO::FETCH_ASSOC); 
$cek_pekerjaan = count($riwayatPekerjaan);

$pribadi = $db->prepare("SELECT *,pro.name as 'provinsi',kab.name as 'kabupaten',kec.name as 'kecamatan',kel.name as 'kelurahan' FROM pegawai_profil peg LEFT JOIN provinsi pro ON(pro.id=peg.provinsi) LEFT JOIN kota kab ON(kab.id=peg.kabupaten) LEFT JOIN kecamatan kec ON(kec.id=peg.kecamatan) LEFT JOIN kelurahan kel ON(kel.id=peg.kelurahan) WHERE id_peg=:id");
  $pribadi->bindParam(":id",$id_pegawai);
  $pribadi->execute();
  $dp = $pribadi->fetch(PDO::FETCH_ASSOC);

try {
	$dept = $db->query("SELECT * FROM departemen");
	$d = $dept->fetchAll(PDO::FETCH_ASSOC);

  $profesi = $db->query("SELECT * FROM profesi");
  $get_profesi = $profesi->fetchAll(PDO::FETCH_ASSOC);
  //get data master
  $master = $db->prepare("SELECT * FROM set_asesor sa INNER JOIN pegawai_profil pro ON(sa.id_pegawai = pro.id_peg) INNER JOIN pegawai peg ON(peg.id_pegawai=pro.id_peg) WHERE pro.id_peg=:id");
  $master->bindParam(":id",$id_pegawai);
  $master->execute();
  $m = $master->fetch(PDO::FETCH_ASSOC);

  $kredensial = $db->prepare("SELECT * FROM kredensial WHERE id_pegawai=:id AND status=0");
  $kredensial->bindParam(":id",$id_pegawai);
  $kredensial->execute();
  $data_kredensial = $kredensial->fetch(PDO::FETCH_ASSOC);
  $number_of_rows = $kredensial->rowCount(); 

  $status_kredensial = $db->prepare("SELECT * FROM status_kredensial WHERE id_pegawai=:id and id_kredensial=:id_kredensial");
  $status_kredensial->bindParam(":id",$id_pegawai);
  $status_kredensial->bindParam(":id_kredensial",$id_kredensial);
  $status_kredensial->execute();
  $status =  $status_kredensial->fetch(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
	echo "Error ".$e->getMessage();
	exit();
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
  <body class="<?php echo $skin_simpeg; ?>">
    <div class="wrapper">
	  <?php 
    include "header.php";
    include "menu_index.php"; ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">

          <h1>
          DATA PRIBADI 
            <small>Data Pribadi</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data Pribadi</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
                     <?php
          if($status_notif==1){?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
            Kredensial Berhasil di Ajukan, silahkan Klik Cetak Untuk Print Surat Permohonan Kredensial 
          </div>
          <?php
          }else if($status_notif==111){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              Data Gagal Di Tambahkan
            </div>
          <?php
          }else if($status_notif==2){?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
            Data Berhasil Di Update
          </div>
          <?php
          }else if($status_notif==112){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              Data Gagal Di Update
            </div>
          <?php
          }else if($status_notif==3){?>
          <div class="alert alert-success alert-dismissible">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-check"></i> Sukses!</h4>
            Data Berhasil Di Hapus
          </div>
          <?php
          }else if($status_notif==113){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              Data Gagal Di Hapus
            </div>
          <?php
          }else if($status_notif=="file_ada"){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              File Sudah Di Upload Sebelumnya
            </div>
          <?php
          }else if($status_notif=="file_kosong"){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              File Tidak Terinput
            </div>
          <?php
          }else if($status_notif=="file_besar"){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              Ukuran File Terlalu Besar
            </div>
          <?php
          }else if($status_notif=="file_not_pdf"){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              File Bukan PDF
            </div>
          <?php
          }else if($status_notif=="masa_kredensial"){?>
            <div class="alert alert-danger alert-dismissible">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Gagal!</h4>
              Anda masih dalam masa kredensial
            </div>
          <?php
          }?>  
              <!-- general form elements -->
			  <!-- left column -->
			  <div class="box">
            <div class="box-header">

              <i class="fa fa-user"></i>
    				  <h3 class="box-title">Data Pribadi <?php echo $m["nama"]; ?></h3>
            </div><!-- /.box-header -->
            <form class="" action="proses_ajukan_kredensial.php" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
              <input type="hidden" name="nama_mitra_bestari" value="<?php echo $m['nama_mitra_bestari']; ?>">
              <input type="hidden" name="nama_profesi" value="<?php echo $m['nama_profesi']; ?>">
            <div class="box-body">
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <table width="100%">
                        <td>
                          <dl class="dl-horizontal">
                            <dt>Nomor Induk Pegawai</dt>
                            <dd><?php echo $m['nip']; ?></dd>
                            <dt>Nama Pegawai</dt>
                            <dd><?php echo $m['nama']; ?></dd>
                            <dt>Tempat, Tanggal Lahir</dt>
                            <dd><?php echo $m['tempat_lahir'];?> , <?php echo $m['tanggal_lahir']; ?> </dd>
                          </dl>
                        </td>
                        <td>
                          <dl class="dl-horizontal">
                            <dt>Status Pegawai</dt>
                            <dd><?php echo $m['status_pegawai']; ?></dd>
                            <dt>Pendidikan Terakhir </dt>
                            <dd>S1</dd>
                            <dt>Tanggal Masuk</dt>
                            <dd><?php echo $dp['tmt_pegawai']?> </dd>
                          </dl>
                        </td>
                        <td>
                          <dl class="dl-horizontal">
                            <dt>Alamat</dt>
                            <dd><?php echo $dp['alamat']; ?></dd>
                            <dt>Provinsi</dt>
                            <dd><?php echo $dp['provinsi']; ?></dd>
                            <dt>Kota</dt>
                            <dd><?php echo $dp['kabupaten'];?> </dd>
                            <dt>Kecamatan</dt>
                            <dd><?php echo $dp['kecamatan'];?> </dd>
                            <dt>Kelurahan</dt>
                            <dd><?php echo $dp['kelurahan'];?> </dd>
                            <dt>Kode Pos</dt>
                            <dd><?php echo $dp['kode_pos'];?> </dd>
                          </dl>
                        </td>
                      </table>
                    </div>
                    <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title">Data Riwayat Pendidikan</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 10px">No</th>
                              <th>Tingkat Pendidikan</th>
                              <th>Tahun Lulus</th>
                              <th>Nama Institusi Pendidikan</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no=1;
                            foreach ($formal as $f) {
                              $id_pendFormal = $f["id_pend_formal"];
                              $count_pend = Count($formal);
                              echo "ini count pendidikan $count_pend";
                              echo "<tr>
                              <td>".$no++."</td>
                              <td>".$f["tingkat_pendidikan"]."</td>
                              <td>".$f["tanggal_sttb"]."</td>
                              <td>".$f["nama_sekolah"]."</td>
                              </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="box">
                      <div class="box-header with-border">
                        <h3 class="box-title">Data Riwayat Pekerjaan</h3>
                      </div>
                      <!-- /.box-header -->
                      <div class="box-body">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th style="width: 10px">No</th>
                              <th>Tahun</th>
                              <th>Nama Tempat Bekerja</th>
                              <th>Ruangan</th>
                              <th>Jabatan</th>
                              <th>Lama Bekerja</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                            $no=1;
                            foreach ($riwayatPekerjaan as $data_pekerjaan) {
                              $id_pekerjaan = $data_pekerjaan["id_pekerjaan"];
                              $count_pekerjaan = Count($riwayatPekerjaan);
                              echo "<tr>
                              <td>".$no++."</td>
                              <td>".$data_pekerjaan['tgl_mulai_kerja']."</td>
                              <td>".$data_pekerjaan['nama_perusahaan']."</td>
                              <td>".$data_pekerjaan['ruangan']."</td>
                               <td>".$data_pekerjaan['jabatan']."</td>
                              <td>".$data_pekerjaan['tgl_selesai_kerja']."</td>
                              </tr>";
                            }
                            ?>
                          </tbody>
                        </table>
                      </div>
                      <!-- /.box -->
                    </div>
            <!-- <div class="box-footer">
              <?php 
              if($number_of_rows == 0){
              ?>
                <button type="submit" class="btn btn-primary" name="simpan" onclick="CekAjuan()"><i class="fa fa-save"></i> Ajukan Kredensial</button>
								<a href="profil_pegawai.php?id=<?php echo $id_pegawai ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
              <?php
              }else{?>
                <a href="cetak_surat_pengajuan_kredensial.php?nama=<?php echo $m['nama']?>" class="btn bg-navy" target="_BLANK">Cetak Surat Pengajuan Kredensial</a>
                <a href="cetak_data_pribadi.php?id=<?php echo $id_pegawai ?>" class="btn bg-navy" target="_BLANK">Cetak Data Pribadi</a>
                 <a href="cetak_surat_pengajuan_kredensial.php?nama=<?php echo $m['nama']?>" onclick="CekAjuan()">Cek</a> -->
                <!-- <button type="submit" class="btn btn-primary" name="simpan" onclick="CekAjuan()"><i class="fa fa-save"></i> Cetak</button> -->
       <!--        <?php
              }
              ?>
            </div> -->
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
      function CekAjuan(){
        var nip = "<?php echo $m['nip']; ?>";
        // var nip = "";
        var nama = "<?php echo $m['nama']; ?>";
        // var nama ="";
        var tempat_lahir = "<?php echo $m['tempat_lahir']; ?>";
        var tanggal_lahir = "<?php echo $m['tanggal_lahir']; ?>";
        var status_pegawai = "<?php echo $m['status_pegawai']; ?>";
        var tmt_pegawai = "<?php echo $dp['tmt_pegawai']; ?>";
        var alamat = "<?php echo $dp['alamat']; ?>";
        var provinsi = "<?php echo $dp['provinsi']; ?>";
        var kabupaten = "<?php echo $dp['kabupaten']; ?>";
        var kecamatan = "<?php echo $dp['kecamatan']; ?>";
        var kelurahan = "<?php echo $dp['kelurahan']; ?>";
        var kode_pos = "<?php echo $dp['kode_pos']; ?>";
        var count_pend = <?php echo $cek_formal;?>;
        var count_pekerjaan = <?php echo $cek_pekerjaan;?>;
        var tujuan=$(this).attr('id');

        if(nip == ''){
          alert("Silahkan Lengkapi Data NIP Pegawai");
        }else if(nama ==''){
          alert("Silahkan Lengkapi Data Nama");
        }else if(tempat_lahir == ''){
          alert("Silahkan Lengkapi Data Tempat Lahir");
        }else if(tanggal_lahir == ''){
          alert("Silahkan Lengkapi Data Tanggal Lahir ");
        }else if(status_pegawai == ''){
          alert("Silahkan Lengkapi Data Status Pegawai");
        }else if(tmt_pegawai == ''){
          alert("Silahkan Lengkapi Data TMT Pegawai ");
        }else if(alamat == ''){
          alert("Silahkan Lengkapi Data Alamat");
        }else if(provinsi == ''){
          alert("Silahkan Lengkapi Data Provinsi ");
        }else if(kabupaten == ''){
          alert("Silahkan Lengkapi Data Kabupaten ");
        }else if(kecamatan == ''){
          alert("Silahkan Lengkapi Data Kecamatan ");
        }else if(kelurahan == ''){
          alert("Silahkan Lengkapi Data Kelurahan ");
        }else if(kode_pos == ''){
          alert("Silahkan Lengkapi Data Kode Pos ");
        }else if(count_pend == 0){
          alert("Silahakan Lengkapi Data Riwayat Pendidikan");
        }else if(count_pekerjaan == 0){
          alert("Silahkan Lengkapi Data Riwayat Pekerjaan");
        }else{
          window.location.href=tujuan;
        }
      }
    </script>
  </body>
</html>
