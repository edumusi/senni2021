<?php include("header_lg_admin.php"); ?>


<script>

var noti = '<?php echo $noti; ?>';
var tipoN = '<?php echo $tipoN; ?>';

  $(function() 
  {
    $( document ).tooltip();
	$( "#tabs" ).tabs();
  });
  
  $(document).ready(function()
  {	
	if($('#cg').text()=="SI")
		$('.esconder').hide();
				
  
	  if(Number($('#pf').text()) > 0)
		 {
		  $("#pf").addClass("positivo");
		  $("#pf").removeClass("negativo");
		 }
	  else  
		{
		  $("#pf").addClass("negativo");
		  $("#pf").removeClass("positivo");
		}			
			
	if(noti == "")
	{
		$("#eta").removeClass("resaltar");
		$("#entrega").removeClass("resaltar");
	}
	else
	{
		if(tipoN == "eta")
			$("#eta").next().addClass("resaltar");
		else
			$("#entrega").next().addClass("resaltar");	
		
		if($('#cg').text()=="NO")
			$("#cg").parent().parent().addClass("resaltar");
	}
	
  });//document ready

</script>
         

<div id="tabs">
  <ul>
	<li><a href="#tabE">Encabezado</a></li>
	<li><a href="#tabP">Producto</a></li>
	<li><a href="#tabF">Flete</a></li>    
	<li><a href="#tabD">Aduana y Adjuntos</a></li>	
	<li><a href="#tabT">Transporte</a></li>
	<li><a href="#tabR">Rastreo</a></li>
	<li><a href="#tabG">Ganancia</a></li>    
  </ul>
  
<!--FORMULARIO ENCABEZADO -->          
  <div id="tabE">
<?php 
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);
//RENGLON 1 								
			$celda 	  = array('data' => $pedido["encabezado"][0]['rfc'].'-'.$pedido["encabezado"][0]['razon_social']
						     .br(2),'colspan'=>4,'class'=>"labelRFC2");
			$celdaDer = array('data' => 'Cliente: '.br(2),'colspan'=>2,'class'=>"labelRFC");
			
			$this->table->add_row(array($celdaDer,$celda));
			$celda 	  = array('data' => $ligaCoti.br(2),'colspan'=>4,'class'=>"labelRFC2");
			$celdaDer = array('data' => 'Datos de la: '.br(2),'colspan'=>2,'class'=>"labelRFC");
			
			$this->table->add_row(array($celdaDer,$celda));
			$celda 	  = array('data' => $pedido["encabezado"][0]['moneda']
						     .br(2),'colspan'=>4,'class'=>"labelRFC2");
			$celdaDer = array('data' => 'Tipo de Moneda: '.br(2),'colspan'=>2,'class'=>"labelRFC");
			
			$this->table->add_row(array($celdaDer,$celda));								  									  
//RENGLON 2			
			$celda1    = array('data' => $pedido["encabezado"][0]['carrier'].br(2),
							   'colspan'=>2,'class'=>"labelCen3");
			$celdaDer1 = array('data' => 'Carrier: '.br(2),'class'=>"labelDer2");									
			$celda2    = array('data' => $pedido["encabezado"][0]['shipper'].br(2),
							   'colspan'=>2,'class'=>"labelCen3");
			$celdaDer2 = array('data' => 'Embarcador: '.br(2),'class'=>"labelDer2");
			
			$this->table->add_row(array($celdaDer1,
                                                    $celda1,
                                                    $celdaDer2,
                                                    $celda2)
                                            );
