<script>    

$(document).ready(function(){
    $("#rfcIVA").combobox();
});//document ready


</script>

 
<?php 
echo form_open(base_url().'gestion/genera/', array('id' => 'formIVA','name' => 'formIVA'));

    echo '<fieldset> 
            <div class="row">
              <section class="col col-4"><label class="label">Cliente:</label>'.
              form_dropdown('rfcIVA',
                             $clientes,
                             "",
                             'id="rfcIVA" class="validate[custom[requiredInFunction]]"').'
             </label>
              </section>
              <section class="col col-2"><label class="label">De:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[required] text-input chartIni', 
                                                            'name'      => 'paramDeIVA', 
                                                            'id'        => 'paramDeIVA',                                                                                             
                                                            'maxlength' => '40')).'                 
                                        <b class="tooltip tooltip-bottom-right">Fecha de Inicio para generar el Reporte</b>
                                        </label>
              </section> 
              <section class="col col-2"><label class="label">Hasta:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[required] text-input chartFin', 
                                                            'name'      => 'paramHastaIVA', 
                                                            'id'        => 'paramHastaIVA',                                                                                             
                                                            'maxlength' => '40')).'
                                        <b class="tooltip tooltip-bottom-right">Fecha Final para generar el Reporte</b>
                                        </label>                                                                
              </section>
              <section class="col col-2"><label class="toggle"><input type="checkbox" name="checkbox-toggle" checked=""><i></i>IVA Venta</label> 
                                      '.br().'<label class="toggle"><input type="checkbox" name="checkbox-toggle" checked=""><i></i>IVA Costo</label> </section>            
              <section class="col col-2">
                <a class=\'button\' href=\'javascript:submitReportExcelAX("'.base_url().'","IVA");\'>Generar reporte</a>                
              </section>
             </div>         
           </fieldset>';
echo form_close();

echo '
     <fieldset> 
       <div class="row">          
         <section class="col col-11">
            <div id="homeReportExcelIVA" ></div>
         </section>
        </div>         
      </fieldset>  
      
     ';

 

?>
