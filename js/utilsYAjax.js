// JavaScript Document
var titAlert     = "SENNI LOGISTICS";
var fondoFlete   = "#1773B2";//#1773B2
var conceptosSAT = new Array();
var dtGrid		 = null;
var dtGridRN	 = null;

function submitForm(forma) 
{	
    $("#"+forma).validationEngine();
    if($("#"+forma).validationEngine('validate'))
       $("#"+forma).submit();		
}

function submitFormAX(baseURL, forma, id_in, accion, timbrarFactura)
{	
	var flagHeaderSaved = $("#flagHeaderSaved").val();
	if(forma !="ENC" && flagHeaderSaved ==="0")
		{ jAlert("Favor de guardar primero el encabezado del embarque antes que cualquier otra sección" ,titAlert); }
	else{
		$("#confirm"+forma).removeClass("msjOk").removeClass("msjErr").addClass("msjconfirm").html("").show();
		$("#"+forma).validationEngine();
		if($("#"+forma).validationEngine('validate'))
		{ 
		if(forma =="ENC") { var numtrack = $("#num_track").val(); $("#status_track").val($("#status"+numtrack).val());  }
		$.ajax({data      : $("#"+forma).serialize(),
				url       : baseURL+'pedido/guardar/'+id_in+'/'+accion+'/'+forma,
				type      : 'post',
				dataType  : 'json',
				beforeSend: function () { $("#confirm"+forma).removeClass("msjOk").addClass("msjconfirm");
										  $("#confirm"+forma).html("<img src=\""+baseURL+"images/loading.gif\"> Guardando seccion, espere por favor...");},
				success   : function (response) { 
										$("#confirm"+forma).removeClass("msjconfirm").addClass("msjOk");
										$("#confirm"+forma).html("<img src=\""+baseURL+"images/check.png\"> Seccion guardada exitosamente");
										$("#confirm"+forma).slideUp(12800);
										if(forma =="ENC")   { $("#flagHeaderSaved").val(1); }
									//	if (timbrarFactura) { timbrarAX(); }
										if(forma =="FLET")  { $("#fleteSalvado").val(1);	}
									}, 
				error     : function(xhr, textStatus, error)
								{ jAlert("Ha ocurrido un error al guardar la seccion: " + xhr.statusText + " " + textStatus+" "+error,titAlert); 
								$("#confirm"+forma).removeClass("msjconfirm").removeClass("msjOk").addClass("msjErr").html("<img src=\""+baseURL+"images/close.png\">Ocurrio un problema al guardar la seccion, intentelo mas tarde");}
			});
		}
	}//else flag
}


function submitFormContactoAX(baseURL,forma) 
{	
	$("#"+forma).validationEngine();
	
	if($("#"+forma).validationEngine('validate'))
	   	contactoAX(baseURL);
}
/* funcion de prueba para arreglar el problemas de la validacion por pestañas**/
function submitFormPedido() 
{
	if($("#pedido").validationEngine('validate'))
		$("#pedido").submit();					   			   
}

function submitFormFiltros(forma,controlador,numColGrid,registrosPagina,baseURL) 
{	
	$("#"+forma).validationEngine();                
	if($("#"+forma).validationEngine('validate'))	  
          paginarAX(controlador,numColGrid,1,registrosPagina,baseURL);
}

function submitFormFiltrosFacturas(forma, registrosPagina, baseURL) 
{	
	$("#"+forma).validationEngine();                
	if($("#"+forma).validationEngine('validate'))	  
	{
		paginarFacturasAX(1, registrosPagina, baseURL);
		toggFiltrosFac();
	}
}

function submitFormReset(forma)
{
    $('#'+forma).each (function(){
    this.reset();
    });
}

function calcularProfit()
{
  var v_costos	     = 0;
  var v_ventas	     = 0;
  var profit	     = 0;
  var com_ven        = 0;
  var com_ope        = 0;
  var fa_por_ventas  = Number($("#comision_ventas_por"     ).val());
  var fa_por_ope     = Number($("#comision_operaciones_por").val());
  var profit_origen  = Number($("#profit_origen"           ).val());
   
 
  $(".subCostos").each(function() { v_costos = v_costos + Number($(this).val()); });	  
  $(".subVentas").each(function() { v_ventas = v_ventas + Number($(this).val()); });
 
  profit   = v_ventas - v_costos - profit_origen;

  $("#costo_t_l").text("$ "+$.number(v_costos,2, '.', ',' ));
  $("#venta_t_l").text("$ "+$.number(v_ventas,2, '.', ',' ));

  $("#costo_t_l_f").text("$ "+$.number(v_costos,2, '.', ',' ));
  $("#venta_t_l_f").text("$ "+$.number(v_ventas,2, '.', ',' ));
  
  $("#costo_t").val(v_costos);
  $("#venta_t").val(v_ventas);
            
  com_ven = (fa_por_ventas/100) * profit;
  com_ven = com_ven.toFixed(3);
  profit  = profit - com_ven;
  $("#comision_ventas_montoLabel").html("$ "+$.number(com_ven, 2, '.', ',' ) );
  $("#comision_ventas"           ).val(com_ven);
  
  com_ope = (fa_por_ope/100) * profit;
  com_ope = com_ope.toFixed(3);
  profit  = profit - com_ope;
  $("#comision_operaciones_montoLabel").html("$ "+$.number(com_ope,2, '.', ',' ) );
  $("#comision_operaciones"           ).val(com_ope);
  
  $("#profit"  ).html("$ "+$.number(profit, 2, '.', ',' ) );    
  $("#profit_c").val(profit );
 
   asignaProfit_A_OtrasFormas('TRAN', v_costos, v_ventas);
   asignaProfit_A_OtrasFormas('FLET', v_costos, v_ventas);
   
}


function calcularFA()
{ 
  var v_costos	     = 0;
  var v_ventas	     = 0;
  var profit	     = 0;
  var fa_monto	     = 0;
  var fa_porcentaje  = $("#comision_ventas").val();
  var profit_origen  = Number($("#profit_origen").val());
   
 
  $(".costos").each(function() { v_costos = v_costos + Number($(this).val()); });	  
  $(".ventas").each(function() { v_ventas = v_ventas + Number($(this).val()); });
 
  profit   = v_ventas - v_costos - profit_origen;
         
  fa_monto = (fa_porcentaje/100) * profit;
  fa_monto = fa_monto.toFixed(3);
  profit   = profit - fa_monto;
  
  $("#profit"              ).html("$"+$.number(profit  ,2, '.', ',' ) );
  $("#comision_operaciones_l").html("$"+$.number(fa_monto,2, '.', ',' ) );
  
  $("#profit_c"          ).val(profit );
  $("#comision_operaciones").val(fa_monto );
  
  asignaProfit_A_OtrasFormas('TRAN', v_costos, v_ventas);
  asignaProfit_A_OtrasFormas('FLET', v_costos, v_ventas);
  
}

function asignaProfit_A_OtrasFormas(forma, costo, venta)
{
 $('#profit'+forma            ).val( $("#profit_c"     ).val() );
 $('#profit_origen'+forma     ).val( $("#profit_origen").val() );
 $('#costo_t'+forma           ).val( costo );
 $('#venta_t'+forma           ).val( venta );
 
 $('#comision_ventas'+forma   ).val( $("#comision_ventas"  ).val() );
 $('#comision_operaciones'+forma).val($("#comision_operaciones").val() );
}

function totalVentaServicio(servicio)
{ var v_ventas	     = 0; 

  $("."+servicio).each(function() { v_ventas = v_ventas + ( (isNaN($(this).val()))?0:Number($(this).val()) );  });
  $("#totalServicio"+servicio).html("$"+$.number(v_ventas, 2, '.', ',' ) );

  calcularProfit();
}

function totalCostoServicio(servicio)
{ var v_costos	     = 0; 

  $("."+servicio).each(function() { v_costos = v_costos + ( (isNaN($(this).val()))?0:Number($(this).val()) );  });
  $("#totalServicio"+servicio).html("$"+$.number(v_costos, 2, '.', ',' ) );

  calcularProfit();
}

function addRowProd(baseURL) {
		var num_prod = Number($("#num_prod").val()) + 1;	
		
		var myRow = '<div class="row">'+
            '<section class="col col-3">'+
            '    <label class="label">Producto: </label>'+
            '    <label class="input"><i class="icon-append fa fa-tag"></i>'+
            '    <input type="text" name="nombre'+num_prod+'" value="" class="validate[custom[onlyLetterNumber]] text-input" id="nombre'+num_prod+'" size="10" maxlength="50"/>'+
            '     <b class="tooltip tooltip-bottom-right">Nombre del producto solicitado</b>'+
            '    </label>'+
            '</section>'+
            '<section class="col col-3">'+
            '    <label class="label">Commodity: </label>'+
            '    <label class="input"><i class="icon-append fa fa-bars"></i>'+                
            '    <input type="text" name="commodity'+num_prod+'" value="" class="validate[custom[onlyLetterNumber]] text-input" id="commodity'+num_prod+'" size="10" maxlength="50"/>'+
            '     <b class="tooltip tooltip-bottom-right">Commity o Clasificaci&oacute;n del Producto</b>'+
            '    </label>'+
            '</section>'+
            '<section class="col col-2">'+
            '    <label class="label">Peso: </label>'+
            '     <label class="input"><i class="icon-append fa fa-tag"></i>'+                
            '    <input type="text" name="peso'+num_prod+'" value="" class="validate[custom[onlyLetterNumber]] text-input" id="peso'+num_prod+'" size="10" maxlength="50"/>'+                                 
            '     <b class="tooltip tooltip-bottom-right">Peso del producto en KG</b>'+
            '    </label>'+
            '</section>'+
            '<section class="col col-3">'+
            '    <label class="label">Volumen: </label>'+
            '    <label class="input"><i class="icon-append fa fa-cube"></i>'+                
            '    <input type="text" name="volumen'+num_prod+'" value="" class="validate[custom[onlyLetterNumber]] text-input" id="volumen'+num_prod+'" size="10" maxlength="50"/>'+
            '      <b class="tooltip tooltip-bottom-right">Volumen del producto en centimetros c&uacute;bicos</b>'+
            '     </label>'+
            ' </section>'+
            ' <section class="col col-1"><img title="Eliminar producto" class="btnDelete" src="'+baseURL+'images/erase.png"></section>'+
            '</div>';                                                
		
            $("#num_prod" ).val(num_prod);
            $("#productos").append(myRow);
            $(".btnDelete").bind("click", Delete);
            $('.btnDelete').addClass('pointer');
}

 function addRowTrack(baseURL) 
 {
        var num_track = Number($("#num_track").val()) + 1;
	var myRow = '<div class="row">'+            
            '<section class="col col-2">'+
            '    <label class="label">Status </label>'+
            '     <label class="input"><i class="icon-append fa fa-road"></i>'+            
            '     <input type="text" name="status'+num_track+'" value="" class="validate[required,custom[onlyLetterNumber]] text-input" text-input" id="status'+num_track+'" size="6" maxlength="80" />'+
            '    </label>'+
            '</section>'+
            '<section class="col col-2">'+
            '    <label class="label">Descripci&oacute;n </label>'+
            '    <textarea name="descripcion'+num_track+'" style = "width:100%" cols="5" rows="2" class="validate[custom[onlyLetterNumber]] text-input"   id="descripcion'+num_track+' size="8" maxlength="100" ></textarea> '+
            '</section>'+
            '<section class="col col-3">'+
            '    <label class="label">Observaciones </label>'+
            '    <textarea name="observaciones'+num_track+'" style = "width:100%" cols="5" rows="2" class="validate[custom[onlyLetterNumber]] text-input" id="observaciones'+num_track+'" size="8" maxlength="150" ></textarea> '+
            '</section>'+
            '<section class="col col-2">'+
            '    <label class="label">Fecha Track </label>'+
            '    <label class="input"><i class="icon-append fa fa-calendar"></i>'+
            '    <input type="text" name="fecha_r'+num_track+'" value="" class="validate[required,custom[date]]" text-input f_r" id="fecha_r'+num_track+'" size="8" maxlength="10" />'+
            '    <b class="tooltip tooltip-bottom-right">Fecha Track</b>'+
            '    </label>'+
            '</section>'+            
            '<section class="col col-2"><label class="label">Enviar Notificación </label><input type="checkbox" name="noti_track'+num_track+'" id="noti_track'+num_track+'" value="1"></section>'+
            '<section class="col col-1"><img title="Eliminar Track" class="btnDeleteTK" src="'+baseURL+'images/erase.png"></section'+
            '</div>';                                                

		var ant_track = num_track - 1;		
		$("#num_track").val(num_track);
		$("#track"    ).append(myRow);		
		$('#status'+num_track).append($('#status'+ant_track).html());
		$('#hora_r'+num_track).html($('#hora_r'+ant_track).html());
		
		$('#status'+num_track).val($('#status'+ant_track+' option:selected+option').val());
		$('#hora_r'+num_track).val($('#hora_r'+ant_track+' option:selected+option').val());
		
		$('#fecha_r'+num_track).val($('#fecha_r'+ant_track).val());
		
		$('.btnDeleteTK').addClass('pointer');	
		$('.btnDeleteTK').click(function() {
			var par = $(this).parent().parent();
                        jConfirm("¿Borrar registro de rastreo?",titAlert, function(r) { if(r) { var num_track = Number($("#num_track").val()) - 1;
                                                                                                $("#num_track").val(num_track);
                                                                                                par.remove();
                                                                                              }
                                                                                    });
			});			
		$(".f_r").datepicker({dateFormat: 'dd/mm/yy'});	
                $('#fecha_r'+num_track).datepicker({dateFormat: 'dd/mm/yy'});	
 }
 
function agregaServicioCoti(baseURL)
{
if($("#tipos_servicio").val() === "0")
{	
	jAlert("Favor de seleccionar un tipo de sevicio","Senni Logistics");
	$("#tipos_servicio").focus();
}
else
{
	var myTable 	 = "";
	var titulo 		 = "";
	var rowsConcepto = "";
	var rowsCargo 	 = "";
	var rowsTermino  = "";
	var rowsNota  	 = "";
	var numconceptos = 0;
	var numcargos    = 0;
	var numterminos  = 0;
	var numnotas     = 0;
	var moneda 		 = $('input:radio[name=moneda]:checked').val();
	
	ts = Number($("#tipos_servicio").val() );		
	switch (ts)
	{
	case 64:
		numconceptos = 1;
		numcargos	 = 3;
		numterminos  = 3;
		numnotas     = 12;
		titulo 		 = "FLETE ÁEREO";
		rowsConcepto = 	" <tr><td width='10%'></td>"+
		" <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep0' value='TIPO DE CARGA' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep0' size='25'  maxlength='100'/></label></td>"+
		" <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato0' value='' placeholder=' ' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato0' size='25'  maxlength='100'/></label></td>"+
		" <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"+
		" <tr><td width='10%'></td>"+
		" <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep1' value='CONTENEDOR' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep1' size='25'  maxlength='100'/></label></td>"+
		" <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato1' value='' placeholder='1*20' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato1' size='25'  maxlength='100'/></label></td>"+
		" <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>";
		/* Mayo 2021 cambio solicitado
		+
		" <tr><td width='10%'></td>"+
		" <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep2' value='DIMENSIONES' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep2' size='25'  maxlength='100'/></label></td>"+
		" <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato2' value='' placeholder='23X23X43' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato2' size='25'  maxlength='100'/></label></td>"+
		" <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"
		*/
	   ;
		rowsCargo 	 = " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo0' value='FLETE INTERNACIONAL' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo0' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe0' value='1' class='validate[required,custom[number]] text-input' id='"+ts+"importe0' size='8'  maxlength='10'/></label></section></td>"+
				  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva0' id='"+ts+"iva0' value='1' />más iva</td>"+
                                  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo1' value='FLETE NACIONAL' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo1' size='25' maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe1' value='1' class='validate[required,custom[number]] text-input' id='"+ts+"importe1' size='8'  maxlength='10'/></label></section></td>"+
                                  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva1' id='"+ts+"iva1' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo2' value='GASTOS EN ORIGEN' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo2' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe2' value='1' class='validate[required,custom[number]] text-input' id='"+ts+"importe2' size='8'  maxlength='10'/></label></section></td>"+
                                  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva2' id='"+ts+"iva2' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo3' value='GASTOS EN DESTINO' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo3' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe3' value='1' class='validate[required,custom[number]] text-input' id='"+ts+"importe3' size='8'  maxlength='10'/></label></section></td>"+
                                  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva3' id='"+ts+"iva3' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"
				  /* Mayo 2021 cambio solicitado
				  +
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo4' value='DOC FEE' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo4' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe4' value='' class='validate[required,custom[number]] text-input' id='"+ts+"importe4' size='8'  maxlength='10'/></label></section></td>"+
                                  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva4' id='"+ts+"iva4' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"
				  */;
		rowsNota   = " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota0' "+
				  "		value='Esta tarifa aplica para Mercancía General, No Peligrosa, Sin Sobredimensión, Sin Sobrepeso.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota0' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota1' "+
				  "		value='La presente cotización no incluye, maniobras portuarias, impuestos o fumigación., así como tampoco almacenaje, manejo de puerto, THC o"+ 
				  " algún otro cargo no mencionado, tanto en el origen como en destino.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota1' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota2' "+
				  "		value='La tarifa proporcionada está sujeta a cambios sin previo aviso, de acuerdo a los mercados internacionales por los cuales se rigen.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota2' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota3' "+
				  "		value='Tarifas sujetas a descripción final de la carga.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota3' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota4' "+
				  "		value='Tarifas sujetas a disponibilidad de equipo, espacio y aceptación.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota4' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota5' "+
				  "		value='Tarifas sujetas a restricciones internacionales de empaque y embalaje (NIMF15).' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota5' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota6' "+
				  "		value='Todas las cargas de origen animal y para consumo humano están sujetas a aceptación de manejo.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota6' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota7' "+
				  "		value='Tanto el flete terrestre como el despacho aduanal están sujetos al impuesto de valor agregado (IVA).' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota7' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota8' "+
				  "		value='Los tiempos de tránsito y frecuencias, corresponden a un servicio de línea regular, sin embargo estos pueden cambiar por causas de "+
				  " fuerza mayor sin previo aviso.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota8' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota9' "+
				  "		value='Quedamos exentos de todo cargo fuera de nuestro control o responsabilidad.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota9' size='60' maxlength='150'/></td>"+
          "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
          " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota10' "+
				  "		value='Toda mercancía que no sea notificada a SENNI LOGISTICS S.A de C.V, es responsabilidad del cliente, lo anterior engloba todo problema o sanción (fiscal, aduanal o de cualquier índole) impuesta por cualquier autoridad previamente, durante y posteriormente al despacho aduanal.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota10' size='60' maxlength='150'/></td>"+
          "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
          " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota11' "+
				  "		value='LAS COTIZACIONES NO INCLUYEN SEGURO DE CARGA NI GASTOS EN DESTINO. En caso de requerir SEGURO el valor es de 0.60% sobre valor aduana.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota11' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>" +
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota12' "+
				  "		value='Carga general no peligrosa.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota12' size='60' maxlength='150'/></td>"+
          		  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>" 
          ;
		rowsTermino = 	" <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'> INCOTERM <input type='hidden' name='"+ts+"termino0'  value='INCOTERM'  id='"+ts+"termino' /></td>"+
				  "   <td width='40%' align='center'><label class='select'><i class='icon-append'></i><select name='"+ts+"termino_dato0' id='"+ts+"termino_dato0' class='validate[custom[requiredInFunction]]' ></select> </label></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'> AOL <input type='hidden' name='"+ts+"termino1' value='AOL'  id='"+ts+"termino1'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato1' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato1' size='25' maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'> AOD <input type='hidden' name='"+ts+"termino2' value='AOD' id='"+ts+"termino2'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i></i><input type='text' name='"+ts+"termino_dato2' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato2' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'> TIEMPO EN TRANSITO <input type='hidden' name='"+ts+"termino3' value='TIEMPO EN TRANSITO' id='"+ts+"termino3'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato3' value='' class='validate[required,custom[number]] text-input' id='"+ts+"termino_dato3' size='22'  maxlength='10'/></label></section>días</td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"
				  /* Mayo 2021 cambio solicitado
				  +
				  "   <td width='40%' align='left'>ORIGEN <input type='hidden' name='"+ts+"termino4' value='ORIGEN' id='"+ts+"termino4'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato4' value='' placeholder='AICD' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato4' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>DESTINO <input type='hidden' name='"+ts+"termino5' value='DESTINO' id='"+ts+"termino5'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato5' value='' placeholder='TIJUANA' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato5' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"
				  */
				 ;  
	break;
	case 65:
		numconceptos = 1;
		numcargos	 = 3;
		numterminos  = 3;
		numnotas  	 = 17;
		titulo 		 = "FLETE MARITIMO";
		rowsConcepto = 	" <tr><td width='10%'></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep0' value='TIPO DE CARGA' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep0' size='25'  maxlength='100'/></label></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato0' value='' placeholder='CARGA GENERAL (Pañales)' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato0' size='25'  maxlength='100'/></label></td>"+
				  " <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"+
 				  " <tr><td width='10%'></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep1' value='CONTENEDOR' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep1' size='25'  maxlength='100'/></label></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato1' value='1X20DC' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato1' size='25'  maxlength='100'/></label></td>"+
				  " <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"
				  /* Mayo 2021 cambio solicitado
				  +
  				  " <tr><td width='10%'></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep2' value='CONTENEDOR' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep2' size='25'  maxlength='100'/></label></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato2' value='1X40DC' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato2' size='25'  maxlength='100'/></label></td>"+
				  " <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep3' value='DIMENSIONES' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep3' size='25'  maxlength='100'/></label></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato3' value='' placeholder='12X24X43' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato3' size='25'  maxlength='100'/></label></td>"+
				  " <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"
				  */
				 ;
				 rowsCargo 	 = " <tr>"+
				 "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo0' value='FLETE INTERNACIONAL ' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo0' size='25'  maxlength='100'/></label></td>"+
				 "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe0' value='1' class='validate[required,custom[number]] text-input ventas"+ts+"' id='"+ts+"importe0' size='8'  maxlength='10'/></label></section></td>"+
				 "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva0' id='"+ts+"iva0' value='1' />más iva</td>"+
								 "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				 " <tr>"+
				 "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo1' value='FLETE NACIONAL' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo1' size='25' maxlength='100'/></label></td>"+
				 "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe1' value='1' class='validate[required,custom[number]] text-input ventas"+ts+"' id='"+ts+"importe1' size='8'  maxlength='10'/></label></section></td>"+
								 "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva1' id='"+ts+"iva1' value='1' />más iva</td>"+
				 "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				 " <tr>"+
				 "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo2' value='GASTOS EN ORIGEN' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo2' size='25'  maxlength='100'/></label></td>"+
				 "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe2' value='1' class='validate[required,custom[number]] text-input ventas"+ts+"' id='"+ts+"importe2' size='8'  maxlength='10'/></label></section></td>"+
								 "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva2' id='"+ts+"iva2' value='1' />más iva</td>"+
				 "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				 " <tr>"+
				 "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo3' value='GASTOS EN DESTINO' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo3' size='25'  maxlength='100'/></label></td>"+
				 "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe3' value='1' class='validate[required,custom[number]] text-input ventas"+ts+"' id='"+ts+"importe3' size='8'  maxlength='10'/></label></section></td>"+
								 "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva3' id='"+ts+"iva3' value='1' />más iva</td>"+
				 "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>";
		rowsNota   = " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota0' "+
				  "		value='Esta tarifa aplica para Mercancía General, No Peligrosa, Sin Sobredimensión, Sin Sobrepeso.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota0' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota1' "+
				  "		value='La presente cotización no incluye, maniobras portuarias, impuestos o fumigación., así como tampoco almacenaje, manejo de puerto, THC o"+ 
				  " algún otro cargo no mencionado, tanto en el origen como en destino.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota1' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota2' "+
				  "		value='La tarifa proporcionada está sujeta a cambios sin previo aviso, de acuerdo a los mercados internacionales por los cuales se rigen.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota2' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota3' "+
				  "		value='Tarifas sujetas a descripción final de la carga.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota3' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota4' "+
				  "		value='Tarifas sujetas a disponibilidad de equipo, espacio y aceptación.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota4' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota5' "+
				  "		value='Tarifas sujetas a restricciones internacionales de empaque y embalaje (NIMF15).' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota5' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota6' "+
				  "		value='Todas las cargas de origen animal y para consumo humano están sujetas a aceptación de manejo.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota6' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota7' "+
				  "		value='Tanto el flete terrestre como el despacho aduanal están sujetos al impuesto de valor agregado (IVA).' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota7' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota8' "+
				  "		value='Los tiempos de tránsito y frecuencias, corresponden a un servicio de línea regular, sin embargo estos pueden cambiar por causas de "+
				  " fuerza mayor sin previo aviso.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota8' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota9' "+
				  "		value='Quedamos exentos de todo cargo fuera de nuestro control o responsabilidad.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota9' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota10' "+
				  "		value='La presente cotización cuenta con 21 días libres de demora.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota10' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota11' "+
				  "		value='Ingreso de Carta Garantía.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota11' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota12' "+
				  "		value='Peso máximo permitido en contenedor de 20 es de 19 toneladas.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota12' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota13' "+
				  "		value='Peso máximo permitido en contenedor de 40 es de 22 toneladas.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota13' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota14' "+
				  "		value='En caso de solicitar contenedor 'grado alimenticio - food grade', agregar Usd 100 + IVA por contenedor.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota14' size='60' maxlength='150'/></td>"+
          "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
          " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota15' "+
				  "		value='Toda mercancía que no sea notificada a SENNI LOGISTICS S.A de C.V, es responsabilidad del cliente, lo anterior engloba todo problema o sanción (fiscal, aduanal o de cualquier índole) impuesta por cualquier autoridad previamente, durante y posteriormente al despacho aduanal.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota15' size='60' maxlength='150'/></td>"+
          "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
          " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota16' "+
				  "		value='LAS COTIZACIONES NO INCLUYEN SEGURO DE CARGA NI GASTOS EN DESTINO. En caso de requerir SEGURO el valor es de 0.60% sobre valor aduana.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota16' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>" +
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota17' "+
				  "		value='Carga general no peligrosa.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota17' size='60' maxlength='150'/></td>"+
          		  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"
          ;
		rowsTermino = 	" <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>INCOTERM <input type='hidden' name='"+ts+"termino0'  value='INCOTERM'  id='"+ts+"termino0' /></td>"+
				  "   <td width='40%' align='center'><label class='select'><i class='icon-append'></i><select name='"+ts+"termino_dato0' id='"+ts+"termino_dato0' class='validate[custom[requiredInFunction]]' ></select> </label></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>POL <input type='hidden' name='"+ts+"termino1' value='POL'  id='"+ts+"termino1'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato1' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato1' size='25' maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>POD <input type='hidden' name='"+ts+"termino2' value='POD' id='"+ts+"termino2'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato2' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato2' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>TIEMPO EN TRANSITO <input type='hidden' name='"+ts+"termino3' value='TIEMPO EN TRANSITO' id='"+ts+"termino3'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato3' value='' class='validate[required,custom[number]] text-input' id='"+ts+"termino_dato3' size='22'  maxlength='10'/></label></section>días</td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>";
				  /*Mayo 2021 cambio solicitado
				  +
				  "   <td width='40%' align='left'>ORIGEN <input type='hidden' name='"+ts+"termino4' value='ORIGEN' id='"+ts+"termino4'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato4' value='' placeholder='AICD' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato4' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>DESTINO <input type='hidden' name='"+ts+"termino5' value='DESTINO' id='"+ts+"termino5'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato5' value='' placeholder='TIJUANA' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato5' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>";
				  */
	break;
	case 66:
		numconceptos = 1;
		numcargos	 = 2;
		numterminos  = 3;
		numnotas  	 = 22;
		titulo 		 = "FLETE TERRESTRE";
		rowsConcepto = " <tr><td width='10%'></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep0' value='TIPO DE CARGA' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep0' size='25'  maxlength='100'/></label></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato0' value='' placeholder='CARGA GENERAL' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato0' size='25'  maxlength='100'/></label></td>"+
				  " <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep1' value='CONTENEDOR' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep1' size='25'  maxlength='100'/></label></td>"+
				  " <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato1' value='' placeholder='2X34X34' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato1' size='25'  maxlength='100'/></label></td>"+
				  " <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>";                                                                                
		rowsCargo 	 = " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo0' value='FLETE INTERNACIONAL' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo0' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe0' value='1' placeholder='130.00' class='validate[required,custom[number]] text-input' id='"+ts+"importe0' size='8'  maxlength='10'/></label></section></td>"+
				  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva0' id='"+ts+"iva0' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo1' value='FLETE NACIONAL' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo1' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe1' value='1' placeholder='170.00' class='validate[required,custom[number]] text-input' id='"+ts+"importe1' size='8'  maxlength='10'/></label></section></td>"+
				  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva1' id='"+ts+"iva1' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo2' value='GASTOS EN ORIGEN' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo2' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe2' value='1' placeholder='100' class='validate[required,custom[number]] text-input' id='"+ts+"importe2' size='8'  maxlength='10'/></label></section></td>"+
				  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva2' id='"+ts+"iva2' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>"
				  " <tr>"+
				  "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo3' value='GASTOS EN DESTINO' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo3' size='25'  maxlength='100'/></label></td>"+
				  "   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe3' value='1' placeholder='100' class='validate[required,custom[number]] text-input' id='"+ts+"importe3' size='8'  maxlength='10'/></label></section></td>"+
				  "   <td width='23%'  align='center'><input type='checkbox' name='"+ts+"iva3' id='"+ts+"iva3' value='1' />más iva</td>"+
				  "   <td width='7%'  align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>";
		rowsNota   = " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota0' "+
				  "		value='Esta tarifa aplica para Mercancía General, No Peligrosa, Sin Sobredimensión, Sin Sobrepeso.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota0' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota1' "+
				  "		value='La presente cotización no incluye, maniobras portuarias, impuestos o fumigación., así como tampoco almacenaje, manejo de puerto, THC o"+ 
				  " algún otro cargo no mencionado, tanto en el origen como en destino.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota1' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota2' "+
				  "		value='La tarifa proporcionada está sujeta a cambios sin previo aviso, de acuerdo a los mercados internacionales por los cuales se rigen.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota2' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota3' "+
				  "		value='Tarifas sujetas a descripción final de la carga.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota3' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota4' "+
				  "		value='Tarifas sujetas a disponibilidad de equipo, espacio y aceptación.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota4' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota5' "+
				  "		value='Tarifas sujetas a restricciones internacionales de empaque y embalaje (NIMF15).' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota5' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota6' "+
				  "		value='Todas las cargas de origen animal y para consumo humano están sujetas a aceptación de manejo.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota6' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota7' "+
				  "		value='Tanto el flete terrestre como el despacho aduanal están sujetos al impuesto de valor agregado (IVA).' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota7' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota8' "+
				  "		value='Los tiempos de tránsito y frecuencias, corresponden a un servicio de línea regular, sin embargo estos pueden cambiar por "+
				  " causas de fuerza mayor sin previo aviso.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota8' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota9' "+
				  "		value='Quedamos exentos de todo cargo fuera de nuestro control o responsabilidad.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota9' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota10' "+
				  "		value='No Incluye maniobras de carga ni descarga.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota10' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota11' "+
				  "		value='La cotización anterior incluye rastreo satelital.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota11' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota12' "+
				  "		value='A los importes antes mencionados en moneda nacional se les incrementará el IVA.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota12' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota13' "+
				  "		value='El servicio debe ser pagado una vez la se haya cargado la unidad.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota13' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota14' "+
				  "		value='Solicitud del servicio con 24 hrs. De anticipación y enviando carta de instrucciones.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota14' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota15' "+
				  "		value='No incluye maniobras, demoras en carga - descarga.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota15' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota16' value='Unidades sujetas a disponibilidad de equipo en la zona en el momento de requerir el Servicio.' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota16' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota17' value='Las maniobras de carga y descarga, así como el seguro de la mercancía serán por cuenta y riesgo del cliente.' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota17' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota18' value='Si usted requiere asegurar su mercancía, este seguro tiene un costo del 2% del valor de su mercancía más IVA.' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota18' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota19' value='El seguro cubre robo total, robo parcial, volcadura, incendio y riesgos ordinarios de tránsito.' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota19' size='60' maxlength='150'/></td>"+
          "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
          " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota20' "+
				  "		value='Toda mercancía que no sea notificada a SENNI LOGISTICS S.A de C.V, es responsabilidad del cliente, lo anterior engloba todo problema o sanción (fiscal, aduanal o de cualquier índole) impuesta por cualquier autoridad previamente, durante y posteriormente al despacho aduanal.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota20' size='60' maxlength='150'/></td>"+
          "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"+
          " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota21' "+
				  "		value='LAS COTIZACIONES NO INCLUYEN SEGURO DE CARGA NI GASTOS EN DESTINO. En caso de requerir SEGURO el valor es de 0.60% sobre valor aduana.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota21' size='60' maxlength='150'/></td>"+
				  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>" +
				  " <tr><td width='10%'></td>"+
				  "  <td width='5%' align='right'><img src='"+baseURL+"images/nota.png'></td>"+
				  "  <td width='75%' align='left'><input type='text' name='"+ts+"nota22' "+
				  "		value='Carga general no peligrosa.' "+
				  "     class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota22' size='60' maxlength='150'/></td>"+
          		  "  <td width='10%'><img title='Eliminar Nota' class='"+ts+"btnDeleteNota' src='"+baseURL+"images/erase.png'></td></tr>"
          ;
		rowsTermino = 	" <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>INCOTERM <input type='hidden' name='"+ts+"termino0'  value='INCOTERM'  id='"+ts+"termino0' /></td>"+
				  "   <td width='40%' align='center'><label class='select'><i class='icon-append'></i><select name='"+ts+"termino_dato0' id='"+ts+"termino_dato0' class='validate[custom[requiredInFunction]]' ></select></label></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>ORIGEN <input type='hidden' name='"+ts+"termino1' value='ORIGEN'  id='"+ts+"termino1'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato1' value='' placeholder='Calle 8 de Blv. Querétaro No.9 Fracc. Viveros del Valle C.P. 54060 Tlalnepantla, Estado de México' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato1' size='25' maxlength='150'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>DESTINO <input type='hidden' name='"+ts+"termino2' value='DESTINO' id='"+ts+"termino2'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato2' value='' placeholder='Veracruz' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato2' size='25'  maxlength='100'/></label></section></td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>"+
				  " <tr><td width='10%'></td>"+
				  "   <td width='40%' align='left'>TIEMPO EN TRANSITO <input type='hidden' name='"+ts+"termino3' value='TIEMPO EN TRANSITO' id='"+ts+"termino3'/></td>"+
				  "   <td width='40%' align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato3' value='' class='validate[required,custom[number]] text-input' id='"+ts+"termino_dato3' size='22' maxlength='10'/></label></section>días</td>"+
				  "   <td width='10%'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr>";
	break;
};
	myTable = "<p></p>"+
			  "<input type='hidden' name='"+ts+"numconceptos' id='"+ts+"numconceptos' value='"+numconceptos+"'/>"+
			  "<input type='hidden' name='"+ts+"numcargos'    id='"+ts+"numcargos'    value='"+numcargos+"'/>"+
			  "<input type='hidden' name='"+ts+"numterminos'  id='"+ts+"numterminos'  value='"+numterminos+"'/>"+
			  "<input type='hidden' name='"+ts+"numnotas'     id='"+ts+"numnotas'     value='"+numnotas+"'/>"+
			  "<div class='row'>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "      <section class='col col-4'>"+
                          "        <label class='label'>Agregar saltos de Línea en esta sección en el PDF: </label>"+
                          "        <label class='input'><i class='icon-append fa fa-paragraph'></i> "+
                          "                 <input type='text' name='slServicios"+ts+"' value='' id='slServicios"+ts+"' class='validate[custom[number]] text-input' size='2' maxlength='5'> "+
                          "                 <b class='tooltip tooltip-bottom-right'>Ingresar el número de saltos de línea o 'enters' para logra un salto de página en la cotización o enviar la información desde este punto a una nueva hoja</b>"+
                          "        </label>"+
                          "      </section>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "</div>"+
			  "<table cellspacing='0' align='center' cellpadding='0' width='100%'>"+
			  "<tr><td width='17%'></td><td width='70%' align='center'>"+
			  "<table id='terminos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
 			  "<tr><td width='100%' colspan='4' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>"+titulo+"</td></tr>"+
			  "<tr><td width='10%'></td><td width='80%' colspan='2' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>TERMINOS</td>"+
			  "<td width='10%' align='center'> "+
			  " <img class='"+ts+"nuevoTermino' title='Agregar concepto al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
			  + rowsTermino +
			  "</table>"+
			  "<div class='row'>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "      <section class='col col-4'>"+
                          "        <label class='label'>Agregar saltos de Línea en esta sección en el PDF: </label>"+
                          "        <label class='input'><i class='icon-append fa fa-paragraph'></i> "+
                          "                 <input type='text' name='slTerminos"+ts+"' value='' id='slTerminos"+ts+"' class='validate[custom[number]] text-input' size='2' maxlength='5'> "+
                          "                 <b class='tooltip tooltip-bottom-right'>Ingresar el número de saltos de línea o 'enters' para logra un salto de página en la cotización o enviar la información desde este punto a una nueva hoja</b>"+
                          "        </label>"+
                          "      </section>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "</div>"+			  
			  "<table id='conceptos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
			  "<tr ><td width='10%'></td><td width='80%' colspan='2' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>DETALLE DEL EMBARQUE</td>"+
			  "<td width='10%' align='center'> "+
			  " <img class='"+ts+"nuevoConcepto' title='Agregar concepto al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
			  + rowsConcepto +
			  "</table>"+
			  "<div class='row'>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "      <section class='col col-4'>"+
                          "        <label class='label'>Agregar saltos de Línea en esta sección en el PDF: </label>"+
                          "        <label class='input'><i class='icon-append fa fa-paragraph'></i> "+
                          "                 <input type='text' name='slConceptos"+ts+"' value='' id='slConceptos"+ts+"' class='validate[custom[number]] text-input' size='2' maxlength='5'> "+
                          "                 <b class='tooltip tooltip-bottom-right'>Ingresar el número de saltos de línea o 'enters' para logra un salto de página en la cotización o enviar la información desde este punto a una nueva hoja</b>"+
                          "        </label>"+
                          "      </section>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "</div>"+			  
			  "<table id='cargos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
			  " <tr>"+
			  " <td width='45%' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>CONCEPTO</td>"+
			  " <td width='45%' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF'>IMPORTE EN <span id='monedaSpan'>"+moneda+"</span></td>"+
                          " <td width='3%'></td>"+
			  " <td width='7%' align='center'> "+
			  " <img class='"+ts+"nuevoCargo' title='Agregar cargo al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
			  + rowsCargo +				  
			  "</table>"+			  
			  "<div class='row'>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "      <section class='col col-4'>"+
                          "        <label class='label'>Agregar saltos de Línea en esta sección en el PDF: </label>"+
                          "        <label class='input'><i class='icon-append fa fa-paragraph'></i> "+
                          "                 <input type='text' name='slNotas"+ts+"' value='' id='slNotas"+ts+"' class='validate[custom[number]] text-input' size='2' maxlength='5'> "+
                          "                 <b class='tooltip tooltip-bottom-right'>Ingresar el número de saltos de línea o 'enters' para logra un salto de página en la cotización o enviar la información desde este punto a una nueva hoja</b>"+
                          "        </label>"+
                          "      </section>"+
                          "      <section class='col col-4'>&nbsp;</section>"+
                          "</div>"+				  
			  "<table id='notas"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
			  " <tr><td width='10%'></td>"+
			  " <td width='80%' align='center' style='font-weight:bold; background-color:#5B9BD5; color:#FFFFFF' colspan='2'>NOTAS</td>"+
			  " <td width='10%' align='center'>"+
			  "  <img class='"+ts+"nuevoNota' title='Agregar Nota del Servicio' src='"+baseURL+"images/new.png'/>"+
			  "  </td></tr>"
			  + rowsNota +
			  "</table><br><br>"+
			  "</td><td width='15%' valign='top'>"+
			  "<img title='Eliminar Servicio de "+titulo+"' class='"+ts+"btnDelete' src='"+baseURL+"images/deleteIcon.png'/>"+
			  "</td></tr></table>";
			  
	$("#servicio"+ts).html(myTable);
	
	habilitaBotonAgregar(ts,baseURL);
	habilitaBotonEliminar(ts,'btnDelete');
	habilitaBotonEliminar(ts,'btnDeleteConcepto');
  habilitaBotonEliminar(ts,'btnDeleteCargo');
  habilitaBotonEliminar(ts,'btnDeleteCargo');
	habilitaBotonEliminar(ts,'btnDeleteTermino');
	habilitaBotonEliminar(ts,'btnDeleteNota');
	
	copiaOpcionesSelect(ts);
	
	$("#"+ts+"termino_dato0").focus();
 }
}

