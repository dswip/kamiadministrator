<?php

$server = "localhost";
$username = "root";
$password = "1989";
$database = "grandpropertydb";

// Koneksi dan memilih database di server
mysql_connect($server,$username,$password) or die("Koneksi gagal");
mysql_select_db($database) or die("Database tidak bisa dibuka");


//------------------------------------------------  PHP koneksi ke Postgree      -------------------------------------------------------------

//$conn_string = "host=localhost port=5432 dbname=test user=lamb password=bar";
//$conn = pg_connect ($conn_string);
//
//if (!$conn) {
//    echo "An error occured.\n";
//    exit;
//}
//
//$result = pg_query ($conn, "SELECT * FROM authors");
//
//if (!$result) {
//    echo "An error occured.\n";
//    exit;
//}

?>
