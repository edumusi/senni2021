
<?php 

echo form_open(base_url().'gestion/genera/', array('id' => 'formCT','name' => 'formCT'));

    echo '<fieldset> 
            <div class="row">          
              <section class="col col-3"><label class="label">De:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[custom[date]] text-input chartIni', 
                                                            'name'      => 'paramDeCT', 
                                                            'id'        => 'paramDeCT',                                                                                             
                                                            'maxlength' => '40')).'                 
                                        <b class="tooltip tooltip-bottom-right">Fecha de Inicio para generar el Reporte</b>
                                        </label>
              </section>
              <section class="col col-3"><label class="label">Hasta:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[custom[date]] text-input chartFin', 
                                                            'name'      => 'paramHastaCT', 
                                                            'id'        => 'paramHastaCT',                                                                                             
                                                            'maxlength' => '40')).'
                                        <b class="tooltip tooltip-bottom-right">Fecha Final para generar el Reporte</b>
                                        </label>                                                                
              </section>
              <section class="col col-3">       
              <label class="label"></label>                         
                             ';
                            echo   '<label class="radio">'.form_radio(array("name"=>"typeParamCT","id"=>"typeParamCT","value"=>"pedido" , "checked"=>"checked")).'<i></i>Servicio</label>'.
                                   '<label class="radio">'.form_radio(array("name"=>"typeParamCT","id"=>"typeParamCT","value"=>"es"                   )).'<i></i>Encuestas Satisfacción</label>'.
                          ' <i></i> 
                            </label>   
              </section>  
              <section class="col col-3">
                <a class=\'button\' href=\'javascript:submitChartAX("'.base_url().'","CT");\'>Generar reporte</a>                
              </section
             </div>         
           </fieldset>';
echo form_close();

echo '           
     <fieldset> 
       <div class="row">          
         <section class="col col-11">
            <div id="containerIII" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>                         
         </section>
        </div>         
      </fieldset>      
     ';

?>
