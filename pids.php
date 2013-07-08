<?php
include('redirect.php');
$refer_url=(empty($_SERVER["HTTP_REFERER"])?"":$_SERVER["HTTP_REFERER"]);
$pids=(empty($_REQUEST["pids"])?"":$_REQUEST["pids"]); 
$vid=(empty($_REQUEST["vid"])?"":$_REQUEST["vid"]); 
$cid=(empty($_REQUEST["cid"])?"":$_REQUEST["cid"]); 
$sRequestvars = $_SERVER["QUERY_STRING"];
$table_name='';
$should_set_cookie=0;
//$domain=".mathtag.com";
//$domain=".designbloxlive.com";
$domain="192.168.102.143";



//#1 check optout cookie - if it is set don't do anything
if (!isset($_COOKIE['optout']))
{

	//#2 get the cookie here ---------
	//getting the server side cookie cookie
	$sCookieVal=$_COOKIE['uuid'];
	
	if($sCookieVal != "")
	{
		$url="http://dcs.imanadserver.com/user/dcs_determination/$sCookieVal";//"?format=json";
		$myvars = 'vendor_id=' . $vid . '&advertiser_id=' . $cid. '&product_id=' . $pids;

		$ch = curl_init( $url );
		curl_setopt( $ch, CURLOPT_POST, 1);
		curl_setopt( $ch, CURLOPT_POSTFIELDS, $myvars);
		curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt( $ch, CURLOPT_HEADER, 0);
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);

		$response = curl_exec( $ch );
	}
} # end if (!isset($_COOKIE['optout']))

// --- for tracking pixel fires
	// open and write query to file
	/*$fd = fopen("/d1/apps/gatewaylogs/data_query_log.log", "a");
	fwrite($fd, $qry . "\n");
	fclose($fd);*/
// --- end tracking pixel fires

if(!process_redir($_REQUEST)) { #if we don't find a redir variable, process_redir returns false. in that case, we want to do the below.
	header("Content-type: image/gif");
	echo file_get_contents("1x1.gif");
}
?>
