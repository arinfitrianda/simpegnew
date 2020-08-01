<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'pegawai';

// Table's primary key
$primaryKey = 'id_pegawai';
$id_dept = isset($_GET['dept']) ? $_GET['dept'] : '0';
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
// $columns = array(
//     array(
//       'db' => 'id_obat',
//       'dt' => 0,
//       'formatter' => function($d,$row){
//           return "<input class='minimal chk' id='pilihObat' type='checkbox' name='pilihObat[]' value='".$row['id_obat']."'>";
//         }
//     ),
//     array( 'db' => 'nama',  'dt' => 1 ),
//     array( 'db' => 'jenis',   'dt' => 2 ),
// );
$columns = array(
    array('db' => '`peg`.`id_pegawai`','dt' => 'id_pegawai', 'field'=>'id_pegawai', 'as'=>'id_pegawai'),
    array('db' => '`peg`.`nama`','dt' => 'nama', 'field'=>'nama', 'as'=>'nama'),
    array('db' => '`peg`.`nip`','dt' => 'nip', 'field'=>'nip', 'as'=>'nip'),
    array('db' => '`peg`.`status`','dt' => 'status', 'field'=>'status', 'as'=>'status'),
    array('db' => '`peg`.`aktif`','dt' => 'aktif', 'field'=>'aktif', 'as'=>'aktif'),
    array('db' => '`peg`.`foto`','dt' => 'foto', 'field'=>'foto', 'as'=>'foto'),
    array('db' => '`peg`.`id_depart`','dt' => 'id_depart', 'field'=>'id_depart', 'as'=>'id_depart'),
    array('db' => '`peg`.`url_foto`','dt' => 'url_foto', 'field'=>'url_foto', 'as'=>'url_foto'),
    array('db' => '`peg`.`nama_file`','dt' => 'nama_file', 'field'=>'nama_file', 'as'=>'nama_file'),
    array('db' => '`peg`.`url_ttd`','dt' => 'url_ttd', 'field'=>'url_ttd', 'as'=>'url_ttd'),
    array('db' => '`peg`.`ttd_scan`','dt' => 'ttd_scan', 'field'=>'ttd_scan', 'as'=>'ttd_scan'),
    array('db' => '`peg_pro`.`nama_profesi`','dt' => 'nama_profesi', 'field'=>'nama_profesi', 'as'=>'nama_profesi'),
);
// SQL server connection information
require_once('../../inc/set_env.php');
$sql_details = array(
    'user' => $userPdo,
    'pass' => $passPdo,
    'db'   => $dbPdo,
    'host' => $hostPdo
);


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( '../ssp.customized.class.php' );
 $joinQuery = "FROM `pegawai_profil` as peg_pro INNER JOIN pegawai as peg ON (peg_pro.id_peg = peg.id_pegawai) INNER JOIN profesi as pf ON(pf.id_profesi = peg_pro.nama_profesi)";
 $extraWhere = "";
 $groupBy = "";
 $having = "";

 echo json_encode(
    SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
 );
