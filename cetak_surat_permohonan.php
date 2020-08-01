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

$nama_mitra_bestari = $_GET["nama_mitra_bestari"];
$nama_profesi = $_GET["nama_profesi"];

$peg = $db->prepare("SELECT pg.nama as nama_mitra, kr.nama_mitra_bestari, pf.nama_profesi, pg_prof.nama_lengkap, kr.id_pegawai, pg_prof.nama_lengkap , kr.no_surat_permohonan, kr.tgl_surat_permohonan FROM status_kredensial as sk INNER JOIN kredensial as kr ON(sk.id_kredensial=kr.id_kredensial) INNER JOIN pegawai as pg ON kr.nama_mitra_bestari = pg.id_pegawai INNER JOIN pegawai_profil as pg_prof ON kr.id_pegawai = pg_prof.id_peg INNER JOIN profesi pf ON (pg_prof.nama_profesi = pf.id_profesi) WHERE kr.nama_mitra_bestari =:nama_mitra_bestari ");
$peg->bindParam(":nama_mitra_bestari",$nama_mitra_bestari);
$peg->execute();
$pegawai = $peg->fetchAll(PDO::FETCH_ASSOC);
$tanggal = date('d - m - y');
foreach ($pegawai as $y) {
	$nama_profesi = $y["nama_profesi"];
	$nama_mitra = $y["nama_mitra"];
	$no_surat_permohonan = $y["no_surat_permohonan"];
	$tgl_surat_permohonan = $y["tgl_surat_permohonan"];
}

function tgl_indo($tanggal){
	$bulan = array (
		1 =>   'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
	);
	$pecahkan = explode('-', $tanggal);
	
	// variabel pecahkan 0 = tanggal
	// variabel pecahkan 1 = bulan
	// variabel pecahkan 2 = tahun
 
	return $pecahkan[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2];
}

$tanggal = date('d-m-Y');

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>SURAT PERMOHONAN KREDENSIALING <?php echo strtoupper($nama_profesi);?></span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New ;Roman",serif;'>DARI RUMAH SAKIT KE MITRA BESARI</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nomor &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : <?php echo $no_surat_permohonan; ?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Lampiran &nbsp; &nbsp; &nbsp; &nbsp; :&nbsp;</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Perihal &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; : Permohonan Kredensialing <?php echo $nama_profesi; ?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Kepada Yth :</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'><?php echo $nama_mitra; ?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Dengan Hormat,</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Dalam rangka menunjang pelayanan kesehatan dengan mengutamakan aspek keselamatan pasien, maka Rumah Sakit Khusus Ibu dan Anak. mengajukan permohonan untuk melakukan kredensialing untuk mendapatkan penugasan klinis terhadap Rumah Sakit Khusus Ibu dan Anak sebanyak <?php echo count($pegawai); ?> orang yaitu :</span></p>
<ol style="list-style-type: decimal;margin-left:11.3px;">
<?php
foreach ($pegawai as $f) {
	$no = 0;
	$nama = $f["nama_lengkap"];
?>
    <li><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'><?php echo $nama?></span></li>
<?php
}
?>
</ol>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Demikianlah permohonan ini kami sampaikan.</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Atas perhatiannya diucapkan terima kasih.</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<table style="width:517.4pt;margin-left:-22.95pt;border-collapse:collapse;border: none;">
    <tbody>
        <tr>
            <td style="width: 163.05pt;border: 0pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td class="fr-cell-handler " style="width: 163pt;border-top: 0pt solid windowtext;border-right: 0pt solid windowtext;border-bottom: 0pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td class="fr-cell-fixed " style="width: 191.35pt;border-top: 0pt solid windowtext;border-right: 0pt solid windowtext;border-bottom: 0pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Bandung, <?php echo tgl_indo($tgl_surat_permohonan) ?></span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Ketua Komite Umum</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Dwi Edriyanti,M.Psi.Psikolog</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>NIP. 197007012010 01 2 001</span></p>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>

<script type="text/javascript">
	window.print()
</script>