<?php
include "mssql_php_connection.php";	
/*
$serverName = "THLDB1SER\THLSTORE";
$connectionInfo = array( "database"=>"DevTHLStore", "UID"=>"devthlsqlluser", "pwd"=>"D34vth5ql","ReturnDatesAsStrings"=>true,"CharacterSet" => "UTF-8",);
//$connectionInfo = array( "database"=>"THLStore", "UID"=>"thlsqlluser", "pwd"=>"\$)guru2504!*","ReturnDatesAsStrings"=>true,"CharacterSet" => "UTF-8",);
$db_link = sqlsrv_connect($serverName, $connectionInfo);
if( $db_link === false ) {
    die( print_r( sqlsrv_errors(), true));
}
*/

$json = file_get_contents('php://input',true); 	
$obj = json_decode($json,true);

$attrcode = $obj['attrcode'];
$ordernum = $obj['ordernum'];
$picked = $obj['picked']; 
$srnum = $obj['srnum']; 
$datetime = $obj['datetime'];
$dep = $obj['dep'];
$quantity = $obj['quantity'];
$pktime=$obj['pktime'];

$sql = "INSERT INTO dbo.THSLOnlineOrderDetail (ShopCode, AttributeCode,OrderNo, SrNo, Quantity, OrderDateTime,DateTime_Created, ActualQuantity,sDepln, PKTimeStamp, BatchNo, BackOrder) VALUES ( 'S001','$attrcode', '$ordernum' , '$srnum', '$quantity', '$datetime', '$datetime','$picked', '$dep', '$pktime', 1 , 0)";


$stmt = sqlsrv_query( $db_link, $sql );



if ($stmt) 
{
    print(json_encode('Submitted'));
} 
else 
{
    print(json_encode('Submit failed'));
    die( print_r( sqlsrv_errors(), true));
}
  

sqlsrv_free_stmt( $stmt);



?>