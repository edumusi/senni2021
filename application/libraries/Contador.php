<?php
require_once(APPPATH."third_party/sdk2/sdk2.php");
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contador
 *
 * @author edumu
 */
class Contador {
        
var $ci;
var $configTimbrado;
var $model;
var $empresa;
   

public function setconfigTimbrado($param)
{ $this->configTimbrado = $param; }

public function getconfigTimbrado()
{ return $this->configTimbrado;   }    


public function setmodel($param)
{ $this->model = $param; }

public function getmodel()
{ return $this->model;   }    
    

public function setempresa($param)
{ $this->empresa = $param; }

public function getempresa()
{ return $this->empresa;   }
    

function __construct()
{    
    date_default_timezone_set('America/Mexico_City');
    error_reporting(~(E_WARNING|E_NOTICE));      
}//CONSTRUCT


public function Init($dbFiscal)
{  
    $this->empresa = $dbFiscal;

    if (file_exists($dbFiscal['dir_cfdi']) == FALSE)
       { mkdir($dbFiscal['dir_cfdi'], 0755); 	   } 

    if ( file_exists($dbFiscal['dir_cfdi']) == FALSE  )
	   { 
		 mkdir($dbFiscal['dir_cfdi'], 0755); 
		 $dbFiscal['dir_cfdi'] = $dbFiscal['dir_cfdi']."cfdi/";
		 mkdir($dbFiscal['dir_cfdi'], 0755);	  	  
	   }
	else{ $dbFiscal['dir_cfdi'] = $dbFiscal['dir_cfdi']."cfdi/";
		  if ( file_exists($dbFiscal['dir_cfdi']) == FALSE  )
	   	  	 { mkdir($dbFiscal['dir_cfdi'], 0755); 			}
	    }       

    $this->configTimbrado['dir_cfdi']     = $dbFiscal['dir_cfdi'];
    $this->configTimbrado['version_cfdi'] = '3.3';
    // Ruta del XML Timbrado
    $this->configTimbrado['cfdi'] = $dbFiscal['dir_cfdi'].$dbFiscal['rfc'].'_cfdi3_3.xml'; //APPPATH.'third_party/sdk2/timbrados/cfdi_ejemplo_factura.xml'; ; 

    // Ruta del XML de Debug
    $this->configTimbrado['xml_debug'] = APPPATH.'third_party/sdk2/timbrados/sin_timbrar_ejemplo_factura.xml';

    // Credenciales de Timbrado
    $this->configTimbrado['PAC']['usuario']    = $dbFiscal['PAC_USUARIO'];
    $this->configTimbrado['PAC']['pass']       = $dbFiscal['PAC_PWD'];
    $this->configTimbrado['PAC']['produccion'] = PROD_FAC;

    // Rutas y clave de los CSD
    $app_path_timb = "/home/sqm8qb62kmlm/public_html/web_app/third_party/sdk2/certificados/";
    $this->configTimbrado['conf']['cer']  = $app_path_timb.$dbFiscal['CSD_CER'];
    $this->configTimbrado['conf']['key']  = $app_path_timb.$dbFiscal['CSD_KEY'];
    $this->configTimbrado['conf']['pass'] = $dbFiscal['CSD_PWD'];

    // Datos del Emisor
    $this->configTimbrado['emisor']['rfc']    = 'XIA190128J61'; //RFC DE PRUEBA //$dbFiscal['rfc']
    $this->configTimbrado['emisor']['nombre'] = 'ACCEM S&ERVICIOS EMPRESARIALES SC';  // EMPRESA DE PRUEBA+ //$dbFiscal['nombre_fiscal']
    /* QUITAR PARA FACTURAR CON SENNI O RAMF
    $this->configTimbrado['emisor']['nombre_fiscal'] = $dbFiscal['nombre_fiscal'];
	$this->configTimbrado['emisor']['cp_fiscal'] 	  = $dbFiscal['cp_fiscal'];
	$this->configTimbrado['emisor']['correo_fiscal'] = $dbFiscal['correo_fiscal'];
    */

}//Init

public function Facturar($datos)
{
try{
    date_default_timezone_set('America/Mexico_City');
    error_reporting(~(E_WARNING|E_NOTICE));  

    $resp   = mf_genera_cfdi($datos);
    $error  = array();    
    
    foreach($resp AS $variable=>$valor)
		{         
            if( strpos($valor, "ERROR") !== false || strpos($valor, "error") !== false )
              { array_push($error,$valor);        }				
        }    
    $sucess = ( count($error) == 0 ) ? $resp : array() ;    

    $resp   = array( "error"    => $error,
                     "success"  => $sucess
                   );

    return $resp;

    }catch (Exception $e) { log_message('error', "Excepción Facturar:" . $e->getMessage()); }            
}//FACTURAR
    

}//CLASS