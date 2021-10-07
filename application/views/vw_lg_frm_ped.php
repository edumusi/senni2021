<?php include("header_lg_admin.php"); ?>

<style>
  .ui-autocomplete-loading { background: white url("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/images/ui-anim_basic_16x16.gif") right center no-repeat; }
  .ui-autocomplete { max-height: 100px;
                    overflow-y: auto;
                    /* prevent horizontal scrollbar */
                    overflow-x: hidden;
                   }
  
</style>

<script>
var hrefF      = '<?php echo base_url(); ?>';
var tipoAccion = '<?php echo $accion; ?>';

  
$(document).ready(function(){
    $( "#modalFac").dialog({ autoOpen: false,
                             height  : 650,
                             width   : 950,
                             modal   : true,
                             buttons : { "Vista Previa" : function (event) { event.preventDefault();
                                                                             $(this).prop('disabled', true);                                                                             
                                                                             vistaPreviaFacturaAX();
                                                                            },
                                         "Timbrar"      : function (event) { event.preventDefault();
                                                                             $(this).prop('disabled', true);                                                                             
                                                                             timbrarAX();
                                                                            },
                                         Cancel         : function() { $( this ).dialog( "close" ); }
                                        },
                             close   : function() {  }
                            }); 
    $("#openModalFac"    ).on( "click", function() { $("#modalFac" ).dialog( "open" ); 
                                                     $("#ui-id-1"  ).html("FACTURACION ELECTRONICA SENNI Logistics ");
                                                     openModalTimbrarAX(hrefF, $("#id_pedido").val(), $("#rfc").val());
                                                     if ($("#fleteSalvado").val() == 0) { jAlert("Favor de guardar primero la sección de 'Flete', previo a generar la factura", "FACTURACIÓN"); $( "#modalFac").dialog( "close" ); }
                                                   });
    $("#tabsTimbrado"    ).tabs()
                          .on("click", '[role="tab"]', function() { var tab     = $(this).find("a");
                                                                    var botones = $(".ui-dialog-buttonset").children();
                                                                    if($(tab).attr('href') == "#tabs-5" || $(tab).attr('href') == "#tabs-6")
                                                                    {
                                                                        $(botones).first().hide();
                                                                        $(botones).first().next().hide()                                                                        
                                                                    }
                                                                    else
                                                                    {
                                                                        if( $("#facturaTimbrada").val() == "0" )
                                                                        {
                                                                            $(botones).first().show();
                                                                            $(botones).first().next().show();
                                                                        }
                                                                    }
                                                                  });
	$("#entrega"         ).datepicker({dateFormat: 'dd/mm/yy'});	
	$(".f_r"             ).datepicker({dateFormat: 'dd/mm/yy'});	

    $("#fecha_expedicion").datepicker({dateFormat: 'dd/mm/yy', maxDate: 2});
    $("#fecha_expedicion").datepicker( "option", "minDate", new Date() );                    
    $("#fecha_rep"       ).datepicker({dateFormat: 'dd/mm/yy', maxDate: 0});
    $("#forma_pago_rep option[value='99']").remove();
    $("#forma_pago_rep option[value='30']").remove();
        
	$(".costos"          ).change(function(){ calcularProfit(); });	 
	$(".ventas"          ).change(function(){ calcularProfit(); });
    $("#fondo_ahorro_por").change(function(){ calcularFA();     });
    $("#profit_origen"   ).change(function(){ calcularProfit(); });
        
	$('.esconder'        ).hide();
	$('.esconderINCO'    ).hide();
	
	$("input[name=moneda]").click(function () { 
    $(".monedaSpan").html($(this).val()); 
    if($(this).val() === "MXN")
        {
            $(this).attr('checked',true);
            $("input[value=USD]").attr('checked',false);
            $("#tipo_cambio").removeClass();
            $("#tipo_cambio").attr('class','validate[custom[number]] text-input');
        }
    else{
            $(this).attr('checked',true);
            $("input[value=MXN]").attr('checked',false);
            $("#tipo_cambio").removeClass();
            $("#tipo_cambio").attr('class','validate[required,custom[number]] text-input');
        }
    });

    $("#convertirAlTC").change(function() {
        if($(this).prop('checked')) { convertirAlTipoCambio("*"); } 
        else { convertirAlTipoCambio("/");  }
    });

	if(tipoAccion === "E")
	{
            $('.btnDelete').addClass('pointer');
            $(".btnDelete").bind("click", Delete);

            $('.boton_confirm').addClass('pointer');
            $('.boton_confirm').click(function() {  var id     = $(this).attr('id');
                                                    var name   = $(this).attr('name');
                                                    var opcion = $(this).attr('opcion');
                                                    var id_adj = $(this).attr('id_adjunto');
                                                    jConfirm("¿Borrar documento?", titAlert, function(r) { if(r) {borraAdjuntoCargadoAX(hrefF, id, name, opcion, id_adj); } });
                                                 });

            traeDatosCotiAX($("#cotis").val(),hrefF);
                     
            habilitaFechas();
            
            habilitaBotonAgregarPedido('64',hrefF);
            habilitaBotonEliminar('64','btnDelete');
            habilitaBotonEliminar('64','btnDeleteConcepto');
            habilitaBotonEliminar('64','btnDeleteCargo');
            habilitaBotonEliminar('64','btnDeleteTermino');
            habilitaBotonEliminar('64','btnDeleteNota');
            habilitaBotonAgregarPedido('65',hrefF);
            habilitaBotonEliminar('65','btnDelete');
            habilitaBotonEliminar('65','btnDeleteConcepto');
            habilitaBotonEliminar('65','btnDeleteCargo');
            habilitaBotonEliminar('65','btnDeleteTermino');
            habilitaBotonEliminar('65','btnDeleteNota');
            habilitaBotonAgregarPedido('66',hrefF);
            habilitaBotonEliminar('66','btnDelete');
            habilitaBotonEliminar('66','btnDeleteConcepto');
            habilitaBotonEliminar('66','btnDeleteCargo');
            habilitaBotonEliminar('66','btnDeleteTermino');
            habilitaBotonEliminar('66','btnDeleteNota');
            habilitaBotonAgregarPedido('88',hrefF);
            habilitaBotonEliminar('88','btnDelete');
            habilitaBotonEliminar('88','btnDeleteConcepto');
            habilitaBotonEliminar('88','btnDeleteCargo');
            habilitaBotonEliminar('88','btnDeleteTermino');
            habilitaBotonEliminar('88','btnDeleteNota');
            habilitaBotonAgregarPedido('89',hrefF);
            habilitaBotonEliminar('89','btnDelete');
            habilitaBotonEliminar('89','btnDeleteConcepto');
            habilitaBotonEliminar('89','btnDeleteCargo');
            habilitaBotonEliminar('89','btnDeleteTermino');
            habilitaBotonEliminar('89','btnDeleteNota');
            habilitaBotonAgregarPedido('90',hrefF);
            habilitaBotonEliminar('90','btnDelete');
            habilitaBotonEliminar('90','btnDeleteConcepto');
            habilitaBotonEliminar('90','btnDeleteCargo');
            habilitaBotonEliminar('90','btnDeleteTermino');
            habilitaBotonEliminar('90','btnDeleteNota');                   
	}
	else
	{   $('.esconderAD').hide();
	}
	
	subirArchivo(hrefF);
	$('#mulitplefileuploader').addClass('pointer');			

	$("#rfc"     ).combobox();
	$("#carrier" ).combobox();
    $("#cotis"   ).combobox();

    $("#uso_cfdi"      ).combobox();
    $("#regimen_fiscal").combobox();
    $("#clave_unidad"  ).combobox();
    $("#metodo_pago"   ).combobox();
    $("#forma_pago"    ).combobox();
    $("#forma_pago_rep").combobox();
    $("#moneda_rep"    ).combobox();
    $("#descuentoSAT"  ).change(function(){ calcularTotFacturas(); });
    
    $( "#cveProdSAT" ).autocomplete({
      source: function( request, response ) {
      $.ajax( { url     : hrefF+'pedido/cveProdSAT_AX',//"search.php",
                type    : 'post',
                dataType: "json",
                data    : { search: request.term },
                success : function( data ) { response( data ); }
              } );
      },
      minLength: 3,
      select: function( event, ui ) {  }
    } );

    $( "#clave_unidadSAT" ).autocomplete({
      source: function( request, response ) {
      $.ajax( { url     : hrefF+'pedido/cveUnidadSAT_AX',//"search.php",
                type    : 'post',
                dataType: "json",
                data    : { search: request.term },
                success : function( data ) { response( data ); }
              } );
      },
      minLength: 3,
      select: function( event, ui ) {  }
    } );    

    $( "#uuidCfdiRel" ).autocomplete({
      source: function( request, response ) {
      $.ajax( { url     : hrefF+'pedido/uuidCfdiRel_AX',//"search.php",
                type    : 'post',
                dataType: "json",
                data    : { search: request.term },
                success : function( data ) { response( data ); }
              } );
      },
      minLength: 3,
      select: function( event, ui ) {  }
    } );

    soloNumeros();
    
	$( "span" ).find("input").addClass("validate[required] text-input");
	$( "span" ).find("a"    ).css     ( "height", "26px" );
	
/*	
	if($('#status'+$("#num_track").val()+' option:selected').val() >= 41)		
            { $('.esconderPF').show(); }
*/
  });//document ready
