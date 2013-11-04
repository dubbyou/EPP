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

$myEppContact = new EppContact;

if ($_SERVER["REQUEST_METHOD"] == "GET"){
	if(isset($_GET['ID'])){
    	$myEppContact->Load($_GET['ID']);
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
						<span>Registrant - <?php print "$myEppContact->AccountNo"; ?></span>
	                     <a href="registrant_view_epp.php?ID=<?php print "$myEppContact->ID"; ?>" >EPP View</a>
                        <br />
                        </h3>
                    
                    
                     
                     
                    <form id="form" action="registrant_update_process.php" method="post">
                    
                      <fieldset id="login">                      
                        <legend>Registarnt Details</legend>
						<input name="ContactID"  id="ContactID" type="hidden" tabindex="1" value="<?php print $myEppContact->ID; ?>" />
                        <table class="simple">
							<tr><td width="100px"><label for="ContactUID">UID : </label></td><td width="250px"><input name="ContactUID"  id="ContactUID" disabled="disabled" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->UID"; ?>" /></td><td></td></tr>
                        	<tr><td width="100px"><label for="ContactName">Company Name : </label></td><td width="250px"><input name="ContactName"  id="ContactName" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Name"; ?>" /></td><td></td></tr>
                              <tr><td width="100px"><label for="AccountNo">Account Number : </label></td><td width="250px"><input name="AccountNo"  id="AccountNo" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->AccountNo"; ?>" /></td><td></td></tr>

                            <tr><td><label for="ContactType">Type : </label></td><td><select name="ContactType" style="width:200px">
                            
                            
                            <?php
							if ($myEppContact->Type == "loc"){
								print '<option value="loc">Local</option>
										<option value="int">International</option>';
							}else{
								print '<option value="int">International</option>
										<option value="loc">Local</option>';
							}
							?>

                                                                                     </select> </td><td></td></tr>
                                                                                     
                            <tr><td><br /></td></tr>
                            <tr><td><label for="ContactStreet">Street Address : </label></td><td><input name="ContactStreet"  id="ContactStreet" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Street"; ?>"/></td><td></td></tr>
                            <tr><td><label for="ContactSuburb">Suburb : </label></td><td><input name="ContactSuburb"  id="ContactSuburb" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Suburb"; ?>"/></td><td></td></tr>
                            <tr><td><label for="ContactCity">City : </label></td><td><input name="ContactCity"  id="ContactCity" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->City"; ?>"/></td><td></td></tr>
                            <tr><td><label for="ContactProvince">Province : </label></td><td><input name="ContactProvince"  id="ContactProvince" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Province"; ?>"/></td><td></td></tr>
                            <tr><td><label for="ContactCode">Code : </label></td><td><input name="ContactCode"  id="ContactCode" type="text" tabindex="1" style="width:100px" value="<?php print "$myEppContact->Postalcode"; ?>"/></td><td></td></tr>    
                            <tr><td><label for="ContactCountry">Country : </label></td><td><input name="ContactCountry"  id="ContactCountry" type="text" tabindex="1" style="width:50px" value="<?php print "$myEppContact->Country"; ?>"/></td><td></td></tr>
                                                    
                            <tr><td><br /></td></tr>
                            <tr><td><label for="ContactVoice">Voice : </label></td><td><input name="ContactVoice"  id="ContactVoice" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Voice"; ?>"/></td><td>+27.312056873</td></tr>
                            <tr><td><label for="ContactFax">Fax : </label></td><td><input name="ContactFax"  id="ContactFax" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Fax"; ?>"/></td><td>+27.312056873</td></tr>
                            <tr><td><label for="ContactEmail">Email : </label></td><td><input name="ContactEmail"  id="ContactEmail" type="text" tabindex="1" style="width:200px" value="<?php print "$myEppContact->Email"; ?>"/></td><td></td></tr>
                            <tr><td><br /></td></tr>
                        </table>
                        


                      </fieldset>
                    
                      <div align="right">
                      <input id="button1" name="RegistrantUpdate" type="submit" value="Update" /> 
                      </div>
                    </form>

                </div>
                <br />
                
                
                
                
                
                
                
                
                
                 <div id="rightnow">
                     <h3 class="reallynow">
                        <span>"<?php print "$myEppContact->AccountNo"; ?>" Domains</span>
                        <a href="#" >New Domain</a>
                        <br />
                        </h3>
                	<table width="100%">
						<thead>
							<tr>
                            	<th width="40px"><a href="#" style="cursor:default;">ID<img src="display/img/icons/arrow_down_mini.gif" width="16" height="16" /></a></th>
                            	<th><a href="#" style="cursor:default;">Name</a></th>
                                <th><a href="#" style="cursor:default;">EXP Date</a></th>
                                <th width="60px"><a href="#" style="cursor:default;">Action</a></th>
                            </tr>
						</thead>
						<tbody>
			<?php                        
      		$query = "SELECT * FROM `domain` where `IsActive` = '1' AND `ContactID` = '$myEppContact->ID' ORDER BY `ID` DESC LIMIT 0 , 30";
	  		$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			
			$num=mysql_numrows($result);
			$i=0;
			
			while ($i <$num)
			{
				$id=mysql_result($result,$i,"ID");
				$name=mysql_result($result,$i,"Name");
				print "<tr><td>$id</td><td>$name</td><td>NULL</td><td>".
				"<a href=\"domain_view.php?DomainId=".$id."\"><img src=\"display/img/icons/user.png\" title=\"Show Contact\" width=\"16\" height=\"16\" /></a>".
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
                    per page |  --> Total <strong><?php //print $num; ?></strong> records found
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
