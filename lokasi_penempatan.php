<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
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
$id_pegawai = isset($_GET['id']) ? base64_decode($_GET['id']) : '0';
$get_pegawai = $db->prepare("SELECT nama,nip FROM pegawai WHERE id_pegawai=:id");
$get_pegawai->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
$get_pegawai->execute();
$data_pegawai = $get_pegawai->fetch(PDO::FETCH_ASSOC);
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
		<!-- notification -->
		<link href="../plugins/pnotify/css/animate.css" rel="stylesheet" type="text/css" />
		<link href="../plugins/pnotify/css/pnotify.custom.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="../dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link href="../dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
		<link href="../plugins/datetimepicker/css/bootstrap-datetimepicker.css" rel="stylesheet" type="text/css" />

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
	    <?php if (isset($_GET['status']) && ($_GET['status'] == "1")) { ?><div class="alert alert-success alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><center><h4><i class="icon fa fa-check"></i>Berhasil</h4>Data Lokasi Penempatan Berhasil ditambahkan.</center></div>
	    <?php } ?>
	    <!-- end pesan -->
        <section class="content-header">
          <h1>
            Riwayat Penempatan
            <small><?php echo $data_pegawai['nama']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Lokasi Penempatan</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
          <div class="row">
            <div class="col-xs-12">
              <div class="box box-primary">
                <div class="box-header">
                  <i class="fa fa-user"></i>
				  				<h3 class="box-title"><?php echo $data_pegawai['nama']."(".$data_pegawai['nip'].")"; ?></h3>
									<button type="button" class="btn btn-primary btn-sm pull-right" data-toggle="modal" data-target="#myModal" data-task="add" data-id="<?php echo $id_pegawai ?>"><i class="fa fa-plus"></i> Tambah Riwayat</button>
                </div><!-- /.box-header -->

                <div class="box-body">
									<div class="table-responsive">
										<table id="example1" class="table table-bordered table-striped" style="width:100%">
											<thead>
												<tr class="bg-blue">
													<th>Tanggal Awal</th>
													<th>Tanggal Akhir</th>
													<th>Lokasi</th>
													<th>Jabatan</th>
													<th>Aksi</th>
												</tr>
											</thead>
										</table>
									</div>
                </div><!-- /.box-body -->
              </div><!-- /.box -->
							<!-- start modal -->
							<div id="myModal" class="modal fade" role="dialog">
							  <div class="modal-dialog">
							    <!-- Modal content-->
							    <div class="modal-content">
							      <div class="modal-header bg-blue">
							        <button type="button" class="close" data-dismiss="modal">&times;</button>
							        <h4 class="modal-title">Form Tambah Data Penempatan</h4>
							      </div>
							      <div class="modal-body">
											<input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $id_pegawai;?>">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
													  <label for="">Tanggal Awal Penempatan <span style="color:red">*</span></label>
													  <input type="text" class="form-control" id="tanggal_awal" name="tanggal_awal" autocomplete="off" required>
													</div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
													  <label for="">Tanggal Akhir Penempatan <span style="color:red">*</span></label>
														<input type="text" class="form-control" id="tanggal_akhir" name="tanggal_akhir" autocomplete="off" required>
													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
									          <label for="">Lokasi <span style="color:red">*</span></label>
														<select class="form-control select21" name="lokasi" id="lokasi" style="width:100%;" required>
															<option value=""></option>
															<option value="POLIKLINIK">Poliklinik</option>
															<option value="NIFAS4">Nifas 4</option>
															<option value="NIFAS3">Nifas 3</option>
															<option value="RUANG ANAK">Ruang Anak</option>
															<option value="PERINATOLOGI">Perinatologi</option>
															<option value="OK">OK</option>
															<option value="ICU">ICU</option>
															<option value="IGD">IGD</option>
															<option value="REKAM MEDIS">REKAM MEDIS</option>
															<option value="JKN">JKN</option>
															<option value="CSSD">CSSD</option>
															<option value="APOTEK">APOTEK</option>
															<option value="GUDANG FARMASI">G.FARMASI</option>
															<option value="RADIOLOGI">RADIOLOGI</option>
															<option value="LABORATORIUM">LABORATORIUM</option>
														</select>
									        </div>
												</div>
												<div class="col-md-6">
													<div class="form-group">
													  <label for="">Jabatan <span style="color:red">*</span></label>
													  <input type="text" class="form-control" id="jabatan" name="jabatan" placeholder="contoh : Perawat/Bidan/Assembly/Case Manager" required>
													</div>
												</div>
											</div>
							      </div>
							      <div class="modal-footer">
											<button type="button" id="tambahPenempatan" class="btn btn-primary"><i class="fa fa-plus"></i> Tambah</button>
							        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa fa-times"></i> Tutup</button>
							      </div>
							    </div>
							  </div>
							</div>
							<!-- end modal -->
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
		<!-- notification -->
		<script type="text/javascript" src="../plugins/pnotify4/dist/iife/PNotify.js"></script>
		<script type="text/javascript" src="../plugins/pnotify4/dist/iife/PNotifyButtons.js"></script>
		<script type="text/javascript" src="../plugins/pnotify4/dist/iife/PNotifyConfirm.js"></script>
		<script type="text/javascript" src="../plugins/pnotify4/dist/iife/PNotifyDesktop.js"></script>
		<script type="text/javascript" src="../plugins/pnotify4/dist/iife/PNotifyHistory.js"></script>
		<script type="text/javascript" src="../plugins/pnotify4/dist/iife/PNotifyAnimate.js"></script>
		<script type="text/javascript" src="../plugins/pnotify/js/modular_pnotify.js"></script>
    <!-- FastClick -->
    <script src='../plugins/fastclick/fastclick.min.js'></script>
		<script src='../plugins/datetimepicker/js/moment-with-locales.js'></script>
		<script src='../plugins/datetimepicker/js/bootstrap-datetimepicker.js'></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
		<script src="../plugins/sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
		  function hapus_data(reg,id){
				var notice = PNotify.notice({
				  title: 'Konfirmasi Hapus Data',
				  text: 'Apakah Anda Yakin?',
				  icon: 'fa fa-question',
				  hide: false,
				  modules: {
				    Confirm: {
				      confirm: true
				    },
				    Buttons: {
				      closer: false,
				      sticker: false
				    },
				    History: {
				      history: false
				    }
				  }
				});
				notice.on('pnotify.confirm', function() {
					var fd = new FormData();
					fd.append("reg", reg);
					fd.append("id_penempatan", id);
					$.ajax({
						type: 'POST',
						url: 'ajax_data/del_lokasi_penempatan.php',
						data: fd,
						contentType: false,
						cache: false,
						processData:false,
						success: function(msg){
						 var res = JSON.parse(msg);
						 PNotify.notice({
				       title: res.title,
				       text: res.msg,
				       modules: {
				         Desktop: {
				           desktop: true
				         },
				         Animate: {
				           animate: true,
				           inClass: "bounceIn",
				           outClass: "bounceOut"
				         }
				       }
				     });
						 setTimeout(function(){
							 window.location="lokasi_penempatan.php?id="+btoa(res.id_peg);
						 },1500);
						}
					});
				});
			}
      $(function () {

				var peg = <?php echo $id_pegawai; ?>;
				var master_simpeg = $('#example1').DataTable({
					"processing" : true,
					"language" : {
						"processing" : "Loading. Please Wait...",
					},
					"serverSide" : true,
					"ajax": "ajax_data/data_penempatan.php?peg="+peg,
					"columns":[
						{"searchable" : true,"data" : 'tanggal_awal'},
						{"searchable" : true,"data" : 'tanggal_akhir'},
						{"searchable" : true,"data" : 'lokasi'},
						{"searchable" : true,"data" : 'jabatan'},
						{
							"searchable" : false,
							"data" : null,
							"render": function(data,type,full,meta){
								var btn ='<button class="btn btn-danger btn-xs btn-block" onclick="hapus_data('+data.id_pegawai+','+data.id_penempatan+')"><i class="fa fa-trash"></i> Hapus</button>';
								return btn;
							}
						},
					],
					"order": [[0, 'asc']],
				});
				$('#tambahPenempatan').on("click",function(){
					var id_pegawai = $('#id_pegawai').val();
					var tanggal_awal = $('#tanggal_awal').val();
					var tanggal_akhir = $('#tanggal_akhir').val();
					var lokasi = $('#lokasi').val();
					var jabatan = $('#jabatan').val();
					if(tanggal_awal==''){
						buatNotifikasi4('Peringatan','Tanggal Awal Penempatan Belum diisi!!','error',true);
					}else if(tanggal_akhir==''){
						buatNotifikasi4('Peringatan','Tanggal Akhir Penempatan Belum diisi!!','error',true);
					}else if(lokasi==''){
						buatNotifikasi4('Peringatan','Lokasi Belum diisi!!','error',true);
					}else if(jabatan==''){
						buatNotifikasi4('Peringatan','Jabatan Belum diisi!!','error',true);
					}else{
						var fd = new FormData();
						fd.append("id_pegawai", id_pegawai);
						fd.append("tanggal_awal", tanggal_awal);
						fd.append("tanggal_akhir", tanggal_akhir);
						fd.append("lokasi", lokasi);
						fd.append("jabatan", jabatan);
						$.ajax({
							type: 'POST',
							url: 'ajax_data/save_lokasi_penempatan.php',
							data: fd,
							contentType: false,
							cache: false,
							processData:false,
							success: function(msg){
							 var response = JSON.parse(msg);
							 if(response.code=='success'){
								 PNotify.success({
  					       title: response.title,
  					       text: response.msg,
  					       modules: {
  					         Desktop: {
  					           desktop: true
  					         }
  					       }
  					     });
							 }else{
								 PNotify.error({
						       title: response.title,
						       text: response.msg,
						       modules: {
						         Desktop: {
						           desktop: true
						         }
						       }
						     });
							 }
							 setTimeout(function(){
								 window.location="lokasi_penempatan.php?id="+btoa(response.id_peg);
							 },1000);
							}
						});
					}
				});
				$('#tanggal_awal').datetimepicker({
					format:"YYYY-MM-DD"
				});
				$('#tanggal_akhir').datetimepicker({
					format:"YYYY-MM-DD"
				});
      });
    </script>

  </body>
</html>
