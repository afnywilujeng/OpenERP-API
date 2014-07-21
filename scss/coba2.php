<?php
function connect() {
   var $user = 'admin';
   var $password = 'admin';
   var $dbname = 'erp';
   var $server_url = 'http://localhost:8069/xmlrpc/';


   if(isset($_COOKIE["user_id"]) == true)  {
       if($_COOKIE["user_id"]>0) {
       return $_COOKIE["user_id"];
       }
   }

   $sock = new xmlrpc_client($server_url.'common');
   $msg = new xmlrpcmsg('login');
   $msg->addParam(new xmlrpcval($dbname, "string"));
   $msg->addParam(new xmlrpcval($user, "string"));
   $msg->addParam(new xmlrpcval($password, "string"));
   $resp =  $sock->send($msg);
   $val = $resp->value();
   $id = $val->scalarval();
   setcookie("user_id",$id,time()+3600);
   if($id > 0) {
       return $id;
   }else{
       return -1;
   }
 }


?>