</script>


<?php
echo  "<div class='sky-form'>";    
    echo '<header>Referencia '.NOMBRE_CORTO.' '.$id_pedido.'</header>';
    echo ' <!-- tabs -->
              <div class="sky-tabs sky-tabs-amount-7 sky-tabs-pos-top-justify sky-tabs-response-to-icons">
                    <input type="radio" name="sky-tabs" value="HD" checked id="sky-tab1" class="sky-tab-content-1">
                    <label for="sky-tab1"><span><span><i class="fa fa-folder"></i>Encabezado</span></span></label>

                    <input type="radio" name="sky-tabs" value="AD" id="sky-tab2" class="sky-tab-content-2">
                    <label for="sky-tab2"><span><span><i class="fa fa-tag"></i>Producto</span></span></label>

                    <input type="radio" name="sky-tabs" value="SW" id="sky-tab3" class="sky-tab-content-3">
                    <label for="sky-tab3"><span><span><i class="fa fa-truck"></i>Flete</span></span></label>

                    <input type="radio" name="sky-tabs" value="SM" id="sky-tab4" class="sky-tab-content-4">
                    <label for="sky-tab4"><span><span><i class="fa fa-file-text-o"></i>Docs </span></span></label>
<!--
                    <input type="radio" name="sky-tabs" value="AP" id="sky-tab5" class="sky-tab-content-5">
                    <label for="sky-tab5"><span><span><i class="fa fa-plane"></i>Transporte</span></span></label>
