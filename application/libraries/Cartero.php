<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Cartero
 *
 * @author edumu
 */
class Cartero {
    
    var $fromMail;
    var $fromName;
    var $message;
    var $cc;
    var $bcc;
    var $subject;
    var $adjunto;
    var $ci;
   
    
function __construct()
{
    $this->ci = get_instance();
    $this->ci->load->library('email');

    $config['protocol']    = "smtp";
    $config['smtp_host']   = "smtp.office365.com";
    $config['smtp_port']   = "587";
    $config['smtp_crypto'] = "tls";
    $config['smtp_timeout']= '60';
    $config['smtp_user']   = CORREO_CONTACTO; 
    $config['smtp_pass']   = "S0luc10n3s";    
    $config['charset']     = "UTF8";
    $config['mailtype']    = "html";		
    $config['wordwrap']    = TRUE;
    $config['priority']    = 2;
    $config['crlf']        = "\r\n";
    $config['newline']     = "\r\n";

    $this->fromMail = CORREO_CONTACTO;    

    $this->ci->email->clear();
    $this->ci->email->initialize($config);    
}
    
public function setfromMail($param)
{ $this->fromMail = $param; }

public function getfromMail()
{ return $this->fromMail; }

public function setfromName($param)
{ $this->fromName = $param; }

public function getfromName()
{ return $this->fromName; }

public function getmessage()
{ return $this->message; }

public function setmessage($param)
{ $this->message = $param; }

public function setto($param)
{ $this->to = $param; }

public function getto()
{ return $this->to; }

public function setcc($param)
{ $this->cc = $param; }

public function getcc()
{ return $this->cc; }

public function setbcc($param)
{ $this->bcc = $param; }

public function getbcc()
{ return $this->bcc; }

public function setsubject($param)
{ $this->subject = $param; }

public function getsubject()
{ return $this->subject; }

public function setadjunto($param)
{ $this->adjunto =  $param;      }

public function getadjunto()
{ return $this->adjunto; }
 
public function clearEmail()
{ $this->ci->email->clear(TRUE); }

public function mandaCorreo()
{	
try{    	
    $this->ci->email->from($this->getfromMail(), $this->getfromName());
    $this->ci->email->to  ($this->getto() );

   if( $this->getcc() != NULL)
     { $this->ci->email->cc($this->getcc()); }

   if( $this->getbcc() != NULL)		
     { $this->ci->email->bcc($this->getbcc()); }

   $this->ci->email->subject($this->getsubject());		
   $this->ci->email->message($this->getmessage() );

   if( $this->getadjunto() != NULL)
     { $this->ci->email->attach($this->getadjunto());  }    

   $sent =  $this->ci->email->send();   
   if (!$sent) 
    { log_message('error', "Excepción mandaCorreo:" . $this->ci->email->print_debugger() );  }    

  }catch (Exception $e) { log_message('error', "Excepción mandaCorreo:" . $e->getMessage()); }            
}

}//CLASS