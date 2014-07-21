<?php

$host = "localhost";
$port = "8069";
$username = "admin";
$password = "admin";

require_once 'xmlrpc.inc';


class OpenERPXmlrpc {

   private $user, $password, $database, $services, $client, $res, $msg, $id;

   function __construct($usr, $pass, $db, $server) {
   
      $this->user = $usr;
      $this->password = $pass;
      $this->database = $db;
      $this->services = $server;
      
      $this->client = new xmlrpc_client($this->services.'common');

      $this->msg = new xmlrpcmsg('login');
      $this->msg->addParam(new xmlrpcval($this->database, "string"));
      $this->msg->addParam(new xmlrpcval($this->user, "string"));   
      $this->msg->addParam(new xmlrpcval($this->password, "string"));

      $this->res =  &$this->client->send($this->msg);
      
      if(!$this->res->faultCode()){
      
         $this->id = $this->res->value()->scalarval();
		 echo "berhasil login dengan id = ".$this->id;

      }
      else {
      
         echo "Unable to login ".$this->res->faultString();
      }
         exit;
   }

   function read($post = null) {
      
      $this->client = new xmlrpc_client($this->services.'object');


$name = $_POST['name'];
$mobile_phone = $_POST['mobile_phone'];
      
      if(empty($post)) {
                  
         //$ids_read = array(new xmlrpcval($this->id, 'int'));

         //$key = array(new xmlrpcval(Earlan,'integer') , new xmlrpcval('name', 'string'));
		 
		 $arrayVal = array(
			'name'=>new xmlrpcval($name, "string") ,
         'mobile_phone'=>new xmlrpcval($mobile_phone , "string")
		);
         $this->msg = new xmlrpcmsg('execute');
         $this->msg->addParam(new xmlrpcval($this->database, "string"));
         $this->msg->addParam(new xmlrpcval(1, "int"));
         $this->msg->addParam(new xmlrpcval($this->password, "string"));
         $this->msg->addParam(new xmlrpcval("hr.employee","string"));
         $this->msg->addParam(new xmlrpcval("create", "string"));
         //$this->msg->addParam(new xmlrpcval($ids_read, "array"));
         $this->msg->addParam(new xmlrpcval($arrayVal, "struct"));

         $this->res = &$this->client->send($this->msg);
         
         if(!$this->res->faultCode()) {
            return ' created !';
         }
         else {
            return "Not read recode from partner table <br />".$this->res->faultString();
         }
      }
   }
}


$cnt = new OpenERPXmlrpc($username, $password, 'erp', 'http://'.$host.':'.$port.'/xmlrpc/');

echo $cnt->read();

?>