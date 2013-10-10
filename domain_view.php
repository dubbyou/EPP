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

$myEppDomain = new EppDomain;
$myEppContact = new EppContact;

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$myEppDomain->Load($_GET['ID']);
    	$myEppContact->Load($myEppDomain->ContactID);
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
                 
                 <?php
							  if ($myEppDomain->IsAutoRenew == 1){
								  print "<p class=\"info\">This Domain is set to Auto Renew</p>";
							  } else{
								  print "<p class=\"warning\">This Domain is <b>Not</b> set to Auto Renew</p>";
							  }
				 ?>
                 <br />
                    
                   <div id="rightnow">
                	<h3 class="reallynow">
                    <span>Domain - <?php print "$myEppDomain->Name"; ?></span>
                     <a href="domain_view_epp.php?ID=<?php print "$myEppDomain->ID"; ?>" >EPP View</a>
                     <a href="domain_change_contact.php?ID=<?php print "$myEppDomain->ID"; ?>" >Change Registrants</a>
                     <a href="domain_syncback.php?ID=<?php print "$myEppDomain->ID"; ?>" >Sync Back</a>
					 <a href="domain_update_cancel.php?ID=<?php print "$myEppDomain->ID"; ?>" >Cancel Pending</a>
                    <br  />
                     </h3>
																			<?php
																				//days left
																				$now = time(); 
																				$days = floor((strtotime($myEppDomain->ExDate) - strtotime(date("Y-m-d"))) / (60 * 60 * 24));
																				
																			?>
																			<table class="simple">
																				<tr><td width="100px">Domain Name : </td><td width="250px"><?php print "$myEppDomain->Name"; ?></td><td></td></tr>
																				<tr><td>Registrant ID: </td><td><?php print "<a href=\"registrant_view.php?ID=$myEppDomain->ContactID\">".$myEppDomain->ContactID."</a>"; ?></td><td></td></tr>
                                                            <tr><td>Registrant Name: </td><td><?php print $myEppContact->Name; ?></td><td></td></tr>
                                                            <tr><td>Status: </td><td><?php print $myEppDomain->Status; ?></td><td></td></tr>
														 
																				<tr><td><br /></td></tr>
																				<tr><td>Created : </td><td><?php print $myEppDomain->CrDate; ?></td><td></td></tr>
																				<tr><td>Expires : </td><td><?php print $myEppDomain->ExDate; ?></td><td></td></tr>
																				<tr><td>Days Left : </td><td><?php print $days; ?></td><td></td></tr>
                                                                                
                                                                                
                                                                                <tr><td>AutoRenew : </td><td><?php 
																																							
																				if ($myEppDomain->IsAutoRenew == "1"){
																					print "<a href=\"domain_autorenew_process.php?ID=$myEppDomain->ID\">Turn Auto Renew OFF</a>";
																				} else{
																					print "<a href=\"domain_autorenew_process.php?ID=$myEppDomain->ID\">Turn Auto Renew ON</a>";
																				}
																				
																				
																				?></td><td></td></tr>
                                                                                
                                                                                 <tr><td>On Hold : </td><td><?php 
																																							
																				if ($myEppDomain->IsOnHold == "1"){
																					print "<a href=\"domain_onhold_process.php?ID=$myEppDomain->ID\">Turn On Hold OFF</a>";
																				} else{
																					print "<a href=\"domain_onhold_process.php?ID=$myEppDomain->ID\">Turn On Hold ON</a>";
																				}
																				
																				
																				?></td><td></td></tr>
                                                                                
                                                                                
                                                                                  <tr><td>Approve Transfer : </td><td><?php 
																					print "<a href=\"transfer_approve_process.php?ID=$myEppDomain->ID\">Approve Transfer</a>";
																				?></td><td></td></tr>


                                                                                  <tr><td>Reject Transfer : </td><td><?php 
																					print "<a href=\"transfer_reject_process.php?ID=$myEppDomain->ID\">Reject Transfer</a>";
																				?></td><td></td></tr>
													
																			</table>	





                </div>
                <br />
                
                
                
                
                
                
                
                <!------------------------------------------------------->
                
                 <div id="rightnow">
                     <h3 class="reallynow">
                        <span>"<?php print "$myEppDomain->Name"; ?>" Hosts</span>
                        <a href="host_create.php?ID=<?php print $myEppDomain->ID; ?>" >New Host</a>
                        <br />
                        </h3>
                	<table width="100%">
						<thead>
							<tr>
                            	<th><a href="#" style="cursor:default;">Name</a></th>
                                <th width="60px"><a href="#" style="cursor:default;">Action</a></th>
                            </tr>
						</thead>
						<tbody>
			<?php                        
      		$query = "SELECT * FROM `host` where `IsActive` = '1' AND `DomainID` = '$myEppDomain->ID' ORDER BY `host`.`ID` DESC LIMIT 0 , 30";
	  		$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			
			$num=mysql_numrows($result);
			$i=0;
			
			while ($i <$num)
			{
				$ID=mysql_result($result,$i,"ID");
				$Name=mysql_result($result,$i,"Name");
				print "<tr><td>$Name</td><td>".
				"<a href=\"host_delete_confirm.php?ID=".$ID."\"><img src=\"display/img/icons/delete.png\" title=\"Delete Host\" width=\"16\" height=\"16\" /></a>".
				"</td></tr>";
				
				$i++;
			}
			
			?>                       
          
  					              
						</tbody>
					</table>
					

                    <div id="pager">
                    	Page <a href="#"><img src="display/img/icons/arrow_left.gif" width="16" height="16" /></a> 
                    	<input size="1" value="1" type="text" name="page" id="page" /> 
                    	<a href="#"><img src="display/img/icons/arrow_right.gif" width="16" height="16" /></a>of 
                    pages | <!-- View <select name="view">
                    				<option>10</option>
                                    <option>20</option>
                                    <option>50</option>
                                    <option>100</option>
                    			</select>
                    per page |  --> Total <strong><?php print $num; ?></strong> records found
                    </div>
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
