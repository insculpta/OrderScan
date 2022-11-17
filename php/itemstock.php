<?php
include "mssql_php_connection.php";	
/*
$serverName = "THLDB1SER\THLSTORE";
//$connectionInfo = array( "database"=>"DevTHLStore", "UID"=>"devthlsqlluser", "pwd"=>"D34vth5ql","ReturnDatesAsStrings"=>true,"CharacterSet" => "UTF-8",);
$connectionInfo = array( "database"=>"THLStore", "UID"=>"thlsqlluser", "pwd"=>"\$)guru2504!*","ReturnDatesAsStrings"=>true,"CharacterSet" => "UTF-8",);
$db_link = sqlsrv_connect( $serverName, $connectionInfo);
if( $db_link === false ) {
    die( print_r( sqlsrv_errors(), true));
}
*/

$json = file_get_contents('php://input',true); 	
$obj = json_decode($json,true);
$scaninput = $obj['scaninput'];
//$customercode = "ABB1";

/*
if(is_numeric($scaninput))
//if the input is barcode, we need to get its attribute code
$sql = "SELECT AA.AttributeCode, AA.MainStockPC_M FROM dbo.THXAItemAttribute as AA WHERE AA.BarcodeID = '$scaninput' ";
else
// if the input is already attribute code
$sql = "SELECT AA.AttributeCode, AA.MainStockPC_M FROM dbo.THXAItemAttribute as AA WHERE AA.AttributeCode = '$scaninput' ";
*/

//find stock and department
if(is_numeric($scaninput))
//if the input is barcode, we need to get its attribute code
$sql = "SELECT AA.AttributeCode, AA.MainStockPC_M, AA.SoldMinQty,  
                    case when AI.DepartmentCode is not null then AI.DepartmentCode 
                    else 
                            case  when AI.Type='S' then 'S' 
                                  when AI.Type='B' then 'B' 
                                  when SG.GroupCode='DIAMONDS' or SG.GroupCode='MOUNTS' then 'D' 
                                  when SG.GroupCode='WEDS' and SG.SubGroupCode='DIAWEDDQ' then 'D' 
                                  when SG.SubGroupCode='FP' then 'D'  
                                  when AI.Type='G' and (SG.GroupCode<>'DIAMONDS' and SG.GroupCode<>'MOUNTS') then 'G' 
                                  when AI.Type='G' and (SG.GroupCode<>'WEDS' and SG.SubGroupCode<>'DIAWEDDQ') then 'G' 
                                  when AI.Type='P' and (SG.GroupCode<>'DIAMONDS' and SG.GroupCode<>'MOUNTS' and SG.SubGroupCode <>'FP') then 'G' 
                                  else 'D' 
                            end 
                    end as Dep 
                    from dbo.THXAItemAttribute as AA 
                    inner join dbo.THXAItem as AI on AI.ItemCode = AA.ItemCode 
                    inner join dbo.THXASubGroup as SG on SG.SubGroupCode=AI.SubGroupCode 
                    WHERE AA.BarcodeID = '$scaninput' ";

// if the input is already attribute code
else
$sql = "SELECT AA.AttributeCode, AA.MainStockPC_M, AA.SoldMinQty,  
                    case when AI.DepartmentCode is not null then AI.DepartmentCode 
                    else 
                            case  when AI.Type='S' then 'S' 
                                  when AI.Type='B' then 'B' 
                                  when SG.GroupCode='DIAMONDS' or SG.GroupCode='MOUNTS' then 'D' 
                                  when SG.GroupCode='WEDS' and SG.SubGroupCode='DIAWEDDQ' then 'D' 
                                  when SG.SubGroupCode='FP' then 'D'  
                                  when AI.Type='G' and (SG.GroupCode<>'DIAMONDS' and SG.GroupCode<>'MOUNTS') then 'G' 
                                  when AI.Type='G' and (SG.GroupCode<>'WEDS' and SG.SubGroupCode<>'DIAWEDDQ') then 'G' 
                                  when AI.Type='P' and (SG.GroupCode<>'DIAMONDS' and SG.GroupCode<>'MOUNTS' and SG.SubGroupCode <>'FP') then 'G' 
                                  else 'D' 
                            end 
                    end as Dep 
                    from dbo.THXAItemAttribute as AA 
                    inner join dbo.THXAItem as AI on AI.ItemCode = AA.ItemCode 
                    inner join dbo.THXASubGroup as SG on SG.SubGroupCode=AI.SubGroupCode 
                    WHERE AA.AttributeCode = '$scaninput' ";


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
else{
    print(json_encode('not in database'));
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