-->
                    <input type="radio" name="sky-tabs" value="RA" id="sky-tab6" class="sky-tab-content-6">
                    <label for="sky-tab6"><span><span><i class="fa fa-road"></i>Rastreo</span></span></label>
                    
                    <input type="radio" name="sky-tabs" value="GA" id="sky-tab7" class="sky-tab-content-7">
                    <label for="sky-tab7"><span><span><i class="fa fa-money"></i>Ganancia</span></span></label>';      
    echo '<ul>
           <li class="sky-tab-content-1">';
    echo  form_input(array('name' => 'controller_fac', 'type' => 'hidden', 'id' => 'controller_fac', 'value' => CONTROLLER_FAC))
         .form_input(array('name' => 'baseURL',       'type' => 'hidden', 'id' => 'baseURL','value'   => base_url()))
         .form_input(array('name' => 'etdOperacion',  'type' => 'hidden', 'id' => 'etdOperacion','value'    => $pedido["encabezado"][0]['etd'],))
         .form_input(array('name' => 'etaOperacion',  'type' => 'hidden', 'id' => 'etaOperacion','value'    => $pedido["encabezado"][0]['eta'],))
         .form_input(array('name' => 'monedaOperaciones',  'type' => 'hidden', 'id' => 'monedaOperaciones','value'    => $pedido["encabezado"][0]['moneda'],))
         .form_input(array('name' => 'tcOperaciones',  'type' => 'hidden', 'id' => 'tcOperaciones','value'    => $pedido["encabezado"][0]['tipo_cambio'],));
    echo form_open(base_url().'pedido/guardar/', array('id' => 'ENC') );
    echo '    <div class="row">          
                <section class="col col-7">
                    <label class="label">Cotizaci&oacute;n:</label>'.
                     form_dropdown('cotis',
                                    $cotizaciones,
                                    $pedido["encabezado"][0]['id_coti'],
                                    'id="cotis" class="validate[custom[requiredInFunction]]"').'
                    </label><span id="cotiServMensaje"> </span><span id="secCoti"> </span>
                </section>
                <section class="col col-1"><label class="label">&nbsp;</label><span id="cotiMensaje"></span>&nbsp;&nbsp;<a href="'.base_url().'cotizador/nuevo/"><img title="Agregar una cotizacion" src="'.base_url().'images/new.png"/></a></section>
                <section class="col col-4" id="EtaEtd">&nbsp;</section>
               </div>';
    echo     '<div class="row">          
                <section class="col col-7">
                    <label class="label">Cliente:</label>'.
                     form_dropdown('rfc',
                                    $clientes,
                                    $pedido["encabezado"][0]['rfc'],
                                    'id="rfc" class="validate[custom[requiredInFunction]]"').'
                    </label>
                </section>
                <section class="col col-2"><label class="label">&nbsp;</label>
                <a href="'.base_url().'gestion/nuevocliente/"><img title="Agregar un nuevo cliente" src="'.base_url().'images/new.png"/></a>
                 '.form_input(array('name' => 'id_pedido', 'type' => 'hidden', 'id' => 'id_pedido','value' => $id_pedido))
                  .form_input(array('name' => 'accion',    'type' => 'hidden', 'id' => 'accion','value'    => $accion))
                  .form_input(array('name' => 'vessel_voyage','type' => 'hidden', 'id' => 'vessel_voyage','value'    => $pedido["encabezado"][0]['vessel_voyage'],))
                  .form_input(array('name' => 'ins_booking',  'type' => 'hidden', 'id' => 'ins_booking','value'    => $pedido["encabezado"][0]['ins_booking'],))
                  .form_input(array('name' => 'carta_garantia',  'type' => 'hidden', 'id' => 'carta_garantia','value' => $pedido["encabezado"][0]['carta_garantia'],))
                  .form_input(array('name' => 'carta_no',  'type' => 'hidden', 'id' => 'carta_no','value'    => $pedido["encabezado"][0]['carta_no'],))
                  .form_input(array('name' => 'monto_carta_no',  'type' => 'hidden', 'id' => 'monto_carta_no','value'    => $pedido["encabezado"][0]['monto_carta_no'],))                  
                  .form_input(array('name' => 'flagHeaderSaved',  'type' => 'hidden', 'id' => 'flagHeaderSaved','value'    => $pedido["encabezado"][0]['flagHeaderSaved'],))
                  .form_input(array('name' => 'status_track',  'type' => 'hidden', 'id' => 'status_track','value'    => $pedido["encabezado"][0]['status_track'],))
                  .'
                </section>
                <section class="col col-3">&nbsp;</section>
                </div>';
    echo     '<div class="row">          
                <section class="col col-7">
                    <label class="label">Carrier:</label>'.
                     form_dropdown('carrier',
                                    $carrier,
                                    $pedido["encabezado"][0]['id_carrier'],
                                    'id="carrier" class="validate[custom[requiredInFunction]]"').'
                    </label>
                </section>
                <section class="col col-1">
                <label class="label">&nbsp;</label>
                 <a href="'.base_url().'proveedor/nuevo/"><img title="Agregar un nuevo Proveedor" src="'.base_url().'images/new.png"/></a>
                </section>
                <section class="col col-4">
                    <label class="label">Tipo de Embarque:</label>
                    <label class="select"><i class="icon-append"></i>'.
                    form_dropdown('tipo_embarque',
                                    $tipo_embarque,
                                    $pedido["encabezado"][0]['tipo_embarque'],
                                    'id="tipo_embarque" ').'
                    </label>
                </section>                
                </div>';
      echo     '<div class="row">
                <section class="col col-7">
                      <label class="label">N. Booking:</label>
                      <label class="input"><i class="icon-append fa fa-male"></i>'.
                      form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                                        'name' 	=> 'num_booking', 
                                        'id' 	=> 'num_booking',
                                        'value'     => $pedido["encabezado"][0]['num_booking'],
                                        'size' 	=> '20',
                                        'maxlength' => '20')).'
                       <b class="tooltip tooltip-bottom-right">N&uacute;mero de Rerervaci&oacute;n</b>
                      </label>
                </section>      
                <section class="col col-1"></section>
                <section class="col col-4">
                        <label class="label">Embarcador</label>'.
                        form_textarea(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                            'name' 	    => 'shipper', 
                                            'id'        => 'shipper',
                                            'value'     => $pedido["encabezado"][0]['shipper'],
                                            'rows'      => '2',
                                            'cols'      => '5',
                                            'style'     => 'width:100%',
                                            'maxlength' => '80'
                                          )).'                 
                    </section>              
                 </div>'; 
 echo     '<div class="row">
            <section class="col col-5">
                  <label class="label">Gu&iacute;a Master:</label>
                  <label class="input"><i class="icon-append fa fa-male"></i>'.
                  form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                                    'name' 	=> 'num_mbl', 
                                    'id' 	=> 'num_mbl',
                                    'value'     => $pedido["encabezado"][0]['num_mbl'],
                                    'size' 	=> '20',
                                    'maxlength' => '20')).'
                   <b class="tooltip tooltip-bottom-right">Ingresar N&uacute;mero de Gu&iacute;a Master o MBL/MAWB</b>
                  </label>
              </section>
              <section class="col col-2"></section>
              <section class="col col-5">
                  <label class="label">Gu&iacute;a House: </label>
                  <label class="input"><i class="icon-append fa fa-male"></i>'.
                  form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                                    'name' 	=> 'num_hbl', 
                                    'id' 	=> 'num_hbl',
                                    'value'     => $pedido["encabezado"][0]['num_hbl'],
                                    'size' 	=> '22',
                                    'maxlength' => '20')).'
                   <b class="tooltip tooltip-bottom-right">Ingresar Número de Guía House o HBL/HAWB</b>
                  </label>
              </section>
             </div>'; 
   echo     '<div class="row">           
             <section class="col col-4">
                <label class="label">POL: </label>
                <label class="input"><i class="icon-append fa fa-map-marker"></i>'.
                form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                                  'name' 	=> 'pol', 
                                  'id' 	    => 'pol',
                                  'value'   => $pedido["encabezado"][0]['pol'],
                                  'size' 	=> '22',
                                  'maxlength' => '80')).'
                 <b class="tooltip tooltip-bottom-right">POL</b>
                </label>
            </section>            
            <section class="col col-4">
            <label class="label">POD: </label>
            <label class="input"><i class="icon-append fa fa-map-marker"></i>'.
            form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                              'name' 	=> 'pod1', 
                              'id' 	    => 'pod1',
                              'value'   => $pedido["encabezado"][0]['pod1'],
                              'size' 	=> '22',
                              'maxlength' => '80')).'
             <b class="tooltip tooltip-bottom-right">POD</b>
            </label>
        </section>    
        <section class="col col-4">
                <label class="label">POD: </label>
                <label class="input"><i class="icon-append fa fa-map-marker"></i>'.
                form_input(array('class' 	 => 'validate[custom[onlyLetterNumber]] text-input', 
                                  'name' 	 => 'pod2', 
                                  'id' 	     => 'pod2',
                                  'value'    => $pedido["encabezado"][0]['pod2'],
                                  'size' 	 => '22',
                                  'maxlength' => '80')).'
                 <b class="tooltip tooltip-bottom-right">POD</b>
                </label>
            </section>    
           </div>';                          
 echo     '<div class="row">
            <section class="col col-5">
                  <label class="label">Observaciones: </label>'.
                  form_textarea(array('class' 	    => 'validate[custom[onlyLetterNumber]] text-input', 
                                        'name' 	    => 'ins_envio', 
                                        'id' 	    => 'ins_envio',
                                        'value'     => $pedido["encabezado"][0]['ins_envio'],								 
                                        'rows'      => '2',
                                        'cols'      => '5',
                                        'style'     => 'width:100%',
                                        'maxlength' => '80')).'
              </section>              
              <section class="col col-2"></section>
              <section class="col col-5">
                  <label class="label">Revalidar al AA:</label>
                  <label class="input"><i class="icon-append fa fa-folder"></i>'.
                  form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                                    'name' 	=> 'revalidar_aa', 
                                    'id' 	=> 'revalidar_aa',
                                    'value'     => $pedido["encabezado"][0]['revalidar_aa'],
                                    'size' 	=> '20',
                                    'maxlength' => '80')).'
                   <b class="tooltip tooltip-bottom-right">Revalidar al Agente Aduanal</b>
                  </label>
              </section>
              </div>';
    echo     '<div class="row">               
              
                </div>';
