<?php

class EppContact
{
	public $ID;
	public $UID;
	public $Type;
	public $Name;
	public $AccountNo;	
	public $Street;	
	public $Suburb;	
	public $City;	
	public $Province;	
	public $Postalcode;
	public $Country;			
	public $Voice;			
	public $Fax;			
	public $Email;
	public $Password;
	public $CrDate;
	public $UpDate;
	public $IsPendingUpdate;
	public $IsActive;
	public $EPPID;	
	
	
/*	
FUNCTIONS
Main functions are placed int this section
*/


	public function Create($Type,$Name,$AccountNo,$Street,$Suburb,$City,$Province,$Postalcode,$Country,$Voice,$Fax,$Email,$Password){
		//load variables
		$this->Type = $Type;
		$this->Name = $Name;	
		$this->AccountNo = $AccountNo;	
		$this->Street = $Street;	
		$this->Suburb = $Suburb;	
		$this->City = $City;	
		$this->Province = $Province;	
		$this->Postalcode = $Postalcode;
		$this->Country = $Country;			
		$this->Voice = $Voice;			
		$this->Fax = $Fax;			
		$this->Email = $Email;
		$this->Password = $Password;
		$this->IsActive = '1';
		
		if(DEBUG_lEVEL >=5){ print "<p>Password: $this->Password</p>";}
		if(DEBUG_lEVEL >=5){ print "<p>Adding contact to database</p>";}
		$query = "INSERT INTO `contact` (`ID`, `Type`,`Name`,`AccountNo`, `Street`, `Suburb`, `City`, `Province`,`PostalCode` ,`Country`, `Voice`, `Fax`, `Email`, `Password`, `IsActive`) VALUES (NULL, '$this->Type', '$this->Name', '$this->AccountNo', '$this->Street', '$this->Suburb', '$this->City', '$this->Province', '$this->Postalcode', '$this->Country', '$this->Voice', '$this->Fax', '$this->Email', '$this->Password','1');";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$this->ID = $EppDatabase->InsertID;
		$this->UID = "dep".$this->ID;
		
		
		if(DEBUG_lEVEL >=5){ print "<p>Contact ID : $this->UID</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlCreate());
		$resultcode = $myEppServer->ResultCode();
		if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was created successfully</p>";}
					$query2 = "UPDATE `contact` SET `UID` = '$this->UID' WHERE `ID` = $this->ID;";
					$EppDatabase = new EppDatabase();
					$EppDatabase->EppDatabaseQuery($query2);
					return 1000;
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The contact already exists</p>";}
				return 2302;
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
				return 0;
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}

	public function Update($ID,$Type,$Name,$AccountNo,$Street,$Suburb,$City,$Province,$Postalcode,$Country,$Voice,$Fax,$Email,$Password){
		//load variables
		$this->ID = $ID;
		$this->Type = $Type;
		$this->Name = $Name;	
		$this->AccountNo = $AccountNo;	
		$this->Street = $Street;	
		$this->Suburb = $Suburb;	
		$this->City = $City;	
		$this->Province = $Province;	
		$this->Postalcode = $Postalcode;
		$this->Country = $Country;			
		$this->Voice = $Voice;			
		$this->Fax = $Fax;			
		$this->Email = $Email;
		$this->Password = $Password;
		
		if(DEBUG_lEVEL >=5){ print "<p>Postalcode: $this->Postalcode</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlUpdate());
		$resultcode = $myEppServer->ResultCode();

			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was updated successfully</p>";}
				return 1000;
			}elseif ($resultcode == 1001){
				if(DEBUG_lEVEL >=5){ print "<p>The contact is pending for update</p>";}
					$this->xmlUpdateProcess($myEppServer->OutXML);
					$action = "INSERT INTO `contact_action` (`ID`,`ContactID`, `Type`,`Name`,`AccountNo`, `Street`, `Suburb`, `City`, `Province`,`PostalCode`, `Country`, `Voice`, `Fax`, `Email`, `Password`, `IsActive`, `EPPID`) VALUES (NULL, $this->ID, '$this->Type', '$this->Name', '$this->AccountNo', '$this->Street', '$this->Suburb', '$this->City', '$this->Province', '$this->Postalcode', '$this->Country', '$this->Voice', '$this->Fax', '$this->Email', '$this->Password','1','$this->EPPID');";
					$query = "UPDATE `contact` SET `IsPendingUpdate` = '1' WHERE `ID` = $this->ID;";
					$EppDatabase = new EppDatabase();
					$EppDatabase->EppDatabaseQuery($action);
					$EppDatabase->EppDatabaseQuery($query);
				return 1001;
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The Contact does not exist</p>";}
				return 2302;
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
				return 0;
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}
	
	public function Info($ID){
		$this->ID = $ID;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlView());
		$resultcode = $myEppServer->ResultCode();

			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was Delete successfully</p>";}
				$this->xmlViewProcess($myEppServer->OutXML);
				return 1000;
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
				return 0;
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}
	
	public function Delete($ID){
		//load
		$this->ID = $ID;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlDelete());
		$resultcode = $myEppServer->ResultCode();

			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was Delete successfully</p>";}
					$query = "UPDATE `contact` SET `IsActive` = '0' WHERE `ID` = $this->ID;";
					$EppDatabase = new EppDatabase();
					$EppDatabase->EppDatabaseQuery($query);
				return 1000;
			}elseif ($resultcode == 2304){
				if(DEBUG_lEVEL >=5){ print "<p>Failed to delete - prohibited</p>";}
				return 2304;
			}elseif ($resultcode == 2305){
				if(DEBUG_lEVEL >=5){ print "<p>FFailed to delete - Dependencies</p>";}
				return 2305;
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
				return 0;
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}
	
	
	public function ApplyUpdate($ID, $msgID){
			$query = "SELECT *  FROM `contact_action` where ID = '$ID'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$num=mysql_numrows($result);
			if ($num ==1){
			
		
			$this->Type = mysql_result($result,0,"Type");
			$this->Name = mysql_result($result,0,"Name");
			$this->AccountNo = mysql_result($result,0,"AccountNo");
			$this->Street = mysql_result($result,0,"Street");	
			$this->Suburb = mysql_result($result,0,"Suburb");	
			$this->City = mysql_result($result,0,"City");		
			$this->Province = mysql_result($result,0,"Province");		
			$this->Postalcode = mysql_result($result,0,"PostalCode");	
			$this->Country = mysql_result($result,0,"Country");				
			$this->Voice = mysql_result($result,0,"Voice");				
			$this->Fax = mysql_result($result,0,"Fax");			
			$this->Email = mysql_result($result,0,"Email");	
			$this->Password = mysql_result($result,0,"Password");	
			$ContactID = mysql_result($result,0,"ContactID");
			
						
			$query3 = "UPDATE `contact` SET `Type` = '$this->Type', `Name` = '$this->Name',`AccountNo` = '$this->AccountNo', `Street` = '$this->Street', `Suburb` = '$this->Suburb', `City` = '$this->City', `Province` = '$this->Province', `Country` = '$this->Country', `Voice` = '$this->Voice', `Fax` = '$this->Fax', `Email` = '$this->Email', `Password` = '$this->Password', `PostalCode` = '$this->Postalcode' WHERE `ID` = $ContactID;";
			
			$query4 = "UPDATE `contact_action` SET `IsActive` = '0' WHERE `ID` = $ID;";
			$query5 = "UPDATE `message` SET `IsActioned` = '1' WHERE `ID` = '$msgID';";

			$EppDatabase = new EppDatabase();
			$EppDatabase->EppDatabaseQuery($query3);
			$EppDatabase->EppDatabaseQuery($query4);
			$EppDatabase->EppDatabaseQuery($query5);
			}
	}
	
	
/*	
SUBFUNCTIONS
Supporting functions are placed in this section
*/


