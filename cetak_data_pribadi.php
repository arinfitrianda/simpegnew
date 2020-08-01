<?php 
include("../inc/pdo.conf.php");
$id_pegawai = $_GET['id'];
$master = $db->prepare("SELECT * FROM pegawai_profil pro INNER JOIN pegawai peg ON(peg.id_pegawai=pro.id_peg) INNER JOIN departemen dp ON(dp.id_dept=peg.id_depart) WHERE pro.id_peg=:id");
$master->bindParam(":id",$id_pegawai);
$master->execute();
$m = $master->fetch(PDO::FETCH_ASSOC);

$pribadi = $db->prepare("SELECT *,pro.name as 'provinsi',kab.name as 'kabupaten',kec.name as 'kecamatan',kel.name as 'kelurahan' FROM pegawai_profil peg LEFT JOIN provinsi pro ON(pro.id=peg.provinsi) LEFT JOIN kota kab ON(kab.id=peg.kabupaten) LEFT JOIN kecamatan kec ON(kec.id=peg.kecamatan) LEFT JOIN kelurahan kel ON(kel.id=peg.kelurahan) WHERE id_peg=:id");
  $pribadi->bindParam(":id",$id_pegawai);
  $pribadi->execute();
  $dp = $pribadi->fetch(PDO::FETCH_ASSOC);

$formal_list = $db->query("SELECT * FROM pegawai_pend_formal WHERE status=0 AND id_pegawai='".$id_pegawai."'" );
$formal = $formal_list->fetchAll(PDO::FETCH_ASSOC);

$getRiwayatPekerjaan = $db->query("SELECT * FROM riwayat_pekerjaan WHERE status=0 AND id_pegawai='".$id_pegawai."'");
$riwayatPekerjaan= $getRiwayatPekerjaan->fetchAll(PDO::FETCH_ASSOC); 

$getRiwayatSTR = $db->query("SELECT * FROM riwayat_str WHERE status=0 AND id_pegawai='".$id_pegawai."'");
$RiwayatSTR= $getRiwayatSTR->fetchAll(PDO::FETCH_ASSOC);  

$getRiwayatSIP = $db->query("SELECT * FROM riwayat_sip WHERE status=0 AND id_pegawai='".$id_pegawai."'");
$RiwayatSIP= $getRiwayatSIP->fetchAll(PDO::FETCH_ASSOC);

$getRiwayatPelatihan = $db->query("SELECT * FROM diklat_p WHERE id_pegawai='".$id_pegawai."'");
$RiwayatPelatihan= $getRiwayatPelatihan->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>FORMULIR 2&nbsp;</span></strong></p>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><strong><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>RINCIAN DATA DAN BUKTI PENDUKUNG ASSESI</span></strong></p>
<p><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'><strong>&nbsp; &nbsp; I.&nbsp; RI</strong></span><strong><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>NCIAN DATA ASSESI</span></strong></p>
<ol start="1" style="list-style-type: upper-alpha;margin-left:29.299999999999997px;">
    <li><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>Data Pribadi</span></li>
</ol>
<table style="border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>1</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nama Pemohon</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['nama']; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>2</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tempat / Tanggal Lahir</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['tempat_lahir'];?> , <?php echo $m['tanggal_lahir']; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>3</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Jenis Kelamin</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>:  <?php if ($m['jenis_kelamin'] == 'L'){ echo "Laki-laki"; } ?>
                              <?php if ($m['jenis_kelamin'] == 'P'){ echo "Perempuan"; } ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>4</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Pangkat / Golongan</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $dp['pangkat']?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>5</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tempat Praktek / Unit Kerja</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['nama_dept']?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>6</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Bagian</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['id_bagian']?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>7</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Pendidikan Terakhir</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: -</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>8</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Alamat Rumah</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $dp['alamat']; ?> , <?php echo $dp['kecamatan']; ?> , <?php echo $dp['kelurahan']; ?> , <?php echo $dp['kode_pos']; ?>t</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>9</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>No. HP/WA</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['no_wea']; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>10</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Telp Rumah / Kantor HP</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['telepon']; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 28.1pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>11</span></p>
            </td>
            <td style="width: 156.2pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>E-mail</span></p>
            </td>
            <td style="width: 266.5pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>: <?php echo $m['email_address']; ?></span></p>
            </td>
        </tr>
    </tbody>
