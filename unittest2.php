<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
include('settings.php');
include('classes/class.EppTCPTransport.php');
include('classes/class.EppServer.php');
include('classes/class.EppDatabase.php');
include('classes/class.EppRegistrar.php');
include('classes/class.EppContact.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print SITE_NAME; ?> Dashboard</title>
</head>
<?php
$myEppContact = new EppContact();
$myEppContact->Create();
?>