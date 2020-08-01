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
$nama = $_POST["nama"];
$nama_mitra_bestari = $_POST["nama_mitra_bestari"];
$aspek_kredensial = $_POST["aspek_kredensial"];
$pencatatan_asesmen =  $_POST["pencatatan_asesmen"];
$saran_perbaikan =  $_POST["saran_perbaikan"];
$id_pegawai =  $_POST["id_pegawai"];
$id_kredensial =  $_POST["id_kredensial"];
$create_at = date('Y-m-d H:i:s');

$update_status = $db->prepare("UPDATE `status_kredensial` SET `surat_laporan_asesmen`=1,`tgl_surat_laporan_asesmen`=:create_at WHERE id_kredensial=:id_kredensial AND id_pegawai=:id_pegawai");
$update_status->BindParam(":id_pegawai", $id_pegawai);
$update_status->BindParam(":id_kredensial", $id_kredensial);
$update_status->BindParam(":create_at", $create_at);
$update_status->execute();
?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<center><h5 style='margin:0cm;margin-bottom:12.0pt;text-align:left;font-size:13px;font-family:"Arial",sans-serif;'><span style='font-size:19px;font-family:"Calibri",sans-serif;'></span><span style='font-size:19px;font-family:"Calibri",sans-serif;'>&nbsp;</span><span style='font-size:19px;font-family:"Calibri",sans-serif;'>FORMULIR LAPORAN ASESMEN</span></h5></center>
<table style="width: 4.7e+2pt;margin-left:5.4pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td rowspan="2" style="width:120.5pt;border-top:1.5pt;border-left:  1.5pt;border-bottom:1.0pt;border-right:1.0pt;border-color:windowtext;border-style:solid;padding:0cm 5.4pt 0cm 5.4pt;height:  22.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:1.7pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>Skema Sertifikasi/ Klaster Asesmen</span></p>
            </td>
            <td style="width: 2cm;border-top: 1.5pt solid windowtext;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 22.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:1.7pt;'><span style='font-family:  "Franklin Gothic Medium",sans-serif;'>Judul</span></p>
            </td>
            <td style="width:14.2pt;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:22.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>:</span></p>
            </td>
            <td style="width:276.4pt;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:  0cm 5.4pt 0cm 5.4pt;height:22.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 2cm;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 22.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:1.7pt;'><span style='font-family:  "Franklin Gothic Medium",sans-serif;'>Nomor</span></p>
            </td>
            <td style="width:14.2pt;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:22.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>:</span></p>
            </td>
            <td style="width:276.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;height:22.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:177.2pt;border-top:none;border-left:  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:  solid windowtext 1.0pt;padding:  0cm 5.4pt 0cm 5.4pt;height:20.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:1.7pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>TUK</span></p>
            </td>
            <td style="width: 14.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 20.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;text-align:center;text-indent:-8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>:</span></p>
            </td>
            <td style="width:276.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;height:20.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>Sewaktu/Tempat Kerja/Mandiri</span><span style='font-family:"Franklin Gothic Medium",sans-serif;'>*</span><span style='font-family:"Franklin Gothic Medium",sans-serif;'>)</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:177.2pt;border-top:none;border-left:  solid windowtext 1.5pt;border-bottom:solid windowtext 1.0pt;border-right:  solid windowtext 1.0pt;padding:  0cm 5.4pt 0cm 5.4pt;height:20.95pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:1.7pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>Nama Asesor</span></p>
            </td>
            <td style="width: 14.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 20.95pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;text-align:center;text-indent:-8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>:</span></p>
            </td>
            <td style="width:276.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;height:20.95pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'><?php echo $nama_mitra_bestari?></span></p>
            </td>
        </tr>
        <tr>
            <td colspan="2" style="width:177.2pt;border-top:none;border-left:  solid windowtext 1.5pt;border-bottom:solid windowtext 1.5pt;border-right:  solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:20.85pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:1.7pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>Tanggal</span></p>
            </td>
            <td style="width: 14.2pt;border-top: none;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 20.85pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;text-align:center;text-indent:-8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>:</span></p>
            </td>
            <td style="width:276.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.5pt;padding:0cm 5.4pt 0cm 5.4pt;height:20.85pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-left:8.8pt;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><em><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>*</span></em><em><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>)&nbsp;</span></em><em><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;Coret yang tidak perlu</span></em></p>
