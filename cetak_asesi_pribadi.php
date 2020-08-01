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

$id_pegawai = isset($_GET['id']) ? $_GET['id'] : '';
$master = $db->prepare("SELECT * FROM pegawai peg INNER JOIN pegawai_profil peg_pro ON (peg.id_pegawai=peg_pro.id_peg)  INNER JOIN profesi pf ON (peg_pro.nama_profesi = pf.id_profesi) WHERE peg.id_pegawai=:id");
$master->bindParam(":id",$id_pegawai);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);
$id_profesi = $m["id_profesi"];
// echo "ini $id_profesi";

$queryPegawai = $db->query("SELECT * FROM pegawai ");
$data = $queryPegawai->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>FORMULIR 3&nbsp;</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;PERMOHONAN RINCIAN KEWENANGAN KLINIS APOTEKER</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nama &nbsp;&nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <?php echo $m["nama"];?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tahun Lulus&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;:</span></p>
<table style="width:460.45pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td rowspan="2" style="width:33.1pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>No.</span></strong></p>
            </td>
            <td rowspan="2" style="width:189.15pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Rincian Kewenangan Klinis</span></strong></p>
            </td>
            <td colspan="3" style="width:238.2pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Permohonan Kemampuan Klinis</span></strong></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>(diisi oleh Assesi)</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:75.2pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>1</span></p>
            </td>
            <td style="width:77.95pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;background:#D9D9D9;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;color:black;'>2</span></p>
            </td>
            <td style="width:3.0cm;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>3</span></p>
            </td>
        </tr>
        	<?php
        	$queryKompetensi  = $db->prepare("SELECT * FROM `asesi_pribadi` ap INNER JOIN asesmen_kompetensi ak ON (ap.id_kompetensi = ak.id_kompetensi) INNER JOIN cek_asesi ca ON(ap.id_profesi = ca.id_profesi) WHERE status_kredensial=0 AND ca.id_pegawai=:id_pegawai");
        	$queryKompetensi->bindParam(":id_pegawai", $id_pegawai);
        	$queryKompetensi->execute();
        	$dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);
        	$no=1;
        	$nomor=1;
        	foreach ($dataKompetensi as $dk){?>
        	<tr>
            <td style="width: 33.1pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'><?php echo $no++?></span></p>
            </td>
            <td style="width: 189.15pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'><?php echo $dk['sub_soal'] ?></span></p>
            </td>
            <td style="width:75.2pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Courier New";'><?php if($dk['jawaban_asesi'] == '1'){?>&radic;<?php }?></span></p>
            </td>
            <td style="width:75.2pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Courier New";'><?php if($dk['jawaban_asesi'] == '2'){?>&radic;<?php }?></span></p>
            </td>
           <td style="width:75.2pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Courier New";'><?php if($dk['jawaban_asesi'] == '3'){?>&radic;<?php }?></span></p>
            </td>
            <?php
        	}
        	?>
        
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>&nbsp;</p>
</body>
</html>