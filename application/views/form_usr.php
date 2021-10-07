<?php include("header_lg_admin.php"); ?>


<script>
var hrefC= '<?php echo base_url(); ?>';

  $(function(){$( document ).tooltip();});
  
  $(document).ready(function(){	  
	  
	  $("#correo").change(function(){validaCampoDuplicadoAX("usuarios","correo",$(this).val(),hrefC)});	  
	  subirFirma(hrefC);
          
           $('.boton_confirm').addClass('pointer');	
            $('.boton_confirm').click(function() {
                    var r = confirm("¿Borrar Firma digitalizada?");
                    if (r === true)
                            borraFirmaCargadaAX(hrefC,$(this).attr('id'),$(this));
                    });
	  });

</script>

               
<?php
	echo form_open(base_url().'usuario/guardar/', array('class' => 'sky-form', 'id' => 'usuario'));
        echo '<header>'.$headerLG.'</header>';  

        echo ' <fieldset>
                <div class="row">          
                 <section class="col col-6"> 
                    <label class="label">Nombre</label>
                    <label class="input"><i class="icon-append fa fa-user"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'nombre', 
                                     'id'          => 'nombre',
                                     'placeholder' => "Ej. Juan",
                                     'value'       => $usr[0]['nombre'],                                     
                                     'maxlength'   => '14')).'
                     <b class="tooltip tooltip-bottom-right">Nombre del nuevo integrante.</b>
                    </label>
                    </section>
                    <section class="col col-6">
                    <label class="label">Apellidos</label>
                    <label class="input"><i class="icon-append fa fa-user"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'apellidos', 
                                     'id'          => 'apellidos',
                                     'placeholder' => "Ej. Perez Perez",
                                     'value'       => $usr[0]['apellidos'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Apellidos del nuevo integrante</b>
                    </label>
                    </section>
                </div>
                <div class="row">          
                 <section class="col col-4"> 
                    <label class="label">Puesto</label>
                    <label class="input"><i class="icon-append fa fa-suitcase"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'puesto', 
                                     'id'          => 'puesto',
                                     'placeholder' => "Ej. Ventas",
                                     'value'       => $usr[0]['puesto'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Puesto del nuevo integrante.</b>
                    </label>
                    </section>
                    <section class="col col-4">
                    <label class="label">Titulo</label>
                    <label class="input"><i class="icon-append fa fa-suitcase"></i>'.
                    form_input(array('class'     => 'validate[required,custom[onlyLetterNumber]] text-input', 
                                     'name'        => 'titulo', 
                                     'id'          => 'titulo',
                                     'placeholder' => "Ej. Lic",
                                     'value'       => $usr[0]['titulo'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Apellidos del nuevo integrante</b>
                    </label>
                    </section>
                    <section class="col col-4">
                     <label class="label">Perfil</label>
                      <label class="select">'.                    
                        form_dropdown('tipo', array("0"=>"Elegir","V"=>"Vendedor","A"=>"Administrador"),$usr[0]['tipo'], 'id="tipo" class="validate[custom[requiredInFunction]]" ').'
                      <i></i>                             
                      </label> 
                    </section>
                </div>
                <div class="row">          
                  <section class="col col-4">
                    <label class="label">Cuenta de Correo</label>
                    <label class="input"><i class="icon-append fa fa-envelope-o"></i>'.
                    form_input(array('class'     => 'validate[required,custom[email]] text-input', 
                                     'name'        => 'correo', 
                                     'id'          => 'correo',
                                     'placeholder' => "Ej. e@senni.com.mx",
                                     'value'       => $usr[0]['correo'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Cuenta de correo electrónico del nuevo integrante</b>
                    </label>
                    </section>
                    <section class="col col-4">
                    <label class="label">Teléfono</label>
                    <label class="input"><i class="icon-append fa fa-phone"></i>'.
                    form_input(array('class'     => 'validate[required] text-input', 
                                     'name'        => 'telefono', 
                                     'id'          => 'telefono',
                                     'placeholder' => "Ej. 515151",
                                     'value'       => $usr[0]['telefono'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Numero telefonico asignado para el nuevo integrante</b>
                    </label>
                    </section>
                     <section class="col col-4">
                    <label class="label">Celular</label>
                    <label class="input"><i class="icon-append fa fa-mobile"></i>'.
                    form_input(array('class'     => 'validate[required] text-input', 
                                     'name'        => 'celular', 
                                     'id'          => 'celular',
                                     'placeholder' => "Ej. 5545115454",
                                     'value'       => $usr[0]['celular'],                                     
                                     'maxlength'   => '100')).'
                     <b class="tooltip tooltip-bottom-right">Numero celular asignado para el nuevo integrante</b>
                    </label>
                    </section>
                </div>
                <div class="row">  
                <section class="col col-4">
                        <label class="label">Contraseña</label>
                        <label class="input">
                            <i class="icon-append fa fa-lock"></i>'.
                            form_input(array('type'        => 'password',
                                             'class'       => 'validate[required,custom[onlyLetterNumber],minSize[4]] ] text-input', 
                                             'name'        => 'pwd', 
                                             'id'          => 'pwd',
                                             'type'      => 'password',
                                             'placeholder' => "Ej. Password",
                                             'value'       => $usr[0]['pwd'],						 
                                             'maxlength'   => '100')).'                                                                      
                            <b class="tooltip tooltip-bottom-right">Contraseña para ingresar el portal</b>
                        </label>
                </section>
                <section class="col col-4">
                <label class="label">Adjuntar Firma</label>
                <div id="mulitplefileuploaderFirma">Seleccionar Firma Digitalizada</div><div id="statusFirma"></div>';
                echo form_input(array('name'=> 'firmaNueva','type'  => 'hidden','id'    => 'firmaNueva','value' => 'null.png'));
                echo form_input(array('name'=> 'accion'    ,'type'  => 'hidden','id'    => 'accion','value' => $accion));
                echo form_input(array('name'=> 'correo_ant','type'  => 'hidden','id'    => 'correo_ant','value' => $usr[0]['correo']));
                $firma = $usr[0]['firma']==NULL || $usr[0]['firma']==""?"null.png":$usr[0]['firma'];
	echo   "</section>
                <section class='col col-4'>
                <div id='Firma'><img title='Firma Digitalizada' width='142' height='172' src='".base_url().$dirFoto.$firma."'></a><br><img class='boton_confirm' title='Borrar Firma' name='".$firma."'  id='".$firma."' src='".base_url()."/images/close.png'></div>
                </section>
                </div>";
        echo '<div class="row">
                <section class="col col-4">
                  <label class="label">RFC</label>
                  <label class="input"><i class="icon-append fa fa-user"></i>'.
                  form_input(array('class'     => 'text-input', 
                                   'name'        => 'RFC', 
                                   'id'          => 'RFC',
                                   'placeholder' => "Ej. XXXX12ZZZZ",
                                   'value'       => $usr[0]['RFC'],
                                   'maxlength'   => '30')).'
                   <b class="tooltip tooltip-bottom-right">Registro Federal del Contribuyente del nuevo integrante</b>
                  </label>
                  </section>
                  <section class="col col-4">
                  <label class="label">CURP</label>
                  <label class="input"><i class="icon-append fa fa-user"></i>'.
                  form_input(array('class'     => 'text-input', 
                                   'name'        => 'Curp', 
                                   'id'          => 'Curp',
                                   'placeholder' => "Ej. XXXX",
                                   'value'       => $usr[0]['Curp'],                                     
                                   'maxlength'   => '100')).'
                   <b class="tooltip tooltip-bottom-right">CURP para el nuevo integrante</b>
                  </label>
                  </section>
                   <section class="col col-4">
                  <label class="label">Número de Seguridad Social </label>
                  <label class="input"><i class="icon-append fa fa-user"></i>'.
                  form_input(array('class'     => 'text-input', 
                                   'name'        => 'NumSeguridadSocial', 
                                   'id'          => 'NumSeguridadSocial',
                                   'placeholder' => "Ej. 1223",
                                   'value'       => $usr[0]['NumSeguridadSocial'],                                     
                                   'maxlength'   => '100')).'
                   <b class="tooltip tooltip-bottom-right">Numero de Seguridad Social del nuevo integrante</b>
                  </label>
                  </section>
              </div>';                
        echo    "</fieldset>
                <footer>\n
                    <a class='button' href='javascript:submitForm(\"usuario\");'>Guardar</a>\n
                    <a href='".base_url()."usuario/' class='button button-secondary'>Salir</a>
                 </footer>\n";

        echo form_close();    
	
 	include("footer_admin.php"); 
	
?>  