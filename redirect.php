<?php
#created by rpawle, 8/31/2011

#in these functions, we:
#1) check the variables being passed in in the request URL via $_REQUEST. If the variable "redir" exists,
#2) unencode the "redir" value
#3) check to see if the unencoded "redir" value has a "[mm_uuid]" tag. If it does, replace it with the value from the cookie variable "uuid"
#4) put the result of the change into an http header like this - http://php.net/manual/en/function.header.php
#5) send the header out

function getClientIP() {
        if (isset ($_SERVER ['HTTP_X_FORWARDED_FOR'])){ $clientIP = $_SERVER ['HTTP_X_FORWARDED_FOR']; }
        elseif (isset ($_SERVER ['HTTP_X_REAL_IP'])){ $clientIP = $_SERVER ['HTTP_X_REAL_IP']; }
        else { $clientIP = $_SERVER ['REMOTE_ADDR']; }
        return $clientIP;
};

function process_redir() { 
        $redir = urldecode($_REQUEST['redir']);
        if ($redir != NULL) {   #if there's a redirect, set the MM_UUID and go there
                #check to see if we have 'http://' or 'http://' at the beginning
                if(strpos($redir, 'http://') == FALSE || strpos($redir, 'https://') == FALSE) {
                        $redir = 'http://'.$redir;
                }
                #check to see if we have a [mm_uuid] and a uuid. if so, replace it with the uuid cookie value.
                if(strpos($redir, '[MM_UUID]') && isset($_COOKIE['uuid']) ) {
                        $redir = str_replace('[MM_UUID]', $_COOKIE['uuid'], $redir);
                }
                
                #check for x-forwarded-for information. we're not doing anything with this.
                $clientIP = getClientIP();
                
                header("Location: $redir");
                
                return true;
        }
        else {
                return false;
        }
};

?>
