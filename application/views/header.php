<?php echo doctype('xhtml1-trans');?>
<html xmlns="http://www.w3.org/1999/xhtml" >
<!--[if lt IE 9]>
          <script src="//oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="//oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<head>

    ​<!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-TM6M7FM');</script>
    <!-- End Google Tag Manager -->​
    
<title><?php echo $titulos["navegador"];?></title>
<?php

$meta = array(
                array('name' => 'author',      'content' => 'SENNI'),
                array('name' => 'description', 'content' => 'Arquitectos de Trasporte'),
                array('name' => 'keywords',    'content' => 'Logistica, embarques, aduana, transporte'),        
                array('name' => 'Content-type','content' => 'text/html; charset=utf-8', 'type' => 'equiv'),
                array('name' => 'viewport',    'content' => 'width=device-width, initial-scale=1')
	    	);

echo meta($meta); 

$hoja_estilo = array('href' => 'css/master.css','rel' => 'stylesheet','charset' => 'utf-8','media' => 'screen');
echo link_tag($hoja_estilo);

?>

<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1-8-2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/jQueryUI_v1_11_4.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/utilsYAjax.js"></script>

</head>
	
<body data-scrolling-animations="true">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TM6M7FM"
    height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

        <div class="sp-body">
        <header id="this-is-top">
            <div class="container-fluid">
                <div class="topmenu row">
                    <nav class="col-sm-offset-3 col-md-offset-4 col-lg-offset-4 col-sm-6 col-md-5 col-lg-5">
                        <a></a></nav>
                </div>
                <div class="row header">
                    <div class="col-sm-3 col-md-3 col-lg-3">
                        <a href="<?php echo base_url();?>" id="logo"></a>
                    </div>
                    <div class="col-sm-offset-1 col-md-offset-1 col-lg-offset-1 col-sm-8 col-md-8 col-lg-8">
                        <div class="text-right header-padding">
                            <div class="h-block"><span>Email</span>ventas@senni.com.mx</div>
                            <div class="h-block"><span>Web</span>senni.com.mx</div>
                            <p style="text-transform:capitalize; font-size:18px;">Rompiendo Barreras,<br /> Cumpliendo tus Metas!!!</p>
                        </div>
                    </div>
                </div>
                <div id="main-menu-bg"></div>  
                <a id="menu-open" href="#"><i class="fa fa-bars"></i></a> 
                <nav class="main-menu navbar-main-slide">
                                        <ul class="nav navbar-nav navbar-main">
                                                <li>
                                                        <a href="<?php echo base_url();?>" class="active">Inicio</a>
                                                </li>
                    <li>
                                                        <a href="<?php echo base_url();?>welcome/quienes_somos/">Quiénes Somos</a>
                                                </li>
                                                <li class="dropdown">
                                                        <a data-toggle="dropdown" class="dropdown-toggle border-hover-color1" >Servicios <i class="fa fa-angle-down"></i></a>
                                                        <ul class="dropdown-menu">
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/flete_internacional/">Flete Internacional</a></li>
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/revision_origen/">Revisión de Origen</a></li>
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/consultoria_comercio_exterior/">Consultoría en Comercio Exterior y Tramites Gubernamentales</a></li>
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/almacenaje/">Almacenaje</a></li>
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/distribucion/">Distribución</a></li>
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/seguro_carga/">Seguro de Carga</a></li>
                                                                <li><a href="<?php echo base_url();?>welcome/servicios/mercancia_peligrosa/">Mercancía Peligrosa</a></li>
                                                        </ul>
                                                </li>
                                                <li><a href="<?php echo base_url();?>welcome/contacto/">Contacto</a></li>
                                                <li><a href="<?php echo base_url();?>rastreo/">Rastreo</a></li>
                                        </ul>
                </nav>
                <a id="menu-close" href="#"><i class="fa fa-times"></i></a>
            </div>
        </header>