<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rastreo extends CI_Controller {

	
	public function __construct()
    {
        parent::__construct();
		$this->load->model('md_rastreo');        
		$this->load->model('md_pedido');        
        $this->load->database('senni_logistics');
		$this->load->library('session');
		$this->load->library('Utils');	
    }
	
	public function index()
	{
		$this->load->library('table');
		$data['titulos'] = array("navegador" =>"Seguimiento de Embarques | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
								
		$attributes = array('class'       => 'col-sm-10 validate[required,custom[integer]] text-input', 
							'name'        => 'num_guia', 
							'id'          => 'num_guia',
							'size'		  => '30',
							'placeholder' => 'Ingrese aqu&iacute; la referencia SENNI: *',
							'maxlength'   => '20');
		$tooltipvar = ' <img title="Ingrese el n&uacute;mero de referencia SENNI proporcionado por su ejecutivo de cuenta para consultar el status de su 
							        embarque"  
						src="'.base_url().'images/pregunta.png"/>';
					  
		$this->table->add_row(array('<label class="col-sm-9">Referencia SENNI:</label> ',form_input($attributes).$tooltipvar));
		
		$this->load->view('vw_frm_rastreo',$data);		
	}
	
	public function buscar()
	{
	   $this->load->library('form_validation');
					
	  $data['titulos'] = array("navegador" =>"Seguimiento de Embarques | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!",
				  "titulo"	 =>"B&uacute;squeda de embarques por Referencia SENNI");
		
	   $this->form_validation->set_rules('num_guia', 'numero de guia', 'integer');        
 
       $this->form_validation->set_message('required', 'El %s es requerido');
	   
	   if ($this->form_validation->run() == FALSE)        
        	$this->index();      
       else
        {           
			$this->session->set_userdata('guia', $this->input->post('num_guia'));
			$this->pg_rastreo(0);      		                        
		}		
	}
	/***
	Función para habilitar el link enviado por correo para validar prefactura
	***/
	public function pf($num_guia)
	{
		$this->session->set_userdata('guia', $num_guia);
		$this->pg_rastreo(0); 
	}
	
	public function maps()
	{
		
		$pod = $this -> md_rastreo -> traePuerto(1);
		$pol = $this -> md_rastreo -> traePuerto(2);
						
		$dom = new DOMDocument('1.0', 'UTF-8');

		// Creates the root KML element and appends it to the root document.
		$node 	 = $dom->createElementNS('http://earth.google.com/kml/2.1', 'kml');
		$parNode = $dom->appendChild($node);
		
		// Creates a KML Document element and append it to the KML element.
		$dnode 	 = $dom->createElement('Document');
		$docNode = $parNode->appendChild($dnode);
		
		// Creates the two Style elements, one for restaurant and one for bar, and append the elements to the Document element.
		$restStyleNode = $dom->createElement('Style');
		$restStyleNode->setAttribute('id', 'puertoStyle');
		
		$restIconstyleNode = $dom->createElement('IconStyle');
		$restIconstyleNode->setAttribute('id', 'puertoIcon');
		
		$restIconNode = $dom->createElement('Icon');
		$restHref 	  = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon63.png');
		
		$restIconNode	   ->appendChild($restHref);
		$restIconstyleNode ->appendChild($restIconNode);
		$restStyleNode	   ->appendChild($restIconstyleNode);
		$docNode	       ->appendChild($restStyleNode);
		
		$barStyleNode = $dom->createElement('Style');
		$barStyleNode->setAttribute('id', 'aeropuertoStyle');
		
		$barIconstyleNode = $dom->createElement('IconStyle');
		$barIconstyleNode->setAttribute('id', 'aeropuertoIcon');
		
		$barIconNode = $dom->createElement('Icon');
		$barHref 	 = $dom->createElement('href', 'http://maps.google.com/mapfiles/kml/pal2/icon27.png');
		$barIconNode      ->appendChild($barHref);
		$barIconstyleNode ->appendChild($barIconNode);
		$barStyleNode     ->appendChild($barIconstyleNode);
		$docNode		  ->appendChild($barStyleNode);
		//AGREGAR FOR para varios PlaceMark
		// Creates a Placemark and append it to the Document.
		  $node 	 = $dom->createElement('Placemark');
		  $placeNode = $docNode->appendChild($node);
		
		  // Creates an id attribute and assign it the value of id column.
		  $placeNode->setAttribute('id', 'placemark' . $pod['0']['id_puerto']);
		
		  // Create name, and description elements and assigns them the values of the name and address columns from the results.
		  $nameNode = $dom->createElement('name',htmlentities($pod['0']['nombre']));
		  $placeNode->appendChild($nameNode);
		  
		  $descNode = $dom->createElement('description', $pod['0']['ubicacion']);
		  $placeNode->appendChild($descNode);
		  
		  $styleUrl = $dom->createElement('styleUrl', '#puertoStyle');
		  $placeNode->appendChild($styleUrl);
		
		  // Creates a Point element.
		  $pointNode = $dom->createElement('Point');
		  $placeNode->appendChild($pointNode);
		
		  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
		  $coorStr  = $pod['0']['longitud'] . ','  . $pod['0']['latitud'];
		  $coorNode = $dom->createElement('coordinates', $coorStr);
		  $pointNode->appendChild($coorNode);
		  
		  // Creates a Placemark and append it to the Document.
		  $node = $dom->createElement('Placemark');
		  $placeNode = $docNode->appendChild($node);
		
		  //POL
		  $placeNode->setAttribute('id', 'placemark' . $pol['0']['id_puerto']);
		
		  // Create name, and description elements and assigns them the values of the name and address columns from the results.
		  $nameNode = $dom->createElement('name',htmlentities($pol['0']['nombre']));
		  $placeNode->appendChild($nameNode);
		  
		  $descNode = $dom->createElement('description', $pol['0']['ubicacion']);
		  $placeNode->appendChild($descNode);
		  
		  $styleUrl = $dom->createElement('styleUrl', '#puertoStyle');
		  $placeNode->appendChild($styleUrl);
		
		  // Creates a Point element.
		  $pointNode = $dom->createElement('Point');
		  $placeNode->appendChild($pointNode);
		
		  // Creates a coordinates element and gives it the value of the lng and lat columns from the results.
		  $coorStr  = $pod['0']['longitud'] . ','  . $pol['0']['latitud'];
		  $coorNode = $dom->createElement('coordinates', $coorStr);
		  $pointNode->appendChild($coorNode);
		//FIN FOR para varios PlaceMark
		
		$kmlOutput = $dom->saveXML();
		header('Content-type: application/vnd.google-earth.kml+xml');
		echo $kmlOutput;
	
	}
	
	public function vermapa()
	{
		$this->load->view('vw_maps',$data);
	}
	
	
	
	
	
	
	public function pg_rastreo($offset=0){
	try{		
		$guia = $this->session->userdata('guia');
		$data['titulos'] = array("navegador" =>"Seguimiento de Embarques | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!",
                                          "titulo"	 =>"B&uacute;squeda de embarques por Referencia SENNI");				
    		
		$encabezado = $this -> md_rastreo -> traeEncabezado($guia);
//		$pod 		= $this -> md_rastreo -> traePuerto($encabezado['0'] -> pol);
//		echo 'POD: '.$pod['0'] -> nombre.' Coordenadas:'.$pod['0'] ->ubicacion;									
		
		$fletes   	   = $this -> md_rastreo -> traeFletes($guia);
		$adjuntos	   = $this->md_pedido->traeAdjuntosPedidoPublicos($guia);

		$columnasFlete     = "";
		$tblEncabezado     = '<div class="container-fluid inner-offset">'.
									'<div class="hgroup text-center wow zoomIn" data-wow-delay="0.3s"> ';
		$tblDetalle        = "";
				
		$tblEncabezado     = $tblEncabezado.'<div class="col-sm-12">'.
												'<div class="col-sm-7 post-info" style="padding-top:2%; border:1px solid #E0E0E0; color:#228dcb;">';
		if ($encabezado==FALSE)
				{ $tblEncabezado   = $tblEncabezado.'<p style="font-size:16px;" class="col-sm-12"> Para el n&uacute;mero de referencia SENNI solicitado: <strong>'.$guia.'</strong> no se encontraron resultados. Puede realizar lo siguiente:'.br(2).
														nbs(3).'<a href="'.base_url().'rastreo/"><img src="'.base_url().'images/ast.png"/> Intentar de nuevo</a>'.br(2).
														nbs(3).'<a href="'.base_url().'welcome/contacto/"><img src="'.base_url().'images/ast.png"/> Ponerse en contacto con un ejecutivo de cuenta</a>'
									. '             </p>'
									. '           </div>';                      
				}
		else { $columnasFlete = $columnasFlete.'<p>&nbsp;</p><p>&nbsp;</p> <p style="float:left; text-align:left; font-size:16px;" class="col-sm-6">  POL: <em class="black">'.$encabezado['0']->pol.' </em>'.br(1).'ETD: <em class="black">'.$encabezado['0']->etd.'</em></p>'.
											    '<p style="float:left; text-align:left; font-size:16px;" class="col-sm-6">  POD: <em class="black">'.$encabezado['0']->pod1.'</em>'.br(1).'ETA: <em class="black">'.$encabezado['0']->eta.'</em></p>';		
			$tablaAdjuntos = "";
			foreach($adjuntos as $a)
	               { $tablaAdjuntos =$tablaAdjuntos . '<div style="float:left; text-align:left; font-size:12px;" class="col-sm-2"> '.$a['desc_adjunto'].'<br><a href="'.base_url().'gestion/download/'.str_replace("adjuntos/","",$a['adjunto']).'" target="_blank"><img title="'.$a['desc_adjunto'].'" src="'.base_url().'images/fileIcon.png"></a> </div>'; }
		             			   
			$tblEncabezado   = $tblEncabezado.'<p style="font-size:16px;" class="col-sm-12">Status del Embarque: <em class="black">'.$encabezado['0']->status_track.'</em></p>'.
												'<p style="float:left; text-align:left; font-size:16px;" class="col-sm-6">N&uacute;mero de Gu&iacute;a Master:	 <em class="black">'.$encabezado['0']->num_mbl.'</em>'.br(1).
											'    Carrier - Transportadora: <em class="black">'.$encabezado['0']->nombre_carrier.'</em></p>'.br(1).                                                        
											'<p style="float:left; text-align:left; font-size:14px;" class="col-sm-6">'.
											'        Embarcador:	 <em class="black">'.$encabezado['0']->shipper.'</em>'.
											'</p>'.
											$columnasFlete.
											'<div class="col-sm-12">'.
											$tablaAdjuntos.    
											'</div></div>';                     
			}
                     
                $tblEncabezado     = $tblEncabezado.'<div class="col-sm-5">'.
                                                        '        <img src="'.base_url().'img/rastreo_2.jpg">'.br(3).
                                                        '</div>'.
                                                        '</div>'.br(2);                
                $tblDetalle        = $tblDetalle.'<h3 align="left" class="col-sm-12">DETALLE DEL MOVIMIENTO DE LOS PEDIDOS</h3>'.                        
                                                 '<table class="col-lg-12 post-info" border="1" bordercolor="#fff	">'. 
                                                 '<tr role="row" class="titulo" style="color:#fff; font-weight:bold; height:25px; font-size:17px;">'.
                                                 '    <td style="width:10%">&nbsp;<i class="glyphicon glyphicon-sort-by-attributes-alt right"></i></td>'.
                                                 '    <td style="width:10%">&nbsp;<i class="glyphicon glyphicon-sort-by-attributes-alt right"></i></td>'.
                                                 '    <td style="width:20%"><i class="glyphicon glyphicon-sort-by-attributes-alt right"></i>Fecha</td>'.
                                                 '    <td style="width:15%">Estado<i class="glyphicon glyphicon-sort-by-attributes-alt right"></i></td>'.
                                                 '    <td style="width:25%">Descripción<i class="glyphicon glyphicon-sort-by-attributes-alt right"></i></td>'.
                                                 '    <td style="width:20%">Observaciones<i class="glyphicon glyphicon-sort-by-attributes-alt right"></i></td>'.
                                                 '</tr>';
                $columnDetalle =  ""; 
		$url_a_paginar = '/rastreo/pg_rastreo/';
		$filtro_paginacion = 1;
		$registros_x_pagina = 10;				                            		
		$rastreo = $this -> md_rastreo -> traeRastreo($guia,$registros_x_pagina,$offset);
										             
		$x = $offset;
                
		foreach($rastreo["registros"] as $row)
		{
			$x ++;
                        $columnDetalle = $columnDetalle.' <tr style="text-align:left">'.
                                                                '<td class="centro"><i class="glyphicon glyphicon-road"></i></td>'.
                                                                '<td class="centro">'.$x.'</td>'.
                                                                '<td class="centro">'.$this->utils->revisaValorVacio($row['fecha_hora']).'</td>'.
                                                                '<td>'.$row['status'].'</td>'.
                                                                '<td>'.$this->utils->revisaValorVacio($row['descripcion']).'</td>'.
                                                                '<td>'.$this->utils->revisaValorVacio($row['observaciones']).'</td>'.
                                                        '  </tr>  ';			
		}
                 $tblDetalle         = $tblDetalle . $columnDetalle .'</table>';
                 $tblEncabezado      = $tblEncabezado.$tblDetalle.'  </div>
                                                       </div>  ';
                 $data['encabezado'] = $tblEncabezado;                                 
                 
                 $this -> load -> view('vw_rastreo',$data);
		
		} catch (Exception $e) {echo 'editar PEdido Excepción: ',  $e->getMessage(), "\n";}
    }
}

