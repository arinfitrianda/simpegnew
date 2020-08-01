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
try {
	$id_pegawai = isset($_GET['id']) ? $_GET['id'] : '';
	$stmt = $db->prepare("SELECT * FROM pegawai WHERE id_pegawai=:id");
	$stmt->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
	$stmt->execute();
	$data_pegawai = $stmt->fetch(PDO::FETCH_ASSOC);
	$akun_name = explode(" ",$data_pegawai['nama']);

	$check_akun = $db->prepare("SELECT * FROM anggota WHERE id_pegawai=:id AND tipe='Pegawai-User'");
	$check_akun->bindParam(":id",$id_pegawai,PDO::PARAM_INT);
	$check_akun->execute();
	$akun = $check_akun->fetch(PDO::FETCH_ASSOC);
	if(!empty($akun_name[1])){
		$user_akun = $akun_name[1];
	}else{
		$user_akun = $akun_name[0];
	}
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
            Pengaturan User
            <small><?php echo $data_pegawai['nama']; ?></small>
          </h1>
          <ol class="breadcrumb">
            <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Pengaturan User</li>
          </ol>
        </section>

        <!-- Main content -->
        <section class="content">
					<div class="row">
						<div class="col-md-6">
							<div class="box box-success">
			            <div class="box-header">
			              <i class="fa fa-user"></i>
			    				  <h3 class="box-title">Form Akun User <?php echo $data_pegawai['nama']; ?></h3>
			            </div><!-- /.box-header -->
			            <form class="" action="#" method="post">
			            <div class="box-body">
										<?php if($check_akun->rowCount()>0){
											$sembunyi ="";	?>
											<div class="alert alert-success alert-dismissible fade in" role="alert">
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
												Berikut dibawah ini data akun yang terdaftar pada sistem,<br> silakan ubah jika ingin mengubah
											</div>
										<?php }else{
											$sembunyi = "hide"; ?>
											<div class="alert alert-warning alert-dismissible fade in" role="alert">
											  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
											    <span aria-hidden="true">&times;</span>
											  </button>
												Belum ada Akun yang terdaftar,<br> silakan isi form dibawah ini untuk membuat akun
											</div>
										<?php	} ?>
			            	<div class="form-group">
			            	  <label for="">Username <span style="color:red">*</span></label>
			            	  <input type="text" class="form-control" id="username" placeholder="Masukan Username" value="<?php echo strtolower($user_akun); ?>" autocomplete="off" readonly>
											<input type="hidden" name="id_pegawai" id="id_pegawai" value="<?php echo $data_pegawai['id_pegawai'] ?>" required>
			            	</div>
										<div class="form-group">
										  <label for="">Password <span style="color:red">*</span></label>
										  <input type="password" class="form-control" id="password" placeholder="Masukan Password Minimal 6 karakter" required>
										</div>
										<div class="form-group">
										  <label for="">Konfirmasi Password <span style="color:red">*</span></label>
										  <input type="password" class="form-control" id="konf_password" placeholder="Masukan Password kembali sesuai dengan yang sebelumnya" required>
										</div>
			            </div>
			            <div class="box-footer">
			                <button type="submit" id="add_akun" class="btn btn-success" name="simpan"><i class="fa fa-save"></i> Simpan</button>
			            </div>
			            </form>
						  </div><!-- /.left column -->
						</div>
						<!-- block kanan -->
						<div class="col-md-6">
							<div class="box box-primary <?php echo $sembunyi; ?>">
			            <div class="box-header">
			              <i class="fa fa-user"></i>
			    				  <h3 class="box-title">Form Aktivasi User <?php echo $data_pegawai['nama']; ?></h3>
			            </div><!-- /.box-header -->
			            <form class="" action="#" method="post">
			            <div class="box-body">
			            	<div class="form-group">
			            	  <label for="">Status Akun User saat ini? <span style="color:red">*</span></label>
			            	  <select id="status_akun" class="form-control" name="status_akun" required>
												<?php
														if($akun['aktif']=='ya'){
															echo '<option value="">---Pilih Status---</option>
															<option value="ya" selected>Aktif</option>
															<option value="tidak">Tidak Aktif</option>';
														}else if($akun['aktif']=='tidak'){
															echo '<option value="">---Pilih Status---</option>
															<option value="ya">Aktif</option>
															<option value="tidak" selected>Tidak Aktif</option>';
														}else{
															echo '<option value="" selected>---Pilih Status---</option>
															<option value="ya">Aktif</option>
															<option value="tidak">Tidak Aktif</option>';
														}
												?>
			            	  </select>
			            	</div>
										<div class="form-group">
										  <label for="">Status Pegawai Saat Ini? <span style="color:red">*</span></label>
											<select id="status_pegawai" class="form-control" name="status_pegawai" required>
												<?php
														if($data_pegawai['aktif']=='y'){
															echo '<option value="">---Pilih Status---</option>
															<option value="y" selected>Aktif</option>
															<option value="t">Tidak Aktif</option>';
														}else if($data_pegawai['aktif']=='t'){
															echo '<option value="">---Pilih Status---</option>
															<option value="y">Aktif</option>
															<option value="t" selected>Tidak Aktif</option>';
														}else{
															echo '<option value="" selected>---Pilih Status---</option>
															<option value="y">Aktif</option>
															<option value="t">Tidak Aktif</option>';
														}
												?>
			            	  </select>
										</div>
			            </div>
			            <div class="box-footer">
			                <button type="button" id="status_button" class="btn btn-primary" name="simpan"><i class="fa fa-save"></i> Simpan</button>
			            </div>
			            </form>
						  </div><!-- /.left column -->
						</div>
					</div>

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
		<script src="../plugins/sweetalert/sweetalert.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../dist/js/app.min.js" type="text/javascript"></script>
    <!-- function provinsi,kecamatan, dll -->
    <script src="ajax_daerah.js" type="text/javascript"></script>
    <!-- page script -->
    <script type="text/javascript">
      $(document).ready(function(){
				function reload_halaman(id,code){
					window.location='conf_user.php?id='+id+'&status='+code;
				}
				$('#add_akun').on("click",function(event){
					event.preventDefault();
					var id_pegawai = $('#id_pegawai').val();
					var user_name = $('#username').val();
					var pass_one = $('#password').val();
					var pass_two = $('#konf_password').val();
					if(pass_two!=pass_one){
						swal({
							title: "Peringatan!",
							text: "Konfirmasi Password tidak sama dengan Password awal",
							icon: "warning",
							button: "OK!",
						}).then((value)=>{
							$('#password').val('');
							$('#konf_password').val('');
						});
					}else{
						var fd = new FormData();
						fd.append("id",id_pegawai);
						fd.append("user",user_name);
						fd.append("pass",pass_two);
						$.ajax({
							type: 'POST',
							url: 'ajax_data/up_user.php',
							data: fd,
							contentType: false,
							cache: false,
							processData:false,
							success: function(response){
								var resp = JSON.parse(response);
								swal({
									title: resp.code,
									text: resp.msg,
									icon: "success",
									button: "OK!",
								}).then((result)=>{
									reload_halaman(resp.id_peg,resp.code);
								});
							}
						});
					}
				});
				$('#status_button').on("click",function(event){
					event.preventDefault();
					var id_pegawai = $('#id_pegawai').val();
					var status_akun = $('#status_akun').val();
					var status_pegawai = $('#status_pegawai').val();
					var formData = new FormData();
					formData.append("id",id_pegawai);
					formData.append("status_akun",status_akun);
					formData.append("status_pegawai",status_pegawai);
					$.ajax({
						type : 'POST',
						url : 'ajax_data/aktifasi_user.php',
						data : formData,
						contentType : false,
						cache : false,
						processData : false,
						success : function(response){
							var resp = JSON.parse(response);
							swal({
								title: resp.code,
								text: resp.msg,
								icon: "success",
								button: "OK!",
							}).then((result)=>{
								reload_halaman(resp.id_peg,resp.code);
							});
						}
					});
				});
			});
    </script>

  </body>
</html>
