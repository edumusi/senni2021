<?php include("header_lg_admin.php"); ?>

<script type="text/javascript">

var href            = '<?php echo base_url(); ?>';
var registrosPagina = '<?php echo $registrosPagina; ?>';
var controlador     = '<?php echo $controlador; ?>';
var numColGrid      = '<?php echo $numColGrid; ?>';


$(document).ready(function() {   
	
        paginarAX(controlador,numColGrid,1,registrosPagina,href);
        
        $("#fechaIni").datepicker({dateFormat: 'yy-mm-dd'});        
        $("#fechaFin").datepicker({dateFormat: 'yy-mm-dd'});                        				
                
        $('.showHideForm').addClass('pointer');
	$('.showHideForm').click(function() {
		$('#filtrosCoti').hide();
		});
                
        if(controlador=="pedido")
            {$("#filtros2").remove("<tbody>");}             
	
} );

	
</script>   


<?php
        echo $filtrosTbl;        
	echo '<div class="row">';
         echo '<section class="col col-6">
            <label class="subtitulo">
                <a href="'.base_url().$controlador.'/'.$accion.'/">
                <img title="Agregar nuevo '.$tipo.' " src="'.base_url().'images/new.png"/> <img title="Agregar un nuevo '.$tipo.' al sistema" src="'.base_url().'images/portafolio.png"/>'.nbs(1).'Agregar un nuevo '.$tipo.'</a>
                '.$mensajeConfirm.'
            </label>
         </section> 
          </div>';
         echo br(2);
        echo '<div class="row">
              <section class="col col-11">';
        echo $grid;
	       
       echo br(1).'<div id="linksPaginar"></div><span id="spinPaginar"></span>
           </section>
            </div>';
        
        include("footer_admin.php"); 
?> 