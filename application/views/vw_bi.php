<?php include("header_lg_admin.php"); ?>
<script>    
    var baseURL    = '<?php echo base_url(); ?>';

$(document).ready(function(){
    
 $("input[name='sky-tabs-3']").click(function (){ cargaChartAX(baseURL,$(this).val()); });

 $(".chartIni").datepicker({onSelect: function(){ var eta = new Date($(this).datepicker("getDate"));         
                                                  eta.setDate(eta.getDate() + 1); 
                                                  $(".chartFin").datepicker("option" , "minDate", eta );
                                                  $(".chartFin").datepicker("setDate", eta );
                                                },dateFormat: 'dd/mm/yy'});
 $(".chartFin").datepicker({dateFormat: 'dd/mm/yy'});	
 
    
});//document ready
</script>
<?php
 echo '<div class="sky-form">';
        echo '<!-- tabs -->
			<div class="sky-tabs sky-tabs-pos-top-center sky-tabs-anim-flip sky-tabs-response-to-icons">';
echo '      <input type="radio" name="sky-tabs-3" value="EC" id="sky-tab1-1" class="sky-tab-content-1">
      <label for="sky-tab1-1"><span><span><i class="fa fa-file-excel-o"></i>Estado de Cuenta</span></span></label>
      
      <input type="radio" name="sky-tabs-3" value="PO" id="sky-tab1-2" class="sky-tab-content-2">
      <label for="sky-tab1-2"><span><span><i class="fa fa-file-excel-o"></i>País de Origen</span></span></label>
      
      <input type="radio" name="sky-tabs-3" value="IV" id="sky-tab1-3" class="sky-tab-content-3">
      <label for="sky-tab1-3"><span><span><i class="fa fa-file-excel-o"></i>Por IVA</span></span></label>
';
if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
{   
echo '<input type="radio" name="sky-tabs-3" value="SE" id="sky-tab1-4" class="sky-tab-content-4">
  <label for="sky-tab1-4"><span><span><i class="fa fa-cubes"></i>Por Servicios</span></span></label>
  
  <input type="radio" name="sky-tabs-3" value="CL" id="sky-tab1-5" class="sky-tab-content-5">
  <label for="sky-tab1-5"><span><span><i class="fa fa-users"></i>Por Participación</span></span></label>
  
  <input type="radio" name="sky-tabs-3" value="CT" id="sky-tab1-6" class="sky-tab-content-6">
  <label for="sky-tab1-6"><span><span><i class="fa fa-tasks"></i>Por Status</span></span></label>
  
  <input type="radio" name="sky-tabs-3" value="VD" id="sky-tab1-7" class="sky-tab-content-7">
  <label for="sky-tab1-7"><span><span><i class="fa fa-male"></i>Por Comisiones</span></span></label>
    ';                
}                                                               
echo '  <ul> 
          <li class="sky-tab-content-1">';
              include("vw_report_EDOCTA.php");
echo '		</li>
          <li class="sky-tab-content-2">';
              include("vw_report_ORIGEN.php");
echo '		</li>					
          <li class="sky-tab-content-3">'; 
              include("vw_report_IVA.php");
echo '		</li>';
if ( $this->user['0']['tipo'] == PERFIL_ADMIN)        
{   
echo '		<li class="sky-tab-content-4">';
              include("vw_bi_partI.php");
echo '		</li>
  <li class="sky-tab-content-5">';
              include("vw_bi_partII.php");
echo '		</li>					
  <li class="sky-tab-content-6">';
              include("vw_bi_partIII.php");
echo '		</li>
  <li class="sky-tab-content-7">';
              include("vw_bi_partIV.php");
echo '		</li>';
echo '    </ul>';                   
}            
    echo '   </div>
            <!--/ tabs -->';    
    echo "<div id='homeChart' class='row'><section class='col col-4'>&nbsp;</section><section class='col col-4'>";	
    echo img(array('src'   => 'img/introduccion.jpg','width'=>"300",'heigth'=>"300"), TRUE); 
    echo "</section><section class='col col-3'>&nbsp;</section></div>";
    echo "<footer>".
           "<a class='button button-secondary' href='".base_url()."expediente/'>Salir</a>".
         "</footer>";
    echo '</div>';
     include("footer_admin.php");   
?>                             