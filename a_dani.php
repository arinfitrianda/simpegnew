<!DOCTYPE html>
<html>
<head>
  <title></title>
</head>
<body>
<table>
  <thead>
    <tr>
      <th>No</th>
      <th>Kompetensi</th>
      <th>Diminta</th>
      <th colspan="2">Disetujui</th>
      <th colspan="2">Ditolak</th>
      <th>Keterangan</th>
    </tr>
  </thead>
  <tbody>
      <?php
        include("../inc/pdo.conf.php");
        $queryKompetensi  = $db->query("SELECT * FROM asesmen_kompetensi");
        $dataKompetensi = $queryKompetensi->fetchAll(PDO::FETCH_ASSOC);

        $no=1;
        $nomor=1;
        foreach ($dataKompetensi as $dk) {
          echo "<tr>
          <td>".$no++."</td>
          <td>".$dk['sub_soal']."</td>
          <td> </td>
          <td><label><input type='radio' id='m1' name='jawaban".$nomor."[]' value='m'><label for='spkk'>Mahir</label></td>
          <td><label><input type='radio' id='ds2' name='jawaban".$nomor."[]' value='ds'><label for='spkk'>Dibawah Supervisi</label></td>
          <td><label><input type='radio' id='ta3' name='jawaban".$nomor."[]' value='ta'><label for='spkk'>Tak Ada Alat</label></td>
          <td><label><input type='radio' id='tk4' name='jawaban".$nomor."[]' value='tk'><label for='spkk'>Tak Ada Kompetensi</label></td>
          <td></td>
          ";
          $no++;
          $nomor++;
        }
        ?>
          
        </tbody> 
      </table>
</body>
</html>