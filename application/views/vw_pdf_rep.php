<?php
     $html = "<html>";
     $meta = array(  array('name' => 'author', 'content' => NOMBRE_CORTO),
                     array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
                  );
      
     $html = $html ."<head>";
     $html = $html . meta($meta);
     $html = $html . '<link rel="STYLESHEET" href="css/factura_pdf.css" type="text/css">';     
     $html = $html . "</head>"; 	 
	
   $decimalTotal = null;
   $wholeTotal   = null;
   list($wholeTotal, $decimalTotal) = explode('.', $p['factura']['total']);

   $html = $html .'<body marginwidth="0" marginheight="0">'
                    .'<div class="header">'
                    .  '<div style="width: 100%;">
                          <table align="center" style="width: 100%;">
                          <tbody> 
						  <tr>
						    <td width="25%" class="left" style="font-size: 9pt;"> </td> 							
							<td width="40%" class="center" style="font-size: 9pt;">
								<div class="recuadroGris">
									<br><strong>RECIBO ELECTRÓNICO DE PAGO - REP</strong><br><br>
								</div>
							</td>							
							<td width="35%" class="center"> <img src="images/LogoSenni.jpg" width="200 px" height="80 px"> </td>
                          </tr>                          
                          </tbody>
                          </table>
						</div>'
					.'</div>					
					'.br(1)	
					.'<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
						<tbody>
							<tr> <td width="30%" class="left" style="font-size: 8pt;">
									<div class="recuadroGrisClaro">'
										.nbs(2).'<strong>EMISOR</strong>'
										.br()
										.nbs(2).'<strong>'.$p['emisor']['nombre_fiscal'].'</strong>'.br()
										.nbs(2).'<strong>RFC:</strong>'.$p['emisor']['rfc'].br()				  
										.nbs(2).$p['emisor']['cp_fiscal'].br()
										.nbs(2).$p['emisor']['correo_fiscal'].br() 
										.nbs(2).$p['factura']['RegimenFiscal'].' '.$p['factPDF']['RegimenFiscalDesc']['Descripcion'].'
									</div>
								 </td> 
								 <td width="2%" class="left" style="font-size: 9pt;"> </td> 
								 <td width="30%" class="left" style="font-size: 8pt;">
									<div class="recuadroGrisClaro">'
										.nbs(2).'<strong>ORDENANTE PAGO</strong>'
										.br()
										.nbs(2).'<strong>'.$p['receptor']['nombre'].'</strong>'.br()
										.nbs(2).'<strong>RFC:</strong>'.$p['receptor']['rfc'].br()				  
										.nbs(2).$p['factPDF']['cpReceptor'].br()
										.nbs(2).$p['factPDF']['emailReceptor'].'
									</div>
								 </td> 
								 <td width="2%" class="left" style="font-size: 9pt;"> </td> 
								 <td width="36%" class="left" style="font-size: 8pt;">
									<div class="recuadroGrisClaro">'
										.nbs(2).'<strong>DOCUMENTO </strong>'
										.br()
										.nbs(2).'<strong>FOLIO: </strong>'.nbs().$p['factura']['folio'].br() 
										.nbs(2).'<strong>LUGAR DE EXPEDICIÓN: </strong>'.nbs().$p['factura']['LugarExpedicion'].br() 
										.nbs(2).'<strong>FECHA DE EMISIÓN: </strong> '.nbs().$p['factura']['fecha_expedicion'].br() 										
										.nbs(2).'<strong>TIPO DE COMPROBANTE: </strong>'.nbs().$p['factura']['tipocomprobante'].' '.$p['factPDF']['tipocomprobanteDesc'].br()
										.nbs(2).'<strong>FOLIO FISCAL: </strong> '.nbs().$r['uuid'].br().'
									</div>
								</td>
							</tr>							
						</tbody>
						</table>						
					'.br()
					.'	<div class="recuadroGrisClaro">
					'.br().'
						<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>								
								<tr> <td width="100%" colspan="6" class="center fondoColor" style="font-size: 9pt;"> <strong>INFORMACIÓN DEL PAGO</strong> </td> </tr>
								<tr> <td width="10%" class="right" style="font-size: 7pt;"> <strong>FECHA DE PAGO</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().$p['pagos10']['Pagos'][0]['FechaPago'].' </td>
									 <td width="10%" class="right" style="font-size: 7pt;"> <strong>FORMA DE PAGO</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().$p['rep']['forma_pago_rep'].' - '.$p['rep']['forma_pago_rep_desc'].' </td>
									 <td width="10%" class="right" style="font-size: 7pt;"> <strong>MONTO</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().$p['pagos10']['Pagos'][0]['Monto'].' </td>
								</tr>
								<tr> <td width="100%" colspan="6" class="center fondoColor" style="font-size: 9pt;"> <br> </td> </tr>
								<tr> <td width="10%" class="right" style="font-size: 7pt;"> <strong>'.($p['pagos10']['Pagos'][0]['NumOperacion']==""?"":'NO. OPERACIÓN').'</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().($p['pagos10']['Pagos'][0]['NumOperacion']==""?"":$p['pagos10']['Pagos'][0]['NumOperacion']).' </td>
									 <td width="10%" class="right" style="font-size: 7pt;"> <strong>MONEDA</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().$p['pagos10']['Pagos'][0]['MonedaP'].' </td>
									 <td width="10%" class="right" style="font-size: 7pt;"> <strong>T.C.</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().$p['rep']['tc_rep'].' </td>
								</tr>
								<tr> <td width="100%" colspan="6" class="center fondoColor" style="font-size: 9pt;"> <br> </td> </tr>
								<tr> <td width="10%" class="right" style="font-size: 7pt;"> <strong>'.($p['pagos10']['Pagos'][0]['RfcEmisorCtaOrd']==""?"":'Banco Ordenante').'</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().($p['pagos10']['Pagos'][0]['RfcEmisorCtaOrd']==""?"":$p['pagos10']['Pagos'][0]['RfcEmisorCtaOrd']).' </td>
									 <td width="10%" class="right" style="font-size: 7pt;"> <strong>'.($p['pagos10']['Pagos'][0]['CtaOrdenante']==""?"":'Cuenta Bancaria Ordenante').'</strong> </td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().($p['pagos10']['Pagos'][0]['CtaOrdenante']==""?"":$p['pagos10']['Pagos'][0]['CtaOrdenante']).' </td>
									 <td width="10%" class="right" style="font-size: 7pt;"> <strong>'.($p['pagos10']['Pagos'][0]['RfcEmisorCtaBen']==""?"":'Banco Beneficiario').'</strong> <br> <strong>'.($p['pagos10']['Pagos'][0]['RfcEmisorCtaBen']==""?"":'Cuenta Beneficiaria').'</strong></td>
									 <td width="23.3%" class="left" style="font-size: 7pt;"> '.nbs().($p['pagos10']['Pagos'][0]['RfcEmisorCtaBen']==""?"":$p['pagos10']['Pagos'][0]['RfcEmisorCtaBen']).' <br> '.($p['pagos10']['Pagos'][0]['CtaBeneficiario']==""?"":$p['pagos10']['Pagos'][0]['CtaBeneficiario']).'</td>
								</tr>
							</tbody>
						</table>
						'.br(2)	.'
						<table cellspacing="0" align="center" cellpadding="0" style="width: 100%;">
							<tbody>								
								<tr> <td width="100%" colspan="10" class="center fondoColor" style="font-size: 9pt;"> <strong>DOCUMENTO RELACIONADO</strong> </td> </tr>
								<tr> <td width="10%" class="center" style="font-size: 7pt;"> <strong>ID DEL DOCUMENTO</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>SERIE</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>FOLIO</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>MONEDA</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>T.C.</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>METODO DE PAGO</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>NO. PARCIALIDAD</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>IMPORTE SALDO ANTERIOR</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>IMPORTE PAGADO</strong> </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> <strong>IMPORTE SALDO INSOLUTO</strong> </td>
								</tr>
								<tr> <td width="10%" class="center" style="font-size: 7pt;"> '.$p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["IdDocumento"].' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.$p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["Serie"].' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.$p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["Folio"].' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.$p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["MonedaDR"].' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.($p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["MonedaDR"]=="USD" ? $p['rep']['facturaTipoCambio'] : "").' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.$p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["MetodoDePagoDR"].' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.$p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["NumParcialidad"].' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.number_format($p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoAnt"],2).' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.number_format($p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpPagado"],2).' </td>
									 <td width="10%" class="center" style="font-size: 7pt;"> '.number_format($p["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoInsoluto"],2).' </td>
								</tr>								
							</tbody>
						</table>
						</div>'					
					.br(1)	
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
							  <td width="30%"><center>'.br(1).'<img src="'.$r['archivo_png'].'" width="212 px" height="212 px"> </center></td> 
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
