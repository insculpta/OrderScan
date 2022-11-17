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

$custcode = $obj['custcode'];
$branchcode = $obj['branchcode'];
$ordernum = $obj['ordernum'];
$datetime = $obj['datetime'];
$deliver = $obj['deliver']; 
$items = $obj['items']; 
$Dialn = $obj['diamond']; 
$Goldln = $obj['gold']; 
$Silverln = $obj['silver']; 
$Boxln = $obj['box']; 
$createby = $obj['createby'];

//diamond dept
if( $Dialn!='0' && $Goldln=='0' && $Silverln =='0' && $Boxln =='0')
$sql = "INSERT INTO dbo.THSLOnlineOrderHeader (ShopCode, OrderNo, CustomerCode, BranchCode ,OrderDateTime ,DateTime_Created ,Pickby, OrderStatus, Items ,Dialn ,Goldln ,Silverln
,Boxln, DiaPickby, DiaPkStatus, PostCollect ,Type , MadeBy,BKOrderOnly) VALUES ('S001', '$ordernum', '$custcode','$branchcode', '$datetime', '$datetime' ,'$createby', 'FP', '$items', '$Dialn', '$Goldln', '$Silverln', '$Boxln', '$createby','FP', '$deliver', 'Z','$createby', 'N' )";

else
$sql = "INSERT INTO dbo.THSLOnlineOrderHeader (ShopCode, OrderNo, CustomerCode, BranchCode ,OrderDateTime ,DateTime_Created , Pickby, OrderStatus, Items ,Dialn ,Goldln ,Silverln
,Boxln ,PostCollect ,Type , MadeBy, BKOrderOnly) VALUES ('S001', '$ordernum', '$custcode','$branchcode', '$datetime', '$datetime' , '$createby', 'FP', '$items', '$Dialn', '$Goldln', '$Silverln', '$Boxln', '$deliver', 'Z', '$createby', 'N' )";

$stmt = sqlsrv_query( $db_link, $sql );



if ($stmt) 
{
    print(json_encode('Submitted'));
} 
else 
{
    //print(json_encode('Submit failed'));
    die( print_r( sqlsrv_errors(), true));
}
  

sqlsrv_free_stmt( $stmt);



?>