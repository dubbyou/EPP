<?php

class EppTransfer
{
	
	public $ID;
	public $Name;
	public $IsActive;
	public $Status;	
	public $EPPID;	

/*	
FUNCTIONS
Main functions are placed int this section
*/
	public function Request($Name){
		//load variables
		$this->Name = $Name;	
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlRequest());
		$resultcode = $myEppServer->ResultCode();
		if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			if ($resultcode == 1001){
				if(DEBUG_lEVEL >=5){ print "<p>The update was created successfully</p>";}
							$this->xmlRequestProcess($myEppServer->OutXML);
							$query = "INSERT INTO `transfer` (`ID`, `Name`, `IsActive`, `Status`,`EPPID`) VALUES (NULL,'$this->Name','1','Pending Transfer','$this->EPPID');";
							$EppDatabase = new EppDatabase();
							$EppDatabase->EppDatabaseQuery($query);
							$this->ID = $EppDatabase->InsertID;
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The contact already exists</p>";}
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
		return $resultcode;
	}	
	
	public function Cancel(){
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlCancel());
		$resultcode = $myEppServer->ResultCode();
		if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was created successfully</p>";}
							$query = "UPDATE `transfer` SET `Status` = 'Transfer Cancelled' WHERE `ID` = '$this->ID'; ";
							$EppDatabase = new EppDatabase();
							$EppDatabase->EppDatabaseQuery($query);
							
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The contact already exists</p>";}
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}		


	public function Approve($name){
		$this->Name = $name;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlApproval());
		$resultcode = $myEppServer->ResultCode();
		if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was created successfully</p>";}
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The contact already exists</p>";}
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}		

	public function Status(){
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlStatus());
		$resultcode = $myEppServer->ResultCode();
		if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			if ($resultcode == 1000){
							$this->xmlStatusProcess($myEppServer->OutXML);
							$query = "UPDATE `transfer` SET `Status` = '$this->Status' WHERE `ID` = '$this->ID'; ";
							$EppDatabase = new EppDatabase();
							$EppDatabase->EppDatabaseQuery($query);
				if(DEBUG_lEVEL >=5){ print "<p>The contact was created successfully</p>";}
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The contact already exists</p>";}
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}		


	public function Reject($name){
		$this->Name = $name;
		
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlReject());
		$resultcode = $myEppServer->ResultCode();
		if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			if ($resultcode == 1000){
				if(DEBUG_lEVEL >=5){ print "<p>The contact was created successfully</p>";}
			}elseif ($resultcode == 2302){
				if(DEBUG_lEVEL >=5){ print "<p>The contact already exists</p>";}
			}else{
				if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
			}
		
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}		
	
	
	public function ApplyUpdate($ID, $msgID,$status){
			$query = "SELECT *  FROM `transfer` where ID = '$ID'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$num=mysql_numrows($result);
			if ($num ==1){
			
			$query4 = "UPDATE `transfer` SET `Status` = '$status' WHERE `ID` = $ID;";
			$query5 = "UPDATE `message` SET `IsActioned` = '1' WHERE `ID` = '$msgID';";

			$EppDatabase = new EppDatabase();
			$EppDatabase->EppDatabaseQuery($query4);
			$EppDatabase->EppDatabaseQuery($query5);
			}
	}
		
	public function Remove(){
			
			$query4 = "UPDATE `transfer` SET `IsActive` = '0' WHERE `ID` = '$this->ID'; ";
			$EppDatabase = new EppDatabase();
			$EppDatabase->EppDatabaseQuery($query4);

	}		
		
		
	public function Load($ID){
			$query = "SELECT *  FROM `transfer` where ID = '$ID'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$this->Name = mysql_result($result,0,"Name");
			$this->IsActive = mysql_result($result,0,"IsActive");
			$this->Status = mysql_result($result,0,"Status");	
			$this->ID = $ID;
	}
	
	function xmlRequestProcess($XMLResult){
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
	
	function xmlStatusProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		$this->Status =  $newdoc->getElementsByTagName('trStatus')->item(0)->nodeValue;
	}
		
	
	public function xmlRequest(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
			  <epp:command>
				<epp:transfer op="request">
				  <domain:transfer>
					<domain:name>'.$this->Name.'</domain:name>
				  </domain:transfer>
				</epp:transfer>
			  </epp:command>
			</epp:epp>';		
	}
	
	public function xmlStatus(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
		  <epp:command>
			<epp:transfer op="query">
			  <domain:transfer>
				<domain:name>'.$this->Name.'</domain:name>
			  </domain:transfer>
			</epp:transfer>
		  </epp:command>
		</epp:epp>';		
	}
	
	public function xmlCancel(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
		  <epp:command>
			<epp:transfer op="cancel">
			  <domain:transfer>
				<domain:name>'.$this->Name.'</domain:name>
			  </domain:transfer>
			</epp:transfer>
		  </epp:command>
		</epp:epp>';		
	}
	

	public function xmlApproval(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
		  <epp:command>
			<epp:transfer op="approve">
			  <domain:transfer>
				<domain:name>'.$this->Name.'</domain:name>
			  </domain:transfer>
			</epp:transfer>
		  </epp:command>
		</epp:epp>';		
	}


	public function xmlReject(){
		return '<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" xmlns:domain="urn:ietf:params:xml:ns:domain-1.0">
		  <epp:command>
			<epp:transfer op="reject">
			  <domain:transfer>
				<domain:name>'.$this->Name.'</domain:name>
			  </domain:transfer>
			</epp:transfer>
		  </epp:command>
		</epp:epp>';		
	}	
}
?>