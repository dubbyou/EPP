<?php

class EppHost
{
	
	public $ID;
	public $Name;
	public $IP;
	public $DomainID;
	public $IsActive;

/*	
FUNCTIONS
Main functions are placed int this section
*/
	//returns the balance from coza
	public function Create($DomainID,$Name){
		$this->Name = $Name;
		$this->DomainID = $DomainID;
		
	$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
			
			$myEppDomain = new EppDomain();
			$myEppDomain->Load($this->DomainID);
			$TempDomainName = $myEppDomain->Name;
			
		$query = "INSERT INTO `host` (`ID`, `Name`,`DomainID`,`IsActive`) VALUES (NULL, '$Name', '$DomainID','1');";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);

		$myEppServer->Chat($this->xmlCreate($TempDomainName));
		$resultcode = $myEppServer->ResultCode();
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}
	
	public function Delete(){
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
			
			$myEppDomain = new EppDomain();
			$myEppDomain->Load($this->DomainID);
			$TempDomainName = $myEppDomain->Name;
			
		$query = "UPDATE `host` SET `IsActive` = '0' WHERE `ID` = '$this->ID';";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);

		$myEppServer->Chat($this->xmlDelete($TempDomainName));
		$resultcode = $myEppServer->ResultCode();
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}	

/*	
SUBFUNCTIONS
Supporting functions are placed in this section
*/

	function Load($id){
			$query = "SELECT *  FROM `host` where ID = '$id'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$this->Name = mysql_result($result,0,"Name");
			$this->DomainID = mysql_result($result,0,"DomainID");
			$this->ID = $id;
	}
	
	
	public function xmlDelete($TempDomainName){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain=
				"urn:ietf:params:xml:ns:domain-1.0">
				  <epp:command>
					<epp:update>
					  <domain:update>
						<domain:name>'.$TempDomainName.'</domain:name>
						<domain:rem>
						  <domain:ns>
							<domain:hostAttr>
							  <domain:hostName>'.$this->Name.'</domain:hostName>
							</domain:hostAttr>
						  </domain:ns>
						</domain:rem>
					  </domain:update>
					</epp:update>
				  </epp:command>
				</epp:epp>
						';		
	}

	public function xmlCreate($TempDomainName){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain=
				"urn:ietf:params:xml:ns:domain-1.0">
				  <epp:command>
					<epp:update>
					  <domain:update>
						<domain:name>'.$TempDomainName.'</domain:name>
						<domain:add>
						  <domain:ns>
							<domain:hostAttr>
							  <domain:hostName>'.$this->Name.'</domain:hostName>
							</domain:hostAttr>
						  </domain:ns>
						</domain:add>
					  </domain:update>
					</epp:update>
				  </epp:command>
				</epp:epp>
						';		
	}

}