echo "<footer>
            <a class='button sub' href='javascript:submitFormAX(hrefF,\"ENC\",\"$id_pedido\",\"$accion\", false);'>Guardar Sección</a>
            <span id='confirmENC' class='msjconfirm'></span>
            <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
         </footer>";
echo form_close();    
//FORMULARIO PRODUCTO
echo '</li>      
      <li class="sky-tab-content-2">';
    echo form_open(base_url().'pedido/guardar/', array( 'id' => 'PROD') );    
    echo '<div id="productos">';
    echo '<div class="row">
            <section class="col col-4"></section>
            <section class="col col-4">
                        <label class="label">Número de Contenedor: </label>
                        <label class="input"><i class="icon-append fa fa-briefcase"></i>'.
                        form_input(array('class' 	=> 'validate[custom[number]] text-input', 
                                            'name' 	=> 'num_contenedor', 
                                            'id' 	=> 'num_contenedor',
                                            'value'     => $pedido["encabezado"][0]['num_contenedor'],
                                            'size' 	=> '22',
                                            'maxlength' => '80')).'
                        <b class="tooltip tooltip-bottom-right">Número de Contenedor</b>
                        </label>
            </section>
            <section class="col col-4"></section>
              </div>';
        if ($pedido["producto"] == FALSE)
        {   echo '<div class="row">
            <section class="col col-3">
                <label class="label">Producto: </label>
                <label class="input"><i class="icon-append fa fa-tag"></i>'.
                form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'nombre0', 
                                 'id'        => 'nombre0',
                                 'size'      => '10',
                                 'maxlength' => '50')).'
                 <b class="tooltip tooltip-bottom-right">Nombre del producto solicitado</b>
                </label>
            </section>
            <section class="col col-3">
                <label class="label">Commodity: </label>
                <label class="input"><i class="icon-append fa fa-bars"></i>'.
                form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'commodity0', 
                                 'id'        => 'commodity0',
                                 'size'      => '10',
                                 'maxlength' => '30')).'
                 <b class="tooltip tooltip-bottom-right">Commity o Clasificaci&oacute;n del Producto</b>
                </label>
            </section>
            <section class="col col-2">
                <label class="label">Peso: </label>
                 <label class="input"><i class="icon-append fa fa-tag"></i>'.
                form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'peso0', 
                                 'id'        => 'peso0',
                                 'size'      => '10',
                                 'maxlength' => '30')).'
                 <b class="tooltip tooltip-bottom-right">Peso del producto en KG</b>
                </label>
            </section>
            <section class="col col-3">
                <label class="label">Volumen: </label>
                <label class="input"><i class="icon-append fa fa-cube"></i>'.
                form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'volumen0', 
                                 'id'        => 'volumen0',
                                 'size'      => '10',
                                 'maxlength' => '30')).'
                 <b class="tooltip tooltip-bottom-right">Volumen del producto en centimetros c&uacute;bicos</b>
                </label>
            </section>
            <section class="col col-1"><a href="javascript:addRowProd(hrefF)"><img title="Agregar producto" src="'.base_url().'images/new.png"/> </a> 
                '.form_input(array('name' => 'num_prod', 'type' => 'hidden', 'id' => 'num_prod','value' => '0')).'</section>
          </div>';
        }                                            
        else
        {
        $x = -1;
        foreach($pedido["producto"] as $p)
        {   $x = $x + 1;
            if($x == 0)
                { $ttvar_ag = '<a href="javascript:addRowProd(hrefF)"><img title="Agregar producto" src="'.base_url().'images/new.png"/> </a>'; }
            else
                { $ttvar_ag = '<img title="Eliminar producto" class="btnDelete" src="'.base_url().'images/erase.png">'; }
            echo '<div class="row">
            <section class="col col-3">
                <label class="label">Producto: </label>
                <label class="input"><i class="icon-append fa fa-tag"></i>'.
                form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'nombre'.$x, 
                                 'id'        => 'nombre'.$x,
                                 'value'     => $p["nombre"],
                                 'size'      => '10',
                                 'maxlength' => '50')).'
                 <b class="tooltip tooltip-bottom-right">Nombre del producto solicitado</b>
                </label>
            </section>
            <section class="col col-3">
                <label class="label">Commodity: </label>
                <label class="input"><i class="icon-append fa fa-bars"></i>'.
                form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'commodity'.$x, 
                                 'id'        => 'commodity'.$x,
                                 'value'     => $p["commodity"],
                                 'size'      => '10',
                                 'maxlength' => '30')).'
                 <b class="tooltip tooltip-bottom-right">Commity o Clasificaci&oacute;n del Producto</b>
                </label>
            </section>
            <section class="col col-2">
                <label class="label">Peso: </label>
                 <label class="input"><i class="icon-append fa fa-tag"></i>'.
                form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'peso'.$x, 
                                 'id'        => 'peso'.$x,
                                 'value'     => $p["peso"],
                                 'size'      => '10',
                                 'maxlength' => '30')).'
                 <b class="tooltip tooltip-bottom-right">Peso del producto en KG</b>
                </label>
            </section>
            <section class="col col-3">
                <label class="label">Volumen: </label>
                <label class="input"><i class="icon-append fa fa-cube"></i>'.
                form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                 'name'      => 'volumen'.$x, 
                                 'id'        => 'volumen'.$x,
                                 'value'     => $p["volumen"],
                                 'size'      => '10',
                                 'maxlength' => '30')).'
                 <b class="tooltip tooltip-bottom-right">Volumen del producto en centimetros c&uacute;bicos</b>
                </label>
            </section>
            <section class="col col-1">'.$ttvar_ag.'
                '.form_input(array('name' => 'num_prod', 'type' => 'hidden', 'id' => 'num_prod','value' => $x)).'</section>
          </div>';                
        }// for each        
        }
echo "</div><footer>
            <a class='button sub' href='javascript:submitFormAX(hrefF,\"PROD\",\"$id_pedido\",\"$accion\", false);'>Guardar Sección</a>
            <span id='confirmPROD' class='msjconfirm'></span>
            <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
      </footer>";        
