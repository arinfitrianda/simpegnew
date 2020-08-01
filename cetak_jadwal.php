<?php
$nama_mitra_bestari = $_POST["nama_mitra_bestari"];
$nama = $_POST["nama"];
$tgl_kredensial = $_POST["tgl_kredensial"];
$tempat_kredensial = $_POST["tempat_kredensial"];

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
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><strong><span style='font-family:"Bookman Old Style",serif;'>FORMULIR PERSETUJUAN KREDENSIAL DAN KERAHASIAAN</span></strong></p>
<table style="border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td colspan="8" style="width: 450.8pt;border: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Persetujuan Asesmen ini untuk menjamin bahwa Peserta telah diberi arahan secara rinci tentang perencanaan dan proses asesmen&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 106.1pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Skema Sertifikasi / Klaster Asesmen</span></p>
            </td>
            <td colspan="3" style="width: 49.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Judul</span></p>
            </td>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 281pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 106.1pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
            <td colspan="3" style="width: 49.6pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Nomor</span></p>
            </td>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 281pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width: 155.7pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>TUK</span></p>
            </td>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 281pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Sewaktu / Tempat Kerja / Mandiri*</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width: 155.7pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Nama Asesor</span></p>
            </td>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 281pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'><?php echo $nama_mitra_bestari ?></span></p>
            </td>
        </tr>
        <tr>
            <td colspan="4" style="width: 155.7pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Nama Peserta</span></p>
            </td>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 281pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'><?php echo $nama; ?></span></p>
            </td>
        </tr>
        <tr>
            <td colspan="4" rowspan="3" style="width: 155.7pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Bukti yang akan dikumpulkan</span></p>
            </td>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td style="width: 57.65pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Bukti TL</span></p>
            </td>
            <td style="width: 14.4pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td style="width: 208.95pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td style="width: 57.65pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Bukti L</span></p>
            </td>
            <td style="width: 14.4pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td style="width: 208.95pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 14.1pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td style="width: 57.65pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Bukti T</span></p>
            </td>
            <td style="width: 14.4pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td style="width: 208.95pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="width: 450.8pt;border-top: none;border-left: 1pt solid windowtext;border-bottom: none;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Pelaksanaan asesmen disepakati pada :</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="width: 150.25pt;border-top: none;border-right: none;border-bottom: none;border-image: initial;border-left: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Hari / Tanggal</span></p>
            </td>
            <td colspan="2" style="width: 19.6pt;border: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 280.95pt;border-top: none;border-bottom: none;border-left: none;border-image: initial;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'><?php echo($tgl_kredensial) ?></span></p>
            </td>
        </tr>
        <tr>
            <td colspan="3" style="width: 150.25pt;border-top: none;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Tempat</span></p>
            </td>
            <td colspan="2" style="width: 19.6pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="3" style="width: 280.95pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'><?php echo $tempat_kredensial ?></span></p>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="width: 450.8pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Peserta Sertifikasi:</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Saya setuju mengikuti asesmen dengan pemahaman bahwa informasi yang dikumpulkan hanya digunakan untuk pengembangan professional dan hanya dapat di akses oleh orang tertentu saja.</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td colspan="8" style="width: 450.8pt;border-right: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-left: 1pt solid windowtext;border-image: initial;border-top: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Asesor:</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Menyatakan tidak akan membuka hasil pekerjaan yang saya peroleh karena penugasan, saya sebagai asesor dalam pekerjaan Asesmen kepada siapapun atau organisasi apapun selain kepada pihak yang berwenang sehubungan dengan kewajiban saya sebagai Asesor yang ditugaskan oleh LSP</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 106.1pt;border-top: none;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Tanda tangan Peserta</span></p>
            </td>
            <td style="width: 14.15pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="4" style="width: 107.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
            <td colspan="2" style="width: 223.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Tanggal : <?php echo $tanggal; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="width: 106.1pt;border-top: none;border-left: 1pt solid windowtext;border-bottom: 1pt solid windowtext;border-right: none;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Tanda tangan Asesor&nbsp;</span></p>
            </td>
            <td style="width: 14.15pt;border-top: none;border-right: none;border-left: none;border-image: initial;border-bottom: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>:</span></p>
            </td>
            <td colspan="4" style="width: 107.2pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
            <td colspan="2" style="width: 223.35pt;border-top: none;border-left: none;border-bottom: 1pt solid windowtext;border-right: 1pt solid windowtext;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-top:0cm;margin-right:0cm;margin-bottom:.0001pt;margin-left:0cm;line-height:  150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>Tanggal : <?php echo $tanggal; ?></span></p>
            </td>
        </tr>
        <tr>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
            <td style="border:none;"><br></td>
        </tr>
    </tbody>
</table>
<p style='margin-top:0cm;margin-right:0cm;margin-bottom:8.0pt;margin-left:0cm;line-height:150%;font-size:15px;font-family:"Calibri",sans-serif;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
</html>
<script type="text/javascript">
    window.print()
</script>