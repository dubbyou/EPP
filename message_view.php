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
</head>
<?php

$myEppMessage = new EppMessage;

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$myEppMessage->Load($_GET['ID']);
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
                	<li class="current"><a href="dashboard.php">Dashboard</a></li>
                    <li><a href="registrant_home.php">Registrants</a></li>
                    <li><a href="domain_home.php">Domains</a></li>
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
                        <span>Epp Message</span>
                        <a href="message_ack_process.php?ID=<?php print "$myEppMessage->ID"; ?>">ACK</a>
                        <br />
                    </h3>
                    
                    
                    
					<?php
					
					if ($myEppMessage->ID == ""){
						
						print "<p class=\"error\">Unable to run a check as the message is blank</p>";
						
					}else{
						
										$mysqldate = date( 'Y-m-d', strtotime( $myEppMessage->Date ) );	
										$mysqltime = date( 'G:i', strtotime( $myEppMessage->Date ) );		
									?>	
																<br />
                                            					<table class="simple">
                                                                    <tr><td>Date : </td><td><?php print $mysqldate  ?></td><td></td></tr>
                                                                    <tr><td>Time : </td><td><?php print $mysqltime ?></td><td></td></tr>
                                                                                                                             
                                                                    <tr><td><br /></td></tr>
                                                                    <tr><td>Message : </td><td><?php print $myEppMessage->Message; ?></td><td></td></tr>
                                                                    <tr><td>EPP ID : </td><td><?php print $myEppMessage->EPPID; ?></td><td></td></tr>
                                                                    <tr><td>Actioned : </td><td><?php print $myEppMessage->IsActioned; ?></td><td></td></tr>
                                                                    <tr><td>Is Transfer : </td><td><?php print $myEppMessage->IsDomainTransfer; ?></td><td></td></tr>
                                                                    
                                                                    <?php
																	if ($myEppMessage->IsDomainTransfer > 0){
																		?>
                                                                    	 <tr><td>Approve Transfer : </td><td><?php 
																					print "<a href=\"transfer_approve_process.php?ID=$myEppMessage->DomainID\">Approve Transfer</a>";
																				?></td><td></td></tr>


                                                                                  <tr><td>Reject Transfer : </td><td><?php 
																					print "<a href=\"transfer_reject_process.php?ID=$myEppMessage->DomainID\">Reject Transfer</a>";
																				?></td><td></td></tr>
                                                                        <?php
																	}
                                                                    ?>
                                                                    <tr><td><br /></td></tr>
                                                                </table>	
                                                                <div align="right">

                                                                </div>
                                            
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
			<div align="center"><p><i><?php print SITE_FOOTNOTE; ?></i></p></div>
        </div>
</div>
</body>
</html>