echo form_close();        
echo '</li>';
//FORMULARIO FLETE
echo '<li class="sky-tab-content-3">';
echo form_open(base_url().'pedido/guardar/', array( 'id' => 'FLET') );
echo '
        <div class="row">          
        <section class="col col-2">&nbsp;</section>
        <section class="col col-4">
                 <label class="label">Tipo de Moneda:</label>';
                $c_MXM = false;
                $c_USD = false;						  
                if ($pedido["encabezado"][0]['moneda']=="MXN"){
                    $c_MXM = true;
                    $c_USD = false;}
                else{
                    $c_MXM = false;
                    $c_USD = true;}
    echo        form_radio(array("name"=>"moneda","id"=>"moneda","value"=>"USD", "checked"=>$c_USD)).'USD'.nbs(2).
                form_radio(array("name"=>"moneda","id"=>"moneda","value"=>"MXN", "checked"=>$c_MXM)).'MXN '.
                '</section>
         <section class="col col-3"><div id="tc"><label class="label">Tipo de Cambio:</label>
         <label class="input "><i class="icon-append fa fa-usd "></i>'.
            form_input(array('class'       => 'validate[custom[number]] text-input ', 
                             'name'        => 'tipo_cambio', 
                             'id'          => 'tipo_cambio',
                             'placeholder' => "Ej. 17.2",
                             'value'       => $pedido['encabezado'][0]['tipo_cambio'],                                     
                             'maxlength'   => '40')).'
             <b class="tooltip tooltip-bottom-right">Tipo de cambio</b>
         </label></div><div class="note" id="ttNoteEta">MXN</div></section>
         <section class="col col-3">&nbsp;</section>
         </div>      
        ';
echo '  <div class="row" id="servicio64"></div>
        <div class="row" id="servicio65"></div>
        <div class="row" id="servicio66"></div>
        <div class="row" id="servicio88"></div>
        <div class="row" id="servicio89"></div>
        <div class="row" id="servicio90"></div>';
echo '<fieldset>
        <div class="row">                  
         <section class="col col-4"> &nbsp; </section>
         <section class="col col-4"><div id="generaPrefacturaPDF"><p>&nbsp;</p></div></section>
         <section class="col col-4"> 
         <a class="button" id="openModalFac">Facturar <i class="fa fa-file-o"></i> <i class="fa fa-file-pdf-o"></i></a>
         </section>
         </div>
      </fieldset>';
echo form_input(array('name' => 'profitFLET'            ,'id' =>'profitFLET'            ,'type'=>'hidden','value' =>'0'))
    .form_input(array('name' => 'profit_origenFLET'     ,'id' =>'profit_origenFLET'     ,'type'=>'hidden','value' =>'0'))
    .form_input(array('name' => 'costo_tFLET'           ,'id' =>'costo_tFLET'           ,'type'=>'hidden','value' =>'0'))
    .form_input(array('name' => 'venta_tFLET'           ,'id' =>'venta_tFLET'           ,'type'=>'hidden','value' =>'0'))
    .form_input(array('name' => 'comision_ventasFLET'  ,'id' =>'comision_ventasFLET'  ,'type'=>'hidden','value' =>'0'))
    .form_input(array('name' => 'comision_operacionesFLET','id' =>'comision_operacionesFLET','type'=>'hidden','value' =>'0'))
    .form_input(array('name' => 'id_pedidoFLET'         ,'id' =>'id_pedidoFLET'         ,'type'=>'hidden','value' =>$id_pedido))
    .form_input(array('name' => 'num_mblFLET'           ,'id' =>'num_mblFLET'           ,'type'=>'hidden','value' =>$pedido["encabezado"][0]['num_mbl']))
    .form_input(array('name' => 'num_hblFLET'           ,'id' =>'num_hblFLET'           ,'type'=>'hidden','value' =>$pedido["encabezado"][0]['num_hbl']))
    .form_input(array('name' => 'vessel_voyageFLET'     ,'id' =>'vessel_voyageFLET'     ,'type'=>'hidden','value' =>$pedido["encabezado"][0]['vessel_voyage']))
    .form_input(array('name' => 'monedaFLET'            ,'id' =>'monedaFLET'            ,'type'=>'hidden','value' =>$pedido["encabezado"][0]['moneda']))        
    .form_input(array('name' => 'rfcFLET'               ,'id' =>'rfcFLET'               ,'type'=>'hidden','value' =>$pedido["encabezado"][0]['rfc']))
    .form_input(array('name' => 'fleteSalvado'          ,'id' =>'fleteSalvado'          ,'type'=>'hidden','value' =>$pedido["numCargos"] ) )    
    ;
echo "<footer>
            <a class='button sub' href='javascript:submitFormAX(hrefF,\"FLET\",\"$id_pedido\",\"$accion\", false);'>Guardar Sección</a>
           <span id='confirmFLET' class='msjconfirm'></span>
            <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
         </footer>";
echo form_close(); 


include("vw_timbrar.php");

  
echo '</li>';

//***************** DOCS
echo '<li class="sky-tab-content-4">';
echo form_open(base_url().'pedido/guardar/', array( 'id' => 'DAA') );
/*
echo '<fieldset>
      <div class="row">
        <section class="col col-6">
            <label class="label">Agencia Aduanal: </label>'.
            form_textarea(array('class'       => 'validate[custom[onlyLetterNumber]] text-input', 
                                  'name'      => 'agencia', 
                                  'id' 	      => 'agencia',
                                  'value'     => $pedido["aduana"][0]['agencia'],
                                  'rows'      => '2',
                                  'cols'      => '5',
                                  'style'     => 'width:100%',
                                  'maxlength' => '80')).'
        </section>
        <section class="col col-6">
            <label class="label">Tiempo Despacho: </label>'.
            form_textarea(array('class'       => 'validate[custom[onlyLetterNumber]] text-input', 
                                  'name'      => 'tiempo', 
                                  'id'        => 'tiempo',
                                  'value'     => $pedido["aduana"][0]['tiempo'],
                                  'rows'      => '2',
                                  'cols'      => '5',
                                  'style'     => 'width:100%',
                                  'maxlength' => '80')).'
        </section>
       </div>
       </fieldset>';
 *
 */
