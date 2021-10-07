<?php include("header_lg_admin.php"); ?>

<!-- Mandar a header -->
<div class="body">            
    <div class="body-wrapper">                
        <div class="content">                	 
            <div class="container">                    	                        
              <div class="sixteen columns" align="right">             	
             	<?php echo $iconuser;echo $usuario;?>                          
              </div>                                                
              <h5 class="semi"> <?php echo $titulos["titulo"];?> </h5>
<!-- Mandar a header -->
                <div class="left">
                       <img src="<?php echo base_url();?>images/admin.png"  width="250"  height="300" />
                </div>
                <?php
                                	echo br(4);                                 									
									$attributes = array('class' => 'contactForm', 'id' => 'login','name' => 'login');
									echo form_open(base_url().'gestion/login/', $attributes);
								?>   Ususario: &nbsp;&nbsp;&nbsp;&nbsp;                            	
                                    <input type="text" class="input" id="usuario" size="10" name="usuario" 
                                    value="<?php echo set_value('usuario'); ?>"  /> 
									<?php echo br(2);?>
                                    Contrase&ntilde;a: 
                                    <input type="text" class="input" id="pwd" size="10" name="pwd" 
                                    value="<?php echo set_value('pwd'); ?>"  />
                                    <div class="errorMsg">
                                    	
                                    <?php 
                                    	echo br(1);
                                    	echo validation_errors();
										echo br(1);
                                    ?>
                                    </div>                                                                        
                                    <div class="submit">
                                          <a class="button color" href="javascript:submitForm('contactus');">
                                          <span>Ingresar</span></a>
                                    </div>                                    
                                    <div class="clear"></div>
                                <?php 
                                	echo form_close();
									echo br(4); 
                                ?>
<!-- Mandar a footer -->                                
                <div class="sixteen columns">                            
                    <blockquote class="standard bottom">
                        <?php echo $titulos["frase"];?>
                    </blockquote>
              </div>
            </div>
        </div>
    </div>
</div>
<!-- Mandar a footer -->              

<?php include("footer_admin.php"); ?>  