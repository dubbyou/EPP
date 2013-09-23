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

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$TempID = $_GET['ID'];
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
                    <li class="current"><a href="registrant_home.php">Registrants</a></li>
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
                        <span>Regestarnt EPP Values</span>
                        <br />
                    </h3>
					<?php
					
					if ($TempID==""){
						
						print "<p class=\"error\">Unable to run a check as the contact is blank</p>";
						
					}else{
						
						$myEppContact = new EppContact();
						$myEppContact->Info($TempID);
						
					}
					?>
						<br />
						<table class="simple">
                            <tr><td>ID : </td><td><?php print $myEppContact->ID; ?></td><td></td></tr>
                        	<tr><td width="100px">Company Name : </td><td width="250px"><?php print $myEppContact->Name; ?></td><td></td></tr>
                                                                                     
                            <tr><td><br /></td></tr>
                            <tr><td>Street Address : </td><td><?php print $myEppContact->Street; ?></td><td></td></tr>
                            <tr><td>Suburb : </td><td><?php print $myEppContact->Suburb; ?></td><td></td></tr>
                            <tr><td>City : </td><td><?php print $myEppContact->City; ?></td><td></td></tr>
                            <tr><td>Province : </td><td><?php print $myEppContact->Province; ?></td><td></td></tr>
                            <tr><td>Code : </td><td><?php print $myEppContact->Postalcode; ?></td><td></td></tr>    
                            <tr><td>Country : </td><td><?php print $myEppContact->Country; ?></td><td></td></tr>
                                                    
                            <tr><td><br /></td></tr>
                            <tr><td>Voice : </td><td><?php print $myEppContact->Voice; ?></td><td></td></tr>
                            <tr><td>Fax : </td><td><?php print $myEppContact->Fax; ?></td><td></td></tr>
                            <tr><td>Email : </td><td><?php print $myEppContact->Email; ?></td><td></td></tr>
                            <tr><td><br /></td></tr>
                        </table>	
                        
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
