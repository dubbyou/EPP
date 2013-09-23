<?php
include('includes.php');
?> 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php print SITE_NAME; ?> - Dashboard</title>
<link rel="stylesheet" type="text/css" href="display/css/theme.css" />
<link rel="stylesheet" type="text/css" href="display/css/style.css" />

<!--[if IE]>
<link rel="stylesheet" type="text/css" href="../display/css/ie-sucks.css" />
<![endif]-->

<?php

$myEppHost = new EppHost;


if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$myEppHost->Load($_GET['ID']);
	}
}



?> 
</head>

<body>

	<div id="container">
    	<div id="header">
        	<h2>Depari Online</h2>
    <div id="topmenu">
            	<ul>
                	<li><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="registrant_home.php">Registrants</a></li>
                    <li class="current"><a href="domain_home.php">Domains</a></li>
                	<li><a href="transfer_home.php">Transfer</a></li>
              </ul>
          </div>
      </div>
        <div id="top-panel">
            <div id="panel">
                <ul>
                    <li><a href="#" class="report">Domain Report</a></li>
                </ul>
            </div>
      </div>
        <div id="wrapper">
            <div id="content">
                 
                    
                   <div id="box">
                	<h3 id="adduser">New Host</h3>
                    <form id="form" action="host_create_process.php" method="post">
                      <input name="DomainID"  id="DomainID" type="hidden" tabindex="1" value="<?php print $myEppHost->DomainID; ?>" />
                      <fieldset id="login">                      
                        <legend>Details </legend>
						
                        <table class="simple">
                            <tr><td><label for="NameServer">Nameserver : </label></td><td><input name="NameServer"  id="NameServer" type="text" tabindex="1" style="width:200px"/></td><td></td></tr>
                        </table>
                        


                      </fieldset>
                    
                      <div align="center">
                      <input id="button1" name="RegistrantCreate" type="submit" value="Create" /> 
                      <input id="button2" type="reset" />
                      </div>
                    </form>

                </div>
                <br />

            </div>
            <div id="sidebar">
  				<ul>
                	<li><h3><a href="#" class="house">Dashboard</a></h3>
                        <ul>
                        	<li><a href="#" class="report">Domain Report</a></li>
                        </ul>
                    </li>
				</ul>       
          </div>
      </div>
        <div id="footer">
        <div align="center"><p><i>Depari onine</i></p></div>
        </div>
</div>
</body>
</html>
