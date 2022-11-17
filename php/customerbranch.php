<?php

include "mssql_php_connection.php";	
/*
$serverName = "THLDB1SER\THLSTORE";
$connectionInfo = array( "database"=>"DevTHLStore", "UID"=>"devthlsqlluser", "pwd"=>"D34vth5ql","ReturnDatesAsStrings"=>true,"CharacterSet" => "UTF-8",);
$db_link = sqlsrv_connect( $serverName, $connectionInfo);
if( $db_link === false ) {
    die( print_r( sqlsrv_errors(), true));
}
*/

$json = file_get_contents('php://input',true); 	
$obj = json_decode($json,true);
$customercode = $obj['code'];
//$customercode = "ABB1";



$sql = "SELECT CustomerCode, BranchCode FROM dbo.THSLCustomerBranch WHERE CustomerCode = '$customercode' AND BranchStatusJ !='C'  ";
$stmt = sqlsrv_query( $db_link, $sql );


if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
/*
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $output[] = $row;  
    print(json_encode($output,JSON_UNESCAPED_UNICODE));
    //echo $row['CustomerCode'].", ".$row['BranchCode']."";
}
*/
// save into array
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $output[] = $row;
}

//encode into json
if (isset($output)){
    print(json_encode($output,JSON_UNESCAPED_UNICODE));
}




//echo"its running";
sqlsrv_free_stmt( $stmt);



/*

//print $object structure and content
var_dump($json);
//print last json activitity error
json_decode($json.true);
switch (json_last_error()) {
    case JSON_ERROR_NONE:
        echo ' - No errors';
    break;

    case JSON_ERROR_DEPTH:
        echo ' - Maximum stack depth exceeded';
    break;
    case JSON_ERROR_STATE_MISMATCH:
        echo ' - Underflow or the modes mismatch';
    break;
    case JSON_ERROR_CTRL_CHAR:
        echo ' - Unexpected control character found';
    break;
    case JSON_ERROR_SYNTAX:
        echo ' - Syntax error, malformed JSON';
    break;
    case JSON_ERROR_UTF8:
        echo ' - Malformed UTF-8 characters, possibly incorrectly encoded';
    break;
    default:
        echo ' - Unknown error';
    break;
}
echo PHP_EOL;



//test json echo
$data = array(
    'name' => 'John Doe',
    'dob' => '1987-12-12',
    'gender' => 'male',
    'nationality' => 'Ireland'
);
$data = json_encode($data);
echo $data;

//see if a object exists
if (isset($obj))
echo"got it";
else echo "didn't get it";

*/






?>