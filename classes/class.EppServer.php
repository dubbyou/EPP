<?php

class EppServer{
	
	
	private $Server 	= EPP_SERVER;
	private $Port 		= EPP_PORT;
	private $UserName	= EPP_USERNAME;
	private $Password	= EPP_PASSWORD;
	private $Session;	//The Active EppTCPTransport
	public  $OutXML;
	
/*	
FUNCTIONS
Main functions are placed int this section
*/
	
	//open conection and login
	function Start(){
		if(DEBUG_lEVEL >=5){ print "<p>Creating TCPIP Session</p>";}
		$this->Session = new EPPTCPTransport($this->Server,$this->Port);
		if(DEBUG_lEVEL >=5){ print "<p>Calling Login</p>";}
		$this->Login();
	}
	
	//submit and recive xml results from coza
	function Chat($InXML){
		if(DEBUG_lEVEL >=5){ print "<p>Chatting to the server</p>";}
		$this->OutXML= $this->Session->chat($InXML);
		if(DEBUG_lEVEL >=5){ print "<p>Logging the chat</p>";}
		return $this->ChatLog($InXML,$this->OutXML); //log the interaction
	}
	
	//logout and close connection
	function Stop(){
		if(DEBUG_lEVEL >=5){ print "<p>Calling Logout</p>";}
		$this->Logout();
		if(DEBUG_lEVEL >=5){ print "<p>Closing TCPIP Session</p>";}
		$this->Session->close();
	}
	
	//log chats to the database
	function ChatLog($InXML,$OutXML){
		$InTemp = "$InXML";
		$OutTemp = str_replace("'", "\'", $OutXML);
		$query = "INSERT INTO `transaction` (`ID`, `Request`, `Response`) VALUES (NULL, '$InTemp', '$OutTemp');";
		$EppDatabase = new EppDatabase();
		$EppDatabase->EppDatabaseQuery($query);
		return $EppDatabase->InsertID;
	}
	
/*	
SUBFUNCTIONS
Supporting functions are placed in this section
*/

	// This function wil create a unique ID prefixed with Depari
	function UniqueID(){
		return uniqid ('Depari', true);
	}
	
	//returns the result code from a chat
	function ResultCode(){
		if(DEBUG_lEVEL >=5){ print "<p>Processing Result code</p>";}
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($this->OutXML);
		return $newdoc->getElementsByTagName('result')->item(0)->getAttribute('code');
	}
	
	//returns the number of chats
	function TotalChats(){
		$query = "SELECT COUNT(*) AS Total FROM `transaction` ";
		$EppDatabase = new EppDatabase();
		$result = $EppDatabase->EppDatabaseQuery($query);
		$total=mysql_result($result,0,"Total");
		return $total;
	}
	
	
	// generate the XML and login to the server
	function Login(){
		if(DEBUG_lEVEL >=5){ print "<p>Starting login chat</p>";}
		$this->Chat('<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
				  <command>
					<login>
					   <clID>'.$this->UserName.'</clID>
					  <pw>'.$this->Password.'</pw>
					  <options>
						<version>1.0</version>
						<lang>en</lang>
					  </options>
					  <svcs>
						<objURI>urn:ietf:params:xml:ns:domain-1.0</objURI>
						<objURI>urn:ietf:params:xml:ns:contact-1.0</objURI>
					  </svcs>
					</login>
					<clTRID>'.$this->UniqueID().'</clTRID>
				  </command>
				</epp>');
	}
	
	//generate the XML and logout
	function Logout(){
		if(DEBUG_lEVEL >=5){ print "<p>Starting logout chat</p>";}
		$this->Chat('
				<epp xmlns="urn:ietf:params:xml:ns:epp-1.0">
				  <command>
					<logout/>
					<clTRID>'.$this->UniqueID().'</clTRID>
				  </command>
				</epp>');	
	}
	
	
	
	
}