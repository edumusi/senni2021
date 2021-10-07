<?php include("header_lg_admin.php"); ?>


<script>
var hrefC= '<?php echo base_url(); ?>';  

$(document).ready(function(){
    subirPlantilla(hrefC);
    
    $('#mulitplefileuploader').addClass('pointer');
    
    $('.boton_confirm').addClass('pointer');
    $('.boton_confirm').click(function() {
            var r = confirm("¿Borrar plantilla?");
            if (r == true)
                    borrarPlantillaCargadoAX(hrefC,$(this).attr('id'),$(this));
            });
});//document ready


</script>

               
<?php
	echo form_open(base_url().'gestion/plantilla/', array('class' => 'sky-form', 'id' => 'plantilla'));
        echo '<fieldset>'
        . '     <header>'.$titulos["formulario"].'</header><br>';
        
        if ($tipo == "A")
        {
            echo '<fieldset>';			
            $celda = array('data' => '<legend>Subir Plantilla o Documento al Portal</legend>'.br(2),
                                       'align'=>"center",'colspan'=>3);
            $this->table->add_row(array($celda));

           
            $celdaDer = array('data' => 'Plantilla o Documento: ','class'=>"labelDer2");
            $this->table->add_row(array($celdaDer,                                                
                                        '<div id="mulitplefileuploader">Seleccionar Archivo</div>
                                        <div id="status"></div>')
                                  );
            echo $this->table->generate();
            echo '</fieldset>'; 
        }

	echo br(2);
        $this->table->clear();
	$tmpl = array('table_open'  => '<table cellspacing="0" align="center" id="documentos" cellpadding="0" width="50%">' );
	$this->table->set_template($tmpl);
						        
        
        foreach($documentos as $doc)
	{
            if ($tipo == "A")
                $borrarPlantilla ="<img class='boton_confirm' title='Borrar Plantilla' id='".$doc['nombre']."' src='".base_url()."/images/close.png'>".nbs(4);
            else
                $borrarPlantilla = "";
            
            $celda = $borrarPlantilla.'<a title="Material SENNI Logistics" href="'.base_url().$doc['link'].'"> 
			<img title="Material SENNI Logistics" src="'.base_url().'images/fileIcon.png">'.nbs(1).$doc['nombre'].'</a>'.br(2);
            $this->table->add_row($celda);
        }
	echo $this->table->generate();
	echo br(8);
	
	
?>                                                                         
									   
</fieldset>    
<?php 

	echo form_close();
	
 	include("footer_admin.php"); 
	
?>  