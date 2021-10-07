<?php include("header_lg_admin.php"); ?>

               
<fieldset>
<legend>
 <strong>Proveedor SENNI LOGISTICS</strong>
</legend>
<?php

	$this->table->clear();
	$tmpl = array('table_open'  => '<table cellspacing="0" align="center" cellpadding="0" width="80%">' );
	$this->table->set_template($tmpl);

	$celda1 = array('data' => 'RFC: '.br(2)					     ,'class'=>"labelRFC");
	$celda2 = array('data' => $proveedor["datos"][0]['rfc'].br(2),'class'=>"labelRFC2");
	$this->table->add_row(array($celda1,$celda2));
	
	$celda1 = array('data' => 'Nombre: '.br(2)			    			  ,'class'=>"labelRFC");
	$celda2 = array('data' => $proveedor["datos"][0]['nombre'].br(2),'class'=>"labelRFC2");
	$this->table->add_row(array($celda1,$celda2));

	$celda1 = array('data' => 'Domicilio Fiscal: '.br(2)			    ,'class'=>"labelRFC");
	$celda2 = array('data' => $proveedor["datos"][0]['calle'].' #'.
							  $proveedor["datos"][0]['numero'].', col.'.
							  $proveedor["datos"][0]['colonia'].', CP '.
							  $proveedor["datos"][0]['cp']. '<br>Delegaci&oacute;n: '.
							  $proveedor["datos"][0]['delegacion'].' <br>'.
							  $proveedor["datos"][0]['estado'].' '.
							  $proveedor["datos"][0]['pais'].br(2)      ,'class'=>"labelRFC2");
	$this->table->add_row(array($celda1,$celda2));						
	
	$celda1 = array('data' => 'Correo Principal: '.br(2)			,'class'=>"labelRFC");
	$celda2 = array('data' => $proveedor["datos"][0]['correo'].br(2),'class'=>"labelRFC2");
	$this->table->add_row(array($celda1,$celda2));
	
	$celda1 = array('data' => 'Tipo de Servicio: '.br(2)			       ,'class'=>"labelRFC");
	$celda2 = array('data' => $proveedor["datos"][0]['tipo_servicio'].br(2),'class'=>"labelRFC2");
	$this->table->add_row(array($celda1,$celda2));
	
	$celda1 = array('data' => 'Observaciones: '.br(2)			,'class'=>"labelRFC");
	$celda2 = array('data' => $proveedor["datos"][0]['obs'].br(2),'class'=>"labelRFC2");
	$this->table->add_row(array($celda1,$celda2));		
			
	echo $this->table->generate();
	echo br(1);		
	
	$this->table->clear();
	$tmpl=array('table_open'=>'<table cellspacing="0" align="center" id="productos" cellpadding="0" width="80%">');
	$this->table->set_template($tmpl);
	
	$celda = array('data' => 'Datos de Contacto'.br(3),
						   'class'=>"labelCenAzul",'colspan'=>3);
	$this->table->add_row(array($celda));
									
	$this->table->add_row(array(array('data' => 'Nombre Contacto'    ,'class'=>"labelCenSeg"),
								array('data' => 'Tel&eacute;fono'	   ,'class'=>"labelCenSeg"),
								array('data' => 'Correo Electr&oacute;nico','class'=>"labelCenSeg")
								));
	if ($proveedor["contactos"] == FALSE)
		$this->table->add_row(array('data' => '<br>No hay registros','align'=>"center",'colspan'=>3));
	else
		foreach($proveedor["contactos"] as $dc)				
			$this->table->add_row(array($dc["contacto"],
										$dc["telefeno"],
										$dc["correo"]
										));																							
	echo $this->table->generate();
	echo br(3);
?>                                                                         
									   
</fieldset>    
<?php 
		
 	include("footer_admin.php"); 
	
?>  