echo '<div class="row">       
        <section class="col col-4"><label class="label">Nombre o Tipo de archivo a anexar al embarque:</label>            
             <label class="input "><i class="icon-append fa fa-file-text-o"></i>'.
            form_input(array('class'       => 'validate[required,custom[onlyLetterNumber]] text-input ', 
                             'name'        => 'fileupSel', 
                             'id'          => 'fileupSel',
                             'placeholder' => "Ej. HBL/MBL/Factura",                             
                             'maxlength'   => '40')).'
             <b class="tooltip tooltip-bottom-right">Tipo de cambio</b>         
            </label>
        </section>
        <section class="col col-2"><label class="label">Tipo de Documento:</label>
            <label class="select"><i class="icon-append"></i>'.
             form_dropdown('segdoc', $segdoc, '0','id=\'segdoc\' ').'
             </label>
        </section>     
        <section class="col col-1">&nbsp;</section>
        <section class="col col-5">            
            <div id="mulitplefileuploader">&nbsp;Seleccionar archivo&nbsp;</div><br>
            <div id="status"></div>
        </section>
        </div>          
        <div class="row"> 
            <section class="col col-2">&nbsp;</section>
            <section class="col col-8"> <label class="subtitulo"><center>Documentos del Embarque</center></label> </section>
            <section class="col col-2">&nbsp;</section>
            </section>
        </div>              
        <div class="row" id="adjuntosDiv">';
