<?php include("header_lg_admin.php"); ?>
<style>
  .ui-autocomplete-loading { background: white url("http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/images/ui-anim_basic_16x16.gif") right center no-repeat; }
  .ui-autocomplete { max-height: 100px;
                    overflow-y: auto;
                    /* prevent horizontal scrollbar */
                    overflow-x: hidden;
                   }
  
</style>

<script type="text/javascript">

var href            = '<?php echo base_url(); ?>';
var registrosPagina = '<?php echo $registrosPagina; ?>';
var controlador     = '<?php echo $controlador; ?>';
var numColGrid      = '<?php echo $numColGrid; ?>';


$(document).ready(function() {   
	
    paginarRNominasAX(1, registrosPagina, href);
    
    $(".newConcept").addClass("pointer").click(function(){ switch( $(this).attr('id') ) {
                                                            case "per": $("#dialogPer").dialog("open"); break;
                                                            case "ded": $("#dialogDed").dialog("open"); break;
                                                            case "op":  $("#dialogOP" ).dialog("open"); break;
                                                            case "in":  $("#dialogInc").dialog("open"); break;
                                                            }
                                                         });
    $("#dialogPer").dialog({ autoOpen: false, height : 250, width : 750, zIndex : 1011, buttons : { "Agregar" : agregaConceptoRN_per, Cancel : function() { $( this ).dialog( "close" ); } }, show: { effect: "blind", duration: 1000}, hide: { effect: "explode", duration: 1000 } });
    $("#dialogDed").dialog({ autoOpen: false, height : 250, width : 750, zIndex : 1011, buttons : { "Agregar" : agregaConceptoRN_ded, Cancel : function() { $( this ).dialog( "close" ); } }, show: { effect: "blind", duration: 1000}, hide: { effect: "explode", duration: 1000 } });
    $("#dialogOP" ).dialog({ autoOpen: false, height : 250, width : 750, zIndex : 1011, buttons : { "Agregar" : agregaConceptoRN_op, Cancel : function() { $( this ).dialog( "close" ); } }, show: { effect: "blind", duration: 1000}, hide: { effect: "explode", duration: 1000 } });
    $("#dialogInc").dialog({ autoOpen: false, height : 250, width : 750, zIndex : 1011, buttons : { "Agregar" : agregaConceptoRN_in, Cancel : function() { $( this ).dialog( "close" ); } }, show: { effect: "blind", duration: 1000}, hide: { effect: "explode", duration: 1000 } });

    $("#togfiltrosForm").click(function(){ toggFiltrosFac(); });
    $("#togfiltrosForm").addClass("pointer");
    toggFiltrosFac();

    $("#togfiltrosFormRE").click(function(){ toggFiltrosRE(); });
    $("#togfiltrosFormRE").addClass("pointer");
    toggFiltrosRE();

    $("#FechaPago").datepicker({dateFormat: 'dd/mm/yy'});
    $('#FechaPago').datepicker("setDate", new Date() );    
    $("#FechaInicialPago").datepicker({dateFormat: 'dd/mm/yy'});
    $("#FechaFinalPago"  ).datepicker({dateFormat: 'dd/mm/yy'});
    $("#FechaInicioRelLaboral").datepicker({dateFormat: 'dd/mm/yy'});

    $("#fechaini_rec").datepicker({dateFormat: 'dd-mm-yy'});
    $("#fechafin_rec").datepicker({dateFormat: 'dd-mm-yy'});    

    $(".impg").change(function(){ calcularImpGravado(); });	 
	  $(".impe").change(function(){ calcularImpExento();  });
    soloNumeros();

    $( "#modalRNom").dialog({ autoOpen: false, height : 600, width : 1050, modal : true, stack : false, zIndex : 1010,
                              buttons : { "Vista Previa" : function (event) { event.preventDefault();
                                                                             $(this).prop('disabled', true);                                                                             
                                                                             vistaPreviaRecNomAX();
                                                                            },
                                          "Timbrar"      : function (event) { event.preventDefault();
                                                                             $(this).prop('disabled', true);                                                                             
                                                                             timbrarRecNomAX();
                                                                            },
                                          Cancel         : function() { $( this ).dialog( "close" ); }
                                        },
                             close   : function() {  }
                          }); 
  
    $("#tabsTimbrado").tabs();
    
} );
	
</script>   


<?php
    echo $filtrosTbl . br(); 	
    echo '<div class="row">            
            <section id="titFac"   class="col col-5"><center><header id="titReportes">'.$titulos['titulo'].'</header></center></section>
            <section id="iconDown" class="col col-4"></section>
            <section id="facDown"  class="col col-3"></section>
          </div>';
      echo br(2);
      echo '<div class="row">
          <section class="col col-11">';
    
      echo $grid;
      
      echo br(1).'<div id="linksPaginar"></div><span id="spinPaginar"></span>
        </section>
        </div>'.br(1).
        '<div class="row">
          <section class="col col-11">
            <div id="confirmDown" title="'.TITULO_VENTANA.'"> 
                <span id="confirmDownHeader"></span>
                <br><span id="confirmDownContent"></span> 
            </div>';
            
       echo form_input(array('name' => 'baseURL', 'type' => 'hidden', 'id' => 'baseURL', 'value' => base_url() ) ) ;
       echo form_input(array('name' => 'tipoUsr', 'type' => 'hidden', 'id' => 'tipoUsr', 'value' => $this->user['0']['tipo'] ) ) ;

      include("vw_timbrar_rnomina.php");
      echo '</section>
      </div>';
      include("footer_admin.php"); 
?> 