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
            Data
            <small>pegawai</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Data pegawai</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-user"></i>
				  				<h3 class="box-title">Data Pegawai</h3>
									<?php
									if($role=='Admin'){
										echo '<span class="pull-right"><a href="form_pegawai.php" class="btn btn-success"><i class="fa fa-plus"></i> Tambah Pegawai</a></span>';
									}
									?>
                </div><!-- /.box-header -->

                <div class="box-body">
                  <table id="example1" class="table table-bordered table-striped">
                    <thead>
                      <tr class="bg-blue">
                        <th>#</th>
                        <th>Nama</th>
												<th>NIP</th>
												<th>Status</th>
												<th>Aktif</th>
												<th>Foto</th>
												<th>Aksi</th>
                      </tr>
                    </thead>
                  </table>
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
    <!-- page script -->
    <script type="text/javascript">
      $(function () {
      			var user = "<?php echo $parts; ?>";
      			var check = (user == "Komite_Umum" || user=="Sub_Komite");

      			if(check == true){
      				var dept = <?php echo $id_dept; ?>;
      				var master_simpeg = $('#example1').DataTable({
      					"processing" : true,
      					"language" : {
      						"processing" : "Loading. Please Wait...",
      					},
      					"serverSide" : true,
      					"ajax": "ajax_data/data_pegawai_ku.php?dept="+dept,
      					"columns":[								
      							{"searchable" : true,"data" : 'id_pegawai'},
								{"searchable" : true,"data" : 'nama'},
								{"searchable" : false,"data" : 'nip'},
								{"searchable" : false,"data" : 'status'},
								{
									"searchable" : false,
									"data" : 'aktif',
									"render" : function(data,type,full,meta){
										var kata;
										if(data=='y'){
											kata='<span class="label label-success"><i class="fa fa-check"></i> Aktif</span>';
										}else{
											kata='<span class="label label-danger"><i class="fa fa-ban"></i> Tidak Aktif</span>';
										}
										return kata;
									}
								},
								{
									"searchable" : false,
									"data" : null,
									"render": function(data,type,full,meta){
										var gambar ='<img src="'+data.url_foto+data.nama_file+'" alt="'+data.nama+'" width="100" height="125"/>';
										return gambar;
									}
								},
								{
									"searchable" : false,
									"data" : null,
									"render": function(data,type,full,meta){
										var btn ='<a class="btn btn-xs btn-block btn-default" target=\"_blank\" href=\"cetak.php?id='+data.nip+'&nama='+data.nama+'\"><i class="fa fa-print"></i> Cetak Barcode</a>';
										if(dept==0){
											btn += '<a class="btn btn-xs btn-block btn-primary" target=\"_blank\" href=\"rekap.php?id='+data.id_pegawai+'\"><i class="fa fa-list"></i> Rekap Absensi Barcode</a>';
											btn += '<a class="btn btn-xs btn-block btn-success" target=\"_blank\" href=\"profil_pegawai.php?id='+data.id_pegawai+'\"><i class="fa fa-user"></i> Profil Pegawai</a>';
											btn += '<a class="btn btn-xs btn-block btn-warning" target=\"_blank\" href=\"conf_user.php?id='+data.id_pegawai+'\"><i class="fa fa-gear"></i> Pengaturan User</a>';
										}else{
											btn += '<a class="btn btn-xs btn-block btn-primary" href=\"lokasi_penempatan.php?id='+btoa(data.id_pegawai)+'\"><i class="fa fa-list"></i> Riwayat Penempatan</a>';
										}
										return btn;
									}
								},
							],
							"order": [[0, 'asc']],
						});
	      			}else{
	      				var dept = <?php echo $id_dept; ?>;
	      				var master_simpeg = $('#example1').DataTable({
							"processing" : true,
							"language" : {
								"processing" : "Loading. Please Wait...",
							},
							"serverSide" : true,
							"ajax": "ajax_data/data_master_pegawai.php?dept="+dept,
							"columns":[

								{"searchable" : true,"data" : 'id_pegawai'},
								{"searchable" : true,"data" : 'nama'},
								{"searchable" : false,"data" : 'nip'},
								{"searchable" : false,"data" : 'status'},
								{
									"searchable" : false,
									"data" : 'aktif',
									"render" : function(data,type,full,meta){
										var kata;
										if(data=='y'){
											kata='<span class="label label-success"><i class="fa fa-check"></i> Aktif</span>';
										}else{
											kata='<span class="label label-danger"><i class="fa fa-ban"></i> Tidak Aktif</span>';
										}
										return kata;
									}
								},
								{
									"searchable" : false,
									"data" : null,
									"render": function(data,type,full,meta){
										var gambar ='<img src="'+data.url_foto+data.nama_file+'" alt="'+data.nama+'" width="100" height="125"/>';
										return gambar;
									}
								},
								{
									"searchable" : false,
									"data" : null,
									"render": function(data,type,full,meta){
										var btn ='<a class="btn btn-xs btn-block btn-default" target=\"_blank\" href=\"cetak.php?id='+data.nip+'&nama='+data.nama+'\"><i class="fa fa-print"></i> Cetak Barcode</a>';
										if(dept==0){
											btn += '<a class="btn btn-xs btn-block btn-primary" target=\"_blank\" href=\"rekap.php?id='+data.id_pegawai+'\"><i class="fa fa-list"></i> Rekap Absensi Barcode</a>';
											btn += '<a class="btn btn-xs btn-block btn-success" target=\"_blank\" href=\"profil_pegawai.php?id='+data.id_pegawai+'\"><i class="fa fa-user"></i> Profil Pegawai</a>';
											btn += '<a class="btn btn-xs btn-block btn-warning" target=\"_blank\" href=\"conf_user.php?id='+data.id_pegawai+'\"><i class="fa fa-gear"></i> Pengaturan User</a>';
										}else{
											btn += '<a class="btn btn-xs btn-block btn-primary" href=\"lokasi_penempatan.php?id='+btoa(data.id_pegawai)+'\"><i class="fa fa-list"></i> Riwayat Penempatan</a>';
										}
										return btn;
									}
								},
							],
							"order": [[0, 'asc']],
						});

	      			}
      });
    </script>

  </body>
</html>
