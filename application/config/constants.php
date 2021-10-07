<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('PROCENTAJE_COMISION_VENTAS'     , 10);
define('PERFIL_ADMIN'     , 'A');
define('PROCENTAJE_COMISION_OPERACIONES', 1 );
define('CORREO_CONTACTO'     , 'admin@senni.com.mx');
define('CORREO_DOMINIO'      , '@senni.com.mx');

define('TITULO_NAVEGADOR' , 'SENNI Logistics, Rompiendo barreras, cumpliendo tus metas' );
define('TITULO_VENTANA'   , 'SENNI Logistics' );
define('NOMBRE_CORTO'     , 'SENNI' );

define('RAZON_SOCIAL_FULL', 'SENNI Logistics S.A. DE C.V.' );
define('RAZON_SOCIAL'     , 'SENNI Logistics S.A. DE C.V.' );
define('RFC'              , 'SLO150219HS8' );
define('URL_SITE'         , 'www.senni.com.mx' );

define('IMPUESTO'       , 'IVA');
define('TIPOCOMP_FACT'  , 'Ingreso');
define('TIPOCOMP_PAGO'  , 'Pago');
define('SERIE_SAT'      , 'B');
define('SERIE_SAT_SENNI', 'B');
define('SERIE_SAT_PAGO' , 'P');
define('TIPOCOMP_RN'    , 'N');
define('STATUS_TIMBRADA','TIMBRADA');
define('STATUS_CANCELADA','CANCELADA');
define('TASA_IVA','0.160000');
define('TASA_IVA_CERO','0.000000');

define('STATUS_ELIMINADO', 94);
define('DOC_PUBLICO', 95);

/* End of file constants.php */
/* Location: ./application/config/constants.php */