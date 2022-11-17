<?php

header("Access-Control-Allow-Origin: *");
//or

// Reading JSON POST using PHP
$json = file_get_contents('php://input');
include "mssql_php_connection.php";	
/*
$serverName = "THLDB1SER\THLSTORE";
$connectionInfo = array( "database"=>"DevTHLStore", "UID"=>"devthlsqlluser", "pwd"=>"D34vth5ql","ReturnDatesAsStrings"=>true);
$db_link = sqlsrv_connect( $serverName, $connectionInfo);
if( $db_link === false ) {
    die( print_r( sqlsrv_errors(), true));
}
*/

//select the latest order number by type Scan (coded in type Z)
$sql = "SELECT OrderNo FROM dbo.THSLOnlineOrderHeader WHERE Type ='Z' and  DateTime_Created = ( SELECT Max(DateTime_Created) FROM dbo.THSLOnlineOrderHeader where Type ='Z')";
$stmt = sqlsrv_query( $db_link, $sql );

if( $stmt === false) {  
die( print_r( sqlsrv_errors(), true)) ;
}



// save into array
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
     $output[] = $row;
}

//encode into json
if (isset($output)){
     print(json_encode($output,JSON_UNESCAPED_UNICODE));
}
else
     print(json_encode('No previous OrderNo'));

sqlsrv_free_stmt( $stmt);


?>