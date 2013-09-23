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
</head>

<body>

	<div id="container">
    	<div id="header">
        	<h2><?php print SITE_NAME; ?></h2>
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
                	<h3 id="adduser">Processing New Domain</h3>
                    <?php
					$DomainName  = $_POST["DomainName"];
					$ContactID  = $_POST["ContactID"];

					
					
					if ($DomainName == "" ||$ContactID == ""){
						
						print "<p lass=\"error\">Unable to register the contact as data is missing</p>";
						
					}else{

											
											$myEppDomain = new EppDomain();
											$resultcode = $myEppDomain->Move($DomainName,$ContactID,"coza");
									
											if ($resultcode == 1000){
																			?>
																			<table class="simple">
																				<tr><td width="100px">Domain Name : </td><td width="250px"><?php print $DomainName; ?></td><td></td></tr>
																				<tr><td>Contact : </td><td><?php print $myEppDomain->ContactID; ?></td><td></td></tr>
																																		 
																				<tr><td><br /></td></tr>
																				<tr><td>Created : </td><td><?php print $myEppDomain->CrDate; ?></td><td></td></tr>
																				<tr><td>Expires : </td><td><?php print $myEppDomain->ExDate; ?></td><td></td></tr>
																				<tr><td>Days Left : </td><td></td><td></td></tr>
													
																			</table>	
																			
																			<a href="domain_home.php">Return</a>
																		<?php
					
					
											}elseif ($resultcode == 2104){
												print "<p class=\"warning\">Insufficient credit available</p>";
											}elseif ($resultcode == 2302){
												print "<p class=\"warning\">Domain is in Use</p>";
											}else{
												print "<p class=\"error\">Unknown Error</p>";
											}

							

					}
					?>
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
        <div align="center"><p><i><?php print SITE_FOOTNOTE; ?></i></p></div>
        </div>
</div>
</body>
</html>
