<?php echo doctype('xhtml1-trans');?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

<title><?php echo $titulos["navegador"];?></title>
<?php

$meta = array( array('name' => 'author'      , 'content' => NOMBRE_CORTO),
               array('name' => 'description' , 'content' => 'Arquitectos de Trasporte'),
               array('name' => 'keywords'    , 'content' => 'Logistica, embarques, aduana, transporte'),        
               array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv'),
               array('name' => 'viewport'    , 'content' => 'width=device-width, initial-scale=1, maximum-scale=1')
        );

echo meta($meta); 


$hoja_estilo = array('href' => 'css/jquery-ui.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);					 	

$hoja_estilo = array('href' => 'css/validationEngine.jquery.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/simplePagination.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/uploadfile.css','rel' => 'stylesheet', 'type' => 'text/css');//upload
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/font-awesome.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/sky-forms.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/sky-tabs.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/sky-forms-blue.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/SENNIStyle.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/jquery.alerts.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/jquery.alerts.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/sky-mega-menu.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/multiselect.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/datatable/jquery.dataTables.min.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/datatable/responsive.dataTables.min.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-8-2.js"></script>
<!--
<script type="text/javascript" src="<?php echo base_url();?>js/datatable/jquery-1.12.4.js"></script>
-->
<script type="text/javascript" src="<?php echo base_url();?>js/jQueryUI_v1_11_4.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validationEngine-esp.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/utilsYAjax.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.simplePagination.js"></script>

<!-- upload -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.uploadfile.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.modal.js"></script>
<!-- RichText tinymce -->
<script type="text/javascript" src="<?php echo base_url();?>js/tinymce/tinymce.min.js"></script>

<!-- Mask Input Jquery -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.maskedinput.min.js"></script>

<!-- JAlert Jquery -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.alerts.js"></script>

<!-- NOTIFICACIONES -->
<script type="text/javascript" src="<?php echo base_url();?>js/ttw-notification-menu.js"></script>

<!-- Number Jquery -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.number.js"></script>
<!-- MaskMoney Jquery -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.maskMoney.js"></script>

<!-- highchartsV5 -->
<script type="text/javascript" src="<?php echo base_url();?>js/code/highcharts.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/code/highcharts-3d.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/code/modules/exporting.js"></script>

<!-- Timbrar Multiselect -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.multi-select.js"></script>

<!-- dataTables -->
<script type="text/javascript" src="<?php echo base_url();?>js/datatable/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/datatable/dataTables.responsive.js"></script>

</head>


<body class="bg-orange">

    <?php
        echo form_input(array('name' => 'companyName'  , 'type' => 'hidden', 'id' => 'companyName'  ,'value' => NOMBRE_CORTO));
        echo form_input(array('name' => 'correoDominio', 'type' => 'hidden', 'id' => 'correoDominio','value' => CORREO_DOMINIO));
    ?>
    
<div id="s4-workspace" class="ms-core-overlay" >
<div id="s4-bodyContainer">
    <div class="container">          
        <header class="clearfix noindex">
         <!-- mega menu -->
        <ul class="sky-mega-menu sky-mega-menu-anim-scale sky-mega-menu-response-to-icons">         
        <li>
            <img src="<?php echo base_url();?>img/logo_senni_header.png" width="97px" height="45px" />
        </li>
        <li>
            <a href="<?php echo base_url();?>gestion/portal/"><i class="fa fa-single fa-home"></i></a>
        </li>
        				
        <li aria-haspopup="true">
            <a href="#"><i class="fa fa-cogs"></i>Gesti&oacute;n</a>
            <div class="grid-container3">
                <ul>
                    <li><a href="<?php echo base_url();?>gestion/consultaclientes/"><i class="fa fa-suitcase"></i>Clientes</a></li>
                    <?php
                        if ( $this->user['0']['tipo']=="A" ) 
                        {
                            echo '<li><a href="'.base_url().'gestion/facturacion/"><i class="fa fa-files-o"></i>Facturas</a></li> ';
                        }
                        echo '<li><a href="'.base_url().'gestion/rnomina/"><i class="fa fa-money"></i>Recibos Nomina</a></li>';
                    ?>                    
                    <li><a href="<?php echo base_url();?>proveedor/"><i class="fa fa-male"></i>Proveedores</a></a></li>
                    <li><a href="<?php echo base_url();?>cotizador/"><i class="fa fa-file-pdf-o"></i>Cotizaciones</a></a></li>
                    <li><a href="<?php echo base_url();?>usuario/"><i class="fa fa-users"></i>Usuarios</a></a></li>
                    <li><a href="<?php echo base_url();?>gestion/plantillas/"><i class="fa fa-file-powerpoint-o"></i>Plantillas</a></a></li>
                </ul>
            </div>
        </li>
        <li aria-haspopup="true">
            <a href="<?php echo base_url();?>pedido/consulta/"><i class="fa fa-truck"></i>Embarques</a>
            <div class="grid-container3">
                <ul>
                    <li><a href="<?php echo base_url();?>pedido/nuevo/"><i class="fa fa-plus-circle"></i>Nuevo Embarque</a></li>
                    <li><a href="<?php echo base_url();?>pedido/consulta/"><i class="fa fa-bookmark"></i>Consultar Embarque</a></li>							
                </ul>
            </div>
        </li>				
        <li>
            <a href="<?php echo base_url();?>retro/consultar/"><i class="fa fa-newspaper-o"></i>Encuestas S.</a>
        </li>
        <li>
            <a href="<?php echo base_url();?>bi/"><i class="fa fa-pie-chart"></i>Reportes</a>
        </li> 
        <li class="right">
            <?php echo $iconuser.nbs(2).$usuario.nbs(2);?>
        </li>       				
        <li class="right">
            <a href="<?php echo base_url();?>gestion/salir/"> <img src="<?php echo base_url();?>images/salir.png"/> Salir </a> 
        </li>
    </ul><!--/ mega menu -->       
    <br>
</header>
<!-- End header -->  
                                            
                                            
                    