	public function Load($ID){
			$query = "SELECT *  FROM `contact` where ID = '$ID'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$this->Type = mysql_result($result,0,"Type");
			$this->UID = mysql_result($result,0,"UID");
			$this->Name = mysql_result($result,0,"Name");
			$this->AccountNo = mysql_result($result,0,"AccountNo");
			$this->Street = mysql_result($result,0,"Street");	
			$this->Suburb = mysql_result($result,0,"Suburb");	
			$this->City = mysql_result($result,0,"City");		
			$this->Province = mysql_result($result,0,"Province");		
			$this->Postalcode = mysql_result($result,0,"PostalCode");	
			$this->Country = mysql_result($result,0,"Country");				
			$this->Voice = mysql_result($result,0,"Voice");				
			$this->Fax = mysql_result($result,0,"Fax");			
			$this->Email = mysql_result($result,0,"Email");	
			$this->Password = mysql_result($result,0,"Password");	
			$this->CrDate = mysql_result($result,0,"CrDate");	
			$this->UpDate = mysql_result($result,0,"UpDate");	
			$this->IsActive = mysql_result($result,0,"IsActive");
			$this->IsPendingUpdate = mysql_result($result,0,"IsPendingUpdate");							
			$this->ID = $ID;
	}
	
	public function TotalActive(){
			$query = "SELECT COUNT(*) AS Total FROM `contact` where IsActive = '1'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$total=mysql_result($result,0,"Total");
			return $total;
	}
	
	
		//balance xml processing
	function xmlUpdateProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		$this->EPPID =  $newdoc->getElementsByTagName('svTRID')->item(0)->nodeValue;
	}
	
	function xmlViewProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		
		
		$this->Name = $newdoc->getElementsByTagName('name')->item(0)->nodeValue;	
		$this->Street = $newdoc->getElementsByTagName('street')->item(0)->nodeValue;
		$this->Suburb = $newdoc->getElementsByTagName('street')->item(1)->nodeValue;	
		$this->City = $newdoc->getElementsByTagName('city')->item(0)->nodeValue;	
		$this->Province = $newdoc->getElementsByTagName('sp')->item(0)->nodeValue;	
		$this->Postalcode = $newdoc->getElementsByTagName('pc')->item(0)->nodeValue;
		$this->Country = $newdoc->getElementsByTagName('cc')->item(0)->nodeValue;			
		$this->Voice = $newdoc->getElementsByTagName('voice')->item(0)->nodeValue;		
		$this->Fax = $newdoc->getElementsByTagName('fax')->item(0)->nodeValue;			
		$this->Email = $newdoc->getElementsByTagName('email')->item(0)->nodeValue;
	}

	
