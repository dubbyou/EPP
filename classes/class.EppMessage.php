<?php

class EppMessage
{
	public $ID;
	public $Date;
	public $Message;
	public $EPPID;	
	public $IsAck;
	public $IsActioned;	
	public $TransactionID;	
	public $IsDomainTransfer;	
	public $DomainID;		

/*	
FUNCTIONS
Main functions are placed int this section
*/

	public function Poll(){

		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$flag = 0;						
		while ($flag != 1){
				$TransactionID = $myEppServer->Chat($this->xmlPoll());
				$resultcode = $myEppServer->ResultCode();
	
				if(DEBUG_lEVEL >=5){ print "<p>Result code: $resultcode</p>";}
			
					if ($resultcode == 1300){
						if(DEBUG_lEVEL >=5){ print "<p>There are no messages in the queue</p>";}
						print "<p>There are no messages in the queue</p>";
						$flag =1;

					}elseif ($resultcode == 1301){
						if(DEBUG_lEVEL >=5){ print "<p>There are messages</p>";}
						$EPPID = $this->xmlPollProcess($myEppServer->OutXML, $TransactionID);
							print "<p>Loading Message</p>";
										
							if(DEBUG_lEVEL >=5){ print "<p>ACK message</p>";}
							$myEppServer->Chat($this->xmlAck($EPPID));
							$resultcode2 = $myEppServer->ResultCode();
						if(DEBUG_lEVEL >=5){ print "<p>ACK Result Code: $resultcode2</p>";}
						

					}else{
						if(DEBUG_lEVEL >=5){ print "<p>Failed due to an unknown Error</p>";}
						$flag =1;
					}
		}
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}
	
	
		public function Ack(){
		if(DEBUG_lEVEL >=5){ print "<p>ACK Message</p>";}
		$query = "UPDATE `message` SET `IsAck` = '1' WHERE `ID` = $this->ID;";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);

	}
/*	
SUBFUNCTIONS
Supporting functions are placed in this section
*/

	// This function wil create a unique ID prefixed with Depari
	function UniqueID(){
		return uniqid ('Depari', true);
	}
	
	function xmlPollProcess($EppXMLResult, $TransactionID){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($EppXMLResult);
		// get root element
		$note = $newdoc->getElementsByTagName("msgQ"); 
		
		$TmpEPPID= $newdoc->getElementsByTagName('msgQ')->item(0)->getAttribute('id');

		foreach( $note as $value ) 
		  { 
			$tasks = $value->getElementsByTagName("qDate"); 
			$TempDate = $tasks->item(0)->nodeValue; 
		
			$details = $value->getElementsByTagName("msg"); 
			$temp = $details->item(0)->nodeValue; 
			$TempMsg = str_replace("'", "", $temp);
			
		  } 
		  
		  $note2 = $newdoc->getElementsByTagName("paTRID"); 
		  
		  $sub ="";
				foreach( $note2 as $valuen ) 
		  { 
			$tasks = $valuen->getElementsByTagName("svTRID"); 
			$sub = $tasks->item(0)->nodeValue; 
			
		  }   
		  
		  
		  
			$query = "INSERT INTO `message` (`ID`, `Date`,`Message`,`EPPID`, `TransactionID`) VALUES (NULL, '$TempDate', '$TempMsg', '$sub', '$TransactionID');";
			$EppDatabase = new EppDatabase();
			$EppDatabase->EppDatabaseQuery($query);
			$this->Load($EppDatabase->InsertID);
			
			
			if(DEBUG_lEVEL >=5){ print "<p>Checking if action must be taken</p>";}
			$this->ActionCheck($EppXMLResult);
			
		  return $TmpEPPID;
	}
	
	function ActionCheck($EppXMLResult){
		$query = "SELECT *  FROM `contact_action` where EPPID = '$this->EPPID'";
		$EppDatabase = new EppDatabase();
		$result = $EppDatabase->EppDatabaseQuery($query);
		$num=mysql_numrows($result);
		if ($num > 0){
		$ActionID = mysql_result($result,0,"ID");
		if(DEBUG_lEVEL >=5){ print "<p>Contact messages <p>";}
			$EppContact = new EppContact();
			$EppContact->ApplyUpdate($ActionID,$this->ID);
		}
		
		$query = "SELECT *  FROM `transfer` where EPPID = '$this->EPPID'";
		$EppDatabase = new EppDatabase();
		$result = $EppDatabase->EppDatabaseQuery($query);
		$num=mysql_numrows($result);
		if ($num > 0){
		$ActionID = mysql_result($result,0,"ID");
		if(DEBUG_lEVEL >=5){ print "<p>Transfer message <p>";}
			$status = $this->xmlTrStatus($EppXMLResult);
			$EppTransfer = new EppTransfer();
			$EppTransfer->ApplyUpdate($ActionID,$this->ID,$status);
		}
		
		$this->xmlTransferCheck($EppXMLResult);
		

	}
	
	
	function xmlTrStatus($EppXMLResult){
	 // initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($EppXMLResult);

		
		$trstatus= $newdoc->getElementsByTagName('trStatus')->item(0)->nodeValue;

			
		  return $trstatus;
	}
	
	function xmlTransferCheck($EppXMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($EppXMLResult);

		$nodes= $newdoc->getElementsByTagName('trnData');
		

		if ($nodes->length >0) {
			if(DEBUG_lEVEL >=5){ print "<p>Is domain transfer</p>";}	
			 $name = $newdoc->getElementsByTagName('name')->item(0)->nodeValue;
			 $EppDomain = new EppDomain();
			$EppDomain->LoadName($name);
			
			 		$query = "UPDATE `message` SET `IsDomainTransfer` = '1',`DomainID` = '$EppDomain->ID' WHERE `ID` = $this->ID;";
					$EppDatabase = new EppDatabase();
					$EppDatabase->EppDatabaseQuery($query);

		}
	}
	
	public function Load($ID){
			$query = "SELECT *  FROM `message` where ID = '$ID'";
			$EppDatabase = new EppDatabase();
			$result = $EppDatabase->EppDatabaseQuery($query);
			$this->Date = mysql_result($result,0,"Date");
			$this->Message = mysql_result($result,0,"Message");
			$this->EPPID = mysql_result($result,0,"EPPID");
			$this->IsAck = mysql_result($result,0,"IsAck");	
			$this->IsActioned = mysql_result($result,0,"IsActioned");	
			$this->TransactionID = mysql_result($result,0,"TransactionID");		
			$this->IsDomainTransfer = mysql_result($result,0,"IsDomainTransfer");		
			$this->DomainID = mysql_result($result,0,"DomainID");		
			$this->ID = $ID;
	}
	
/*	
XML
XML generation functions
*/		
	
	public function xmlPoll(){
			return '<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
			 <command>
			   <poll op="req"/>
			   <clTRID>'.$this->UniqueID().'</clTRID>
			 </command>
		   </epp>';		
	}

	public function xmlAck($EPPID){
			return '<?xml version="1.0" encoding="UTF-8" standalone="no"?>
			   <epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
				   <command>
					 <poll op="ack" msgID="'.$EPPID.'"/>
					 <clTRID>'.$this->UniqueID().'</clTRID>
				   </command>
			   </epp>';		
	}
	
}