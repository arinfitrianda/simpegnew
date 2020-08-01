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
$bagian=$_GET["bagian"];
$gabung=$_GET["gabung"];
//mysql data pasien
$h2=$db->query("SELECT * FROM pegawai WHERE foto='$bagian' AND aktif='y'");
$data2=$h2->fetchAll();
//EXCEL
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=export.xls");
?>
Rekap absen per <?php echo $gabung; ?>
<table id="example1" class="table table-bordered table-striped" border="1">
                    <thead>
                      <tr>
                        <th>Nomer</th>
						<th>ID Pegawai</th>
                        <th>Nama</th>
						<th>NIP</th>
						<th>Status</th>
						<th>Jam</th>
						<th>Menit</th>
						<th>Jam Kerja</th>
						<th>Hari Bekerja</th>
                      </tr>
                    </thead>
                    <tbody>
<?php
$nomer=1;
foreach ($data2 as $r2) {
	$h3=$db->query("SELECT * FROM absen WHERE id_pegawai='".$r2['id_pegawai']."' AND tanggald LIKE '%$gabung%' AND status='2'");
	$numrow3 = $h3->rowCount();
	$data3=$h3->fetchAll();
	$subtot=0;
	$dSelisih=0;
	foreach ($data3 as $r3) {
		list($h,$m) = explode(":",$r3['kerjap']);
		$jamkemenit=$h*60;
		$dSelisih=$jamkemenit+$m;
		$subtot=$subtot+$dSelisih;
	}
	$kerjatot = sprintf("%02d jam %02d menit", floor($subtot/60), $subtot%60);
	$jam = sprintf("%02d", floor($subtot/60));
	$menit = sprintf("%02d", $subtot%60);
	echo("
	<tr>
			<td>".$nomer++."</td>
			<td>".$r2['id_pegawai']."</td>
			<td>".$r2['nama']."</td>
	    <td>'".$r2['nip']."</td>
	    <td>".$r2['status']."</td>
			<td>".$jam."</td>
	    <td>".$menit."</td>
	    <td>$kerjatot</a></td>
	    <td>$numrow3</a></td>
	</tr>
	");
}
?>
                    </tbody>
                  </table>
