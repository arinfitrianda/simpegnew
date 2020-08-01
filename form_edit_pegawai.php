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
$id_pegawai = isset($_GET['d']) ? $_GET['d'] : '';
try {
	$dept = $db->query("SELECT * FROM departemen");
	$d = $dept->fetchAll(PDO::FETCH_ASSOC);

  $profesi = $db->query("SELECT * FROM profesi");
  $get_profesi = $profesi->fetchAll(PDO::FETCH_ASSOC);
  //get data master
  $master = $db->prepare("SELECT * FROM pegawai_profil pro INNER JOIN pegawai peg ON(peg.id_pegawai=pro.id_peg) WHERE pro.id_peg=:id");
  $master->bindParam(":id",$id_pegawai);
  $master->execute();
  $m = $master->fetch(PDO::FETCH_ASSOC);
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
            DATA PEGAWAI
            <small>Form Edit Data Pegawai</small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Form Edit Data Pegawai</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">

              <!-- general form elements -->
			  <!-- left column -->
			  <div class="box">
            <div class="box-header">
              <i class="fa fa-user"></i>
    				  <h3 class="box-title">Form Edit Data Pegawai</h3>
            </div><!-- /.box-header -->
            <form class="" action="edit_pegawai.php" method="post">
              <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
            <div class="box-body">
							<div class="alert alert-info">
							  <strong>Info!</strong> Field yang bertanda kan <span style="color:red">*</span> wajib diisi.
							</div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="nip">Nomor Induk Pegawai <span style="color:red">*</span></label>
                      <input type="text" name="nip" class="form-control" id="nip" placeholder="Masukan Nomor Induk Pegawai disini." value="<?php echo $m['nip']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="ktp">Nomor KTP <span style="color:red">*</span></label>
                      <input type="text" name="ktp" class="form-control" id="ktp" placeholder="Masukan Nomor KTP disini." value="<?php echo $m['ktp']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="npwp">NPWP</label>
                      <input type="text" name="npwp" class="form-control" id="npwp" placeholder="Masukan NPWP disini." value="<?php echo $m['npwp']; ?>">
                    </div>
										<div class="form-group">
                      <label for="askes">Nomor Askes <span style="color:red">*</span></label>
                      <input type="text" name="askes" class="form-control" id="askes" placeholder="Masukan Nomor Askes disini." value="<?php echo $m['askes']; ?>" required>
                    </div>
										<div class="form-group">
											<div class="col-md-6 col-lg-6">
												<div class="form-group">
													<label for="status_pegawai">Status Pegawai <span style="color:red">*</span></label>
		                      <select class="form-control" name="status_pegawai" required>
		                        <?php
		                          if($m['status_pegawai']=='CPNS'){
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }elseif ($m['status_pegawai']=='PNS') {
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\">CPNS</option>
		          												<option value=\"PNS\" selected>PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }elseif ($m['status_pegawai']=='BLUD') {
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\" selected>BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }elseif ($m['status_pegawai']=='PTT') {
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\" selected>PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }elseif ($m['status_pegawai']=='SECURITY') {
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\" selected>SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }elseif ($m['status_pegawai']=='CS') {
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\" selected>CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }elseif ($m['status_pegawai']=='Lainnya') {
		                            echo "<option value=\"\">Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\" selected>Lainnya</option>";
		                          }else{
		                            echo "<option value=\"\" selected>Pilih Status Pegawai</option>
		          												<option value=\"CPNS\" selected>CPNS</option>
		          												<option value=\"PNS\">PNS</option>
		          												<option value=\"BLUD\">BLUD</option>
		          												<option value=\"PTT\">PTT</option>
		          												<option value=\"SECURITY\">SECURITY</option>
		          												<option value=\"CS\">CS</option>
		          												<option value=\"Lainnya\">Lainnya</option>";
		                          }
		                        ?>
		                      </select>
												</div>
											</div>
											<div class="col-md-6 col-lg-6">
												<div class="form-group">
													<label for="tmt_pegawai">TMT Pegawai <span style="color:red">*</span></label>
                          <input type="date" name="tmt_pegawai" class="form-control" id="tmt_pegawai" placeholder="Masukan TMT Pegawai disini." value="<?php echo $m['tmt_pegawai']; ?>" required>
												</div>
											</div>
                    </div>
										<div class="form-group">
                      <label for="unit_kerja">Unit Kerja <span style="color:red">*</span></label>
                      <select class="form-control" name="unit_kerja" required>
                      	<option value="">Pilih Unit Kerja</option>
												<?php
												foreach ($d as $unit) {
                          if($m['id_depart']==$unit['id_dept']){
                            echo "<option value='".$unit['id_dept']."' selected>".$unit['nama_dept']."</option>";
                          }else{
                            echo "<option value='".$unit['id_dept']."'>".$unit['nama_dept']."</option>";
                          }

												}
												?>
                      </select>
                    </div>
										<div class="form-group">
                      <label for="jenis_jabatan">Jenis Jabatan <span style="color:red">*</span></label>
                      <input type="text" name="jenis_jabatan" class="form-control" id="jenis_jabatan" placeholder="Masukan Jenis Jabatan disini." value="<?php echo $m['jenis_jabatan']; ?>" required>
                    </div>
										<div class="form-group">
                      <label for="nama_jabatan">Nama Jabatan <span style="color:red">*</span></label>
                      <input type="text" name="nama_jabatan" class="form-control" id="nama_jabatan" placeholder="Masukan Nama Jabatan disini." value="<?php echo $m['nama_jabatan'] ?>" required>
                    </div>
										<div class="form-group">
                      <label for="tmt_jabatan">TMT Jabatan <span style="color:red">*</span></label>
                      <input type="date" name="tmt_jabatan" class="form-control" id="tmt_jabatan" placeholder="Masukan TMT Jabatan disini." value="<?php echo $m['tmt_jabatan']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="jenis_profesi">Jenis Profesi <span style="color:red">*</span></label>
                      <input type="text" name="jenis_profesi" class="form-control" id="jenis_profesi" placeholder="Masukan Jenis Profesi disini." value="<?php echo $m['jenis_profesi']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="nama_profesi">Nama Profesi <span style="color:red">*</span></label>
                      <select class="form-control" name="nama_profesi" required>
                        <option value="">Pilih Profesi</option>
                        <?php
                        foreach ($get_profesi as $profesi) {
                            echo "<option value='".$profesi['nama_profesi']."'>".$profesi['nama_profesi']."</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
											<div class="col-md-4 col-lg-4">
												<div class="form-group">
													<label for="prefix">Gelar Depan </label>
		                      <input type="text" name="prefix" class="form-control" id="prefix" placeholder="Masukan Gelar Depan disini." value="<?php echo $m['prefix']; ?>">
												</div>
											</div>
											<div class="col-md-4 col-lg-4">
												<div class="form-group">
													<label for="nama_lengkap">Nama Lengkap <span style="color:red">*</span></label>
		                      <input type="text" name="nama_lengkap" class="form-control" id="nama_lengkap" placeholder="Masukan Nama Lengkap disini." value="<?php echo $m['nama_lengkap']; ?>" required>
												</div>
											</div>
											<div class="col-md-4 col-lg-4">
												<div class="form-group">
													<label for="postfix">Gelar Belakang</label>
		                      <input type="text" name="postfix" class="form-control" id="postfix" placeholder="Masukan Gelar Belakang disini." value="<?php echo $m['postfix']; ?>" required>
												</div>
											</div>

                    </div>
                    <!-- block ttl -->
                    <div class="form-group">
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="tempat_lahir">Tempat Lahir <span style="color:red">*</span></label>
                          <input type="text" name="tempat_lahir" class="form-control" id="tempat_lahir" placeholder="Masukan Tempat lahir disini." value="<?php echo $m['tempat_lahir']; ?>" required>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="form-group">
                          <label for="tanggal_lahir">Tanggal Lahir <span style="color:red">*</span></label>
                          <input type="date" name="tanggal_lahir" class="form-control" id="tanggal_lahir" placeholder="Masukan Tanggal Lahir disini." value="<?php echo $m['tanggal_lahir']; ?>" required>
                        </div>
                      </div>
                    </div>
                    <!-- end block ttl -->
                    <div class="form-group">
                      <label for="jk">Jenis Kelamin <span style="color:red">*</span></label>
                      <select class="form-control" name="jk" required>
                        <?php
                          if($m['jenis_kelamin']=='L'){
                            echo "<option value=\"\">Pilih Jenis Kelamin</option>
                                  <option value=\"L\" selected>Laki-Laki</option>
                                  <option value=\"P\">Perempuan</option>";
                          }elseif ($m['jenis_kelamin']=='P') {
                            echo "<option value=\"\">Pilih Jenis Kelamin</option>
                                  <option value=\"L\">Laki-Laki</option>
                                  <option value=\"P\" selected>Perempuan</option>";
                          }else{
                            echo "<option value=\"\" selected>Pilih Jenis Kelamin</option>
                                  <option value=\"L\">Laki-Laki</option>
                                  <option value=\"P\">Perempuan</option>";
                          }
                         ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="status_kawin">Status Perkawinan <span style="color:red">*</span></label>
                      <select class="form-control" name="status_perkawinan" required>
                        <?php
                          if($m['status_perkawinan']=='Kawin'){
                            echo "<option value=\"\">Pilih Status Perkawinan</option>
                                  <option value=\"Kawin\" selected>Kawin</option>
                                  <option value=\"Belum Kawin\">Belum Kawin</option>
                                  <option value=\"Janda\">Janda</option>
          												<option value=\"Duda\">Duda</option>";
                          }elseif ($m['status_perkawinan']=='Belum Kawin') {
                            echo "<option value=\"\">Pilih Status Perkawinan</option>
                                  <option value=\"Kawin\">Kawin</option>
                                  <option value=\"Belum Kawin\" selected>Belum Kawin</option>
                                  <option value=\"Janda\">Janda</option>
          												<option value=\"Duda\">Duda</option>";
                          }elseif ($m['status_perkawinan']=='Janda') {
                            echo "<option value=\"\">Pilih Status Perkawinan</option>
                                  <option value=\"Kawin\" selected>Kawin</option>
                                  <option value=\"Belum Kawin\">Belum Kawin</option>
                                  <option value=\"Janda\" selected>Janda</option>
          												<option value=\"Duda\">Duda</option>";
                          }elseif ($m['status_perkawinan']=='Duda') {
                            echo "<option value=\"\">Pilih Status Perkawinan</option>
                                  <option value=\"Kawin\" selected>Kawin</option>
                                  <option value=\"Belum Kawin\">Belum Kawin</option>
                                  <option value=\"Janda\">Janda</option>
          												<option value=\"Duda\" selected>Duda</option>";
                          }else{
                            echo "<option value=\"\" selected>Pilih Status Perkawinan</option>
                                  <option value=\"Kawin\" selected>Kawin</option>
                                  <option value=\"Belum Kawin\">Belum Kawin</option>
                                  <option value=\"Janda\">Janda</option>
          												<option value=\"Duda\">Duda</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="agama">Agama <span style="color:red">*</span></label>
                      <select class="form-control" name="agama" required>
                        <?php
                          if($m['agama']=='islam'){
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\" selected>Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }elseif ($m['agama']=='kristen katolik') {
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\">Islam</option>
                                  <option value=\"kristen katolik\" selected>Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }elseif ($m['agama']=='kristen protestan') {
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\">Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\" selected>Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }elseif ($m['agama']=='buddha') {
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\" selected>Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\" selected>Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }elseif ($m['agama']=='hindu') {
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\" selected>Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\" selected>Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }elseif ($m['agama']=='konghucu') {
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\" selected>Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\" selected>Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }elseif ($m['agama']=='lainnya') {
                            echo "<option value=\"\">Pilih Agama</option>
                                  <option value=\"islam\" selected>Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\" selected>Lainnya</option>";
                          }else{
                            echo "<option value=\"\" selected>Pilih Agama</option>
                                  <option value=\"islam\" selected>Islam</option>
                                  <option value=\"kristen katolik\">Kristen Katolik</option>
                                  <option value=\"kristen protestan\">Kristen Protestan</option>
                                  <option value=\"buddha\">Buddha</option>
                                  <option value=\"hindu\">Hindu</option>
                                  <option value=\"konghucu\">Konghucu</option>
          												<option value=\"lainnya\">Lainnya</option>";
                          }
                        ?>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="golongan_darah">Golongan Darah <span style="color:red">*</span></label>
                      <select class="form-control" name="golongan_darah" required>
												<?php
													if($m['golongan_darah']=='A'){
														echo "<option value=\"\">Pilih Golongan Darah</option>
		                        <option value=\"A\" selected>A</option>
		                        <option value=\"B\">B</option>
		                        <option value=\"AB\">AB</option>
		                        <option value=\"O\">O</option>";
													}elseif ($m['golongan_darah']=='B') {
														echo "<option value=\"\">Pilih Golongan Darah</option>
		                        <option value=\"A\">A</option>
		                        <option value=\"B\" selected>B</option>
		                        <option value=\"AB\">AB</option>
		                        <option value=\"O\">O</option>";
													}elseif ($m['golongan_darah']=='AB') {
														echo "<option value=\"\">Pilih Golongan Darah</option>
		                        <option value=\"A\" selected>A</option>
		                        <option value=\"B\">B</option>
		                        <option value=\"AB\" selected>AB</option>
		                        <option value=\"O\">O</option>";
													}elseif ($m['golongan_darah']=='O') {
														echo "<option value=\"\">Pilih Golongan Darah</option>
		                        <option value=\"A\" selected>A</option>
		                        <option value=\"B\">B</option>
		                        <option value=\"AB\">AB</option>
		                        <option value=\"O\" selected>O</option>";
													}else{
														echo "<option value=\"\" selected>Pilih Golongan Darah</option>
		                        <option value=\"A\" selected>A</option>
		                        <option value=\"B\">B</option>
		                        <option value=\"AB\">AB</option>
		                        <option value=\"O\">O</option>";
													}
												?>
                      </select>
                    </div>
										<div class="form-group">
                      <label for="pendidikan_awal">Pendidikan Awal <span style="color:red">*</span></label>
                      <input type="text" name="pendidikan_awal" class="form-control" id="pendidikan_awal" placeholder="Masukan Pendidikan Awal disini." value="<?php echo $m['pend_awal']; ?>" required>
                    </div>
										<div class="form-group">
                      <label for="tahun_pendidikan_awal">Tahun Pendidikan Awal <span style="color:red">*</span></label>
                      <input type="text" name="tahun_pendidikan_awal" class="form-control" id="tahun_pendidikan_awal" placeholder="Masukan Tahun Pendidikan Awal disini." value="<?php echo $m['tahun_pend_awal']; ?>" required>
                    </div>
										<div class="form-group">
                      <label for="pendidikan_akhir">Pendidikan Akhir <span style="color:red">*</span></label>
                      <input type="text" name="pendidikan_akhir" class="form-control" id="pendidikan_akhir" placeholder="Masukan Pendidikan Akhir disini." value="<?php echo $m['pend_akhir']; ?>" required>
                    </div>
										<div class="form-group">
                      <label for="tahun_pendidikan_akhir">Tahun Pendidikan Akhir <span style="color:red">*</span></label>
                      <input type="text" name="tahun_pendidikan_akhir" class="form-control" id="tahun_pendidikan_akhir" placeholder="Masukan Tahun Pendidikan Akhir disini."  value="<?php echo $m['tahun_pend_akhir']; ?>" required>
                    </div>
                  </div>
                  <div class="col-md-6">
										<div class="form-group">
                      <label for="alamat">Alamat <span style="color:red">*</span></label>
                      <input type="text" name="alamat" class="form-control" id="alamat" placeholder="Masukan Alamat disini." value="<?php echo $m['alamat']; ?>" required>
                    </div>
										<div class="form-group">
                      <label for="provinsi">Provinsi <span style="color:red">*</span></label>
                      <select class='form-control' name="prop" id="prop" onchange="ajaxkota(this.value)">
                        <option value="">Pilih Provinsi</option>
                        <?php
                        $query=$db->prepare("SELECT id,name FROM provinsi ORDER BY name");
                        $query->execute();
                        while ($data=$query->fetchObject()){
                        echo '<option value="'.$data->id.'">'.$data->name.'</option>';
                        }
                        ?>
                      <select>
                    </div>
                    <div class="form-group" id="box-kota">
                      <label for="kota">Kota/Kabupaten <span style="color:red">(Pilih Provinsi Terlebih Dahulu)*</span></label>
                      <select class='form-control' name="kota" id="kota" onchange="ajaxkec(this.value)">
                        <option value="">Pilih Kota</option>
                      </select>
                    </div>
                    <div class="form-group" id="box-kecamatan">
                      <label for="kota">Kecamatan <span style="color:red">(Pilih Kota/Kabupaten Terlebih Dahulu)*</span></label>
                      <select name="kec" id="kec" class="form-control" onchange="ajaxkel(this.value)">
                        <option value="">Pilih Kecamatan</option>
                      </select>
                    </div>
                    <div class="form-group" id="box-kelurahan">
                      <label for="kota">Kelurahan <span style="color:red">(Pilih Kecamatan Terlebih Dahulu)*</span></label>
                      <select name="kel" id="kel" class="form-control">
                        <option value="">Pilih Kelurahan</option>
                      </select>
                    </div>
                    <div class="form-group">
                      <label for="kode_pos">Kode Pos <span style="color:red">*</span></label>
                      <input type="text" name="kode_pos" class="form-control" id="kode_pos" placeholder="Masukan Kode Pos Disini." value="<?php echo $m['kode_pos']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="email">Email <span style="color:red">*</span></label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Masukan Email disini." value="<?php echo $m['email_address']; ?>" required>
                    </div>
                    <div class="form-group">
                      <label for="telepon">Telepon <span style="color:red">*</span></label>
                      <input type="text" name="telepon" class="form-control" id="telepon" placeholder="Masukan Nomor Telepon Disini." value="<?php echo $m['telepon']; ?>" required>
                    </div>
										<div class="form-group">
                      <label for="wea">No.WA </label>
                      <input type="text" name="wea" class="form-control" id="wea" placeholder="Masukan Nomor Whatsapp Disini." value="<?php echo $m['no_wea']; ?>">
                    </div>
                  </div>
                </div>

            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
								<a href=".php?id=<?php echo $id_pegawai ?>" class="btn btn-danger"><i class="fa fa-times-circle"></i> Batal</a>
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
