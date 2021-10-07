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
		        array('name' => 'Content-type', 'content' => 'text/html; charset=ISO-8859-1', 'type' => 'equiv'),
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

$hoja_estilo = array('href' => 'css/prettyPhoto.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen', 'type' => 'text/css');
echo link_tag($hoja_estilo);					 					
?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-8-2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/default.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.easing.1.3.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.carousel.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.color.animation.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jquery.prettyPhoto.js" charset="utf-8"></script>

</head>
	
<body><div class="page-wrapper">
        <div class="slug-pattern"><div class="overlay"><div class="slug-cut"></div></div></div>
        <div class="header">
            <div class="nav">                            
                <div class="container">
                    <div class="standard">
                     <div class="five column alpha">
                            <div class="logo">
                                <a href="<?php echo base_url();?>index.php"><img src="<?php echo base_url();?>images/logoSenni.png" height="64" /></a>
                            </div>
                        </div>
                        
                         <div class="eleven column omega tabwrapper">
                            <div class="menu-wrapper">
                                <ul class="tabs menu">
                                   
                                    <li>
                                        <a href="<?php echo base_url();?>LG/contacto/">
                                            <img src="<?php echo base_url();?>images/mail.png"/> Contacto
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