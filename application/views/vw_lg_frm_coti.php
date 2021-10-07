<?php include("header_lg_admin.php"); ?>


<script>
  var href	 = '<?php echo base_url(); ?>';
  var accion = '<?php echo $accion; ?>';

  $(function(){$( document ).tooltip();});
  
  $(document).ready(function()
  { 
  	$("#admin").change(function(){traDetalleAdminAX($(this).val(),href)});
	$('.nuevoServicio').addClass('pointer');
	$('.nuevoServicio').click(function() { agregaServicioCoti(href) });
	$('.esconder').hide();
	
	$('#tipos_servicio option').each(function() {//eliminiar opciones para el tip de servicio porque solo aplican para los proveedores
    if ( $(this).val() > 66 )
        $(this).remove();
    
	});
	
  $("input[name=moneda]").click(function () {	 
			if($(this).val() == "MXN"){
				$(this).attr('checked',true);
				$("input[value=USD]").attr('checked',false);
                                $("#lblTipoCambio").hide();
                                $("#tipo_cambio").val(1);}
			else{
				$(this).attr('checked',true);
				$("input[value=MXN]").attr('checked',false);
                                $("#lblTipoCambio").show();
                                $("#tipo_cambio").val('');}
                            
			$("#monedaSpan").html($(this).val());
			});

	if (accion == "A")
	{
		var index;
		var servicio 	= ["64","65","66"];
		var optionsINCO = $("#terminoINCO").html();
				  			  		
		for (index=0; index < servicio.length; index++)
		{	
			habilitaBotonAgregar(servicio[index],href);
			habilitaBotonEliminar(servicio[index],'btnDelete');
			habilitaBotonEliminar(servicio[index],'btnDeleteConcepto');
			habilitaBotonEliminar(servicio[index],'btnDeleteCargo');
			habilitaBotonEliminar(servicio[index],'btnDeleteTermino');
			habilitaBotonEliminar(servicio[index],'btnDeleteNota');
			
			var valor = $("#"+servicio[index]+"termino_dato0").val();
			$("#"+servicio[index]+"termino_dato0").html(optionsINCO);
			$("#"+servicio[index]+"termino_dato0").find('option:selected').removeAttr("selected");
			$("#"+servicio[index]+"termino_dato0").val(valor);
		}
			
		$('.boton_confirm').addClass('pointer');	
		$('.boton_confirm').click(function() {
			var r = confirm("¿Borrar Cotización en PDF?");
			if (r == true)
				borraCotizacionAX(href,$(this).attr('id'));
			});		
	}
	
  });

