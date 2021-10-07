<?php include("header_lg.php"); ?>

<script>
var baseURL	   = '<?php echo base_url(); ?>';

$(function(){$( document ).tooltip();});
  
</script>

<?php
 if($encuesta == TRUE)
 {
?>	 
<div class="left">
       <img src="<?php echo base_url();?>images/admin.png"  width="250"  height="300" />
</div>
<div class="cuadroSombraRetro">
<?php  	 
		$attributes = array('class' => 'contactForm', 'id' => 'login','name' => 'login');
		echo form_open(base_url().'retro/guardar/', $attributes);
		
		$this->table->clear();
		$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="100%">');
		$this->table->set_template($tmpl);
		$tooltipvar = '<img title="Por favor seleccione un opcion para calificar el servicio proporcionado" 
						 src="'.base_url().'images/pregunta.png"/>';
		$nombreCalif = array('name'=>'calif', 'id'=>'calif','class'=>'pointer');
		$celda 		=  form_radio($nombreCalif,5).'Excelente'.
					   form_radio($nombreCalif,4).'Bueno'.
					   form_radio($nombreCalif,3).'Regular'.
					   form_radio($nombreCalif,2).'Malo'.
					   form_radio($nombreCalif,1).'P&eacute;simo'.
					   $tooltipvar;
		$celdaDer 	= array('data'=>'&iquest;C&oacute;mo califica el servicio<br>proporcionado?:'.br(2),
							'class'=>"labelDer");
		$this->table->add_row(array($celdaDer,$celda));
		
		$attributes = array('class' 	 => 'validate[custom[onlyLetterNumber]] text-input', 
							 'name' 	 => 'comen', 
							 'id' 		 => 'comen',
							 'value'     => '',
							 'rows'      => '5',
							 'cols'      => '10',
							 'style'     => 'width:50%',
							 'maxlength' => '150');			
		$tooltipvar = '<img title="Por favor ind&iacute;quenos si tiene alg&uacute;n comentario, a considerar,
								   acerca del servicio proporcionado" 
						 src="'.base_url().'images/pregunta.png"/>';			
		$celda 		=  form_textarea($attributes).$tooltipvar.br(2);
		$celdaDer 	= array('data' => 'Comentarios: ','class'=>"labelDer");
		$this->table->add_row(array($celdaDer,$celda));
		
		$attributes = array('class' 	 => 'validate[custom[onlyLetterNumber]] text-input', 
							 'name' 	 => 'sugerencia', 
							 'id' 		 => 'sugerencia',
							 'value'     => '',
							 'rows'      => '5',
							 'cols'      => '10',
							 'style'     => 'width:50%',
							 'maxlength' => '150');			
		$tooltipvar = '<img title="Por favor, podr&iacute;a indicarnos en qu&eacute; podemos mejorar para lograr su 
								   entera satisfaci&oacute;n" 
						 src="'.base_url().'images/pregunta.png"/>';			
		$celda 	  	= array('data' =>  form_textarea($attributes).$tooltipvar,'class'=>"verticalMiddel");
		$celdaDer 	= array('data' => 'Sugerencias: ','class'=>"labelDer");
		$this->table->add_row(array($celdaDer,$celda));
		$this->table->add_row(array(form_input(array('name'  => 'id_pedido', 
													  'type'  => 'hidden', 
													  'id'    => 'id_pedido',
													  'value' => $id_pedido)),''));
		
	
		echo br(1);
		echo $this->table->generate(); 
		echo br(1);
	?>                                                                  
		<div class="submit">
			  <a class="button color" href="javascript:submitForm('login');">
			  <span>Enviar Respuesta</span></a>
		</div>  <br> <br> <br>                                   
	<?php 
		echo form_close();
		echo br(4); 
 }
 else
 {
s?>	 
<div class="cuadroSombraRetro">
<?php  
	$this->table->clear();
	$tmpl = array('table_open'  => '<table cellspacing="0" cellpadding="0" width="100%">');
	$this->table->set_template($tmpl);
	$celda 	= array('data' => '&iexcl;Muchas Gracias por su tiempo!'.br(2).
							  '<img src="'.base_url().'images/gracias.jpg"/>','class'=>"labelCenTit");
	$this->table->add_row(array($celda));

	echo br(2);
	echo $this->table->generate(); 
	echo br(1);
 }
	?>
</div>
  

<?php include("footer_admin.php"); ?>  