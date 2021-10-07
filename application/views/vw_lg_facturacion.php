<?php include("header_lg_admin.php"); ?>

<script type="text/javascript">

var href            = '<?php echo base_url(); ?>';
var registrosPagina = '<?php echo $registrosPagina; ?>';
var controlador     = '<?php echo $controlador; ?>';
var numColGrid      = '<?php echo $numColGrid; ?>';


$(document).ready(function() {
    
    $("#fechaIni").datepicker({dateFormat: 'yy-mm-dd'});        
    $("#fechaFin").datepicker({dateFormat: 'yy-mm-dd'});   
    $("input[value=FT]").attr('checked',true);
    $("#titFac"     ).hide();
    $("#grid"       ).hide();
    $("#confirmDown").hide();
    $("#iconDown"   ).html('');
    
    $("#togfiltrosForm").click(function(){ toggFiltrosFac(); });
    $("#togfiltrosForm").addClass("pointer");

    $( "#modalFac").dialog({ autoOpen: false,
                             height  : 600,
                             width   : 950,
                             modal   : true,
                             stack: false,
                             zIndex: 1010,
                             buttons : { "Vista Previa" : function (event) { event.preventDefault();
                                                                             $(this).prop('disabled', true);                                                                             
                                                                             vistaPreviaFacturaAX();
                                                                            },
                                         "Timbrar"      : function (event) { event.preventDefault();
                                                                             $(this).prop('disabled', true);                                                                             
                                                                             salvarAntesTimbrar();
                                                                            },
                                         Cancel         : function() { $( this ).dialog( "close" ); }
                                       },
                             close   : function() {  }
                          });    
    $("#tabsTimbrado").tabs() 
                      .on("click", '[role="tab"]', function() { var tab     = $(this).find("a");
                                                                var botones = $(".ui-dialog-buttonset").children();
                                                                if($(tab).attr('href') == "#tabs-5" || $(tab).attr('href') == "#tabs-6")
                                                                {
                                                                    $(botones).first().hide();
                                                                    $(botones).first().next().hide()                                                                        
                                                                }
                                                                else
                                                                {
                                                                    if( $("#facturaTimbrada").val() == "0" )
                                                                    {
                                                                        $(botones).first().show();
                                                                        $(botones).first().next().show();
                                                                    }
                                                                }
                                                              });
    habilitaValidacionListaNegraAX(href);
                
} );
	
</script>   


<?php
    echo $filtrosTbl . br(); 	
    echo '<div class="row">            
            <section id="titFac"   class="col col-5"><center><header id="titReportes">'.$titulos['titulo'].'</header></center></section>
            <section id="iconDown" class="col col-4"></section>
            <section id="facDown" class="col col-3"></section>
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
            <div id="confirmDown" title="SENNI LOGISTICS"> 
                <span id="confirmDownHeader"></span>
                <br><span id="confirmDownContent"></span> 
            </div>';
            
      echo form_input(array('name' => 'baseURL',     'type' => 'hidden', 'id' => 'baseURL'  ,   'value' => base_url() ))
          .form_input(array('name' => 'id_pedido',   'type' => 'hidden', 'id' => 'id_pedido',   'value' => null ))
          .form_input(array('name' => 'accion',      'type' => 'hidden', 'id' => 'accion'   ,   'value' => "E" ))
          .form_input(array('name' => 'fleteSalvado','type' => 'hidden', 'id' => 'fleteSalvado','value' => 0 ))
          ;

      include("vw_timbrar.php");
      echo '</section>
      </div>';
      include("footer_admin.php"); 
?> 