<?php include("header_portal.php"); ?>

<script> 
    var hrefCon	= '<?php echo base_url(); ?>';
</script>

<div class="bg-image page-title">
				<div class="container-fluid">
					<a href="<?php echo base_url();?>welcome/contacto/"><h1>Contacto</h1></a>
					<div class="pull-right">
						<a href="<?php echo base_url();?>welcome/contacto/"><i class="fa fa-home fa-lg"></i></a> &nbsp;&nbsp;|&nbsp;&nbsp; <a>Contacto</a>
					</div>
				</div>
			</div>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3763.9285559539476!2d-99.17775718565811!3d19.372245947628993!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1ff90825bf401%3A0x694ff6aab6080835!2sSan+Francisco+1626%2C+Col+del+Valle+Sur%2C+03100+Ciudad+de+M%C3%A9xico%2C+CDMX!5e0!3m2!1ses-419!2smx!4v1480694086879" width="600" height="450" frameborder="0" style="border:0; pointer-events: none;" allowfullscreen class="we-onmap wow fadeInUp"></iframe>

			<div class="container-fluid block-content">
				<div class="row main-grid">
					<div class="col-sm-4">
						<h4>Gerencia de Ventas</h4>
						<div class="adress-details wow fadeInLeft" data-wow-delay="0.3s">
							<div>
								<span><i class="fa fa-envelope"></i></span>
								<div>ventas@senni.com.mx</div>
							</div>
							<div>
								<span><i class="fa fa-globe"></i></span>
								<div>www.senni.com.mx</div>
							</div>
						</div>
					</div>
					<div class="col-sm-8 wow fadeInRight" data-wow-delay="0.3s">
						<h4>Formulario de Contacto</h4>
                        <form action="gestion/contacto/" class="contactForm" id="contactus" name="contactus">
							<div class="row form-elem">	
								<div class="col-sm-12 form-elem">
									<div class="default-inp form-elem ">
										<i class="fa fa-user"></i>                              
                                        
                                        <input type="text" class="input validate[required,custom[onlyLetterNumber]] text-input" id="nombre" name="nombre" placeholder="Nombre *" />
									</div>
									<div class="default-inp form-elem">
										<i class="fa fa-envelope"></i>										
                                                                                <input type="text" class="input validate[required,custom[email]] text-input" id="email" name="email" placeholder="Correo *" />
									</div>
								</div>
							</div>
							<div class="default-inp form-elem">                                
                                <input type="text" class="input validate[custom[onlyLetterNumber]] text-input" id="tel" name="tel" placeholder="Teléfono *" />
							</div>
							<div class="form-elem default-inp">                                
                                <textarea class="input validate[custom[onlyLetterNumber]] text-input" name="comment" id="comment" rows="10" cols="65" placeholder="Mensaje *" ></textarea>
							</div>
                            
							<div class="form-elem">                                
                                <a class="btn btn-success btn-default" href="javascript:submitFormContactoAX(hrefCon,'contactus');"><span>Enviar</span></a>
                                <h4><b style="color:#15BC57;" id="mensajeContacto"></b></h4>
							</div>
						</form>
					</div>
				</div>
			</div>
	
<?php include("footer_portal.php"); ?>
