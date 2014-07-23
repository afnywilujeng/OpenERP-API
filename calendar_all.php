<?php

//xmlrpc
@require_once 'config.php';

//me
if (file_exists('config.local.php'))
   require_once 'config.local.php';

require_once 'xmlrpc.inc';

$error = false;

try {
   if (!$host)
      throw new Exception('config host tidak ditemukan');
   if (!$port)
      throw new Exception('config port tidak ditemukan');
   if (!$username)
      throw new Exception('config username tidak ditemukan');
   if (!$password)
      throw new Exception('config passwod tidak ditemukan');


   $client = new xmlrpc_client('http://' . $host . ':' . $port . '/xmlrpc/object');
   $sock   = new xmlrpc_client('http://' . $host . ':' . $port . '/xmlrpc/common');

   $sock_msg = new xmlrpcmsg('login');
   $sock_msg->addParam(new xmlrpcval($dbname, "string"));
   $sock_msg->addParam(new xmlrpcval($username, "string"));
   $sock_msg->addParam(new xmlrpcval($password, "string"));
   $sock_resp = $sock->send($sock_msg);

   if ($sock_resp->errno != 0)
      throw new Exception('Login Error');


   $sock_val = $sock_resp->value();

   $user_id = $sock_val->scalarval();


   //get my calender
   $today  = time();
   $before = strtotime('-5 month');
   $next   = strtotime('+5 month');
   $key    = array(
      new xmlrpcval (
         array(
            new xmlrpcval('date', "string"), // field name
            new xmlrpcval('>=', "string"), // operator
            new xmlrpcval(strftime('%Y-%m-%d %H:%M:%S', $before), "string")), "array"),
      new xmlrpcval (
         array(
            new xmlrpcval('date', "string"), // field name
            new xmlrpcval('<=', "string"), // operator
            new xmlrpcval(strftime('%Y-%m-%d %H:%M:%S', $next), "string")), "array"),

   );


   $msg = new xmlrpcmsg('execute');
   $msg->addParam(new xmlrpcval($dbname, "string"));
   $msg->addParam(new xmlrpcval($user_id, "int"));
   $msg->addParam(new xmlrpcval($password, "string"));
   $msg->addParam(new xmlrpcval('crm.meeting', "string"));
   $msg->addParam(new xmlrpcval("search", "string"));
   $msg->addParam(new xmlrpcval($key, "array"));

   $resp = $client->send($msg);
   $val  = $resp->value();

   if (!$val)
      throw new Exception('Error Request XML RPC');
   $ids = $val->scalarval(); // here we will get the return ids

   if (!$ids)
      throw new Exception('Calender dengan kriteria yang diinginkan tidak ditemukan');

   $idCals = array();
   foreach ($ids as $i) {
      $idCals[] = new xmlrpcval($i->scalarval(), 'int');
   }

   //TODO: pagination by array idcals

   //read details
   $key = array(
      new xmlrpcval('name', 'string'),
      new xmlrpcval('date', 'string'),
      new xmlrpcval('user_id', 'string'),
      new xmlrpcval('duration', 'string'),
   );
   $msg = new xmlrpcmsg('execute');
   $msg->addParam(new xmlrpcval($dbname, "string"));
   $msg->addParam(new xmlrpcval($user_id, "int"));
   $msg->addParam(new xmlrpcval($password, "string"));
   $msg->addParam(new xmlrpcval("crm.meeting", "string"));
   $msg->addParam(new xmlrpcval("read", "string"));
   $msg->addParam(new xmlrpcval($idCals, "array")); // sending id which is to be read
   $msg->addParam(new xmlrpcval($key, "array")); // sending an array of field
   $resp = $client->send($msg);


   $val = $resp->value();

   if (!$val)
      throw new Exception('Error Request XML RPC');

   $myCalenders = $val->scalarval();


} catch (Exception $e) {
   $error = $e->getMessage();
   //display last response on error
   if ($resp)
      var_dump($resp);

}

?>
<head>
   <meta charset="utf-8"/>
   <title>Dashboard I Admin Panel</title>

   <link rel="stylesheet" href="css/layout.css" type="text/css" media="screen"/>
   <!--[if lt IE 9]>
   <link rel="stylesheet" href="css/ie.css" type="text/css" media="screen"/>
   <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
   <![endif]-->
   <script src="js/jquery-1.5.2.min.js" type="text/javascript"></script>
   <script src="js/hideshow.js" type="text/javascript"></script>
   <script src="js/jquery.tablesorter.min.js" type="text/javascript"></script>
   <script type="text/javascript" src="js/jquery.equalHeight.js"></script>
   <script type="text/javascript">
      $(document).ready(function () {
            $(".tablesorter").tablesorter();
         }
      );
      $(document).ready(function () {

         //When page loads...
         $(".tab_content").hide(); //Hide all content
         $("ul.tabs li:first").addClass("active").show(); //Activate first tab
         $(".tab_content:first").show(); //Show first tab content

         //On Click Event
         $("ul.tabs li").click(function () {

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
      $(function () {
         $('.column').equalHeight();
      });
   </script>

</head>


<body>

<header id="header">
   <hgroup>
      <h1 class="site_title"><a href="index.html">Website Admin</a></h1>

      <h2 class="section_title">Dashboard</h2>

      <div class="btn_view_site"><a href="http://www.medialoot.com">View Site</a></div>
   </hgroup>
</header>
<!-- end of header bar -->

<section id="secondary_bar">
   <div class="user">

   </div>
   <div class="breadcrumbs_container">
      <article class="breadcrumbs"><a href="index.html">Website Admin</a>

         <div class="breadcrumb_divider"></div>
         <a class="current">Dashboard</a></article>
   </div>
</section>
<!-- end of secondary bar -->

<?php include "option.php"; ?>

<section id="main" class="column"><!-- end of stats article --><!-- end of content manager article -->
   <!-- end of messages article -->

   <div class="clear"></div>

   <article class="module width_full">
      <header><h3>Semua Calender </h3></header>
      <div class="module_content">
         <?php if ($error) { ?>
            <h4 class="alert_error"><?php echo $error ?></h4>
         <?php } else { ?>
            <?php if ($myCalenders) { ?>
               <table class="tablesorter">
                  <thead>
                  <th>Subject</th>
                  <th>Responsible</th>
                  <th>Date</th>
                  <th>Duration</th>
                  </thead>
                  <tbody>
                  <?php $fetchedUser = array(); ?>
                  <?php foreach ($myCalenders as $mc) { ?>
                     <?php $m = $mc->scalarval(); ?>
                     <tr>
                        <td><?php echo $m['name']->scalarval() ?></td>
                        <td><?php
                           $user = $m['user_id']->scalarval();
                           echo $user[1]->scalarval();
                           ?></td>
                        <td><?php echo $m['date']->scalarval() ?></td>
                        <td><?php echo $m['duration']->scalarval() ?></td>
                     </tr>
                  <?php } ?>
                  </tbody>
               </table>
            <?php } ?>
         <?php } ?>
      </div>


      <footer>


      </footer>

   </article>
</section>
</body>
              
    

