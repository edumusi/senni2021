<?php include("header_lg.php"); ?>
<script>
var hrefCon	= '<?php echo base_url(); ?>';

$(function() 
  { $( document ).tooltip(); });
</script>                            

<p> <img src="<?php echo base_url();?>images/datosContactoAMS_2.jpg" /></p>
<p>&nbsp;</p>                                                                             
<div class="right">
<img src="<?php echo base_url();?>images/correo.png" width="200" height="186"  />
</div>

<div class="contact eleven columns">
<div class="standard-form compressed">
    <h4 class="semi">Formulario de Contacto</h4>
    <span id="mensajeContacto" class="txtTit"></span>
    <form action="gestion/contacto/" class="contactForm" id="contactus" name="contactus">
        <input type="text" class="input validate[custom[onlyLetterNumber]] text-input" id="name" name="name" placeholder="Nombre *" />
        <input type="text" class="input validate[required,custom[email]] text-input" id="email" name="email" placeholder="Correo *" />
        <input type="text" class="input extend validate[custom[onlyLetterNumber]] text-input" id="subject" name="subject" placeholder="T&iacute;tulo *" />
        <textarea name="comment validate[custom[onlyLetterNumber]] text-input" id="comment" rows="10" cols="65" placeholder="Mensaje *" ></textarea>
        <div class="submit">
              <a class="button color" href="javascript:submitFormContactoAX(hrefCon,'contactus');"><span>Enviar</span></a>
        </div>                                    
    </form> <br>  <br>
</div>                          
</div>    

<?php include("footer.php"); ?>            