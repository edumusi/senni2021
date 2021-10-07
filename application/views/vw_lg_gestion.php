<?php include("header_lg.php"); ?>

<script>
var baseURL = '<?php echo base_url(); ?>';

$(function(){$( document ).tooltip();});

$(document).ready(function(){
    
	$('#recuperarPwd').hide();	
        $("#leyendaPWD").html("");
        $("#email").val('');
       
});//document ready
  
</script>

<?php   
    echo '<div class="body-s">';    
    echo form_open(base_url().'gestion/login/', array('class' => 'sky-form', 'id' => 'login','name' => 'login'));
    echo '<header></header>';
    echo form_fieldset();
        echo "<section>\n
                 <div class='row'>\n";        
        echo      form_label('Usuario','',array('class' => 'label col col-4'));
        echo "          <div class='col col-8'>\n";
        echo "               <label class='input'>\n                                    
                                    <i class='icon-append fa fa-user'></i>\n";    
        echo                        form_input(array('type' => 'email', 'name'=>'usuario','id'=>'usuario','class'=>'validate[required,custom[email]] text-input','value'=>set_value('usuario')));
        echo "                      <b class='tooltip tooltip-top-right'>Ingrese su correo electronico corporativo</b>
                             </label>
                       </div>\n
                 </div>\n
              </section>\n";

        echo "<section>\n
                 <div class='row'>\n";        
        echo     form_label('Contraseña','', array('class' => 'label col col-4'));
        echo "          <div class='col col-8'>\n";
        echo "               <label class='input'>\n
                                    <i class='icon-append fa fa-lock'></i>\n";                                        
        echo                        form_input(array('type' => 'password', 'name'=>'pwd', 'id'=>'pwd','class'=>'validate[custom[onlyLetterNumber]] text-input','value'=>set_value('pwd')));
        echo "               </label>
                            <div class='note'><a href='#sky-form2' class='modal-opener'>&iquest;Olvid&oacute; su contrase&ntilde;a?</a></div>
                            <div class='errorMsg' style='color:red;'></br>\n"; 
        echo                validation_errors().
                            $sesion;
        echo "               </div></br>
                       </div>\n
                 </div>\n
              </section>\n";    
    echo form_fieldset_close();
    
    echo "<footer>\n
            <a class='button' href='javascript:submitForm(\"login\");'>Ingresar</a>\n
         </footer>\n";
                           
    echo form_close();
    echo '</div>';
        
    echo form_open(base_url().'gestion/login/', array('class' => 'sky-form sky-form-modal', 'id' => 'sky-form2','name' => 'formPwd'));    
    echo '<header>Recuperar Contraseña</header>';
    echo form_fieldset();
        echo "<section>\n";        
        echo form_label('Correo Electr&oacute;nico','',array('class' => 'label'));       
        echo "               <label class='input'>\n
                                    <i class='icon-append fa fa-envelope-o'></i>\n";                                        
                                    echo form_input(array('type' => 'email', 'name'=>'email','id'=>'email','class'=>'validate[required,custom[email]] text-input'));
        echo "               </label>".br(1);
        echo form_label('','',array('id' => 'leyendaPWD')).br(1);
        echo "   </section>\n";
    echo form_fieldset_close();    
    echo "<footer>\n                
                <a class='button' href='javascript:recuperarPwdAX(baseURL,\"sky-form2\");'>Recuperar</a>\n
                <a href='#' class='button button-secondary modal-closer'>Cerrar</a>
         </footer>\n";
    
    echo "<div class='message'>\n
                <i class='fa fa-check'></i>\n
                <p>La contrasena ha sido enviada!<br><a href='#' class='modal-closer'>Cerrar</a></p>\n
         </div>\n";

    echo form_close();
    
    include("footer_admin.php"); 
?>  
