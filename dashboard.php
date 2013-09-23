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
                        <span>Messages</span>
                        <a href="message_poll_manual.php" >Poll</a>
                        <br />
                    </h3>
				    <table width="100%">
						<thead>
							<tr>
                            	<th width="70px"><a href="#" style="cursor:default;">Date</a></th>
                                <th><a href="#" style="cursor:default;">Message</a></th>
                                <th><a href="#" style="cursor:default;"></a></th>
                            </tr>
						</thead>
						<tbody>
			<?php                        
      		$query = "SELECT * FROM `message` where `IsAck` = '0' ORDER BY `message`.`ID` DESC LIMIT 0 , 30";
	  		$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			
			$num=mysql_numrows($result);
			$i=0;
			
			while ($i <$num)
			{
				$id=mysql_result($result,$i,"ID");
				$date=mysql_result($result,$i,"Date");
				$Message=mysql_result($result,$i,"Message");	
				$mysqldate = date( 'Y-m-d', strtotime( $date ) );	
				$mysqltime = date( 'G:i', strtotime( $date ) );		
				print "<tr><td>$mysqldate</td><td>$Message</td><td align=\"right\">".
				"<a href=\"message_view.php?ID=".$id."\"><img src=\"display/img/icons/view.png\" title=\"Show Message\" width=\"16\" height=\"16\" /></a>".
				"<a href=\"message_ack_process.php?ID=".$id."\"><img src=\"display/img/icons/success_blue.png\" title=\"ACK Message\" width=\"16\" height=\"16\" /></a>".				
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
                    per page |  --> Total <strong><?php // print $num; ?></strong> records found
                    </div>
                    
                    
                    
                    
                    
			  </div>
              <div id="infowrap">
              <!------------ General Infromation Info Box --------------------->
				<div id="infobox">
                    <h3>General Information</h3>
                    <?php
						$myEppContact = new EppContact;
					
					?>
                    
                    <table>
						<thead>
							<tr>
                            	<th>Item</th>
                                <th>Total</th>
                            </tr>
						</thead>
						<tbody>
							<tr>
                            	<td><a href="#">Total Registrants</a></td>
                                <td><?php print $myEppContact->TotalActive();?></td>
                            </tr>
						</tbody>
					</table>            
                  </div>
              <!------------------------------------------------------>
                  <!----------------Epp Domain Check --------------------->  
                 <div id="infobox" class="margin-left">
                    <h3>Domain Availability Check </h3>
                    <br /> 
                    <p align="center">Enter a Domain to check avalibility.</p>
                    <form method="post" action="domain_check.php">
                    <table>
							<tr>
                            	<td style="border:none;" align="center" ><input type="text" name="name" style="width:240px;" value="test.dnservices.co.za"/></a><input type="submit" value=" Check "/></td>
                            </tr>
					</table>
                    </form>
                  </div>
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