//RENGLON 3  opcion_catalogo,p.carta_no,p.monto_carta_no                			
			$celdaDer1 	 = array('data' => 'Carta en Garant&iacute;a : '.br(2),'class'=>"labelDer2");
			$celdaDer2 	 = array('data' => 'Tipo Garant&iacute;a: '.br(2),'class'=>"labelDer2 esconder");
			$celda2 	 = array('data' => ''.$pedido["encabezado"][0]['carta_no'].br(2),'class'=>"esconder");
			$celdaDer3 	 = array('data' => 'Monto Garant&iacute;a: '.br(2),'class'=>"labelDer2 esconder");
			$celda3 	 = array('data' => ''.$pedido["encabezado"][0]['monto_carta_no'].br(2),'class'=>"esconder");
			
			$this->table->add_row(array($celdaDer1,
										'<span id="cg">'.$pedido["encabezado"][0]['cg'].'</span>'.br(2),
										$celdaDer2,
										$celda2,														
										$celdaDer3,
										$celda3)
								  );              				   

			$celda1    = array('data' => $pedido["encabezado"][0]['num_mbl'].br(2),'colspan'=>2);
			$celda2    = array('data' => $pedido["encabezado"][0]['num_hbl'].br(2),'colspan'=>2);
			$celdaDer1 = array('data' => 'Gu&iacute;a Master: '.br(2),'class'=>"labelDer2");
			$celdaDer2 = array('data' => 'Gu&iacute;a House: '.br(2),'class'=>"labelDer2");
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );                   			

			$celda1    = array('data' => $pedido["encabezado"][0]['num_booking'].br(2),'colspan'=>2);
			$celda2    = array('data' => $pedido["encabezado"][0]['vessel_voyage'].br(2),'colspan'=>2);
			$celdaDer1 = array('data' => 'N. Booking: '.br(2),'class'=>"labelDer2");
			$celdaDer2 = array('data' => 'Vessel Voyage: '.br(2),'class'=>"labelDer2");
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );                   			
								  
//RENGLON 8									  			   
			$celdaDer1 = array('data' => 'Instrucciones Env&iacute;o:'.br(3),'class'=>"labelDer2");
			$celda1    = array('data' => $pedido["encabezado"][0]['ins_envio'].br(3),'colspan'=>2);			
			$celdaDer2 = array('data' => 'Instrucciones Booking:'.br(3),'class'=>"labelDer2");
			$celda2    = array('data' => $pedido["encabezado"][0]['ins_booking'].br(3),'colspan'=>2);
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );

//RENGLON 9					              			
			$celda1    = array('data' => $pedido["encabezado"][0]['corte_documentar'].br(2),'colspan'=>2);					 	   				   
			$celda2    = array('data' => $pedido["encabezado"][0]['despacho_origen'].br(2),'colspan'=>2);					
			$celdaDer1 = array('data' => 'Corte Documental: '.br(2),'class'=>"labelDer2");
			$celdaDer2 = array('data' => 'Despacho Origen: '.br(2),'class'=>"labelDer2");
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );
                        $celda1    = array('data' => $pedido["encabezado"][0]['te_desc'].br(2),'colspan'=>2);					
			$celdaDer1 = array('data' => 'Tipo de Embarque: '.br(2),'class'=>"labelDer2");			
			$this->table->add_row(array($celdaDer1,$celda1));
								  
			echo $this->table->generate(); 
?> 
  </div>
<!--FORMULARIO PRODUCTO -->                    
  <div id="tabP">
<?php 
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" id="productos" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);
											
			$this->table->add_row(array(array('data' => 'Producto' ,'class'=>"labelCenProd"),
										array('data' => 'Commodity','class'=>"labelCenProd"),
										array('data' => 'Peso'     ,'class'=>"labelCenProd"),
										array('data' => 'Volumen'  ,'class'=>"labelCenProd")
										));
			$image_properties = array(
									  'src' => base_url().'images/box.png',
									  'width' => '13',
									  'height' => '13'
									);						
			if ($pedido["producto"] == FALSE)
    			$this->table->add_row(array('data' => '<br>No hay registros','align'=>"center",'colspan'=>3));
			else
				foreach($pedido["producto"] as $p)				
					$this->table->add_row(array(  img($image_properties).nbs(2).
						  						$p["nombre"],
												$p["commodity"],
												$p["peso"],												
												$p["volumen"]
												));																						
			echo $this->table->generate(); 
			echo br(3);
?>
  </div>
<!--FORMULARIO DESPECHO ADUANAL -->                              
  <div id="tabD">
<?php 
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);												
								
			$this->table->add_row(array(array('data' => 'Agencia Aduanal' ,'class'=>"labelCenDA"),
										array('data' => 'Tiempo Despacho','class'=>"labelCenDA")
										));
			$this->table->add_row(array(array('data' => $pedido["aduana"][0]['agencia'] ,'class'=>"labelCenDA2"),
										array('data' => $pedido["aduana"][0]['tiempo'],'class'=>"labelCenDA2")
										));										
										
			echo $this->table->generate(); 
						echo br(5);
			$this->table->clear();
