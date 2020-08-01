<?php 
include("../inc/pdo.conf.php");
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

$id_pegawai = $_GET['id_pegawai'];
$master = $db->prepare("SELECT * FROM pegawai_profil pro INNER JOIN pegawai peg ON(peg.id_pegawai=pro.id_peg) INNER JOIN departemen dp ON(dp.id_dept=peg.id_depart) INNER JOIN profesi as pr on(pro.nama_profesi=pr.id_profesi) INNER JOIN set_asesor sa ON(sa.id_pegawai=pro.id_peg) where id_peg=:id");
$master->bindParam(":id",$id_pegawai);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);

$pribadi = $db->prepare("SELECT *,pro.name as 'provinsi',kab.name as 'kabupaten',kec.name as 'kecamatan',kel.name as 'kelurahan' FROM pegawai_profil peg LEFT JOIN provinsi pro ON(pro.id=peg.provinsi) LEFT JOIN kota kab ON(kab.id=peg.kabupaten) LEFT JOIN kecamatan kec ON(kec.id=peg.kecamatan) LEFT JOIN kelurahan kel ON(kel.id=peg.kelurahan) WHERE id_peg=:id");
  $pribadi->bindParam(":id",$id_pegawai);
  $pribadi->execute();
  $dp = $pribadi->fetch(PDO::FETCH_ASSOC);

$tanggal = date('d-m-Y');
?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>REKAPAN DATA ASSESI</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>NAMA ASSESI&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: <?php echo $m["nama"]; ?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>NIP/ NIK&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;:<?php echo $m["nip"] ?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>TEMPAT PRAKTEK/ UNIT KERJA &nbsp; &nbsp; : <?php echo $m["nama_dept"]?></span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:21.3pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<table style="width:429.35pt;margin-left:21.3pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td rowspan="2" style="width:1.0cm;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>No.</span></strong></p>
            </td>
            <td rowspan="2" style="width:219.35pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Format/ Instrumen</span></strong></p>
            </td>
            <td colspan="2" style="width:3.0cm;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Kelengkapan</span></strong></p>
            </td>
            <td rowspan="2" style="width:96.6pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:  .0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Keterangan</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width: 42.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Ya</span></strong></p>
            </td>
            <td style="width: 42.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tidak</span></strong></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border:solid windowtext 1.0pt;border-top:  none;padding:0cm 5.4pt 0cm 5.4pt;height:47.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:  "Times New Roman",serif;'>1.</span></p>
            </td>
            <td style="width:219.35pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:47.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Data Profil Individu</span></p>
            </td>
            <td style="width:42.5pt;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:47.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Courier New";'>&radic;</span></p>
            </td>
            <td style="width: 42.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 47.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 96.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 47.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border:solid windowtext 1.0pt;border-top:  none;padding:0cm 5.4pt 0cm 5.4pt;height:120.35pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>2.</span></p>
            </td>
            <td style="width:219.35pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:120.35pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Permohonan Kredensial</span></p>
                <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
                    <ol start="1" style="margin-bottom:0cm;list-style-type: lower-alpha;margin-left:12.55px;">
                        <li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Indentitas</span></li>
                        <li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Status regristasi</span></li>
                        <li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Status kredensial</span></li>
                        <li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Persyaratan kredensial</span></li>
                    </ol>
                </div>
            </td>
            <td style="width:42.5pt;border-top:none;border-left:none;border-bottom:  solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:120.35pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:  .0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Courier New";'>&radic;</span></p>
            </td>
            <td style="width: 42.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 120.35pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 96.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 120.35pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Pernyataan:</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:1.0cm;border:solid windowtext 1.0pt;border-top:  none;padding:0cm 5.4pt 0cm 5.4pt;height:112.2pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>3.</span></p>
            </td>
            <td style="width:219.35pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;height:112.2pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Rincian Kewenangan Apoteker</span></p>
                <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
                    <ol start="1" style="margin-bottom:0cm;list-style-type: upper-alpha;margin-left:12.55px;">
                        <li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Assesment Mandiri Nakes</span></li>
                        <li style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Rekomendasi Assesor</span></li>
                    </ol>
                </div>
            </td>
            <td style="width: 42.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 112.2pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 42.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 112.2pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 96.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;height: 112.2pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:justify;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Rekomendasi:</span></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:68.55pt;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:107%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<table style="margin-left:19.6pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 134.4pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:68.55pt;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 71.15pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:68.55pt;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
            </td>
            <td style="width:236.95pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>Bandung, <?php echo tgl_indo($tanggal); ?>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>Mitra Bestari</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:normal;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;font-family:"Times New Roman",serif;'><?php echo $m["nama_mitra_bestari"]; ?></span></p>
            </td>
        </tr>
    </tbody>
</table>
</body>
</html>
