<?php
include('includes.php');
?> 
<?php
$myEppServer = new EppServer();
$myEppServer->Start();
$myEppServer->Chat('<epp:epp xmlns:epp="urn:ietf:params:xml:ns:epp-1.0" 
xmlns:contact="urn:ietf:params:xml:ns:contact-1.0" 
xmlns:cozacontact="http://co.za/epp/extensions/cozacontact-1-0">
  <epp:command>
    <epp:info>
      <contact:info>
        <contact:id>examplerarID</contact:id>
      </contact:info>
    </epp:info>
    <epp:extension>
      <cozacontact:info>
      <cozacontact:balance>true</cozacontact:balance></cozacontact:info>
    </epp:extension>
  </epp:command>
</epp:epp>');
$myEppServer->Stop();
?>