echo '<fieldset>';			
			$celda = array('data' => 'Archivos adjuntados al Embarque'.br(2),
						   'class'=>"labelCenAzul",'colspan'=>2);
			$this->table->add_row(array($celda));
			echo $this->table->generate(); 
			echo br(1);
			
			if(    $pedido["encabezado"][0]['adjunto_mbl'] != NULL 
				&& $pedido["encabezado"][0]['adjunto_mbl'] != "" 
				&& $pedido["encabezado"][0]['adjunto_mbl'] != "0")
				{
					$celdaAdjuntos1 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									  '/'.$pedido["encabezado"][0]['adjunto_mbl'].'" target="_blank">
									   <img title="Ver Archivo MBL" src="'.base_url().'images/fileIcon.png"></a>';
					$ca1 ="MBL/MAWB";
				}
		
			if(   $pedido["encabezado"][0]['adjunto_hbl'] != NULL
			   && $pedido["encabezado"][0]['adjunto_hbl'] != "" 
			   && $pedido["encabezado"][0]['adjunto_hbl'] != "0")
			   {
					$celdaAdjuntos2 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									  '/'.$pedido["encabezado"][0]['adjunto_hbl'].'" target="_blank">
									   <img title="Ver Archivo HBL" src="'.base_url().'images/fileIcon.png"></a>';							
					$ca2 ="HBL/HAWB";
				}
		
			if(    $pedido["encabezado"][0]['adjunto_facturaP'] != NULL
				&& $pedido["encabezado"][0]['adjunto_facturaP'] != "" 
				&& $pedido["encabezado"][0]['adjunto_facturaP'] != "0")
				{
					$celdaAdjuntos3 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									   '/'.$pedido["encabezado"][0]['adjunto_facturaP'].'" target="_blank">
									   <img title="Ver Factura del Producto" 
									   		src="'.base_url().'images/fileIcon.png"></a>';
					$ca3 ="Factura Producto";
				}
						   
			if(   $pedido["encabezado"][0]['adjunto_le'] != NULL
			   && $pedido["encabezado"][0]['adjunto_le'] != "" 
			   && $pedido["encabezado"][0]['adjunto_le'] != "0")
			   {
					$celdaAdjuntos4 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									  '/'.$pedido["encabezado"][0]['adjunto_le'].'" target="_blank">
									   <img title="Ver Lista de Empaque" 
									   		src="'.base_url().'images/fileIcon.png"></a>';					
					$ca4 ="Lista de Empaque";
				}	
		
			if(   $pedido["encabezado"][0]['adjunto_poliza'] != NULL
			   && $pedido["encabezado"][0]['adjunto_poliza'] != "" 
			   && $pedido["encabezado"][0]['adjunto_poliza'] != "0")
			   {
					$celdaAdjuntos5 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									 '/'.$pedido["encabezado"][0]['adjunto_poliza'].'" target="_blank">
										   <img title="Ver Poliza del Seguro" 
										   		src="'.base_url().'images/fileIcon.png"></a>';
					$ca5 ="Poliza de Seguro";
			   }					
							   
			if(   $pedido["encabezado"][0]['adjunto_factura'] != NULL
			   && $pedido["encabezado"][0]['adjunto_factura'] != "" 
			   && $pedido["encabezado"][0]['adjunto_factura'] != "0")
			   {
					$celdaAdjuntos6 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									   '/'.$pedido["encabezado"][0]['adjunto_factura'].'" target="_blank">
									   <img title="Ver Factura SENNI" 
									   		src="'.base_url().'images/fileIcon.png"></a>';						
					$ca6 ="Factura SENNI";
				}
			if(   $pedido["encabezado"][0]['adjunto_cartaporte'] != NULL
			   && $pedido["encabezado"][0]['adjunto_cartaporte'] != "" 
			   && $pedido["encabezado"][0]['adjunto_cartaporte'] != "0")
			   {
					$celdaAdjuntos7 = '<a href="'.base_url().'gestion/download/'.$pedido["encabezado"][0]['id_pedido'].
									   '/'.$pedido["encabezado"][0]['adjunto_cartaporte'].'" target="_blank">
									   <img title="Ver Carta Porte" 
									   		src="'.base_url().'images/fileIcon.png"></a>';						
					$ca7 ="Carta Porte";
				}