function traeDatosCotiAX(id_coti,baseURL){
  var param = {"id_coti" : id_coti,"id_pedido" : $("#id_pedido").val() };
  $.ajax({
          data	  : param,
          url	  : baseURL+'cotizador/traeDatosCotiAX/',
          type	  : 'post',
          dataType  : 'json',
          beforeSend: function () 
                     { $("#cotiMensaje").html("<img src=\""+baseURL+"images/spin.png\"> Cargando Datos, espere por favor..."); },
          success   : function (response) 
                      {$("#cotiMensaje").html("");
                      var lenServicios = response.length;
                      var numconceptos = 0;
            var numcargos    = 0;
            var numcostos    = 0;
			var numterminos  = 0;					 
			var conceptos    = {};
			var cargos       = {};
			var terminos     = {};
			var titulo       = "";
			var ts           = "";
			var myTable      = "";
			var rowConceptos = "";
            var rowCargos    = "";
            var rowCostos    = "";
            var rowTerminos  = "";
            var rowFechas    = "";		
            var podHeader  	 = "";
			var polHeader  	 = "";
			var podCoti   	 = "";
			var polCoti    	 = "";				                    
			var bdModena     = $("#monedaOperaciones").val();
            var bdTC         = $("#tcOperaciones"    ).val(); 
            var moneda       = "";					
                      var tipoCambio 	 = "";					
                      var INCO         = "";					
                      
                      for (var x = 0; x < lenServicios; x++)
                      {   var t  = 0;
                          titulo = response[x]['servicio'];
                          ts     = response[x]['id_servicio'];						
  
                          if(response[x]['coti_conceptos'] !== false)													
                           { numconceptos = response[x]['coti_conceptos'].length; }
  
                          if(response[x]['coti_cargos'] !== false)
                           { numcargos   = response[x]['coti_cargos'].length; }
  
                          if(response[x]['coti_terminos'] !== false)
                           { numterminos  = response[x]['coti_terminos'].length; }
  
                          conceptos = response[x]['coti_conceptos'];
                          cargos    = response[x]['coti_cargos'];
                          terminos  = response[x]['coti_terminos'];
  
                          for (var i = 0; i < numconceptos; i++)
                          {  rowConceptos = rowConceptos+" <tr>"+
                              "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep"+i+"'        value='"+conceptos[i]['concepto']+"'    class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep"+i+"'      size='25' maxlength='100'/></label></td>"+
                              "   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato"+i+"' value='"+conceptos[i]['descripcion']+"' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato"+i+"' size='25' maxlength='100'/></label></td>"+
                              "   <td width='10%' align='center'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto' src='"+baseURL+"images/erase.png'></td></tr>";
                          }												
                          var y = 0;
                          for (var i = 0; i < numcargos; i++)
                          {  var ivaStr = "";
                          if (cargos[i]['iva'] === "1") { ivaStr = "checked"; }
                      
                          if (cargos[i]['tipo'] === "VENTA")
                          {
                            rowCargos = rowCargos+" <tr>"+
                            "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargoV"+i+"' value='"+cargos[i]['cargo']+"'   class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargoV"+i+"'   size='22' maxlength='100' ts='"+ts+"' index='"+i+"' /></label></td>"+
                            "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importeV"+i+"'    value='"+cargos[i]['importe']+"' class='validate[required,custom[number]] text-input ventas onlyNumber'    id='"+ts+"importeV"+i+"' size='8'  maxlength='12'   ts='"+ts+"' index='"+i+"' /></label></td>"+
                            "   <td width='15%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"unidadV"+i+"'     value='"+cargos[i]['unidad']+"'  class='validate[required,custom[number]] text-input unidadv onlyNumber'   id='"+ts+"unidadV"+i+"'  size='4'  maxlength='8'   ts='"+ts+"' index='"+i+"' /></label></td>"+
                            "   <td width='15%' align='center'><input type='hidden' name='"+ts+"statusV"+i+"' value='"+empty(cargos[i]['status'])+"' id='"+ts+"statusV"+i+"' /> "+empty(cargos[i]['status'])+"<span id='"+ts+"labelV"+i+"'></span><input type='hidden' name='"+ts+"subTotV"+i+"' value='"+cargos[i]['subtotal']+"' class='subVentas' id='"+ts+"subTotV"+i+"' /> </td>"+
                            "   <td width='3%' align='center'><input type='checkbox' name='"+ts+"ivaV"+i+"' id='"+ts+"ivaV"+i+"' value='1' "+ivaStr+" class='checBokFact' /> más iva</td>"+
                            "   <td width='7%' align='center'><img title='Eliminar Venta' class='"+ts+"btnDeleteCargo' src='"+baseURL+"images/erase.png'></td></tr>";                 
                          }
                          else{
                          numcostos++;
                          y++;
                          rowCostos = rowCostos+" <tr>"+
                          "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargoC"+y+"' value='"+cargos[i]['cargo']+"'   class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargoC"+y+"'   size='22' maxlength='100' ts='"+ts+"' index='"+y+"'/></label></td>"+
                          "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importeC"+y+"'    value='"+cargos[i]['importe']+"' class='validate[required,custom[number]] text-input costos onlyNumber'    id='"+ts+"importeC"+y+"' size='8'  maxlength='12'   ts='"+ts+"' index='"+y+"'/></label></td>"+
                          "   <td width='15%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"unidadC"+y+"'     value='"+cargos[i]['unidad']+"'  class='validate[required,custom[number]] text-input unidadc onlyNumber'   id='"+ts+"unidadC"+y+"'  size='4'  maxlength='8'   ts='"+ts+"' index='"+y+"'/></label></td>"+
                          "   <td width='15%' align='center'><span id='"+ts+"labelC"+y+"'></span><input type='hidden' name='"+ts+"subTotC"+y+"' value='"+cargos[i]['subtotal']+"' class='subCostos' id='"+ts+"subTotC"+y+"' /> </td>"+
                          "   <td width='3%' align='center'><input type='checkbox' name='"+ts+"ivaC"+y+"' id='"+ts+"ivaC"+y+"' value='1' "+ivaStr+" class='checBokFact' /> más iva</td>"+
                          "   <td width='7%' align='center'><img title='Eliminar Costo' class='"+ts+"btnDeleteCosto' src='"+baseURL+"images/erase.png'></td></tr>";
                          }
                        }
                  
                          for (t = 0; t < numterminos; t++)
                          {   var campo = "";
                              if( t === 0){
                                      campo = "<label class='select'><i class='icon-append'></i><select name='"+ts+"termino_dato"+t+"' id='"+ts+"termino_dato"+t+"' class='validate[custom[requiredInFunction]]'>"+$('#terminoINCO').html()+"</select></label>";
                                      INCO = terminos[t]['descripcion'];}
                              else{
                                  if( t === 3)
                                      { campo = "<label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato"+t+"' value='"+terminos[t]['descripcion']+"' class='validate[required,custom[number]] text-input' id='"+ts+"termino_dato"+t+"' size='25' maxlength='100'/></label>"; }
                                  else
                                      { campo = "<label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato"+t+"' value='"+terminos[t]['descripcion']+"' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato"+t+"' size='25' maxlength='100'/></label>"; }
                                 }
  
                              rowTerminos  = rowTerminos+" <tr>"+
                              " <td width='30%' align='left'  ><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"termino"+t+"' value='"+terminos[t]['termino']+"'class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino"+t+"' size='25' maxlength='100'/></label></td> "+
                              " <td width='30%' align='center'>"+campo+"</td> "+
                              " <td width='10%' align='center'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino' src='"+baseURL+"images/erase.png'></td></tr> ";
                          }
  
              moneda       = isEmpty( bdModena ) == true ? response[x]['moneda']['moneda'] : bdModena ;
                        tipoCambio   = isEmpty( bdTC     ) == true ? response[x]['moneda']['tipo_cambio'] : bdTC ;
                          var bdETD    = $("#etdOperacion").val();
                          var bdETA    = $("#etaOperacion").val();
                          var valueETD = isEmpty( bdETD )==true ? response[x]['fechas'][0]['etd'] : bdETD;
              var valueETA = isEmpty( bdETA )==true ? response[x]['fechas'][0]['eta'] : bdETA;
              
                          rowFechas = "<label class='label'>ETD:</label>"+
                                            "<label class='input'><i class='icon-append fa fa-calendar'></i>"+
                                            " <input type='text' name='etd' id='etd' value='"+valueETD+"' class='validate[required,custom[date]] text-input datepicker' size='8'  maxlength='30'  />"+
                                            " <b class='tooltip tooltip-bottom-right'>Ingresar la Fecha Estimada de Salida</b>"+
                                            "</label>"+                                          
                                            "<label class='label'>ETA:</label>"+
                                            "<label class='input'><i class='icon-append fa fa-calendar'></i>"+
                                            " <input type='text' name='eta' id='eta' value='"+valueETA+"' class='validate[required,custom[date]] text-input datepicker'  size='8' maxlength='30'  />"+
                                            " <b class='tooltip tooltip-bottom-right'>Ingresar la Fecha Estimada de llegada</b>"+
                                            "</label> <div class='note' id='ttNoteEta'></div>";
  
                          myTable =         "<input type='hidden' name='"+ts+"numconceptos' id='"+ts+"numconceptos' value='"+numconceptos+"'/>"+                                          
                        "<input type='hidden' name='"+ts+"numterminos'  id='"+ts+"numterminos'  value='"+numterminos+"'/>"+
                        "<legend id='togDetalleServicio' class='pointer'>[<i class='fa fa-plus' id='imgDetalleServicio'> </i>] Servicio Cotizado </legend><br>"+
                        "<div id='DetalleServicio'>"+
                                            "<table cellspacing='0' align='center' cellpadding='0' width='100%'>"+
                                            "<tr><td width='80%' align='center'>"+
                                            "<table id='terminos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
                                            "<tr><td width='100%' align='center' colspan='4' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>SERVICIO "+titulo+"</td></tr>"+
                        "<tr><td width='75%' colspan='3' align='center'  style='font-weight:bold; background-color:#FFFFFF; color:#FFFFFF'></td>"+
                                            "<td width='25%' rowspan='"+(t+1)+"' valign='middle' align='center'> "+
                                            " <img class='"+ts+"nuevoTermino' title='Agregar concepto al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
                                            + rowTerminos +
                                            "</table></br><br>"+
                                            "<table id='conceptos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
                                            "<tr ><td width='90%' align='center' colspan='2' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>DETALLE SERVICIO</td>"+
                                            "<td width='10%' align='center'> "+
                                            " <img class='"+ts+"nuevoConcepto' title='Agregar concepto al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
                                            + rowConceptos +
                        "</table></br><br>"+
                        "</td></tr></table>"+
                        "</div>"+	
                        "<input type='hidden' name='"+ts+"numcargos' id='"+ts+"numcargos' value='"+numcargos+"'/>"+
                                            "<input type='hidden' name='"+ts+"numcostos' id='"+ts+"numcostos' value='"+numcostos+"'/>"+
                                            "<table id='costos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
                                            " <tr>"+
                                            " <td width='30%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>CONCEPTO</td>"+
                                            " <td width='30%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>COSTO EN <span class='monedaSpan'>"+moneda+"</span></td>"+
                        " <td width='15%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>UNIDAD</td>"+
                        " <td width='15%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'></td>"+
                                            " <td width='10%' align='center' align='center'> "+
                        " <img class='"+ts+"nuevoCosto' title='Agregar Costo al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
                        + rowCostos +
                        "</table>"+
                                            " <table cellspacing='0' align='center' cellpadding='0' width='100%'><tr>"+
                                            " <td width='30%' align='center' style='font-weight:bold;'></td>"+
                                            " <td width='30%' align='center' style='font-weight:bold;' align='left'>TOTAL: <span id='costo_t_l_f' class='currency'></span> <span class='monedaSpan'></span></td>"+
                                            " <td width='15%' align='center' style='font-weight:bold;'></td>"+
                                            " <td width='15%' align='center' style='font-weight:bold;'></td>"+
                                            " <td width='10%' align='center' align='center'> </td></tr></table><br><br>"+
                                            "<table id='cargos"+ts+"' cellspacing='0' align='center' cellpadding='0' width='100%'>"+
                                            " <tr>"+
                                            " <td width='30%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>CONCEPTO</td>"+
                                            " <td width='30%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>VENTA EN <span class='monedaSpan'>"+moneda+"</span></td>"+
                        " <td width='15%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'>UNIDAD</td>"+
                        " <td width='15%' align='center' style='font-weight:bold; background-color:"+fondoFlete+"; color:#FFFFFF'></td>"+
                                            " <td width='10%' align='center' align='center'> "+
                                            " <img class='"+ts+"nuevoCargo' title='Agregar Venta al servicio' src='"+baseURL+"images/new.png'/></td></tr>"
                                            + rowCargos +				  
                                            "</table>"+
                                            " <table cellspacing='0' align='center' cellpadding='0' width='100%'><tr>"+
                                            " <td width='30%' align='center' style='font-weight:bold;'></td>"+
                                            " <td width='30%' align='center' style='font-weight:bold;' align='left'>TOTAL: <span id='venta_t_l_f' class='currency'></span> <span class='monedaSpan'></span></td>"+
                                            " <td width='15%' align='center' style='font-weight:bold;'></td>"+
                                            " <td width='15%' align='center' style='font-weight:bold;'></td>"+
                                            " <td width='10%' align='center' align='center'> </td></tr></table>";  
              
              $("#EtaEtd"     ).html(rowFechas);
              $("#servicio"+ts).html(myTable);
              $("#"+ts+"termino_dato0").val(INCO);
                          
              habilitaFechas(ts);
              var tt = $("#"+ts+"termino_dato3").val();
              $("#ttNoteEta").html("Tiempo en Transito "+tt);
  
              polCoti = $("#"+ts+"termino_dato1").val();
			  podCoti = $("#"+ts+"termino_dato2").val();

			  podHeader = $("#pod1").val();
			  polHeader = $("#pol" ).val();

 			  $("#pol" ).val(polHeader=="" ? polCoti : polHeader);
			  $("#pod1").val(podHeader=="" ? podCoti : podHeader);
              
              $("#DetalleServicio").toggle();
              $("#togDetalleServicio").click(function(){ var isHidden = $("#DetalleServicio").is(":hidden");                                    
                                    if(isHidden) { $("#imgDetalleServicio").removeClass("fa-plus" ).addClass("fa-minus" ); 
                                          $("#DetalleServicio").show();
                                          }
                                    else         { $("#imgDetalleServicio").removeClass("fa-minus").addClass("fa-plus"); 
                                          $("#DetalleServicio").hide();
                                          }                                                
                                });
              $("#togDetalleServicio").addClass("pointer");
            
                          habilitaBotonAgregarPedido(ts,baseURL);
                          habilitaBotonEliminar(ts,'btnDelete');
              habilitaBotonEliminar(ts,'btnDeleteConcepto');
              habilitaBotonEliminar(ts,'btnDeleteCosto');
                          habilitaBotonEliminar(ts,'btnDeleteCargo');
                          habilitaBotonEliminar(ts,'btnDeleteTermino');
                          habilitaBotonEliminar(ts,'btnDeleteNota');    				   						
  
                          rowConceptos = "";
                          rowCargos	 = "";
                          rowTerminos	 = "";
                          rowFechas	 = "";
                      }//for
                                     
                      habilitaCalculosVentasCostos();
                      $(".checBokFact").click(function (){ $("#fleteSalvado").val(0); }); 
                      $('.esconderMN' ).show();
                      $(".monedaSpan" ).html(moneda);
                      $("#tipo_cambio").val(tipoCambio);                    
                      if(moneda === "MXN"){
                              $("#tipo_cambio"    ).attr('class','validate[custom[number]] text-input');
                              $("input[value=MXN]").attr('checked',true);
                              $("input[value=USD]").attr('checked',false);}
                      else{
                              $("input[value=USD]").attr('checked',true);
                              $("input[value=MXN]").attr('checked',false);
                              $("#tipo_cambio"    ).attr('class','validate[required,custom[number]] text-input');}
          }, 
          error: function(err)
          {
              $("#cotiMensaje").html("");
              alert("Ha ocurrido un traeDatosCotiAX error: " + err.status + " " + err.statusText);
          }
  });					
  }

  function calculaSubTotal(objecto, campo, tipo)
  {
    var ts    = $(objecto).attr('ts');
    var index = $(objecto).attr('index');
    var value = Number($(objecto).val());
    var multi = Number($("#"+ts+campo+tipo+index).val());  
  
    $("#"+ts+"subTot"+tipo+index).val( value * multi);
    $("#fleteSalvado").val(0);
  
  }

function habilitaBotonEliminar(servicio,boton)
{
    $('.'+servicio+boton).addClass('pointer');
    $('.'+servicio+boton).click(function()
        {  var leyenda ="";
            switch (boton)
             {
                case 'btnDelete'        : leyenda = " el servicio completo";  break;
                case 'btnDeleteConcepto': leyenda = " Concepto del servicio"; break;
                case 'btnDeleteCargo'   : leyenda = " Cargo del servicio";    break;
                case 'btnDeleteCosto'   : leyenda = " Costo del servicio";    break;
                case 'btnDeleteTermino' : leyenda = " Termino del servicio";  break;
                case 'btnDeleteNota'    : leyenda = " Nota del servicio";     break;												
            }
            var tabla = $(this).parent().parent();                        
            jConfirm("¿Borrar "+leyenda+"?",titAlert, function(r) { if(r) { tabla.remove();
                                                                            if(boton === "btnDelete")
                                                                            {
                                                                                    $("#"+servicio+"numconceptos").val(0);
                                                                                    $("#"+servicio+"numcargos"   ).val(0);
                                                                                    $("#"+servicio+"numcotos"    ).val(0);
                                                                                    $("#"+servicio+"numterminos" ).val(0);
                                                                                    $("#"+servicio+"numnotas"    ).val(0);
                                                                            } 
                                                                            if(boton === "btnDeleteCargo") { totalVentaServicio("ventas"+servicio); }
																			                                      if(boton === "btnDeleteCosto") { totalCostoServicio("costos"+servicio); }
                                                                          }
                                                                         });			
       });		
}

function habilitaBotonAgregar(ts,baseURL)
{
	$("."+ts+"nuevoConcepto").addClass('pointer');
	$("."+ts+"nuevoConcepto").click(function()
		{
		  var nc = Number($("#"+ts+"numconceptos").val()) + 1;
		  var myRow = " <tr><td width='10%'></td>"+
			"   <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"concep"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep"+nc+"' size='25' maxlength='100'/></label></td>"+
			"   <td width='40%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep_dato"+nc+"' size='25' maxlength='100'/></label></td>"+
			"   <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto pointer' src='"+baseURL+"images/erase.png'></td></tr>";
		  $("#conceptos"+ts+" tr:last").after(myRow);
		  $("#"+ts+"numconceptos").val(nc);
		  habilitaBotonEliminar(ts,'btnDeleteConcepto');
		});

	$("."+ts+"nuevoCargo").addClass('pointer');
	$("."+ts+"nuevoCargo").click(function()
		{
		 var nc = Number($("#"+ts+"numcargos").val()) + 1;
		 var myRow = " <tr>"+
			"   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargo"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargo"+nc+"' size='25' maxlength='100'/></label></td>"+
			"   <td width='30%' align='center'><section class='col col-8'><label class='input'><i class='icon-append fa fa-usd'></i><input type='text' name='"+ts+"importe"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input ventas"+ts+"' id='"+ts+"importe"+nc+"' size='8' maxlength='10'/></label></section></td>"+
                        "   <td width='23%' align='center'><input type='checkbox' name='"+ts+"iva"+nc+"' id='"+ts+"iva"+nc+"' value='1' class='checBokFact'/>más iva</td>"+
			"   <td width='7%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteCargo pointer' src='"+baseURL+"images/erase.png'></td></tr>";
		 $("#cargos"+ts+" tr:last").after(myRow);
		 $("#"+ts+"numcargos").val(nc);
		 habilitaBotonEliminar(ts,'btnDeleteCargo');	
    $(".ventas"+ts).change(function(){ totalVentaServicio("ventas"+ts); });
		});

	$("."+ts+"nuevoTermino").addClass('pointer');
	$("."+ts+"nuevoTermino").click(function()
		{
		 var nc = Number($("#"+ts+"numterminos").val()) + 1;		 
		 var myRow = " <tr><td></td>"+
			"   <td align='left'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"termino"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino"+nc+"' size='25' maxlength='100'/></label></td>"+
			"   <td align='center'><section class='col col-11'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato"+nc+"' value=''  class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato"+nc+"' size='25' maxlength='100'/></label></section></td>"+
			"   <td align='center'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino pointer' src='"+baseURL+"images/erase.png'></td></tr>";
		 $("#terminos"+ts+" tr:last").after(myRow);
		 $("#"+ts+"numterminos").val(nc);
		habilitaBotonEliminar(ts,'btnDeleteTermino');
		});

	$("."+ts+"nuevoNota").addClass('pointer');
	$("."+ts+"nuevoNota").click(function()
		{
		 var nc = Number($("#"+ts+"numnotas").val()) + 1;
		 var myRow = " <tr><td></td>"+
			"   <td align='right'><img src='"+baseURL+"images/nota.png'></td>"+
			"   <td align='left'><input type='text' name='"+ts+"nota"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"nota"+nc+"' size='60' maxlength='150'/></td>"+
			"   <td><img title='Eliminar Nota' class='"+ts+"btnDeleteNota pointer' src='"+baseURL+"images/erase.png'></td></tr>";
		 $("#notas"+ts+" tr:last").after(myRow);
		 $("#"+ts+"numnotas").val(nc);
		habilitaBotonEliminar(ts,'btnDeleteNota');	
		});									
}

