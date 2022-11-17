<?php
//$serverName = "MINGYI_LAPTOP"; //serverName\instanceName  THDB1SER\\THSTLORE  MINGYI_LAPTOP

// Since UID and PWD are not specified in the $connectionInfo array,
// The connection will be attempted using Windows Authentication.
//$connectionInfo = array( "Database"=>"THLStore");//$)guru2504!*
//$spwd="3D4vth5ql";
//$connectionInfo = array( "Database"=>"devthlstore", "UID"=>"devthlsqlluser", "PWD"=>$spwd);
//$spwd="3D$vth5ql";

//$serverName = "THLDB1SER\THLSTORE";
//$connectionInfo = array( "database"=>"THLStore", "UID"=>"thlsqlluser", "pwd"=>"\$)guru2504!*","ReturnDatesAsStrings"=>true);

$serverName = "THLDB1SER\THLSTORE";
$connectionInfo = array( "database"=>"DevTHLStore", "UID"=>"devthlsqlluser", "pwd"=>"D34vth5ql","ReturnDatesAsStrings"=>true);

//$serverName = "MINGYI_LAPTOP"; 
//$connectionInfo = array( "Database"=>"thlstore","ReturnDatesAsStrings"=>true);

$db_link = sqlsrv_connect( $serverName, $connectionInfo);

if(!$db_link ) {
	 echo "Connection could not be established.<br />";
     die( print_r( sqlsrv_errors(), true));
}
/*else{
     echo "Connection established. Ya!!<br />";
}*/
?>