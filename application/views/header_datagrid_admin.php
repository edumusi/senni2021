<?php echo doctype('xhtml1-trans');?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<!--[if lt IE 7 ]><html class="ie ie6" lang="en"> <![endif]-->
<!--[if IE 7 ]><html class="ie ie7" lang="en"> <![endif]-->
<!--[if IE 8 ]><html class="ie ie8" lang="en"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html lang="es-Es" xmlns="http://www.w3.org/1999/xhtml"> <!--<![endif]-->
<head>

<title><?php echo $titulos["navegador"];?></title>
<?php

$meta = array(
		        array('name' => 'author', 'content' => 'SENNI'),
		        array('name' => 'description', 'content' => 'Arquitectos de Trasporte'),
		        array('name' => 'keywords', 'content' => 'Logistica, embarques, aduana, transporte'),        
		        array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv'),
				array('name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, maximum-scale=1')
	    	);

echo meta($meta); 

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

$hoja_estilo = array('href' => 'css/jquery.dataTables.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen', 'type' => 'text/css');
echo link_tag($hoja_estilo);	

$hoja_estilo = array('href' => 'css/tableFade.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/style_light_dg.css','rel' => 'stylesheet', 'type' => 'text/css');//notificaciones
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/simplePagination.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/validationEngine.jquery.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);

$hoja_estilo = array('href' => 'css/jquery-ui.css','rel' => 'stylesheet', 'type' => 'text/css');
echo link_tag($hoja_estilo);					 	

?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-8-2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/default.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.color.animation.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.prettyPhoto.js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.simplePagination.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url();?>js/jquery.dataTables.min.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>js/utilsYAjax.js"></script>
<!-- NOTIFICACIONES -->
<script type="text/javascript" src="<?php echo base_url();?>js/ttw-notification-menu.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.validationEngine-esp.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jQueryUI_v1_11_4.js"></script>

<script>

var notifications = null;

$(document).ready(function() 
{
	$('#menu_noti').addClass('pointer');
	
	notifications = new $.ttwNotificationMenu({notificationList:{anchor:'item',offset:'0 0'}});

    notifications.initMenu({ projects:'#projects'});
	
	var hrefN= '<?php echo base_url(); ?>';
	traeNotificacionesAX(hrefN);
	
});

</script>
</head>
	
<body bgcolor="#FFFFFF"><div class="page-wrapper">
        <div class="slug-pattern slider-expand"><div class="overlay"><div class="slug-cut"></div></div></div>
        <div class="header">
            <div class="nav">                            
                <div class="container">
                    <div class="standard">
                     <div class="five column alpha">
                            <div class="">
                                <a href="<?php echo base_url();?>index.php">
                                <img src="<?php echo base_url();?>img/logo_senni.png" width="120" height="55" /></a>
                            </div>
                        </div>
                        
                        <div class="eleven column omega tabwrapper">
                            <div class="menu-wrapper">
                                <ul class="tabs menu">
                                    <li>
                                       <a href="<?php echo base_url();?>LG/" class="active">
                                       <img src="<?php echo base_url();?>images/inicio.png"/> <span>Inicio</span></a>                                       
                                    </li> 
                                    
                                    <li id="projects">                                    	
                                        <span id="menu_noti"><img src="<?php echo base_url();?>images/noti.png"/> Notificaciones</span>
                                    </li>
                                                                              
                                    <li>                                        
                                           <a href="#"><img src="<?php echo base_url();?>images/gestion.png"/> Gesti&oacute;n</a>                                        
                                           <ul class="child">                                           
                                            <li>
                                            <a href="<?php echo base_url();?>gestion/consultaclientes/">
                                           Clientes
                                            </a>
                                            </li>
                                               
                                             <li>
                                            <a href="<?php echo base_url();?>proveedor/consulta/">
                                            Proveedores
                                            </a>
                                            </li>
                                             <li>
                                            <a href="<?php echo base_url();?>cotizador/">Cotizaciones</a>
                                            </li>
                                            <li>
                                            <a href="<?php echo base_url();?>usuario/">  Usuarios</a>
                                            </li>                                            
                                            <li>
                                            <a href="<?php echo base_url();?>gestion/plantillas">Plantillas</a>
                                            </li>    
                                           </ul>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>pedido/consulta/">
                                           <img src="<?php echo base_url();?>images/truck.png"/> Embarques
                                        </a>
                                          <ul class="child">
                                            <li>
                                            <a href="<?php echo base_url();?>pedido/nuevo/">Nuevo Embarque</a>
                                            </li>
                                            <li>
                                            <a href="<?php echo base_url();?>pedido/consulta/">Consultar Embarque</a>
                                            </li>                                          
                                          </ul>
                                    </li>
                                      <li>
                                        <a href="<?php echo base_url();?>retro/consultar/">
                                        <img src="<?php echo base_url();?>images/retro.png"/> Encuestas de Satisfacci&oacute;n</a>
                                    </li>
                                    <li>
                                        <a href="<?php echo base_url();?>gestion/salir/">
                                           <img src="<?php echo base_url();?>images/salir.png"/> Salir
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
        <!-- Mandar a header -->
        <div class="body">            
            <div class="body-wrapper">                
                <div class="content">                	 
                    <div class="container">                    	                        
                      <div class="sixteen columns" align="right">             	
                         <?php echo $iconuser.nbs(1).$usuario;?>                            
                      </div>                                                
                      <h5 class="semi"> <?php echo $titulos["titulo"];?> </h5>
                      <div class="callout-hr"></div>
        <!-- Mandar a header --> 