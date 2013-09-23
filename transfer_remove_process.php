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
<link rel="stylesheet" type="text/css" href="display/css/ie-sucks.css" />
<![endif]-->


<?php

$myEppTransfer= new EppTransfer;

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$myEppTransfer->Load($_GET['ID']);
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
                    <li><a href="domain_home.php">Domains</a></li>
                	<li class="current"><a href="transfer_home.php">Transfer</a></li>
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
                 
                 
                 <br />
                    
                   <div id="rightnow">
                	<h3 class="reallynow">
                     <span>Domain - <?php print "$myEppTransfer->Name"; ?></span>
                     <a href="transfer_view_epp.php?ID=<?php print "$myEppTransfer->ID"; ?>" class="modules">EPP View</a>

                     <br />
                     </h3>
		
                    <?php
					
					if ($myEppTransfer->ID == ""){
						
						print "<p lass=\"error\">Unable remove transfer</p>";
						
					}else{

											$resultcode = $myEppTransfer->Remove();

					}
					?>



                </div>
                <br />
                
                
                
                
                
                
                
                <!------------------------------------------------------->
                

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