echo '<table cellspacing="0" cellpadding="0" border="0" id="filesAd" width="100%">
	 <tr align="center">
	 <td width="14.30%"><span class="cMBL">'.$ca1.'</span></td>
	 <td width="14.30%"><span class="cHBL">'.$ca2.'</span></td>
	 <td width="14.30%"><span class="cFP">'.$ca3.'</span></td>
	 <td width="14.30%"><span class="cLE">'.$ca4.'</span></td>
	 <td width="14.30%"><span class="cCP">'.$ca7.'</span></td>
	 <td width="14.30%"><span class="cPS">'.$ca5.'</span></td>
	 <td width="14.30%"><span class="cFS">'.$ca6.'</span></td>
	 </tr>
	 <tr align="center">
	 <td><span id="celdaMBL" class="cMBL">'.$celdaAdjuntos1.'</span></td>
	 <td><span id="celdaHBL" class="cHBL">'.$celdaAdjuntos2.'</span></td>
	 <td><span id="celdaFP" class="cFP">'.$celdaAdjuntos3.'</span></td>
	 <td><span id="celdaLE" class="cLE">'.$celdaAdjuntos4.'</span></td>
	 <td><span id="celdaCP" class="cCP">'.$celdaAdjuntos7.'</span></td>
	 <td><span id="celdaPS" class="cPS">'.$celdaAdjuntos5.'</span></td>
	 <td><span id="celdaFS" class="cFS">'.$celdaAdjuntos6.'</span></td></tr>
	 </table>';	
echo '</fieldset>';
?>
  </div>
<!--FORMULARIO TRANSPORTE -->                                                  
  <div id="tabT">
<?php 
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);
//RENGLON 1																			
			$costo_t = $pedido["transporte"][0]['costo'].br(2);	
			$venta_t = $pedido["transporte"][0]['venta'].br(2);
			$celdaDer1 = array('data' => 'Costo: '.br(2),'class'=>"labelCenT");
			$celdaDer2 = array('data' => 'Venta: '.br(2),'class'=>"labelCenT");					
			$this->table->add_row(array($celdaDer1,
										'$'.$costo_t,														
										$celdaDer2,
										'$'.$venta_t)
								  );
//RENGLON 2											
			$celda1 = array('data' =>$pedido["transporte"][0]['salida_puerto'].br(2),'class'=>"labelCenT2");	
			$celda2 = array('data' =>''.br(2),'class'=>"labelCenT2");
			$celdaDer1 = array('data' => 'Salida del (aero)puerto: '.br(2),'class'=>"labelCenT");
			$celdaDer2 = array('data' => ''.br(2),'class'=>"labelCenT");
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );
//RENGLON 3														
			$celda1 = array('data' =>$pedido["transporte"][0]['maniobras'].br(2),'class'=>"labelCenT2");	
			$celda2 = array('data' =>$pedido["transporte"][0]['regreso_v'].br(2),'class'=>"labelCenT2");
			$celdaDer1 = array('data' => 'Maniobras: '.br(2),'class'=>"labelCenT");
			$celdaDer2 = array('data' => 'Regreso Vacio: '.br(2),'class'=>"labelCenT");
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );
//RENGLON 4																													
			$celda1 = array('data' =>$pedido["transporte"][0]['contacto_almacen'].br(2),'class'=>"labelCenT2");	
			$celda2 = array('data' =>$pedido["transporte"][0]['entrega'].br(2),'class'=>"labelCenT2");
			$celdaDer1 = array('data'=>'Contacto en Almac&eacute;n: '.br(2),'class'=>"labelCenT");
			$celdaDer2 = array('data'=>'Fecha de entrega: '.br(2),'class'=>"labelCenT ",'id'=>"entrega");
			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );
