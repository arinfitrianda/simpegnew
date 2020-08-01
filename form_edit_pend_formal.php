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
$id_pegawai=isset($_GET["id_pegawai"]) ? $_GET['id_pegawai'] : '';
$id_pendFormal = isset($_GET['id_pendFormal']) ? $_GET['id_pendFormal'] : '';

$getData = $db->prepare("SELECT * FROM pegawai_pend_formal WHERE id_pend_formal=:id_pendFormal AND id_pegawai=:id_pegawai");
$getData->bindParam(":id_pegawai",$id_pegawai);
$getData->bindParam(":id_pendFormal",$id_pendFormal);
$getData->execute();
$data_pendFormal = $getData->fetch(PDO::FETCH_ASSOC);
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
	  <header class="main-header">
        <a href="index.php" class="logo"><b>SIMRS</b><?php echo $version; ?></a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                        <a href="#">
                          <div class="pull-left">
                            <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
                          </div>
                          <h4>
                            Support Team
                            <small><i class="fa fa-clock-o"></i> 5 mins</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li><!-- end message -->
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            AdminLTE Design Team
                            <small><i class="fa fa-clock-o"></i> 2 hours</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Developers
                            <small><i class="fa fa-clock-o"></i> Today</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="../dist/img/user3-128x128.jpg" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Sales Department
                            <small><i class="fa fa-clock-o"></i> Yesterday</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <div class="pull-left">
                            <img src="../dist/img/user4-128x128.jpg" class="img-circle" alt="user image"/>
                          </div>
                          <h4>
                            Reviewers
                            <small><i class="fa fa-clock-o"></i> 2 days</small>
                          </h4>
                          <p>Why not buy a new awesome theme?</p>
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">See All Messages</a></li>
                </ul>
              </li>
              <!-- Notifications: style can be found in dropdown.less -->
              <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-bell-o"></i>
                  <span class="label label-warning">10</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 10 notifications</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-aqua"></i> 5 new members joined today
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the page and may cause design problems
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-users text-red"></i> 5 new members joined
                        </a>
                      </li>

                      <li>
                        <a href="#">
                          <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                        </a>
                      </li>
                      <li>
                        <a href="#">
                          <i class="fa fa-user text-red"></i> You changed your username
                        </a>
                      </li>
                    </ul>
                  </li>
                  <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
              <!-- Tasks: style can be found in dropdown.less -->
              <li class="dropdown tasks-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-flag-o"></i>
                  <span class="label label-danger">9</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 9 tasks</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Design some buttons
                            <small class="pull-right">20%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">20% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Create a nice theme
                            <small class="pull-right">40%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">40% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Some task I need to do
                            <small class="pull-right">60%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">60% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                      <li><!-- Task item -->
                        <a href="#">
                          <h3>
                            Make beautiful transitions
                            <small class="pull-right">80%</small>
                          </h3>
                          <div class="progress xs">
                            <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                              <span class="sr-only">80% Complete</span>
                            </div>
                          </div>
                        </a>
                      </li><!-- end task item -->
                    </ul>
                  </li>
                  <li class="footer">
                    <a href="#">View all tasks</a>
                  </li>
                </ul>
              </li>
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $r1["nama"]; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $r1["nama"]; ?> - <?php echo $r1["tipe"]; ?>
                      <small>Member since Nov. 2012</small>
                    </p>
                  </li>
                  <!-- Menu Body -->
                  <li class="user-body">
                    <div class="col-xs-4 text-center">
                      <a href="#">Followers</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Sales</a>
                    </div>
                    <div class="col-xs-4 text-center">
                      <a href="#">Friends</a>
                    </div>
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="#" class="btn btn-default btn-flat">Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="../logout.php" class="btn btn-default btn-flat">Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header><!-- ./static header -->
	  <?php include "menu_index.php"; ?>
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            DATA PENDIDIKAN FORMAL PEGAWAI
            <small>Form Edit Data Pegawai</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Form Edit Data Pendidikan Formal Pegawai</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
			  <!-- left column -->
			  <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
    				  <h3 class="box-title">Form Edit Data Pendidikan Formal Pegawai</h3>
            </div><!-- /.box-header -->
            <form class="" action="proses_edit_pend_formal.php" enctype="multipart/form-data" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
              <input type="hidden" name="id_pendFormal" value="<?php echo $id_pendFormal; ?>">
            <div class="box-body">
							<div class="alert alert-info">
							  <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
							</div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="form-group">
                      <label for="nip">Tingkat Pendidikan <span style="color:red">*</span></label>
                      <select class="form-control" name="tingkat_pendidikan" id="tingkat_pendidikan" required>
                          <option value="<?php echo $data_pendFormal["tingkat_pendidikan"]?>"><?php echo $data_pendFormal["tingkat_pendidikan"]?></option>
                          <option value="SD">SD</option>
                          <option value="SLTP">SLTP</option>
                          <option value="SLTA">SLTA</option>
                          <option value="D1">D1</option>
                          <option value="D2">D2</option>
                          <option value="D3">D3</option>
                          <option value="S1/D4">S1/D4</option>
                          <option value="S2">S2</option>
                          <option value="S3">S3</option>
                        </select>
                    </div>
                    <div class="form-group">
                      <label for="fakultas">Fakultas<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="fakultas" name="fakultas" value="<?php echo $data_pendFormal["fakultas"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="jurusan">Jurusan<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="jurusan" name="jurusan" value="<?php echo $data_pendFormal["jurusan"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nomor_sttb">Nomor Ijazah/STTB<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="nomor_sttb" name="nomor_sttb" value="<?php echo $data_pendFormal["nomor_sttb"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="tanggal_sttb">Tanggal Ijazah/STTB<span style="color:red">*</span></label>
                      <input type="date" class="form-control" id="tanggal_sttb" name="tanggal_sttb" value="<?php echo $data_pendFormal["tanggal_sttb"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nama_kepsek">Nama Kepala Sekolah/Rektor<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="nama_kepsek" name="nama_kepsek" value="<?php echo $data_pendFormal["nama_kepsek"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nama_sekolah">Nama Sekolah<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="<?php echo $data_pendFormal["nama_sekolah"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="lokasi_sekolah">Lokasi Sekolah<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="lokasi_sekolah" name="lokasi_sekolah" value="<?php echo $data_pendFormal["lokasi_sekolah"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nama_pt">Nama Perguruan Tinggi<span style="color:red">*</span></label>
                      <input type="text" class="form-control" id="nama_pt" name="nama_pt" value="<?php echo $data_pendFormal["nama_perguruan_tinggi"]?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nama_pt">Dokumen Terupload</label><br>
                      <a target='_blank' href="<?php echo $data_pendFormal['url_doc']."/".$data_pendFormal['nama_doc']?>"><?php echo $data_pendFormal['nama_doc']?></a>
                    </div>
                    <div class="form-group">
                      <label for="scan_files">Dokumen</label><br>
                      <input type="file" class="form-control" id="scan_files" name="scan_files">
                      <p class="help-block">(hanya diperbolehkan upload dokumen max 1Mb & tipe file *.pdf)</p>
                    </div>
                  </div>
                </div>
            </div>
                 
            <div class="box-footer">
                <input type="submit" name="submit" value="Simpan" class="btn btn-success">
								<a href="profil_pegawai.php?id=<?php echo $id_pegawai ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
            </div>
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

  </body>
</html>
