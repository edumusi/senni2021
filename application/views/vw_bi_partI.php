<script>    


/*   
$(document).ready(function(){

chartService = new Highcharts.Chart({ chart: { renderTo: 'containerService',
                                               
                                               events: { load: requestDataForChart(baseURL,'SRV') }
                                             },
                                      title: { text: 'Servicios BFF International' },
                                      xAxis: {categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']},
                                      yAxis: { min: 0,
                                               max: 10,
                                               gridLineColor: '#FFFFFF', 
                                               title: { text: 'Inquilinos'}
                                             },                                      
                                      series: [],
                                      credits: { enabled: false }
                                    });
  
chartService = new Highcharts.Chart({ chart: { renderTo: 'containerService',
                                              defaultSeriesType: 'spline',
                                              events: { load: requestDataForChart(baseURL,'SRV') }
                                             },
                                      title: { text: 'Servicios BFF International' },
                                      xAxis: {type: 'datetime',
                                              tickPixelInterval: 150,
                                              maxZoom: 20 * 1000
                                             },
                                      yAxis: { minPadding: 0.2,
                                               maxPadding: 0.2,
                                              title: { text: 'Value', margin: 80 }
                                             },
                                      series: [{ name: 'Random data',
                                               data: []
                                            }],
                                      credits: { enabled: false }
                                    });

$('#containerService').highcharts({  chart: { type: 'bar' },
                                title: { text: 'Servicios BFF International '},
                                xAxis: {categories: ''},
                                yAxis: { min: 0,
                                         max: 10,
                                         gridLineColor: '#FFFFFF', 
                                        title: { text: 'Inquilinos'}
                                       },
                                legend: { reversed: true },
                                tooltip: {formatter: function() { return '</b>. profit 1,235 '; }},
                                plotOptions: { series: { stacking: 'normal'} },
                                series: [{  name: 'Aereo',
                                            data: //[1, 2, 3]
                                            [{name: 'Point 1',y: 1}, {name: 'Point 2',y: 2}, {name: 'Point 3',y: 3}]
                                         }, {name: 'Maritimo',
                                             data: [1, 3, 2]
                                            }
                                          , { name: 'Terrestre',
                                              data: [3, 2, 1]
                                            }
                                        ],
                                credits: { enabled: false }
                            });
                          
});//document ready
*/      

</script>


<?php 
echo form_open(base_url().'gestion/genera/', array('id' => 'formSE','name' => 'formSE'));

    echo '<fieldset> 
            <div class="row">          
              <section class="col col-3"><label class="label">De:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[required] text-input chartIni', 
                                                            'name'      => 'paramDeSE', 
                                                            'id'        => 'paramDeSE',                                                                                             
                                                            'maxlength' => '40')).'                 
                                        <b class="tooltip tooltip-bottom-right">Fecha de Inicio para generar el Reporte</b>
                                        </label>
              </section>
              <section class="col col-3"><label class="label">Hasta:</label>
                                         <label class="input"><i class="icon-append fa fa-calendar"></i>
                                         '.form_input(array('class'     => 'validate[required] text-input chartFin', 
                                                            'name'      => 'paramHastaSE', 
                                                            'id'        => 'paramHastaSE',                                                                                             
                                                            'maxlength' => '40')).'
                                        <b class="tooltip tooltip-bottom-right">Fecha Final para generar el Reporte</b>
                                        </label>                                                                
              </section>
              <section class="col col-4">
                <a class=\'button\' href=\'javascript:submitChartAX("'.base_url().'","SE");\'>Generar reporte</a>                
              </section
             </div>         
           </fieldset>';
echo form_close();

echo '
     <fieldset> 
       <div class="row">          
         <section class="col col-11">
            <div id="containerService" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>                         
         </section>
        </div>         
      </fieldset>  
      
     ';

 

?>
