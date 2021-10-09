<?php 

echo form_input(array('name' => 'IVA_POR', 'id' => 'IVA_POR','type'=>'hidden','value' =>'.16'));
echo form_input(array('name' => 'facturaTimbrada', 'id' => 'facturaTimbrada','type'=>'hidden', 'value' =>'0'));
echo form_input(array('name' => 'controller_fac', 'id' => 'controller_fac', 'type'=>'hidden', 'value' =>CONTROLLER_FAC));

echo '<div id="modalFac" title="MODAL"> ';
echo form_open(base_url().'pedido/timbrar/', array( 'id' => 'CFDI_FORM') );
echo form_input(array('name' => 'sat_tasaocuota', 'id' => 'sat_tasaocuota','type'=>'hidden','value' =>'.16'));
echo form_input(array('name' => 'id_factura'    , 'id' =>'id_factura'     ,'type'=>'hidden','value' =>'' ) );
echo form_input(array('name' => 'folio'         , 'id' =>'folio'          ,'type'=>'hidden','value' =>'' ) );
echo '  <div class="row"> 
        <section class="col col-6" id="confirmtimbrar">&nbsp;</section> <section class="col col-6"><span id="vistapreviaPDF"></span><span id="timbrarPDF"></span></section></div>      
        <div id="tabsTimbrado">
        <ul>
            <li><a href="#tabs-1">Emisor</a></li>
            <li><a href="#tabs-2">Receptor</a></li>
            <li><a href="#tabs-3">Conceptos</a></li>
            <li><a href="#tabs-4">Info Pago</a></li>
            <li><a href="#tabs-5">Complementos de Pago REP</a></li>
            <li><a href="#tabs-6">CFDI Relacionados</a></li>
        </ul>
        <div id="tabs-1"> 
            <table style="width:100%">            
            <tr>
                <td width="40%" style="text-align:right">RFC: </td>
                <td width="60%">'. form_input(array('class'     => 'timb text-input ', 
                                                    'size'      => '12', 
                                                    'name'      => 'rfcEmisor',                                                     
                                                    'id'        => 'rfcEmisor',   
                                                    'disabled'  => 'disabled',                                 
                                                    'maxlength' => '40')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Razón Social: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '25', 
                                                    'name'      => 'rsEmisor', 
                                                    'id'        => 'rsEmisor',    
                                                    'disabled'  => 'disabled',                                
                                                    'maxlength' => '40')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Código Postal (Expedición): </td>
                <td width="60%">'.form_input(array('class'      => 'timb onlyNumber ', 
                                                    'size'      => '25', 
                                                    'name'      => 'cpEmisor', 
                                                    'id'        => 'cpEmisor',    
                                                    'disabled'  => 'disabled',                                
                                                    'maxlength' => '8')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Correo: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '25', 
                                                    'name'      => 'emailEmisor', 
                                                    'id'        => 'emailEmisor',    
                                                    'disabled'  => 'disabled',                                
                                                    'maxlength' => '80')).'
               </td>                
            </tr> 
            <tr>
                <td width="40%" style="text-align:right">Regimen Fiscal: </td>
                <td width="60%">'.form_dropdown('regimen_fiscal', $regimenFiscal, '601','id=\'regimen_fiscal\' ').'
                </td>                
            </tr>
            </table>'.br(2).'            
            <legend id="togdomFiscalEmisor" class="pointer">[<i class="fa fa-plus" id="imgdomFiscalEmisor"> </i>] Domicilio Fiscal (opcional)</legend><br>
			<div id="domFiscalEmisor"> <p id="labelDomFis"></p>  </div>
        </div>
        <div id="tabs-2">
            <table style="width:100%">            
            <tr>
                <td width="40%" style="text-align:right">RFC: </td>
                <td width="60%">'. form_input(array('class'     => 'timb text-input ', 
                                                    'size'      => '12', 
                                                    'name'      => 'rfcReceptor',                                                     
                                                    'id'        => 'rfcReceptor',                                                       
                                                    'maxlength' => '20')).'
                </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Razón Social: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '25', 
                                                    'name'      => 'rsReceptor',
                                                    'id'        => 'rsReceptor',
                                                    'maxlength' => '80')).'
                </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Código Postal (Dom. Fiscal): </td>
                <td width="60%">'.form_input(array('class'      => 'timb onlyNumber ', 
                                                    'size'      => '25', 
                                                    'name'      => 'cpReceptor', 
                                                    'id'        => 'cpReceptor',                                                        
                                                    'maxlength' => '8')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Correo: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '25', 
                                                    'name'      => 'emailReceptor',
                                                    'id'        => 'emailReceptor',
                                                    'maxlength' => '80')).'
                </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Uso de CFDI: </td>
                <td width="60%">'.form_dropdown('uso_cfdi', $usoCFDI, null,'id=\'uso_cfdi\' ').'
                </td>                
            </tr>
            </table>'.br(2).'
            <legend id="togdomFiscalReceptor" class="pointer">[<i class="fa fa-plus" id="imgdomFiscalReceptor"> </i>] Domicilio Fiscal (opcional)</legend><br>
			<div id="domFiscalReceptor"> <p id="labelDomFisReceptor"></p>  </div>
        </div>
        <div id="tabs-3">            
            <table style="width:100%">
            <tr class="noConcepts">
                <td width="30%"> <label for="conceptosSinCodSATlbl">1) Prod./Serv. cotizados: </label><br>
                                 <select id="conceptosSinCodSAT" name="conceptosSinCodSAT" multiple></select>
                </td>
                <td width="35%"><div class="ui-widget">
                                    <label for="cveProdSATlbl">2) Claves Prod./Serv. SAT: </label><br>
                                    <input id="cveProdSAT">
                                    '.br(1).'<label for="cveProdSATNot"><small>Ingrese al menos 3 caracteres para buscar</small></label>
                                </div>
                </td>
                <td width="35%"> <div class="ui-widget">
                                    <label for="clave_unidadSATlbl">3) Claves Unidad Medida SAT: </label><br>
                                    <input id="clave_unidadSAT">
                                    '.br(1).'<label for="clave_unidadSATNot"><small>Ingrese al menos 3 caracteres para buscar</small></label>                                           
                                </div>                
                </td>
            </tr>
            <tr class="noConcepts">
                <td width="100%" colspan="4" style="text-align:center">'.br(1).'<a class="button" id="buttonAsigCodSat">4) Agregar concepto Factura SAT</a> </td> 
            </tr>            
            <tr>
                <td width="100%" colspan="4">'.br(1).form_input(array('name' => 'numConceptosConCveSAT', 'id' => 'numConceptosConCveSAT','type'=>'hidden','value' =>'0')).'
                                              <table id="tblConceptosSAT" style="width:100%; border-collapse: collapse; border: 1px solid black;">
                                                 <tr><td width="100%" colspan="6" style="text-align:center"> <strong>No hay conceptos asignados para facturar</strong> </td></tr>
                                              </table>
                                              '.br(1).'
                </td>
            </tr>
            </table>
            <table style="width:100%">
            <tr>
                <td width="15%"><strong>SubTotal</strong> </td>
                <td width="35%"><span id="subtotalSATLbl"></span>'.form_input(array('name' => 'subtotalSAT', 'id' => 'subtotalSAT','type'=>'hidden','value' =>'0')).' </td>
                <td width="15%"> </td>
                <td width="35%" colspan="2"> </td>
            </tr>
            <tr>
                <td width="15%">Descuento </td>
                <td width="35%">'.form_input(array('class' => 'onlyNumber', 'size' => '2', 'name' => 'descuentoSAT', 'id' => 'descuentoSAT','maxlength' => '5','value' =>'0.0')).' %</td>
                <td width="15%">IVA </td>
                <td width="35%" colspan="2"><span id="ivaSATLbl"></span>'.form_input(array('name' => 'ivaSAT', 'id' => 'ivaSAT', 'type'=>'hidden', 'value' =>'0')).' </td>
            </tr>
            <tr>
                <td width="15%">Moneda de la Factura </td>
                <td width="35%">'.form_dropdown('monedaSAT', $monedaSAT, 'MXN','id=\'monedaSAT\' ').' </td>
                <td width="15%">Tipo de Cambio </td>
                <td width="20%">$'.form_input(array('class' => 'onlyNumber', 'size' => '5', 'name' => 'tcSAT', 'id' => 'tcSAT', 'maxlength' => '7')).'MXN </td>
                <td width="15%"><input type="checkbox" name="convertirAlTC" id="convertirAlTC" value="1"> <small>Convertir al Tipo de Cambio</small></td>
            </tr>
            <tr>
                <td width="15%"><strong>Total</strong> </td>
                <td width="35%"><span id="totalSATLbl"></span>'.form_input(array('name' => 'totalSAT', 'id' => 'totalSAT','type'=>'hidden','value' =>'0')).' </td>
                <td width="15%"> </td>
                <td width="35%" colspan="2"> </td>
            </tr>
            </table>
        </div>
        <div id="tabs-4">
            <table style="width:100%">  
                <tr>
                    <td width="20%" style="text-align:right">Método de Pago: </td>
                    <td width="30%">'.form_dropdown('metodo_pago', $metodoPago, '0','id=\'metodo_pago\' ').br(2).' </td>
                    <td width="20%" style="text-align:right">Forma de Pago: </td>
                    <td width="30%">'.form_dropdown('forma_pago', $formaPago, '0','id=\'forma_pago\' ').br(2).'</td>
                </tr>
                <tr>
                    <td width="20%" style="text-align:right">Notas: </td>
                    <td width="80%" colspan="3">'.form_textarea(array('name'      => 'notasFactura', 
                                                                      'id' 	      => 'notasFactura',
                                                                      'value'     => '',
                                                                      'rows'      => '2',
                                                                      'cols'      => '5',
                                                                      'style'     => 'width:100%',
                                                                      'maxlength' => '80')).br(2).' </td>
                </tr>    
                <tr>
                <td width="20%" style="text-align:right">Fecha de Expedición: </td>
                <td width="80%" colspan="3">'.form_input(array('class' 	=> 'datepicker',
                                                                'name' 	=> 'fecha_expedicion', 
                                                                'id' 	=> 'fecha_expedicion',
                                                                'value'     => $fechaExpedicion, 
                                                                'maxlength' => '11')).br(2).' </td>
            </tr>    
            </table>              
        </div>
         <div id="tabs-5">
            <span id="confirmvp_rep">&nbsp;</span>
            <span id="confirmtimbrar_rep">&nbsp;</span>
            <table cellspacing="0" id="tblRepFact" align="center" cellpadding="0" style="width:100%">  
            <tr>
                <td width="3% " style="text-align:right"><small>&nbsp;</small> </td>
                <td width="15%" style="text-align:left"><small><strong>Factura</strong></small> </td>
                <td width="11%" style="text-align:left"><small><strong>Saldo</strong> </small> </td>                
                <td width="13%" style="text-align:left"><small><strong>Saldo Insoluto</strong></small></td>
                <td width="25%" style="text-align:left"><small><strong>Fecha</strong></small></td>
                <td width="7%"  style="text-align:left"><small><strong># Parcial</strong></small></td>
                <td width="10% " style="text-align:left"><small><strong>Moneda</strong></small></td>
                <td width="10%" style="text-align:center"><small><strong>Status</strong></small></td>
                <td width="3% " style="text-align:center"><small>&nbsp;</small> </td>
                <td width="3% " style="text-align:center"><small>&nbsp;</small> </td>
            </tr>
            </table>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <i class="fa fa-arrow-circle-right fa-lg togREP" > <small>REP</small> </i> 
            <table cellspacing="0" id="tblDatRep" align="center" cellpadding="0" style="width:100%"> 
            <tr>                
                <td width="17%" style="text-align:right"><small>Moneda REP: </small></td>
                <td width="20%" >'.form_dropdown('moneda_rep', $monedaSAT, 'MXN','id=\'moneda_rep\' ').' </td>
                <td width="21%" style="text-align:right"><small>Tipo cambio REP: </small></td>
                <td width="20%" >$'.form_input(array('class' => 'onlyNumber', 'size' => '5', 'name' => 'tc_rep', 'id' => 'tc_rep', 'maxlength' => '7')).'MXN </td>
                <td width="12%" style="text-align:right"><small>Monto REP: </small></td>
                <td width="16%" >'.form_input(array('class' 	=> 'onlyNumber montoRep',
                                                    'name' 	    => 'monto_rep', 
                                                    'id' 	    => 'monto_rep',
                                                    'value'     => null, 
                                                    'size'      => 6, 
                                                    'maxlength' => '11')).' </td>
            </tr>              
            <tr>
                <td width="17%" style="text-align:right"><small>Forma de Pago REP: </small></td>
                <td width="20%" >'.form_dropdown('forma_pago_rep', $formaPago, '0','id=\'forma_pago_rep\' ').' </td>
                <td width="21%" style="text-align:right"><small>Fecha Pago: </small></td>
                <td width="20%" >'.form_input(array('class' 	=> 'datepicker',
                                                    'name' 	=> 'fecha_rep', 
                                                    'id' 	=> 'fecha_rep',
                                                    'size'      => 8, 
                                                    'value'     => $fechaExpedicion, 
                                                    'maxlength' => '11')).' </td>                
                <td width="12%" style="text-align:right"><small>Num. Parcialidad:</small> </td>
                <td width="16%" >'.form_input(array('class' 	=> 'onlyNumber',
                                                    'name' 	    => 'parcial_rep', 
                                                    'id' 	    => 'parcial_rep',
                                                    'value'     => 1, 
                                                    'size'      => 4, 
                                                    'maxlength' => '2')).' </td>
            </tr>    
            </table><br>
            
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr><td width="30%" > <i class="fa fa-arrow-circle-right fa-lg togDatBan" > <small>Datos Bancarios (Opcionales)</small> </i> </td>
                <td width="15%" > <span id="timbrar_repPDF"> </span></td>
                <td width="15%" > <span id="vp_repPDF"> </span> </td>
                <td width="20%" > <a href="javascript:vistaPreviaAX(\'vp_rep\');" class="button button-secondary">Vista previa REP</a> </td>
                <td width="20%" > <a href="javascript:timbrarREPAX();" class="button button-secondary">Timbrar REP</a> </td>
            </tr>    
            </table><br>';

            echo form_input(array('name' => 'uuidREP'       , 'id' =>'uuidREP'       ,'type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'id_pedidoREP'  , 'id' =>'id_pedidoREP'  ,'type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'id_facturaREP' , 'id' =>'id_facturaREP'  ,'type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'serieREP'      , 'id' =>'serieREP'      ,'type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'monedaREP'     , 'id' =>'monedaREP'     ,'type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'tipocambioREP' , 'id' =>'tipocambioREP' ,'type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'metodo_pagoREP', 'id' =>'metodo_pagoREP','type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'rfcReceptorREP', 'id' =>'rfcReceptorREP','type'=>'hidden','value' =>'' ) );
            echo form_input(array('name' => 'rsReceptorREP' , 'id' =>'rsReceptorREP','type'=>'hidden','value' =>'' ) );

            echo '<table cellspacing="0" id="tblDatBan" align="center" cellpadding="0" style="width:100%"> 
            <tr>
                <td width="16%" style="text-align:right"><small>Número de Operacion:</small> </td>
                <td width="16%" >'.form_input(array('class' 	=> 'onlyNumber',
                                                    'name' 	    => 'NumOperacion', 
                                                    'id' 	    => 'NumOperacion',
                                                    'value'     => '', 
                                                    'size'      => 5, 
                                                    'maxlength' => '15')).' </td>
                <td width="16%" style="text-align:right"><small>Banco Ordenante: </small></td>
                <td width="16%" >'.form_input(array('name' 	=> 'RfcEmisorCtaOrd', 
                                                    'id' 	=> 'RfcEmisorCtaOrd',
                                                    'size'      => 8, 
                                                    'value'     => '', 
                                                    'maxlength' => '30')).' </td>                
                <td width="16%" style="text-align:right"><small>Cuenta Bancaria Ordenante: </small></td>
                <td width="16%" >'.form_input(array('name' 	    => 'CtaOrdenante', 
                                                    'id' 	    => 'CtaOrdenante',
                                                    'value'     => '', 
                                                    'size'      => 6, 
                                                    'maxlength' => '20')).' </td>
            </tr>  
             <tr>
                <td width="16%" style="text-align:right"></td>
                <td width="16%" > </td>
                <td width="16%" style="text-align:right"><small>Banco Beneficiario: </small></td>
                <td width="16%" >'.form_input(array('name' 	=> 'RfcEmisorCtaBen', 
                                                    'id' 	=> 'RfcEmisorCtaBen',
                                                    'size'      => 8, 
                                                    'value'     => '', 
                                                    'maxlength' => '30')).' </td>                
                <td width="16%" style="text-align:right"><small>Cuenta Bancaria Beneficiaria: </small></td>
                <td width="16%" >'.form_input(array('name' 	    => 'CtaBeneficiario', 
                                                    'id' 	    => 'CtaBeneficiario',
                                                    'value'     => '', 
                                                    'size'      => 6, 
                                                    'maxlength' => '20')).' </td>
            </tr>    
            </table>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr><td width="30%" > <i class="fa fa-arrow-circle-right fa-lg togPagReg" > <small>Pagos Registrados</small> </i> </td>               
            </tr>    
            </table>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table id="tblREPs" cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr><td width="10%">Factura</td>
                    <td width="10%">  </td>
                    <td width="40%"> REP </td>
                    <td width="40%">  </td>
                </tr>    
            </table> 
        </div>

        <div id="tabs-6">';
        echo form_input(array('name' => 'cfdiRelTot', 'id' =>'cfdiRelTot', 'type'=>'hidden','value' =>0 ) );     
