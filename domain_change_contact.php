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
                	<h3 id="adduser">Change Domain Registrant</h3>
                    <form id="form" action="domain_change_contact_process.php" method="post">
                    <input name="DomainID"  id="DomainID" type="hidden" tabindex="1" value="<?php print $myEppDomain->ID; ?>" />
                      <fieldset id="login">                      
                        <legend>Details </legend>
						
                        <table class="simple">
                        	<tr><td width="100px"><label for="DomainName">Domain : </label></td><td width="250px"><input name="DomainName"  id="DomainName" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppDomain->Name"; ?>" disabled="disabled" /></td><td></td></tr>
                            <tr><td><label for="ContactID">Registrant : </label></td><td><select name="ContactID" style="width:200px">
                            
                            
                            			<?php                        
										$query = "SELECT * FROM `contact` where `IsActive` = '1' and `ID` =  $myEppDomain->ContactID ORDER BY `Name` ";
										$EppDatabase = new EppDatabase();
										$myEppDomain = new EppDomain;
										$result = $EppDatabase->EppDatabaseQuery($query);
										
										$num=mysql_numrows($result);
										$i=0;
										
										while ($i <$num)
										{
											$id=mysql_result($result,$i,"ID");
											$name=mysql_result($result,$i,"Name");
											$email=mysql_result($result,$i,"Email");
											print "<option value=\"$id\">$name</option>";
											
											$i++;
										}
										
										?>  
                                        <option value="#"><hr /></option>
                                      <?php                        
										$query = "SELECT * FROM `contact` where `IsActive` = '1' ORDER BY `Name` ";
										$EppDatabase = new EppDatabase();
										$myEppDomain = new EppDomain;
										$result = $EppDatabase->EppDatabaseQuery($query);
										
										$num=mysql_numrows($result);
										$i=0;
										
										while ($i <$num)
										{
											$id=mysql_result($result,$i,"ID");
											$name=mysql_result($result,$i,"Name");
											$email=mysql_result($result,$i,"Email");
											print "<option value=\"$id\">$name</option>";
											
											$i++;
										}
										
										?> 
 
                                        </select> </td><td></td></tr>
                                                                                     
                            <tr><td><br /></td></tr>
                        </table>
                        


                      </fieldset>
                    
                      <div align="center">
                      <input id="button1" name="RegistrantChange" type="submit" value="Change" /> 
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
