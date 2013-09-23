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
$myEppDomain = new EppDomain;

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$myEppDomain->Load($_GET['ID']);
	}
}

?> 
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
       			<div id="rightnow">
                    <h3 class="reallynow">
                        <span>Domain Details</span>
                        <br />
                    </h3>
					<?php
					
					if ($myEppDomain->ID == ""){
						
						print "<p>Unable to run a check as the domain is blank</p>";
						
					}else{
						
						
						
							$myEppDomain->Renew();
											
											
						?>
<table class="simple">
                                        <tr><td width="100px">Domain Name : </td><td width="250px"><?php print "$myEppDomain->Name"; ?></td><td></td></tr>
                                        <tr><td>Registrant ID: </td><td><?php print "<a href=\"registrant_view.php?ContactId=$myEppDomain->ContactID\">".$myEppDomain->ContactID."</a>"; ?></td><td></td></tr>
                                        <tr><td>Registrant Name: </td><td></td><td></td></tr>
                 
                                        <tr><td><br /></td></tr>
                                        <tr><td>Created : </td><td><?php print $myEppDomain->CrDate; ?></td><td></td></tr>
                                        <tr><td>Expires : </td><td><?php print $myEppDomain->ExDate; ?></td><td></td></tr>
                                        <tr><td>Days Left : </td><td></td><td></td></tr>
                                        
                                        
                                        <tr><td>AutoRenew : </td><td><?php 
                                                                                                                    
                                        if ($myEppDomain->IsAutoRenew == "0"){
                                            print "Auto Renew is OFF ";
                                        } else{
                                            print "Auto Renew is ON ";
                                        }
                                        
                                        
                                        ?></td><td></td></tr>
                                        <tr><td>Hosts : </td><td><?php print $myEppHost->EppHostDomainCount($myEppDomain->EppDomainID); ?></td><td></td></tr>
                                        </table>
                        <?php					
						

						
					}
					?>

			  </div>
              <div id="infowrap">

                <!--------------------------------------------------->
                
                
              </div>
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