echo '    <section class="col col-2">&nbsp;</section>';
        foreach($adjuntos as $a)
        { echo '<section class="col col-2" id="ad'.$a['id_adjunto'].'"> <label class="label">'.$a['desc_adjunto'].' - '.$a['SEGURIDAD'].'</label> <a href="'.base_url().$a['adjunto'].'" target="_blank"><img title="'.$a['desc_adjunto'].'" src="'.base_url().'images/fileIcon.png"></a><br><br>
                                                <img class="boton_confirm" title="Borrar Archivo"
                                                        name="'.$a['id_pedido'].'" id_adjunto="'.$a['id_adjunto'].'"
                                                        id="'.str_replace("adjuntos/".$a['id_pedido']."/","",$a['adjunto']).'" src="'.base_url().'/images/close.png"></section>';  }
echo '   </div>  ';
echo "<footer>";
//     <a class='button sub' href='javascript:submitFormAX(hrefF,\"DAA\",\"$id_pedido\",\"$accion\");'>Guardar Sección</a>
echo "      <span id='confirmDAA' class='msjconfirm'></span>
            <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
      </footer>";

 echo form_close();
 echo '</li>';
$costo_tot = $pedido["encabezado"][0]['costo_tot'];
$venta_tot = $pedido["encabezado"][0]['venta_tot'];
//***************** DOCS
 
/***********************FORMULARIO TRANSPORTE 
echo '<li class="sky-tab-content-5">';
echo form_open(base_url().'pedido/guardar/', array( 'id' => 'TRAN') );
echo '    
      <fieldset>';			
        $costo_t = $pedido["transporte"][0]['costo'];
        $venta_t = $pedido["transporte"][0]['venta'];
        $iva_t 	 = $pedido["transporte"][0]['iva'];
        $ivaStr	 = "";
        if ($iva_t =="1")
            { $ivaStr	 = "checked"; }
echo '<div class="row">
        <section class="col col-4">
            <label class="label">Costo <span class="monedaSpan"></span>: </label>
            <label class="input"><i class="icon-append fa fa-dollar"></i>'.
            form_input(array('class' 	=> 'validate[custom[number]] text-input costos', 
                            'name' 	=> 'costo_tt', 
                            'id' 	=> 'costo_tt',
                            'value'     => $costo_t,                            
                            'maxlength' => '11')).'
             <b class="tooltip tooltip-bottom-right">Costo del Transporte</b>
            </label>
        </section>
        <section class="col col-2">&nbsp;</section>
        <section class="col col-4">
            <label class="label">Venta <span class="monedaSpan"></span>: </label>
            <label class="input"><i class="icon-append fa fa-dollar"></i>'.
            form_input(array('class' 	=> 'validate[custom[number]] text-input ventas', 
                            'name' 	=> 'venta_tt', 
                            'id' 	=> 'venta_tt',
                            'value'     => $venta_t,                            
                            'maxlength' => '11')).'
             <b class="tooltip tooltip-bottom-right">Venta del Transporte</b>
            </label>
        </section>
        <section class="col col-2">&nbsp;</section>
      </div>
      <div class="row">
        <section class="col col-4">
            <label class="label">Salida del (aero)puerto: </label>
            <label class="input"><i class="icon-append fa fa-plane"></i>'.
            form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                            'name' 	=> 'salida_puerto', 
                            'id' 	=> 'salida_puerto',
                            'value'     => $pedido["transporte"][0]['salida_puerto'],
                            'size' 	=> '10',
                            'maxlength' => '50')).'
             <b class="tooltip tooltip-bottom-right">Salida del (aero)puerto</b>
            </label>
        </section>
        <section class="col col-4">&nbsp;</section>
        <section class="col col-4">&nbsp;</section>
      </div>
      <div class="row">
        <section class="col col-4">
            <label class="label">Maniobras </label>
            <label class="input"><i class="icon-append fa fa-dropbox"></i>'.
            form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                            'name' 	=> 'maniobras', 
                            'id' 	=> 'maniobras',
                            'value'     => $pedido["transporte"][0]['maniobras'],
                            'size' 	=> '10',
                            'maxlength' => '50')).'
             <b class="tooltip tooltip-bottom-right">Maniobras</b>
            </label>
        </section>
        <section class="col col-2">&nbsp;</section>
        <section class="col col-4">
            <label class="label">&iquest;El transporte regresar&uacute; vacio?</label>
            <label class="select"><i class="icon-append"></i>'.
             form_dropdown('regreso_v', $regreso_v, $pedido["transporte"][0]['id_regreso_v'],'id=\'regreso_v\' ').'
            </label>
        </section>
        <section class="col col-2">&nbsp;</section>
      </div>
      <div class="row">
        <section class="col col-4">
            <label class="label">Contacto de Recepci&oacute;n en Almac&eacute;n: </label>
            <label class="input"><i class="icon-append fa fa-male"></i>'.
            form_input(array('class' 	=> 'validate[custom[onlyLetterNumber]] text-input', 
                            'name' 	=> 'contacto_almacen', 
                            'id' 	=> 'contacto_almacen',
                            'value'     => $pedido["transporte"][0]['contacto_almacen'],                            
                            'maxlength' => '50')).'
             <b class="tooltip tooltip-bottom-right">Contacto de Recepci&oacute;n en Almac&eacute;n</b>
            </label>
        </section>
        <section class="col col-2">&nbsp;</section>
        <section class="col col-4">
            <label class="label">Fecha de entrega del almac&eacute;n</label>
            <label class="input"><i class="icon-append fa fa-calendar"></i>'.
            form_input(array('class' 	=> 'validate[required,custom[date]] text-input datepicker',
                            'name' 	=> 'entrega', 
                            'id' 	=> 'entrega',
                            'value'     => $pedido["transporte"][0]['entrega'],                            
                            'maxlength' => '11')).'
             <b class="tooltip tooltip-bottom-right">Fecha de entrega del almac&eacute;n</b>
            </label>
        </section>
        <section class="col col-2">&nbsp;</section>
      </div>
      </fieldset>
      <fieldset>
      <div class="row">
       <section class="col col-4">&nbsp;</section>
        <section class="col col-4"><label class="subtitulo">Seguro del Embarque</label></section>
        <section class="col col-4">&nbsp;</section>
        </div>
        <div class="row">
        <section class="col col-3">
            <label class="label">Costo <span class="monedaSpan"></span> </label>
            <label class="input"><i class="icon-append fa fa-dollar"></i>'.
            form_input(array('class' 	 => 'validate[custom[number]] text-input costos', 
                             'name' 	 => 'costo_s', 
                             'id' 	 => 'costo_s',
                             'value'     => $pedido["seguro"][0]['costo'],                                    
                             'maxlength' => '11')).'
             <b class="tooltip tooltip-bottom-right">Costo del seguro</b>
            </label>
        </section>
        <section class="col col-3">
        <label class="label">Venta <span class="monedaSpan"></span></label>
            <label class="input"><i class="icon-append fa fa-dollar"></i>'.
            form_input(array('class'    => 'validate[custom[number]] text-input ventas', 
                            'name' 	=> 'venta_s', 
                            'id' 	=> 'venta_s',
                            'value'     => $pedido["seguro"][0]['venta'],                            
                            'maxlength' => '11')).'
             <b class="tooltip tooltip-bottom-right">Venta del Seguro</b>
            </label>
            <input type="checkbox" name="iva_s" id="iva_s" value="1" '.$ivaStr.'/> más iva
        </section>
        <section class="col col-3">
            <label class="label">Cobertura</label>
            <label class="input"><i class="icon-append fa fa-bookmark"></i>'.
            form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                            'name'	=> 'cobertura', 
                            'id'        => 'cobertura',
                            'value'     => $pedido["seguro"][0]['cobertura'],                                        
                            'maxlength' => '50')).'
             <b class="tooltip tooltip-bottom-right">Cobertura del Seguro</b>
            </label>
        </section>
        <section class="col col-3">
            <label class="label">Poliza</label>
            <span id="polizaS">'.$celdaAdjuntos5.'</span>
        </section>
      </div>
     </fieldset>';    
    echo "<footer>
                <a class='button sub' href='javascript:submitFormAX(hrefF,\"TRAN\",\"$id_pedido\",\"$accion\");'>Guardar Sección</a>
                <span id='confirmTRAN' class='msjconfirm'></span>
                <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
             </footer>";    
    echo form_close();
    echo '</li>';
 ***********************FORMULARIO TRANSPORTE 
 */
//FORMULARIO RASTREO 
    echo form_input(array('name' => 'profitTRAN'            ,'id' =>'profitTRAN'            ,'type'=>'hidden','value' =>'0'))
        .form_input(array('name' => 'profit_origenTRAN'     ,'id' =>'profit_origenTRAN'     ,'type'=>'hidden','value' =>'0'))
        .form_input(array('name' => 'costo_tTRAN'           ,'id' =>'costo_tTRAN'           ,'type'=>'hidden','value' =>'0'))
        .form_input(array('name' => 'venta_tTRAN'           ,'id' =>'venta_tTRAN'           ,'type'=>'hidden','value' =>'0'))
        .form_input(array('name' => 'comision_ventasTRAN'  ,'id' =>'comision_ventasTRAN'  ,'type'=>'hidden','value' =>'0'))
        .form_input(array('name' => 'comision_operacionesTRAN','id' =>'comision_operacionesTRAN','type'=>'hidden','value' =>'0'));
echo '<li class="sky-tab-content-6">';
echo form_open(base_url().'pedido/guardar/', array( 'id' => 'TRAC') );    
echo '<div id="track">';
if ($pedido["rastreo"] == FALSE)
        {  $x = 0;
           echo '<div class="row">
              <section class="col col-2">
                <label class="label">Status </label>
                <label class="input"><i class="icon-append fa fa-road"></i>'.
                //form_dropdown('status'.$x,$status,$r["id_status"],'id="status'.$x.'" class="validate[custom[requiredInFunction]]"').'
                form_input(array('class'    => 'validate[required,custom[onlyLetterNumber]] text-input',
                                'name' 	    => 'status0', 
                                'id'        => 'status0',
                                'value'     => '',
                                'maxlength' => '80')).'
                </label>
            </section>
            <section class="col col-2">
                <label class="label">Descripci&oacute;n </label>'.
                 form_textarea(array('class'       => 'validate[custom[onlyLetterNumber]] text-input', 
                                  'name' 	 => 'descripcion0', 
                                  'id'        => 'descripcion0',                                  
                                  'rows'      => '2',
                                  'cols'      => '5',
                                  'style'     => 'width:100%',
                                  'maxlength' => '80')).'
            </section>
            <section class="col col-3">
                <label class="label">Observaciones </label>'.
                 form_textarea(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                     'name'      => 'observaciones0', 
                                     'id'        => 'observaciones0',
                                     'rows'      => '2',
                                     'cols'      => '5',
                                     'style'     => 'width:100%',
                                     'maxlength' => '80')).'
            </section>
            <section class="col col-2">
                <label class="label">Fecha Track </label>
                <label class="input"><i class="icon-append fa fa-calendar"></i>'.
                form_input(array('class'    => 'validate[required,custom[date]] text-input f_r',
                                'name' 	    => 'fecha_r0', 
                                'id' 	    => 'fecha_r0',                                
                                'maxlength' => '10')).'
                 <b class="tooltip tooltip-bottom-right">Fecha Track</b>
                </label>
            </section>
            <section class="col col-2"><label class="label">Enviar Notificación </label><input type="checkbox" name="noti_track0" id="noti_track0" value="1"></section>
            <section class="col col-1"><a href="javascript:addRowTrack(hrefF)"><img title="Agregar Status del Embarque" src="'.base_url().'images/new.png"/></a> 
                '.form_input(array('name' => 'num_track','type' =>'hidden','id' =>'num_track','value' =>'0')).'</section>
          </div>';
        }                                            
        else
        { $x = -1;
        foreach($pedido["rastreo"] as $r)
        {   
            $notiStr = $r["noti_track"] == "1" ? "checked" : "";
            $x = $x + 1;
            if($x == 0)
                { $ttvar_ag = '<a href="javascript:addRowTrack(hrefF)"><img title="Agregar Status del Embarque" src="'.base_url().'images/new.png"/></a>'; }
            else
                { $ttvar_ag = '<img title="Eliminar Track" class="btnDelete" src="'.base_url().'images/erase.png">'; }
            echo '<div class="row">
            <section class="col col-2">
                <label class="label">Status </label>
                <label class="input"><i class="icon-append fa fa-road"></i>'.
                //form_dropdown('status'.$x,$status,$r["id_status"],'id="status'.$x.'" class="validate[custom[requiredInFunction]]"').'
                form_input(array('class'    => 'validate[required,custom[onlyLetterNumber]] text-input',
                                'name' 	    => 'status'.$x, 
                                'id'        => 'status'.$x,
                                'value'     => $r["status_track"],                                
                                'maxlength' => '80')).'
                </label>
            </section>
            <section class="col col-2">
                <label class="label">Descripci&oacute;n </label>'.
                 form_textarea(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                     'name' 	 => 'descripcion'.$x, 
                                     'id'        => 'descripcion'.$x,
                                     'value'     => $r["descripcion"],
                                     'rows'      => '2',
                                     'cols'      => '5',
                                     'style'     => 'width:100%',
                                      'maxlength' => '80')).'
            </section>
            <section class="col col-3">
                <label class="label">Observaciones </label>'.
                form_textarea(array('class'    => 'validate[custom[onlyLetterNumber]] text-input', 
                                    'name'     => 'observaciones'.$x, 
                                    'id'       => 'observaciones'.$x,
                                    'value'    => $r["observaciones"],
                                   'rows'      => '2',
                                   'cols'      => '5',
                                   'style'     => 'width:100%',
                                   'maxlength' => '80')).'
            </section>
            <section class="col col-2">
                <label class="label">Fecha Track </label>
                <label class="input"><i class="icon-append fa fa-calendar"></i>'.
                form_input(array('class'    => 'validate[required,custom[date]] text-input f_r',
                                'name' 	    => 'fecha_r'.$x, 
                                'id'        => 'fecha_r'.$x,
                                'value'     => $r["fecha"],                                
                                'maxlength' => '10')).'
                <b class="tooltip tooltip-bottom-right">Fecha Track</b>
                </label>
            </section>
            <section class="col col-2"><label class="label">Enviar Notificación </label><input type="checkbox" name="noti_track'.$x.'" id="noti_track'.$x.'" value="1" '.$notiStr.'></section>
            <section class="col col-1">'.$ttvar_ag.'</section>
          </div>';                
        }// for each        
        }
