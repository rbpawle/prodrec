<?php
//$domain=".mathtag.com";
//$domain=".designbloxlive.com";
$domain="192.168.102.143";

//#1 check optout cookie - if it is set don't do anything
if (!isset($_COOKIE['optout']))
{

	$cookie=uniqid(md5(rand()),true);
	setcookie("uuid",$cookie,time()+31536000,"/",$domain);
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