echo'       <table style="width:100%">  
            <tr>                
                <td width="20%" style="text-align:left">Tipo Relación: </td>
                <td width="35%">'.form_dropdown('tipo_relacion', $tipoRelacion, '0','id=\'tipo_relacion\' ').br(2).' </td>                
                <td width="20%" style="text-align:right">Tipo Comprobante: </td>
                <td width="25%">'.form_dropdown('tipo_comprobante', $tipoComprobante, '0','id=\'tipo_comprobante\' ').br(2).'</td>
            </tr>
            <tr>
                <td colspan="2" width="60%"><div class="ui-widget">
                                                <label for="uuidCfdiRellbl">UUID: </label>
                                                <input id="uuidCfdiRel">
                                                '.br(1).'<label for="uuidCfdiRelNot"><small>Ingrese al menos 2 caracteres para buscar</small></label>
                                             </div>
                </td>                
                <td colspan="2" width="40%">Notas:'.form_textarea(array('name'      => 'notasCfdiRel', 
                                                                        'id' 	    => 'notasCfdiRel',
                                                                        'value'     => '',
                                                                        'rows'      => '2',
                                                                        'cols'      => '5',
                                                                        'style'     => 'width:70%',
                                                                        'maxlength' => '80')).br(2).' </td>
            </tr>
            </table>
            <br>
            <table cellspacing="0" id="tblCfdiRel" align="center" cellpadding="0" style="width:100%">  
            <tr>
                <td width="5% " style="text-align:left"><small>&nbsp;</small> </td>
                <td width="15%" style="text-align:left"><small><strong>Folio</strong></small> </td>
                <td width="25%" style="text-align:left"><small><strong>UUID</strong></small> </td>
                <td width="10%" style="text-align:left"><small><strong>PDF</strong></small> </td>
                <td width="20%" style="text-align:left"><small><strong>Saldo</strong> </small> </td>                                                
                <td width="10%" style="text-align:left"><small><strong>Moneda</strong></small></td>
                <td width="20%" style="text-align:left"><small><strong>Fecha</strong></small></td>                 
            </tr>
            </table>
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr><td width="30%" > <span id="timbrar_cfdirelPDF"> </span></td>
                <td width="25%" > <span id="vp_cfdirelPDF"> </span> </td>
                <td width="25%" > <a href="javascript:vistaPreviaCfdiRelAX(\'vp_cfdirel\');" class="button button-secondary">Vista previa CFDI Rel</a> </td>
                <td width="20%" > <a href="javascript:timbrarCfdiRelAX();" class="button button-secondary">Timbrar CFDI Rel</a> </td>
            </tr>    
            </table><br>

        </div>        
    ';
echo form_close(); 
echo '</div>';

 ?>