//SEGURO																  
			echo $this->table->generate(); 
			echo br(4);
			
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);			

			$celda = array('data' => 'Seguro del Embarque'.br(3),
						   'class'=>"labelCenAzul",'colspan'=>4);
			$this->table->add_row(array($celda));								
								
			$this->table->add_row(array(array('data' => 'Costo'    ,'class'=>"labelCenSeg"),
										array('data' => 'Venta'	   ,'class'=>"labelCenSeg"),
										array('data' => 'Cobertura','class'=>"labelCenSeg"),
										array('data' => 'Poliza'   ,'class'=>"labelCenSeg")
										));
			$this->table->add_row(array('$'.$pedido["seguro"][0]['costo'],
										'$'.$pedido["seguro"][0]['venta'],
										$pedido["seguro"][0]['cobertura'],
										$celdaAdjuntos5
										));
										
			echo '<fieldset>';
			echo $this->table->generate(); 
			echo '</fieldset>';  
			echo br(2);
?>	   
  </div>
<!--FORMULARIO FLETE -->                                                  
  <div id="tabF">
<?php 
		$this->table->clear();
		$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="80%">' );
		$this->table->set_template($tmpl);

		$celda = array('data' => $pedido["flete"][0]['veri_o'].br(2),'colspan'=>3);
		$celdaDer = array('data' => 'Verificaci&oacute;n en Origen: '.br(2),'class'=>"labelCenT");
		$this->table->add_row(array($celdaDer,$celda));			
		echo $this->table->generate();
		
		for ($s = 0; $s <= 2; $s++) // los tres tipos de servicios 664,65,66
		{  
			$pedido_terminos  = $pedido['servicios'][$s]['pedido_terminos'];
			$pedido_conceptos = $pedido['servicios'][$s]['pedido_conceptos'];
			$pedido_cargos	  = $pedido['servicios'][$s]['pedido_cargos'];
			$servicio		  = $pedido['servicios'][$s]['servicio'];
			$myCargos 	 	  = "";
			$myTerminos  	  = "";
			$myConceptos 	  = "";

			if ($pedido_terminos != NULL | $pedido_conceptos != NULL | $pedido_cargos != NULL)
			{			

			foreach($pedido_cargos as $detalle)
			{
				$venta_f = $venta_f + $detalle['importe'];
				$costo_f = $costo_f + $detalle['costo'];
				$myCargos = $myCargos." <td width='30%' align='left'>".$detalle['cargo']."</td>".
				"   <td width='30%' align='center'>$ ".$detalle['importe']."</td>".
				"   <td width='30%' align='center'>$ ".$detalle['costo']."</td>".
				"   <td width='10%'></td></tr>";
			}
			
			foreach($pedido_conceptos as $detalle)			
				$myConceptos = $myConceptos." <tr>".
				"  <td width='45%' align='center'>".$detalle['concepto']."</td>".
				"  <td width='45%' align='center'>".$detalle['descripcion']."</td>".
				"  <td width='10%'></td></tr>";		
			
			$x = -1;
			foreach($pedido_terminos as $detalle)
			{
				$x = $x+1;
				if($x == 0)
					$desc = $detalle['descINCO'];
				else
					$desc = $detalle['descripcion'];
						
				$myTerminos = $myTerminos." <tr>".
				" <td width='30%' align='left'><img src='".base_url()."images/check.png'> ".
				" ".$detalle['termino']."</td> ".
				"   <td width='30%' align='center'>".$desc."</td> ".
				"   <td width='10%'></td></tr> ";
			}
			
			
			$etd = "";
			$eta = "";			
			foreach($pedido['flete'] as $f)
				if($f['tipo_servicio'] == $ts)
				{
					$eta = $f['eta'];
					$etd = $f['etd'];	
				}

			$rowFechas = "<br><br><br>".
			  "ETD:<br>".$etd."<br><br>".
			  "ETA:<br>".$eta;

			$myTable = "<p></p>".
			"<table cellspacing='0' align='center' cellpadding='0' width='100%'>".
			"<tr><td width='80%' align='center'>".
			"<table id='terminos".$ts."' cellspacing='0' align='center' cellpadding='0' width='100%'>".
			"<tr><td width='100%' align='center' colspan='4' style='font-weight:bold; background-color:#5B9BD5'>FLETE ".$servicio."</td></tr>".
			"<tr><td width='75%' colspan='3' class='CotiTextCenterBold'>TERMINOS</td>".
			"<td width='25%' rowspan='".(count($pedido_terminos)+1)."' valign='middle' align='center'> ".
			$rowFechas."</td></tr>".
			$myTerminos .
			"</table><p></p>".
			"<table id='conceptos".$ts."' cellspacing='0' align='center' cellpadding='0' width='100%'>".
			"<tr ><td width='90%' colspan='2' class='CotiTextCenterBoldAzulCl'>CONCEPTOS</td>".
			"<td width='10%' align='center'> </td></tr>".
			$myConceptos .
			"</table></br><br>".
			"<table id='cargos".$ts."' cellspacing='0' align='center' cellpadding='0' width='100%'>".
			" <tr>".
			" <td width='30%' class='CotiTextCenterBoldAzulCl'>CONCEPTO</td>".
			" <td width='30%' class='CotiTextCenterBoldAzulCl'>VENTA EN USD</td>".
			" <td width='30%' class='CotiTextCenterBoldAzulCl'>COSTO EN USD</td>".
			" <td width='10%' align='center'> </td></tr>".
			$myCargos .
			"</table>".
			"<br><br>".								  
			"</td></tr></table>";

			echo $myTable;
			}//if
	  	}//for