function totalVentaServicio(servicio)
{ var v_ventas	     = 0; 

  $("."+servicio).each(function() { v_ventas = v_ventas + ( (isNaN($(this).val()))?0:Number($(this).val()) );  });
  $("#totalServicio"+servicio).html("$"+$.number(v_ventas, 2, '.', ',' ) );

  calcularProfit();
}

function totalCostoServicio(servicio)
{ var v_costos	     = 0; 

  $("."+servicio).each(function() { v_costos = v_costos + ( (isNaN($(this).val()))?0:Number($(this).val()) );  });
  $("#totalServicio"+servicio).html("$"+$.number(v_costos, 2, '.', ',' ) );

  calcularProfit();
}

function habilitaBotonAgregarPedido(ts,baseURL)
{
	$("."+ts+"nuevoConcepto").addClass('pointer');
	$("."+ts+"nuevoConcepto").click(function()
		{
		  var nc = Number($("#"+ts+"numconceptos").val()) + 1;
		  var validar="onlyLetterNumber";
		  if(nc === 3)
			validar="number";			
		  var myRow = " <tr>"+
			"   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'>  </i><input type='text' name='"+ts+"concep"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"concep"+nc+"' size='25' maxlength='100'/></label></td>"+
			"   <td width='45%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"concep_dato"+nc+"' value='' class='validate[required,custom["+validar+"]] text-input' id='"+ts+"concep_dato"+nc+"' size='25' maxlength='100'/></label></td>"+
			"   <td width='10%'><img title='Eliminar Concepto' class='"+ts+"btnDeleteConcepto pointer' src='"+baseURL+"images/erase.png'></td></tr>";
		  $("#conceptos"+ts+" tr:last").after(myRow);
		  $("#"+ts+"numconceptos").val(nc);
		  habilitaBotonEliminar(ts,'btnDeleteConcepto');
		});

    $("."+ts+"nuevoCargo").addClass('pointer');
    $("."+ts+"nuevoCargo").click(function()
      {
       var nc = Number($("#"+ts+"numcargos").val()) + 1;                 
       var myRow = " <tr>"+
        "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargoV"+nc+"'   value=''  class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargoV"+nc+"'   size='22' maxlength='100' ts='"+ts+"' index='"+nc+"'/></label></td>"+
        "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i>     <input type='text' name='"+ts+"importeV"+nc+"' value=''  class='validate[required,custom[number]] text-input ventas onlyNumber'    id='"+ts+"importeV"+nc+"' size='8'  maxlength='12'  ts='"+ts+"' index='"+nc+"'/></label></td>"+
        "   <td width='15%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i> 	  <input type='text' name='"+ts+"unidadV"+nc+"'  value='1' class='validate[required,custom[number]] text-input unidadv onlyNumber'   id='"+ts+"unidadV"+nc+"'  size='8'  maxlength='8'   ts='"+ts+"' index='"+nc+"'/></label></td>"+
        "   <td width='15%' align='center'><input type='hidden' name='"+ts+"statusV"+nc+"' value='' id='"+ts+"statusV"+nc+"' /><span id='"+ts+"labelV"+nc+"'></span><input type='hidden' name='"+ts+"subTotV"+nc+"' value='0' class='subVentas' id='"+ts+"subTotV"+nc+"' /> </td>"+
        "   <td width='3%' align='center'><input type='checkbox' name='"+ts+"ivaV"+nc+"' id='"+ts+"ivaV"+nc+"' value='1' /> más iva</td>"+
        "   <td width='7%'><img title='Eliminar Venta' class='"+ts+"btnDeleteCargo pointer' src='"+baseURL+"images/erase.png'></td></tr>";
       $("#cargos"+ts+" tr:last").after(myRow);
       $("#"+ts+"numcargos").val(nc);
       habilitaBotonEliminar(ts,'btnDeleteCargo');	

       habilitaCalculosVentasCostos();
      });

    $("."+ts+"nuevoCosto").addClass('pointer');
    $("."+ts+"nuevoCosto").click(function()
      {
       var nc = Number($("#"+ts+"numcostos").val()) + 1;                 
       var myRow = " <tr>"+
        "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"cargoC"+nc+"'   value=''  class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"cargoC"+nc+"'   size='22' maxlength='100' ts='"+ts+"' index='"+nc+"'/></label></td>"+
        "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i>     <input type='text' name='"+ts+"importeC"+nc+"' value=''  class='validate[required,custom[number]] text-input costos onlyNumber'    id='"+ts+"importeC"+nc+"' size='8'  maxlength='12'  ts='"+ts+"' index='"+nc+"'/></label></td>"+
        "   <td width='15%' align='center'><label class='input'><i class='icon-append fa fa-usd'></i> 	  <input type='text' name='"+ts+"unidadC"+nc+"'  value='1' class='validate[required,custom[number]] text-input unidadc onlyNumber'   id='"+ts+"unidadC"+nc+"'  size='8'  maxlength='8'   ts='"+ts+"' index='"+nc+"'/></label></td>"+
        "   <td width='15%' align='center'><span id='"+ts+"labelC"+nc+"'></span><input type='hidden' name='"+ts+"subTotC"+nc+"' value='0' class='subCostos' id='"+ts+"subTotC"+nc+"' /> </td>"+
        "   <td width='3%' align='center'><input type='checkbox' name='"+ts+"ivaC"+nc+"' id='"+ts+"ivaC"+nc+"' value='1' /> más iva</td>"+
        "   <td width='7%'><img title='Eliminar Costo' class='"+ts+"btnDeleteCosto pointer' src='"+baseURL+"images/erase.png'></td></tr>";
       $("#costos"+ts+" tr:last").after(myRow);
       $("#"+ts+"numcostos").val(nc);
       habilitaBotonEliminar(ts,'btnDeleteCosto');	

       habilitaCalculosVentasCostos();

      });

	$("."+ts+"nuevoTermino").addClass('pointer');
	$("."+ts+"nuevoTermino").click(function()
            {
             var nc = Number($("#"+ts+"numterminos").val()) + 1;		 
             var myRow = " <tr>"+
                    "   <td width='30%' align='left'><label class='input'><i class='icon-append fa fa-bookmark'></i><input type='text' name='"+ts+"termino"+nc+"' value='' class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino"+nc+"' size='25' maxlength='100'/></label></td>"+
                    "   <td width='30%' align='center'><label class='input'><i class='icon-append fa fa-text-width'></i><input type='text' name='"+ts+"termino_dato"+nc+"' value=''  class='validate[required,custom[onlyLetterNumber]] text-input' id='"+ts+"termino_dato"+nc+"' size='25' maxlength='100'/></label></td>"+
                    "   <td width='10%' align='center'><img title='Eliminar Termino' class='"+ts+"btnDeleteTermino pointer' src='"+baseURL+"images/erase.png'></td></tr>";
             $("#terminos"+ts+" tr:last").after(myRow);
             $("#"+ts+"numterminos").val(nc);
            habilitaBotonEliminar(ts,'btnDeleteTermino');
            });							
}

function habilitaCalculosVentasCostos()
{
  soloNumeros();
  $(".costos" ).change(function(){ calculaSubTotal(this, "unidad" , "C"); calcularProfit(); });	 
  $(".ventas" ).change(function(){ calculaSubTotal(this, "unidad" , "V"); calcularProfit(); });
  $(".unidadc").change(function(){ calculaSubTotal(this, "importe", "C"); calcularProfit(); });
  $(".unidadv").change(function(){ calculaSubTotal(this, "importe", "V"); calcularProfit(); });					
  calcularProfit();
}

function copiaOpcionesSelect(ts)
{
    var optionsINCO = $("#terminoINCO option").clone();
    $("#"+ts+"termino_dato0").append(optionsINCO);	
    $("#"+ts+"termino_dato0").change(function(){abreCampoINCO(ts);});
}

function abreCampoINCO(ts)
{
	
}


function generaCotiPDFAX(baseURL)		
{
    $("#coti").validationEngine();
    if($("#coti").validationEngine('validate'))      
    $.ajax({
    url       : baseURL+'cotizador/generarPDFAX/',
    type      : 'post',
    data      : $('#coti').serialize(),
    dataType  : 'json',
    beforeSend: function () 
        { $("#generaCotiPDF").html("<img src=\""+baseURL+"images/spin.png\"> Generando Archivo, espere por favor...");},
    success:  function (response) 
                    {
                    var	iconF="<a href=\""+baseURL+"cotizador/download/"+response['cotizacion']+ "\" target=\"_blank\">"
                                      +"<img title=\"Ver Cotización generada con nombre "+response['cotizacion']+"\" "
                                      +"  src=\""+baseURL+"images/logoPDF.png\" width='40px' height='40px'></a><br><br>"
                                      +"&nbsp;&nbsp;&nbsp;&nbsp;<img class=\"boton_confirm\" title=\"Borrar Cotización\""
                                      +" id=\""+response['cotizacion']+"\" src=\""+baseURL+"/images/erase.png\">";

                    $("#generaCotiPDF").html(iconF);
                    $("#coti_pdf").val(response['cotizacion']);

                    $('.boton_confirm').addClass('pointer');	
                    $('.boton_confirm').click(function() { var id= $(this).attr('id');
                                                            jConfirm("¿Borrar Cotización en PDF?",titAlert, function(r) { if(r) { borraCotizacionAX(baseURL,id); }
                                                                                                                         });						
                            });
    }, 
                    error: function(err)
                    { alert("Ha ocurrido un error al genera Cotizacion PDF: " + err.status + " " + err.statusText); }
    });	
}


function generaPrefacturaPDFAX(baseURL)		
{	$('#id_pedidoFLET'    ).val($("#id_pedido").val());
        $('#num_mblFLET'      ).val($("#num_mbl").val() );
        $('#num_hblFLET'      ).val($("#num_hbl").val() );
        $('#vessel_voyageFLET').val($("#vessel_voyage").val() );
        $('#monedaFLET'       ).val($("#moneda").val() );
        $('#rfcFLET'          ).val($("#rfc").val() );   
       
        $.ajax({                
                url		  : baseURL+'pedido/generarPrefacturaPDFAX/',
                type	  : 'post',
				data	  : $('#FLET').serialize(),
				dataType  : 'json',
				beforeSend: function () 
				{$("#generaPrefacturaPDF").html("<img src=\""+baseURL+"images/spin.png\"> Generando Archivo, espere por favor...");},
                success:  function (response) 
				{	
					var	iconF="<a href=\""+baseURL+"pedido/downloadPF/"+response['preFactura']+ "\" target=\"_blank\">"
							  +"<img title=\"Ver Prefactura generada con nombre "+response['preFactura']+"\" "
							  +"  src=\""+baseURL+"images/logoPDF.png\" width='40px' height='40px'></a><br><br>"
							  +"&nbsp;&nbsp;&nbsp;&nbsp;<img class=\"boton_confirm\" title=\"Borrar PreFactura\""
							  +" id=\""+response['preFactura']+"\" src=\""+baseURL+"/images/erase.png\">";
							  
					$("#generaPrefacturaPDF").html(iconF);
					
					$('.boton_confirm').addClass('pointer');	
					$('.boton_confirm').click(function() {var id= $(this).attr('id');
                                                                              jConfirm("¿Borrar PreFactura en PDF?",titAlert, function(r) { if(r) { borraPFAX(baseURL,id); }
                                                                                                                                          });						
                                                                             });
                }, 
				error: function(err)
				{ $("#generaPrefacturaPDF").html('');alert("Ha ocurrido un error al generarala Prefactura: " + err.status + " " + err.statusText); }
        });	
}


function borraPFAX(baseURL,filename)
{
	var nombreArchivoStr = String(filename);
	var len 			 = nombreArchivoStr.length;
	var len_ext 		 = len-3; 
	var param 			 = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1)};
	
	$.ajax({ 
			data	: param,               
			url		: baseURL+'pedido/borraPFAX/',
			type	: 'post',
			dataType: 'json',                
			success	: function (response) 
			{ $("#generaPrefacturaPDF").html('');	}, 
			error: function(err)
			{alert("Ha ocurrido un error borraCotizacionAX: " + err.status + " " + err.statusText);}
	});	
}

function borraCotizacionAX(baseURL,filename)
{
	var nombreArchivoStr = String(filename);
	var len              = nombreArchivoStr.length;
	var len_ext          = len-3; 
	var param            = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1)};
	
	$.ajax({ 
			data	: param,               
			url	: baseURL+'cotizador/borraCotizacionAX/',
			type	: 'post',
			dataType: 'json',                
			success	: function (response) 
			{ $("#generaCotiPDF").html('');	}, 
			error: function(err)
			{alert("Ha ocurrido un error borraCotizacionAX: " + err.status + " " + err.statusText);}
	});	
}
		
function addRowDC(baseURL) {

		var num_dc = Number($("#num_dc").val()) + 1;

		var myRow = "<tr>"+
		"<td><section class=\"col col-11\"><label class=\"input\"><i class=\"icon-append fa fa-user\"></i><input type=\"text\" name=\"contacto"+num_dc+"\" value=\"\" class=\"validate[custom[onlyLetterNumber]] text-input\" "+
		" id=\"contacto"+num_dc+"\" placeholder = \"Ej. Juan Perez\" size=\"20\" maxlength=\"40\"/><b class=\"tooltip tooltip-bottom-right\">Nombre del contacto hasta 30 caracteres</b></label></section></td>"+
		" <td><section class=\"col col-11\"><label class=\"input\"><i class=\"icon-append fa fa-phone\"></i><input type=\"text\" name=\"tel"+num_dc+"\" value=\"\" class=\"validate[custom[phone]] text-input\" "+
		" id=\"tel"+num_dc+"\" placeholder = \"Ej. +1 (52) 768-2334 ext 703\" size=\"20\" maxlength=\"30\"/><b class=\"tooltip tooltip-bottom-right\">Tel&eacute;fono de contacto solo n&uacute;meros incluir lada: +1 (52) 768-2334 extension 703</b></label></section>  </td>"+
		" <td><section class=\"col col-11\"><label class=\"input\"><i class=\"icon-append fa fa-envelope-o\"></i><input type=\"text\" name=\"correo"+num_dc+"\" value=\"\" class=\"validate[custom[email]] text-input\" "+
		" id=\"correo"+num_dc+"\" placeholder = \"Ej. jp@test.com\" size=\"20\" maxlength=\"50\"/> <b class=\"tooltip tooltip-bottom-right\">Correo de contacto alternativo</b></label></section> </td>"+		
		" <td><img title=\"Eliminar producto\" class=\"btnDelete pointer\" src=\""+baseURL+"images/erase.png\"></td> "+
		"</tr>";
		
		$("#num_dc").val(num_dc);
		$("#contactos tr:last").after(myRow);
		$(".btnDelete").bind("click", Delete);		
}		
		
function Delete()
{
	var par = $(this).parent().parent();
        jConfirm("¿Borrar registro?",titAlert, function(r) { if(r) { par.remove(); }
                                                           });	
}	


function habilitaCarta(opcion,tipoAccion)
{
	if(opcion === "48")
			$('.esconder').show();
		else
		{
			if(tipoAccion === "N")
			{
				$("#carta_no").val("0");
				$("#monto_carta_no").val("");				
			}
			$('.esconder').hide();	
		}   
}


function validaCampoDuplicadoAX(tipo,campo,valor,baseURL){
        var param = {"tipo"  : tipo, 
                    "campo" : campo,
                    "valor" : valor  };
        $.ajax({
                data	  :  param,
                url	  :   baseURL+'gestion/validaCampoDuplicadoAX/',
                type	  :  'post',
		dataType  : 'json',
                beforeSend: function () 
				{ $("#valida"+campo).html("<img src=\""+baseURL+"images/spin.png\"> Validando "+campo+", espere por favor..."); },
                success:  function (response) 
				{
 				 $("#valida"+campo).html("");
				 
				if(response['duplicado'] === true)
				{
                                    var ligaDetalle = "";
                                    var ligaEditar  = "";
                                    var datoDuplicado ="";
                                    
                                    if(tipo === "usuarios" )
                                    { var cuenta = response['correo'];                                       
                                        ligaEditar   = "usuario/edita/"+cuenta.replace('@senni.com.mx','');
                                        datoDuplicado =  "Usuario Ingresado <a href=\""+baseURL+ligaEditar+"\">"+response['correo']
                                                        +"<img title=\"Editar "+tipo+"\" src=\""+baseURL+"images/edit.png\"></a>"
                                                        +"&nbsp;&nbsp;&nbsp;"
                                                        +"<img title=\"Cerrar Mensaje\" class=\"cerrarMenj\" src=\""+baseURL+"images/close.png\">";
                                    }
                                    else
                                    {
                                    if(tipo === "proveedor")
                                    {
                                        ligaDetalle = "proveedor/detalle/"+response['id_prove'];
                                        ligaEditar  = "proveedor/editar/"+response['id_prove'];
                                    }
                                    else
                                    {
                                        ligaDetalle = "gestion/dc/"+response['rfc'];
                                        ligaEditar  = "gestion/editacliente/"+response['rfc'];
                                        $("#correo_p").val('');
                                    }				 

                                    datoDuplicado = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" align=\"left\" cellpadding=\"0\">"
                                                    +"<tr><td valign=\"middle\">Datos ingresados:</td>"
                                                    +"<td>"+String(response['rfc'])+"<br>"+String(response['nombre'])
                                                    +"<br>"+String(response['correo'])
                                                    +"<br>"+String(response['calle'])+' #'+String(response['numero'])
                                                    +"<br>col. "+String(response['colonia'])+' CP '+String(response['cp'])
                                                    +"<br>Delegacion "+String(response['delegacion'])
                                                    +"<br>"+String(response['estado'])+' '+String(response['pais'])+"</td>"
                                                    +"<td>"+"<a href=\""+baseURL+ligaDetalle+"\">"
                                                    +"<img title=\"Detalle "+tipo+"\" src=\""+baseURL+"images/detail.png\"></a>"		
                                                    +"&nbsp;&nbsp;&nbsp;"
                                                    +"<a href=\""+baseURL+ligaEditar+"\">"
                                                    +"<img title=\"Editar "+tipo+"\" src=\""+baseURL+"images/edit.png\"></a>"
                                                    +"&nbsp;&nbsp;&nbsp;"
                                                    +"<img title=\"Cerrar Mensaje\" class=\"cerrarMenj\" src=\""+baseURL+"images/close.png\">"
                                                    +"</td></tr>"
                                                    +"</table>";
                                    }                                    
                                   
                                   $("#valida"+campo).html(campo+" dado de alta.Ingrese otra cuenta de correo.<br>"+datoDuplicado);
                                   $("#valida"+campo).show();

                                   $('.cerrarMenj').addClass('pointer');
                                   $('.cerrarMenj').click(function() 
                                     {
                                           $("#valida"+campo).hide();
                                           $("#valida"+campo).html("");						
                                     });
                                     $("#"+campo).val('');
				  }//if	  	
                }, 
				error: function(err)
				{
					$("#valida"+campo).html("");
					$("#"+campo).val("");
					alert("Ha ocurrido un error al validad duplicidad en "+tipo+", "+campo+": " + err.status + " " + err.statusText);
				}
        });
}

function validaCorreoAsignadoAX(correo,baseURL){
        var param = {"correo" : correo };//,"valorCaja2" : valorCaja2                
       
        $.ajax({
                data	  : param,
                url		  : baseURL+'gestion/validaRfccCorreoAX/',
                type	  : 'post',
				dataType  : 'json',
                beforeSend: function () 
				{ $("#validaCorreo").html("<img src=\""+baseURL+"images/spin.png\"> Validando Correo, espere por favor..."); },
                success:  function (response) 
				{					
				 var cliente = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" align=\"left\" "
				 			  +"  cellpadding=\"0\">"
							  +"<tr><td valign=\"middle\">Cuenta de correo asignada al cliente:</td>"
							  +"<td>"+String(response['rfc'])+"<br>"+String(response['cliente'])
							  +"<br>"+String(response['correo'])
							  +"<br>"+String(response['calle'])+' #'+String(response['numero'])
							  +"<br>col. "+String(response['colonia'])+' CP '+String(response['cp'])
							  +"<br>Delegacion "+String(response['delegacion'])
							  +"<br>"+String(response['estado'])+' '+String(response['pais'])+"</td>"
							  +"<td>"+"<a href=\""+baseURL+"gestion/dc/"+rfc+"\">"
							  +"<img title=\"Detalle Cliente\" src=\""+baseURL+"images/detail.png\"></a>"		
							  +"&nbsp;&nbsp;&nbsp;"
							  +"<a href=\""+baseURL+"gestion/editarCliente/"+rfc+"\">"
							  +"<img title=\"Editar Cliente\" src=\""+baseURL+"images/edit.png\"></a>"
							  +"&nbsp;&nbsp;&nbsp;"
							  +"<img title=\"Cerrar Mensaje\" class=\"cerrarMenjC\" "
							  +"      src=\""+baseURL+"images/close.png\">"
							  +"</td></tr>"
							  +"</table>";																												
					$("#validaCorreo").html("");
					if(response['duplicado'] === true)
					{
						$("#correo_principal").val('');						
						$("#validaCorreo").html("Correo asignado.<br>"+cliente);
						$("#validaCorreo").show();
					}
					$('.cerrarMenjC').addClass('pointer');
					$('.cerrarMenjC').click(function()
					  {
						$("#correo_principal").hide();
						$("#correo_principal").html("");						
					  });	
                }, 
				error: function(err)
				{
					$("#validaCorreo").html("");
					("#rfc").val("");
					alert("Ha ocurrido un error: " + err.status + " " + err.statusText);
				}
        });					
}

function traeDatosClienteCotiAX(id_coti,baseURL){
        var param = {"id_coti" : id_coti };
       
        $.ajax({
                data	  : param,
                url		  : baseURL+'cotizador/traeDatosClienteCotiAX/',
                type	  : 'post',
				dataType  : 'json',
                beforeSend: function () 
				{ $("#cotiMensaje").html("<img src=\""+baseURL+"images/spin.png\"> Cargando Datos, espere por favor..."); },
                success:  function (response) 
				{
					$("#cotiMensaje").html("");																																			
					$("#nombre_cliente").val(response['prosp_empresa']);
					$("#correo")	    .val(response['prosp_correo']);
					$("#contacto0")	    .val(response['prosp_nombre']);
					$("#tel0")	   	    .val(response['prosp_tel']);
					$("#correo0")		.val(response['prosp_correo']);
                        
					validaCampoDuplicadoAX("clientes","correo",response['prosp_correo'],baseURL);					
                },				
				error: function(err)
				{
					$("#cotiMensaje").html("");
					alert("Ha ocurrido un traeDatosClienteCotiAX error: " + err.status + " " + err.statusText);
				}
        });					
}

function habilitaFechas(ts)
{  
    $("#etd").datepicker({onSelect: function(){llegada(ts);},dateFormat: 'dd/mm/yy'}); //"#"+ts+"etd"
    $("#eta").datepicker({dateFormat: 'dd/mm/yy'}); //"#"+ts+"eta"
    $("#"+ts+"termino_dato3").change(function(){llegada(ts);});
    $("#"+ts+"termino_dato2").change(function(){llegada(ts);});        
}

function llegada(ts)
{
    var etd = $("#etd").datepicker("getDate");//"#"+ts+"etd"
    var tt = $("#"+ts+"termino_dato3").val();

    var dias = Number(tt);	

    if( etd !== null & isNaN(dias) === false)
     {
            var eta = new Date(etd);									

            eta.setDate(eta.getDate() + dias);
            $( "#eta" ).datepicker( "option", "minDate", eta );//"#"+ts+"eta"
            $( "#eta" ).datepicker( "setDate", eta );// "#"+ts+"eta"
     }

}

function traeNotificacionesAX(baseURL)		
{      
        $.ajax({                
                url     : baseURL+'gestion/notificacionesAX/',
                type    : 'post',
				dataType: 'json',                
                success : function (response) 
				{		
					var len = response.length;													
					var post, i;
					var liga = "";
					var param = "";					
					
					  for (var x = 0; x < len; x++)
					  {	
					    if(response[x]['tipo']==="retro")
							liga = "retro/noti/";
						else
							liga = "pedido/detalle/";
						var optionsN = {
							category:'projects',
							message: '<a href=\"'+baseURL+liga+response[x]['id_pedido']+'/noti/'+response[x]['tipo']+'\">'+
									  response[x]['descripcion']+'</a>'
						};
						notifications.createNotification(optionsN);
					  }					
                }, 
				error: function(err)
				{ alert("Ha ocurrido un error al traer las notificaciones: " + err.status + " " + err.statusText); }
        });	
}


function subirArchivo(hrefF)
{
var settings = 
{
	url		      : hrefF+"pedido/agregaArchivoAdjuntoAX",
	dragDrop	  : true,
	fileName	  : "myfile",
	allowedTypes: "jpg,png,gif,pdf,xml",	
	returnType	: "json",		
	onSuccess 	: function(files,data,xhr)
	{        
	  $(".ajax-file-upload-green").html("Guardar Archivo");
    $(".ajax-file-upload-green").before("<br>");
	  $(".ajax-file-upload-red"  ).html("Cancelar Archivo");		
	  $(".ajax-file-upload-green").attr( "id", "btnGuardarArchivo" );	  
	  $("#btnGuardarArchivo").click(function(){ if (isEmpty( $("#fileupSel").val() ) == true) 
                                                    {
                                                        jAlert("Favor ingresar un Nombre o Tipo de archivo", titAlert);							
                                                        $("#fileupSel").focus();
                                                    }
                                                    else
                                                      if (Number($("#segdoc").val()) === 0)
                                                      {
                                                          jAlert("Favor de seleccionar una opción del Tipo de Documento", titAlert);							
                                                          $("#segdoc").focus();
                                                      }
                                                      else
                                                      { renombraAdjuntoAX(hrefF, data, $("#id_pedido").val(), $("#fileupSel").val(), $("#segdoc").val() ); }
                                                  });
	},
	showDelete:true,
	deleteCallback: function(data,pd)
	{
		for(var i=0;i<data.length;i++)
		{
			$.post(hrefF+"pedido/borraArchivoAdjuntoAX",{op:"delete",name:data[i]},
			function(resp, textStatus, jqXHR)
				{ $("#status").html("<div>Archivo Borrado</div>"); });//.append("<div>Archivo Borrado</div>")
		}      
		pd.statusbar.hide(); //You choice to hide/not.
	}
};

var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

}

function renombraAdjuntoAX(baseURL,nombreArchivo, id_pedido, nombreTipoArchivo, tipoDoc)		
{   var nombreArchivoStr = String(nombreArchivo);
    var extensionStr     = String(nombreArchivo);
    var len              = nombreArchivoStr.length;
    var len_ext          = len-3; 
    var param = {"nombreArchivo"    : nombreArchivoStr.substring(0, len_ext-1),
                 "extension"        : extensionStr.substring(len_ext,len), 
                 "id_pedido"        : id_pedido, 
                 "nombreTipoArchivo": nombreTipoArchivo,
                 "tipoDoc"          : tipoDoc};
    
    $.ajax({data	  : param,               
            url	    : baseURL+'pedido/renombraAdjuntoAX/',
            type	  : 'post',
            dataType: 'json',
            success : function (response) 
                        {	var iconF = "<section class='col col-2' id='ad"+response['id_adjunto']+"'> <label class='label'>"+response['desc_adjunto']+" - "+tipoDoc+"</label> <a href=\""+baseURL+"adjuntos/"+response['id_pedido']+"/"+response['nombreSenni']+"\" target=\"_blank\">"
                                        +"<img title=\"Ver Archivo\" src=\""+baseURL+"images/fileIcon.png\"></a><br><br>"
                                        +"<img class='boton_confirm' title='Borrar Archivo'"
                                        +"     name='"+response['id_pedido']+"' id_adjunto='"+response['id_adjunto']+"' "
                                        +"     id='"+response['nombreSenni']+"' src='"+baseURL+"/images/close.png'></section>";
                          $('#adjuntosDiv'  ).append(iconF);
                          $('#fileupSel'    ).val('');
                          $('#segdoc'       ).val(0);
                          $('.boton_confirm').addClass('pointer');	
                          $('.boton_confirm').click(function() {  var id     = $(this).attr('id');
                                                                    var name   = $(this).attr('name');
                                                                    var opcion = $(this).attr('opcion');
                                                                    var id_adj = $(this).attr('id_adjunto');
                                                                    jConfirm("¿Borrar documento?",titAlert, function(r) { if(r) {borraAdjuntoCargadoAX(baseURL, id, name, opcion, id_adj); } });
                                                                 });
                        }, 
            error: function(err)
                        {alert("Ha ocurrido un error al traer las renombraAdjuntoAX: " + err.status + " " + err.statusText);}
    });			
}


function borraAdjuntoCargadoAX(baseURL,nombreArchivo,id_pedido,opcionTA, id_adj)
{    	
    var nombreArchivoStr = String(nombreArchivo);
    var extensionStr     = String(nombreArchivo);
    var len              = nombreArchivoStr.length;
    var len_ext          = len-3; 
    
    var param = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
                 "extension"     : extensionStr.substring(len_ext,len), 
                 "id_pedido"     : id_pedido, 
                 "opcionTA"      : opcionTA,
                 "id_adjunto"    : id_adj};    
    $.ajax({data    : param,               
            url     : baseURL+'pedido/borraAdjuntoCargadoAX/',
            type    : 'post',
            dataType: 'json',                
            success : function (response) 
                    {  $("#ad"+id_adj).remove();
                    }, 
            error: function(err)
            {alert("Ha ocurrido un error borraAdjuntoCargadoAX: " + err.status + " " + err.statusText);}
    });			
}


