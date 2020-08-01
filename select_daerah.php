<?php
include("../inc/pdo.conf.php");
if (!empty($_GET['prop'])){
  if (ctype_digit($_GET['prop'])) {
    $query = $db->prepare("SELECT * FROM kota WHERE province_id=:prop ORDER BY name");
    $query->execute(array(':prop'=>$_GET['prop']));
    echo"<option value=''>Pilih Kota/Kab</option>";
    while($d = $query->fetchObject()){
      echo "<option value='{$d->id}'>{$d->name}</option>";
    }
  }
}
if (!empty($_GET['kab'])){
  if (ctype_digit($_GET['kab'])) {
    $query = $db->prepare("SELECT * FROM kecamatan WHERE regency_id=:kab ORDER BY name");
    $query->execute(array(':kab'=>$_GET['kab']));
    echo"<option value=''>Pilih Kecamatan</option>";
    while($d = $query->fetchObject()){
      echo "<option value='{$d->id}'>{$d->name}</option>";
    }
  }
}
if (!empty($_GET['kec'])){
  if (ctype_digit($_GET['kec'])) {
    $query = $db->prepare("SELECT * FROM kelurahan WHERE district_id=:kec ORDER BY name");
    $query->execute(array(':kec'=>$_GET['kec']));
    echo"<option value=''>Pilih Kelurahan/Desa</option>";
    while($d = $query->fetchObject()){
      echo "<option value='{$d->id}'>{$d->name}</option>";
    }
  }
}
