<?php

class EppRegistrar {
	  
	 public	$Balance;

/*	
FUNCTIONS
Main functions are placed int this section
*/
	//returns the balance from coza
	public function Balance(){
		$myEppServer = new EppServer();
		if(DEBUG_lEVEL >=5){ print "<p>Starting Connection</p>";}
		$myEppServer->Start();
		$myEppServer->Chat($this->xmlBalance());
		$resultcode = $myEppServer->ResultCode();
		$this->xmlBalanceProcess($myEppServer->OutXML);
		return($this->Balance);
		$myEppServer->Stop();
		if(DEBUG_lEVEL >=5){ print "<p>Stopping Connection</p>";}
	}



/*	
SUBFUNCTIONS
Supporting functions are placed in this section
*/

	//balance xml processing
	function xmlBalanceProcess($XMLResult){
		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML($XMLResult);
		// get root element
		$newroot = $newdoc->firstChild;
		$this->Balance = $newdoc->getElementsByTagName('balance')->item(0)->nodeValue;
	}

	//balance xml request
	public function xmlBalance(){
		return '
		<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
xmlns:contact="urn:ietf:params:xml:ns:contact-1.0" 
xmlns:cozacontact="http://co.za/epp/extensions/cozacontact-1-0">
  <epp:command>
    <epp:info>
      <contact:info>
        <contact:id>depari</contact:id>
      </contact:info>
    </epp:info>
    <epp:extension>
      <cozacontact:info>
      <cozacontact:balance>true</cozacontact:balance></cozacontact:info>
    </epp:extension>
  </epp:command>
</epp:epp>
			 ';		
			 
	}

} // End User class definition
?>