function subirPlantilla(hrefF)
{
var settings = 
{
	url		: hrefF+"gestion/agregarPlantillaAX",
	dragDrop	: true,
	fileName	: "myfile",
	allowedTypes    : "jpg,png,gif,pdf,xml,doc,docx,ppt,pptx,xls,xlsx",	
	returnType	: "json",		
	onSuccess 	: function(files,data,xhr)
	{        
	  $(".ajax-file-upload-green").html("Guardar Plantilla");
	  $(".ajax-file-upload-red").html("Cancelar Plantilla");
		
	  $(".ajax-file-upload-green").attr( "id", "btnGuardarArchivo" );	  
	  $("#btnGuardarArchivo").click(function(){ renombrarPlantillaAX(hrefF, data); });							
	},
	showDelete:true,
	deleteCallback: function(data,pd)
	{
		for(var i=0;i<data.length;i++)
		{
			$.post(hrefF+"gestion/borrarPlantillaAX",{op:"delete",name:data[i]},
			function(resp, textStatus, jqXHR)
				{ $("#status").html("<div>Plantilla Borrada</div>"); });
		}      
		pd.statusbar.hide(); 
	}
}
	
var uploadObj = $("#mulitplefileuploader").uploadFile(settings);

}

function renombrarPlantillaAX(baseURL,nombreArchivo)
{    	
        var nombreArchivoStr = String(nombreArchivo);
        var extensionStr     = String(nombreArchivo);
        var len 	     = nombreArchivoStr.length;
        var len_ext 	     = len-3; 
        
        if (nombreArchivoStr.substring(len_ext-1, len_ext) != ".")
            len_ext = len-4; 
        
        var param = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
                     "extension"     : extensionStr.substring(len_ext,len)
                    };                          
      
        $.ajax({ 
		data	: param,               
                url	: baseURL+'gestion/renombrarPlantillaAX/',
                type	: 'post',
		dataType: 'json',                
                success : function (response) 
				{		
					var	iconP="<img class='boton_confirm' title='Borrar Plantilla' id='"+response['nombreSenni']+"' src='"+baseURL+"/images/close.png'> &nbsp;&nbsp;&nbsp;&nbsp;"+
                                                      " <a title='Material SENNI Logistics' href='"+baseURL+response['link']+"'> "+
                                                      " <img title='Material SENNI Logistics' src='"+baseURL+"images/fileIcon.png'>  "+response['nombreSenni']+"</a><br><br>";
						  
					$('#documentos tr:last').after('<tr><td>'+iconP+'</td></tr>');
					
					$('.boton_confirm').addClass('pointer');	
					$('.boton_confirm').click(function() {  var id     = $(this).attr('id');
                                                                                var object = $(this);
                                                                                jConfirm("¿Borrar plantilla?",titAlert, function(r) { if(r) { borrarPlantillaCargadoAX(baseURL,id,object); }
                                                                                                                                   });
                                                                             });		
		
                }, 
				error: function(err)
			    {alert("Ha ocurrido un error al traer las renombrarPlantillaAX: " + err.status + " " + err.statusText);}
        });			
}

function borrarPlantillaCargadoAX(baseURL,nombreArchivo,object)
{    	
	var nombreArchivoStr = String(nombreArchivo);
        var extensionStr     = String(nombreArchivo);
        var len 	     = nombreArchivoStr.length;        
        var len_ext 	     = len-3; 
        
        if (nombreArchivoStr.substring(len_ext-1, len_ext) != ".")
            len_ext = len-4;         
        
        var param = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
                     "extension"     : extensionStr.substring(len_ext,len)
                    };
        
        $.ajax({ 
		data	: param,               
                url     : baseURL+'gestion/borraPlantillaCargadaAX/',
                type	: 'post',
		dataType: 'json',
                success : function () 
                                { $(object).parent().parent().remove(); }, 
		error   : function(err)
				{ alert("Ha ocurrido un error borraAdjuntoCargadoAX: " + err.status + " " + err.statusText);}
        });			
}

/*******************
 * Firma Digital INI
 *******************/
function subirFirma(hrefF)
{
var settings = 
{
	url		: hrefF+"usuario/agregaFirmaAX",
	dragDrop	: true,
	fileName	: "myfile",
	allowedTypes    : "jpg,png,gif,pdf",
	returnType	: "json",		
	onSuccess 	: function(files,data,xhr)
	{        
	  $(".ajax-file-upload-green").html("Guardar Firma");
	  $(".ajax-file-upload-red"  ).html("Cancelar Firma");
		
	  $(".ajax-file-upload-green").attr( "id", "btnGuardarFirma" );
	  $("#btnGuardarFirma").click(function(){ $("#statusFirma").html("<div><img src=\""+hrefF+"images/upload.jpg\"> Cargando Firma...</div>");
                                                     renombraFirmaAX(hrefF, data); 
                                                   });
	},
	showDelete:true,
	deleteCallback: function(data,pd)
	{
            for(var i=0;i<data.length;i++)
            {
                    $.post(hrefF+"usuario/borraImagenAX",{op:"delete",name:data[i]},
                    function(resp, textStatus, jqXHR)
                            { $("#statusClientLogo").html("<div>Firma Borrada</div>"); });
            }      
            pd.statusbar.hide(); 
	}
};
	
$("#mulitplefileuploaderFirma").uploadFile(settings);

}

function renombraFirmaAX(baseURL,nombreArchivo)		
{    	
    var nombreArchivoStr = String(nombreArchivo);
    var extensionStr	 = String(nombreArchivo);
    var len 		 = nombreArchivoStr.length;
    var len_ext 	 = len-3;
    var cuenta           = String($("#correo").val());    
    var param = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
		 "extension"	 : extensionStr.substring(len_ext,len),
                 "cuenta"        : cuenta.replace('@senni.com.mx','')   };             
    $.ajax({ 
            data    : param,               
            url     : baseURL+'usuario/renombraFirmaAX/',
            type    : 'post',
            dataType: 'json',                
            success : function (response) 
                            {	$("#statusFirma").html("");
                                
                                var iconImage="<img title=\"Firma Digitalizada \" width='142' height='172'  src=\""+baseURL+response['nombreSL']+"\" ></a><br>"
                                             +"<img class=\"boton_confirm\" title=\"Borrar archivo adjunto \" name='"+response['hImg']+"'" 
                                             +" id=\""+response['hImg']+"\" src=\""+baseURL+"/images/close.png\"><br>";
                                $('#Firma').html(iconImage);
                                $('#firmaNueva').val(response['hImg']);
                                $('.boton_confirm').addClass('pointer');	
                                $('.boton_confirm').click(function() {  var id     = $(this).attr('id');
                                                                        var object = $(this);
                                                                        jConfirm("¿Borrar Firma digitalizada?",titAlert, function(r) { if(r) { borraFirmaCargadaAX(baseURL,id,object); }
                                                                                                                                     });
                                                                     });
            }, 
            error   : function(err) { jAlert("Ha ocurrido un error al renombraAdjuntoAX: " + err.status + " " + err.statusText,''); }
    });			
}


function borraFirmaCargadaAX(baseURL,objectFile)
{    	        
	var nombreArchivoStr = String($(objectFile).attr('id'));
        var extensionStr     = String($(objectFile).attr('id'));
        var len 	     = nombreArchivoStr.length;
        var len_ext 	     = len-3;
        var cuenta           = String($("#correo").val());
        var param            = {"nombreArchivo" : nombreArchivoStr.substring(0, len_ext-1),
                                "extension"     : extensionStr.substring(len_ext,len),
                                "cuenta"        : cuenta.replace('@senni.com.mx','')   };
        $.ajax({data	: param,               
                url     : baseURL+'usuario/borraFirmaCargadaAX/',
                type	: 'post',
		dataType: 'json',
                success : function (response) { $('#Firma').html('');}, 
		error   : function (err)      { alert("Ha ocurrido un error borraImagenCargadaFotoPortadaAX: " + err.status + " " + err.statusText,titAlert); }
               });
}
/**********************
 * Firma Digital FIN
 **********************/




function recuperarPwd()
{
	
	  $("#closePWD" ).position({        
        my: "right-8 top",
        at: "right-8 top",
        of: "#recuperarPwd"
      });
	  $('#closePWD').addClass('pointer');
	  $('#closePWD').click(function()
		{
			$("#leyendaPWD").html("");
			$("#userRec").val("");
			$('#recuperarPwd').hide('Fold');
				$("#recuperarPwd" ).position({        
					  my: "left0 top0",
					  at: "left0 top0",
					  of: "#recuperarPwd"
				  });
				  $("#closePWD" ).position({        
					my: "right-8 top",
        			at: "right-8 top",
			        of: "#recuperarPwd"
				  });
		});	
 	$('#recuperarPwd').show('Drop');
}

function recuperarPwdAX(baseURL,forma)
{
  $("#"+forma).validationEngine();
  if($("#"+forma).validationEngine('validate'))
  {
    var correo = $("#email").val();
    var param  = {"correo" : correo};    
    $.ajax({ 
            data      : param,               
            url       : baseURL+'gestion/recuperarPwdAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () {$("#leyendaPWD").html("<br><img src=\""+baseURL+"images/spin.png\"> Validando Cuenta, espere por favor...");},
            success   :  function (response) 
                        { 
                            $("#leyendaPWD").html("");						
                            if(response['existe']=== true)
                            {
                                $("#leyendaPWD").html("La contaseña ha sido enviada a la cuenta de correo: "+correo);
                                $("#usuario").val(correo);
                            }
                            else
                                $("#leyendaPWD").html("No se encuentra registrada la cuenta de correo: "+correo);
                        }, 
            error     : function(err) {alert("Ha ocurrido un error recuperarPwdAX: " + err.status + " " + err.statusText);}
    });
  }  
}

function contactoAX(baseURL)
{    	
		var name    = $("#nombre").val();
		var email   = $("#email").val();
		var tel     = $("#tel").val();
		var comment = $("#comment").val();                

		var param = {"name"    : name,
			     "email"   : email, 
			     "tel"     : tel, 
			     "comment" : comment};
        $.ajax({ 
		data	  : param,               
                url	  : baseURL+'gestion/contactoAX/',
                type	  : 'post',
				dataType  : 'json',
				beforeSend: function () 
				{   $("#mensajeContacto").attr( "style", "color:orange;" );
                                    $("#mensajeContacto").html("<img src=\""+baseURL+"images/spin.png\"> Procesando su solicitud, espere por favor..."); },
                success:  function (response) 
				{	
                                    
                                        $("#mensajeContacto").attr( "style", "color:#15BC57;" );
					$("#mensajeContacto").html("<img src=\""+baseURL+"images/check.png\"> Hemos recibido su solicitud, a la brevedad nos comunicaremos con  usted");
					
					$("#name").val("");
					$("#email").val("");
					$("#tel").val("");
                                        $("#codigo").val("");
					$("#comment").val("");
                                  
                }, 
				error: function(err)
				{alert("Ha ocurrido un error contactoAX: " + err.status + " " + err.statusText);}
        });			
}

function traeProveedoresPorTSAX(ts,baseURL)
{
	var param = {"ts" : ts};
	$.ajax({ 
			data	   : param,               
			url	 	   : baseURL+'proveedor/traeProveedoresPorTSAX/',
			type	   : 'post',
			dataType   : 'json',
			 beforeSend: function () 
			{
			   $("#tsMensaje").html("<img src=\""+baseURL+"images/spin.png\"> Trayendo proveedores por tipo de servicio, espere por favor...");
			},
			success:  function (response) 
			{																	
				$("#tsMensaje").html("");
				var len = response.length;																					
				
				if(len > 1)
				{
					$('#carrier').empty();	
					for (var x = 0; x < len; x++)	
						$('#carrier').append($('<option>', {value: response[x]['id_prove'], text: response[x]['nombre']}));
				}				
			}, 
			error: function(err)
			{alert("Ha ocurrido un error traeProveedoresPorTSAX: " + err.status + " " + err.statusText);}
	});			
}

function traDetalleAdminAX(correo,baseURL)
{
	var param = {"correo" : correo};
	$.ajax({ 
			data: param,               
			url:   baseURL+'cotizador/traeDetalleAdminAX/',
			type:  'post',
			dataType: 'json',
			 beforeSend: function () 
			{
			   $("#adminMensaje").html("<img src=\""+baseURL+"images/loading.gif\"> Procesando Solicitud, espere por favor...");
			},
			success:  function (response) 
			{																	
				$("#adminMensaje").html("");
				var firma = (response[0]['firma'] == null | response[0]['firma'] == ''?"null.jpg":response[0]['firma'] );
				$("#firmaAdmin").html("<img border=0 width=\"120px\" height=\"80px\" src=\""+baseURL+"images/firmas/"+firma+"\"/>");
				$("#nombreAdmin").html(response[0]['titulo']+" "+response[0]['nombre']+" "+response[0]['apellidos']);
				$("#telAdmin").html(response[0]['telefono']);
				$("#celAdmin").html(response[0]['celular']);
				$("#correoAdmin").html(response[0]['correo']);
				$("#correoAdmin").parent().attr( "href", "mailto:"+response[0]['correo'] );
			}, 
			error: function(err)
			{alert("Ha ocurrido un error traDetalleAdminAX: " + err.status + " " + err.statusText);}
	});			
}


function traeFacturaZipAX(id_pedido, baseURL)
{ 
	var param = {"id_pedido" : id_pedido};

	$.ajax({url      : baseURL+'gestion/zipFacturaAX/',
			type     : 'post',
			data     : param,
			dataType : 'json',
			beforeSend: function ()  { $("#facDown").html("<img src=\""+baseURL+"images/loading.gif\" width='48px' heigth='43px'> Cargando, espere por favor..."); },
			success:  function (response) 
			{	
				var iconF = "<a href='"+baseURL+response['pathFile']+"' target='_blank'> <img src=\""+baseURL+"images/zip.jpg\" width='28px' heigth='23px'>  "+response['fileName']+" </a>"; 
                $("#facDown").html(iconF);
			}, 
			error: function(err) { alert("Ha ocurrido un error traeFacturaZipAX: " + err.status + " " + err.statusText);}
	});			
}


function paginarAX(controlador,numColGrid,currentPage,registrosPagina,baseURL)
{    
    var param = (controlador=="pedido")?{"pagina"   : currentPage,
                                        "f1"       : $("#f1").val(),
                                        "f2"       : $("#f2").val(),
                                        "f3"       : $("#f3").val(),
                                        "f4"       : $("#f4").val(),
                                        "fechaIni" : $("#fechaIni").val(),
                                        "fechaFin" : $("#fechaFin").val(),
                                        "f5"       : $("#f5").val(),
                                        "f6"       : $("#f6").val(),
                                        "f7"       : $('input:radio[name=f7]:checked').val(),
                                        "deF8"     : $("#deF8").val(),
                                        "aF8"      : $("#aF8").val()
                                       }
                                       :{"pagina"   : currentPage,
                                        "f1"       : $("#f1").val(),
                                        "f2"       : $("#f2").val(),
                                        "f3"       : $("#f3").val(),
                                        "f4"       : $("#f4").val(),
                                        "fechaIni" : $("#fechaIni").val(),
                                        "fechaFin" : $("#fechaFin").val()
                                       };
    if ( $.fn.dataTable.isDataTable( '#grid' ) ) 
	   { dtGrid.destroy(); }

    $.ajax({ url      : baseURL+controlador+'/paginarAX/',
             type     : 'post',
             data     : param,
             dataType : 'json',
             beforeSend: function () 
                {$("#spinPaginar").html("<img src=\""+baseURL+"images/loading.gif\"> Espere por favor...");
                 $("#grid tbody").html("");},
             success:  function (response) 
             {	
               $("#spinPaginar").html("");                           
               var columna = '';
               var conteo    = 0;
               var registros = 0;
               
               if (response == false)
               {
                    $("#linksPaginar").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){paginarAX(controlador,numColGrid,pageNumber,registrosPagina,baseURL);}
                    });
                    
                   columna = '<tr><td>-</td><td>&nbsp;</td><td align="center"><br><strong>No results</strong></td>';
				   var limiteTDCol = ((numColGrid-3)<0?0:numColGrid-3);
				   for (var z = 0; z <= limiteTDCol ; z++)
				   	   { columna += '<td>&nbsp;</td>'; }
				   columna += '</tr>';
                   $('#grid > tbody:last-child').append(columna);
                }
               else
               {   
                   var id      = response['offset'];                    
                   conteo      = response['conteo'];
                   registros   = response['registros'];                   
                    
                   $("#linksPaginar").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){paginarAX(controlador,numColGrid,pageNumber,registrosPagina,baseURL);}
                    });
                   
                   for (var x = 0; x <= (registros.length-1) ; x++)
                   {id = id +1;
                    switch(controlador)
                    {
                    case 'cotizador':                    
                        columna = '<tr>';
                        columna = columna + '<td align="center" width="5px">'+id+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['fecha_alta'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['prosp_nombre'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['prosp_empresa'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['asunto'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['at'])+'</td>';                        
                        columna = columna + '<td align="center"> <a href="'+baseURL+controlador+'/clonar/'+registros[x]['id_coti']+'">'
								+'<img title="Copiar una cotizaci&oacute;n existente para generar una nueva" width="17px" heigth="18px" src="'+baseURL+'images/clone.png"></a>'
                                                                +'&nbsp;<a href="'+baseURL+controlador+'/editar/'+registros[x]['id_coti']+'">'
								+'<img title="Editar Cotizaci&oacute;n" width="17px" heigth="18px" src="'+baseURL+'images/edit.png"></a>'								
								+'<img class="boton_confirm" width="17px" heigth="18px" title="Borrar Cotizaci&oacute;n" id="'+registros[x]['id_coti']+'" src="'+baseURL+'/images/erase2.png">';
                        columna = columna + '</tr>';
                   break;
                   case 'proveedor':
                        columna = '<tr>';
                        columna = columna + '<td align="center" width="15px">'+id+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['nombre'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['rfc'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['correo'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['tipo_servicio'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['fecha_alta'])+'</td>';                        
                        columna = columna + '<td align="center"><a href="'+baseURL+controlador+'/detalle/'+registros[x]['id_prove']+'">'
								+'<img title="Detalle Proveedor" src="'+baseURL+'images/detail.png"></a>'
								+' &nbsp;'
								+'  <a href="'+baseURL+controlador+'/editar/'+registros[x]['id_prove']+'">'
                                                                +'   <img title="Editar Proveedor" src="'+baseURL+'images/edit.png"></a>';
                        columna = columna + '</tr>';
                   break;
                   case  'gestion':
                        columna = '<tr>';
                        columna = columna + '<td align="center" width="15px">'+id+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['razon_social'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['rfc'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['correo'])+'</td>';                        
                        columna = columna + '<td align="center">'+empty(registros[x]['fecha_alta'])+'</td>';                        
                        columna = columna + '<td align="center"><a href="'+baseURL+controlador+'/dc/'+registros[x]['rfc']+'">'
								+'<img title="Detalle Cliente" src="'+baseURL+'images/detail.png"></a>'
								+' &nbsp;'
								+'  <a href="'+baseURL+controlador+'/editacliente/'+registros[x]['rfc']+'">'
                                                                +'   <img title="Editar Cliente" src="'+baseURL+'images/edit.png"></a>';                       
                        columna = columna + '</tr>';
                    break;
                    case 'pedido':                    
                        var adjuntos = '';                        
                        for( var i=0; i<registros[x]['adjuntos'].length; i++ )
						   { adjuntos = adjuntos + '<a href="'+( (registros[x]['adjuntos'][i]['tipo']=="FACTURA" || registros[x]['adjuntos'][i]['tipo']=="REP") ? "" : baseURL) + registros[x]['adjuntos'][i]['adjunto']+'" target="_blank"><img title="'+registros[x]['adjuntos'][i]['desc_adjunto']+'" src="'+baseURL+'images/fileIcon.png"></a>&nbsp;'; }
						   
                        
                        columna = '<tr>';
                        columna = columna + '<td align="center" width="15px">'+id+'. </td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['id_pedido'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['status'])+'</td>';
                        columna = columna + '<td align="left">'+empty(registros[x]['razon_social'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['num_mbl'])+'</td>'; 
                        columna = columna + '<td align="center">'+adjuntos.replace('pedido/consulta/','')+'</td>'; 
                        columna = columna + '<td align="center"><a href="'+baseURL+controlador+'/detalle/'+registros[x]['id_pedido']+'">'
								+'  <a href="'+baseURL+controlador+'/editar/'+registros[x]['id_pedido']+'">'
                                                                +'   <img title="Editar Embarque" src="'+baseURL+'images/edit.png" width="20px"></a>';								  
                        columna = columna + '</tr>';
                    break;
                    case 'usuario':
                        var cuenta  = registros[x]['correo'];
                        
                        columna = '<tr id='+cuenta+'>';
                        columna = columna + '<td align="center" width="15px">'+id+'</td>';
                        columna = columna + '<td align="left" width="200px">'+empty(registros[x]['nombre'])+' '+empty(registros[x]['apellidos'])+'</td>';
                        columna = columna + '<td align="center" width="150px">'+empty(registros[x]['puesto'])+'</td>';
                        columna = columna + '<td align="left" width="150px">'+empty(registros[x]['correo'])+'</td>';                        
                        columna = columna + '<td align="center" width="210px">'+empty(registros[x]['fecha_alta'])+'</td>';                        
                        columna = columna + '<td align="center"><a href="'+baseURL+controlador+'/edita/'+encodeURIComponent(cuenta)+'">'
                                                                +'   <img title="Editar Usuario" src="'+baseURL+'images/edit.png"></a>'
								+' &nbsp;'
								+'  <a href="javascript:confirmaBorraUsuario(\''+cuenta+'\',\''+baseURL+'\');">'
                                                                +'   <img title="Eliminar Usuario" src="'+baseURL+'images/erase.png"></a>';                    
                        columna = columna + '</tr>';
                    break;
                   }//switch
                    
                    $('#grid > tbody:last-child').append(columna);                     
                    columna = '';                    
                   }                   
                 $('.boton_confirm').addClass('pointer');                 
                 $('.boton_confirm').click(function() {  var id     = $(this).attr('id');
                                                        jConfirm("¿Borrar registro?",titAlert, function(r) { if(r) { $(location).attr('href',baseURL+controlador+'/borrar/'+id); }
                                                                                                           });
                                                     });                    
                }

				dtGrid = $('#grid').DataTable( { retrieve: false, destroy: true, responsive: true, paging: false, searching: false  } );
				 
				$("#grid_filter").hide();
				$("#grid_info"  ).hide();
             }, 
             error: function(err)
                { alert("Ha ocurrido un error al paginarAX: " + err.status + " " + err.statusText); }
             });
}

function paginarFacturasAX(currentPage, registrosPagina, baseURL)
{    	
    var param = {"pagina"   : currentPage,
				 "tipo"   	: $('input:radio[name=f4]:checked').val(),
				 "f1"       : $("#f1").val(),
				 "f2"       : $("#f2").val(),
				 "f3"       : $("#f3").val(),				 
				 "f4"       : $("#f4").val(),
				 "fechaIni" : $("#fechaIni").val(),
				 "fechaFin" : $("#fechaFin").val(),
				 "export"   : null
				};	

	if ( $.fn.dataTable.isDataTable( '#grid' ) ) 
	   { dtGrid.destroy(); }

    $.ajax({ url      : baseURL+'gestion/paginarFacturasAX/',
             type     : 'post',
             data     : param,
             dataType : 'json',
             beforeSend: function () 
                { $("#spinPaginar").html("<img src=\""+baseURL+"images/loading.gif\"> Espere por favor...");
                  $("#grid tbody" ).html("");
				  $("#titReportes").html("");
				  $("#iconDown"   ).html("");
				  $("#facDown"    ).html("");
				},
             success: function (response) 
             {				   			   
			   $("#spinPaginar").html("");
			   $("#titFac"	   ).show();
			   $("#grid"	   ).show(); 

               var columna   = '';
               var conteo    = 0;
               var registros = 0;
               
			   
               if (response == false)
               {
					$("#titReportes").html( (param['tipo']=="FT" ? "Facturas Timbradas" : ( param['tipo']=="FSI" ? "Facturas con Saldo Insoluto" : "Facturar Embarque") ) );
                    $("#linksPaginar").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){ paginarFacturasAX(pageNumber,registrosPagina,baseURL); }
                    });
                    
					columna = '<tr><td align="center">-</td><td>&nbsp;</td><td>&nbsp;</td><td align="center"><br><strong>No results</strong></td><td align="center">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
                   $('#grid > tbody:last-child').append(columna);
                }
               else
               {   
                   var id    = response['offset'];                    
                   conteo    = response['conteo'];
                   registros = response['registros'];
				   
                   $("#linksPaginar").pagination({
					items       : conteo,
					itemsOnPage : registrosPagina,
					cssStyle    : 'light-theme',
					currentPage : currentPage,
					onPageClick : function(pageNumber){ paginarFacturasAX(pageNumber,registrosPagina,baseURL); }
					});

				   if( param['tipo']=="FSI" ) 
				   {
						$('#grid > thead').html("<tr><th align='center'>#</th><th align='center'># Folio</th><th align='center'>Embarque</th><th align='center'>RFC</th><th align='center'>Razon Social</th><th align='center'>Total</th><th align='center'>Saldo Insoluto</th><th align='center'># Parcialidades</th><th align='center'>Dias Vencido</th><th align='center'>Fecha</th><th align='center'>Acciones</th></tr>"); 
						$("#titReportes" ).html( "Facturas con Saldo Insoluto. "+conteo+" registros." );
						var r = 0;
						for (var x = 0; x <= (registros.length-1) ; x++) 
						{    id = id + 1;
							 r  = r  + 1;
	 
							 columna = '<tr>';
							 columna = columna + '<td align="center" width="15px">'+id+'</td>';
							 columna = columna + '<td align="center">'+empty(registros[x]['folio'])+'</td>';
							 columna = columna + '<td align="center">'+empty(registros[x]['id_pedido'])+'</td>';
							 columna = columna + '<td align="center">'+empty(registros[x]['rfc'])+'</td>';
							 columna = columna + '<td align="left">'+empty(registros[x]['nombre'])+'</td>';
							 columna = columna + '<td align="left">'+empty( "$ "+$.number(registros[x]['total'],2, '.', ',' ) )+'</td>';
							 columna = columna + '<td align="left">'+empty( "$ "+$.number(registros[x]['saldo_insoluto'],2, '.', ',' ) )+'</td>';
							 columna = columna + '<td align="left">'+empty( +$.number(registros[x]['num_parcialidades'],2, '.', ',' ) )+'</td>';
							 columna = columna + '<td align="center">'+empty(registros[x]['dias_vencidos'])+'</td>';
							 columna = columna + '<td align="left">'+empty(registros[x]['fecha_factura'])+'</td>';
							 columna = columna + '<td align="center"> <i class="fa fa-download downFac" idpedido="'+registros[x]['id_pedido']+'"></i> </td>';
							 columna = columna + '</tr>';                  
						 
						 $('#grid > tbody:last-child').append(columna);                     
						 columna = '';                    
						}
				   }
				   else
				   {
						$('#grid > thead').html("<tr><th align='center'>#</th><th align='center'>Referencia Senni</th><th align='center'>Folio</th><th align='center'>RFC</th><th align='center'>Razon Social</th><th align='center'>Total</th><th align='center'>Moneda</th><th align='center'>Fecha</th><th align='center'>Acciones</th></tr>"); 
						$("#titReportes" ).html( (param['tipo']=="FT" ? "Facturas Timbradas. " : "Facturar Embarque. " )+conteo+" registros." );
						var r = 0;
						for (var x = 0; x <= (registros.length-1) ; x++)
						{    id = id + 1;
							 r  = r  + 1;
							 columna = '<tr>';
							 columna = columna + '<td align="center" width="15px">'+id+'</td>';
							 columna = columna + '<td align="center">'+empty(registros[x]['id_pedido'])+'</td>';
							 columna = columna + '<td align="center">'+empty(registros[x]['folio'])+'</td>';
							 columna = columna + '<td align="left">'+empty(registros[x]['rfc'])+'</td>';
							 columna = columna + '<td align="left">'+empty(registros[x]['nombre'])+'</td>';                        
							 columna = columna + '<td align="left">'+empty( "$ "+$.number(registros[x]['total'],2, '.', ',' ) )+'</td>';                        
							 columna = columna + '<td align="center">'+empty(registros[x]['moneda'])+'</td>';
							 columna = columna + '<td align="left">'+empty(registros[x]['fecha_factura'])+'</td>';
							 columna = columna + '<td align="center">'+( param['tipo'] == "FE" ? registros[x]['total']==0?'':'<a class="button openModalFac" idPedido="'+registros[x]['id_pedido']+'" rfc="'+registros[x]['rfc']+'">Facturar <i class="fa fa-file-o"></i> <i class="fa fa-file-pdf-o"></i></a>' : '<i class="fa fa-download downFac" idpedido="'+registros[x]['id_pedido']+'"></i>' )+'</td>';
							 columna = columna + '</tr>';                  
						 
						 $('#grid > tbody:last-child').append(columna);                     
						 columna = '';                    
						}
				   }

                 $('.downFac').addClass('pointer');                 
                 $('.downFac').click(function() {  var id_pedido = $(this).attr('idpedido');
													traeFacturaZipAX(id_pedido, baseURL);
												});                    
            }

				if (param['tipo'] == "FE")
				{
					$(".openModalFac").on( "click", function() { $("#modalFac" ).dialog( "open" ); 
																 $("#ui-id-1"  ).html("FACTURACION ELECTRONICA RAMF Logistics ");
																 var id_pedido = $(this).attr('idPedido');
																 var rfc       = $(this).attr('rfc');
																 $("#id_pedido").val(id_pedido);
																 openModalTimbrarAX(baseURL, id_pedido, rfc);																 
																 $( ".ui-dialog" ).css({"z-index": 1001});
															   });
				}
				else
				{
					$("#confirmDownHeader").html('<p><i class="fa fa-file-excel-o"></i> ¿Desea descargar las '+conteo+' facturas <b>ó</b> las '+r+' mostradas en pantalla?</p>');
					$("#iconDown"	).html(' <i class="fa fa-download"></i> <i class="fa fa-file-excel-o"></i> <b>Descargar Facturas</b>')
									.addClass('pointer')
									.on( "click", function() {$("#confirmDownContent").html('');	
															  $("#confirmDown").dialog({resizable: false,
																						height   : "auto",
																						width    : "80%",
																						modal    : true,
																						buttons  : { "Las mostradas en pantalla": function() { exportarFacturasAX(currentPage, baseURL);   },
																									"Todas" : function() {  exportarFacturasAX(0, baseURL);  },
																									"Cerrar": function() {  $( this ).dialog( "close" ); }
																									}
																						});
															});
				}
				dtGrid = $('#grid').DataTable( { retrieve: false, destroy: true, responsive: true, paging: false, searching: false  } );
				
				$("#grid_filter").hide();
				$("#grid_info"  ).hide();

             }, 
             error: function(err) { alert("Ha ocurrido un error al paginarAX: " + err.status + " " + err.statusText); }
             });
}


