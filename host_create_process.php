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
       			<div id="rightnow">
                    <h3 class="reallynow">
                        <span>Host update</span>
                        <br />
                    </h3>
					<?php
					$DomainID  = $_POST["DomainID"];
					$NameServer  = $_POST["NameServer"];
					
					
					if ($DomainID == ""){
						
						print "<p>Unable to run a check as the domain is blank</p>";
						
					}else{
						
								if(DEBUG_lEVEL >=5){ print "<p>Domain $DomainID</p>";}
								if(DEBUG_lEVEL >=5){ print "<p>NameServer $NameServer</p>";}
									$myEppHost->Create($DomainID,$NameServer);			
					
					}
					?>
						<div align="right">
                          <a href="domain_view.php?ID=<?php print "$DomainID"; ?>">Return </a>
                        </div>
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
