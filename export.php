<?php
session_start();
include("../inc/pdo.conf.php");
include("../inc/version.php");
$namauser = $_SESSION['namauser'];
$password = $_SESSION['password'];
$tipes = explode('-',$_SESSION['tipe']);
$role = $tipes[1];
if ($tipes[0]!='Simpeg')
{
	unset($_SESSION['tipe']);
	unset($_SESSION['namauser']);
	unset($_SESSION['password']);
	header("location:../index.php?status=2");
	exit;
}
include "../inc/anggota_check.php";
$id=$_GET["id"];
$gabung=$_GET["gabung"];
//mysql data pasien
$h2=$db->query("SELECT * FROM absen WHERE id_pegawai='$id' AND tanggald LIKE '%$gabung%' AND status='2'");
$data2=$h2->fetchAll();
$h3=$db->query("SELECT * FROM pegawai WHERE id_pegawai='$id'");
$data3=$h3->fetch(PDO::FETCH_ASSOC);
$nama=$data3["nama"];
//EXCEL
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=export.xls");
?>
Rekap absen <?php echo $nama; ?> per <?php echo $gabung; ?>
<table id="example1" class="table table-bordered table-striped" border="1">
                    <thead>
                      <tr>
                        <th>Nomer</th>
                        <th>Tanggal Datang</th>
												<th>Jam Datang</th>
												<th>Tanggal Pulang</th>
												<th>Jam Pulang</th>
												<th>Jam Kerja</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$nomer=1;
$subtot=0;
foreach ($data2 as $r2) {
	echo("
	<tr>
	    <td>".$nomer++."</td>
			<td>".$r2['tanggald']."</td>
	    <td>".$r2['datang']."</td>
	    <td>".$r2['tanggalp']."</td>
	    <td>".$r2['pulang']."</td>
	    <td>".$r2['kerja']."</td>
	</tr>
	");
	list($h,$m) = explode(":",$r2['kerjap']);
	$jamkemenit=$h*60;
	$dSelisih=$jamkemenit+$m;
	$subtot=$subtot+$dSelisih;
}
$kerjatot = sprintf("%02d jam %02d menit", floor($subtot/60), $subtot%60);
?>
                    </tbody>
					<tfoot>
					  <tr><td colspan="5" align="right"><b>Total Jam Kerja</b></td><td><?php echo $kerjatot; ?></td></tr>
					</tfoot>
                  </table>