function paginarRNominasAX(currentPage, registrosPagina, baseURL)
{    	
    var param = {"pagina"   : currentPage,				 
				 "f1"       : $("#f1").val(),
				 "f2"       : $("#f2").val(),
				 "f3"       : $("#f3").val(),
				 "f4"       : $("#f4").val(),
				 "fechaIni" : $("#fechaIni").val(),
				 "fechaFin" : $("#fechaFin").val(),				 
				};

	if ( $.fn.dataTable.isDataTable( '#grid' ) ) 
	   { dtGrid.destroy(); }

    $.ajax({ url      : baseURL+'gestion/paginarRNominasAX/',
             type     : 'post',
             data     : param,
             dataType : 'json',
             beforeSend: function () 
                { $("#spinPaginar").html("<img src=\""+baseURL+"images/loading.gif\"> Espere por favor...");
                  $("#grid tbody" ).html("");
				  //$("#titReportes").html("");
				  //$("#iconDown"   ).html("");
				  //$("#facDown"    ).html("");
				},
             success: function (response) 
             {				   			   
			   $("#spinPaginar").html("");			   
			   $("#grid"	   ).show(); 

               var columna   = '';
               var conteo    = 0;
               var registros = 0;
               
               if (response == false)
               {					
                    $("#linksPaginar").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){ paginarRNominasAX(pageNumber,registrosPagina,baseURL); }
                    });
                    
                   columna = '<tr><td align="center">-</td><td>&nbsp;</td><td align="center"><br><strong>No results</strong></td><td align="center">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
                   $('#grid > tbody:last-child').append(columna);
                }
               else
               {   
                   var id    = response['offset'];                    
                   conteo    = response['conteo'];
                   registros = response['registros'];				   
				   
                   $("#linksPaginar").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){ paginarRNominasAX(pageNumber,registrosPagina,baseURL); }
                    });
                   				   
                   for (var x = 0; x <= (registros.length-1) ; x++)
                   {    id = id + 1;					

                        columna = '<tr>';
                        columna = columna + '<td align="center" width="15px">'+id+'</td>';
						columna = columna + '<td align="left"  >'+empty(registros[x]['nombre'])+' '+empty(registros[x]['apellidos'])+'</td>';
						columna = columna + '<td align="center">'+empty(registros[x]['puesto'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['correo'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['fecha_alta'])+'</td>';
                        columna = columna + '<td align="center"> <a class="button openModalRNom" correo="'+registros[x]['correo']+'">Recibo Nomina <i class="fa fa-file-pdf-o"></i></a> </td>';
                        columna = columna + '</tr>';                  
                    
                    $('#grid > tbody:last-child').append(columna);
                    columna = '';                    
                   }				 			   	 

				$(".openModalRNom").on( "click", function() { $("#modalRNom" ).dialog( "open" ); 
															  $("#ui-id-1"  ).html("TIMBRADO ELECTRONICO RAMF LOGISTICS ");
															  var correo = $(this).attr('correo');															
															  $( ".ui-dialog" ).css({"z-index": 1001});
															  openModalReciboNominaAX(baseURL, correo );
														});
                }
				
				dtGrid = $('#grid').DataTable( { retrieve: false, destroy: true, responsive: true, paging: false, searching: false  } );
				
				$("#grid_filter").hide();
				$("#grid_info"  ).hide();

             }, 
             error: function(err) { alert("Ha ocurrido un error al paginarAX: " + err.status + " " + err.statusText); }
             });
}

function paginarMisRecibosNominasAX(currentPage, registrosPagina, baseURL)
{    	
    var param = {"pagina"   : currentPage,				 				 
				 "correo"   : $("#correo_emp").val(),
				 "fechaIni" : $("#fechaini_rec").val(),
				 "fechaFin" : $("#fechafin_rec").val(),
				};
				
	if ( $.fn.dataTable.isDataTable( '#gridMisRecibos' ) ) 
	   { dtGrid.destroy(); }

    $.ajax({ url      : baseURL+'gestion/paginarMisRecibosNominasAX/',
             type     : 'post',
             data     : param,
             dataType : 'json',
             beforeSend: function () 
                { $("#spinPaginarMisRecibos" ).html("<img src=\""+baseURL+"images/loading.gif\"> Espere por favor...");
                  $("#gridMisRecibos > tbody").html("");				  
				},
             success: function (response) 
             {				   			   
			   $("#spinPaginarMisRecibos").html("");			   
			   $("#gridMisRecibos"	     ).show(); 

               var columna   = '';
               var conteo    = 0;
               var registros = 0;
               
               if (response == false)
               {					
                    $("#linksPaginarMisRecibos").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){ paginarMisRecibosNominasAX(pageNumber,registrosPagina,baseURL); }
                    });
                    
					columna = '<tr><td align="center">-</td><td>&nbsp;</td><td align="center"><br><strong>No results</strong></td><td align="center">&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>';
                   $('#gridMisRecibos > tbody:last-child').append(columna);
                }
               else
               {   var id    = response['offset'];                    
                   conteo    = response['conteo'];
                   registros = response['registros'];				   
				   
                   $("#linksPaginarMisRecibos").pagination({
                        items       : conteo,
                        itemsOnPage : registrosPagina,
                        cssStyle    : 'light-theme',
                        currentPage : currentPage,
                        onPageClick : function(pageNumber){ paginarMisRecibosNominasAX(pageNumber,registrosPagina,baseURL); }
                    });
                   				   
                   for (var x = 0; x <= (registros.length-1) ; x++)
                   {    id = id + 1;					

                        columna = '<tr>';
                        columna = columna + '<td align="center" width="15px">'+id+'</td>';
						columna = columna + '<td align="center"  >'+empty(registros[x]['FechaPagoFormat'])+'</td>';
						columna = columna + '<td align="center">'+empty(registros[x]['FechaInicialPagoFormat'])+'</td>';
                        columna = columna + '<td align="center">'+empty(registros[x]['FechaFinalPagoFormat'])+'</td>';
						var iconF = "<a href='"+registros[x]['dir_cfdi']+registros[x]['filename']+"' target='_blank'> <img src=\""+baseURL+"images/zip.jpg\" width='24px' heigth='21px'> "+registros[x]['filename']+" </a>"; 
                        columna = columna + '<td align="center"> '+iconF+' </td>';
                        columna = columna + '</tr>';                  
                    
                    $('#gridMisRecibos > tbody:last-child').append(columna);
                    columna = '';                    
                   }				
                }//else

				dtGrid = $('#grid').DataTable( { retrieve: false, destroy: true, responsive: true, paging: false, searching: false  } );
				
				$("#grid_filter").hide();
				$("#grid_info"  ).hide();

             }, 
             error: function(err) { alert("Ha ocurrido un error al paginarMisRecibosNominasAX: " + err.status + " " + err.statusText); }
             });
}

function openModalReciboNominaAX(baseURL, correo)
{ 
  var paramReport = { "correo":correo};	
	
    $.ajax({data      :  paramReport,
            url       :  baseURL+'gestion/datosReciboNominaAX',
            type      : 'post',
            dataType  : 'json',			
			beforeSend: function () { $("#confirmTimb").html(""); $("#confirmTimb").html("<img src=\""+baseURL+"images/loading.gif\"> Cargando información. Espere por favor...");},
            success   : function (resp) 
						{ $("#confirmTimb").html("");
						/************ EMISOR ************/
						  $("#rfcEmisor").val(resp['emisor']['rfc']);
						  $("#rsEmisor" ).val(resp['emisor']['nombre_fiscal']);
						  $("#cpEmisor" ).val(resp['emisor']['cp_fiscal']);
						  $("#emailEmisor" ).val(resp['emisor']['correo_fiscal']);	
						  $("#RegistroPatronal" ).val(resp['emisor']['RegistroPatronal']);						  
						/************ EMISOR ************/												

						/************ EMPLEADO ************/
						$("#nombre_emp" ).val(resp['empleado']['apellidos']+" "+resp['empleado']['nombre']);
						$("#correo_emp" ).val(resp['empleado']['correo']);
						$("#puesto_emp" ).val(resp['empleado']['puesto']);
						$("#RFC"  		).val(resp['empleado']['RFC']);
						$("#Curp"  		).val(resp['empleado']['Curp']);
						$("#NumSeguridadSocial").val(resp['empleado']['NumSeguridadSocial']);						
						$('#tipo_jornada_emp'  ).val('01');

						$("#NumEmpleado" 		   ).val(resp['rn']['recibo']['NumEmpleado']);
						$("#FechaInicioRelLaboral" ).val(resp['rn']['recibo']['FechaInicioRelLaboralFormat']);
						$("#SalarioBaseCotApor"    ).val(resp['rn']['recibo']['SalarioBaseCotApor']);						
						$("#SalarioDiarioIntegrado").val(resp['rn']['recibo']['SalarioDiarioIntegrado']);
						$("#tipo_jornada_emp"	   ).val(resp['rn']['recibo']['tipo_jornada_emp']);
						$("#periodo_emp"		   ).val(resp['rn']['recibo']['periodo_emp']);
						$("#tipo_regimen_emp"	   ).val(resp['rn']['recibo']['tipo_regimen_emp']);
						$("#tipo_contrato_emp"	   ).val(resp['rn']['recibo']['tipo_contrato_emp']);
						$("#riesgo_emp"			   ).val(resp['rn']['recibo']['riesgo_emp']);
						$("#banco_emp"			   ).val(resp['rn']['recibo']['banco_emp']);
						$("#cuenta_banco_emp"	   ).val(resp['rn']['recibo']['cuenta_banco_emp']);
						$("#id_recibo"			   ).val(resp['rn']['recibo']['tipo_recibo']=="vp"?resp['rn']['recibo']['id_recibo']:'');						
						$("#cve_entidad_emp"	   ).val(resp['emisor']['cp_fiscal']);
						/************ EMPLEADO ***********/

						/************ NOMINA ***********/
						$('#NumDiasPagados'  ).val(resp['rn']['recibo']['NumDiasPagados'] );
						if(resp['rn']['recibo']['tipo_recibo'] == "vp")
						{
							$("#FechaInicialPago").val(resp['rn']['recibo']['FechaInicialPagoFormat']);
							$("#FechaFinalPago"  ).val(resp['rn']['recibo']['FechaFinalPagoFormat']);
							$("#FechaPago"		 ).val(resp['rn']['recibo']['FechaPagoFormat']);
						}
						/************ NOMINA ***********/

						/************ PERCEPCIONES ***********/
						$("#tot_anti_emp"     ).val(resp['rn']['recibo']['tot_anti_emp']);
						$("#tot_sueldo_emp"   ).val(resp['rn']['recibo']['tot_sueldo_emp']);
						$("#tot_pag_dec_emp"  ).val(resp['rn']['recibo']['tot_pag_dec_emp']);
						$("#ano_serv_dec_emp" ).val(resp['rn']['recibo']['ano_serv_dec_emp']);
						$("#ing_acu_dec_emp"  ).val(resp['rn']['recibo']['ing_acu_dec_emp']);
						$("#ing_noacu_dec_emp").val(resp['rn']['recibo']['ing_noacu_dec_emp']);
						$("#ul_sueldo_dec_emp").val(resp['rn']['recibo']['ul_sueldo_dec_emp']);

						for( var i = 0; i < resp['rn']['percepciones'].length; i++  )
						{
							var columna = '<tr id="trper'+resp['rn']['percepciones'][i]['tipo']+'">';
							columna = columna + '<td align="center">'+resp['rn']['percepciones'][i]['tipo']+'</td>';
							columna = columna + '<td align="center"> <input type="text" name="cve'+resp['rn']['percepciones'][i]['tipo']+'"    id="cve'+resp['rn']['percepciones'][i]['tipo']+'"    value="'+resp['rn']['percepciones'][i]['clave']+'" 			 class="text-input " size="5" maxlength="20"> </td>';
							columna = columna + '<td align="center"> <input type="text" name="con'+resp['rn']['percepciones'][i]['tipo']+'"    id="con'+resp['rn']['percepciones'][i]['tipo']+'"    value="'+resp['rn']['percepciones'][i]['concepto']+'"        class="text-input " size="18" maxlength="20"> </td>';
							columna = columna + '<td align="center"> <input type="text" name="per_ig'+resp['rn']['percepciones'][i]['tipo']+'" id="per_ig'+resp['rn']['percepciones'][i]['tipo']+'" value="'+resp['rn']['percepciones'][i]['importe_gravado']+'" class="text-input impg onlyNumber" size="8" maxlength="20"> </td>';
							columna = columna + '<td align="center"> <input type="text" name="per_ie'+resp['rn']['percepciones'][i]['tipo']+'" id="per_ie'+resp['rn']['percepciones'][i]['tipo']+'" value="'+resp['rn']['percepciones'][i]['importe_exento']+'"  class="text-input impe onlyNumber" size="8" maxlength="20"> </td>';
							columna = columna + '<td align="center"> <i class="fa fa-trash borraCon" idper="trper'+resp['rn']['percepciones'][i]['tipo']+'"></i> <input type="hidden" name="percep'+resp['rn']['percepciones'][i]['tipo']+'" id="percep'+resp['rn']['percepciones'][i]['tipo']+'" value="'+resp['rn']['percepciones'][i]['tipo']+'" /> </td>';
							columna = columna + '</tr>';				
							creaTablaPercepciones(columna);
						}						
						calcularImpGravado();
						calcularImpExento();
						/************ PERCEPCIONES ***********/

						/************ DEDUCCIONES ***********/
						$("#tot_o_deduc_emp" ).val(resp['rn']['recibo']['tot_o_deduc_emp']);
						$("#tot_imp_ret_emp" ).val(resp['rn']['recibo']['tot_imp_ret_emp']);
						
						for( var i = 0; i < resp['rn']['deducciones'].length; i++  )
						{
							var columna = '<tr id="trdec'+resp['rn']['deducciones'][i]['tipo']+'">';
							columna = columna + '<td align="center"> <input type="text" name="dec_cve'+resp['rn']['deducciones'][i]['tipo']+'" id="dec_cve'+resp['rn']['deducciones'][i]['tipo']+'" value="'+resp['rn']['deducciones'][i]['clave']+'" class="text-input " size="5" maxlength="20"> </td>';
							columna = columna + '<td align="center"> <input type="text" name="dec_con'+resp['rn']['deducciones'][i]['tipo']+'" id="dec_con'+resp['rn']['deducciones'][i]['tipo']+'" value="'+resp['rn']['deducciones'][i]['concepto']+'" class="text-input " size="18" maxlength="20"> </td>';		
							columna = columna + '<td align="center"> <input type="text" name="dec_imp'+resp['rn']['deducciones'][i]['tipo']+'" id="dec_imp'+resp['rn']['deducciones'][i]['tipo']+'" value="'+resp['rn']['deducciones'][i]['importe']+'" class="text-input '+(resp['rn']['deducciones'][i]['impuesto_ret']=="0"?"tod":"tir")+' onlyNumber" size="8" maxlength="20"> <input type="checkbox" id="dec_ir'+resp['rn']['deducciones'][i]['tipo']+'" name="dec_ir'+resp['rn']['deducciones'][i]['tipo']+'" deduc="'+resp['rn']['deducciones'][i]['tipo']+'" class="checkir" '+(resp['rn']['deducciones'][i]['impuesto_ret']=="0"?"":"checked")+' value="Si"> Impuestos retenidos </td>';		
							columna = columna + '<td align="center"><i class="fa fa-trash borraConDec" iddec="trdec'+resp['rn']['deducciones'][i]['tipo']+'"></i> <input type="hidden" name="deduc'+resp['rn']['deducciones'][i]['tipo']+'" id="deduc'+resp['rn']['deducciones'][i]['tipo']+'" value="'+resp['rn']['deducciones'][i]['tipo']+'" /> </td>';
							columna = columna + '</tr>';  

							creaTablaDeducciones(columna);
						}						
						calcularTotImpRet();
						calcularTotDeduccion();
						/************ DEDUCCIONES ***********/	

						/************ OTROS PAGOS ***********/						
						for( var i = 0; i < resp['rn']['otrospagos'].length; i++  )
						{
							var columna = '<tr id="trop'+resp['rn']['otrospagos'][i]['tipo']+'">';
							columna = columna + '<td align="center"> <input type="text" name="op_cve'+resp['rn']['otrospagos'][i]['tipo']+'" id="op_cve'+resp['rn']['otrospagos'][i]['tipo']+'" value="'+resp['rn']['otrospagos'][i]['clave']+'"    class="text-input " size="5" maxlength="20"> </td>';
							columna = columna + '<td align="center"> <input type="text" name="op_con'+resp['rn']['otrospagos'][i]['tipo']+'" id="op_con'+resp['rn']['otrospagos'][i]['tipo']+'" value="'+resp['rn']['otrospagos'][i]['concepto']+'" class="text-input " size="18" maxlength="20"> </td>';		
							columna = columna + '<td align="center"> <input type="text" name="op_imp'+resp['rn']['otrospagos'][i]['tipo']+'" id="op_imp'+resp['rn']['otrospagos'][i]['tipo']+'" value="'+resp['rn']['otrospagos'][i]['importe']+'"  class="text-input totop onlyNumber" size="8" maxlength="20"> </td>';
							columna = columna + '<td align="center"><i class="fa fa-trash borraConOP" idop="trop'+resp['rn']['otrospagos'][i]['tipo']+'"></i> <input type="hidden" name="op'+resp['rn']['otrospagos'][i]['tipo']+'" id="op'+resp['rn']['otrospagos'][i]['tipo']+'" value="'+resp['rn']['otrospagos'][i]['tipo']+'" /> </td>';
							columna = columna + '</tr>';                  		

							creaTablaOtrosPagos(columna);
						}						
						calcularTotOP();
						/************ OTROS PAGOS ***********/	

						/************ INCAPACIDADES ***********/						
						for( var i = 0; i < resp['rn']['incapacidades'].length; i++  )
						{
							var columna = '<tr id="trInc'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'">';
							columna = columna + '<td align="center"> <small>'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'</small>  </td>';
							columna = columna + '<td align="center"> <small>'+resp['rn']['incapacidades'][i]['concepto']+'</small> <input type="hidden" name="inc_con'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" id="inc_con'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" value="'+resp['rn']['incapacidades'][i]['concepto']+'" /></td>';		
							columna = columna + '<td align="center"> <input type="text" name="inc_dias'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" id="inc_dias'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" value="'+resp['rn']['incapacidades'][i]['DiasIncapacidad']+'" class="text-input onlyNumber" size="10" maxlength="6"> </td>';		
							columna = columna + '<td align="center"> <input type="text" name="inc_imp'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'"  id="inc_imp'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'"  value="'+resp['rn']['incapacidades'][i]['ImporteMonetario']+'"  class="text-input totinc onlyNumber" size="8" maxlength="20"> </td>';		
							columna = columna + '<td align="center"><i class="fa fa-trash borraConInc" idinc="trInc'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'"></i> <input type="hidden" name="inc'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" id="inc'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" value="'+resp['rn']['incapacidades'][i]['TipoIncapacidad']+'" /> </td>';
							columna = columna + '</tr>';                  
						
							creaTablaIncapacidades(columna);
						}												
						/************ INCAPACIDADES ***********/
						
						/************ MIS RECIBOS ***********/
						paginarMisRecibosNominasAX(1, 10, baseURL);
						if( $("#tipoUsr").val() != 'A')
						  { ocultaBotonesVPTim();     }
						/************ MIS RECIBOS  ***********/
                        }, 
            error     : function(err) { jAlert("Ha ocurrido un error openModalReciboNominaAX en " + err.status + " " + err.statusText,titAlert); }
		  }); 
}

function muestraDetalleConcepto(tabla)
{
	if ($('#'+tabla+' tr').length == 1){ $('#'+tabla).hide(); } else { $('#'+tabla).show(); }
}

function toggFiltrosFac()
{
	var isHidden = $("#filtrosForm").is(":hidden");                                    
	if(isHidden) { $("#imgfiltrosForm").removeClass("fa-plus" ).addClass("fa-minus" ); 
					$("#filtrosForm"   ).show();
					}
	else         { $("#imgfiltrosForm").removeClass("fa-minus").addClass("fa-plus"); 
					$("#filtrosForm"   ).hide();
					}   
}

function toggFiltrosRE()
{
	var isHidden = $("#filtrosFormRE").is(":hidden");                                    
	if(isHidden) { $("#imgfiltrosFormRE").removeClass("fa-plus" ).addClass("fa-minus" ); 
					$("#filtrosFormRE"   ).show();
					}
	else         { $("#imgfiltrosFormRE").removeClass("fa-minus").addClass("fa-plus"); 
					$("#filtrosFormRE"   ).hide();
					}   
}

function exportarFacturasAX(pageNumber, baseURL)
{    
	var param = {"pagina"   : pageNumber,
				 "tipo"   	: $('input:radio[name=f4]:checked').val(),
				 "f1"       : $("#f1").val(),
				 "f2"       : $("#f2").val(),
				 "f3"       : $("#f3").val(),				 
				 "fechaIni" : $("#fechaIni").val(),
				 "fechaFin" : $("#fechaFin").val(),
				 "export"   : 1
				};

    $.ajax({data    : param,
            url     : baseURL+'gestion/paginarFacturasAX/',
            type    : 'post',
            dataType: 'json',
			beforeSend: function () 
			{ $("#confirmDownContent").html("<img src=\""+baseURL+"images/loading.gif\" width='100px' heigth='100px'> Espere por favor...");			 
			},
            success :  function (response) 
            {	var iconF = "<a href='"+baseURL+response['pathFile']+"' target='_blank'> <img src=\""+baseURL+"images/zip.jpg\" width='48px' heigth='43px'>  "+response['fileName']+" </a>"; 
                $("#confirmDownContent").html(iconF);
            }, 
            error: function(err)
            { alert("Ha ocurrido un error exportarFacturasAX: " + err.status + " " + err.statusText); }
    });			
}

function confirmaBorraUsuario(correo,baseURL)
{
    jConfirm("¿Dar de baja al usuario "+correo+" del portal "+$("#companyName").val()+"?",titAlert, function(r) { if(r) { borraUsuario(correo,baseURL); }
                                                                                                                 });
}

function borraUsuario(correo,baseURL)
{
    var param = {"correo" : correo};
    $.ajax({data    : param,               
            url     : baseURL+'usuario/bajaUserAX/',
            type    : 'post',
            dataType: 'json',             
            success:  function (response) 
            {	
                if(response === true)
                    { $("#"+correo).remove(); }
            }, 
            error: function(err)
            { alert("Ha ocurrido un error traDetalleAdminAX: " + err.status + " " + err.statusText); }
    });			
}


function agregaConceptoRN_per()
{	
	if($("#percepciones").val()=="0")
	{ jAlert("Favor de seleccionar un concepto para agregar " , titAlert);  }
	else
	{		
		var columna = '<tr id="trper'+$("#percepciones").val()+'">';
		columna = columna + '<td align="center">'+$("#percepciones").val()+'</td>';
		columna = columna + '<td align="center"> <input type="text" name="cve'+$("#percepciones").val()+'" id="cve'+$("#percepciones").val()+'" value="'+$("#percepciones").val()+'" class="text-input " size="5" maxlength="20"> </td>';
		columna = columna + '<td align="center"> <input type="text" name="con'+$("#percepciones").val()+'" id="con'+$("#percepciones").val()+'" value="'+$("#percepciones option:selected").text()+'" class="text-input " size="18" maxlength="20"> </td>';
		columna = columna + '<td align="center"> <input type="text" name="per_ig'+$("#percepciones").val()+'" id="per_ig'+$("#percepciones").val()+'" value="" class="text-input impg onlyNumber" size="8" maxlength="20"> </td>';
		columna = columna + '<td align="center"> <input type="text" name="per_ie'+$("#percepciones").val()+'" id="per_ie'+$("#percepciones").val()+'" value="" class="text-input impe onlyNumber" size="8" maxlength="20"> </td>';
		columna = columna + '<td align="center"> <i class="fa fa-trash borraCon" idper="trper'+$("#percepciones").val()+'"></i> <input type="hidden" name="percep'+$("#percepciones").val()+'" id="percep'+$("#percepciones").val()+'" value="'+$("#percepciones").val()+'" /> </td>';
		columna = columna + '</tr>';

		creaTablaPercepciones(columna);

		$("#dialogPer").dialog( "close" );
		$("#percepciones").val(0);
	}
}//agregaConceptoRN_per


function creaTablaPercepciones(columna)
{	
	$('#detallePercepciones > tbody:last-child').append(columna);

	$('.borraCon').addClass('pointer');
	$('.borraCon').click(function() { var idC  = $(this).attr('idper');										  											
										jConfirm("¿Borrar concepto?", titAlert, function(r) { if(r) { $("#"+idC).remove();
																									muestraDetalleConcepto('detallePercepciones');
																									calcularImpGravado();
																									calcularImpExento();
																									} });
									});

	$(".impg").change(function(){ calcularImpGravado(); });	 
	$(".impe").change(function(){ calcularImpExento();  });
	
	muestraDetalleConcepto('detallePercepciones');
	soloNumeros();
}//creaTablaPercepciones


function calcularImpGravado()
{
  var totImpGravado = 0;   
 
  $(".impg").each(function() { totImpGravado = totImpGravado + Number($(this).val()); });	    
  
  $("#tot_gravado_emp").val(totImpGravado);
  $("#txtTotPE_RN").text("$ "+$.number(totImpGravado,2, '.', ',' ));  
  $("#TotalPercepciones").val(totImpGravado);

}//calcularImpGravado

function calcularImpExento()
{
  var totImpExento = 0;   
 
  $(".impe").each(function() { totImpExento = totImpExento + Number($(this).val()); });	    
   
  $("#tot_ext_emp").val(totImpExento);


}//calcularImpGravado



function agregaConceptoRN_ded()
{
	if($("#deducciones").val()=="0")
	{ jAlert("Favor de seleccionar un concepto para agregar " , titAlert);  }
	else
	{		
		var columna = '<tr id="trdec'+$("#deducciones").val()+'">';
		columna = columna + '<td align="center"> <input type="text" name="dec_cve'+$("#deducciones").val()+'" id="dec_cve'+$("#deducciones").val()+'" value="'+$("#deducciones").val()+'" class="text-input " size="5" maxlength="20"> </td>';
		columna = columna + '<td align="center"> <input type="text" name="dec_con'+$("#deducciones").val()+'" id="dec_con'+$("#deducciones").val()+'" value="'+$("#deducciones option:selected").text()+'" class="text-input " size="18" maxlength="20"> </td>';		
		columna = columna + '<td align="center"> <input type="text" name="dec_imp'+$("#deducciones").val()+'" id="dec_imp'+$("#deducciones").val()+'" value="" class="text-input tod onlyNumber" size="8" maxlength="20"> <input type="checkbox" id="dec_ir'+$("#deducciones").val()+'" name="dec_ir'+$("#deducciones").val()+'" deduc="'+$("#deducciones").val()+'" class="checkir" value="Si"> Impuestos retenidos </td>';		
		columna = columna + '<td align="center"><i class="fa fa-trash borraConDec" iddec="trdec'+$("#deducciones").val()+'"></i> <input type="hidden" name="deduc'+$("#deducciones").val()+'" id="deduc'+$("#deducciones").val()+'" value="'+$("#deducciones").val()+'" /> </td>';
		columna = columna + '</tr>';  

		creaTablaDeducciones(columna);

		$("#deducciones").val(0);
		$("#dialogDed").dialog( "close" );		
	}
}//agregaConceptoRN_ded

function creaTablaDeducciones(columna)
{
	$('#detalleDeducciones > tbody:last-child').append(columna);
		
	$('.borraConDec').addClass('pointer');
	$('.borraConDec').click(function(){ var idC  = $(this).attr('iddec');
										jConfirm("¿Borrar concepto?", titAlert, function(r) { if(r) { $("#"+idC).remove();	
																									  muestraDetalleConcepto('detalleDeducciones');
																									  calcularTotImpRet();
																									calcularTotDeduccion(); 
																									} });
									  });
	$('.checkir').click(function() { var deduc = $(this).attr('deduc');
									 if($(this).is(':checked'))
										{																							
											$("#dec_imp"+deduc).removeClass();
											$("#dec_imp"+deduc).addClass("text-input tir onlyNumber");												
										}
										else
										{ 
											$("#dec_imp"+deduc).removeClass();
											$("#dec_imp"+deduc).addClass("text-input tod onlyNumber");												
										}
										calcularTotImpRet();
										calcularTotDeduccion(); 
								   });
	$(".tod").change(function(){ calcularTotDeduccion(); });	 
	$(".tir").change(function(){ calcularTotImpRet();    });

	muestraDetalleConcepto('detalleDeducciones');
	soloNumeros();
}//creaTablaDeducciones


function calcularTotDeduccion()
{
  var totDeduccion = 0;   
 
  $(".tod").each(function() { totDeduccion = totDeduccion + Number($(this).val()); });	    
  
  $("#tot_o_deduc_emp").val(totDeduccion);

  $("#txtTotDE_RN").text("$ "+$.number( Number($("#tot_o_deduc_emp").val()) + Number($("#tot_imp_ret_emp").val()), 2, '.', ',' ));
  $("#TotalDeducciones").val( Number($("#tot_o_deduc_emp").val()) + Number($("#tot_imp_ret_emp").val()) );

}//calcularImpGravado

function calcularTotImpRet()
{
  var totImpRet = 0;   
 
  $(".tir").each(function() { totImpRet = totImpRet + Number($(this).val()); });	    
   
  $("#tot_imp_ret_emp").val(totImpRet);

  $("#txtTotDE_RN").text("$ "+$.number( Number($("#tot_o_deduc_emp").val()) + Number($("#tot_imp_ret_emp").val()), 2, '.', ',' ));
  $("#TotalDeducciones").val( Number($("#tot_o_deduc_emp").val()) + Number($("#tot_imp_ret_emp").val()) );

}//calcularImpGravado

function agregaConceptoRN_op()
{
	if($("#otrosPagos").val()=="0")
	{ jAlert("Favor de seleccionar un concepto para agregar " , titAlert);  }
	else
	{
		var columna = '<tr id="trop'+$("#otrosPagos").val()+'">';
		columna = columna + '<td align="center"> <input type="text" name="op_cve'+$("#otrosPagos").val()+'" id="op_cve'+$("#otrosPagos").val()+'" value="'+$("#otrosPagos").val()+'" class="text-input " size="5" maxlength="20"> </td>';
		columna = columna + '<td align="center"> <input type="text" name="op_con'+$("#otrosPagos").val()+'" id="op_con'+$("#otrosPagos").val()+'" value="'+$("#otrosPagos option:selected").text()+'" class="text-input " size="18" maxlength="20"> </td>';		
		columna = columna + '<td align="center"> <input type="text" name="op_imp'+$("#otrosPagos").val()+'" id="op_imp'+$("#otrosPagos").val()+'" value="" class="text-input totop onlyNumber" size="8" maxlength="20"> </td>';
		columna = columna + '<td align="center"><i class="fa fa-trash borraConOP" idop="trop'+$("#otrosPagos").val()+'"></i> <input type="hidden" name="op'+$("#otrosPagos").val()+'" id="op'+$("#otrosPagos").val()+'" value="'+$("#otrosPagos").val()+'" /> </td>';
		columna = columna + '</tr>';                  		

		creaTablaOtrosPagos(columna);

		$("#otrosPagos").val(0);
		$("#dialogOP").dialog( "close" );
		
	}		
}//agregaConceptoRN_op