?>
  </div>
<!--FORMULARIO RASTREO -->
  <div id="tabR">
<?php 
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" id="track" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);
			
			$celdaDer = array('data' => 'Status General del Embarque:'.
									$pedido["encabezado"][0]['status']
									.br(3),'class'=>"labelCenAzul",'colspan'=>4);
			$this->table->add_row(array($celdaDer));

			$this->table->add_row(array(array('data' => 'Status' ,'class'=>"labelCenProd"),
										array('data' => 'Movimiento del Embarque','class'=>"labelCenProd"),
										array('data' => 'Observaciones'     ,'class'=>"labelCenProd"),
										array('data' => 'Fecha y hora del movimiento'  ,'class'=>"labelCenProd")
										));
			$image_properties = array(
								  'src' => base_url().'images/road.png',
								  'width' => '13',
								  'height' => '13'
								);								
			if ($pedido["rastreo"] == FALSE)
    			$this->table->add_row(array('data' => '<br>No hay registros','align'=>"center",'colspan'=>4));
			else
				foreach($pedido["rastreo"] as $r)				
					$this->table->add_row(array(img($image_properties).nbs(2).
												$r["status"],
												$r["descripcion"],
												$r["observaciones"],
												$r["fecha_hora"]
												));			
			echo $this->table->generate(); 
			echo br(3)
?>
 </div>  
<!--FORMULARIO GANACIA -->
 <div id="tabG">          
<?php 
			echo br(6);
			$this->table->clear();
			$tmpl = array('table_open'  => '<table cellspacing="0" border="0" cellpadding="0" width="100%">' );
			$this->table->set_template($tmpl);
//RENGLON 1					

			$costo_tot = ($pedido["seguro"][0]['costo']
						   +$costo_t
						   +$costo_f
						  );
			$venta_tot = ($pedido["seguro"][0]['venta']
						   +$venta_t
						   +$venta_f
						  );	
			
			$celdaDer1 = array('data' => 'Costo Total del Embarque: ','class'=>"labelCenT");
			$celdaDer2 = array('data' => 'Venta Total del Embarque: ','class'=>"labelCenT");
			$celda1 = array('data' => '$'.$costo_tot,'class'=>"labelCenT2");
			$celda2 = array('data' => '$'.$venta_tot,'class'=>"labelCenT2");

			$this->table->add_row(array($celdaDer1,
										$celda1,														
										$celdaDer2,
										$celda2)
								  );					
			$this->table->add_row(array('<br><br>','','',''));
//RENGLON 2			
													
			$profit = ($venta_tot - $costo_tot)-$pedido["encabezado"][0]['profit_origen'];
			$celdaDer1 = array('data' => 'Profit: ','class'=>"labelDer2");
			$celdaDer2 = array('data' => 'Profit Origen: ','class'=>"labelDer2");

			$this->table->add_row(array($celdaDer1,
										'$<span id="pf">'.$profit.'</span>',														
										$celdaDer2,
										'$'.$pedido["encabezado"][0]['profit_origen'])
								  );

			echo '<fieldset>';
			echo $this->table->generate(); 
			echo '</fieldset>';
			echo br(6)
?>             
  </div> <!-- div  FORMULARIO GANACIA--> 
</div>  <!-- div  TABS--> 	
																	                                 
<?php include("footer_admin.php"); ?>  