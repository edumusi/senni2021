
<?php 

echo form_open(base_url().'gestion/genera/', array('id' => 'formCL','name' => 'formCL'));

    echo '<fieldset> 
            <div class="row">          
              <section class="col col-2"><label class="label">De:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[custom[date]] text-input chartIni', 
                                                            'name'      => 'paramDeCL', 
                                                            'id'        => 'paramDeCL',                                                                                             
                                                            'maxlength' => '40')).'                 
                                        <b class="tooltip tooltip-bottom-right">Fecha de Inicio para generar el Reporte</b>
                                        </label>
              </section>
              <section class="col col-2"><label class="label">Hasta:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[custom[date]] text-input chartFin', 
                                                            'name'      => 'paramHastaCL', 
                                                            'id'        => 'paramHastaCL',                                                                                             
                                                            'maxlength' => '40')).'
                                        <b class="tooltip tooltip-bottom-right">Fecha Final para generar el Reporte</b>
                                        </label>                                                                
              </section>
              <section class="col col-2">       
              <label class="label">Graficar por:</label>                         
                             ';
                            echo   '<label class="radio">'.form_radio(array("name"=>"typeParamCL","id"=>"typeParamCL","value"=>"razon_social", "checked"=>"checked")).'<i></i>Clientes</label>'.
                                   '<label class="radio">'.form_radio(array("name"=>"typeParamCL","id"=>"typeParamCL","value"=>"nombre")).'<i></i>Proveedor</label>'.
                          ' <i></i> 
                            </label>   
              </section> 
              <section class="col col-2">       
              <label class="label">Participación en:</label>                         
                             ';
                            echo   '<label class="radio">'.form_radio(array("name"=>"typeParamCLII","id"=>"typeParamCLII","value"=>"N", "checked"=>"checked")).'<i></i>Num Servicios</label>'.
                                   '<label class="radio">'.form_radio(array("name"=>"typeParamCLII","id"=>"typeParamCLII","value"=>"P")).'<i></i>Profit</label>'.
                          ' <i></i> 
                            </label>   
              </section> 
              <section class="col col-2">
                <a class=\'button\' href=\'javascript:submitChartAX("'.base_url().'","CL");\'>Generar reporte</a>                
              </section
             </div>         
           </fieldset>';
echo form_close();

echo '
      <fieldset> 
       <div class="row">          
         <section class="col col-11">
            <div id="containerII" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>                         
         </section>
        </div>         
      </fieldset>
     
     ';

 

?>