function creaTablaOtrosPagos(columna)
{
	$('#detalleOtrosPagos > tbody:last-child').append(columna);

	$('.borraConOP').addClass('pointer');
	$('.borraConOP').click(function() { var idC  = $(this).attr('idop');										  											
										jConfirm("¿Borrar concepto?", titAlert, function(r) { if(r) { $("#"+idC).remove();	
																										muestraDetalleConcepto('detalleOtrosPagos');
																										calcularTotOP();
																									} });
										});
	$(".totop").change(function(){ calcularTotOP();  });
									
	muestraDetalleConcepto('detalleOtrosPagos');												
	soloNumeros();
}//creaTablaOtrosPagos

function calcularTotOP()
{
  var totOP = 0;   
 
  $(".totop").each(function() { totOP = totOP + Number($(this).val()); });	    

  $("#txtTotOP_RN").text("$ "+$.number( totOP, 2, '.', ',' ));
  $("#TotalOtrosPagos").val( totOP );

}//calcularTotOP


function agregaConceptoRN_in()
{
	if($("#incapacidades").val()=="0")
	{ jAlert("Favor de seleccionar un concepto para agregar " , titAlert);  }
	else
	{		
		var columna = '<tr id="trInc'+$("#incapacidades").val()+'">';
		columna = columna + '<td align="center"> <small>'+$("#incapacidades").val()+'</small>  </td>';
		columna = columna + '<td align="center"> <small>'+$("#incapacidades option:selected").text()+'</small> <input type="hidden" name="inc_con'+$("#incapacidades").val()+'" id="inc_con'+$("#incapacidades").val()+'" value="'+$("#incapacidades option:selected").text()+'" /></td>';		
		columna = columna + '<td align="center"> <input type="text" name="inc_dias'+$("#incapacidades").val()+'" id="inc_dias'+$("#incapacidades").val()+'" value="1" class="text-input onlyNumber" size="10" maxlength="6"> </td>';		
		columna = columna + '<td align="center"> <input type="text" name="inc_imp'+$("#incapacidades").val()+'"  id="inc_imp'+$("#incapacidades").val()+'"  value=""  class="text-input totinc onlyNumber" size="8" maxlength="20"> </td>';		
		columna = columna + '<td align="center"><i class="fa fa-trash borraConInc" idinc="trInc'+$("#incapacidades").val()+'"></i> <input type="hidden" name="inc'+$("#incapacidades").val()+'" id="inc'+$("#incapacidades").val()+'" value="'+$("#incapacidades").val()+'" /> </td>';
		columna = columna + '</tr>';                  
	
		creaTablaIncapacidades(columna);

		$("#incapacidades").val(0);
		$("#dialogInc").dialog( "close" );		
	}		
}//agregaConceptoRN_in

function creaTablaIncapacidades(columna)
{
	$('#detalleIncapacidades > tbody:last-child').append(columna);

	$('.borraConInc').addClass('pointer');
	$('.borraConInc').click(function() { var idC  = $(this).attr('idinc');										  											
										  jConfirm("¿Borrar concepto?", titAlert, function(r) { if(r) { $("#"+idC).remove();
																									  muestraDetalleConcepto('detalleIncapacidades');
																									//calcularTotFacturas();
																									} });
									  });
	muestraDetalleConcepto('detalleIncapacidades');												
	soloNumeros();
}//creaTablaIncapacidades



function empty(e) {
                    switch(e) {
                        case "":                 
                        case null:
                        case false:
                        case typeof this === "undefined":
                            return "";
                                default : return e;
                    }
                }
function isEmpty(e) {
                    switch(e) {
                        case "":                 
                        case null:
                        case false:
                        case typeof this === "undefined":
                            return true;
                                default : return false;
                    }
                }                


function submitChartAX(baseURL,typeChart) 
{
    $("#form"+typeChart).validationEngine();        
    if($("#form"+typeChart).validationEngine('validate'))
        { cargaChartAX(baseURL,typeChart);  }
}


