<?php include("header_lg_admin.php"); ?>


<script>
var hrefC= '<?php echo base_url(); ?>';

  $(function(){$( document ).tooltip();});
  
  $(document).ready(function(){	  
	  $("#rfc").change(function(){validaCampoDuplicadoAX("clientes","rfc",$(this).val(),hrefC)});
	  $("#correo").change(function(){validaCampoDuplicadoAX("clientes","correo",$(this).val(),hrefC)});
	  $("#cotis").change(function(){traeDatosClienteCotiAX($(this).val(),hrefC)});	  
	  $('.btnDelete').addClass('pointer');
	  $(".btnDelete").bind("click", Delete);
	  });

</script>

               
<?php
	echo form_open(base_url().'gestion/guardarcliente/', array('class' => 'sky-form', 'id' => 'cliente'));
        echo '<header>Cliente Nuevo</header>';        
        echo ' <fieldset>
        <div class="row">          
         <section class="col col-9"> <label class="label">Tomar datos de la cotizaci&oacute;n:</label>
                                        <label class="select"><i class="icon-append"></i>'.
                                         form_dropdown('cotis', $cotizaciones, '0','id=\'cotis\' ').'
                                        </label><span id="cotiServMensaje"> </span><span id="secCoti"> </span>
            </section>
            <section class="col col-3">&nbsp;</section>
        </div>
        </fieldset>';
        
        echo ' <fieldset>
                <div class="row">          
                 <section class="col col-6"> 
                    <label class="label">RFC</label>
                    <label class="input"><i class="icon-append fa fa-male"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'rfc', 
                                     'id'          => 'rfc',
                                     'placeholder' => "Ej. ABCDEF12345678",
                                     'value'       => $cliente['datos'][0]['rfc'],                                     
                                     'maxlength'   => '14')).'
                     <b class="tooltip tooltip-bottom-right">Registro Federal de Contribuyentes. Personas morales debe contener 12 caracteres y 13 caracteres para las personas f&iacute;sicas</b>
                    </label><span id= "validarfc"></span>
                    </section>
                    <section class="col col-6">
                    <label class="label">Raz&oacute;n Social</label>
                    <label class="input"><i class="icon-append fa fa-male"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'nombre_cliente', 
                                     'id'          => 'nombre_cliente',
                                     'placeholder' => "Ej. Senni Logistics SA. de CV.",
                                     'value'       => $cliente['datos'][0]['razon_social'],                                     
                                     'maxlength'   => '40')).'
                     <b class="tooltip tooltip-bottom-right">Raz&oacute;n social del cliente hasta 40 caracteres</b>
                    </label>
                    </section>
                </div>
                <div class="row">          
                 <section class="col col-3"> 
                    <label class="label">Calle</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'calle', 
                                     'id'          => 'calle',
                                     'placeholder' => "Ej. Av. Reforma",
                                     'value'       => $cliente['datos'][0]['calle'],                                     
                                     'maxlength'   => '40')).'
                     <b class="tooltip tooltip-bottom-right">Calle del domicilio fiscal</b>
                    </label><span id= "validarfc"></span>
                    </section>
                    <section class="col col-3">
                    <label class="label">N&uacute;mero Exterior / Interior</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[numExtInt]] text-input', 
                                     'name'        => 'numero', 
                                     'id'          => 'numero',
                                     'placeholder' => "Ej. 1234 int A",
                                     'value'       => $cliente['datos'][0]['numero'],                                     
                                     'maxlength'   => '20')).'
                     <b class="tooltip tooltip-bottom-right">N&uacute;mero del domicilio fiscal.Primero el n&uacute;mero externo y luego(-,int,interior) interno. Ejemplo  1234 int A</b>
                    </label>
                    </section>
                    <section class="col col-3"> 
                    <label class="label">Colonia</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'colonia', 
                                     'id'          => 'colonia',
                                     'placeholder' => "Ej. Roma Norte",
                                     'value'       => $cliente['datos'][0]['colonia'],                                     
                                     'maxlength'   => '40')).'
                     <b class="tooltip tooltip-bottom-right">Colonia del domicilio fiscal</b>
                    </label><span id= "validarfc"></span>
                    </section>
                    <section class="col col-3">
                    <label class="label">Delegaci&oacute;n o Municipio</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'delegacion', 
                                     'id'          => 'delegacion',
                                     'placeholder' => "Ej. Tlalpan",
                                     'value'       => $cliente['datos'][0]['delegacion'],                                     
                                     'maxlength'   => '30')).'
                     <b class="tooltip tooltip-bottom-right">Delegaci&oacute;n o Municipio del domicilio fiscal</b>
                    </label>
                    </section>
                </div>
                <div class="row">          
                 <section class="col col-4"> 
                    <label class="label">Estado</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'estado', 
                                     'id'          => 'estado',
                                     'placeholder' => "Ej. CDMX",
                                     'value'       => $cliente['datos'][0]['estado'],                                     
                                     'maxlength'   => '30')).'
                     <b class="tooltip tooltip-bottom-right">Colonia del domicilio fiscal</b>
                    </label>
                    </section>
                    <section class="col col-4">
                    <label class="label">País</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'pais', 
                                     'id'          => 'pais',
                                     'placeholder' => "Ej. Mexico",
                                     'value'       => $cliente['datos'][0]['pais'],                                     
                                     'maxlength'   => '30')).'
                     <b class="tooltip tooltip-bottom-right">País del domicilio fiscal.Primero el n&uacute;mero externo y luego(-,int,interior) interno. Ejemplo  1234 int A</b>
                    </label>
                    </section>
                    <section class="col col-4"> 
                    <label class="label">C&oacute;digo Postal</label>
                    <label class="input"><i class="icon-append fa fa-university"></i>'.
                    form_input(array('class'     => 'validate[required,custom[number]] text-input', 
                                     'name'        => 'cp', 
                                     'id'          => 'cp',
                                     'placeholder' => "Ej. 123456",
                                     'value'       => $cliente['datos'][0]['cp'],                                     
                                     'maxlength'   => '5')).'
                     <b class="tooltip tooltip-bottom-right">C&oacute;digo Postal del domicilio fiscal</b>
                    </label><span id= "validarfc"></span>
                    </section>
                   </div>
            </fieldset>
            <fieldset>
            <div class="row">          
            <section class="col col-2">&nbsp;</section>
            <section class="col col-4"> 
               <label class="label">Correo Principal</label>
               <label class="input"><i class="icon-append fa fa-envelope-o"></i>'.
               form_input(array('class'     => 'validate[required,custom[email]] text-input', 
                                'name'        => 'correo_p', 
                                'id'          => 'correo_p',
                                'placeholder' => "Ej: test@test.com",
                                'value'       => $cliente['datos'][0]['correo'],                                     
                                'maxlength'   => '50')).'
                <b class="tooltip tooltip-bottom-right">Correo de contacto principal</b>
               </label><span id= "validacorreo"></span>
               </section>
               <section class="col col-1">&nbsp;</section>
               <section class="col col-3"> 
               <label class="label">Días de Vencimiento(estado de cuenta)</label>
               <label class="input"><i class="icon-append fa fa-university"></i>'.
               form_input(array('class'     => 'validate[required,custom[number]] text-input', 
                                'name'        => 'dias_vencimiento', 
                                'id'          => 'dias_vencimiento',
                                'placeholder' => "Ej: 1",
                                'value'       => $cliente['datos'][0]['dias_vencimiento'],                                     
                                'maxlength'   => '50')).'
                <b class="tooltip tooltip-bottom-right">Correo de contacto principal</b>
               </label><span id= "validacorreo"></span>
               </section>
            <section class="col col-2">&nbsp;</section>
           </div>
                </fieldset>
                <fieldset>
                <div class="row">          
                 <section class="col col-11">';	
                    $tmpl = array('table_open'  => '<table cellspacing="0" id="contactos" cellpadding="0" width="100%">' );
                    $this->table->set_template($tmpl);
                   
                    $ttvar_ag = '<a href="javascript:addRowDC(hrefC)"><img title="Agregar Datos de Contacto" src="'.base_url().'images/new.png"/> </a>';
                    $this->table->add_row(array('&nbsp;'));
                    $this->table->add_row(array('<legend>Datos de Contacto</legend>'));
                    $this->table->add_row(array('&nbsp;'));
                    $this->table->add_row(array('Nombre Contacto ','Tel&eacute;fono','Correo',''));

                    if ($cliente["contactos"] == FALSE)
                        {$this->table->add_row(array('<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-user"></i>'.
                                                        form_input(array('class'     => 'validate[custom[onlyLetterNumber]] text-input', 
                                                                         'name'        => 'contacto0', 
                                                                         'id'          => 'contacto0',
                                                                         'placeholder' => "Ej. Juan Perez",
                                                                         'value'       => '',
                                                                         'maxlength'   => '40')).'
                                                         <b class="tooltip tooltip-bottom-right">Nombre del contacto hasta 30 caracteres</b>
                                                        </label>
                                                        </section>',
                                                     '<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-phone"></i>'.
                                                        form_input(array('class'     => 'validate[custom[phone]] text-input', 
                                                                         'name'        => 'tel0', 
                                                                         'id'          => 'tel0',
                                                                         'placeholder' => "Ej. +1 (52) 768-2334 ext 703",
                                                                         'value'       => '',
                                                                         'maxlength'   => '30')).'
                                                         <b class="tooltip tooltip-bottom-right">Tel&eacute;fono de contacto solo n&uacute;meros incluir lada: +1 (305) 768-2334 extension 703</b>
                                                        </label>
                                                        </section>',
                                                     '<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-envelope-o"></i>'.
                                                        form_input(array('class'     => 'validate[custom[email]] text-input', 
                                                                         'name'        => 'correo0', 
                                                                         'id'          => 'correo0',
                                                                         'placeholder' => "Ej. jp@test.com",
                                                                         'value'       => '',
                                                                         'maxlength'   => '50')).'
                                                         <b class="tooltip tooltip-bottom-right">Correo de contacto alternativo</b>
                                                        </label>
                                                        </section>',
                                                     $ttvar_ag.
                                                     form_input(array('name' => 'num_dc', 'type'=>'hidden', 'id' =>'num_dc','value' =>'0'))
                                                    ));}
                    else
                    {
                            $x = -1;
                            foreach($cliente["contactos"] as $dc)
                            {
                                    $x = $x+1;                                    		
                                    if($x == 0)
                                        { $ttvar_ag = '<a href="javascript:addRowDC(hrefC)"><img title="Agregar Datos de Contacto" src="'.base_url().'images/new.png"/> </a>'; }
                                    else
                                        { $ttvar_ag = '<img title="Eliminar Datos del Cliente" class="btnDelete pointer" src="'.base_url().'images/erase.png">'; }
                                    $this->table->add_row(array('<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-user"></i>'.
                                                        form_input(array('class'       => 'validate[custom[onlyLetterNumber]] text-input', 
                                                                         'name'        => 'contacto'.$x, 
                                                                         'id'          => 'contacto'.$x,
                                                                         'placeholder' => "Ej. Juan Perez",
                                                                         'value'       => $dc["contacto"],
                                                                         'maxlength'   => '40')).'
                                                         <b class="tooltip tooltip-bottom-right">Nombre del contacto hasta 30 caracteres</b>
                                                        </label>
                                                        </section>',
                                                     '<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-phone"></i>'.
                                                        form_input(array('class'     => 'validate[custom[phone]] text-input', 
                                                                         'name'        => 'tel'.$x, 
                                                                         'id'          => 'tel'.$x,
                                                                         'placeholder' => "Ej. +1 (52) 768-2334 ext 703",
                                                                         'value'     => $dc["telefeno"],
                                                                         'maxlength'   => '30')).'
                                                         <b class="tooltip tooltip-bottom-right">Tel&eacute;fono de contacto solo n&uacute;meros incluir lada: +1 (305) 768-2334 extension 703</b>
                                                        </label>
                                                        </section>',
                                                     '<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-envelope-o"></i>'.
                                                        form_input(array('class'     => 'validate[custom[email]] text-input', 
                                                                         'name'        => 'correo'.$x, 
                                                                         'id'          => 'correo'.$x,
                                                                         'placeholder' => "Ej. jp@test.com",
                                                                         'value'     => $dc["correo"],
                                                                         'maxlength'   => '50')).'
                                                         <b class="tooltip tooltip-bottom-right">Correo de contacto alternativo</b>
                                                        </label>
                                                        </section>',
                                                                $ttvar_ag));
                            }
                            $this->table->add_row(array('','',form_input(array('name'  => 'num_dc', 
                                                                                'type'  => 'hidden', 
                                                                                'id'    => 'num_dc',
                                                                                'value' => $x))));
                    }
                    echo $this->table->generate();
                    echo form_input(array('name'  => 'accion', 'type' => 'hidden','id' => 'accion', 'value' => $accion));
                    echo form_input(array('name'  => 'rfc_ant','type' => 'hidden','id' => 'rfc_ant','value' => $cliente["datos"][0]['rfc']));        
   
        echo "</section>
            </div>
            </fieldset>
            <footer>\n
                <a class='button' href='javascript:submitForm(\"cliente\");'>Guardar</a>\n
                <a href='".base_url()."gestion/consultaclientes/' class='button button-secondary'>Salir</a>
             </footer>\n";
                           
        echo form_close();
        
        include("footer_admin.php"); 
?>                                                                         
