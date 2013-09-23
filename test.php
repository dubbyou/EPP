<?php

		$EppXMLResult ="

		";

		// initialize new DOMDocument
		$newdoc = new DOMDocument();
		// disable whitespace-only text nodes
		$newdoc->preserveWhiteSpace = false;
		// read XML file
		$newdoc->loadXML("<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?>
<epp:epp xmlns:epp=\"urn:ietf:params:xml:ns:epp-1.0\">
  <epp:response>
    <epp:result code=\"1301\">
      <epp:msg>Command completed successfully; ack to dequeue</epp:msg>
    </epp:result>
    <epp:msgQ count=\"1\" id=\"OTE-EPP-140B181347A-B47E4\">
      <epp:qDate>2013-08-24T18:06:09.535Z</epp:qDate>
      <epp:msg>Domain 'depari1.test.dnservices.co.za' transfer requested by 'depari-2', a decision is required to approve or reject the transfer</epp:msg>
    </epp:msgQ>
    <epp:resData>
      <domain:trnData xmlns:domain=\"urn:ietf:params:xml:ns:domain-1.0\">
        <domain:name>depari1.test.dnservices.co.za</domain:name>
        <domain:trStatus>pending</domain:trStatus>
        <domain:reID>depari-2</domain:reID>
        <domain:reDate>2013-08-24T18:06:09Z</domain:reDate>
        <domain:acID>depari</domain:acID>
        <domain:acDate>2013-08-24T18:11:09Z</domain:acDate>
    </domain:trnData>
    </epp:resData>
    <epp:trID>
      <epp:clTRID>Depari5219174916bb60.57492932</epp:clTRID>
      <epp:svTRID>OTE-EPP-140B181347A-B47E4</epp:svTRID>
    </epp:trID>
  </epp:response>
</epp:epp>");

		$nodes= $newdoc->getElementsByTagName('trnData');
		
			print "$nodes->length;";

?>