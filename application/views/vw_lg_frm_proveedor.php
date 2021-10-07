<?php include("header_lg_admin.php"); ?>


<script>
var href= '<?php echo base_url(); ?>';

  $(function(){$( document ).tooltip();});
  
  $(document).ready(function(){	  
	  $("#rfc").change(function(){validaCampoDuplicadoAX("proveedor","rfc",$(this).val(),href)});
	  $("#nombre").change(function(){validaCampoDuplicadoAX("proveedor","nombre",$(this).val(),href)});
	  $("#correo").change(function(){validaCampoDuplicadoAX("proveedor","correo",$(this).val(),href)});
	  $('.btnDelete').addClass('pointer');
	  $(".btnDelete").bind("click", Delete);
	  });

</script>

               
<?php
	echo form_open(base_url().'proveedor/guardar/',  array('class' => 'sky-form', 'id' => 'provee'));
        echo '<header>Nuevo Proveedor</header>';  

        echo ' <fieldset>
                <div class="row">          
                 <section class="col col-6"> 
                    <label class="label">RFC</label>
                    <label class="input"><i class="icon-append fa fa-male"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'rfc', 
                                     'id'          => 'rfc',
                                     'placeholder' => "Ej. ABCDEF12345678",
                                     'value'       => $proveedor['datos'][0]['rfc'],                                     
                                     'maxlength'   => '14')).'
                     <b class="tooltip tooltip-bottom-right">Registro Federal de Contribuyentes. Personas morales debe contener 12 caracteres y 13 caracteres para las personas f&iacute;sicas</b>
                    </label><span id= "validarfc"></span>
                    </section>
                    <section class="col col-6">
                    <label class="label">Nombre de Proveedor</label>
                    <label class="input"><i class="icon-append fa fa-male"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'nombre', 
                                     'id'          => 'nombre',
                                     'placeholder' => "Ej. Senni Logistics SA. de CV.",
                                     'value'       => $proveedor['datos'][0]['nombre'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Raz&oacute;n social o nombre del proveedor hasta 100 caracteres</b>
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
                                     'value'       => $proveedor['datos'][0]['calle'],                                     
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
                                     'value'       => $proveedor['datos'][0]['numero'],                                     
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
                                     'value'       => $proveedor['datos'][0]['colonia'],                                     
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
                                     'value'       => $proveedor['datos'][0]['delegacion'],                                     
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
                                     'value'       => $proveedor['datos'][0]['estado'],                                     
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
                                     'value'       => $proveedor['datos'][0]['pais'],                                     
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
                                     'value'       => $proveedor['datos'][0]['cp'],                                     
                                     'maxlength'   => '5')).'
                     <b class="tooltip tooltip-bottom-right">C&oacute;digo Postal del domicilio fiscal</b>
                    </label><span id= "validarfc"></span>
                    </section>
                   </div>
                    </fieldset>
            <fieldset>
                <div class="row">                           
                 <section class="col col-6"> 
                    <label class="label">Correo Principal</label>
                    <label class="input"><i class="icon-append fa fa-envelope-o"></i>'.
                    form_input(array('class'     => 'validate[required,custom[email]] text-input', 
                                     'name'        => 'correo', 
                                     'id'          => 'correo',
                                     'placeholder' => "test@test.com",
                                     'value'       => $proveedor['datos'][0]['correo'],                                     
                                     'maxlength'   => '50')).'
                     <b class="tooltip tooltip-bottom-right">Correo de contacto principal</b>
                    </label><span id= "validacorreo"></span>
                    </section>
                    <section class="col col-6"><label class="label">Tipo de servicio ofrecido por el proveedor:</label>
                                            <label class="select"><i class="icon-append"></i>'.
                                             form_dropdown('tipo_servicio', $tipos_servicio, $proveedor["datos"][0]['id_tipo_servicio'],'id="tipo_servicio" class="validate[custom[requiredInFunction]]" ').'
                                            </label>
                    </section>
                </div>
                <div class="row">                           
                 <section class="col col-6">  <label class="label">Observaciones</label>'.
                                                form_textarea(array('class' => 'validate[custom[onlyLetterNumber]] text-input', 
                                                                    'name'  => 'obs', 
                                                                    'id'    => 'obs',                                     
                                                                    'value' => $proveedor['datos'][0]['obs'],
                                                                    'rows'      => '3',
                                                                    'maxlength' => '150'
                                                                   )).'
                  </section>
                  <section class="col col-6"> &nbsp;</section>
                </div>
                </fieldset>
                <fieldset>
                <div class="row">          
                 <section class="col col-11">';	
                    $tmpl = array('table_open'  => '<table cellspacing="0" id="contactos" cellpadding="0" width="100%">' );
                    $this->table->set_template($tmpl);
                   
                    $ttvar_ag = '<a href="javascript:addRowDC(href)"><img title="Agregar Datos de Contacto" src="'.base_url().'images/new.png"/> </a>';
                    $this->table->add_row(array('&nbsp;'));
                    $this->table->add_row(array('<legend>Datos de Contacto</legend>'));
                    $this->table->add_row(array('&nbsp;'));
                    $this->table->add_row(array('Nombre Contacto ','Tel&eacute;fono','Correo',''));

                    if ($proveedor["contactos"] == FALSE)
                        {$this->table->add_row(array('<section class="col col-11">                                                        
                                                        <label class="input"><i class="icon-append fa fa-user"></i>'.
                                                        form_input(array('class'       => 'validate[custom[onlyLetterNumber]] text-input', 
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
                                                                         'maxlength'   => '20')).'
                                                         <b class="tooltip tooltip-bottom-right">Correo de contacto alternativo</b>
                                                        </label>
                                                        </section>',
                                                     $ttvar_ag.
                                                     form_input(array('name' => 'num_dc', 'type'=>'hidden', 'id' =>'num_dc','value' =>'0'))));}
                    else
                    {
                            $x = -1;
                            foreach($proveedor["contactos"] as $dc)
                            {
                                    $x = $x+1;                                    		
                                    if($x == 0)
                                        { $ttvar_ag = '<a href="javascript:addRowDC(href)"><img title="Agregar Datos de Contacto" src="'.base_url().'images/new.png"/> </a>'; }
                                    else
                                        { $ttvar_ag = '<img title="Eliminar Datos del Cliente" class="btnDelete" src="'.base_url().'images/erase.png">'; }
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
                                                                         'maxlength'   => '20')).'
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
                echo form_input(array('name'  => 'accion'  ,'type' => 'hidden','id' => 'accion'  ,'value' => $accion));
                echo form_input(array('name'  => 'id_prove','type' => 'hidden','id' => 'id_prove','value' => $id_prove));
                echo "</section>
                           </div>
                           </fieldset>
                           <footer>\n
                               <a class='button' href='javascript:submitForm(\"provee\");'>Guardar</a>\n
                               <a href='".base_url()."proveedor/' class='button button-secondary'>Salir</a>
                            </footer>\n";

            echo form_close();
        
        include("footer_admin.php"); 
	
?>  