</table>

<div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
    <p style="margin-left: 40px;"><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>A. Data Pendidikan</span></p>
</div>
<table style="width:503.25pt;margin-left:-.25pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 1cm;border: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>No</span></p>
            </td>
            <td style="width: 127.6pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tingkat Pendidikan</span></p>
            </td>
            <td style="width: 77.95pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tahun</span></p>
            </td>
            <td style="width: 269.35pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nama Institusi</span></p>
            </td>
        </tr>
        <?php
        $no=1;
        foreach ($formal as $f) {
        ?>                   
        <tr>
            <td style="width: 1cm;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $no++?></span></p>
            </td>
            <td style="width: 127.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp; <?php echo $f["tingkat_pendidikan"];?></span></p>
            </td>
            <td style="width: 77.95pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $f["tanggal_sttb"];?></span></p>
            </td>
            <td style="width: 269.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $f["nama_sekolah"];?></span></p>
            </td>
        </tr>
        <?php
        }
        ?>
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:18.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
    <p style="margin-left: 40px;"><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>B.Data Pekerjaan</span></p>
</div>
<table style="width:503.25pt;margin-left:-.25pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td rowspan="2" style="width:1.0cm;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>No</span></p>
            </td>
            <td rowspan="2" style="width:142.9pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Nama Rumah Sakit / Unit</span></p>
            </td>
            <td colspan="2" style="width:195.5pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Pindah / Rotasi /Mutasi</span></p>
            </td>
            <td rowspan="2" style="width:136.5pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Posisi</span></p>
            </td>
        </tr>
        <tr>
            <td style="width:98.1pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Mulai (Bulan/Tahun)</span></p>
            </td>
            <td style="width:97.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>Sampai</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>(Bulan / Tahun)</span></p>
            </td>
        </tr>
        <tr>
            <?php
            $no=1;
            foreach ($riwayatPekerjaan as $data_pekerjaan) {?>
            <td style="width: 1cm;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $no++ ?></span></p>
            </td>
            <td style="width: 142.9pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pekerjaan['nama_perusahaan'] ?></span></p>
            </td>
            <td style="width:98.1pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pekerjaan['tgl_mulai_kerja']?></span></p>
            </td>
            <td style="width:97.4pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;text-align:center;'><span style='font-size:16px;line-height:  150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pekerjaan['tgl_selesai_kerja'] ?></span></p>
            </td>
            <td style="width: 136.5pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pekerjaan['jabatan'] ?></span></p>
            </td>
            <?php 
            }?>
        </tr>
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:18.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
    <p style="margin-left: 40px;"><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>C.Data Registrasi</span></p>