/*	
XML
XML generation functions
*/	
	
	//balance xml request
	public function xmlCreate(){
		return '
		<epp:epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
				xmlns:contact="urn:ietf:params:xml:ns:contact-1.0" xsi:schemaLocation="urn:ietf:
				params:xml:ns:epp-1.0 epp-1.0.xsd">
				  <epp:command>
					<epp:create>
					  <contact:create xsi:schemaLocation="urn:ietf:params:xml:ns:contact-1.0 contact-1.0.xsd">
						<contact:id>'.$this->UID.'</contact:id>
						<contact:postalInfo type="'.$this->Type.'">
						  <contact:name>'.$this->Name.'</contact:name>
						  <contact:addr>
							<contact:street>'.$this->Street.'</contact:street>
							<contact:street>'.$this->Suburb.'</contact:street>
							<contact:city>'.$this->City.'</contact:city>
							<contact:sp>'.$this->Province.'</contact:sp>
							<contact:pc>'.$this->Postalcode.'</contact:pc>
							<contact:cc>'.$this->Country.'</contact:cc>
						  </contact:addr>
						</contact:postalInfo>
						<contact:voice>'.$this->Voice.'</contact:voice>
						<contact:fax>'.$this->Fax.'</contact:fax>
						<contact:email>'.$this->Email.'</contact:email>
						<contact:authInfo>
						  <contact:pw>'.$this->Password.'</contact:pw>
						</contact:authInfo>
					  </contact:create>
					</epp:create>
				  </epp:command>
				</epp:epp>
			 ';		
	}
	
	public function xmlUpdate(){
		return '
		<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
				  <epp:command>
					<epp:update>
					  <contact:update>
						<contact:id>'.$this->ID.'</contact:id>
						<contact:chg>
						  <contact:postalInfo type="'.$this->Type.'">
							<contact:name>'.$this->Name.'</contact:name>
							<contact:addr>
								<contact:street>'.$this->Street.'</contact:street>
								<contact:street>'.$this->Suburb.'</contact:street>
								<contact:city>'.$this->City.'</contact:city>
								<contact:sp>'.$this->Province.'</contact:sp>
								<contact:pc>'.$this->Postalcode.'</contact:pc>
								<contact:cc>'.$this->Country.'</contact:cc>
							</contact:addr>
						  </contact:postalInfo>
						  <contact:voice>'.$this->Voice.'</contact:voice>
						  <contact:fax>'.$this->Fax.'</contact:fax>
						  <contact:email>'.$this->Email.'</contact:email>
						</contact:chg>
					  </contact:update>
					</epp:update>
				  </epp:command>
				</epp:epp>
			 ';		
	}
	
	public function xmlDelete(){
		return'<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
			  xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
				<epp:command>
				  <epp:delete>
					<contact:delete>
					  <contact:id>'.$this->ID.'</contact:id>
					</contact:delete>
				  </epp:delete>
				</epp:command>
			  </epp:epp>';
	}
	
	public function xmlView(){
		return'<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:contact="urn:ietf:params:xml:ns:contact-1.0">
			  <epp:command>
				<epp:info>
				  <contact:info>
					<contact:id>'.$this->ID.'</contact:id>
				  </contact:info>
				</epp:info>
			  </epp:command>
			</epp:epp>';
	}
}