<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
<table style="width: 4.7e+2pt;margin-left:5.4pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width:1.0cm;border-top:1.5pt;border-left:1.5pt;border-bottom:1.0pt;border-right:1.0pt;border-color:black;border-style:solid;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;height:37.15pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>No.</span></strong></p>
            </td>
            <td style="width:177.2pt;border-top:solid black 1.5pt;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;height:37.15pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>Nama Peserta</span></strong></p>
            </td>
            <td style="width:35.45pt;border-top:solid black 1.5pt;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;height:37.15pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>K</span></strong></p>
            </td>
            <td style="width:35.45pt;border-top:solid black 1.5pt;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;height:37.15pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>BK</span></strong></p>
            </td>
            <td style="width:191.35pt;border-top:solid black 1.5pt;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.5pt;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;height:37.15pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>Keterangan</span></strong><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>**</span></strong><strong><span style='font-size:15px;font-family:  "Franklin Gothic Medium",sans-serif;color:black;'>)</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border-top:none;border-left:solid black 1.5pt;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:26.05pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>1.</span></p>
            </td>
            <td style="width: 177.2pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'><?php echo $nama ?></span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 191.35pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border-top:none;border-left:solid black 1.5pt;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:26.05pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>2.</span></p>
            </td>
            <td style="width: 177.2pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 191.35pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border-top:none;border-left:solid black 1.5pt;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:26.05pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>3.</span></p>
            </td>
            <td style="width: 177.2pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 191.35pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border-top:none;border-left:solid black 1.5pt;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:26.05pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>4.</span></p>
            </td>
            <td style="width: 177.2pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 191.35pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border-top:none;border-left:solid black 1.5pt;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:26.05pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>5.</span></p>
            </td>
            <td style="width: 177.2pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 191.35pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border-top:none;border-left:solid black 1.5pt;border-bottom:solid black 1.5pt;border-right:solid black 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:26.05pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>6.</span></p>
            </td>
            <td style="width: 177.2pt;border-top: none;border-left: none;border-bottom: 1.5pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1.5pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 35.45pt;border-top: none;border-left: none;border-bottom: 1.5pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 191.35pt;border-top: none;border-left: none;border-bottom: 1.5pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 26.05pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>**</span><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>)</span><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;tuliskan Kode dan Judul Unit Kompetensi yang dinyatakan BK &nbsp; &nbsp; &nbsp;</span></p>
<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
<table style="width:467.8pt;margin-left:5.4pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width:120.8pt;border-top:1.5pt;border-left:1.5pt;border-bottom:1.0pt;border-right:1.0pt;border-color:black;border-style:solid;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;'>Aspek Negatif dan Positif Dalam asesemen</span></strong></p>
            </td>
            <td style="width:140.2pt;border-top:solid black 1.5pt;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.0pt;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>Pencatatan Penolakan Hasil Asesmen</span></strong></p>
            </td>
            <td style="width:206.8pt;border-top:solid black 1.5pt;border-left:  none;border-bottom:solid black 1.0pt;border-right:solid black 1.5pt;background:#C6D9F1;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>Saran Perbaikan :</span></strong></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;text-align:center;'><strong><span style='font-size:15px;font-family:"Franklin Gothic Medium",sans-serif;color:black;'>(Asesor/Personil Terkait)</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 120.8pt;border-top: none;border-left: 1.5pt solid black;border-bottom: 1.5pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 83.2pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'><?php echo $aspek_kredensial; ?></span></p>
            </td>
            <td style="width: 140.2pt;border-top: none;border-left: none;border-bottom: 1.5pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 83.2pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'><?php echo $pencatatan_asesmen; ?></span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 206.8pt;border-top: none;border-left: none;border-bottom: 1.5pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 83.2pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'><?php echo $saran_perbaikan; ?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
<table style="width: 4.7e+2pt;margin-left:5.4pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td colspan="2" style="width: 233.9pt;border-width: 1.5pt 1.5pt 1pt;border-color: windowtext black black windowtext;border-style: solid;padding: 0cm 5.4pt;height: 21.85pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><strong><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></strong><strong><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Penanggung Jawab Pelaksanaan Asesmen :</span></strong></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><strong><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></strong></p>
            </td>
            <td colspan="2" style="width:233.9pt;border-top:solid windowtext 1.5pt;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.5pt;padding:  0cm 5.4pt 0cm 5.4pt;height:21.85pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><strong><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Asesor</span></strong><strong><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp; :&nbsp;</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 89.1pt;border-top: none;border-left: 1.5pt solid windowtext;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 17.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Nama</span></p>
            </td>
            <td style="width: 144.8pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 17.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width:99.15pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Nama&nbsp;</span></p>
            </td>
            <td style="width: 134.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1.5pt solid windowtext;padding: 0cm 5.4pt;height: 17.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'><?php echo $nama_mitra_bestari; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 89.1pt;border-top: none;border-left: 1.5pt solid windowtext;border-bottom: 1pt solid black;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 17.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Jabatan</span></p>
            </td>
            <td style="width: 144.8pt;border-top: none;border-left: none;border-bottom: 1pt solid black;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 17.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width:99.15pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:17.7pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>No. Reg</span></p>
            </td>
            <td style="width: 134.75pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1.5pt solid windowtext;padding: 0cm 5.4pt;height: 17.7pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 89.1pt;border-top: none;border-left: 1.5pt solid windowtext;border-bottom: 1.5pt solid windowtext;border-right: 1pt solid black;padding: 0cm 5.4pt;height: 76.8pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 144.8pt;border-top: none;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1.5pt solid black;padding: 0cm 5.4pt;height: 76.8pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;margin-top:3.0pt;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
            <td style="width:99.15pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.5pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:76.8pt;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Tanda tangan/</span></p>
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>Tanggal</span></p>
            </td>
            <td style="width: 134.75pt;border-top: none;border-left: none;border-bottom: 1.5pt solid windowtext;border-right: 1.5pt solid windowtext;padding: 0cm 5.4pt;height: 76.8pt;vertical-align: top;">
                <p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-size:13px;font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin:0cm;margin-bottom:.0001pt;font-size:16px;font-family:"Times New Roman",serif;'><span style='font-family:"Franklin Gothic Medium",sans-serif;'>&nbsp;</span></p>
</body>
</html>
<script type="text/javascript">
	window.print()
</script>