function cargaChartAX(baseURL,typeChart)
{   var paramChart   = null;
    var chartService = null;    

    $.ajax({data      :  {"type" : typeChart, "paramDe":$("#paramDe"+typeChart).val(),"paramHasta":$("#paramHasta"+typeChart).val(),"typeParam":$("input[name=typeParam"+typeChart+"]:checked").val(),"typeParamII":$("input[name=typeParam"+typeChart+"II]:checked").val() },
            url       :  baseURL+'bi/dataForChartAX/',
            type      : 'post',
            dataType  : 'json',
            beforeSend: function () { $("#homeChart").html('');  },
            success   : function (data) 
                        { /*** INI DIBUJA LA GRAFICA CON LOS PARAMETROS DEFINIDOS Y CON LOS DATOS EXTRAIDOS DE AJAX  **/  
                            
                          switch(typeChart) 
                          {case "SE":paramChart = {    chart:       { renderTo  : 'containerService',
                                                                      type      : 'column' },
                                                       title:       { text      : 'Profit en MXN por Servicios '+$("#companyName").val() },
                                                       subtitle:    { text      : data['subtitulo'] },
                                                       xAxis:       { categories: data['data']['categories'],
                                                                      crosshair : true,
                                                                      title: { text: 'Meses'}
                                                                    },
                                                       yAxis:       { title      : { text: 'Profit MXN'}
                                                                    },
                                                       legend:      { align: 'center',
                                                                      y    : 10,
                                                                      floating: true,
                                                                      backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',                                                                      
                                                                      shadow: true
                                                                    },             
                                                       tooltip:     { headerFormat: '<b>{point.x}</b><br/>',
                                                                      pointFormat: '{series.name}: ${point.y} Profit en MXN'
                                                                    },
                                                        plotOptions:{ column: { stacking  : 'normal',
                                                                                dataLabels: { enabled: true,
                                                                                              color  : (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                                                                                            }
                                                                              }
                                                                    },             
                                                       series:      data['data']['data'],
                                                       credits:     { enabled: false }
                                                  };
                             break;
                             case "CL":var Tooltip =($("input[name=typeParam"+typeChart+"II]:checked").val()=="N"?'{series.name}: <b>{point.x}</b> = <b>{point.percentage:.1f}%</b> <br/>':'{series.name}: <b>${point.x} MXN profit</b> = <b>{point.percentage:.1f}%</b> <br/>');
                                       paramChart = { chart:    { renderTo   : 'containerII',
                                                                   type      : 'pie',
                                                                   options3d : { enabled: true, alpha: 45, beta: 0 }
                                                                },
                                                      title:    { text       : 'Porcentaje de participación '+$("#companyName").val() },
                                                      subtitle: { text       : data['subtitulo'] },
                                                      tooltip:  { pointFormat: Tooltip,
                                                                  backgroundColor: { linearGradient: [0, 0, 0, 60],
                                                                                     stops         : [ [0, '#FFFFFF'], [1, '#E0E0E0'] ]
                                                                                   },
                                                                  borderWidth: 1,                                                                  
                                                                  borderRadius: 10 
                                                                },
                                                      plotOptions: { pie: { allowPointSelect: true,
                                                                            cursor          : 'pointer',
                                                                            depth           : 35,
                                                                            dataLabels      : { enabled: true, format: '{point.name}' }
                                                                          }
                                                                   },
                                                      series:  [{  type: 'pie',
                                                                   name: 'Participación',
                                                                   data: data['data']
                                                                }],
                                                      credits:  { enabled: false }
                                                    };                             
                             break;
                             case "CT":paramChart ={  chart:    { renderTo   : 'containerIII',
                                                                  plotBackgroundColor: null,
                                                                  plotBorderWidth: 0,
                                                                  plotShadow: false
                                                                },
                                                      title:    { text: 'Total<br>de registros<br>por Status',
                                                                  align: 'center',
                                                                  verticalAlign: 'middle',
                                                                  y: 40 
                                                                },
                                                      subtitle: { text           : data['subtitulo'] },
                                                      tooltip:  { pointFormat    : 'Total: <b>{point.x:,.0f}</b> representando el <b>{point.percentage:.1f}%</b>',
                                                                  backgroundColor: { linearGradient: [0, 0, 0, 60],
                                                                                     stops         : [ [0, '#FFFFFF'], [1, '#E0E0E0'] ]
                                                                                   },
                                                                  borderWidth : 1,                                                                  
                                                                  borderRadius: 10 
                                                                },
                                                      plotOptions: { pie: { dataLabels: { enabled: true,
                                                                                          distance: -50,
                                                                                          style: { fontWeight: 'bold',
                                                                                                   color     : 'white'
                                                                                                 }
                                                                                        },
                                                                            startAngle: -90,
                                                                            endAngle  : 90,
                                                                            center    : ['50%', '75%']
                                                                           }
                                                                    },
                                                      series:   [{ type     : 'pie',
                                                                   name     : 'Cotizaciones',
                                                                   innerSize: '50%',
                                                                   data     : data['data']
                                                                }],
                                                      credits:  { enabled: false }
                                                    };
                             paramChart.series[0].data   = data['data']['data'];
                             break;
                             case "VD":paramChart = {  chart:       { renderTo  : 'containerIV',
                                                                      type      : 'column'
                                                                    },
                                                       title:       { text      : 'Reporte de Comisiones '+$("#companyName").val() },
                                                       subtitle:    { text      : data['subtitulo'] },
                                                       xAxis:       { categories: data['data']['categories'],
                                                                      crosshair : true,
                                                                      title: { text: 'Meses'}
                                                                    },
                                                       yAxis:       { title : { text: 'Monto de comisiones en MXN'} },
                                                       legend:      { align          : 'center',
                                                                      y              : 10,
                                                                      floating       : true,
                                                                      backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',                                                                      
                                                                      shadow         : true
                                                                    },             
                                                       tooltip:     { headerFormat: '<b>{point.x}</b><br/>',
                                                                      pointFormat : '{series.name}: ${point.y} de comision en MXN'
                                                                    },
                                                        plotOptions:{ column: { stacking  : 'normal',
                                                                                dataLabels: { enabled: true,
                                                                                              color  : (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                                                                                            }
                                                                              }
                                                                    },             
                                                       series:      data['data']['data'],
                                                       credits:     { enabled: false }
                                                  };
                             break;
                          };
                          
                          Highcharts.setOptions({ lang: { decimalPoint: '.', thousandsSep: ',' } });
                          chartService = new Highcharts.Chart(paramChart);
                          
                          /*** FIN DIBUJA LA GRAFICA CON LOS PARAMETROS DEFINIDOS Y CON LOS DATOS EXTRAIDOS DE AJAX  **/  
                        }, 
            error     : function(err) { jAlert("Ha ocurrido un error cargaChartAX en " + err.status + " " + err.statusText,titAlert); }
          }); 
}


function submitReportExcelAX(baseURL,typeReport) 
{
    $("#form"+typeReport).validationEngine();        
    if($("#form"+typeReport).validationEngine('validate'))
        { reportExcelAX(baseURL,typeReport);  }
}


function reportExcelAX(baseURL,typeReport)
{   var paramReport   = null;
 
	switch (typeReport)
	{
		case 'IVA'	 : paramReport = { "rfc":$("#rfc"+typeReport).val(),"paramDe":$("#paramDe"+typeReport).val(),"paramHasta":$("#paramHasta"+typeReport).val(), "iva_costo":$("input[name=iva_costo]:checked").val(), "iva_venta":$("input[name=iva_venta]:checked").val() }; break;
		case 'ORIGEN': paramReport = { "origen":$("#origen").val(),"paramDe":$("#paramDe"+typeReport).val(),"paramHasta":$("#paramHasta"+typeReport).val() }; break;
		case 'EDOCTA': paramReport = { "rfc":$("#rfc"+typeReport).val(),"paramDe":$("#paramDe"+typeReport).val(),"paramHasta":$("#paramHasta"+typeReport).val() }; break;
	}
	
    $.ajax({data      :  paramReport,
            url       :  baseURL+'bi/reportExcelAX'+typeReport+'/',
            type      : 'post',
            dataType  : 'json',			
			beforeSend: function () { $("#homeReportExcel"+typeReport).html(""); $("#homeReportExcel"+typeReport).html("<img src=\""+baseURL+"images/loading.gif\"> Espere por favor...");},
            success   : function (resp) 
						{ $("#homeReportExcel"+typeReport).html(resp['expFile']);						  
                        }, 
            error     : function(err) { jAlert("Ha ocurrido un error reportExcelAX en " + err.status + " " + err.statusText,titAlert); }
          }); 
}

function ocultaBotonesVPTim()
{
	var botones = $(".ui-dialog-buttonset").children();                                                                   
	$(botones).first().hide();
	$(botones).first().next().hide();
}


function openModalTimbrarAX(baseURL, id_pedido, rfc)
{ //submitFormAX(baseURL,\"FLET\",\"$id_pedido\",\"$accion\")
  var paramReport = { "id_pedido":id_pedido, "rfc":rfc };	
	
    $.ajax({data      :  paramReport,
            url       :  baseURL+'pedido/datosTimbrarAX',
            type      : 'post',
            dataType  : 'json',			
			beforeSend: function () { $("#confirmTimb").html(""); $("#confirmTimb").html("<img src=\""+baseURL+"images/loading.gif\"> Cargando información. Espere por favor...");},
            success   : function (resp) 
						{ $("#confirmTimb").html("");
						/************ EMISOR ************/
						  $("#rfcEmisor"  ).val(resp['emisor']['rfc']);
						  $("#rsEmisor"   ).val(resp['emisor']['nombre_fiscal']);
						  $("#cpEmisor"   ).val(resp['emisor']['cp_fiscal']);
						  $("#emailEmisor").val(resp['emisor']['correo_fiscal']);
						  $("#labelDomFis").html( resp['emisor']['domicilio_fiscal']);
						  $("#domFiscalEmisor").toggle();
						  $("#togdomFiscalEmisor").click(function(){ var isHidden = $("#domFiscalEmisor").is(":hidden");                                    
																		if(isHidden) { $("#imgdomFiscalEmisor").removeClass("fa-plus" ).addClass("fa-minus" ); 
																					$("#domFiscalEmisor").show();
																					}
																		else         { $("#imgdomFiscalEmisor").removeClass("fa-minus").addClass("fa-plus"); 
																					$("#domFiscalEmisor").hide();
																					}                                                
																});
						/************ EMISOR ************/

						/************ RECEPTOR ************/
						$("#rfcReceptor"  ).val(resp['cliente']['rfc']);
						$("#rsReceptor"   ).val(resp['cliente']['razon_social']);
						$("#emailReceptor").val(resp['cliente']['correo']);
						$("#cpReceptor"   ).val( (resp['cliente']['cp'].length == 4?"0"+resp['cliente']['cp'] : resp['cliente']['cp'] ));
						$("#labelDomFisReceptor" ).html( resp['cliente']['calle'] + " " + resp['cliente']['numero'] + " " + resp['cliente']['colonia'] + " " + resp['cliente']['delegacion'] + " " + resp['cliente']['estado'] + " " + resp['cliente']['pais'] + " " + resp['cliente']['cp']);
						$("#domFiscalReceptor"   ).toggle();
						$("#togdomFiscalReceptor").click(function(){ var isHidden = $("#domFiscalReceptor").is(":hidden");                                    
																	  if(isHidden) { $("#imgdomFiscalReceptor").removeClass("fa-plus" ).addClass("fa-minus" ); 
																					 $("#domFiscalReceptor").show();
																				   }
																	  else         { $("#imgdomFiscalReceptor").removeClass("fa-minus").addClass("fa-plus"); 
																				     $("#domFiscalReceptor").hide();
																				   }                                                
															  });
						/************ RECEPTOR ************/
						
						/************ CONCEPTOS ************/							
						$("#monedaSAT").val(resp['moneda']['moneda']);
						$("#monedaSAT").combobox();
						$("#tcSAT"    ).val(resp['moneda']['moneda']=="MXN"?1:resp['moneda']['tipo_cambio']);
						conceptosSAT = resp['conceptos'];
					    
						$('#conceptosSinCodSAT').html("");
						$.each( conceptosSAT, function(i, value) { if(idCargoAsignado(value['id_cargo'])==false){ $('#conceptosSinCodSAT').append($('<option>').text(value['cargo']).attr('value', value['id_cargo']).attr('iva', value['iva']) ); } });
						//$('#conceptosSinCodSAT').multiSelect();
						/************ CONCEPTOS ************/

						/************ FACTURA CREADA ************/						
						if ( JSON.stringify(resp['factura']).length > 2 )
						{
							var	iconF = "";
							var numConceptosConCveSAT =-1;
							
							$("#id_factura"   ).val(resp['factura']['id_factura']);
							$("#rfcReceptor"  ).val(resp['factura']['rfc']);
							$("#rsReceptor"   ).val(resp['factura']['nombre']);
							$("#emailReceptor").val(resp['factura']['emailReceptor']);
							$("#cpReceptor"   ).val(resp['factura']['cpReceptor']);	
							
							$("#monedaSAT").val(resp['factura']['moneda']);						
							$("#tcSAT"    ).val(resp['factura']['tipocambio']);

							
							if ( resp['vistaprevia'] == "1" )
							   { 	
									if ( resp['cfdiRel'].length == "0" )
									{ 
										iconF = "<a href='"+$("#baseURL").val()+resp["dir"]+"PREFACTURA_"+resp["factura"]["tipocomprobante"]+"_"+resp["factura"]["serie"]+"_0.pdf' target='_blank'> <img src='"+$("#baseURL").val()+"images/check.png'> <img title='PROFORMA(Plantilla)' src='"+$("#baseURL").val()+"images/logoPDF.png' width='25px' height='25px'> PROFORMA(Plantilla)</a>"; 										
										$("#vistapreviaPDF" ).html(iconF); 	
							   		} 
									else
									{ 
										iconF = "<a href='"+$("#baseURL").val()+resp["dir"]+"PREFACTURA_"+resp["factura"]["tipocomprobante"]+"_"+resp["factura"]["serie"]+"_0.pdf' target='_blank'> <img src='"+$("#baseURL").val()+"images/check.png'> <img title='PROFORMA(Plantilla)' src='"+$("#baseURL").val()+"images/logoPDF.png' width='25px' height='25px'> PROFORMA(Plantilla)</a>"; 
										$("#vp_cfdirelPDF"   ).html(iconF);
										$("#tipo_comprobante").val( resp['cfdiRel'][0]['tipo_comprobante'] );
										$("#tipo_relacion"   ).val( resp['cfdiRel'][0]['tipo_relacion'] );
										var cfdiRel = 0;
										$.each( resp['cfdiRel'], function(i, value) 
											{  ++cfdiRel;
												var	TRcfdirel = "<tr>  <td style='text-align:right' ><input type='checkbox' class='selCfdiRel' id='CfdiRel"+cfdiRel+"' name='CfdiRelSel"+cfdiRel+"' value='"+value['uuid']+"' checked> </td>"+
																		"<td style='text-align:left'  ><small>"+value['folio']+"</small> </td>"+
																		"<td style='text-align:left'  ><small>"+value['uuid_relacionado']+"</small> </td>"+
																		"<td style='text-align:left'  ><small><a href='"+value["adjunto"]+"' target='_blank'> <img title='Factura' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>PDF</small> </a></small> </td>"+
																		"<td style='text-align:left'  ><small>"+value['total']+"</small> </td>"+                                
																		"<td style='text-align:left'  ><small>"+value['moneda']+"</small></td> "+            
																		"<td style='text-align:left'  ><small>"+value['fecha_timbrado']+"</small></td>"+									  
																"</tr>";
												$("#tblCfdiRel tr:last").after(TRcfdirel);				
				
											});			
											$("#cfdiRelTot").val(cfdiRel);
									}
									$("#tblConceptosSAT").html("<tr>  <td> <small>Clave Prod./Serv. SAT</small></td>"
											+"<td> <small>Concepto</small></td>"
											+"<td> <small>Cve UM SAT</small></td>"
											+"<td> <small>UM</small></td>"											
											+"<td> <small>Cantidad</small></td>"
											+"<td> <small>Precio Unitario</small></td>"
											+"<td> <small>Importe</small></td>"
											+"<td> </td>"
										+"</tr>"); 								
									$.each( resp['facturaCon'], function(i, value) 
									{  ++numConceptosConCveSAT;
										$('#tblConceptosSAT').append( "<tr>   <td>"+value['ClaveProdServ']+" <input value='"+value['ClaveProdServ']+"' type='hidden' name='conSATCodigo"+numConceptosConCveSAT+"' id='conSATCodigo"+numConceptosConCveSAT+"'/></td>"
																			+"<td> <input value='"+value['descripcion'] +"' 	 size='15' type='text' name='conSATCargo"+numConceptosConCveSAT+"'     id='conSATCargo"+numConceptosConCveSAT+"'/></td>"
																			+"<td>"+value['ClaveUnidad']+" <input value='"+value['ClaveUnidad']+"' type='hidden' name='conSATCveUnidad"+numConceptosConCveSAT+"' id='conSATCveUnidad"+numConceptosConCveSAT+"'/></td>"
																			+"<td> <input value='SERVICIO'			 	 size='6'  type='text' name='conSATUM"+numConceptosConCveSAT+"' 	   id='conSATUM"+numConceptosConCveSAT+"'/></td>"
																			+"<td> <input value='"+Number(value['cantidad']).toFixed(0)  +"' size='1'  type='text' name='conSATCantidad"+numConceptosConCveSAT+"' id='conSATCantidad"+numConceptosConCveSAT+"' idcon='"+numConceptosConCveSAT+"' class='onlyNumber calcImp'/></td>"
																			+"<td>$<input value='"+Number(value['valorunitario']).toFixed(2) +"' size='4'  type='text' name='conSATValorUni"+numConceptosConCveSAT+"' id='conSATValorUni"+numConceptosConCveSAT+"' idcon='"+numConceptosConCveSAT+"' class='onlyNumber calcImp convTC'/></td>"
																			+"<td>$<input value='"+Number(value['importe']).toFixed(2)+"' size='4'  type='text' name='conSATsubtot"+numConceptosConCveSAT+"'   id='conSATsubtot"+numConceptosConCveSAT+"'   class='importeCargoSAT "+(value['sumaIVA']=="0"?"":"sumaIva")+" onlyNumber convTC'/>"
																			+"     <input value='"+value['sumaIVA']+"' type='hidden' name='conSATIVA"+numConceptosConCveSAT+"' id='conSATIVA"+numConceptosConCveSAT+"'/>"+(value['sumaIVA']=="0"?"<small>NO iva</small>":"<small>+ IVA</small>")+"</td>"
																			+"<td> <img title='Borrar Concepto' src='"+$("#baseURL").val()+"/images/erase.png' class='borrarConcepto' valueC='"+value['ID'] +"' labelC='"+value['descripcion'] +"' ivaC='"+value['sumaIVA'] +"'  unidadC='"+value['cantidad'] +"' importeC='"+value['valorunitario'] +"' subtotalC='"+value['importe'] +"' width='20px'>"
																			+"     <input value='"+value['ID']+"' type='hidden' class='idCargo' name='conSATID"+numConceptosConCveSAT+"' id='conSATID"+numConceptosConCveSAT+"'/>"
																			+"</td>"
																	+"</tr>" );   
										$("#conceptosSinCodSAT option[value='"+value['ID']+"']").remove();
									});			
							   
									$(".calcImp").change(function(){ var objCon     = $(this);
																	var id_concepto = objCon.attr('idcon'); 
																	calculaImporteConcepto(id_concepto);
																	});
									calcularTotFacturas();
									$('.borrarConcepto').addClass('pointer');
									$('.borrarConcepto').click(function() { var objC   = $(this);
																			var valueC = objC.attr('valueC');
																			var labelC = objC.attr('labelC');
																			var ivaC   = objC.attr('ivaC');	
																			var unidadC   = objC.attr('unidadC');
																			var importeC  = objC.attr('importeC');
																			var subtotalC = objC.attr('subtotalC');											
																			jConfirm("¿Borrar concepto?", titAlert, function(r) { if(r) { borraConceptoFactura(objC, valueC, labelC, ivaC, unidadC, importeC, subtotalC); 
																																		calcularTotFacturas();
																																		} });
																			});
									$("#numConceptosConCveSAT").val( numConceptosConCveSAT );
							   }
							else
							   { 	
									$.each( resp['facturaCon'], function(i, value) 
										{ $("#conceptosSinCodSAT option[value='"+value['ID']+"']").remove();	});																
									
									$("#asignarCodigoSAT" ).val(resp['facturaCon'].length);

									limpiaConceptosFac();								
							   }
									
							$("#regimen_fiscal").val(resp['factura']['RegimenFiscal']);
							$('#uso_cfdi').combobox();
							$('#uso_cfdi').combobox('autocomplete', resp['factura']['UsoCFDIDesc']);
							$("#uso_cfdi").val(resp['factura']['UsoCFDI']);
							 
							$('#metodo_pago').combobox();
							$('#metodo_pago').combobox('autocomplete', resp['factura']['metodo_pagoDesc']);
							$("#metodo_pago").val(resp['factura']['metodo_pago']);
							
							$('#forma_pago').combobox();
							$('#forma_pago').combobox('autocomplete', resp['factura']['forma_pagoDesc']);
							$("#forma_pago").val(resp['factura']['forma_pago']);

							$("#notasFactura"    ).val(resp['factura']['notas']);
							$("#fecha_expedicion").val(resp['factura']['fe']);
							$("#emailReceptor"	 ).val(resp['factura']['emailReceptor']);
						}                                          
						/************ FACTURA CREADA ************/
						
						//if ( $('#conceptosSinCodSAT option').length <= 0) { jAlert("Embarque sin conceptos a facturar. Para generar una factura, es necesario, guardar primero la sección de 'Embarque/Flete'.", "FACTURACIÓN"); $( "#modalFac").dialog( "close" ); }

						iconF = ""; 	
						$('#tblRepFact').html( '<tr>'
												+'<td width="3% " style="text-align:right"><small>&nbsp;</small> </td>'
												+'<td width="15%" style="text-align:left"><small><strong>Factura</strong></small> </td> '
												+'<td width="11%" style="text-align:left"><small><strong>Saldo</strong> </small> </td> '              
												+'<td width="13%" style="text-align:left"><small><strong>Saldo Insoluto</strong></small></td>'
												+'<td width="25%" style="text-align:left"><small><strong>Fecha</strong></small></td>'
												+'<td width="7%" style="text-align:left"><small><strong># Parcial</strong></small></td>'
												+'<td width="10% " style="text-align:left"><small><strong>Moneda</strong></small></td>'
												+'<td width="10%" style="text-align:ccc"><small><strong>Status</strong></small></td>'
												+'<td width="3% " style="text-align:center"><small>&nbsp;</small> </td>'
												+'<td width="3% " style="text-align:center"><small>&nbsp;</small> </td>'
											+'</tr>');
						$.each( resp["adjuntoFac"], function(i, value) 
								{ $('#tblRepFact').append( "<tr> <td> <input type='radio' class='selFac' id='f"+value['id_factura']+"' name='facturaPedido' value='"+value['id_factura']+"'></td>"
																+"<td align='left'><a href='"+value["adjunto"]+"' target='_blank'><small>"+value['filename']+"</small></a></td>"
																+"<td align='left'><input value='"+value['total']+"' 		  type='hidden' name='sal"+value['id_factura']+"' id='sal"+value['id_factura']+"'/><small id='lblSal"+value['id_factura']+"'>$"+$.number(value['total'],2, '.', ',' )+"</small></td>"
																+"<td align='left'><input value='"+value['saldo_insoluto']+"' type='hidden' name='si" +value['id_factura']+"'    id='si" +value['id_factura']+"'/>"
																+"				   <input value='"+value['saldo_insoluto']+"' type='hidden' name='siIni" +value['id_factura']+"' id='siIni" +value['id_factura']+"'/><strong><small id='lblSi" +value['id_factura']+"'>$"+$.number(value['saldo_insoluto'],2, '.', ',' )+"</small></strong></td>"
																+"<td align='left'><small>"+value['fecha_timbrado']+" <strong>"+value['dias_vencidos']+"</strong></small></td>"
																+"<td align='center'><input value='"+value['num_parcialidades']+"' type='hidden' name='np" +value['id_factura']+"' id='np" +value['id_factura']+"'/><small id='lblNp" +value['id_factura']+"'>"+value['num_parcialidades']+"</small></td>"
																+"<td align='center'><input value='"+value['moneda']+"' type='hidden' name='monedaFact"+value['id_factura']+"' id='monedaFact"+value['id_factura']+"'/><small>"+value['moneda']+"</small></td>"
																+"<td align='center'><small id='lblStat" +value['id_factura']+"'>"+value['status']+"</small></td>"
																+"<td> <i class='fa fa-credit-card pagFact pointer' id='"+value['id_factura']+"' folio='"+value['folio']+"'> </i> </td>"
																+"<td> <i class='fa fa-remove cancelFact pointer'   id='"+value['id_factura']+"' folio='"+value['folio']+"'> </i> </td>"
														+"</tr>" );

								  let adjunto  = value["adjunto"];
								  let filaname = value["filename"];

								  iconF += "<a href='"+value["adjunto"]+"' target='_blank'> <img title='"+value["desc_adjunto"]+"' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>"+value["filename"]+"</small>"
								  		+  "</a>&nbsp;&nbsp;"
										+  "<a href='"+(adjunto.replace(".pdf", "_cfdi3_3.xml"))+"' target='_blank'> <img title='"+(adjunto.replace(".pdf", "_cfdi3_3.xml"))+"' src='"+$("#baseURL").val()+"images/logoXML.png' width='18px' height='18px'> <small>"+(filaname.replace(".pdf", "_cfdi3_3.xml"))+"</small>"
								  		+  "</a>&nbsp;&nbsp;"
										; 
								});
						$('.selFac').click(function() { seleccionaFactura( $(this).attr('value') ); }); 
						$('.pagFact'   ).click(function() { let idParam = $(this).attr('id'); let folioParam = $(this).attr('folio'); jConfirm("¿Cambiar el Status de la Factura con folio <b>"+folioParam+"</b> a PAGADA?", titAlert, function(r) { if(r) { pagarFacturaAX( idParam ); } }); }); 
			  			$('.cancelFact').click(function() { let idParam = $(this).attr('id'); let folioParam = $(this).attr('folio'); jConfirm("¿Está seguro de CANCELAR la factura con folio <b>"+folioParam+"</b>?", titAlert, function(r) { if(r) { cancelarFacturaAX( idParam ); } }); }); 
						$("#timbrarPDF").html(iconF);
						$("#tblREPs").html('<tr><td width="10%">Factura</td>'
                    							+'<td width="10%">  </td>'
												+'<td width="40%"> REP </td>'
												+'<td width="40%">  </td>'
											+'</tr> ');
						$.each( resp['facturaREP'], function(i, value) 
								{   var dirPath = value["adjunto"];
									dirPath     = dirPath.replace(value['filename'], "");

									var TRiconF = "<tr><td width='15%'> <a href='"+value["adjunto"]+"' target='_blank'><small>"+value['filename']+"</small></a> </td>"+
									"  <td width='5%' > <img src='"+$("#baseURL").val()+"images/check.png'> </td>"+
									"  <td width='65%'>" +value["fr"]+" " +"$"+$.number(value["monto_rep"], 2, '.', ',' )+" "+value["moneda_rep"]+" "+value["forma_pago_rep_desc"]+"</td>"+
									"  <td width='25%'> <a href='"+dirPath+value["path_pdf"]+"' target='_blank'>"+
									"					  <img title='REP' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>REP</small> </a></td>"+
									"</tr>";
								$("#tblREPs tr:last").after(TRiconF);
								});

						/************ FACTURAR GRID ************/
						$("#forma_pago_rep"  ).combobox();
						$("#moneda_rep"      ).combobox();
						$("#fecha_expedicion").datepicker({dateFormat: 'dd/mm/yy', maxDate: 2});
						$("#fecha_expedicion").datepicker( "option", "minDate", new Date() );                    
						$("#fecha_rep"       ).datepicker({dateFormat: 'dd/mm/yy', maxDate: 0});
						$("#forma_pago_rep option[value='99']").remove();
						$("#forma_pago_rep option[value='30']").remove();

						toggleSection("tblDatRep", "togREP", "fa-search-minus", "fa-search-plus"); 
						toggleSection("tblDatBan", "togDatBan", "fa-search-minus", "fa-search-plus"); 
						toggleSection("tblREPs"  , "togPagReg", "fa-search-minus", "fa-search-plus"); 

						$("#monto_rep"       ).change(function(){ calcularSaldoREP( Number($(this).val()) ); });
						$("#tc_rep"          ).change(function(){ calcularSaldoREP( Number($("#monto_rep").val()) ); });
						$("#moneda_rep"      ).change(function(){ calcularSaldoREP( Number($("#monto_rep").val()) ); });
						$("#descuentoSAT"    ).change(function(){ calcularTotFacturas(); });
						$('#buttonAsigCodSat').click(function() {  var conceptos    = $('#conceptosSinCodSAT').val();
																   var codigoSAT    = $('#cveProdSAT').val();
																   var cveUnidadSAT = $('#clave_unidadSAT').val();
																   asignarCodigoSAT(codigoSAT, cveUnidadSAT, conceptos);
																}); 
						$("#tipo_relacion").change(function(){  switch( $(this).val() )  
																	{	case "04":
																		case "07": 
																			$("#tipo_comprobante").val("I"); 
																		break;
																		case "01":
																		case "02": 
																		case "03": 
																			$("#tipo_comprobante").val("E"); 
																		break;
																		case "05":
																		case "06": 
																			$("#tipo_comprobante").val("T"); 
																		break;
																	}
															 });	
						$( "#cveProdSAT" ).autocomplete({
						source: function( request, response ) {
						$.ajax( { url     : baseURL+'pedido/cveProdSAT_AX',//"search.php",
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
						$.ajax( { url     : baseURL+'pedido/cveUnidadSAT_AX',//"search.php",
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
							$.ajax( { url     : baseURL+'pedido/uuidCfdiRel_AX',//"search.php",
									  type    : 'post',
									  dataType: "json",
									  data    : { search: request.term },
									  success : function( data ) { response( data ); }
									} );
							},
							minLength: 2,							
							select   : showResultUuidCfdiRel,
						  } );						

						soloNumeros();
						/************ FACTURAR GRID ************/
                        }, 
            error     : function(err) { jAlert("Ha ocurrido un error openModalTimbrarAX en " + err.status + " " + err.statusText,titAlert); }
		  }); 
}

function showResultUuidCfdiRel(event, ui) 
{	var param = {"uuid" : ui.item.value };
	$.ajax({data	  : param,
			url		  : $("#baseURL").val()+'gestion/traeUuidCfdiRelAX/',
			type	  : 'post',
			dataType  : 'json',
			beforeSend: function () { },
			success:  function (resp) 
			{	var cfdiRelTot= Number($("#cfdiRelTot").val()) + 1;
				var PDF = "" ;
				if(resp.length == 0)
				  {resp['folio']  = "";
				   resp['total']  = "";
				   resp['moneda'] = "";
				   resp['fecha_timbrado'] = "";
				   resp['uuid'] = ui.item.value.replace("Sin registros: '",'').replace("' (click para seleccionar)",'');
				  }
				  else
				  { PDF= "<a href='"+resp["adjunto"]+"' target='_blank'> <img title='Factura' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>PDF</small> </a></small>";}
				
				var	TRcfdirel = "<tr>  <td style='text-align:right' ><input type='checkbox' class='selCfdiRel' id='CfdiRel"+cfdiRelTot+"' name='CfdiRelSel"+cfdiRelTot+"' value='"+resp['uuid']+"' checked> </td>"+
									  "<td style='text-align:left'  ><small>"+resp['folio']+"</small> </td>"+
									  "<td style='text-align:left'  ><small>"+resp['uuid']+"</small> </td>"+
									  "<td style='text-align:left'  ><small>"+PDF+"</td>"+
									  "<td style='text-align:left'  ><small>"+resp['total']+"</small> </td>"+                                
									  "<td style='text-align:left'  ><small>"+resp['moneda']+"</small></td> "+            
									  "<td style='text-align:left'  ><small>"+resp['fecha_timbrado']+"</small></td>"+									  
								"</tr>";

				$("#tblCfdiRel tr:last").after(TRcfdirel);
				$("#uuidCfdiRel"       ).val('');
				$("#cfdiRelTot"	   	   ).val(cfdiRelTot);
			},				
			error: function(err) { alert("Ha ocurrido un traeDatosFacturaAX error: " + err.status + " " + err.statusText); }
	});
}

function seleccionaFactura(value)
{
	$("#id_factura" ).val( value );		
	$("#parcial_rep").val(Number( $("#np"+value).val() ) + 1);
	traeDatosFacturaAX( value ); 
}

function limpiaConceptosFac()
{	
	$("#totalSAT"	   	    ).val( '' );
	$("#saldoInsolutoFac"	).val( '' );
	$("#saldoInsolutoFacIni").val( '' );
	$("#subtotalSAT"		).val( '' );
	$("#ivaSAT"	  			).val( '' );
	$("#totalSAT"	  		).val( '' );
	$("#saldoInsolutoFac"	).val( '' );
	$("#descuentoSAT"  		).val( '0.0' );
	$("#tcSAT"  	   		).val( 1  );
	$("#monedaSAT"	   		).val('MXN');

	$("#tblConceptosSAT").html("<tr>  <td> <small>Clave Prod./Serv. SAT</small></td>"
									+"<td> <small>Concepto</small></td>"
									+"<td> <small>Cve UM SAT</small></td>"
									+"<td> <small>UM</small></td>"											
									+"<td> <small>Cantidad</small></td>"
									+"<td> <small>Precio Unitario</small></td>"
									+"<td> <small>Importe</small></td>"
									+"<td> </td>"
								+"</tr>");

	$("#subtotalSATLbl").html("$ 0.0" );
	$("#ivaSATLbl"	   ).html("$ 0.0" );
	$("#totalSATLbl"   ).html("$ 0.0" );									
	$('#monedaSAT'	   ).combobox();
	$('#monedaSAT'	   ).combobox('autocomplete', 'MXN');
}


function idCargoAsignado(id_cargo)
{

	var cargoAsignado = $('.idCargo').val() == id_cargo ? true : false;	
	return cargoAsignado;
}


function asignarCodigoSAT(codigoSAT, cveUnidadSAT, conceptosPorAsignar)
{   
	var numConceptosConCveSAT = Number($("#numConceptosConCveSAT").val());
	
	if (isEmpty(codigoSAT) == true || isEmpty(cveUnidadSAT) == true || conceptosPorAsignar == null)
	   {  jAlert("Favor de ingresar el producto/sevicio cotizado, la clave y la unidad de medida del SAT", titAlert); }
	else{
	if( numConceptosConCveSAT == 0 )	  
	  { $("#tblConceptosSAT").html("<tr>  <td> <small>Clave Prod./Serv. SAT</small></td>"
											+"<td> <small>Concepto</small></td>"
											+"<td> <small>Cve UM SAT</small></td>"
											+"<td> <small>UM</small></td>"											
											+"<td> <small>Cantidad</small></td>"
											+"<td> <small>Precio Unitario</small></td>"
											+"<td> <small>Importe</small></td>"
											+"<td> </td>"
										+"</tr>"); 
	  }
			
		$.each( conceptosPorAsignar, function(i, searchValue) 
		{
			$.each( conceptosSAT, function(i, value) 
				{  if ( value['id_cargo'] == searchValue) { ++numConceptosConCveSAT;
															$('#tblConceptosSAT').append( "<tr>   <td>"+codigoSAT+" <input value='"+codigoSAT+"' type='hidden' name='conSATCodigo"+numConceptosConCveSAT+"' id='conSATCodigo"+numConceptosConCveSAT+"'/></td>"
																								+"<td> <input value='"+value['cargo'] +"' 	 size='15' type='text' name='conSATCargo"+numConceptosConCveSAT+"'     id='conSATCargo"+numConceptosConCveSAT+"'/></td>"
																								+"<td>"+cveUnidadSAT+" <input value='"+cveUnidadSAT   +"' type='hidden' name='conSATCveUnidad"+numConceptosConCveSAT+"' id='conSATCveUnidad"+numConceptosConCveSAT+"'/></td>"
																								+"<td> <input value='SERVICIO'			 	 size='6'  type='text' name='conSATUM"+numConceptosConCveSAT+"' 	   id='conSATUM"+numConceptosConCveSAT+"'/></td>"
																								+"<td> <input value='"+Number(value['unidad']).toFixed(0)  +"' size='1'  type='text' name='conSATCantidad"+numConceptosConCveSAT+"' id='conSATCantidad"+numConceptosConCveSAT+"' idcon='"+numConceptosConCveSAT+"' class='onlyNumber calcImp'/></td>"
																								+"<td>$<input value='"+Number(value['importe']).toFixed(2) +"' size='4'  type='text' name='conSATValorUni"+numConceptosConCveSAT+"' id='conSATValorUni"+numConceptosConCveSAT+"' idcon='"+numConceptosConCveSAT+"' class='onlyNumber calcImp convTC'/></td>"
																								+"<td>$<input value='"+Number(value['subtotal']).toFixed(2)+"' size='4'  type='text' name='conSATsubtot"+numConceptosConCveSAT+"'   id='conSATsubtot"+numConceptosConCveSAT+"'   class='importeCargoSAT "+(value['iva']=="0"?"":"sumaIva")+" onlyNumber convTC'/>"
																								+"     <input value='"+value['iva']+"' type='hidden' name='conSATIVA"+numConceptosConCveSAT+"' id='conSATIVA"+numConceptosConCveSAT+"'/>"+(value['iva']=="0"?"<small>NO iva</small>":"<small>+ IVA</small>")+"</td>"
																								+"<td> <img title='Borrar Concepto' src='"+$("#baseURL").val()+"/images/erase.png' class='borrarConcepto' valueC='"+value['id_cargo'] +"' labelC='"+value['cargo'] +"' ivaC='"+value['iva'] +"' unidadC='"+value['unidad'] +"' importeC='"+value['importe'] +"' subtotalC='"+value['subtotal'] +"' width='20px'>"
																								+"     <input value='"+value['id_cargo']+"' type='hidden' class='idCargo' name='conSATID"+numConceptosConCveSAT+"' id='conSATID"+numConceptosConCveSAT+"'/>"
																								+"</td>"
																						+"</tr>" );   
															$("#conceptosSinCodSAT option[value='"+searchValue+"']").remove();
														} 
				});			
		});
		$(".calcImp").change(function(){ var objCon     = $(this);
										var id_concepto = objCon.attr('idcon'); 
										calculaImporteConcepto(id_concepto);
										});
		calcularTotFacturas();
		$('.borrarConcepto').addClass('pointer');
		$('.borrarConcepto').click(function() { var objC   = $(this);
												var valueC = objC.attr('valueC');
												var labelC = objC.attr('labelC');
												var ivaC   = objC.attr('ivaC');			
												var unidadC   = objC.attr('unidadC');
												var importeC  = objC.attr('importeC');
												var subtotalC = objC.attr('subtotalC');									
												jConfirm("¿Borrar concepto?", titAlert, function(r) { if(r) { borraConceptoFactura(objC, valueC, labelC, ivaC, unidadC, importeC, subtotalC); 
																											  calcularTotFacturas();																										
																											} });
												});
		$("#numConceptosConCveSAT").val( numConceptosConCveSAT );		

		$("#cveProdSAT"		).val('');
		$("#clave_unidadSAT").val('');
	}
}

function calculaImporteConcepto(id_concepto)
{ 
  
  var v_cantidad  = Number($("#conSATCantidad"+id_concepto).val());  
  var v_precioUni = Number($("#conSATValorUni"+id_concepto).val());
  var v_importe   = (v_cantidad * v_precioUni).toFixed(2);

  $("#conSATsubtot"+id_concepto).val( v_importe );

  calcularTotFacturas();
   
}

function calcularTotFacturas()
{ 
  var v_subtotalSAT  = 0;
  var v_subTotIVASAT = 0;
  var v_totSAT	     = 0;
  var v_IVA_imp	     = 0;
  var v_Desc_imp	 = 0;
  var v_IVA_por	     = Number($("#IVA_POR").val());  
  var v_Desc_por	 = Number($("#descuentoSAT").val());
  var lbl_IvaNoCon	 = 0;

  $(".importeCargoSAT").each(function() { v_subtotalSAT = v_subtotalSAT + Number($(this).val()); });

  $(".sumaIva").each(function() { v_subTotIVASAT = v_subTotIVASAT + Number($(this).val()); });

  v_subtotalSAT = v_subtotalSAT - (v_subtotalSAT * (v_Desc_por/100));
  v_subTotIVASAT= v_subTotIVASAT- (v_subTotIVASAT* (v_Desc_por/100));

  v_Desc_imp	= v_subtotalSAT;

  v_IVA_imp = v_IVA_por * v_subTotIVASAT;  

  v_subtotalSAT = truncaA2Decimales(v_subtotalSAT);
  v_IVA_imp 	= truncaA2Decimales(v_IVA_imp);
  v_totSAT  	= v_subtotalSAT + v_IVA_imp;
  lbl_IvaNoCon	= (v_IVA_imp==0?" <small>(conceptos sin IVA)</small>":"");

  
  $("#subtotalSATLbl").html("$"+$.number(v_subtotalSAT,2, '.', ',' ) );
  $("#ivaSATLbl"	 ).html("$"+$.number(v_IVA_imp,2, '.', ',' )+lbl_IvaNoCon );
  $("#totalSATLbl"	 ).html("$"+$.number(v_totSAT,2, '.', ',' ) );
  $("#saldoFactura"	 ).html("$"+$.number(v_totSAT,2, '.', ',' ) );
  $("#saldoInsoluto" ).html("$"+$.number(v_totSAT,2, '.', ',' ) );
  
  $("#subtotalSAT").val(v_subtotalSAT.toFixed(2) );
  $("#ivaSAT"	  ).val(v_IVA_imp.toFixed(2) );
  $("#totalSAT"	  ).val(v_totSAT.toFixed(2) );
  $("#saldoInsolutoFac").val( v_totSAT.toFixed(2) );
  
}
function truncaA2Decimales(monto)
{	
	var truncated = Math.floor(monto * 100) / 100;

	return truncated;
}

function calcularSaldoREP(montoREP)
{
	var titFormVal = titAlert;
	var id_factura = $('input:radio[name=facturaPedido]:checked').val();

	if ( typeof id_factura === "undefined" )
		{   jAlert("Favor de seleccionar la Factura a la cual se le aplicará el REP " , titAlert); }
	else
		{ 	var v_totalSAT    = Number( $("#siIni"+id_factura).val()  );			
			var saldoInsoluto = Number( $("#si"+id_factura).val() );
			var tc			  = Number( $("#tc_rep").val() );
						
			if( $("#monedaSAT").val() == $("#moneda_rep").val() )
			{ 	saldoInsoluto = v_totalSAT - montoREP ;
				$("#lblSi"+id_factura).html("$"+$.number(saldoInsoluto, 2, '.', ',' ) );
				$("#si"+id_factura   ).val(saldoInsoluto);
			}
			else
			{ 
				if ($("#tc_rep").val() == "")
				{   jAlert("Es obligatario ingresar el 'Tipo cambio REP' " , titFormVal); }
				else
				{ 			
					saldoInsoluto = ($("#monedaFact"+id_factura).val() =="USD" && $("#moneda_rep").val()=="MXN" ? v_totalSAT - (montoREP / tc) : v_totalSAT - (montoREP * tc) );
					$("#lblSi"+id_factura).html("$"+$.number(saldoInsoluto, 2, '.', ',' ) );
					$("#si"+id_factura   ).val(saldoInsoluto);
				}//else
			}//else			
		}//else
}

function traeFacturaSeleccionada()
{
	var id_factura = $('input:radio[name=facturaPedido]:checked').val();
		
	if (isEmpty(id_factura) == true)
		{ return true;  	 }
		else
		{ return id_factura; }
	
}


function convertirAlTipoCambio(operacion)
{
	var tipoCambio   = Number($("#tcSAT").val());
	var importeCargo = 0;	

	if(operacion =="*")
		{ $(".convTC").each(function() { importeCargo = Number($(this).val()) * tipoCambio; $(this).val(importeCargo); }); }
	else{ $(".convTC").each(function() { importeCargo = Number($(this).val()) / tipoCambio; $(this).val(importeCargo); }); }

	calcularTotFacturas();

}

function borraConceptoFactura(objC, valueC, labelC, ivaC, unidadC, importeC, subtotalC)
{	
	$(objC).parent().parent().remove();	
	$('#conceptosSinCodSAT').append($('<option>').text( labelC ).attr('value', valueC ).attr('iva', ivaC ));			
	var cargo = {id_cargo: valueC, cargo: labelC, iva: ivaC, unidad: unidadC , importe: importeC,subtotal:subtotalC };
	conceptosSAT.push(cargo);
}

function vistaPreviaFacturaAX()
{
	vistaPreviaAX('vistaprevia');
}


function scrollToAnchor(aid){
    var aTag = $("#"+ aid );	
    $('html,body').animate({scrollTop: aTag.offset().top},'slow');
}

function vistaPreviaAX(tipo)
{ 	
	$.ajax({data	  : $('#CFDI_FORM').serialize(),
			url       : $("#baseURL").val()+'pedido/timbrarAX/'+$("#id_pedido").val()+'/'+tipo,
			type      : 'post',						
			dataType  : 'json',
			beforeSend: function (    ) {$("#"+tipo+"PDF").html(""); $("#confirm"+tipo).html(""); $("#confirm"+tipo).html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
			success   : function (resp) 
				{   $("#confirm"+tipo).html("");
				    $("#"+tipo+"PDF" ).html("");
					var	titF	   = tipo=="vistaprevia"?"PROFORMA(Plantilla)":"Vista previa REP";
					var	iconF      = "<a style='color:#008000' href='"+$("#baseURL").val()+resp['dir']+resp['pdf']+"' target='_blank'>"
				 				   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='"+titF+"' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>"+titF+"</small></a>";
					$("#"+tipo+"PDF").html(iconF);
					scrollToAnchor(tipo+"PDF");
					$("#id_factura").val(resp['id_factura']);
				}, 
			error : function(err) { jAlert("Ha ocurrido un error vistaPreviaAX en " + err.status + " " + err.statusText,titAlert); }
        }); 	
}


function vistaPreviaCfdiRelAX(tipo)
{ 	
	$.ajax({data	  : $('#CFDI_FORM').serialize(),
			url       : $("#baseURL").val()+'pedido/timbrarCfdiRelAX/'+$("#id_pedido").val()+'/'+tipo,
			type      : 'post',						
			dataType  : 'json',
			beforeSend: function (    ) {$("#vp_cfdirelPDF").html(""); $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
			success   : function (resp) 
				{   $("#confirmtimbrar").html("");
				    $("#vp_cfdirelPDF" ).html("");
					var	titF	   = "PROFORMA CFDI Rel(Plantilla)";
					var	iconF      = "<a style='color:#008000' href='"+$("#baseURL").val()+resp['dir']+resp['pdf']+"' target='_blank'>"
				 				   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='"+titF+"' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>"+titF+"</small></a>";
					$("#vp_cfdirelPDF").html(iconF);					
				}, 
			error : function(err) { jAlert("Ha ocurrido un error vistaPreviaCfdiRelAX en " + err.status + " " + err.statusText,titAlert); }
        }); 	
}

function salvarAntesTimbrar()
{
	submitFormAX( $("#baseURL").val(), "FLET", $("#id_pedido").val(), $("#accion").val(), true);
}

function timbrarAX()
{ 		
    if(validarFormaParaTimbrar() == true )
	{   
		$.ajax({url       : $("#baseURL").val()+'pedido/traeConsecutivoAX',
				type      : 'post',
				dataType  : 'json',				
				beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
				success   : function (resp) 
					{   $("#confirmtimbrar").html("");
						$("#folio").val(resp);
						$.ajax({url       : $("#controller_fac").val()+'pedido/timbrarAX/'+$("#id_pedido").val()+'/timbrar/senni',
								type      : 'post',
								dataType  : 'json',
								data	  : $('#CFDI_FORM').serialize(),
								beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
								success   : function (resp) 
									{   $("#confirmtimbrar").html("");
										if(resp["success"].length == 0)
										{  var msjError = "";
										for( var i = 0; i<resp["error"].length; i++  )
											{ msjError = msjError + resp["error"][i]; }
										jAlert("NO FUE POSIBLE TIMBRAR LA FACTURA ANTE EL SAT, FAVOR DE REVISAR LO SIGUIENTE: " + msjError, titAlert);
										}
										else
										{ guardaFacturaAX(resp); }
									}, 
									error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error en el timbrado de SAT: " + textStatus + ", [" + ex + "] ",titAlert); console.log("Ha ocurrido un error en el timbrado de SAT: " + textStatus + ", [" + ex + "] " + jqXHR.responseText);  }
								}); 
					}, 
					error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error en el timbrado de SAT: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert);  }
				});
	}//if
}//timbrarAX

function guardaFacturaAX(datos)
{ 
$.ajax({url       : $("#baseURL").val()+'pedido/guardaFacturaAX/',
		type      : 'post',
		dataType  : 'json',
		data	  : datos,
		beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
		success   : function (resp) 
			{ $("#confirmtimbrar").html("");
			  var iconF = "<a style='color:#76a035' href='"+resp["pathFile"]+resp["filename"]+"' target='_blank'>"
						   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='FACTURA' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>"+resp["filename"]+"</small> "
						   + "</a>&nbsp&nbsp&nbsp"
						   + "<a style='color:#76a035' href='"+resp["pathFile"]+resp["xmlname"]+"' target='_blank'>"
						   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='FACTURA XML' src='"+$("#baseURL").val()+"images/logoXML.png' width='18px' height='18px'> <small>"+resp["xmlname"]+"</small>" 
						   + "</a>"
							 ;		
			  $("#timbrarPDF").append(iconF);
			  limpiaConceptosFac();
			  scrollToAnchor("timbrarPDF");
			 
			  $('#tblRepFact').append("<tr> <td> <input type='radio' class='selFac' id='f"+resp['id_factura']+"' name='facturaPedido' value='"+resp['id_factura']+"'></td>"
											+"<td align='left'><a href='"+resp["pathFile"]+resp["filename"]+"' target='_blank'><small>"+resp['filename']+"</small></a></td>"
											+"<td align='left'><input value='"+resp['factura']['total']+"' 		  type='hidden' name='sal"+resp['id_factura']+"' id='sal"+resp['id_factura']+"'/><small id='lblSal"+resp['id_factura']+"'>$"+$.number(resp['factura']['total'],2, '.', ',' )+"</small></td>"
											+"<td align='left'><input value='"+resp['factura']['total']+"' 		  type='hidden' name='si" +resp['id_factura']+"' id='si" +resp['id_factura']+"'/>"
											+"				   <input value='"+resp['factura']['total']+"' 		  type='hidden' name='siIni" +resp['id_factura']+"' id='siIni" +resp['id_factura']+"'/><strong><small id='lblSi" +resp['id_factura']+"'>$"+$.number(resp['factura']['total'],2, '.', ',' )+"</small></strong></td>"
											+"<td align='left'><small>"+resp['factura']['fecha_timbrado']+" </small></td>"
											+"<td align='center'><input value='0' type='hidden' name='np" +resp['id_factura']+"' id='np" +resp['id_factura']+"'/><small id='lblNp" +resp['id_factura']+"'>0</small></td>"
											+"<td align='center'><input value='"+resp['factura']['moneda']+"' type='hidden' name='monedaFact"+resp['id_factura']+"' id='monedaFact"+resp['id_factura']+"'/><small>"+resp['factura']['moneda']+"</small></td>"
											+"<td align='center'><small id='lblStat" +resp['id_factura']+"'>"+resp['factura']['status']+"</small></td>"
											+"<td> <i class='fa fa-credit-card pagFact pointer' id='"+resp['id_factura']+"' folio='"+resp['success']['folio']+"'> </i> </td>"
											+"<td> <i class='fa fa-remove cancelFact pointer'   id='"+resp['id_factura']+"' folio='"+resp['success']['folio']+"'> </i> </td>"
									+"</tr>" );
			  $('.selFac').click(function() { seleccionaFactura( $(this).attr('value') ); }); 
			  $('.pagFact'   ).click(function() { let idParam = $(this).attr('id'); let folioParam = $(this).attr('folio'); jConfirm("¿Cambiar el Status de la Factura con folio <b>"+folioParam+"</b> a PAGADA?", titAlert, function(r) { if(r) { pagarFacturaAX( idParam ); } }); }); 
			  $('.cancelFact').click(function() { let idParam = $(this).attr('id'); let folioParam = $(this).attr('folio'); jConfirm("¿Está seguro de CANCELAR la factura con folio <b>"+folioParam+"</b>?", titAlert, function(r) { if(r) { cancelarFacturaAX( idParam ); } }); }); 
			}, 
			error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error al guardar recibo nomina: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert); }
		}); 	
}//guardaFacturaAX()

function timbrarCfdiRelAX()
{ 		
    if(validarFormaParaTimbrarCfdiRel() == true )
	{   
		$.ajax({url       : $("#baseURL").val()+'pedido/traeConsecutivoAX',
				type      : 'post',
				dataType  : 'json',				
				beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
				success   : function (resp) 
					{   $("#confirmtimbrar").html("");
						$("#folio").val(resp);
						$.ajax({url       : $("#controller_fac").val()+'pedido/timbrarCfdiRelAX/'+$("#id_pedido").val()+'/timbrarcfdirel/senni',
								type      : 'post',
								dataType  : 'json',
								data	  : $('#CFDI_FORM').serialize(),
								beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
								success   : function (resp) 
									{   $("#confirmtimbrar").html("");									
										if(resp["success"].length == 0)
										{  var msjError = "";
										for( var i = 0; i<resp["error"].length; i++  )
											{ msjError = msjError + resp["error"][i]; }
										jAlert("NO FUE POSIBLE TIMBRAR LA FACTURA ANTE EL SAT, FAVOR DE REVISAR LO SIGUIENTE: " + msjError, titAlert);
										}
										else
										{ guardaFacturaCfdiRelAX(resp); }
									}, 
									error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error en el timbrado de SAT: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert);  }
								}); 
					}, 
					error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error en el timbrado de SAT: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert);  }
				});
	}//if
}//timbrarCfdiRelAX

function guardaFacturaCfdiRelAX(datos)
{ 
$.ajax({url       : $("#baseURL").val()+'pedido/guardaFacturaCfdiRelAX/',
		type      : 'post',
		dataType  : 'json',
		data	  : datos,
		beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
		success   : function (resp) 
			{ $("#confirmtimbrar").html("");
			  var iconF = "<a style='color:#76a035' href='"+resp["pathFile"]+resp["filename"]+"' target='_blank'>"
						   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='FACTURA' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>"+resp["filename"]+"</small> "
						   + "</a>&nbsp&nbsp&nbsp"
						   + "<a style='color:#76a035' href='"+resp["pathFile"]+resp["xmlname"]+"' target='_blank'>"
						   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='FACTURA XML' src='"+$("#baseURL").val()+"images/logoXML.png' width='18px' height='18px'> <small>"+resp["xmlname"]+"</small>" 
						   + "</a>"
							 ;		
			  $("#timbrarPDF").append(iconF);
			  limpiaConceptosFac();
			  scrollToAnchor("timbrarPDF");
			 
			  $('#tblRepFact').append("<tr> <td> <input type='radio' class='selFac' id='f"+resp['id_factura']+"' name='facturaPedido' value='"+resp['id_factura']+"'></td>"
											+"<td align='left'><a href='"+resp["pathFile"]+resp["filename"]+"' target='_blank'><small>"+resp['filename']+"</small></a></td>"
											+"<td align='left'><input value='"+resp['factura']['total']+"' 		  type='hidden' name='sal"+resp['id_factura']+"' id='sal"+resp['id_factura']+"'/><small id='lblSal"+resp['id_factura']+"'>$"+$.number(resp['factura']['total'],2, '.', ',' )+"</small></td>"
											+"<td align='left'><input value='"+resp['factura']['total']+"' 		  type='hidden' name='si" +resp['id_factura']+"' id='si" +resp['id_factura']+"'/>"
											+"				   <input value='"+resp['factura']['total']+"' 		  type='hidden' name='siIni" +resp['id_factura']+"' id='siIni" +resp['id_factura']+"'/><strong><small id='lblSi" +resp['id_factura']+"'>$"+$.number(resp['factura']['total'],2, '.', ',' )+"</small></strong></td>"
											+"<td align='left'><small>"+resp['factura']['fecha_timbrado']+" </small></td>"
											+"<td align='center'><input value='0' type='hidden' name='np" +resp['id_factura']+"' id='np" +resp['id_factura']+"'/><small id='lblNp" +resp['id_factura']+"'>0</small></td>"
											+"<td align='center'><input value='"+resp['factura']['moneda']+"' type='hidden' name='monedaFact"+resp['id_factura']+"' id='monedaFact"+resp['id_factura']+"'/><small>"+resp['factura']['moneda']+"</small></td>"
											+"<td align='center'><small id='lblStat" +resp['id_factura']+"'>"+resp['factura']['status']+"</small></td>"
											+"<td> <i class='fa fa-credit-card pagFact pointer' id='"+resp['id_factura']+"' folio='"+resp['success']['folio']+"'> </i> </td>"
											+"<td> <i class='fa fa-remove cancelFact pointer'   id='"+resp['id_factura']+"' folio='"+resp['success']['folio']+"'> </i> </td>"
									+"</tr>" );
			  $('.selFac').click(function() { seleccionaFactura( $(this).attr('value') ); }); 
			  $('.pagFact'   ).click(function() { let idParam = $(this).attr('id'); let folioParam = $(this).attr('folio'); jConfirm("¿Cambiar el Status de la Factura con folio <b>"+folioParam+"</b> a PAGADA?", titAlert, function(r) { if(r) { pagarFacturaAX( idParam ); } }); }); 
			  $('.cancelFact').click(function() { let idParam = $(this).attr('id'); let folioParam = $(this).attr('folio'); jConfirm("¿Está seguro de CANCELAR la factura con folio <b>"+folioParam+"</b>?", titAlert, function(r) { if(r) { cancelarFacturaAX( idParam ); } }); }); 
			}, 
			error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error al guardar guardaFacturaCfdiRelAX: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert); }
		}); 	
}//guardaFacturaCfdiRelAX()

