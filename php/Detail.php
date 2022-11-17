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
$total = $obj['total'];
$submit = 0;

$tsql = "INSERT INTO dbo.THSLOnlineOrderDetail (ShopCode, AttributeCode,OrderNo, SrNo, Quantity, OrderDateTime,DateTime_Created, ActualQuantity,sDepln, PKTimeStamp, BatchNo, BackOrder) VALUES ( 'S001',?, ? , ?, ?, ?, ? ,? , ?, ?, 1 , 0)";
$params = array(&$AttriCode, &$OrderNo, &$SrNo, &$Quan, &$Date_time, &$Date_time, &$PickedItem, &$Dept, &$Pk_time);
$stmt = sqlsrv_prepare($db_link, $tsql, $params); 



for($i = 0; $i < $total; $i++) {
   
    $AttriCode = $attrcode[$i];
    $OrderNo = $ordernum[$i];
    $SrNo = $srnum[$i]; 
    $Quan = $quantity[$i];
    $Date_time = $datetime[$i];
    $PickedItem = $picked[$i];
    $Dept = $dep[$i];
    $Pk_time= $pktime[$i];
    

    if( sqlsrv_execute( $stmt))  
    {  
        //echo "Statement executed.\n"; 
        $submit++;
    }  
    else  
    {         
        print(json_encode('Submit failed'));
        die( print_r( sqlsrv_errors(), true));
    } 

    }

    if( $submit == $total)  
    {  
        //echo "Statement executed.\n"; 
        print(json_encode('Fully Submitted')); 
    }  
    else  
    {         
        print(json_encode('Partly Submitted'));
        die( print_r( sqlsrv_errors(), true));
    } 


    
//}


/*
$sql = "INSERT INTO dbo.THSLOnlineOrderDetail (ShopCode, AttributeCode,OrderNo, SrNo, Quantity, OrderDateTime,DateTime_Created, ActualQuantity,sDepln, PKTimeStamp, BatchNo, BackOrder) VALUES ( 'S001','$attrcode', '$ordernum' , '$srnum', '$quantity', '$datetime', '$datetime','$picked', '$dep', '$pktime', 1 , 0)";


$stmt = sqlsrv_query( $db_link, $sql );

$stmt2 = sqlsrv_prepare($conn, $tsql, array(&$id));  

sqlsrv_execute($stmt2)
*/

/* Set up the Transact-SQL query. */  
//$tsql = "UPDATE Sales.SalesOrderDetail   SET OrderQty = ( ?)   WHERE SalesOrderDetailID = ( ?)";  
         



/*==========================================================================


$AttriCode = '123';
$OrderNo = '123';
$SrNo = '1'; 
$Quan = '10';

if( sqlsrv_execute( $stmt))  
{  
    echo "Statement executed.\n";  
}  
else  
{  
    echo "Error in executing statement.\n";  
    die( print_r( sqlsrv_errors(), true));  
} 

$AttriCode = '456';
$OrderNo = '456';
$SrNo = '1'; 
$Quan = '10';

if( sqlsrv_execute( $stmt))  
{  
    echo "Statement executed.\n";  
}  
else  
{  
    echo "Error in executing statement.\n";  
    die( print_r( sqlsrv_errors(), true));  
} 


======================================================*/
/*

$AttriCode = array('123','123');
$OrderNo = array('456','789');
$SrNo = array('1','2'); 
$Quan = array('10','10');


/* Set up the parameters array. Parameters correspond, in order, to  
question marks in $tsql. */  
//$params = array(&$ShopCode, &$AttriCode, &$OrderNo, &$SrNo, &$Quan);
/*  
$params[0] = array(&$AttriCode[0], &$OrderNo[0], &$SrNo[0], &$Quan[0]); 
$params[1] = array(&$AttriCode[1], &$OrderNo[1], &$SrNo[1], &$Quan[1]); 
echo  $OrderNo[1]; 
*/
//$params = array('123'); 
  
/*
$params[0] = array(&$ShopCode[0], &$AttriCode[0], &$OrderNo[0], &$SrNo[0], &$Quan[0]); 
$params[1] = array(&$ShopCode[1], &$AttriCode[1], &$OrderNo[1], &$SrNo[1], &$Quan[1]); 
*/

/*
/* Create the statement.   
//$stmt = sqlsrv_prepare($db_link, $tsql, array(&$ShopCode, &$AttriCode, &$OrderNo, &$SrNo, &$Quan));  
//$stmt[0] = sqlsrv_prepare($db_link, $tsql, $params[0]); 
//$stmt[1] = sqlsrv_prepare($db_link, $tsql, $params[1]); 
$stmt = sqlsrv_prepare($db_link, $tsql, $params);   

//for($i = 0; $i < count($params); $i++) {
    //echo $keys[$i] . "{<br>";
    echo  "{ ";
    foreach($params as $value) {
        //echo $value . ",";
        if( sqlsrv_execute( $stmt))  
        {  
            echo "Statement executed.\n";  
        }  
        else  
        {  
            echo "Error in executing statement.\n";  
            die( print_r( sqlsrv_errors(), true));  
        }  

    }
    echo "}<br>";
//}

*/

  
/* Execute the statement. Display any errors that occur. */  
//foreach($params as $ShopCode, $AttriCode, $OrderNo, $SrNo, $Quan)
//$orders=array_combine( $ShopCode, $AttriCode, $OrderNo,$SrNo, $Quan);

/*
foreach ($orders as $OrderNo => $Quan){
if( sqlsrv_execute( $stmt))  
{  
      echo "Statement executed.\n";  
}  
else  
{  
     echo "Error in executing statement.\n";  
     die( print_r( sqlsrv_errors(), true));  
}  
}
*/


  

sqlsrv_free_stmt( $stmt);



?>