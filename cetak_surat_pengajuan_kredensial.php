<?php
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

$nama = $_GET['nama'];
// echo $nama;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Perihal&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: Proses Kredensial</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Lampiran&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp;: 1 (Satu) Berkas</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Kepada Yth,</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Ketua Komite Nakes Lain</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Rumah Sakit Khusus Ibu dan Anak Kota Bandung</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Di tempat</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>Dengan Hormat,</span></p>
<p style="margin: 0cm 0cm 8pt; font-size: 15px; font-family: Calibri, sans-serif; line-height: 1.5; text-indent: 36pt;"><span style='font-family:"Bookman Old Style",serif;'>Dengan ini saya mengajukan permohonan surat penugasan kerja klinis dan rincian kewenangan kompetensi profesi sebagai staf medis rumah sakit. Demikian surat ini saya sampaikan, atas perhatiannya diucapkan terima kasih</span></p>
<table style="border-collapse:collapse;border:none;">
    <tbody>
        <tr>
            <td style="width: 150.25pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 150.25pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
            </td>
            <td style="width: 150.3pt;padding: 0cm 5.4pt;vertical-align: top;">
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'><span style='font-family:"Bookman Old Style",serif;'>Bandung, <?php echo tgl_indo($tanggal) ?></span></p>
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;text-align:center;'><span style='font-family:"Bookman Old Style",serif;'>Pemohon</span></p>
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
                <p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;text-align:center;'><span style='font-family:"Bookman Old Style",serif;'><?php echo $nama; ?></span></p>
            </td>
        </tr>
    </tbody>
</table>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;color:black;'>Berkas yang diperlukan :</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>1. Foto copy STR</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>2. Foto copy Ijazah</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>3. Curiculum Vitae</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>4. Foto copy Surat Ijin Praktek</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>5. Foto copy KTP</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>6. Pas Foto 4 x 6 Berwarna (1 lbr)</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:107%;'><span style='font-family:"Bookman Old Style",serif;'>7. Format Rincian Kewenangan klinik yang sudah di isi</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
<p style='margin-right:0cm;margin-left:0cm;font-size:15px;font-family:"Calibri",sans-serif;margin-top:0cm;margin-bottom:8.0pt;line-height:150%;'><span style='font-family:"Bookman Old Style",serif;'>&nbsp;</span></p>
<script>
	window.print();
</script>
</body>
</html>