</script>

               
<?php  
	echo form_open(base_url().'cotizador/guardar/', array('class' => 'sky-form', 'id' => 'coti'));
        echo '<fieldset>'
        . '     <header>Prospecto</header><br>';
        
	echo form_input(array('name' => 'id_coti' ,'type' => 'hidden',  'id' => 'id_coti' ,'value' => $id_coti));
	echo form_input(array('name' => 'coti_pdf','type'  => 'hidden', 'id' => 'coti_pdf','value' => null));
	echo form_input(array('name' => 'accion' , 'type'  => 'hidden', 'id' => 'accion'  ,'value' => $accion));						  
	
        echo '<div class="row">                          
                <section class="col col-4">&nbsp;</section>
                <section class="col col-4"><label class="subtitulo">Plantilla para realizar una Cotizaci&oacute;n <img border=0 src="'.base_url().'images/logoPDF.png" width="30px" height="30px" /></label></section>
                <section class="col col-4">&nbsp;</section>
              </div>
              <div class="row">
                 <section class="col col-4"><label class="subtitulo">Datos de Contacto del Prospecto</label></section>
                 <section class="col col-8">&nbsp;</section>
              </div>';
        echo '<div class="row">
                <section class="col col-6">
                      <label class="label">Correo Principal:</label>
                      <label class="input"><i class="icon-append fa fa-envelope"></i>'.
                      form_input(array('class' 	=> 'validate[required,custom[email]] text-input',
                                        'name' 		=> 'prosp_correo', 
                                        'id' 		=> 'prosp_correo',
                                        'size' 	 	=> '20',
                                        'value' 	=> ($accion == "N"?NULL:$cotizacion['coti'][0]['prosp_correo']),
                                        'maxlength' => '30')).'
                       <b class="tooltip tooltip-bottom-right">Correo de contacto principal, dato usado para ingresar al sistema para cuando sea cliente</b>
                      </label>
                  </section>
                  <section class="col col-6">
                      <label class="label">Tel&eacute;fono:</label>
                      <label class="input"><i class="icon-append fa fa-phone"></i>'.
                      form_input(array('class' 	=> 'validate[required,custom[phone]] text-input', 
						'name' 		=> 'prosp_tel', 
						'id' 		=> 'prosp_tel',
						'value' 	=> ($accion == "N"?NULL:$cotizacion['coti'][0]['prosp_tel']),
						'size'  	=> '15',
						'maxlength' => '30')).'
                       <b class="tooltip tooltip-bottom-right">Tel&eacute;fono de contacto</b>
                      </label>
                  </section>
                 </div>';
        
         echo '<div class="row">                          
                <section class="col col-9"> </section>
                <section class="col col-3"> <label class="label">'.$fechaCoti.' </label> </section>
              </div>';         	
	if($accion == "N")
	   {	$attributes = array('class' 	  => 'validate[required,custom[onlyLetterNumber]] text-input',
                                    'name' 		  => 'prosp_nombre', 
                                    'id'		  => 'prosp_nombre',
                                    'placeholder' => 'Ingresar a quien va dirigida la cotización',
                                    'value' 	  => '',
                                    'size' 		  => '35',
                                    'maxlength'   => '50');
           }
	else
           { $attributes = array('class' 	  => 'validate[required,custom[onlyLetterNumber]] text-input',
                                'name' 		  => 'prosp_nombre', 
                                'id'		  => 'prosp_nombre',
                                'value' 	  => $cotizacion['coti'][0]['prosp_nombre'],
                                'size' 		  => '35',
                                'maxlength'   => '50');
           }
	echo '<div class="row">
                <section class="col col-6">
                      <label class="label">Atte.</label>
                      <label class="input"><i class="icon-append fa fa-male"></i>'.
                      form_input($attributes).'
                       <b class="tooltip tooltip-bottom-right">Nombre o Contacto del Prospecto</b>
                      </label>
                  </section>
                  <section class="col col-6">&nbsp;</section>
               </div>';
	
	if($accion == "N")
            { $attributes = array('class' 	  => 'validate[required,custom[onlyLetterNumber]] text-input',
                                'name' 		  => 'prosp_empresa', 
                                'id'		  => 'prosp_empresa',
                                'placeholder'     => 'Ingresar nombre de la empresa a cotizar',
                                'value' 	  => '',
                                'size' 		  => '42',
                                'maxlength'       => '50');}
	else
            { $attributes = array('class' 	  => 'validate[required,custom[onlyLetterNumber]] text-input',
                                'name' 		  => 'prosp_empresa', 
                                'id'		  => 'prosp_empresa',
                                'value' 	  => $cotizacion['coti'][0]['prosp_empresa'],
                                'size' 		  => '42',
                                'maxlength'   => '50');
            }
         echo '<div class="row">
                <section class="col col-6">                      
                      <label class="input"><i class="icon-append fa fa-university"></i>'.
                      form_input($attributes).'
                       <b class="tooltip tooltip-bottom-right">Nombre o Raz&oacute;n Social de la empresa</b>
                      </label>
                  </section>
                  <section class="col col-6">&nbsp;</section>
               </div>';   															
	if($accion == "N")
            { $attributes = array('class' 	  => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                    'name'        => 'asunto', 
                                    'id'          => 'asunto',
                                    'value' 	  => '',
                                    'placeholder' => 'Ingresar el asunto de la cotizacion',
                                    'size'        => '31',
                                    'maxlength'   => '90');
            }
        else
            { $attributes = array('class' 	  => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                    'name'        => 'asunto', 
                                    'id'          => 'asunto',
                                    'value' 	  => $cotizacion['coti'][0]['asunto'],
                                    'size' 	  => '31',
                                    'maxlength'   => '90');
            }
        echo '<div class="row">
                <section class="col col-6">
                      <label class="label">ASUNTO:</label>
                      <label class="input"><i class="icon-append fa fa-bookmark"></i>'.
                      form_input($attributes).'
                       <b class="tooltip tooltip-bottom-right">Asunto</b>
                      </label>
                  </section>
                  <section class="col col-6">&nbsp;</section>
               </div>
               <div class="row">                          
                <section class="col col-12"> <label class="label">'.$templateCotizacion[0]['parrafo_inicial'].' </label> </section>
              </div>';
              $classTS = $accion == "N"?'class="validate[custom[requiredInFunction]]"':"";
              $c_MXM = false;
              $c_USD = false;
              $tc    = NULL;
              if ( $cotizacion['coti'][0]['moneda']=="MXN")
                {$c_MXM = true;
                 $c_USD = false;
                $tc    = 1;
                }
              else
                {$c_MXM = false;
                 $c_USD = true;
                }
               if($accion == "N")
                { $attributes = array('class' 	  => 'validate[required,custom[number]] text-input',
                                    'name' 		  => 'tipo_cambio', 
                                    'id'		  => 'tipo_cambio',
                                    'placeholder'     => 'Ej. 20.0',
                                    'value' 	  => $tc,
                                    'size' 		  => '25',
                                    'maxlength'       => '50');}
              else
                        { $attributes = array('class' 	  => 'validate[required,custom[number]] text-input',
                                            'name' 		  => 'tipo_cambio', 
                                            'id'		  => 'tipo_cambio',
                                            'value' 	  => $cotizacion['coti'][0]['tipo_cambio'],
                                            'size' 		  => '25',
                                            'maxlength'   => '50');
                        }         
        echo '<div class="row">
                <section class="col col-3">
                    <label class="label">Tipo de Servicio:</label>
                    <label class="select"><i class="icon-append"></i>'.
                     form_dropdown('tipos_servicio',$tipos_servicio,'0','id="tipos_servicio" '.$classTS).'
                    </label>
                </section>
                <section class="col col-1"></section>
                <section class="col col-3">
                <label class="label">Tipo Moneda</label>
                             ';
                            echo   '<label class="radio">'.form_radio(array("name"=>"moneda","id"=>"moneda","value"=>"USD", "checked"=>$c_USD)).'<i></i>USD</label>'.
                                   '<label class="radio">'.form_radio(array("name"=>"moneda","id"=>"moneda","value"=>"MXN", "checked"=>$c_MXM)).'<i></i>MXN</label>'.
                          ' <i></i> 
                            </label>   
                </section>
                <section class="col col-3" id="lblTipoCambio">
                  <label class="label">Tipo de Cambio</label>
                  <label class="input"><i class="icon-append fa fa-usd"></i>'.
                    form_input($attributes).'
                    <b class="tooltip tooltip-bottom-right">Tipo de Camio actual</b>
                  </label>
                </section>
                <section class="col col-2">
                    <img class="nuevoServicio" title="Agregar un nuevo servicio a la cotizaci&oacute;n" src="'.base_url().'images/new.png"/>
                </section>
              </div>';

	if($cotizacion['servicios'][0] == NULL)
        {
            echo '  <div class="row" id="servicio64"></div>
                    <div class="row" id="servicio65"></div>
                    <div class="row" id="servicio66"></div>';
        }		
	else
	{						  
		$x 		   	   = -1;
		$servicios 	   = "";
		
		for ($s = 0; $s <= 2; $s++) // los tres tipos de servicios 664,65,66
		{  
                    $x              = $x + 1;
                    $id             = $cotizacion['servicios'][$s]['id_servicio'];
                    $ts             = $cotizacion['servicios'][$s]['servicio'];
                    $coti_terminos  = $cotizacion['servicios'][$s]['coti_terminos'];
                    $coti_conceptos = $cotizacion['servicios'][$s]['coti_conceptos'];
                    $coti_cargos    = $cotizacion['servicios'][$s]['coti_cargos'];
                    $coti_notas     = $cotizacion['servicios'][$s]['coti_notas'];
                    $coti_sl        = $cotizacion['servicios'][$s]['coti_sl'];

		 if ($coti_terminos != NULL & $coti_conceptos != NULL & $coti_cargos != NULL & $coti_notas != NULL)
		 {	
		 	if(!empty($coti_sl))
			{
                            $numSlTerminos  = $coti_sl[0]['slterminos'];
                            $numSlConceptos = $coti_sl[0]['slconceptos'];
                            $numSlNotas 	= $coti_sl[0]['slnotas'];
                            $numSlServicios = $coti_sl[0]['slservicios'];
			}			
			
			$servicios = $servicios."<div id='servicio'".$id.">";			
			$saltoLinea ='<div class="row">
                                        <section class="col col-4">&nbsp;</section>
                                        <section class="col col-4">&nbsp;
                                        <!--
                                          <label class="label">Agregar saltos de Línea en esta sección en el PDF: </label>
                                          <label class="input"><i class="icon-append fa fa-paragraph"></i>'.
                                              form_input(array('name' => 'slServicios'.$id,'id' => 'slServicios'.$id,'class'=>'validate[custom[number]] text-input','value'=>$numSlServicios, 'size'=>'2','maxlength'=>'5')).'
                                           <b class="tooltip tooltip-bottom-right">Agregar saltos de Línea:</b>
                                          </label>
                                        -->
                                      </section>
                                      <section class="col col-4">&nbsp;</section>
                                      </div>';
			$servicios = $servicios.$saltoLinea.
				  "<table cellspacing='0' align='center' cellpadding='0' width='100%'>".
				  "<tr><td width='17%'></td><td width='70%' align='center'>".
				  "<table id='terminos".$id."' cellspacing='0' align='center' cellpadding='0' width='100%'>".
				  "<tr><td width='100%' align='center' colspan='4' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>FLETE ".$ts."</td></tr>".
				  "<tr><td width='10%'></td><td width='80%' colspan='2' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>TERMINOS</td>".
				  "<td width='10%' align='center'> ".
				  " <img class='".$id."nuevoTermino' title='Agregar concepto al servicio' src='".base_url()."images/new.png'/></td></tr>";
  
      $myRow = "";
			$numte = -1;
			foreach($coti_terminos as $detalle)
			{
			 $numte = $numte + 1;
			 if ($numte == 0)
                            { $campoDato0 = "<label class='select'><i class='icon-append'></i><select name='".$id."termino_dato0' id='".$id."termino_dato0' class='validate[custom[requiredInFunction]]' >
                                             <option value='".$detalle['descripcion']."' selected>".$detalle['descripcion']."</option></select> </label>";}
			 else
                            { $campoDato0 = "<section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='".$id."termino_dato".$numte."' value='".$detalle['descripcion']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."termino_dato".$numte."' size='25' maxlength='100'/></label></section>";}
			 
			 $myRow = $myRow." <tr><td width='10%'></td> ".
			 "<td align='left'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='".$id."termino".$numte."' value='".$detalle['termino']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."termino".$numte."' size='25' maxlength='100'/></label></td> ".
			 "<td align='center'>".$campoDato0."</td> ".
			 "<td><img title='Eliminar Termino' class='".$id."btnDeleteTermino' src='".base_url()."images/erase.png'></td></tr> ";
			}						
			$saltoLinea ='<div class="row">
                                        <section class="col col-4">&nbsp;</section>
                                        <section class="col col-4">&nbsp;
                                        <!--
                                          <label class="label">Agregar saltos de Línea en esta sección en el PDF: </label>
                                          <label class="input"><i class="icon-append fa fa-paragraph"></i>'.
                                              form_input(array('name' => 'slTerminos'.$id,'id' => 'slTerminos'.$id,'class'=>'validate[custom[number]] text-input','value'=>$numSlTerminos,'size'=>'2','maxlength'=>'5')).'
                                           <b class="tooltip tooltip-bottom-right">Agregar saltos de Línea:</b>
                                          </label>
                                        -->
                                      </section>
                                      <section class="col col-4">&nbsp;</section>
                                      </div>';	  
			$servicios = $servicios.$myRow."</table>".$saltoLinea.
				  "<table id='conceptos".$id."' cellspacing='0' align='center' cellpadding='0' width='100%'>".
				  "<tr ><td width='10%'></td><td width='80%' colspan='2' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>DETALLE DEL EMBARQUE</td>".
				  "<td width='10%' align='center'> ".
				  " <img class='".$id."nuevoConcepto' title='Agregar concepto al servicio' src='".base_url()."images/new.png'/></td></tr>";
			
			$myRow = "";
			$numco = -1;
			foreach($coti_conceptos as $detalle)
			{
			  $numco = $numco + 1;
			  $myRow = $myRow."<tr><td width='10%'></td> ".
			  "<td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='".$id."concep".$numco."' value='".$detalle['concepto']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."concep".$numco."' size='25' maxlength='100'/></label></td> ".
			  "<td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='".$id."concep_dato".$numco."' value='".$detalle['descripcion']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."concep_dato".$numco."' size='25' maxlength='100'/></label></td> ".
			  "<td width='10%'><img title='Eliminar Concepto' class='".$id."btnDeleteConcepto' src='".base_url()."images/erase.png'>
			  </td></tr> ";
			}				
                        $saltoLinea ='<div class="row">
                                        <section class="col col-4">&nbsp;</section>
                                        <section class="col col-4">
                                          <label class="label">Agregar saltos de Línea en esta sección en el PDF: </label>
                                          <label class="input"><i class="icon-append fa fa-paragraph"></i>'.
                                              form_input(array('name' => 'slConceptos'.$id,'id' => 'slConceptos'.$id,'class'=>'validate[custom[number]] text-input','value'=>$numSlConceptos,'size'=>'2','maxlength'=>'5')).'
                                           <b class="tooltip tooltip-bottom-right">Agregar saltos de Línea:</b>
                                          </label>                                        
                                      </section>
                                      <section class="col col-4">&nbsp;</section>
                                      </div>';	
			$servicios = $servicios.$myRow."</table>".$saltoLinea.
				  "<table id='cargos".$id."' cellspacing='0' align='center' cellpadding='0' width='100%'>".
				  " <tr>".
				  " <td width='45%' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>CONCEPTO</td>".
				  " <td width='45%' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>IMPORTE EN <span id='monedaSpan'>".$cotizacion['coti'][0]['moneda']."</span></td>".
                                  " <td width='3%'></td>".
				  " <td width='7%' align='center'> ".
				  " <img class='".$id."nuevoCargo' title='Agregar cargo al servicio' src='".base_url()."images/new.png'/></td></tr>";
			
			$myRow = "";
			$numca = -1;
			foreach($coti_cargos as $detalle)
			{
                            $ivaStr = "";
                            if ($detalle['iva'] == "1")
                                { $ivaStr = "checked"; }
			  $numca = $numca + 1;
			  $myRow = $myRow." <tr>".
			  "<td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='".$id."cargo".$numca."' value='".$detalle['cargo']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."cargo".$numca."' size='25' maxlength='100'/></label></td> ".
			  "<td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='".$id."importe".$numca."' value='".$detalle['importe']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."importe".$numca."' size='8' maxlength='10'/></label></section></td>".
			  "<td width='23%' align='center'><input type='checkbox' name='".$id."iva".$numca."' id='".$id."iva".$numca."' value='1' ".$ivaStr."/>más iva</td> ".
			  "<td width='7%'  align='center'><img title='Eliminar Concepto' class='".$id."btnDeleteCargo' src='".base_url()."images/erase.png'></td>
			  </tr> ";
			}						
			$saltoLinea ='<div class="row">
                                        <section class="col col-4">&nbsp;</section>
                                        <section class="col col-4">&nbsp;
                                        <!--
                                          <label class="label">Agregar saltos de Línea en esta sección en el PDF: </label>
                                          <label class="input"><i class="icon-append fa fa-paragraph"></i>'.
                                              form_input(array('name'=>'slNotas'.$id,'id'=>'slNotas'.$id,'class'=>'validate[custom[number]] text-input','value'=>$numSlNotas,'size'=>'2','maxlength'=>'5')).'
                                           <b class="tooltip tooltip-bottom-right">Agregar saltos de Línea:</b>
                                          </label>
                                        -->
                                      </section>
                                      <section class="col col-4">&nbsp;</section>
                                      </div>';		  
			$servicios = $servicios.$myRow."</table>".$saltoLinea.
				  "<table id='notas".$id."' cellspacing='0' align='center' cellpadding='0' width='100%'>".				  
				  " <tr><td width='10%'></td><td width='80%' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF' colspan='2'>NOTAS</td>".
				  " <td width='10%' align='center'>".
				  "  <img class='".$id."nuevoNota' title='Agregar Nota del Servicio' src='".base_url()."images/new.png'/></td></tr>";
	
			$myRow = "";
			$numno = -1;
			foreach($coti_notas as $detalle)
			{
			  $numno = $numno + 1;
			  $myRow = $myRow." <tr><td></td> ".
			  "<td align='right'><img src='".base_url()."images/nota.png'></td> ".
			  "<td align='left'><input type='text' name='".$id."nota".$numno."' value='".$detalle['nota']."' class='validate[required,custom[onlyLetterNumber]] text-input' id='".$id."nota".$numno."' size='60' maxlength='150'/></td> ".
			  "<td><img title='Eliminar Nota' class='".$id."btnDeleteNota' src='".base_url()."images/erase.png'></td></tr> ";
			}
				
			$servicios = $servicios.$myRow."</table><p></p>".
				  "</td><td width='15%' valign='top'>".
				  "<img title='Eliminar Servicio de ".$ts."' class='".$id."btnDelete' src='".base_url()."images/deleteIcon.png'/>".
				  "</td></tr></table>"; 
			
			$myRow = "";	  
			$servicios = $servicios."</div>".
						 "<input type='hidden' name='".$id."numconceptos' id='".$id."numconceptos' value='".$numco."'/>".
						 "<input type='hidden' name='".$id."numcargos'    id='".$id."numcargos'    value='".$numca."'/>".
						 "<input type='hidden' name='".$id."numterminos'  id='".$id."numterminos'  value='".$numte."'/>".
						 "<input type='hidden' name='".$id."numnotas'     id='".$id."numnotas'     value='".$numno."'/>";
		 }
		 else
                    { $servicios = $servicios."<div id='servicio".$id."'></div>"; }
		}
	
	
		$celda = array('data' => $servicios,'colspan'=>2);
		$pdf   = '';
	}

	$this->table->add_row($celda);
	echo $this->table->generate();	

        echo '
              <div class="row">
                <section class="col col-3">&nbsp;</section>
                <section class="col col-6">
                    <label class="label">La cotizaci&oacute;n se realizar&aacute;n a nombre de:</label>
                    <label class="select"><i class="icon-append"></i>'.
                     form_dropdown('admin', $admins, $cotizacion['coti'][0]['atentamente'],'id="admin" class="validate[custom[requiredInFunction]]"').'
                    </label>
                </section>
                <section class="col col-3">&nbsp;</section>
              </div>
              <div class="row">
              <section class="col col-4">&nbsp;</section>
              <section class="col col-4">
                <label class="label">Agregar saltos de Línea: </label>
                <label class="input"><i class="icon-append fa fa-paragraph"></i>'.
                    form_input(array('name' => 'slAtte','id' => 'slAtte','class'=>'validate[custom[number]] text-input','value'=>$cotizacion['coti'][0]['slAtte'],'size'=>'2','maxlength'=>'5')).'
                 <b class="tooltip tooltip-bottom-right">Agregar saltos de Línea:</b>
                </label>
            </section>
            <section class="col col-4">&nbsp;</section>
            </div>
            <div class="row">               
                <section class="col col-12">
                    <label class="label">'.$templateCotizacion[0]['parrafo_final'].'</label>
                </section>
            </div>';	
        $this->table->clear();
	$this->table->set_template(array('table_open'  => '<table cellspacing="0" align="center" cellpadding="0" width="100%">' ));
	$firmaAdmin  = "";
        $firma = $atentamente[0]['firma']==NULL || $atentamente[0]['firma']==""?"null.png":$atentamente[0]['firma']; 
	
	if($atentamente != NULL)
            { $firmaAdmin = '<img border=0 width="120px" height="80px" src="'.base_url().'images/firmas/'.$firma.'"/>'; }
			
	$celda = array('data' => 'Atentamente.'.br(2),'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span id="firmaAdmin">'.$firmaAdmin.'</span>','class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<span id="nombreAdmin">'.$atentamente[0]['titulo'].' '.$atentamente[0]['nombre'].' '.$atentamente[0]['apellidos'].'</span>'.br(2),'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => 'SENNI LOGISTICS S.A. DE C.V.'.br(2),'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => 'Tel. <img border=0 src="'.base_url().'images/tel.png"/>  <span id="telAdmin">'.$atentamente[0]['telefono'].'</span>'.br(2),'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => 'Cel. <img border=0 src="'.base_url().'images/cel.png"/> <span id="celAdmin">'.$atentamente[0]['celular'].'</span>'.br(2),'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => 'EM.  <a href="mailto:'.$atentamente[0]['correo'].'"><img border=0 src="'.base_url().'images/at.png" /> 
	                           <span id="correoAdmin">'.$atentamente[0]['correo'].'</span></a>'.br(2),
				   'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	$celda = array('data' => '<a href="'.base_url().'"> <img border=0 src="'.base_url().'images/inicio.png"/> www.senni.com.mx</a>'.br(2),'class'=>"CotiIzquierdaBold");	
	$this->table->add_row($celda);
	
	echo $this->table->generate();
	
	$this->table->clear();
	$tmpl = array('table_open'  => '<table cellspacing="0" align="center" cellpadding="0" width="80%">' );
	$this->table->set_template($tmpl);
	
	$celda1 = array('data'=>'<a class="button color" href="javascript:generaCotiPDFAX(href);"><span>Generar PDF</span></a>','align'=>"right",'width'=>"50%");
	$celda2 = array('data'=>'<span id="generaCotiPDF">'.$pdf.'</span>','align'=>"left",'width'=>"50%");
	$this->table->add_row(array($celda1,$celda2));
	echo $this->table->generate();
	echo br(1);
	
	$attributes1 = 'id="terminoINCO" class="esconder"';					
	echo form_dropdown('terminoINCO',$terminosINCO,'0',$attributes1);
?>                                                                         
 <a class="button color" href="javascript:submitForm('coti');"><span>Guardar Cotización</span></a>
									   
</fieldset>    
<?php 
	echo form_close();
	
 	include("footer_admin.php"); 	
?>  