echo form_input(array('name' => 'num_track', 'type' => 'hidden', 'id' => 'num_track','value' => $x))
     ."</div><footer>
                <a class='button sub' href='javascript:submitFormAX(hrefF,\"TRAC\",\"$id_pedido\",\"$accion\", false);'>Guardar Sección</a>
                <span id='confirmTRAC' class='msjconfirm'></span>
                <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
             </footer>";
echo form_close();
echo '</li>'; 
//FORMULARIO GANACIA 
echo '<li class="sky-tab-content-7">';
echo form_open(base_url().'pedido/guardar/', array( 'id' => 'PROF') );

$celda1    = ' <span id="costo_t_l" class="currency"></span>'
            .form_input(array('name' => 'costo_t','type'=>'hidden', 'id' =>'costo_t','value' =>$costo_tot)).  br(2);

$celda2    = ' <span id="venta_t_l" class="currency"></span>'
           .form_input(array('name' => 'venta_t','type'=>'hidden', 'id' =>'venta_t','value' =>$venta_tot)).  br(2);

           echo '<fieldset>      
           <div class="row">
           <section class="col col-1">&nbsp;</section>
             <section class="col col-3">
                 <label class="label">Costo Total <span class="monedaSpan"></span>: </label>
                 <label class="label">'. $celda1.' </label>
             </section>
             <section class="col col-1">&nbsp;</section>
             <section class="col col-3">
                 <label class="label">Venta Total <span class="monedaSpan"></span>: </label>
                 <label class="label">'. $celda2.' </label>
             </section>
             <section class="col col-1">&nbsp;</section>
             <section class="col col-3">';
     if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
     {
     echo '      <label class="label">Profit <span class="monedaSpan"></span>: </label>
                 <label class="input"><i class="icon-append fa fa-usd"></i>'.
                 form_input(array('class' 	 => 'validate[custom[number]] text-input', 
                                 'name' 	 => 'profit_origen', 
                                 'id' 	 => 'profit_origen',
                                 'size' 	 => '5',
                                 'value'     => $pedido["encabezado"][0]['profit_origen'],
                                 'maxlength' => '11')).'
                  <b class="tooltip tooltip-bottom-right">Profit</b>
                 </label>';
     }
     echo '  </section>
           </div>      
            </fieldset>';
     if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
     {
     echo '  <fieldset>
           <div class="row">
            <section class="col col-1">&nbsp;</section>         
            <section class="col col-3">
                 <label class="label">Comisión Ventas: </label>'.
                 PROCENTAJE_COMISION_VENTAS.' % <BR>           
                 <span id="comision_ventas_montoLabel"></span>'.form_input(array('name' => 'comision_ventas','type'=>'hidden', 'id' =>'comision_ventas','value' =>$pedido["encabezado"][0]['comision_ventas']))
                                                               .form_input(array('name' => 'comision_ventas_por','type'=>'hidden', 'id' =>'comision_ventas_por','value' =>PROCENTAJE_COMISION_VENTAS)).'
             </section>
             <section class="col col-1">&nbsp;</section>
             <section class="col col-3">
                 <label class="label">Comisión Operaciones: </label>'.
                 PROCENTAJE_COMISION_OPERACIONES.' % <BR>
                 <span id="comision_operaciones_montoLabel"></span>'.form_input(array('name' => 'comision_operaciones','type'=>'hidden', 'id' =>'comision_operaciones','value' =>$pedido["encabezado"][0]['comision_operaciones']))
                                                                    .form_input(array('name' => 'comision_operaciones_por','type'=>'hidden', 'id' =>'comision_operaciones_por','value' =>PROCENTAJE_COMISION_OPERACIONES)).'
             </section>
             <section class="col col-1">&nbsp;</section>
             <section class="col col-3">
                 <label class="label subtitulo">Profit Total<span class="monedaSpan"></span>: </label>
                 <label class="label subtitulo"><span id="profit" class="currency">$ 0</span>'.form_input(array('name' => 'profit_c','type'=>'hidden', 'id' =>'profit_c','value' =>'0')).' </label>
             </section>      
           </div>
            </fieldset>';
     }
    echo "<footer>";
    if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
       { echo "<a class='button sub' href='javascript:submitFormAX(hrefF,\"PROF\",\"$id_pedido\",\"$accion\", false);'>Guardar Sección</a>"; }
    echo "  <span id='confirmPROF' class='msjconfirm'></span>
            <a href='".base_url()."pedido/consulta/' class='button button-secondary'>Salir</a>
         </footer>\n"; 
    echo form_close();
    echo '    </il>';                   
    echo '    </ul>';                   
    echo '   </div>
    <!--/ tabs -->';    
    echo form_dropdown('terminoINCO',$terminosINCO,'0','id="terminoINCO" class="esconderINCO"');                  
    echo '   </div>';

    include("footer_admin.php"); 
?>  