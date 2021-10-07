<script>    

$(document).ready(function(){
  $("#rfcEDOCTA").combobox();                 
});//document ready


</script>


<?php 
echo form_open(base_url().'gestion/genera/', array('id' => 'formEDOCTA','name' => 'formEDOCTA'));

    echo '<fieldset>             
            <div class="row">          
            <section class="col col-4"><label class="label">Cliente:</label>'.
            form_dropdown('rfcEDOCTA',
                           $clientes,
                           "",
                           'id="rfcEDOCTA" class="validate[custom[requiredInFunction]]"').'
           </label>
           </section>            
           <section class="col col-2"><label class="label">De:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[required] text-input chartIni', 
                                                            'name'      => 'paramDeEDOCTA', 
                                                            'id'        => 'paramDeEDOCTA',                                                                                             
                                                            'maxlength' => '40')).'                 
                                        <b class="tooltip tooltip-bottom-right">Fecha de Inicio para generar el Reporte</b>
                                        </label>
              </section>
              <section class="col col-2"><label class="label">Hasta:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[required] text-input chartFin', 
                                                            'name'      => 'paramHastaEDOCTA', 
                                                            'id'        => 'paramHastaEDOCTA',                                                                                             
                                                            'maxlength' => '40')).'
                                        <b class="tooltip tooltip-bottom-right">Fecha Final para generar el Reporte</b>
                                        </label>                                                                
              </section>
              <section class="col col-3">
                <a class=\'button\' href=\'javascript:submitReportExcelAX("'.base_url().'","EDOCTA");\'>Generar reporte</a>                
              </section>
             </div>         
           </fieldset>';
echo form_close();

echo '
     <fieldset> 
       <div class="row">          
         <section class="col col-11">
            <div id="homeReportExcelEDOCTA" ></div>
         </section>
        </div>         
      </fieldset>  
      
     ';

 

?>
