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
                 
                    
                   <div id="box">
                	<h3 id="adduser">New Registrant </h3>
                    <form id="form" action="registrant_create_process.php" method="post">
                    
                      <fieldset id="login">                      
                        <legend>New Registarnt </legend>
						
                        <table class="simple">
                        	<tr><td width="100px"><label for="ContactName">Company Name : </label></td><td width="250px"><input name="ContactName"  id="ContactName" type="text" tabindex="1" style="width:200px" /></td><td></td></tr>
                            <tr><td><label for="AccountNo">Account No: </label></td><td width="250px"><input name="AccountNo"  id="AccountNo" type="text" tabindex="1" style="width:200px" /></td><td></td></tr>
                            <tr><td><label for="ContactType">Type : </label></td><td><select name="ContactType" style="width:200px">
                                                                                       <option value="loc">Local</option>
                                                                                       <option value="int">International</option>
                                                                                     </select> </td><td></td></tr>
                                                                                     
                            <tr><td><br /></td></tr>
                            <tr><td><label for="ContactStreet">Street Address : </label></td><td><input name="ContactStreet"  id="ContactStreet" type="text" tabindex="1" style="width:200px"/></td><td></td></tr>
                            <tr><td><label for="ContactSuburb">Suburb : </label></td><td><input name="ContactSuburb"  id="ContactSuburb" type="text" tabindex="1" style="width:200px"/></td><td></td></tr>
                            <tr><td><label for="ContactCity">City : </label></td><td><input name="ContactCity"  id="ContactCity" type="text" tabindex="1" style="width:200px"/></td><td></td></tr>
                            <tr><td><label for="ContactProvince">Province : </label></td><td><input name="ContactProvince"  id="ContactProvince" type="text" tabindex="1" style="width:200px"/></td><td></td></tr>
                            <tr><td><label for="ContactCode">Code : </label></td><td><input name="ContactCode"  id="ContactCode" type="text" tabindex="1" style="width:100px"/></td><td></td></tr>    
                            <tr><td><label for="ContactCountry">Country : </label></td><td><input name="ContactCountry"  id="ContactCountry" type="text" tabindex="1" style="width:50px"/></td><td></td></tr>
                                                    
                            <tr><td><br /></td></tr>
                            <tr><td><label for="ContactVoice">Voice : </label></td><td><input name="ContactVoice"  id="ContactVoice" type="text" tabindex="1" style="width:200px"/></td><td>+27.312056873</td></tr>
                            <tr><td><label for="ContactFax">Fax : </label></td><td><input name="ContactFax"  id="ContactFax" type="text" tabindex="1" style="width:200px"/></td><td>+27.312056873</td></tr>
                            <tr><td><label for="ContactEmail">Email : </label></td><td><input name="ContactEmail"  id="ContactEmail" type="text" tabindex="1" style="width:200px"/></td><td></td></tr>
                            <tr><td><br /></td></tr>
                            <tr><td><label for="ContactPassword">Password : </label></td><td><input name="ContactPassword"  id="ContactPassword" type="Password" tabindex="1" style="width:200px"/></td><td></td></tr>
                        </table>
                        


                      </fieldset>
                    
                      <div align="center">
                      <input id="button1" name="RegistrantCreate" type="submit" value="Create" /> 
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
        <div align="center"><p><i><?php print SITE_FOOTNOTE; ?></i></p></div>
        </div>
</div>
</body>
</html>
