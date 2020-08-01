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
$table = 'pegawai_penempatan';

// Table's primary key
$primaryKey = 'id_penempatan';
$id_pegawai = isset($_GET['peg']) ? $_GET['peg'] : '0';
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
    array('db' => '`pp`.`id_pegawai`','dt' => 'id_pegawai', 'field'=>'id_pegawai', 'as'=>'id_pegawai'),
    array('db' => '`pp`.`tanggal_awal`','dt' => 'tanggal_awal', 'field'=>'tanggal_awal', 'as'=>'tanggal_awal'),
    array('db' => '`pp`.`tanggal_akhir`','dt' => 'tanggal_akhir', 'field'=>'tanggal_akhir', 'as'=>'tanggal_akhir'),
    array('db' => '`pp`.`jabatan`','dt' => 'jabatan', 'field'=>'jabatan', 'as'=>'jabatan'),
    array('db' => '`pp`.`lokasi`','dt' => 'lokasi', 'field'=>'lokasi', 'as'=>'lokasi'),
    array('db' => '`pp`.`id_penempatan`','dt' => 'id_penempatan', 'field'=>'id_penempatan', 'as'=>'id_penempatan'),
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
 $joinQuery = "FROM `pegawai_penempatan` AS `pp`";
 $extraWhere = " `pp`.`id_pegawai`='".$id_pegawai."'";
 $groupBy = "";
 $having = "";

 echo json_encode(
 	SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere, $groupBy, $having )
 );
