     
     <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
              <p><?php echo $r1["nama"]; ?></p>

              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <?php  if($role=='Admin'){ ?>
              <li><a href="master.php"><i class="fa fa-book"></i> Data Pegawai</a></li>
              <li><a href="datarekap.php"><i class="fa fa-user"></i> Rekap Absen</a></li>
            <?php  }else if($role=='operator'){ ?>
              <li><a href="master.php"><i class="fa fa-book"></i> Data Pegawai</a></li>
              <li><a href="rekap_penempatan.php"><i class="fa fa-book"></i> Rekap Riwayat Penempatan</a></li>
            <?php }else if($parts=='User'){ ?>
              <li><a href="profil_pegawai_user.php?id=<?php echo $id_pegawai ?>"><i class="fa fa-book"></i> Data Pegawai</a></li>
              <li><a href="asesmen_asesi.php?id=<?php echo $id_pegawai ?>"><i class="fa fa-book"></i> Permohonan Kemampuan Klinis</a></li>
              <li><a href="pengajuan_kredensial.php?id=<?php echo $id_pegawai ?>"><i class="fa fa-book"></i> Pengajuan Kredensial</a></li>
              <li><a href="jadwal_kredensial_user.php?id=<?php echo $id_pegawai ?>"><i class="fa fa-book"></i> Jadwal Kredensial</a></li>
              <!-- <li><a href="rekap_penempatan.php"><i class="fa fa-book"></i> Rekap Riwayat Penempatan</a></li> -->
            <?php }else if($parts=='Sub_Komite'){ ?>
              <li><a href="master.php"><i class="fa fa-book"></i> Data Pegawai</a></li>
              <li><a href="set_mitra_bestari.php"><i class="fa fa-book"></i>Pengaturan Mitra Bestari</a></li>
              <li><a href="peserta_kredensial.php"><i class="fa fa-book"></i>Data Peserta Kredensial</a></li>
              <!-- <li><a href="rekap_penempatan.php"><i class="fa fa-book"></i> Rekap Riwayat Penempatan</a></li> -->
            <?php }else if($parts=='Mitra_Bestari'){ ?>
              <li><a href="peserta_kredensial.php"><i class="fa fa-book"></i> Data Peserta Kredensial</a></li>
              <!-- <li><a href="set_mitra_bestari.php"><i class="fa fa-book"></i>Pengaturan Mitra Bestari</a></li> -->
              <!-- <li><a href="rekap_penempatan.php"><i class="fa fa-book"></i> Rekap Riwayat Penempatan</a></li> -->
            <?php }else if($parts=='Komite_Umum'){ ?>
              <li><a href="master.php"><i class="fa fa-book"></i> Data Pegawai</a></li>
              <li><a href="peserta_kredensial.php"><i class="fa fa-book"></i> Data Peserta Kredensial</a></li>
              <!-- <li><a href="set_mitra_bestari.php"><i class="fa fa-book"></i>Pengaturan Mitra Bestari</a></li> -->
              <!-- <li><a href="rekap_penempatan.php"><i class="fa fa-book"></i> Rekap Riwayat Penempatan</a></li> -->
            <?php }else{ }?>
      			<li><a href="../logout.php"><i class="fa fa-lock"></i> Logout</a></li>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>
