<?php
require_once 'xmlrpc.inc';
?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]> <html class="lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]> <html class="lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html lang="en"> <!--<![endif]-->
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dark Login Form</title>
  <link rel="stylesheet" href="css/style.css">
  <!--[if lt IE 9]><script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
</head>
<body>
  <form method="get" action="" class="login">
    <p>
      <label for="Host">Host:</label>
      <input type="text" name="host" id="host" value="172.17.1.151">
    </p>

    <p>
      <label for="Port">Port:</label>
      <input type="text" name="port" id="port" value="8069">
    </p>
	
	<p class="login-submit">
      <button type="submit" class="login-button">Login</button>
    </p>

  </form>
  </br>
  
<?php
$host = $_GET['host'];
$port = $_GET['port'];
$server = 'http://'.$host.':'.$port.'/xmlrpc/';
$client = new xmlrpc_client($host.'/db');
$resp = $client -> send("list");
$val = $resp->value();
echo $val;
?>
	

	
  <form method="post" action="coba.php" class="login">	
  <input type=hidden name="host" id="host" value="<?php echo $host ?>">
  <input type=hidden name="port" id="port" value="<?php echo $port ?>">
    <p>
      <label for="login">Username:</label>
      <input type="text" name="username" id="username" value="admin">
    </p>

    <p>
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" value="admin">
    </p>

	
	<p class="login-submit">
      <button type="submit" class="login-button">Login</button>
    </p>

  </form>

  
</body>
</html>
