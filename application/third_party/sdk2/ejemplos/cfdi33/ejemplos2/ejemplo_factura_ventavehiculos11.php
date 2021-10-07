<?php
// Se desactivan los mensajes de debug
error_reporting(0);

// Se especifica la zona horaria
date_default_timezone_set('America/Mexico_City');

// Se incluye el SDK
require_once '../../../sdk2.php';

// Se especifica la version de CFDi 3.3
$datos['version_cfdi'] = '3.3';
$datos['validacion_local'] = 'NO';
// SE ESPECIFICA EL COMPLEMENTO
$datos['complemento'] = 'ventavehiculos11';

// Ruta del XML Timbrado
$datos['cfdi']='../../../timbrados/ejemplo_factura_ventavehiculos1111.xml';

// Ruta del XML de Debug
$datos['xml_debug']='../../../timbrados/debug_ejemplo_factura_ventavehiculos1111.xml';

// Credenciales de Timbrado
$datos['PAC']['usuario'] = 'DEMO700101XXX';
$datos['PAC']['pass'] = 'DEMO700101XXX';
$datos['PAC']['produccion'] = 'NO';

// Rutas y clave de los CSD
$datos['conf']['cer'] = '../../../certificados/lan7008173r5.cer.pem';
$datos['conf']['key'] = '../../../certificados/lan7008173r5.key.pem';
$datos['conf']['pass'] = '12345678a';

// Datos de la Factura
$datos['factura']['condicionesDePago'] = 'CONDICIONES';
$datos['factura']['descuento'] = '0.00';
$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
$datos['factura']['folio'] = '100';
$datos['factura']['forma_pago'] = '01';
$datos['factura']['LugarExpedicion'] = '45079';
$datos['factura']['metodo_pago'] = 'PUE';
$datos['factura']['moneda'] = 'MXN';
$datos['factura']['serie'] = 'A';
$datos['factura']['subtotal'] = 100.00;
$datos['factura']['tipocambio'] = '1';
$datos['factura']['tipocomprobante'] = 'I';
$datos['factura']['total'] = 116.00;
$datos['factura']['RegimenFiscal'] = '601';

// Datos del Emisor
$datos['emisor']['rfc'] = 'LAN7008173R5'; //RFC DE PRUEBA
$datos['emisor']['nombre'] = 'ACCEM SERVICIOS EMPRESARIALES SC';  // EMPRESA DE PRUEBA

// Datos del Receptor
$datos['receptor']['rfc'] = 'XAXX010101000';
$datos['receptor']['nombre'] = 'Publico en General';
$datos['receptor']['UsoCFDI'] = 'G01';

// Se agregan los conceptos

$datos['conceptos'][0]['cantidad'] = 1.00;
$datos['conceptos'][0]['unidad'] = 'NA';
$datos['conceptos'][0]['ID'] = "1726";
$datos['conceptos'][0]['descripcion'] = "PRODUCTO DE PRUEBA 1";
$datos['conceptos'][0]['valorunitario'] = 100.00;
$datos['conceptos'][0]['importe'] =100.00;
$datos['conceptos'][0]['ClaveProdServ'] = '01010101';
$datos['conceptos'][0]['ClaveUnidad'] = 'ACT';

$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Base'] = 100.00;
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
$datos['conceptos'][0]['Impuestos']['Traslados'][0]['Importe'] = 16.00;



// Se agregan los Impuestos
$datos['impuestos']['translados'][0]['impuesto'] = '002';
$datos['impuestos']['translados'][0]['tasa'] = '0.160000';
$datos['impuestos']['translados'][0]['importe'] = 16.00;
$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';


$datos['impuestos']['TotalImpuestosTrasladados'] =16.00;

// Complemento de Venta de Vehiculos
$datos['ventavehiculos11']['ClaveVehicular']='2';
$datos['ventavehiculos11']['Niv']='A1';

$datos['ventavehiculos11']['InformacionAduanera'][0]['numero']='12';
$datos['ventavehiculos11']['InformacionAduanera'][0]['fecha']='2019-06-25';
$datos['ventavehiculos11']['InformacionAduanera'][0]['aduana']='jdhe';

$datos['ventavehiculos11']['InformacionAduanera'][1]['numero']='16';
$datos['ventavehiculos11']['InformacionAduanera'][1]['fecha']='2019-06-25';
$datos['ventavehiculos11']['InformacionAduanera'][1]['aduana']='kjhe';
/*
$datos['ventavehiculos11']['Parte'][0]['InformacionAduanera'][0]['numero']='2';
$datos['ventavehiculos11']['Parte'][0]['InformacionAduanera'][0]['fecha']='2019-06-25';
$datos['ventavehiculos11']['Parte'][0]['InformacionAduanera'][0]['aduana']='wed';
$datos['ventavehiculos11']['Parte'][0]['InformacionAduanera'][1]['numero']='3';
$datos['ventavehiculos11']['Parte'][0]['InformacionAduanera'][1]['fecha']='2019-06-25';
$datos['ventavehiculos11']['Parte'][0]['InformacionAduanera'][1]['aduana']='ntu';
$datos['ventavehiculos11']['Parte'][0]['cantidad']='116.00';
$datos['ventavehiculos11']['Parte'][0]['unidad']='0';
$datos['ventavehiculos11']['Parte'][0]['noIdentificacion']='detalles';
$datos['ventavehiculos11']['Parte'][0]['descripcion']='10.23';
$datos['ventavehiculos11']['Parte'][0]['valorUnitario']='116.00';
$datos['ventavehiculos11']['Parte'][0]['importe']='116.00';

$datos['ventavehiculos11']['Parte'][1]['cantidad']='112';
$datos['ventavehiculos11']['Parte'][1]['unidad']='76';
$datos['ventavehiculos11']['Parte'][1]['noIdentificacion']='098';
$datos['ventavehiculos11']['Parte'][1]['descripcion']='kye';
$datos['ventavehiculos11']['Parte'][1]['valorUnitario']='119.00';
$datos['ventavehiculos11']['Parte'][1]['importe']='119.00';
*/
// Se ejecuta el SDK
$res= mf_genera_cfdi($datos);


///////////    MOSTRAR RESULTADOS DEL ARRAY $res   ///////////
 
echo "<h1>Respuesta Generar XML y Timbrado</h1>";
foreach($res AS $variable=>$valor)
{
    $valor=htmlentities($valor);
    $valor=str_replace('&lt;br/&gt;','<br/>',$valor);
    echo "<b>[$variable]=</b>$valor<hr>";
}



?>