<?php

    $html = "<html>";
    $meta = array(  array('name' => 'author', 'content' => 'SENNI'),
                    array('name' => 'Content-type', 'content' => 'text/html; charset=UTF-8', 'type' => 'equiv')
                  );
        
    $html = $html ."<head>";
		$html = $html . meta($meta);
		$html = $html . '<link rel="STYLESHEET" href="css/formatos_pdf.css" type="text/css">';
    $html = $html . '<style type="text/css">
               @page { margin: 0; }
                body {  margin-top: 3.5cm;
                        margin-bottom: 2.5cm;
                        margin-left: 1.0cm;
                        margin-right: 1.0cm;		  
                        text-align: justify;
                        font-size:12pt;
                        font-weight:normal;
                        font:sans-serif;
                        background-image:url(../images/backGroundSENNI.png);
                        background-repeat: no-repeat;
                        background-attachment: fixed;
                        background-position: center; 
                      }
                div.header,div.footer {
                  position: fixed;	 
                  width: 100%;
                  border: 0px solid #888;
                  overflow: hidden;
                  padding: 0.1cm;
                }		
                div.footer {
                  bottom: -0.2cm;
                  left: 0cm;
                  background-image:url(../images/pieCotizacionNuevaImagen.png);	 
                  height: 2.0cm;
                  padding: 0cm 0cm .4cm 0cm;
                }
                div.header {
                  top: 0cm;
                  left: 0cm;
                  background-image:url(../images/encabezadoCotizacionNuevaImagen.png);	  
                  height: 2.0cm;
                }
                div.footer table {width: 100%;
                  text-align: center;
                }
                hr { page-break-after: always;
                     border: 0;
                   }
                .page_break { page-break-before: always; }
                .page-number:before { content: "PÁGINA " counter(page); }
                </style>';
      $html = $html . "</head>"; 
     
      $html = $html .'<body marginwidth="0" marginheight="0">'
                    .  '<div class="header">'
                    .  '<div style="width: 100%;">
                          <table align="center" style="width: 100%;">
                          <tbody>
                          <tr> <td width="" class="center" rowspan="2" ><img src="images/logo_encabezado.png" width="80px" height="60px"/></td>
                            <td width="" class="center" style="font-size: 9pt;"><strong>'.$datosSL[0]['nombre_fiscal'].'</strong></td>
                            <td width="" class="center" rowspan="2" style="font-size: 10pt;"><div class="recuadroGris"><strong>NUM COTIZACIÓN</strong><br><strong>#'.$this->input->post('id_coti').br(1).$fechaCoti.'</strong></div></td>
                          </tr>
                          <tr> 
                            <td width="" class="center"  style="font-size: 8pt;">'.$datosSL[0]['domicilio'].'</td>                            
                            </tr>
                          </tbody>
                          </table>
							          </div>'
                    .  '</div>'
                    .  '<div class="footer">'
                    .    '<table align="center" style="width: 100%;">
                            <tbody>
                            <tr> <td width="45%" class="center">'.nbs(1).'</td>
                                <td width="20%" class="center" style="font-size: 12pt;" rowspan="2"><div class="page-number"></div></td>
                                <td width="35%" class="left" style="font-size: 9pt; text-align: left;" rowspan="2"><span style="font-weight:bold;">Tel.'.nbs(1).$atentamente['telAdmin'].'</span>
                                                                                                  '.br(1).' <span style="font-weight:bold;">Cel.'.nbs(1).$atentamente["celAdmin"].'</span>'              
                                                                                                    .br(1).' <span style="font-weight:bold;">'.$atentamente["correoAdmin"].'</span>'
                                                                                                    .br(1).' <span style="font-weight:bold;">'.URL_SITE.'</span> </td></tr>
                                </td>
                            </tr>
                            <tr> <td width="40%" class="left" style="font-size: 8pt; text-align: left;" >'.nbs(1).'</td> </tr>
                            </tbody>
                          </table>'
                    .  '</div>'
                    .  br(1).'<table cellspacing="0" align="center" cellpadding="0" width="100%">'                    
                    .    '<tr><td colspan="2" width="100%"><span style="font-weight:bold;text-align: left;">Atte.'.nbs(1).$prospecto["prosp_nombre"].'</span></td></tr>'
                    .    '<tr><td width="40%"><span style="font-weight:bold; text-align: left;">'.$prospecto["prosp_empresa"].'</span></td><td width="60%" style="font-size: 11pt; text-align: right;" >'.$prospecto["asunto"].'</td></tr>'
                    .    '<tr><td colspan="2" width="100%">'.br(1).'<p style="font-size:9x;text-align: justify;">'.$templateCotizacion[0]['parrafo_inicial'].'</p></td></tr>'
                    .  '</table>'.br(1);
 
      $html = $html . $servicios;
          
      $slStr ='<p>&nbsp;</p>';
     for ($s = 0; $s <= $sl["slAtte"]; $s++)
         { $slStr = $slStr.'<p>&nbsp;</p>'; }
         
         $firma = $atentamente["firmaAdmin"]==NULL || $atentamente["firmaAdmin"]==""?"null.png":$atentamente["firmaAdmin"];                    
         $html = $html .$slStr.'<table cellspacing="0" align="center" cellpadding="0" width="100%">'                 
                       .    '<tr><td class="CotiIzquierdaBold"><p style="font-weight:bold;">Atentamente.</p></td></tr>'
                       .    '<tr><td class="CotiIzquierdaBold"><img border=0 width="120px" height="80px" src="images/firmas/'.$firma.'"/></td></tr>'              
                       .    '<tr><td class="CotiIzquierdaBold"><span style="font-weight:bold;">'.$atentamente["nombreAdmin"].'</span></td></tr>'
                       .    '<tr><td class="CotiIzquierdaBold"><span style="font-weight:bold;">'.RAZON_SOCIAL_FULL.'</span></td></tr>
                       <table cellspacing="0" align="center" cellpadding="0" width="100%">'
                       .    '<tr><td width="50%" class="CotiIzquierdaBold">'.br(1).'<span style="font-weight:bold;">Tel.'.nbs(1).'<img border=0 src="images/tel.png"/>'.nbs(1).$atentamente["telAdmin"].'</span></td>'
                       .    '    <td width="50%" class="CotiIzquierdaBold">'.br(1).'<span style="font-weight:bold;">Cel.'.nbs(1).'<img border=0 src="images/cel.png"/> '.nbs(1).$atentamente["celAdmin"].'</span></td></tr>'              
                       .    '<tr><td width="50%" class="CotiIzquierdaBold"><span style="font-weight:bold;">'.nbs(1).'<img border=0 src="images/mail.png" /> '.nbs(1).'<a href="mailTo:'.$atentamente["correoAdmin"].'" style="color:#3F86C0;">'.$atentamente["correoAdmin"].'</a></span></td>'
                       .    '    <td width="50%" class="CotiIzquierdaBold"><span style="font-weight:bold;">'.nbs(1).'<img border=0 src="images/inicio.png"/>'.nbs(1).'<a href="'.base_url().'" style="color:#3F86C0;">'.URL_SITE.'</a></span></td></tr>'
                       . '</body></html>'
                       ;
      echo $html;

?>