function pagarFacturaAX(idFactura)
{ 	
	
$.ajax({data      : { idFactura: idFactura },
		url       : $("#baseURL").val()+'gestion/pagarFacturaAX',
		type      : 'post',						
		dataType  : 'json',
		beforeSend: function (    ) {$("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
		success   : function (resp) 
			{   $("#confirmtimbrar").html("");				
				
			}, 
		error : function(err) { jAlert("Ha ocurrido un error pagarFacturaAX en " + err.status + " " + err.statusText,titAlert); }
	}); 	
}

function cancelarFacturaAX(idFactura)
{
	let param = { idFactura: idFactura };
	$.ajax({data      : param,
			url       : $("#baseURL").val()+'gestion/cancelarFacturaAX',
			type      : 'post',						
			dataType  : 'json',
			beforeSend: function (    ) { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
			success   : function (respCan) 
				{   $("#confirmtimbrar").html("");					
					$.ajax({data      : { uuid: respCan["uuid"] },
							url       : $("#controller_fac").val()+'gestion/cancelarFacturaAX/senni',
							type      : 'post',						
							dataType  : 'json',
							beforeSend: function (    ) { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
							success   : function (resp) 
								{   $("#confirmtimbrar").html("");
								alert(JSON.stringify(resp));
								if(resp["success"].length == 0)
								{   var msjError = "";
									for( var i = 0; i<resp["error"].length; i++  )
										{ msjError = msjError + resp["error"][i]; }
									jAlert("NO FUE POSIBLE CANCELAR LA FACTURA EN EL SAT, FAVOR DE REVISAR LO SIGUIENTE: " + msjError, titAlert);
								}
								else
								{ guardaStatucCanceladaAX(respCan); }
				
								}, 
							error : function(err) { jAlert("Ha ocurrido un error cancelarFacturaAX RAMF en " + err.status + " " + err.statusText,titAlert); }
						}); 

					}, 
			error : function(err) { jAlert("Ha ocurrido un error cancelarFacturaAX en " + err.status + " " + err.statusText,titAlert); }
		}); 		
}

function guardaStatucCanceladaAX(resp)
{ alert("Cancel: "+resp["uuid"]+" -- "+resp["id_factura"]);
$.ajax({url       : $("#baseURL").val()+'gestion/guardaStatucCanceladaAX/',
		type      : 'post',
		dataType  : 'json',
		data	  : resp,
		beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
		success   : function (r) 
			{ 
				$("#confirmtimbrar").html("");								
			    $('#lblStat'+resp['id_factura']).html(r);
			}, 
			error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error al guardar recibo nomina: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert); }
		}); 	
}//timbrarRecNomAX()

function vistaPreviaRecNomAX()
{ 	
	$.ajax({data	  : $('#CFDI_FORM_RN').serialize(),
			url       : $("#baseURL").val()+'gestion/timbrarRecNomAX/vp',
			type      : 'post',						
			dataType  : 'json',
			beforeSend: function (    ) {$("#vistapreviaPDF").html(""); $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
			success   : function (resp) 
				{   $("#confirmtimbrar").html("");
				    $("#vistapreviaPDF").html("");
					var	titF	   = "Vista previa Recibo Nomina";
					var	iconF      = "<a style='color:#008000' href='"+$("#baseURL").val()+resp['dir']+resp['pdf']+"' target='_blank'>"
				 				   + "<img src='"+$("#baseURL").val()+"images/check.png'> <img title='"+titF+"' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>"+titF+"</small> </a>";
					$("#vistapreviaPDF").html(iconF);
					scrollToAnchor("vistapreviaPDF");
				}, 
			error : function(err) { jAlert("Ha ocurrido un error vistaPreviaRecNomAX en " + err.status + " " + err.statusText,titAlert); }
        }); 	
}

function timbrarRecNomAX()
{ 		
    if(validarRecNomParaTimbrar() == true )
	{       
		$.ajax({url       : $("#controller_fac").val()+'gestion/timbrarRecNomAX/timb/senni',
				type      : 'post',
				dataType  : 'json',
				data	  : $('#CFDI_FORM_RN').serialize(),
				beforeSend: function () { $("#timbrarPDF").html(""); $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
				success   : function (resp) 
					{ $("#confirmtimbrar").html("");						

						if(resp["success"].length == 0)
						{  var msjError = "";
						for( var i = 0; i<resp["error"].length; i++  )
							{ msjError = msjError + resp["error"][i]; }
						jAlert("NO FUE POSIBLE TIMBRAR EL RECIBO DE NOMINA ANTE EL SAT, FAVOR DE REVISAR LO SIGUIENTE: " + msjError, titAlert);
						}
						else
						{ guardaRecNomAX(resp);	}
					}, 
					error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error en el timbrado de SAT: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert); }
				}); 	
	}
}//timbrarRecNomAX()

function guardaRecNomAX(datos)
{ 
$.ajax({url       : $("#baseURL").val()+'gestion/guardaRecNomAX/',
		type      : 'post',
		dataType  : 'json',
		data	  : datos,
		beforeSend: function () { $("#timbrarPDF").html(""); $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
		success   : function (resp) 
			{ $("#confirmtimbrar").html("");						
				var	iconF = "<a style='color:#76a035' href='"+resp["pathFile"]+"' target='_blank'>"
				+ "<img src='"+$("#baseURL").val()+"images/check.png'> <img src='"+$("#baseURL").val()+"images/zip.jpg' width='24px' heigth='21px'> Recibo de Nomina </a>";
				$("#timbrarPDF").html(iconF);
				
				paginarMisRecibosNominasAX(1, 10, $("#baseURL").val());
				scrollToAnchor("timbrarPDF");
				
			}, 
			error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error al guardar recibo nomina: " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert); }
		}); 	
}//timbrarRecNomAX()


function toggleSection(div, icon, iconMinus, iconPlus)
{   
	$("#"+div ).off( "toggle");
	$("."+icon).unbind( "click" );
    $("#"+div ).toggle("swing");
    $("."+icon).addClass("pointer").click(function(){   var isHidden = $("#"+div ).is(":hidden");
                                                        if(isHidden) { $("."+icon).removeClass("fa-arrow-circle-right").addClass("fa-arrow-circle-down" ); $("."+icon).children("i").removeClass(iconMinus).addClass(iconPlus);  }
                                                        else         { $("."+icon).removeClass("fa-arrow-circle-down" ).addClass("fa-arrow-circle-right"); $("."+icon).children("i").removeClass(iconPlus ).addClass(iconMinus); }                                            
                                                        $("#"+div).toggle("swing"); 
                                                    });    
}

function validarFormaParaTimbrar()
{	
	var titFormVal = titAlert;//"RAMF Logistics";
	var dateReg    = /^(([0-2]?\d{1})|([3][0,1]{1}))\/[0,1]?\d{1}\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/;
	var rfcReg     = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
	var charNumReg = /^[a-záéíóúÁÉÍÓÚÑñA-Z\ \:\;\_\,\.\-\']+$/;
	var cpReg 	   = /^([0-9]{0,6})$/;
	var emailReg   = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	
	switch(true) {		
		
		case $("#regimen_fiscal").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-1"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de EMISOR, es obligatario seleccionar un valor del campo 'Regimen Fiscal' " , titFormVal); 
				break;	
		/** RECEPTOR **/
		case validaListaNegraSATAX($("#baseURL").val(), $("#rfcReceptor").val() ) === false:
		break;	
		case rfcReg.test($("#rfcReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'RFC' no es valido " , titFormVal); 
				break;	
		case charNumReg.test($("#rsReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'Razón Social' no es valido " , titFormVal); 
				break;
		case cpReg.test($("#cpReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'Código Postal (Dom. Fiscal)' no es valido " , titFormVal); 
				break;
		case emailReg.test($("#emailReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'Correo' no es valido " , titFormVal); 
				break;																	
		case $("#uso_cfdi").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, es obligatario seleccionar un valor del campo 'Uso del CFDI' " , titFormVal); 
				break;
		/** CONCEPTOS **/							
		case $('#tblConceptosSAT >tbody >tr').length <= 1:
				var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CONCEPTOS, es obligatario agregar los servicios cotizados " , titFormVal); 
				break;
		case $("#monedaSAT").val() == "USD" && ( $("#tcSAT").val()=="0" || $("#tcSAT").val()=="" || Number($("#tcSAT").val()) > 50 ) : 				
				var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CONCEPTOS, la moneda de la factura se estableció USD y no se ingresó Tipo de cambio o es invalido " , titFormVal); 
				break;		
		case $("#ivaSAT").val() == "0.00" && $("#sat_tasaocuota").val()== ".16":
				var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jConfirm("Concepto a facturar sin IVA, favor de confimar si el concepto pertenece a la TASA 0 de IVA, y vuelva a timbrar", titFormVal, function(r) { if(r) { $("#sat_tasaocuota").val(0.0000) } });
				break;
		/** INFO PAGO **/
		case $("#metodo_pago").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de INFO PAGO, es obligatario seleccionar un valor del campo 'Método de Pago' " , titFormVal); 
				break;
		case $("#forma_pago").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de INFO PAGO, es obligatario seleccionar un valor del campo 'Forma de Pago' " , titFormVal); 
				break;							
		case dateReg.test($("#fecha_expedicion").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de INFO PAGO, la fecha 'Fecha de Expedición' no es valida " , titFormVal); 
				break;

		default : return true;
	}

	return false;

}

function validarFormaParaTimbrarCfdiRel()
{	
	var titFormVal = titAlert;//"RAMF Logistics";
	var dateReg    = /^(([0-2]?\d{1})|([3][0,1]{1}))\/[0,1]?\d{1}\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/;
	var rfcReg     = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
	var charNumReg = /^[a-záéíóúÁÉÍÓÚÑñA-Z\ \:\;\_\,\.\-\']+$/;
	var cpReg 	   = /^([0-9]{0,6})$/;
	var emailReg   = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	var uuids      = false;
	$(".selCfdiRel").each(function() {  if( $(this).is(':checked') ) {uuids = true} });
	switch(true) {		
		
		case $("#regimen_fiscal").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-1"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de EMISOR, es obligatario seleccionar un valor del campo 'Regimen Fiscal' " , titFormVal); 
				break;	
		/** RECEPTOR **/
		case validaListaNegraSATAX($("#baseURL").val(), $("#rfcReceptor").val() ) === false:
		break;	
		case rfcReg.test($("#rfcReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'RFC' no es valido " , titFormVal); 
				break;	
		case charNumReg.test($("#rsReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'Razón Social' no es valido " , titFormVal); 
				break;
		case cpReg.test($("#cpReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'Código Postal (Dom. Fiscal)' no es valido " , titFormVal); 
				break;
		case emailReg.test($("#emailReceptor").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, el valor del campo 'Correo' no es valido " , titFormVal); 
				break;																	
		case $("#uso_cfdi").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de RECEPTOR, es obligatario seleccionar un valor del campo 'Uso del CFDI' " , titFormVal); 
				break;
		/** CONCEPTOS **/							
		case $('#tblConceptosSAT >tbody >tr').length <= 1:
				var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CONCEPTOS, es obligatario agregar los servicios cotizados " , titFormVal); 
				break;
		case $("#monedaSAT").val() == "USD" && ( $("#tcSAT").val()=="0" || $("#tcSAT").val()=="" || Number($("#tcSAT").val()) > 50 ) : 				
				var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CONCEPTOS, la moneda de la factura se estableció USD y no se ingresó Tipo de cambio o es invalido " , titFormVal); 
				break;		
		case $("#ivaSAT").val() == "0.00" && $("#sat_tasaocuota").val()== ".16":
				var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jConfirm("Concepto a facturar sin IVA, favor de confimar si el concepto pertenece a la TASA 0 de IVA, y vuelva a timbrar", titFormVal, function(r) { if(r) { $("#sat_tasaocuota").val(0.0000) } });
				break;
		/** INFO PAGO **/
		case $("#metodo_pago").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de INFO PAGO, es obligatario seleccionar un valor del campo 'Método de Pago' " , titFormVal); 
				break;
		case $("#forma_pago").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de INFO PAGO, es obligatario seleccionar un valor del campo 'Forma de Pago' " , titFormVal); 
				break;							
		case dateReg.test($("#fecha_expedicion").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de INFO PAGO, la fecha 'Fecha de Expedición' no es valida " , titFormVal); 
				break;
		/** CFDIS RELACIONADOS **/
		case $("#tipo_comprobante").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-6"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CFDI Relacionados, es obligatario seleccionar un valor del campo 'Tipo de Comprobante' " , titFormVal); 
				break;
		case $("#tipo_relacion").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-6"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CFDI Relacionados, es obligatario seleccionar un valor del campo 'Tipo de Relación' " , titFormVal); 
				break;
		case uuids == false: 				
				var index = $('#tabsTimbrado a[href="#tabs-6"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de CFDI Relacionados, es obligatario seleccionar un 'CDFI relacionado mediante UUID' " , titFormVal); 
				break;				
 
		default : return true;
	}

	return false;

}

function validarRecNomParaTimbrar()
{	
	var titFormVal = titAlert;
	var regPatReg  = /^[0-9a-zA-Z]+$/;
	var numPagReg  = /^(([1-9][0-9]{0,4})|[0])(.[0-9]{3})?/;
	var dateReg    = /^(([0-2]?\d{1})|([3][0,1]{1}))\/[0,1]?\d{1}\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/;
	var rfcReg     = /^([A-ZÑ&]{3,4}) ?(?:- ?)?(\d{2}(?:0[1-9]|1[0-2])(?:0[1-9]|[12]\d|3[01])) ?(?:- ?)?([A-Z\d]{2})([A\d])$/;
	var numSSReg   = /^([0-9]{1,15})$/;
	var charNumReg = /^[a-záéíóúÁÉÍÓÚÑñA-Z\ \:\;\_\,\.\-\']+$/;
	var cpReg 	   = /^([0-9]{0,6})$/;
	var emailReg   = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9-]+(?:\.[a-zA-Z0-9-]+)*$/;
	
	switch(true) {		
		
		/** EMISOR **/
		case $("#regimen_fiscal").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-1"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de EMISOR, es obligatario seleccionar un valor del campo 'Regimen Fiscal' " , titFormVal); 
				break;
		case regPatReg.test($("#RegistroPatronal").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-1"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de EMISOR, es obligatario ingresar un valor correcto en el campo 'Registro Patronal' " , titFormVal); 
				break;					
		/** EMISOR **/	
		/** NOMINA **/
		case $("#TipoNomina").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de NOMINA, es obligatario seleccionar un valor del campo 'Tipo de Nomina:' " , titFormVal); 
				break;
		case numPagReg.test($("#NumDiasPagados").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de NOMINA, el valor del campo 'Días pagados' no es valido " , titFormVal); 
				break;	
		case dateReg.test($("#FechaPago").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de NOMINA, el valor del campo 'Fecha de Pago' no es valido " , titFormVal); 
				break;
		case dateReg.test($("#FechaInicialPago").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de NOMINA, el valor del campo 'Fecha Inicial de Pago' no es valido " , titFormVal); 
				break;
		case dateReg.test($("#FechaFinalPago").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-2"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("En el apartado de NOMINA, el valor del campo 'Fecha Final de Pago' no es valido " , titFormVal); 
				break;																			
		/** NOMINA **/
		/** EMPLEADO **/
		case $("#nombre_emp").val() == "": 				
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, es obligatario ingresar un valor del campo 'Nombre Completo' " , titFormVal); 
			break;
		case emailReg.test($("#correo_emp").val()) === false: 
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, el valor del campo 'Correo' no es valido " , titFormVal); 
			break;
		case rfcReg.test($("#RFC").val()) === false: 
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, el valor del campo 'RFC' no es valido " , titFormVal); 
			break;				
		case $("#Curp").val() == "":
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, es obligatario ingresar un valor del campo 'CURP'" , titFormVal); 
			break;
		case numSSReg.test($("#NumSeguridadSocial").val()) === false: 
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, el valor del campo 'Num Seg. Social' no es valido " , titFormVal); 
			break;	
		 case $("#NumEmpleado").val() == "": 				
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, es obligatario ingresar un valor del campo 'Num. Empleado' " , titFormVal); 
			break;
		case $("#tipo_contrato_emp").val() == "0":
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, es obligatario seleccionar un valor del campo 'Tipo Contrato' " , titFormVal); 
			break;
		case $("#tipo_regimen_emp").val() == "0":
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, es obligatario seleccionar un valor del campo 'Tipo Régimen' " , titFormVal); 
			break;	
		case $("#periodo_emp").val() == "0":
			var index = $('#tabsTimbrado a[href="#tabs-3"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de EMPLEADO, es obligatario seleccionar un valor del campo 'Periodicidad Pago' " , titFormVal); 
			break;								
		/** EMPLEADO **/
		/** PERCEPCIONES **/
		case $('#detallePercepciones >tbody >tr').length <= 1:
			var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de Percepciones, es obligatario agregar los conceptos " , titFormVal); 
			break;
		case $("#tot_gravado_emp").val() == "0" || $("#tot_gravado_emp").val() == "":
			var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de Percepciones,  el valor del campo 'Total Gravado' no es valido  " , titFormVal); 
			break;	
		case $("#tot_ext_emp").val() == "0" || $("#tot_ext_emp").val() == "":
			var index = $('#tabsTimbrado a[href="#tabs-4"]').parent().index();
			$('#tabsTimbrado').tabs("option", "active", index);
			jAlert("En el apartado de Percepciones,  el valor del campo 'Total Exento' no es valido  " , titFormVal); 
			break;									
		/** PERCEPCIONES **/
		

		default : return true;
	}

	return false;

}


function timbrarREPAX()
{ 		
    if(validarFormaParaTimbrarREP() == true )
	{       
		$.ajax({url       :  $("#controller_fac").val()+'pedido/timbrarAX/'+$("#id_pedido").val()+'/timbrar_rep/senni',
				type      : 'post',
				dataType  : 'json',
				data	  : $('#CFDI_FORM').serialize(),
				beforeSend: function () { $("#timbrar_repPDF").html(""); $("#confirmtimbrar_rep").html(""); $("#confirmtimbrar_rep").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
				success   : function (resp) 
					{ $("#confirmtimbrar_rep").html("");						

						if(resp["success"].length == 0)
						{  var msjError = "";
						 for ( var i = 0; i<resp["error"].length; i++  )
						  	 { msjError = msjError + resp["error"][i]; }
						 jAlert("NO FUE POSIBLE TIMBRAR LA FACTURA ANTE EL SAT, FAVOR DE REVISAR LO SIGUIENTE: " + msjError, titAlert);
						}
						else
						{ guardaREPAX(resp); }
					}, 
				error : function(err) { jAlert("Ha ocurrido un error timbrarAX en " + err.status + " " + err.statusText,titAlert); }
				}); 	
	}
}

function guardaREPAX(datos)
{ 
$.ajax({url       : $("#baseURL").val()+'pedido/guardaREPAX/',
		type      : 'post',
		dataType  : 'json',
		data	  : datos,
		beforeSend: function () { $("#confirmtimbrar").html(""); $("#confirmtimbrar").html("<img src=\""+$("#baseURL").val()+"images/loading.gif\" width='50px' height='50px'> Cargando información. Espere por favor...");},
		success   : function (resp) 
			{   $("#timbrar_repPDF").html("");
				$("#vp_repPDF"	   ).html("");
				$("#confirmtimbrar").html("");
				$("#tblREPs"	   ).show(); 

				var factura = $("#f"+resp["id_factura"]).parent().next().html();
				var	TRiconF = "<tr> <td width='15%'> "+factura+" </td>"+
								" 	<td width='5% '> <img src='"+$("#baseURL").val()+"images/check.png'> </td>"+
								"   <td width='65%'>" +resp["success"]["fecha"]+" " +"$"+$.number(resp["success"]["monto_rep"], 2, '.', ',' )+" "+resp["success"]["moneda_rep"]+" "+resp["success"]["forma_pago_rep_desc"]+"</td>"+
								"   <td width='25% '> <a href='"+resp["pathFile"]+resp["filename"]+"' target='_blank'>"+
								"					  <img title='REP' src='"+$("#baseURL").val()+"images/logoPDF.png' width='18px' height='18px'> <small>REP </small> </a></td>"+
								"	</tr>";

				$("#tblREPs tr:last"	     			).after(TRiconF);
				$("#lblSi"+resp["id_factura"]).html( "<strong>$"+$.number(resp["success"]["ImpSaldoInsoluto"], 2, '.', ',' )+"</strong>");
				$("#si"+resp["id_factura"]   ).val ( resp["success"]["ImpSaldoInsoluto"]);
				$("#siIni"+resp["id_factura"]).val ( resp["success"]["ImpSaldoInsoluto"]);
				$("#np"+resp["id_factura"]   ).val ( resp["success"]["NumParcialidad"]);
				$("#lblNp"+resp["id_factura"]).html( resp["success"]["NumParcialidad"] );
				$("#parcial_rep"			 			).val ( Number( resp["success"]["NumParcialidad"] ) + 1);

				$("#tc_rep"    	   ).val('');
				$("#monto_rep" 	   ).val('');				
				$("#fecha_rep" 	   ).datepicker('setDate', new Date());
				$('#moneda_rep'    ).combobox('autocomplete', '::Elegir::');
				$("#moneda_rep"    ).val(0);
				$('#forma_pago_rep').combobox('autocomplete', '::Elegir::');
				$("#forma_pago_rep").val(0);
			}, 
			error : function(jqXHR, textStatus, ex) { jAlert("Ha ocurrido un error al guardar guarda REP : " + textStatus + ", [" + ex + "] " + jqXHR.responseText,titAlert); }
		}); 	
}//guardaFacturaAX()




function traeDatosFacturaAX(id_factura){
	var param = {"id_factura" : id_factura };
   
	$.ajax({data	  : param,
			url		  : $("#baseURL").val()+'gestion/traeDatosFacturaAX/',
			type	  : 'post',
			dataType  : 'json',
			beforeSend: function () { },
			success:  function (response) 
			{		
				$("#uuidREP"	   ).val(response['uuid']);
				$("#id_pedidoREP"  ).val(response['folio']);
				$("#serieREP"	   ).val(response['serie']);
				$("#monedaREP"	   ).val(response['moneda']);
				$("#metodo_pagoREP").val(response['metodo_pago']);
				$("#rfcReceptorREP").val(response['rfc']);
				$("#rsReceptorREP" ).val(response['nombre']);
			},				
			error: function(err) { alert("Ha ocurrido un traeDatosFacturaAX error: " + err.status + " " + err.statusText); }
	});					
}


function habilitaValidacionListaNegraAX(baseURL)
{ 
	$("#rfcReceptor").change(function() { validaListaNegraSATAX(baseURL, $(this).val() ); });
}

function validaListaNegraSATAX(baseURL,rfc)
{    	        	
        var param = {"rfc" : rfc};
		if (isEmpty(rfc) == true)
		{ return true;  }
		else
		{
        $.ajax({data	: param,               
                url     : baseURL+'gestion/validaListaNegraSATAX/',
                type	: 'post',
				dataType: 'json',
                success : function (response) { if(response['enListaNegra']== true)
												   { jAlert(" El RFC <b>"+response['detalle']['rfc']+"</b> correspondiente a <b>"+response['detalle']['razon_social']+"</b> SE ENCUENTRA EN LA <b>LISTA NEGRA DEL SAT 69 B:</b>"+
												   			"<br><br><table width='100%' border='0' cellspacing='0' align='center' cellpadding='0'>"+
															      "<tr><td align='center'><b>Situación del contribuyente:</b></td></tr><tr><td align='center'>"+response['detalle']['situacion_contribuyente']+"</td></tr>"+
																  "<tr><td align='center'><b>Número y fecha de oficio global de presunción SAT:</b></td></tr><tr><td align='center'> "+response['detalle']['num_fecha_oficio_global_presuncion_sat']+"</td></tr>"+
															      "<tr><td align='center'><b>Publicación página SAT presuntos</b></td></tr><tr><td align='center'>"+response['detalle']['publicacion_SAT_presuntos']+"</td></tr>"+
															      "<tr><td align='center'><b>Número y fecha de oficio global de presunción DOF:</b></td></tr><tr><td align='center'>"+response['detalle']['num_fecha_oficio_global_presuncion_DOF']+"</td></tr>"+
															      "<tr><td align='center'><b>Publicación DOF presuntos:</b></td></tr><tr><td align='center'>"+response['detalle']['publicacion_dof_presuntos']+"</td></tr>"+
															      "<tr><td align='center'><b>Número y fecha de oficio global de contribuyentes que desvirtuaron SAT:</b></td></tr><tr><td align='center'>"+response['detalle']['num_fecha_oficio_global_contribuyentes_desvirtuaron_sat']+" "+
															      "<tr><td align='center'><b>Publicación página SAT desvirtuados:</b></td></tr><tr><td align='center'>"+response['detalle']['publicacion__sat_desvirtuados']+"</td></tr>"+
															      "<tr><td align='center'><b>Número y fecha de oficio global de contribuyentes que desvirtuaron DOF:</b></td></tr><tr><td align='center'>"+response['detalle']['num_fecha_oficio_global_contribuyentes_desvirtuaron_DOF']+" "+
															      "<tr><td align='center'><b>Publicación DOF desvirtuados:</b></td></tr><tr><td align='center'>"+response['detalle']['publicacion_DOF_desvirtuados']+"</td></tr>"+
															      "<tr><td align='center'><b>Número y fecha de oficio global de definitivos SAT:</b></td></tr><tr><td align='center'>"+response['detalle']['num_fecha_oficio_global_definitivos_sat']+"</td></tr>"+
															      "<tr><td align='center'><b>Número y fecha de oficio global de definitivos DOF:</b></td></tr><tr><td align='center'>"+response['detalle']['num_fecha_oficio_global_definitivos_DOF']+"</td></tr>"+
															      "<tr><td align='center'><b>Publicación página SAT definitivos:</b></td></tr><tr><td align='center'>"+response['detalle']['publicacion_sat_definitivos']+"</td></tr></table>"
												   			,titAlert);
													$("#rfcReceptor").val('');
													$("#rsReceptor").val('');
													$("#cpReceptor").val('');
													$("#emailReceptor").val('');

													return false;
												   }
												   else { return true; }
				}, 
				error   : function (err)      { jAlert("Ha ocurrido un error validaListaNegraSATAX: " + err.status + " " + err.statusText,titAlert); return false; }
               });
		}
}

function validarFormaParaTimbrarREP()
{	
	var titFormVal = titAlert;//"RAMF Logistics";
	var dateReg    = /^(([0-2]?\d{1})|([3][0,1]{1}))\/[0,1]?\d{1}\/(([1]{1}[9]{1}[9]{1}\d{1})|([2-9]{1}\d{3}))$/;
	
	switch(true) {		
																			
		case $("#forma_pago_rep").val() == "0": 				
				var index = $('#tabsTimbrado a[href="#tabs-5"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("Es obligatario seleccionar un valor del campo 'Forma de Pago REP' " , titFormVal); 
				break;

		case $("#monto_rep").val() == "0" || $("#monto_rep").val() == "": 				
				var index = $('#tabsTimbrado a[href="#tabs-5"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("E obligatario seleccionar un valor del campo 'Monto REP' " , titFormVal); 
				break;								
		case dateReg.test($("#fecha_rep").val()) === false: 
				var index = $('#tabsTimbrado a[href="#tabs-5"]').parent().index();
				$('#tabsTimbrado').tabs("option", "active", index);
				jAlert("La 'Fecha del REP' no es valida " , titFormVal); 
				break;

		default : return true;
	}

	return false;

}

function soloNumeros()
{
    $(".onlyNumber").keydown(function (e) 
    {      
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||             // Allow: backspace, delete, tab, escape, enter and .
            (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || // Allow: Ctrl+A, Command+A        
            (e.keyCode >= 35 && e.keyCode <= 40))                               // Allow: home, end, left, right, down, up   
                { return null; }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey  || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) 
           { e.preventDefault(); }
    }); 
}


// Funcion Jquery para habilitar un objeto Select como autocomplete

(function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" ).addClass( "custom-combobox" )
                                    .insertAfter( this.element );
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" ).appendTo( this.wrapper )
                                   .val( value )
                                   .attr( "title", "" )
                                   .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left largoSL" )
                                   .autocomplete({ delay    : 0,
                                                   minLength: 0,
                                                   source   : $.proxy( this, "_source" )
                                                 })
                                    .tooltip({ tooltipClass: "ui-state-highlight" });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) {
            ui.item.option.selected = true;
            this._trigger( "select", event, { item: ui.item.option });            
            if ($(this.element).attr( "id") === "cotis")
                { traeDatosCotiAX($(ui.item.option).val(),$("#baseURL").val()); }
            
          },
 
          autocompletechange: "_removeIfInvalid"
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $("<a>").attr( "tabIndex", -1 )
                .attr( "title", "Show All Items" )
                .tooltip()
                .appendTo( this.wrapper )
                .button({ icons: { primary: "ui-icon-triangle-1-s" },
                          text: false
                        })
                .removeClass( "ui-corner-all" )
                .addClass( "custom-combobox-toggle ui-corner-right" )
                .mousedown(function() { wasOpen = input.autocomplete( "widget" ).is( ":visible" ); })
                .click(function() {
                  input.focus();

                  // Close if already visible
                  if ( wasOpen ) { return; }

                  // Pass empty string as value to search for, displaying all results
                  input.autocomplete( "search", "" );
                });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return { label : text,
                     value : text,
                     option: this
                    };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) { 
        // Selected an item, nothing to do
        if ( ui.item ) { return; }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) { return; }
 
        // Remove invalid value
        this.input.val( "" ).attr( "title", value + " no se encontro el valor ingresado, sino se encuentra el registro deseado, favor de darlo de alta con el simbolo +" )
                            .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() { this.input.tooltip( "close" ).attr( "title", "" ); }, 2500 );
        this.input.autocomplete( "instance" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }

	  ,
    autocomplete : function(value) {
        this.element.val(value);
        this.input.val(value);
    }
    });
  })( jQuery );