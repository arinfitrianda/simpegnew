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
$tahun=isset($_GET["tahun"]) ? $_GET['tahun'] : date('Y');
//mysql data pasien
$h2=$db->query("SELECT pp.*,peg.nama,peg.nip FROM pegawai_penempatan pp INNER JOIN pegawai peg ON(pp.id_pegawai=peg.id_pegawai) WHERE peg.id_depart='".$id_dept."' AND (YEAR(pp.tanggal_awal)='".$tahun."' OR YEAR(pp.tanggal_akhir)='".$tahun."') ORDER BY pp.tanggal_awal,peg.nama");
$data2=$h2->fetchAll(PDO::FETCH_ASSOC);
//EXCEL
header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=export_penempatan_".$tahun.".xls");
?>
Rekap Riwayat Penempatan Tahun <?php echo $tahun; ?>
<table border="1" cellpadding="5" cellspacing="5">
	<thead>
		<tr>
			<th>Nama</th>
			<th>NIP</th>
			<th>Tanggal Awal</th>
			<th>Tanggal Akhir</th>
			<th>Lokasi</th>
			<th>Jabatan</th>
		</tr>
	</thead>
	<tbody>
	<?php
	foreach ($data2 as $r2) {
		echo '<tr>
						<td>'.$r2['nama'].'</td>
						<td>\''.$r2['nip'].'</td>
						<td>'.$r2['tanggal_awal'].'</td>
						<td>'.$r2['tanggal_akhir'].'</td>
						<td>'.$r2['lokasi'].'</td>
						<td>'.$r2['jabatan'].'</td>
				</tr>';
	}
	?>
	</tbody>
</table>
