<?php 

echo '<div id="modalRNom" title="RECIBO DE NOMINA '.TITULO_NAVEGADOR.'"> ';
echo form_open(base_url().'pedido/timbrar/', array( 'id' => 'CFDI_FORM_RN') );
echo form_input(array('name' => 'uuid', 'id' =>'uuid','type'=>'hidden','value' =>'' ) );
echo form_input(array('name' => 'id_recibo', 'id' =>'id_recibo','type'=>'hidden','value' =>'' ) );
echo form_input(array('name' => 'controller_fac', 'id' =>'controller_fac','type'=>'hidden', 'value' => CONTROLLER_FAC ) );
echo '  <div class="row"> 
        <section class="col col-6" id="confirmtimbrar">&nbsp;</section> <section class="col col-6"><span id="vistapreviaPDF"></span><span id="timbrarPDF"></span></section></div>      
        <div id="tabsTimbrado">
        <ul>';
        if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
        {
        echo '<li><a href="#tabs-1">Emisor</a></li>
              <li><a href="#tabs-2">Nomina</a></li>
              <li><a href="#tabs-3">Empleado</a></li>
              <li><a href="#tabs-4">Percepciones</a></li>
              <li><a href="#tabs-5">Deducciones</a></li>
              <li><a href="#tabs-6">Otros Pagos</a></li>
              <li><a href="#tabs-7">Incapcidades</a></li>';
        }
        echo '<li><a href="#tabs-8"><i class="fa fa-download"></i> Recibos</a></li>          
        </ul>';
        if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
        {
        echo ' 
        <div id="tabs-1"> <!-- Emisor -->
            <table style="width:100%">
            <tr>
                <td width="40%" style="text-align:right">RFC: </td>
                <td width="60%">'. form_input(array('class'     => 'timb text-input ', 
                                                    'size'      => '12', 
                                                    'name'      => 'rfcEmisor',                                                     
                                                    'id'        => 'rfcEmisor',   
                                                    'readonly'  => 'readonly',                                 
                                                    'maxlength' => '40')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Razón Social: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '25', 
                                                    'name'      => 'rsEmisor', 
                                                    'id'        => 'rsEmisor',    
                                                    'readonly'  => 'readonly',                                
                                                    'maxlength' => '40')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Código Postal (Expedición): </td>
                <td width="60%">'.form_input(array('class'      => 'timb onlyNumber ', 
                                                    'size'      => '25', 
                                                    'name'      => 'cpEmisor', 
                                                    'id'        => 'cpEmisor',    
                                                    'readonly'  => 'readonly',                                
                                                    'maxlength' => '8')).'
               </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Correo: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '20', 
                                                    'name'      => 'emailEmisor', 
                                                    'id'        => 'emailEmisor',    
                                                    'readonly'  => 'readonly',
                                                    'maxlength' => '80')).'
               </td>                
            </tr> 
            <tr>
                <td width="40%" style="text-align:right">Regimen Fiscal: </td>
                <td width="60%">'.form_dropdown('regimen_fiscal', $regimenFiscal, '601','id=\'regimen_fiscal\' ').'
                </td>                
            </tr>
            <tr>
                <td width="40%" style="text-align:right">Registro Patronal: </td>
                <td width="60%">'.form_input(array('class'      => 'timb text-input ', 
                                                    'size'      => '25', 
                                                    'name'      => 'RegistroPatronal', 
                                                    'id'        => 'RegistroPatronal',
                                                    'maxlength' => '80')).'
               </td>                
            </tr> 
            </table>
            
        </div>
        <div id="tabs-2"> <!-- NOMINA -->
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        <br>
        <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
        <tr>
            <td width="20%" style="text-align:right"><small>Tipo de Nomina:</small> </td>
            <td width="50%" style="text-align:left"><label class="select">'.form_dropdown('TipoNomina', $tipoNomina, 'O','id=\'TipoNomina\' ').' <i></i> </label> </td>
            <td width="10%" style="text-align:right"><small>Días pagados:</small> </td>                
            <td width="20%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                        'size'      => '8', 
                                                                        'name'      => 'NumDiasPagados', 
                                                                        'id'        => 'NumDiasPagados',
                                                                        'maxlength' => '4')).' </td>                
        </tr>
        </table>
        <table cellspacing="0" align="center" cellpadding="0" style="width:100%">              
            <tr>
                <td width="15%" style="text-align:right"><small>Fecha de Pago:</small> </td>
                <td width="18%" style="text-align:left"> '.form_input(array('class' 	=> 'datepicker','size' => '10','name' => 'FechaPago', 'id' => 'FechaPago', 'maxlength' => '11')).'</td>
                <td width="15%" style="text-align:right"><small>Fecha Inicial de Pago:</small> </td>
                <td width="18%" style="text-align:left"> '.form_input(array('class' 	=> 'datepicker','size' => '10','name' => 'FechaInicialPago', 'id' => 'FechaInicialPago', 'maxlength' => '11')).'</td>
                <td width="15%" style="text-align:right"><small>Fecha Final de Pago:</small> </td>
                <td width="18%" style="text-align:left"> '.form_input(array('class' 	=> 'datepicker','size' => '10','name' => 'FechaFinalPago', 'id' => 'FechaFinalPago', 'maxlength' => '11')).'</td>
            </tr>
            <tr>
                <td width="25%" style="text-align:right"><small>Origen de los Recursos:</small> </td>
                <td width="75%" style="text-align:left" colspan="5"> <label class="select">'.form_dropdown('origenRecursos', $origenRecurso, 'IP','id=\'origenRecursos\' ').' <i></i> </label> </td>
            </tr>
        </table><br><br>
        <hr style="height:2px;border-width:0;color:gray;background-color:gray">
        <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr>
                <td width="100%" style="text-align:center" colspan="6"><strong>TOTALES</strong> <br></td>                
            </tr>
            <tr>
                <td width="15%" style="text-align:right">PERCEPCIONES: </td>
                <td width="18%" style="text-align:left"><strong><span id="txtTotPE_RN"> </span></strong>'.form_input(array('name' => 'TotalPercepciones', 'id' => 'TotalPercepciones','type'=>'hidden','value' =>'0')).'</td>
                <td width="15%" style="text-align:right">DEDUCCIONES: </td>
                <td width="18%" style="text-align:left"><strong><span id="txtTotDE_RN"> </span></strong>'.form_input(array('name' => 'TotalDeducciones', 'id' => 'TotalDeducciones','type'=>'hidden','value' =>'0')).'</td>
                <td width="15%" style="text-align:right">OTROS PAGOS: </td>
                <td width="18%" style="text-align:left"><strong><span id="txtTotOP_RN"> </span></strong>'.form_input(array('name' => 'TotalOtrosPagos' , 'id' => 'TotalOtrosPagos','type'=>'hidden','value' =>'0')).'</td>
            </tr>
        </table>
        </div>
        <div id="tabs-3"> <!-- EMPLEADO -->
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr>
                <td width="25%" style="text-align:right"><small>Nombre Completo: </small></td>
                <td width="25%" colspan="2" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '24', 
                                                                            'name'      => 'nombre_emp', 
                                                                            'id'        => 'nombre_emp',
                                                                            'maxlength' => '50')).'</td>
                <td width="25%" style="text-align:right"><small>Correo: </small></td>
                <td width="25%" colspan="2" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '24', 
                                                                            'name'      => 'correo_emp', 
                                                                            'id'        => 'correo_emp',
                                                                            'readonly'  => 'readonly',
                                                                            'maxlength' => '50')).'</td>                                                                            
            </tr>            
            <tr>                                                                            
                <td width="15%" style="text-align:right"><small>RFC: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'RFC', 
                                                                            'id'        => 'RFC',
                                                                            'maxlength' => '20')).' </td>
                <td width="15%" style="text-align:right"><small>CURP: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'Curp', 
                                                                            'id'        => 'Curp',
                                                                            'maxlength' => '20')).' </td>
                <td width="15%" style="text-align:right"><small>Num Seg. Social: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'NumSeguridadSocial', 
                                                                            'id'        => 'NumSeguridadSocial',
                                                                            'maxlength' => '20')).' </td>                                                                            
            </tr>
            <tr>                                                                            
                <td width="15%" style="text-align:right"><small>Num. Empleado: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'NumEmpleado', 
                                                                            'id'        => 'NumEmpleado',
                                                                            'maxlength' => '20')).' </td>
                <td width="15%" style="text-align:right"><small>Puesto: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'puesto_emp', 
                                                                            'id'        => 'puesto_emp',
                                                                            'maxlength' => '80')).' </td>
                <td width="15%" style="text-align:right"><small>Clave Entidad: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '10', 
                                                                            'name'      => 'cve_entidad_emp', 
                                                                            'id'        => 'cve_entidad_emp',                                                                            
                                                                            'maxlength' => '50'))
                                                                            .'</td>
                                                                        </tr>
            <tr>                                                                            
                <td width="15%" style="text-align:right"><small>Fecha Inicio: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'FechaInicioRelLaboral', 
                                                                            'id'        => 'FechaInicioRelLaboral',
                                                                            'maxlength' => '20')).' </td>
                <td width="15%" style="text-align:right"><small>Sueldo Base: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'SalarioBaseCotApor', 
                                                                            'id'        => 'SalarioBaseCotApor',
                                                                            'maxlength' => '20')).' </td>
                <td width="15%" style="text-align:right"><small>Sueldo diario integrado: </small></td>                
                <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'SalarioDiarioIntegrado', 
                                                                            'id'        => 'SalarioDiarioIntegrado',
                                                                            'maxlength' => '20')).' </td>                                                                            
            </tr>
            <tr>
                <td width="15%" style="text-align:right"><small>Tipo Jornada: </small></td>
                <td width="18%" style="text-align:left"> '.form_dropdown('tipo_jornada_emp', $tipoJornada, '0','id=\'tipo_jornada_emp\' ').'</td> 
                <td width="15%" style="text-align:right"><small>Sindicalizado: </small></td>
                <td width="18%" style="text-align:left"> '.form_dropdown('sindi_emp', $sindicalizado, '0','id=\'sindi_emp\' ').'</td> 
                <td width="15%" style="text-align:right"><small>Periodicidad Pago: </small></td>
                <td width="18%" style="text-align:left"> '.form_dropdown('periodo_emp', $periodicidadPago, '0','id=\'periodo_emp\' ').'</td>                 
            </tr>                
            <tr>             
                <td width="20%" style="text-align:right"><small>Tipo Régimen: </small></td>
                <td width="80%" style="text-align:left" colspan="5"> '.form_dropdown('tipo_regimen_emp', $tipoRegimen, '0','id=\'tipo_regimen_emp\' ').'</td> 
            </tr>                
            <tr>             
                <td width="15%" style="text-align:right"><small>Tipo Contrato: </small></td>
                <td width="60%" style="text-align:left" colspan="3"> '.form_dropdown('tipo_contrato_emp',$tipoContrato, '0','id=\'tipo_contrato_emp\' ').'</td> 
                <td width="10%" style="text-align:right"><small>Riesgo: </small></td>
                <td width="15%" style="text-align:left"> '.form_dropdown('riesgo_emp', $riesgoPuesto, '0','id=\'riesgo_emp\' ').'</td> 
            </tr>            
            </table>
            
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr>
                <td width="100%" style="text-align:center" colspan="4"><strong>DATOS BANCARIOS</strong> <br></td>                
            </tr>
            <tr>
                <td width="25%" style="text-align:right">Banco: </td>
                <td width="25%" style="text-align:left"> '.form_dropdown('banco_emp', $nominaBanco, '0','id=\'banco_emp\' ').'</td>
                <td width="25%" style="text-align:right">Cuenta Bancaria: </td>                
                <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                            'size'      => '12', 
                                                                            'name'      => 'cuenta_banco_emp', 
                                                                            'id'        => 'cuenta_banco_emp',
                                                                            'maxlength' => '20')).' </td>                
            </tr>
            </table>
        </div>
        <div id="tabs-4"> <!-- PERCEPCIONES -->            
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="100%" style="text-align:center" colspan="4"><strong>INFORMACIÓN GENERAL</strong> <br></td>                
                </tr>
                <tr>
                    <td width="25%" style="text-align:right">Total Sueldos: </td>
                    <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                                'size'      => '12', 
                                                                                'name'      => 'tot_sueldo_emp', 
                                                                                'id'        => 'tot_sueldo_emp',
                                                                                'maxlength' => '20')).' </td>      
                    <td width="25%" style="text-align:right">Total Antiguedad: </td>                
                    <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                                'size'      => '12', 
                                                                                'name'      => 'tot_anti_emp', 
                                                                                'id'        => 'tot_anti_emp',
                                                                                'maxlength' => '20')).' </td>                
                </tr>
                <tr>
                    <td width="25%" style="text-align:right">Total Gravado: </td>
                    <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                                'size'      => '12', 
                                                                                'name'      => 'tot_gravado_emp', 
                                                                                'id'        => 'tot_gravado_emp',
                                                                                'maxlength' => '20')).' </td>      
                    <td width="25%" style="text-align:right">Total Exento: </td>                
                    <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                                'size'      => '12', 
                                                                                'name'      => 'tot_ext_emp', 
                                                                                'id'        => 'tot_ext_emp',
                                                                                'maxlength' => '20')).' </td>                
                </tr>
            </table>
            <br>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="80%" style="text-align:center" colspan="5"><strong>INFORMACIÓN DETALLADA</strong> <br></td>
                    <td width="20%" style="text-align:left"   colspan="1"><legend id="per" class="newConcept"> <i class="fa fa-plus-circle" style="color:#7d141A;"> Agregar Percepciones</i> </legend> </td>
                </tr>
            </table>
            <div id="dialogPer" title="Tipo Percepción">  
                <br> Seleccione el tipo de percepción a incluir en el recibo:<br>
                    '.form_dropdown('percepciones', $percepcion, '0','id=\'percepciones\' ').'
            </div>
            <br>
            <table id="detallePercepciones" cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="10%" style="text-align:center"><small>Tipo</small> </td>
                    <td width="10%" style="text-align:center"><small>Clave</small> </td>
                    <td width="20%" style="text-align:center"><small>Concepto</small> </td>
                    <td width="20%" style="text-align:center"><small>Importe Gravado</small> </td>
                    <td width="20%" style="text-align:center"><small>Importe Exento</small> </td>
                    <td width="10%" style="text-align:center"><small>Acciones</small> </td>
                </tr>
            </table>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="100%" style="text-align:center" colspan="6"><strong>INFORMACIÓN DE PAGOS POR SEPARACIÓN E INDEMNIZACIÓN</strong> <br></td>                
                </tr>
                <tr>                                                                            
                    <td width="15%" style="text-align:right"><small>Total Pagado: </small></td>                
                    <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                                'size'      => '15', 
                                                                                'name'      => 'tot_pag_dec_emp', 
                                                                                'id'        => 'tot_pag_dec_emp',
                                                                                'maxlength' => '20')).' </td>
                    <td width="15%" style="text-align:right"><small>Años de Servicio: </small></td>                
                    <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                                'size'      => '15', 
                                                                                'name'      => 'ano_serv_dec_emp', 
                                                                                'id'        => 'ano_serv_dec_emp',
                                                                                'maxlength' => '20')).' </td>
                    <td width="15%" style="text-align:right"><small>Último Sueldo: </small></td>                
                    <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                                'size'      => '15', 
                                                                                'name'      => 'ul_sueldo_dec_emp', 
                                                                                'id'        => 'ul_sueldo_dec_emp',
                                                                                'maxlength' => '20')).' </td>
                </tr>
                <tr>                                                                            
                    <td width="15%" style="text-align:right"><small>Ingreso Acumulable: </small></td>                
                    <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                                'size'      => '15', 
                                                                                'name'      => 'ing_acu_dec_emp', 
                                                                                'id'        => 'ing_acu_dec_emp',
                                                                                'maxlength' => '20')).' </td>
                    <td width="15%" style="text-align:right"><small>Ingreso No Acumulable: </small></td>                
                    <td width="18%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                                'size'      => '15', 
                                                                                'name'      => 'ing_noacu_dec_emp', 
                                                                                'id'        => 'ing_noacu_dec_emp',
                                                                                'maxlength' => '20')).' </td>
                    <td width="15%" style="text-align:right"></td>                
                    <td width="18%" style="text-align:left"> </td>
                </tr>
            </table>
        </div>
        <div id="tabs-5"><!-- DEDUCCIONES -->
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="100%" style="text-align:center" colspan="6"><strong>INFORMACIÓN GENERAL</strong> <br></td>                
                </tr>
                <tr>
                    <td width="25%" style="text-align:right">Total Otras Deducciones: </td>
                    <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                                'size'      => '12', 
                                                                                'name'      => 'tot_o_deduc_emp', 
                                                                                'id'        => 'tot_o_deduc_emp',
                                                                                'maxlength' => '20')).' </td>      
                    <td width="25%" style="text-align:right">Total Impuestos Retenidos: </td>                
                    <td width="25%" style="text-align:left"> '.form_input(array('class'     => 'timb text-input ', 
                                                                                'size'      => '12', 
                                                                                'name'      => 'tot_imp_ret_emp', 
                                                                                'id'        => 'tot_imp_ret_emp',
                                                                                'maxlength' => '20')).' </td>                
                </tr>
            </table>
            <div id="dialogDed" title="Tipo Deducción">  
                <br> Seleccione el tipo de deducción a incluir en el recibo:<br>
                    '.form_dropdown('deducciones', $deduccion, '0','id=\'deducciones\' ').'
            </div>
            <br>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="80%" style="text-align:center" colspan="5"><strong>INFORMACIÓN DETALLADA</strong> <br></td>                
                    <td width="20%" style="text-align:left"   colspan="1"><legend id="ded" class="newConcept"> <i class="fa fa-plus-circle" style="color:#7d141A;"> Agregar Deducciones</i> </legend> </td>
                </tr>
            </table>
            <table id="detalleDeducciones" cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="10%" style="text-align:center"><small>Clave</small> </td>
                    <td width="20%" style="text-align:center"><small>Concepto</small> </td>
                    <td width="20%" style="text-align:center"><small>Importe</small> </td>                
                    <td width="10%" style="text-align:center"><small>Acciones</small> </td>
                </tr>
            </table>
        </div>
        <div id="tabs-6"><!-- OTROS PAGOS -->
            <div id="dialogOP" title="Tipo de otros pagos">  
                    <br> Seleccione qué tipo de otros pagos se va a incluir en el recibo:<br>
                        '.form_dropdown('otrosPagos', $otroPago, '0','id=\'otrosPagos\' ').'
            </div>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="80%" style="text-align:center" colspan="5"><strong>INFORMACIÓN DETALLADA</strong> <br></td> 
                    <td width="20%" style="text-align:left"   colspan="1"><legend id="op" class="newConcept"> <i class="fa fa-plus-circle" style="color:#7d141A;"> Agregar Otros Pagos</i> </legend> </td>
                </tr>
            </table>
            <table id="detalleOtrosPagos" cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="10%" style="text-align:center"><small>Clave</small> </td>
                    <td width="20%" style="text-align:center"><small>Concepto</small> </td>
                    <td width="20%" style="text-align:center"><small>Importe</small> </td>                
                    <td width="10%" style="text-align:center"><small>Acciones</small> </td>
                </tr>
            </table>         
        </div>
        <div id="tabs-7"><!-- INCAPACIDADES -->
            <div id="dialogInc" title="Tipo Incapacidad">  
                    <br> Seleccione el tipo de incapacidad a incluir en el recibo:<br>
                        '.form_dropdown('incapacidades', $incapacidad, '0','id=\'incapacidades\' ').'
            </div>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">            
            <table cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="80%" style="text-align:center" colspan="5"><strong>INFORMACIÓN DETALLADA</strong> <br></td>
                    <td width="20%" style="text-align:left"   colspan="1"><legend id="in" class="newConcept"> <i class="fa fa-plus-circle" style="color:#7d141A;"> Agregar Incapacidades</i> </legend> </td>
                </tr>
            </table>
            <table id="detalleIncapacidades" cellspacing="0" align="center" cellpadding="0" style="width:100%">  
                <tr>
                    <td width="10%" style="text-align:center"><small>Clave</small> </td>
                    <td width="20%" style="text-align:center"><small>Concepto</small> </td>
                    <td width="20%" style="text-align:center"><small>Dias de Incapacidad</small> </td>
                    <td width="10%" style="text-align:center"><small>Importe</small> </td>                
                    <td width="10%" style="text-align:center"><small>Acciones</small> </td>
                </tr>
            </table>         
        </div>
        ';
        }    
        else { echo form_input(array('name' => 'correo_emp', 'id' =>'correo_emp','type'=>'hidden','value' =>'' ) ); }

        echo '
        <div id="tabs-8"><!-- RECIBOS -->            
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
            <legend id="togfiltrosFormRE">[<i class="fa fa-plus" id="imgfiltrosFormRE"> </i>] Filtros de Busqueda </legend> 
            <table id="filtrosFormRE" cellspacing="0" align="center" cellpadding="0" style="width:100%">  
            <tr>
                <td width="15%" style="text-align:right"><small>Fecha Inicio: </small></td>
                <td width="25%" style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'fechaini_rec', 
                                                                            'id'        => 'fechaini_rec',
                                                                            'maxlength' => '50')).'</td>
                <td width="15%" style="text-align:right"><small>Fecha Fin: </small></td>
                <td width="25%"  style="text-align:left">'.form_input(array('class'      => 'timb text-input ', 
                                                                            'size'      => '15', 
                                                                            'name'      => 'fechafin_rec', 
                                                                            'id'        => 'fechafin_rec',                                                                            
                                                                            'maxlength' => '50')).'</td>
                <td width="20%" style="text-align:right"><a href="javascript:paginarMisRecibosNominasAX(1,10,\''.base_url().'\');" class="button button-secondary">Buscar</a></td>
            </tr>   
            </table>
            <hr style="height:2px;border-width:0;color:gray;background-color:gray">
                <div class="row">            
                        <section id="titFac"   class="col col-5"><center><strong>Mis Recibos</strong></center></section>
                        <section id="iconDown" class="col col-4"></section>
                        <section id="facDown"  class="col col-3"></section>
                    </div>'.br();                
                echo '<div class="row">
                    <section class="col col-11">';
                
                echo $gridMisRecibos;
                
                echo br().'<div id="linksPaginarMisRecibos"></div><span id="spinPaginarMisRecibos"></span>
                    </section>
                </div>'.br(1).'         
        </div>
    ';
echo form_close(); 
echo '</div>';

 ?>