<?php

class EppDomain
{
	
	public $ID;
	public $Name;
	public $ContactID;
	public $Password;
	public $CrDate;
	public $ExDate;	
	public $UpDate;
	public $IsOnHold;
	public $IsPendingUpdate;	
	public $IsAutoRenew;	
	public $IsActive;
	public $Status;	


/*	
FUNCTIONS
Main functions are placed int this section
*/
	//returns the balance from coza
	public function Create($Name,$ContactID,$NameServers,$Password){

		if(DEBUG_lEVEL >=5){ print "<p>Seting variables</p>";}		
		$this->Name =$Name;
		$this->ContactID = $ContactID;
		$this->Password = $Password;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlCreate($NameServers));
		$resultcode = $myEppServer->ResultCode();
		$this->xmlCreateProcess($myEppServer->OutXML);		
		
			$query = "INSERT INTO `domain` (`ID`, `Name`,`ContactID`,`Password`, `CrDate`, `ExDate`, `IsAutoRenew`, `IsActive`) VALUES (NULL, '$this->Name', '$this->ContactID', '$this->Password', '$this->CrDate', '$this->ExDate', '1', '1');";
			$EppDatabase = new EppDatabase();
			$EppDatabase->EppDatabaseQuery($query);
			$this->ID = $EppDatabase->InsertID;
		
		
			foreach ($NameServers as $i => $value) {
				$query = "INSERT INTO `host` (`ID`, `Name`,`DomainID`,`IsActive`) VALUES (NULL, '$value', '$this->ID','1');";
				$EppDatabase = new EppDatabase();
				$EppDatabase->EppDatabaseQuery($query);
			}
	
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
		
	}
	
	
		//returns the balance from coza
	public function Move($Name,$ContactID,$Password){

		if(DEBUG_lEVEL >=5){ print "<p>Seting variables</p>";}		
		$this->Name =$Name;
		$this->ContactID = $ContactID;
		$this->Password = $Password;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		
		$myEppServer->Chat($this->xmlUpdateContact());
		$resultcode = $myEppServer->ResultCode();
		
			$query = "INSERT INTO `domain` (`ID`, `Name`,`ContactID`,`Password`, `CrDate`, `ExDate`, `IsAutoRenew`, `IsActive`) VALUES (NULL, '$this->Name', '$this->ContactID', '$this->Password', '$this->CrDate', '$this->ExDate', '1', '1');";
			$EppDatabase = new EppDatabase();
			$EppDatabase->EppDatabaseQuery($query);
			$this->ID = $EppDatabase->InsertID;
		
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;

	}
	
	public function Check($Name){
		if(DEBUG_lEVEL >=5){ print "<p>Seting Name $Name</p>";}
		$this->Name=$Name;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlCheck());
		$resultcode = $myEppServer->ResultCode();
		return $this->xmlCheckProcess($myEppServer->OutXML);		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}

	public function EPPView(){
		if(DEBUG_lEVEL >=5){ print "<p>Running EPP View</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlEppView());
		$resultcode = $myEppServer->ResultCode();
		$OutXML = $myEppServer->OutXML;
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $OutXML;
	}

	public function TurnOnHoldOn(){
		if(DEBUG_lEVEL >=5){ print "<p>Running on hold on</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlOnHoldOn());
		$resultcode = $myEppServer->ResultCode();
		$query = "UPDATE `domain` SET `IsOnHold` = '1' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}
	
		public function TurnOnHoldOff(){
		if(DEBUG_lEVEL >=5){ print "<p>Running On hold off</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlOnHoldOff());
		$resultcode = $myEppServer->ResultCode();
		$query = "UPDATE `domain` SET `IsOnHold` = '0' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}
	
	
	public function AutoRenewOn(){
		if(DEBUG_lEVEL >=5){ print "<p>Running on AutoRenew on</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlAutoRenewOn());
		$resultcode = $myEppServer->ResultCode();
		$query = "UPDATE `domain` SET `IsAutoRenew` = '1' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}
	
	public function AutoRenewOff(){
		if(DEBUG_lEVEL >=5){ print "<p>Running On AutoRenew off</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlAutoRenewOff());
		$resultcode = $myEppServer->ResultCode();
		$query = "UPDATE `domain` SET `IsAutoRenew` = '0' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}	
	
	public function Renew(){
		if(DEBUG_lEVEL >=5){ print "<p>Running renew domain</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlRenew());
		$resultcode = $myEppServer->ResultCode();
		$this->xmlRenewProcess($myEppServer->OutXML);	
		$query = "UPDATE `domain` SET `ExDate` = '$this->ExDate' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}	
	
	public function Delete(){
		if(DEBUG_lEVEL >=5){ print "<p>Running  domain delete</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlDelete());
		$resultcode = $myEppServer->ResultCode();
		$query = "UPDATE `domain` SET `IsActive` = '0' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}			
	
	public function UpdateContact(){
		if(DEBUG_lEVEL >=5){ print "<p>Running  domain delete</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlUpdateContact());
		$resultcode = $myEppServer->ResultCode();
		$query = "UPDATE `domain` SET `ContactID` = '$this->ContactID' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}	
	
	public function SyncBack(){
		if(DEBUG_lEVEL >=5){ print "<p>Running  domain sync back</p>";}
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlEppView());
		$resultcode = $myEppServer->ResultCode();
		return $this->xmlSyncBackProcess($myEppServer->OutXML);
		$OutXML = $myEppServer->OutXML;
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $OutXML;
	}		
/*	
SUBFUNCTIONS
Supporting functions are placed in this section
*/


	public function Load($ID){
			$query = "SELECT *  FROM `domain` where ID = '$ID'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$this->Name = mysql_result($result,0,"Name");
			$this->ContactID = mysql_result($result,0,"ContactID");
			$this->Password = mysql_result($result,0,"Password");	
			$this->CrDate = mysql_result($result,0,"CrDate");	
			$this->ExDate = mysql_result($result,0,"ExDate");		
			$this->IsOnHold = mysql_result($result,0,"IsOnHold");		
			$this->IsAutoRenew = mysql_result($result,0,"IsAutoRenew");	
			$this->IsPendingUpdate = mysql_result($result,0,"IsPendingUpdate");				
			$this->Status = mysql_result($result,0,"Status");				
			$this->IsActive = mysql_result($result,0,"IsActive");
			$this->ID = $ID;
	}

	public function LoadName($name){
			$query = "SELECT *  FROM `domain` where `Name` = '$name' and `IsActive`= '1'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$this->ID = mysql_result($result,0,"ID");
			$this->ContactID = mysql_result($result,0,"ContactID");
			$this->Password = mysql_result($result,0,"Password");	
			$this->CrDate = mysql_result($result,0,"CrDate");	
			$this->ExDate = mysql_result($result,0,"ExDate");		
			$this->IsOnHold = mysql_result($result,0,"IsOnHold");		
			$this->IsAutoRenew = mysql_result($result,0,"IsAutoRenew");	
			$this->IsPendingUpdate = mysql_result($result,0,"IsPendingUpdate");				
			$this->Status = mysql_result($result,0,"Status");				
			$this->IsActive = mysql_result($result,0,"IsActive");
	}

	function xmlCheckProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		return $newroot->getElementsByTagName('name')->item(0)->getAttribute('avail');
	}
	
	function xmlCreateProcess($XMLResult){
		if(DEBUG_lEVEL >=5){ print "<p>Processing create xml</p>";}
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		$this->CrDate = $newdoc->getElementsByTagName('crDate')->item(0)->nodeValue;
		$this->ExDate =  $newdoc->getElementsByTagName('exDate')->item(0)->nodeValue;
	}
	
	function xmlRenewProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		$this->ExDate =  $newdoc->getElementsByTagName('exDate')->item(0)->nodeValue;
		return $newdoc->getElementsByTagName('result')->item(0)->getAttribute('code');
	}

	function xmlSyncBackProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		$this->ContactID = $newdoc->getElementsByTagName('registrant')->item(0)->nodeValue;		
		$this->CrDate = $newdoc->getElementsByTagName('crDate')->item(0)->nodeValue;
		$this->ExDate =  $newdoc->getElementsByTagName('exDate')->item(0)->nodeValue;
		$this->UpDate = $newdoc->getElementsByTagName('upDate')->item(0)->nodeValue;
		//$this->Status = $newdoc->getElementsByTagName('status')->item(0)->nodeValue;
		$this->Status = $newdoc->getElementsByTagName('status')->item(0)->getAttribute('s');
		
		if ($newdoc->getElementsByTagName('autorenew')->item(0)->nodeValue == "false"){
			$this->IsAutoRenew = 0;
		}else{
			$this->IsAutoRenew = 1;
		}
		
		$query = "UPDATE `domain` SET `CrDate` = '$this->CrDate', `ExDate` = '$this->ExDate', `ContactID` = '$this->ContactID',`Status` = '$this->Status',`UpDate` = '$this->UpDate' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		
	   $query = "UPDATE `host` SET `IsActive` = '0' WHERE `DomainID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);		
		
		
		
		$note = $newdoc->getElementsByTagName("hostAttr"); 
		
		 foreach( $note as $value ) { 
				$tasks = $value->getElementsByTagName("hostName"); 
				$temp = $tasks->item(0)->nodeValue;
				
				$query = "INSERT INTO `host` (`ID`, `Name`,`DomainID`,`IsActive`) VALUES (NULL, '$temp', '$this->ID','1');";
				$EppDatabase = new EppDatabase();
				$EppDatabase->EppDatabaseQuery($query);
		 } 		
		
	}	
	
	
/*	
XML
XML generation functions
*/	
	
	// xml check request
	public function xmlCheck(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
			  <epp:command>
				<epp:check>
				  <domain:check>
					<domain:name>'.$this->Name.'</domain:name>
				  </domain:check>
				</epp:check>
			  </epp:command>
			</epp:epp>
			 ';			
	}
	
	
	public function xmlCreate($NameServers){
		$xml = '<epp:epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
				xmlns:domain="urn:ietf:params:xml:ns:domain-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
				  <epp:command>
					<epp:create>
					  <domain:create xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
						<domain:name>'.$this->Name.'</domain:name>
						<domain:ns>';
						
					foreach ($NameServers as $i => $value) {
							    $xml= $xml."
						  <domain:hostAttr>
							<domain:hostName>".$value."</domain:hostName>
						  </domain:hostAttr>";
						  
						}

			
		$xml =	$xml.			'</domain:ns>
						<domain:registrant>'.$this->ContactID.'</domain:registrant>
						<domain:authInfo>
						  <domain:pw>'.$this->Password.'</domain:pw>
						</domain:authInfo>
					  </domain:create>
					</epp:create>

				  </epp:command>
				</epp:epp>
				';		
				
				return $xml;
	}	



	public function xmlEppView(){
		return '<epp:epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
				xmlns:domain="urn:ietf:params:xml:ns:domain-1.0" xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
				  <epp:command>
					<epp:info>
					  <domain:info xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
						<domain:name hosts="all">'.$this->Name.'</domain:name>
					  </domain:info>
					</epp:info>
					<epp:extension>
					  <cozadomain:info xmlns:cozadomain="http://co.za/epp/extensions/cozadomain-1-0" xsi:schemaLocation="http://co.za/epp/extensions/cozadomain-1-0 coza-domain-1.0.xsd">
					  </cozadomain:info>
					</epp:extension>
				  </epp:command>
				</epp:epp>
				 ';		
	}
	
	
	public function xmlOnHoldOn(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
		xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
		  <epp:command>
			<epp:update>
			  <domain:update>
				<domain:name>'.$this->Name.'</domain:name>
				<domain:add>
				  <domain:status s="clientHold"/>
				</domain:add>
			  </domain:update>
			</epp:update>
		  </epp:command>
		</epp:epp>';		
		}
		
	public function xmlOnHoldOff(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
		xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
		  <epp:command>
			<epp:update>
			  <domain:update>
				<domain:name>'.$this->Name.'</domain:name>
				<domain:rem>
				  <domain:status s="clientHold"/>
				</domain:rem>
			  </domain:update>
			</epp:update>
		  </epp:command>
		</epp:epp>';		
		}
	
	public function xmlAutoRenewOn(){
		return '<epp:epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
				xmlns:domain="urn:ietf:params:xml:ns:domain-1.0" xmlns:cozadomain="http://co.za/epp/extensions/cozadomain-1-0" 
				xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
				  <epp:command>
					<epp:update>
					  <domain:update xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
						<domain:name>'.$this->Name.'</domain:name>
					  </domain:update>
					</epp:update>
					<epp:extension>
					  <cozadomain:update xsi:schemaLocation="http://co.za/epp/extensions/cozadomain-1-0 coza-domain-1.0.xsd">
					  <cozadomain:chg><cozadomain:autorenew>true</cozadomain:autorenew></cozadomain:chg></cozadomain:update>
					</epp:extension>
				  </epp:command>
				</epp:epp>';		
	}

	public function xmlAutoRenewOff(){
		return '<epp:epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
				xmlns:domain="urn:ietf:params:xml:ns:domain-1.0" xmlns:cozadomain="http://co.za/epp/extensions/cozadomain-1-0" 
				xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
				  <epp:command>
					<epp:update>
					  <domain:update xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
						<domain:name>'.$this->Name.'</domain:name>
					  </domain:update>
					</epp:update>
					<epp:extension>
					  <cozadomain:update xsi:schemaLocation="http://co.za/epp/extensions/cozadomain-1-0 coza-domain-1.0.xsd">
					  <cozadomain:chg><cozadomain:autorenew>false</cozadomain:autorenew></cozadomain:chg></cozadomain:update>
					</epp:extension>
				  </epp:command>
				</epp:epp>';		
	}	
	
	public function xmlRenew(){
		$date = date( 'Y-m-d', strtotime( $this->ExDate ) );
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
			  <epp:command>
				<epp:renew>
				  <domain:renew>
					<domain:name>'.$this->Name.'</domain:name>
					<domain:curExpDate>'.$date.'</domain:curExpDate>
				  </domain:renew>
				</epp:renew>
			  </epp:command>
			</epp:epp>';		
	}	
	
	public function xmlDelete(){
		return '<epp:epp xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" 
				xmlns:epp="urn:ietf:params:xml:ns:epp-1.0"  
				xmlns:domain="urn:ietf:params:xml:ns:domain-1.0" 
				xsi:schemaLocation="urn:ietf:params:xml:ns:epp-1.0 epp-1.0.xsd">
				  <epp:command>
					<epp:delete>
					  <domain:delete xsi:schemaLocation="urn:ietf:params:xml:ns:domain-1.0 domain-1.0.xsd">
						<domain:name>'.$this->Name.'</domain:name>
					  </domain:delete>
					</epp:delete>
				  </epp:command>
				</epp:epp>
						';		
	}
	
	public function xmlUpdateContact(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain=
				"urn:ietf:params:xml:ns:domain-1.0">
				  <epp:command>
					<epp:update>
					  <domain:update>
						<domain:name>'.$this->Name.'</domain:name>
						<domain:chg>
						  <domain:registrant>'.$this->ContactID.'</domain:registrant>
						</domain:chg>
					  </domain:update>
					</epp:update>
				  </epp:command>
				</epp:epp>
				';		
	}	
	
	public function xmlTransferRequest(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
			  <epp:command>
				<epp:transfer op="request">
				  <domain:transfer>
					<domain:name>'.$this->EppDomainName.'</domain:name>
				  </domain:transfer>
				</epp:transfer>
			  </epp:command>
			</epp:epp>';		
	}	
	
}