</div>
<table style="width:503.25pt;margin-left:-.25pt;border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width:25.5pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>No</span></p>
            </td>
            <td style="width:144.6pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nomor STR</span></p>
            </td>
            <td style="width:99.25pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tgl. Terbit&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>(tgl-bln-th)</span></p>
            </td>
            <td style="width:93.35pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tgl. Akhir <br>&nbsp;(tgl-bln-th)</span></p>
            </td>
            <td style="width:140.55pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:  .0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tempat Praktek</span></p>
            </td>
        </tr>
        <tr>
            <?php
            $no=1;
            foreach ($RiwayatSTR as $data_str) {?>
            <td style="width: 25.5pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $no++ ?></span></p>
            </td>
            <td style="width: 144.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_str['no_str'] ?></span></p>
            </td>
            <td style="width: 99.25pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_str['tgl_terbit_str'] ?></span></p>
            </td>
            <td style="width: 93.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_str['tgl_kadaluarsa_str']; ?></span></p>
            </td>
            <td style="width: 140.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_str['tempat_praktek']; ?></span></p>
            </td>
            <?php 
            }
            ?>
        </tr>
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:18.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
<div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
    <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
        <p style="margin-left: 40px;"><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>D.Data Izin Praktek&nbsp;</span></p>
    </div>
    <table style="width:503.25pt;margin-left:-.25pt;border-collapse:collapse;border:none;">
        <tbody>
            <tr>
                <td style="width:25.5pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>No</span></p>
                </td>
                <td style="width:144.6pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nomor SIP</span></p>
                </td>
                <td style="width:99.25pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tgl. Terbit&nbsp;</span></p>
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>(tgl-bln-th)</span></p>
                </td>
                <td style="width:93.35pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tgl. Akhir <br>&nbsp;(tgl-bln-th)</span></p>
                </td>
                <td style="width:140.55pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:  .0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tempat Praktek</span></p>
                </td>
            </tr>
            <tr>
                <?php
                $no=1;
                foreach ($RiwayatSIP as $data_sip) { 
                ?>
                <td style="width: 25.5pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $no++ ?></span></p>
                </td>
                <td style="width: 144.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_sip['no_sip']; ?></span></p>
                </td>
                <td style="width: 99.25pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_sip['tgl_terbit_sip']; ?></span></p>
                </td>
                <td style="width: 93.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_sip['tgl_kadaluarsa_sip']; ?></span></p>
                </td>
                <td style="width: 140.55pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_sip['tempat_praktek']; ?></span></p>
                </td>
                <?php 
                }
                ?>
            </tr>
        </tbody>
    </table>
    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
    <div style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:107%;font-size:15px;font-family:"Calibri",sans-serif;'>
        <p style="margin-left: 40px;"><span style='line-height:150%;font-family:"Times New Roman",serif;font-size:16px;'>E.Data Pelatihan</span></p>
    </div>
    <table style="width:503.25pt;margin-left:-.25pt;border-collapse:collapse;border:none;">
        <tbody>
            <tr>
                <td style="width:27.8pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>No</span></p>
                </td>
                <td style="width:128.15pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nama Pelatihan</span></p>
                </td>
                <td style="width:3.0cm;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Nama Penyedia Pelatihan</span></p>
                </td>
                <td style="width:92.15pt;border:solid windowtext 1.0pt;border-left:  none;padding:0cm 5.4pt 0cm 5.4pt;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tanggal Mulai Pelatihan</span></p>
                </td>
                <td style="width: 99.2pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Tanggal Selesai Pelatihan</span></p>
                </td>
                <td style="width: 70.9pt;border-top: 1pt solid windowtext;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-image: initial;border-left: none;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:  .0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;text-align:center;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>Jumlah Hari</span></p>
                </td>
            </tr>
            <tr>
                <?php
                $no=1;
                foreach ($RiwayatPelatihan as $data_pelatihan) {?>
                <td style="width: 27.8pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $no++ ?></span></p>
                </td>
                <td style="width: 128.15pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pelatihan['namapelatihan']; ?></span></p>
                </td>
                <td style="width: 3cm;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pelatihan['namapenyedia'] ?></span></p>
                </td>
                <td style="width: 92.15pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pelatihan['tanggalmulai'] ?></span></p>
                </td>
                <td style="width: 99.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pelatihan['tanggalselesai'] ?></span></p>
                </td>
                <td style="width: 70.9pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:36.0pt;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;margin:0cm;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;<?php echo $data_pelatihan['jumlahhari'] ?></span></p>
                </td>
                <?php 
                }
                ?>
            </tr>
        </tbody>
    </table>
    <p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-size:16px;line-height:150%;font-family:"Times New Roman",serif;'>&nbsp;</span></p>
</div>
</body>
</html>

<script type="text/javascript">
    window.print()
</script>