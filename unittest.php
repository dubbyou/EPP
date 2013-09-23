<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include('settings.php');
include('classes/class.EppTCPTransport.php');
include('classes/class.EppServer.php');
include('classes/class.EppDatabase.php');
include('classes/class.EppRegistrar.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print SITE_NAME; ?> Dashboard</title>
</head>

<body>
<?php
$myEppRegistrar = new EppRegistrar();
$myEppServer = new EppServer();
?>

<p>General Settings Settings</p>
<table>
<tr><td>Site Name</td><td><?php print SITE_NAME; ?></td></tr>
<tr><td>Debug Level</td><td><?php print DEBUG_lEVEL; ?></td></tr>
</table>

<p>Current Database Settings</p>
<table>
<tr><td>Database Server</td><td><?php print DB_SERVER; ?></td></tr>
<tr><td>Database User</td><td><?php print DB_USER; ?></td></tr>
<tr><td>Database Name</td><td><?php print DB_NAME; ?></td></tr>
<tr><td>Database Pasword</td><td><?php print DB_PASS; ?></td></tr>
</table>

<p>Current EPP Settings</p>
<table>
<tr><td>EPP Server</td><td><?php print EPP_SERVER; ?></td></tr>
<tr><td>EPP Port</td><td><?php print EPP_PORT; ?></td></tr>
<tr><td>EPP Username</td><td><?php print EPP_USERNAME; ?></td></tr>
<tr><td>EPP Pasword</td><td><?php print EPP_PASSWORD; ?></td></tr>
<tr><td></td><td></td></tr>
</table>


<p>Transactions</p>
<table>
<tr><td>Total Transactions</td><td><?php print $myEppServer->TotalChats(); ?></td></tr>
</table>

<p>Registrant</p>
<table>
<tr><td valign="top">Balance</td><td><?php print $myEppRegistrar->Balance(); ?></td></tr>
</table>

</body>
</html>