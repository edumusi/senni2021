<?php
	$html = "<html>";
	$meta = array(  array('name' => 'author', 'content' => NOMBRE_CORTO),
					array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
				 );

	$html = $html ."<head>";
	$html = $html . meta($meta);
	$html = $html . '<link rel="STYLESHEET" href="css/rn_pdf.css" type="text/css">';     
	$html = $html . "</head>"; 	 
	 
    $html = $html .'<body marginwidth="0" marginheight="0">'
                    .'<div class="header">'
                    .  '<div style="width: 100%;">
                          <table align="center" style="width: 100%;">
                          <tbody> 
						  <tr>
						  	<td width="30%" class="left"> <img src="images/'.$rn['PDF']['logo'].'" width="'.$rn['PDF']['logoWidth'].' px" height="'.$rn['PDF']['logoHeight'].' px"> </td>						    
							<td width="30%" class="left" style="font-size: 7pt;">
								<strong>'.$rn['PDF']['rsEmisor'].'</strong><br>
								<strong>RFC:</strong> '.$rn['nomina12']['Emisor']['RfcPatronOrigen'].'<br>
								<strong>Regimen Fiscal:</strong><br>'.$rn['factura']['RegimenFiscal'].' - '.$rn['PDF']['regimen_fiscalDesc'].'<br>
								<strong>Registro Patronal:</strong> '.$rn['nomina12']['Emisor']['RegistroPatronal'].'<br>								 
							</td>
							<td width="40%" class="left" style="font-size: 7pt;"> 								
								<strong>Tipo Comprobante:</strong> '.$rn['factura']['tipocomprobante'].' - '.$rn['PDF']['tipocomprobanteDesc'].'<br>
								<strong>Folio Fiscal:</strong> '.$rn['uuid'] .'<br>								
								<strong>Fecha y Hora Emisión:</strong> '.$rn['fecha_timbrado'] .'<br>
								<strong>Lugar de Expedición:</strong> '.$rn['PDF']['cpEmisor'] .'<br>
								<strong>Método de Pago:</strong> '.$rn['factura']['metodo_pago'].' - '.$rn['PDF']['metodo_pagoDesc'].'<br>
								<strong>Forma de Pago:</strong> '.$rn['factura']['forma_pago'].' - '.$rn['PDF']['forma_pagoDesc'].'<br>								
							</td>
                          </tr>
                          </tbody>
                          </table>
						</div>'
					.'</div>
					  <table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
						<tbody>
							<tr> <td width="35%" class="left" style="font-size: 8pt;">
									<div class="recuadroGrisClaro">
									'.nbs(3).'<strong>Fecha Pago:</strong> '.$rn['nomina12']['FechaPago'] .'<br>
									'.nbs(3).'<strong>Fecha Inicial Pago:</strong> '.$rn['nomina12']['FechaInicialPago'] .'<br>
									'.nbs(3).'<strong>Fecha Final de Pago:</strong> '.$rn['nomina12']['FechaFinalPago'] .'<br>
									'.nbs(3).'<strong>Número Días Pagados:</strong> '.$rn['nomina12']['NumDiasPagados'] .'<br>
									'.nbs(3).'<strong>Periocididad Pago:</strong> '.$rn['nomina12']['Receptor']['PeriodicidadPago'] .'<br>
									</div>
								 </td> 
								 <td width="25%" class="center" style="font-size: 9pt;"><strong>RECIBO<br>DE<br>NOMINA</strong></td> 
								 <td width="40%" class="left" style="font-size: 8pt;">
								 <div class="recuadroGrisClaro">
									'.nbs(3).'<strong>Fecha Inicio Laboral:</strong> '.$rn['nomina12']['Receptor']['FechaInicioRelLaboral'] .'<br>
									'.nbs(3).'<strong>Tipo de Contrato:</strong> '.$rn['nomina12']['Receptor']['TipoContrato'] .'<br>
									'.nbs(3).'<strong>Tipo Jornada:</strong> '.$rn['tipo_jornada_emp'] .'<br>
									'.nbs(3).'<strong>Tipo Nomina:</strong> '.$rn['nomina12']['TipoNomina']  .'<br><br>						
									</div>
								 </td> 								 
							</tr>							
						</tbody>
						</table>
					'.br()
					.'	<div class="recuadroGrisClaro"><br>			
							<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>
								<tr> <td width="100%" colspan="4" class="center fondoColor" style="font-size: 9pt;"><strong>EMPLEADO</strong>  </td> </tr>
								<tr> <td width="20%" class="right" style="font-size: 7pt;"> <strong>Nombre: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['receptor']['nombre'].' </td>
									<td width="20%" class="right" style="font-size: 7pt;"> <strong>Num. Empleado : </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['nomina12']['Receptor']['NumEmpleado']  .' </td>
								</tr>
								<tr> <td width="20%" class="right" style="font-size: 7pt;"> <strong>RFC: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['receptor']['rfc'].' </td>
									<td width="20%" class="right" style="font-size: 7pt;"> <strong>Num Seg. Social: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['nomina12']['Receptor']['NumSeguridadSocial'] .' </td>
								</tr>
								<tr> <td width="20%" class="right" style="font-size: 7pt;"> <strong>Clave Entidad: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['nomina12']['Receptor']['ClaveEntFed']  .' </td>
									<td width="20%" class="right" style="font-size: 7pt;"> <strong>CURP: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['nomina12']['Receptor']['Curp']  .' </td>
								</tr>
								<tr> <td width="20%" class="right" style="font-size: 7pt;"> <strong>Uso de CFDI: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['receptor']['UsoCFDI'].' </td>
									<td width="20%" class="right" style="font-size: 7pt;"> <strong>Puesto: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['nomina12']['Receptor']['Puesto'] .' </td>
								</tr>	
								<tr> <td width="20%" class="right" style="font-size: 7pt;"> '.nbs().' </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().' </td>
									<td width="20%" class="right" style="font-size: 7pt;"> <strong>Banco: </strong> </td>
									<td width="30%" class="left"  style="font-size: 7pt;">'.nbs().$rn['nomina12']['Receptor']['Banco'] .' </td>
								</tr>								
							</tbody>
							</table>
						</div>'					
					.br()	
					.'	<div class="recuadroGrisClaro"><br>
							<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>								
								<tr> <td width="10%" class="center fondoColor"  style="font-size: 8pt;"> <strong>CANTIDAD </strong> </td>
									 <td width="10%" class="center fondoColor"  style="font-size: 8pt;"> <strong>UNIDAD </strong> </td>
									 <td width="40%" class="center fondoColor"  style="font-size: 8pt;"> <strong>CONCEPTO </strong> </td>
									 <td width="20%" class="center fondoColor"  style="font-size: 8pt;"> <strong>VALOR UNITARIO </strong> </td>
									 <td width="20%" class="center fondoColor"  style="font-size: 8pt;"> <strong>IMPORTE </strong> </td>
								</tr>
								<tr> <td width="10%" class="center"  style="font-size: 7pt;"> 1 </td>
									 <td width="10%" class="center"  style="font-size: 7pt;"> ACT </td>
									 <td width="40%" class="center"  style="font-size: 7pt;"> PAGO DE NOMINA </td>
									 <td width="20%" class="center"  style="font-size: 7pt;"> '.number_format($rn['factura']['subtotal'], 2).' </td>
									 <td width="20%" class="center"  style="font-size: 7pt;"> '.number_format($rn['factura']['subtotal'], 2).' </td>
								</tr>
								</tbody>
							</table><br>
							<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>								
								<tr> <td width="60%" colspan="6" class="center fondoColor" style="font-size: 9pt;"> <strong>PERCEPCIONES </strong> </td>
									 <td width="40%" colspan="4" class="center fondoColor"  style="font-size: 9pt;"> <strong>DEDUCCIONES </strong> </td>
								</tr>	
								<tr> <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Agrup SAT </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Clave </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Concepto </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Imp. Gravado </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Imp. Exento </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Agrup SAT </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Clave </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Concepto </strong> </td>
									 <td width="10%" class="center fondoColor" style="font-size: 7pt;"> <strong>Importe </strong> </td>									 
								</tr>';

								$limitePer = count($rn['nomina12']['Percepciones']) - 3;
								$limiteDed = count($rn['nomina12']['Deducciones'])  - 2;
								for($i=0; $i < $limitePer; $i++)        
									{   
										$html = $html . '<tr> 
												<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Percepciones'][$i]['TipoPercepcion'].' </td>
												<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Percepciones'][$i]['Clave'].'</td>
												<td width="10%" class="center" style="font-size: 6pt;">'.$rn['nomina12']['Percepciones'][$i]['Concepto'].'</td>
												<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Percepciones'][$i]['ImporteGravado'].'</td>
												<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Percepciones'][$i]['ImporteExento'].'</td>
											  ';	
											  										  
										if( isset($rn['nomina12']['Deducciones'][$i]) )
										{
											$html = $html . '<td width="10%" class="center" style="font-size: 7pt;"> </td>
												  <td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Deducciones'][$i]['TipoDeduccion'].'</td>
												  <td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Deducciones'][$i]['Clave'].'</td>
												  <td width="10%" class="center" style="font-size: 6pt;">'.$rn['nomina12']['Deducciones'][$i]['Concepto'].'</td>
												  <td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Deducciones'][$i]['Importe'].'</td>												  
												 ';
										}
										else
										{
											$html = $html . '<td width="10%" class="center" style="font-size: 7pt;"> </td>
												  <td width="10%" class="center" style="font-size: 7pt;"> </td>
												  <td width="10%" class="center" style="font-size: 7pt;"> </td>
												  <td width="10%" class="center" style="font-size: 7pt;"> </td>
												  <td width="10%" class="center" style="font-size: 7pt;"> </td>
												  ';
										}
										$html = $html . '</tr>';										
                					}//for

								for($i=$limitePer; $i < $limiteDed; $i++)        
								{   
									$html = $html . '<tr> 
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 6pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Deducciones'][$i]['TipoDeduccion'].'</td>
											<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Deducciones'][$i]['Clave'].'</td>
											<td width="10%" class="center" style="font-size: 6pt;">'.$rn['nomina12']['Deducciones'][$i]['Concepto'].'</td>
											<td width="10%" class="center" style="font-size: 7pt;">'.$rn['nomina12']['Deducciones'][$i]['Importe'].'</td>
											</tr>';										
								}//for
								$html = $html . '<tr>  <td width="10%" colspan="10" class="center" style="font-size: 9pt;"> <br><br></td></tr>';
								$html = $html . '<tr> 
													<td width="10%" colspan="6" class="center fondoColor" style="font-size: 9pt;"><strong>OTROS PAGOS </strong> </td>
													<td width="10%" colspan="4" class="center" style="font-size: 7pt;"> </td>								
													</tr>';
								if(isset($rn['nomina12']['OtrosPagos']))
								foreach($rn['nomina12']['OtrosPagos'] as $o)									  
								{   
									$html = $html . '<tr> 
											<td width="10%" class="center" style="font-size: 7pt;">'.$o['TipoOtroPago'].' </td>
											<td width="10%" class="center" style="font-size: 7pt;">'.$o['Clave'].'</td>
											<td width="10%" class="center" style="font-size: 6pt;">'.$o['Concepto'].'</td>
											<td width="10%" class="center" style="font-size: 7pt;">'.$o['Importe'].'</td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											<td width="10%" class="center" style="font-size: 7pt;"> </td>
											</tr>';
								}//for
								$html = $html . '<tr> <td width="10%" colspan="10" class="center" style="font-size: 9pt;"> <br><br></td> </tr>';
								$html = $html . '
								<tr> <td width="40%" colspan="4" class="right fondoColor" valign="top" style="font-size: 9pt;"> Total Percepciones más Otros Pagos $ '.number_format($rn['factura']['subtotal'],2).'</td>
									 <td width="20%" colspan="2" class="right fondoColor" style="font-size: 9pt;"> </td>
									 <td width="40%" colspan="4" class="right fondoColor" style="font-size: 9pt;"> Subtotal $ '.number_format($rn['factura']['subtotal'],2).' <br>
									 																				Descuentos $ '.number_format($rn['nomina12']['Deducciones']['TotalOtrasDeducciones'],2).'<br>
																													Retenciones $ '.number_format($rn['nomina12']['Deducciones']['TotalImpuestosRetenidos'],2).'<br>
																													Total $ '.number_format($rn['factura']['total'] ,2).'<br>
																											<strong>Neto del recibo $ '.number_format($rn['factura']['total'] ,2).'</strong>
									 </td>
								</tr>';	
	$html = $html . '			<tr> <td width="100%" colspan="10" class="right" style="font-size: 7pt;">'.br().'Importe en letras '.$rn['PDF']['totalConLetras'].' </td>
								</tr>
							</tbody>
							</table>
							<br> 
						</div>'
					.br()
					.'	<div class="recuadroGrisClaro">
					'.br().' 
							<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>
								<tr> <td width="60%" class="center" style="font-size: 7pt;" valign="top">Se puso a mi disposición el archivo XML correspondiente y recibí de la empresa arriba mencionada la cantidad neta a que este documento se refiere estando conforme con las percepciones y deducciones que en él aparece especificado.</td> 
									 <td width="40%" class="center" style="font-size: 8pt;"><strong>Firma del Empleado</strong>  </td> 
								</tr>								
							</tbody>
							</table>
						</div>'
					.br()
					.'
					  <table cellspacing="0" align="center" cellpadding="0" width="100%">
					  <tbody> 
						  <tr><td width="70%" class="left" style="font-size: 7pt;">
							   <span style="font-size: 7pt; background: #FFF; color: #5B9BD5;">'.nbs().'NÚMERO DE SERIE DEL CERTIFICADO DEL SAT'.nbs().'</span>
					  '.br(1).'<span style="font-size: 7pt; ">'.$r['representacion_impresa_certificado_no'].'</span>
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
							  <td width="30%"><center>'.br(1).'<img src="'.$r['archivo_png'].'" width="180 px" height="180 px"> </center></td> 
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
								<td width="25%" class="center" style="font-size: 6pt;"> CFDI desde Sistemas Digitales Convivere </td>
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
