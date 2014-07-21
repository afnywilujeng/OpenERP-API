
<!doctype html>
<html lang="en">

<head>
   <meta charset="utf-8"/>
   <title>Dashboard I Admin Panel</title>
   
   <link rel="stylesheet" href="css/layout.css" type="text/css" media="screen" />
   <!--[if lt IE 9]>
   <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen" />
   <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
   <![endif]-->
   <script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
   <script src="js/hideshow.js" type="text/javascript"></script>
   <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="js/jquery.equalHeight.js"></script>
   <script type="text/javascript">
   $(document).ready(function() 
      { 
           $(".tablesorter").tablesorter(); 
       } 
   );
   $(document).ready(function() {

   //When page loads...
   $(".tab_content").hide(); //Hide all content
   $("ul.tabs li:first").addClass("active").show(); //Activate first tab
   $(".tab_content:first").show(); //Show first tab content

   //On Click Event
   $("ul.tabs li").click(function() {

      $("ul.tabs li").removeClass("active"); //Remove any "active" class
      $(this).addClass("active"); //Add "active" class to selected tab
      $(".tab_content").hide(); //Hide all tab content

      var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
      $(activeTab).fadeIn(); //Fade in the active ID content
      return false;
   });

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>

</head>


<body>

   <header id="header">
      <hgroup>
         <h1 class="site_title"><a href="index.html">Website Admin</a></h1>
         <h2 class="section_title">Dashboard</h2><div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div>
      </hgroup>
   </header> <!-- end of header bar -->
   
   <section id="secondary_bar">
      <div class="user">
         
            
            
            <p>ADMIN</p>
         <!-- <a class="logout_user" href="#" title="Logout">Logout</a> -->
      </div>
      <div class="breadcrumbs_container">
         <article class="breadcrumbs"><a href="index.html">Website Admin</a> <div class="breadcrumb_divider"></div> <a class="current">Dashboard</a></article>
      </div>
   </section><!-- end of secondary bar -->
      <?php include"option.php"; ?>
   <section id="main" class="column">
      <?php

$host = "localhost";
$port = "8069";
$username = "admin";
$password = "admin";

$id="5";

require_once 'xmlrpc.inc';


class OpenERPXmlrpc {

   private $user, $password, $database, $services, $client, $res, $msg, $id;

   function __construct($usr, $pass, $db, $server, $id) {
   
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

      }
      else {
      
         echo "Unable to login ".$this->res->faultString();
         exit;
      }
   }

   

   function read($post = null) {

      $this->client = new xmlrpc_client($this->services.'object');

      $this->id = $_GET['login'];

      if(empty($post)) {
         $ids_read = array(new xmlrpcval($this->id, 'int'));
        // var_dump($ids_read);
         $key = array(new xmlrpcval('id','integer') , new xmlrpcval('name', 'string'), new xmlrpcval('work_email', 'string'), new xmlrpcval('work_phone', 'string'), new xmlrpcval('mobile_phone', 'string'),new xmlrpcval('work_location', 'string'));
         
         $this->msg = new xmlrpcmsg('execute');
         $this->msg->addParam(new xmlrpcval($this->database, "string"));
         $this->msg->addParam(new xmlrpcval(1, "int"));
         $this->msg->addParam(new xmlrpcval($this->password, "string"));
         $this->msg->addParam(new xmlrpcval("hr.employee","string"));
         $this->msg->addParam(new xmlrpcval("read", "string"));
         $this->msg->addParam(new xmlrpcval($ids_read, "array"));
         $this->msg->addParam(new xmlrpcval($key, "array"));

         $this->res = &$this->client->send($this->msg);
         
         if(!$this->res->faultCode()) {
          'include"css.php"';
         
            $read_html = '<table width="20%" border="0" cellpadding="4" cellspacing="4" align="center">
                        <tr>
                           <th>Id</th>
                           <th>Name</th>
                           <th>work email</th>
                           <th>work phone</th>
                           <th>mobile_phone</th>
                           <th>office location</th>
                        </tr>
                     ';
            
            $scalval = $this->res->value()->scalarval();

            foreach ($scalval as $keys => $values) {
            
               $value = $values->scalarval();
               //var_dump($value['birthday']);
               $read_html .= '
                     <tr>
                        <td>'.$value['id']->scalarval().'</td>
                        <td>'.$value['name']->scalarval().'</td>
                        <td>'.$value['work_email']->scalarval().'</td>
                        <td>'.$value['work_phone']->scalarval().'</td>
                        <td>'.$value['mobile_phone']->scalarval().'</td>
                        <td>'.$value['work_location']->scalarval().'</td>
                     </tr>
                     <tr><td colspan="2"></td></tr>
                        ';
            }

            $read_html .= '
                     </table>
                     ';
            return $read_html;
         }
         else {
            return "Not read recode from partner table <br />".$this->res->faultString();
         }
      }
   }
}

   $cnt = new OpenERPXmlrpc($username, $password, 'erp', 'http://'.$host.':'.$port.'/xmlrpc/',$id);

   echo $cnt->read();

?>
     <div class="clear"></div><!-- end of post new article --><!-- end of styles article -->
     <div class="spacer"></div>
   </section>
</body>
</html>