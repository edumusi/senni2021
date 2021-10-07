<?php
     $html = "<html>";
     $meta = array(  array('name' => 'author', 'content' => NOMBRE_CORTO),
                     array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
                  );
      
     $html = $html ."<head>";
     $html = $html . meta($meta);
     $html = $html . '<link rel="STYLESHEET" href="css/factura_pdf.css" type="text/css">';     
     $html = $html . "</head>"; 
  
	 $htmlConceptos = "";
	 foreach($f['conceptos'] as $con)
	 {
		$htmlConceptos = $htmlConceptos . '<tr> <td width="14.28%" class="center" style="font-size: 7pt;"> '.$con['ClaveProdServ'].' </td>
												<td width="10.28%" class="center" style="font-size: 7pt;"> '.$con['ClaveUnidad'].' </td>
												<td width="10.28%" class="center" style="font-size: 7pt;"> '.$con['unidad'].' </td>
												<td width="24.00%" class="right"  style="font-size: 7pt;"> '.$con['descripcion'].' </td>
												<td width="10.28%" class="center" style="font-size: 7pt;"> '.$con['cantidad'].' </td>
												<td width="14.28%" class="center" style="font-size: 7pt;"> '.number_format($con['valorunitario'],2).' </td>
												<td width="14.28%" class="center" style="font-size: 7pt;"> '.number_format($con['importe'],2).' </td>
										</tr>';
	 }

	 $htmlIVAConceptos = "";
	 foreach($f['pdfconceptos'] as $conIVA)
	 {
		
		$htmlIVAConceptos = $htmlIVAConceptos . '<tr> <td width="20%" class="center" style="font-size: 7pt;"> '.number_format($conIVA['Impuestos']['Traslados'][0]['Base'],2).' </td>
													  <td width="20%" class="center" style="font-size: 7pt;"> '.$conIVA['Impuestos']['Traslados'][0]['Impuesto'].' </td>
													  <td width="20%" class="center" style="font-size: 7pt;"> '.$conIVA['Impuestos']['Traslados'][0]['TipoFactor'].' </td>
													  <td width="20%" class="center" style="font-size: 7pt;"> '.$conIVA['Impuestos']['Traslados'][0]['TasaOCuota'].' </td>
													  <td width="20%" class="center" style="font-size: 7pt;"> '.number_format($conIVA['Impuestos']['Traslados'][0]['Importe'],2).' </td>
		   										</tr>';
	 } 
   $decimalTotal = null;
   $wholeTotal   = null; 
   
   $tot = number_format($f['factura']['total'] ,2);
   list($wholeTotal, $decimalTotal) = explode('.', $tot );

   $html = $html .'<body marginwidth="0" marginheight="0">'
                    .'<div class="header">'
                    .  '<div style="width: 100%;">
                          <table align="center" style="width: 100%;">
                          <tbody>
						  <tr>
						    <td width="5%" class="left" style="font-size: 9pt;"> </td> 
							<td width="30%" class="left" style="font-size: 9pt;"> 
							<div class="recuadroGris">
							'.nbs(2).'<strong>'.$f['emisor']['nombre_fiscal'].'</strong>'.br()
							 .nbs(2).'<strong>RFC:</strong>'.$f['emisor']['rfc'].br()				  
							 .nbs(2).$f['emisor']['cp_fiscal'].br()
							 .nbs(2).$f['emisor']['correo_fiscal'].br()
							.'							
							</div></td> 
							<td width="30%" class="center" style="font-size: 9pt;">
								<strong>FOLIO:</strong><br><strong>'.$f['factura']['serie'].'-'.$f['factura']['folio'].'</strong><br>
								<strong>FOLIO FISCAL:</strong><br>'.$r['folio_fiscal'].'
							</td>							
							<td width="35%" class="center"> <img src="images/LogoSenni.jpg" width="200 px" height="80 px"> </td>
                          </tr>                          
                          </tbody>
                          </table>
						</div>'
					.'</div>
					<div class="recuadroGrisClaro"> 
					'.br(1)	
					.'<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
						<tbody>
							<tr> <td width="100%" colspan="4" class="center fondoColor" style="font-size: 9pt;"><strong>FACTURA</strong> </td> </tr>							
							<tr> <td width="20%" class="right" style="font-size: 8pt;"> <strong>FOLIO: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['folio'].' </td>
								 <td width="20%" class="right" style="font-size: 8pt;"> <strong>LUGAR DE EXPEDICIÓN: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['LugarExpedicion'].' </td>
							</tr>
							<tr> <td width="20%" class="right" style="font-size: 8pt;"> <strong>FOLIO FISCAL: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$r['folio_fiscal'].' </td> 
								 <td width="20%" class="right" style="font-size: 8pt;"> <strong>FECHA Y HORA DE EMISIÓN: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['fecha_expedicion'].' </td>
							</tr>
							<tr> <td width="20%" class="right" style="font-size: 8pt;"> <strong>VERSIÓN: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['version_cfdi'].' </td>
								 <td width="20%" class="right" style="font-size: 8pt;"> <strong>FECHA Y HORA DE CFDI: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$r['fecha_timbrado'].' </td>
							</tr>									
							<tr> <td width="20%" class="right" style="font-size: 8pt;"> <strong>FORMA DE PAGO: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['forma_pago'].' '.$f['factura']['forma_pagoDesc']['Descripcion'].'</td>
								 <td width="20%" class="right" style="font-size: 8pt;"> <strong>RÉGIMEN FISCAL: </strong> </td> 
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['RegimenFiscal'].' '.$f['factPDF']['RegimenFiscalDesc']['Descripcion'].'</td>
							</tr>							
							<tr> 
								<td width="20%" class="right" style="font-size: 8pt;"> <strong>MÉTODO DE PAGO: </strong> </td>
								<td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['metodo_pago'].' '.$f['factura']['metodo_pagoDesc']['Descripcion'].'</td>
								<td width="20%" class="right" style="font-size: 8pt;"> <strong>TIPO DE COMPROBANTE: </strong> </td>
								<td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factura']['tipocomprobante'].' '.$f['factPDF']['tipocomprobanteDesc'].' </td>								
							</tr>
						</tbody>
						</table>
					'.br(2)	
					.'<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
						<tbody>
							<tr> <td width="100%" colspan="4" class="center fondoColor" style="font-size: 9pt;"><strong>CLIENTE</strong>  </td> </tr>
							<tr> <td width="20%" class="right" style="font-size: 8pt;"> <strong>RFC: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['receptor']['rfc'].' </td>
								 <td width="20%" class="right" style="font-size: 8pt;"> <strong>CORREO: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factPDF']['emailReceptor'] .' </td>
							</tr>
							<tr> <td width="20%" class="right" style="font-size: 8pt;"> <strong>RAZÓN SOCIAL: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['receptor']['nombre'].' </td>
								 <td width="20%" class="right" style="font-size: 8pt;"> <strong>CÓDIGO POSTAL: </strong> </td>
								 <td width="30%" class="left"  style="font-size: 8pt;">'.nbs().$f['factPDF']['cpReceptor'].' </td>
							</tr>
							<tr> <td width="50%" colspan="2" class="right" style="font-size: 8pt;"> <strong>USO DE CFDI: </strong> </td>
								 <td width="50%" colspan="2" class="left"  style="font-size: 8pt;">'.nbs().$f['receptor']['UsoCFDI'].' '.$f['factPDF']['UsoCFDIDesc']['Descripcion'].' </td>								 
							</tr>	
						</tbody>
						</table>'						
					.( ($f['factPDF']['notas']==null || $f['factPDF']['notas']=="") ? "" : 
						br(1).'	<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>
								<tr> <td width="" class="center fondoColor" style="font-size: 9pt;"><strong>NOTAS</strong> </td> </tr>
								<tr> <td width="" class="left" style="font-size: 9pt;">'.nbs().$f['factPDF']['notas'].' </td> </tr>
							</tbody>
							</table>'
					) 
					.br(2)	
					.'	<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>								
								<tr> <td width="100%" colspan="7" class="center fondoColor" style="font-size: 9pt;"> <strong>CONCEPTOS</strong> </td> </tr>
								<tr> <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>CLAVE PRODUCTO/SERVICIO</strong> </td>
									 <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>CLAVE UNIDAD</strong> </td>
									 <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>UNIDAD</strong> </td>
									 <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>DESCRIPCIÓN</strong> </td>
									 <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>CANTIDAD</strong> </td>
									 <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>VALOR UNITARIO</strong> </td>
									 <td width="14.28%" class="center" style="font-size: 8pt;"> <strong>IMPORTE</strong> </td>
								</tr>
								'.
								$htmlConceptos
								.'
							</tbody>
						</table>
					'
					.br(2)	
					.'<div class="recuadroGris">
					  <table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>
								<tr> <td width="100%" rowspan="4" class="left" style="font-size: 8pt;">'.nbs(3).'<strong>Moneda:</strong> '.$f['factura']['moneda'].($f['factura']['moneda']=="MXN"?'- Peso Mexicano.':'- Dolar americano. <strong>Tipo de Cambio:</strong> '.$f['factura']['tipocambio']).br(3).nbs(3).' TOTAL EN LETRA '.br(1).nbs(3).'<small><i>'.$f['factPDF']['totalConLetras'].($f['factura']['moneda']=="MXN"?' PESOS '.$decimalTotal.'/100 M.N':' USD CON '.$decimalTotal.'/100').'</i></small></td></tr>									 
								<tr> <td width="75%" class="right" style="font-size: 9pt;"><strong>SUBTOTAL </strong></td>
									 <td width="25%" class="left" style="font-size: 9pt;">'.nbs().number_format($f['factura']['subtotal'] ,2).' </td>  
								</tr>
								<tr> <td width="75%" class="right" style="font-size: 8pt;"><strong>IMPUESTOS FEDERALES TRASLADADOS </strong> </td> 
									 <td width="25%" class="left" style="font-size: 9pt;">'.nbs().number_format($f['impuestos']['TotalImpuestosTrasladados'] ,2).' </td>  
								</tr>
								<tr> <td width="75%" class="right" style="font-size: 9pt;"><strong>TOTAL </strong> </div> </td> 
									 <td width="25%" class="left" style="font-size: 9pt;">'.nbs().number_format($f['factura']['total'] ,2).' </td>  
								</tr>								
							</tbody>
						</table>
						</div>  '
					.br(2)	
					.'	<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>								
								<tr> <td width="100%" colspan="5" class="center fondoColor" style="font-size: 8pt;"><strong>IMPUESTOS FEDERALES TRASLADADOS </strong> </td> </tr>
								<tr> <td width="20%" class="center" style="font-size: 7pt;"> <strong>BASE</strong> </td>
									 <td width="20%" class="center" style="font-size: 7pt;"> <strong>IMPUESTO</strong> </td>
									 <td width="20%" class="center" style="font-size: 7pt;"> <strong>TIPO FACTOR</strong> </td>
									 <td width="20%" class="center" style="font-size: 7pt;"> <strong>TASA/CUOTA</strong> </td>
									 <td width="20%" class="center" style="font-size: 7pt;"> <strong>IMPORTE</strong> </td>									 
								</tr>	
								'.
								$htmlIVAConceptos
								.'							
							</tbody>
						</table>
					'.br(1)
					.'</div>
					'.br(1)
					.'<table cellspacing="0" align="center" cellpadding="0" width="100%">
							<tbody> 
								<tr><td width="70%" class="left " style="font-size: 7pt;">
									 <span style="font-size: 7pt; background: #FFF; color: #5B9BD5;">'.nbs().'NÚMERO DE SERIE DEL CERTIFICADO DEL SAT'.nbs().'</span>'.nbs(6).'<span style="font-size: 7pt; background: #FFF; color: #5B9BD5;">'.nbs().'NÚMERO DE SERIE DEL CSD DEL EMISOR'.nbs().'</span>
							'.br(1).'<span style="font-size: 7pt; ">'.$r['representacion_impresa_certificadoSAT'].'</span>'.nbs(60).'<span style="font-size: 7pt; ">'.$r['representacion_impresa_certificado_no'].'</span>
									 '.br(2).'
									 <span style="font-size: 7pt; background: #FFF; color: #5B9BD5;">'.nbs().'SELLO DIGITAL DEL SAT'.nbs().'</span>
									 ';
							$lenCadena     = strlen($r['representacion_impresa_selloSAT']);
							$totCaracteres = 100;
							$renglones 	   = intval($lenCadena / $totCaracteres);
							$offset 	   = -100;							
							for ($i = 0; $i <= $renglones; $i++) 
								{ $offset = $offset + $totCaracteres; 
								  $html = $html.br(1).'<span style="font-size: 7pt; ">'.substr($r['representacion_impresa_selloSAT'], $offset, $totCaracteres).'</span>'; 
								}

							$html = $html.br(2).'<span style="font-size: 7pt; background: #FFF; color: #5B9BD5;">'.nbs().'SELLO DIGITAL DEL CFDI'.nbs().'</span>';
							$lenCadena     = strlen($r['representacion_impresa_sello']);
							$totCaracteres = 100;
							$renglones 	   = intval($lenCadena / $totCaracteres);
							$offset 	   = -100;							
							for ($i = 0; $i <= $renglones; $i++) 
								{ $offset = $offset + $totCaracteres; 
								  $html = $html.br(1).'<span style="font-size: 7pt; ">'.substr($r['representacion_impresa_sello'], $offset, $totCaracteres).'</span>'; 
								}														
							$html = $html.br(2).'<span style="font-size: 7pt; background: #FFF; color: #5B9BD5;">'.nbs().'CADENA ORIGINAL DEL COMPLEMENTO DE CERTIFICACIÓN DIGITAL DEL SAT'.nbs().'</span>';
							$lenCadena     = strlen($r['representacion_impresa_cadena']);
							$totCaracteres = 100;
							$renglones 	   = intval($lenCadena / $totCaracteres);
							$offset 	   = -100;							
							for ($i = 0; $i <= $renglones; $i++) 
								{ $offset = $offset + $totCaracteres; 
								  $html = $html.br(1).'<span style="font-size: 7pt; ">'.substr($r['representacion_impresa_cadena'], $offset, $totCaracteres).'</span>'; 
								}
							$html = $html.'
									</td> 
									<td width="30%"><center><img src="'.$r['archivo_png'].'" width="212 px" height="212 px"> </center></td> 
								</tr>								
							</tbody> 
						</table>						
					'
					.br(1)	
					.'  <div class="footer">
                          <table align="center" style="width: 100%;">
							<tbody>
							<tr>
								<td width="5%" class="center" style="font-size: 9pt;"> </td> 
								<td width="45%" class="left" style="font-size: 6pt;">ESTE DOCUMENTO ES UNA REPRESENTACIÓN IMPRESA DE UN CFDI 3.3</td>
								<td width="25%" class="center" style="font-size: 6pt;"> CFDI emitido por </td>
								<td width="20%" class="right"   style="font-size: 6pt;"> <div class="page-number"></div> </td>
								<td width="5%" class="center" style="font-size: 9pt;"> </td> 
							</tr>                          
							</tr>
							</tbody>
                          </table>'
                    .  '</div>'
                    ;
  
     echo  $html;
?>
