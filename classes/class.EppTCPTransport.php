<?php
# $Id$
# © Domain Name Services (Pty) Ltd. 2010. All rights reserved.
# Author: Ed Pascoe <ed@dnservices.co.za>

/*     
  EPP Client class for PHP. 
  This program includes support for SSL certificates if provided
*/

class EPPTransportError extends Exception{ };

class EPPTCPTransport{
   /*
      An epp client transport class. This is just the raw TCP IP protocol. The XML data needs to be handled separatly.
      The EPP transport protocol is definied at http://tools.ietf.org/html/rfc5734 it looks complicated but is 
      actually very simple and elegant. 
      the actual data should be XML data formated according to RFC5730-RFC5733
      No validation of any data takes place in this Class
    */

   var $sock;
   var $greeting; #Contents of the epp greeting when we connect

   function __construct($ip="127.0.0.1",$port=3121,$clientpemfile='epp.pem',$ssl=true) {
     if ($ssl) {
       $context = stream_context_create();
       #$result = stream_context_set_option($context, 'ssl', 'local_cert', $certFile);
       #if($passPhrase) $result = stream_context_set_option($context, 'ssl', 'passphrase', $passPhrase);
       $result = stream_context_set_option($context, 'ssl', 'verify_peer', false);
       $result = stream_context_set_option($context, 'ssl', 'verify_host', false);
       $result = stream_context_set_option($context, 'ssl', 'allow_self_signed', true);

       if ($clientpemfile) {
         print "Connecting using: '$clientpemfile'\n";
         stream_context_set_option($context, 'ssl', 'local_cert', $clientpemfile);
       }

       #http://bytes.com/topic/php/answers/389749-fsockopen-php5-missing-6th-argument-context
       $this->socket = stream_socket_client("tls://$ip:$port", &$errno,&$errstr, 60, STREAM_CLIENT_CONNECT, $context);
     } else {
       $this->socket = stream_socket_client("tcp://$ip:$port", &$errno,&$errstr, 60, STREAM_CLIENT_CONNECT);
     }
     $this->greeting=$this->read();
   }

   /* Read an EPP XML Instance 
    */

   function read() {
     $headerstr = "";
     while (strlen($headerstr) < 4)  {
        $lenstr = fread($this->socket,4 - strlen($headerstr)); #Get the size of the complete EPP Data Unit
        if ($lenstr === false) {
          throw EPPTransportError("Socket error");
        }
        $headerstr = $headerstr . $lenstr;
     }
     $bytes = unpack("Nbytes", $headerstr);
     $bytes = $bytes['bytes']; #PHP unpack returns an assoc array
     $data = "";
     while(strlen($data) < ($bytes - 4 ) ) {
        $tmpdata = fread($this->socket, ($bytes-4) - strlen($data)); #1st 4 bytes have already been read
        if ($tmpdata ===false)
          throw EPPTransportError("Didn't recieve any XML data?");
        $data = $data . $tmpdata;
     }
     return $data;
   }

   function write($eppmsg) {
     $lenstr=pack("N",strlen($eppmsg)+4);
     fwrite($this->socket,$lenstr);
     fwrite($this->socket,$eppmsg);
     return;
   }

   /*
      Convenience function. Does a write followed by a read
    */
   function chat($eppmsg){
      $this->write($eppmsg);
      return $this->read();
   }

   /**
   * Close the connection.
   */
   function close() {
      return @fclose($this->socket);
   }
}


   

