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
                        <span>Domains</span>
                        <a href="domain_create.php">New Domain</a>
                        <a href="#" >Transfer Domain</a>                        
                        <br />
                        </h3>
                	<table width="100%">
						<thead>
							<tr>
                            	<th width="40px"><a href="#" style="cursor:default;">ID<img src="display/img/icons/arrow_down_mini.gif" width="16" height="16" /></a></th>
                            	<th><a href="#" style="cursor:default;">Name</a></th>
                                <th width="80px"><a href="#" style="cursor:default;">EXP Date</a></th>
                                <th width="30px"><a href="#" style="cursor:default;">Auto</a></th>
                                <th width="60px"><a href="#" style="cursor:default;">Action</a></th>
                            </tr>
						</thead>
						<tbody>
			<?php                        
      		$query = "SELECT * FROM `domain` where `IsActive` = '1' ORDER BY `ID` DESC LIMIT 0 , 30";
	  		$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			
			
			$num=mysql_numrows($result);
			$i=0;
			

			while ($i <$num)
			{
				$ID=mysql_result($result,$i,"ID");
				$Name=mysql_result($result,$i,"Name");
				$ExDate=mysql_result($result,$i,"ExDate");
				$Autorenew=mysql_result($result,$i,"IsAutoRenew");
				$mysqldate = date( 'Y-m-d', strtotime( $ExDate ) );
				print "<tr><td>$ID</td><td>$Name</td><td>$mysqldate</td><td>$Autorenew</td><td>".
				"<a href=\"domain_view.php?ID=".$ID."\"><img src=\"display/img/icons/page_white_edit.png\" title=\"View Domain\" width=\"16\" height=\"16\" /></a>".
				"<a href=\"domain_delete_confirm.php?ID=".$ID."\"><img src=\"display/img/icons/delete.png\" title=\"Delete Domain\" width=\"16\" height=\"16\" /></a>".
				"<a href=\"domain_renew_confirm.php?ID=".$ID."\"><img src=\"display/img/icons/page_gear.png\" title=\"Renew Domain\" width=\"16\" height=\"16\" /></a>".
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
         <div align="center"><p><i><?php print SITE_FOOTNOTE; ?></i></p></div>
        </div>
</div>
</body>
</html>
