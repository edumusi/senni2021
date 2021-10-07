<?php echo doctype('xhtml1-trans');?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

<title><?php echo $titulos["navegador"];?></title>
<?php

$meta = array(  array('name' => 'author',      'content' => 'SENNI'),
                array('name' => 'description', 'content' => 'Arquitectos de Trasporte'),
                array('name' => 'keywords',    'content' => 'Logistica, embarques, aduana, transporte'),        
                array('name' => 'Content-type','content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
                array('name' => 'viewport',    'content' => 'width=device-width, initial-scale=1, maximum-scale=1')
	     );

echo meta($meta); 

/*
$hoja_estilo = array('href' => 'css/base.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/skeleton.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/layout.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/child.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/animate.min.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/nivo-slider.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/prettyPhoto.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/jquery-ui.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);					 	

$hoja_estilo = array('href' => 'css/validationEngine.jquery.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/templateFormulario.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);
 * 
 */

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
?>

<!--
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-8-2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/default.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.color.animation.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.prettyPhoto.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.nivo.slider.pack.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jQueryUI_v1_11_4.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validationEngine-esp.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/utilsYAjax.js"></script>
-->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-8-2.js"></script>

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

<!-- Number Jquery -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.number.js"></script>
<!-- MaskMoney Jquery -->
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.maskMoney.js"></script>


</head>

<body class="bg-orange">
    
<div id="s4-workspace" class="ms-core-overlay" >
<div id="s4-bodyContainer">
    <div class="container">
        <header class="clearfix noindex">
                    <div class="logo">
                       <a href="<?php echo base_url();?>gestion/"><img src="<?php echo base_url();?>img/logo_senni.png" /></a><br><br>
                    </div>
                    <div class="secondary_navigation_container noindex">
                        <ul class="language_navigation clearfix"> 
                            <li class="country_selector">
                            <a href="<?php echo base_url();?>" class="active">
                                       <img src="<?php echo base_url();?>images/inicio.png"/> <span>Sitio Comercial</span></a>
                            </li>
                        </ul>
                    </div>
            <ul class="primary_navigation">

            </ul>
        </header>
        <!-- End header -->  
<!--        
<body><div class="page-wrapper">
        <div class="slug-pattern slider-expand"><div class="overlay"><div class="slug-cut"></div></div></div>
        <div class="header">
            <div class="nav">                            
                <div class="container">
                    <div class="standard">
                     <div class="five column alpha">
                            <div class="">
                                <a href="<?php echo base_url();?>gestion/"><img src="<?php echo base_url();?>img/logo_senni.png" width="120" height="55" /></a>
                            </div>
                        </div>
                        
                        <div class="eleven column omega tabwrapper">
                            <div class="menu-wrapper">
                                <ul class="tabs menu">
                                    <li>
                                       <a href="<?php echo base_url();?>" class="active">
                                       <img src="<?php echo base_url();?>images/inicio.png"/> <span>Sitio Comercial</span></a>                                       
                                    </li>                                                                                                                                                                                        
                                     <li>
                                        <a title="Ingresar al Portal de SENNI LOGISTICS" 
                                        href="<?php echo base_url();?>gestion/">
                                           <img src="<?php echo base_url();?>images/user.png"/>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>                    
                                            
                    </div>              
                </div>                 
            </div>
                
            <div class="shadow"></div>
            <div class="container">
                <div class="page-title">
                    <div class="rg"></div>
                    <h1><?php echo $titulos["ventana"];?></h1>
                </div>
            </div>
        </div>
      
        <div class="body" id="contenedor">            
            <div class="body-wrapper">                
                <div class="content">                	 
                    <div class="container"  style="background-color:#FFF">
                      <div class="sixteen columns" align="right">             	
                         <?php echo $iconuser.nbs(1).$usuario;?>                          
                      </div>                                                
                      <h5 class="semi"> <?php echo $titulos["titulo"];?> </h5>
                       <div class="callout-hr"></div> 
--> 