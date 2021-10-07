<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cotizador extends CI_Controller {

public   $user               = NULL;
private  $registros_x_pagina = 10;
private  $output_dir         = "adjuntos/cotizaciones/";
	
public function __construct()
{    
	parent::__construct();
	
	$this->load->database('senni_logistics');       
	$this->load->model('md_cotizador');
	$this->load->model('md_catalogo');
	$this->load->model('md_usuario');
	$this->load->model('md_pedido');	
	$this->load -> model   ('md_sat');
	$this->load->library('session');
	$this->load->helper('array');
	$this->load->library('table');
	$this->load->library('Utils');	
}


private function validaSS()
{
	$this->user = $this -> session -> userdata('datos_sesion');
	$data['titulos'] = array("navegador" => "INGRESO a SENNI LOGISTICS", 
							"ventana"	 => "Rompiendo Barreras, Cumpliendo tus Metas",
							"frase"		 => "Servicios Integrales Especializados en Log&iacute;stica");
											
	if( $this->user == NULL )
	{
		$data['sesion'] = "Su sesión ha expirado";
		$this->load->view('vw_lg_gestion',$data);
		die($this->output->get_output());
	}
	else		
		if ($this->user['0']['tipo']=="C")
		{
			$data['sesion'] = "Usted no cuenta con los privilegios necesarios para accesar a la sección
							   solicitada";
			$this->load->view('vw_index',$data);
			die($this->output->get_output());
		}
}


public function generarPDFAX()
{
 try
 {
	$this->load->helper('date');
	$this->load->library('Pdf');
	$this->load->helper( 'file');
		
	$naSinAcentos = $this->utils->generaNombrePDF($this -> input -> post('prosp_empresa'));
	$moneda       = $this -> input -> post('moneda');
	$tipo_cambio  = $this -> input -> post('tipo_cambio');
	$filename     = 'cotizacion_'.$naSinAcentos.'_'.$this -> input -> post('id_coti').'.pdf';		
	$now 	      = new DateTime();
	$fechaCoti    = $this->utils->traduceMeses($now->format('F-Y'));
	$myTable      = "";
	$rowsConcepto = "";
	$rowsCargo    = "";
	$rowsTermino  = "";
	$rowsNota     = "";

	$admin          = $this -> md_usuario -> traeDetalleAdmin($this -> input -> post('admin'));
	$tipos_servicio = $this -> md_catalogo-> poblarSelect("tipo_servicio");

	$data['datosSL']    		= $this->md_pedido->traeDatosSL();
	$data['prospecto']          = array("prosp_nombre"  => $this -> input -> post('prosp_nombre'), 
										"prosp_empresa" => $this -> input -> post('prosp_empresa'),
										"asunto"        => $this -> input -> post('asunto'));							   
	$data['templateCotizacion'] = $this -> md_cotizador -> traeTemplateCotizacion();	
	$data['atentamente']        = array("firmaAdmin"  => $admin[0]['firma'], 
                                            "nombreAdmin" => $admin[0]['titulo'].' '.$admin[0]['nombre'].' '.$admin[0]['apellidos'],
                                            "correoAdmin" => $admin[0]['correo'],
                                            "celAdmin" 	  => $admin[0]['celular'],
                                            "telAdmin"    => $admin[0]['telefono']);
	$sl                 = array("slAtte"  => $this -> input -> post('slAtte') );
	$lblTC              = $moneda=="USD" ? " ".$moneda.br()."<small><small>tipo de cambio: $".$tipo_cambio." MXN</small></small>" : " MXN<br>&nbsp;";	
	
	//while (list($llave, $valor) = each($tipos_servicio)) 
	foreach($tipos_servicio as $llave => $valor)
	{
		if ($llave != 0 & $llave <= 66)
		{
			$slStr 		  = "";
			$rowsConcepto = "";
			$numconceptos = $this -> input -> post($llave.'numconceptos');									
			for ($x = 0; $x <= $numconceptos; $x++) 
			{
				$concep 	 = $this -> input -> post($llave.'concep'.$x);
				$concep_dato = $this -> input -> post($llave.'concep_dato'.$x);
				if ($concep != "")
				   {	$rowsConcepto = $rowsConcepto."<tr><td width='4%'></td>".
													"   <td width='48%' align='left'> <img src='images/check.png'> ".$concep."</td>".
													"   <td width='48%' align='left'>".$concep_dato."</td>".
													" </tr>";
				  }
			}
			
			$rowsCargo ="";
			$numcargos = $this -> input -> post($llave.'numcargos');
			$totCargos = 0;
			for ($x = 0; $x <= $numcargos; $x++) 
			{				
				$concep 	 = $this -> input -> post($llave.'cargo'.$x);
				$concep_dato = $this -> input -> post($llave.'importe'.$x);
				$iva 		 = $this -> input -> post($llave.'iva'.$x);
				$ivaStr 	 = $iva == "1" ? " más iva " : "";
				
				if ($concep != "")
					{ $rowsCargo = $rowsCargo."<tr>".
												"   <td width='50%' align='left'>".$concep."</td>".
												"   <td width='50%' align='left'>$ ".number_format($concep_dato,2).$ivaStr."</td>".
												"</tr>"; 
					  $totCargos = $totCargos + $concep_dato;
					}
			}
			
			$rowsCargo = $rowsCargo."<tr>".
								"   <td width='100%' colspan='2' align='center'><div class='recuadroGris'> TOTAL: $ ".number_format($totCargos,2).$lblTC."</div></td>".
								"   </tr>"; 

			$rowsTermino   = "";
			$numterminos  = $this -> input -> post($llave.'numterminos');
			for ($x = 0; $x <= $numterminos; $x++) 
			{
				$termino 	  = $this -> input -> post($llave.'termino'.$x);				
				$termino_dato = $x == 0 ? $this->md_catalogo->traeDescOpcion($this -> input -> post($llave.'termino_dato'.$x)) : $this -> input -> post($llave.'termino_dato'.$x) ; 
				$leyenda 	  = $x == 3 ? " días" : ""; 		

				if ($termino != "")
					{ $rowsTermino = $rowsTermino." <tr><td width='4%'></td>".
												  "     <td width='48%' align='left'> <img src='images/check.png'> ".$termino."</td>".
												  "     <td width='48%' align='left'>".$termino_dato." ".$leyenda."</td>".
												  " </tr>"; 
				   }
			}
			
			$rowsNota   = "";
			$numnotas  = $this -> input -> post($llave.'numnotas');
			for ($x = 0; $x <= $numnotas; $x++) 
			{
				$nota 	 = $this -> input -> post($llave.'nota'.$x);
				if ($nota != "")
					{ $rowsNota = $rowsNota." <tr>".
						 "  <td width='5%' align='center'><img src='images/icon02.png' width='20px' heigth='20px'></td>".
						  " <td width='95%' style='font-size:10pt;font-weight:normal;' align='justify'>".$nota."</td>".
						  " </tr>"; 
					}
			}

			if ($numnotas != "" & $numcargos != "" & $numconceptos != "" & $numterminos != "")
			{//#CEDFEA
				if( $rowsTermino != "" && $rowsConcepto != "" )
				 { $myTable = $myTable."
					<table cellspacing='0' style='width: 100%;' bordercolor='white' align='center' cellpadding='0' >".
					"<tr>".
						"<td width='20%' align='center' style='background-color:#CEDFEA'>FLETE ".$valor.":</td>".
						"<td width='80%' align='center' style='font-weight:bold;'>
							<table cellspacing='0' width='100%' align='center' cellpadding='0' >								
								".$rowsTermino."
							</table>
						</td>".
					"</tr>
					<tr><td width='80%' colspan='2'>".nbs(1)."</td> </tr>
					<tr>".
						"<td width='20%' align='center' style='background-color:#CEDFEA'>DETALLE DEL EMBARQUE:</td>".
						"<td width='80%' align='center' style='font-weight:bold;'> 
							<table cellspacing='0' width='100%' align='center' cellpadding='0' >								
								".$rowsConcepto."
							</table>
						</td>".
					"</tr>					
					</table>"; 
				  }

				  $slStr = "<p>&nbsp;</p>";
				  for ($s = 0; $s <= $this -> input -> post('slConceptos'.$llave); $s++)
                      { $slStr = $slStr.'<p>&nbsp;</p>'; }
				  $myTable = $myTable.$slStr;
				  $slStr   = "";
																	
				if($rowsCargo != "")	  
					{ $myTable = $myTable."<table cellspacing='0' style='width: 100%' align='center' cellpadding='0'>".
						  " <tr>".
						  " <td width='50%' align='center' style='font-weight:bold;'><div class='recuadroGris'>CARGO<br>&nbsp;</div></td>".
						  " <td width='50%' align='center' style='font-weight:bold;'><div class='recuadroGris'>IMPORTE EN".$lblTC."</div></td>".
						  " </tr>".
						   $rowsCargo.
						  "</table>"; }
						  
				
				if($rowsNota != "")	  
				   { $myTable = $myTable. "
							<div class='page_break'></div>
								<div class='recuadroGris'>
								<center>NOTAS</center>
								<table cellspacing='0' width='100%' align='center' cellpadding='0'>".
									$rowsNota.
							"	</table>
						  </div>";	
					}				  
			}
		}
	}
		
	$data['servicios'] = $myTable;	
	$data['sl']        = $sl;
	$data['lblTC']     = $lblTC;	
	$data['fechaCoti'] = $fechaCoti;
    $html = $this->load->view('vw_pdf_coti' , $data , true );

  	 $this->pdf->generate($html, $this->output_dir.$filename, FALSE);
    
     $cotizacion = array("cotizacion"  => $filename, "accion" => '');		
	
    echo json_encode ($cotizacion);

 } catch (Exception $e) {echo 'Cotizador Excepción: ',  $e->getMessage(), "\n";}	
}


public function download($filename)
{
	$this->load->helper('download');			

	$data = file_get_contents("./".$this->output_dir.$filename);

	force_download($filename, $data);		
}

	
public function nuevo()
{
 try{
	 		
	$this->validaSS();
	$this->load->helper('date');
	
	$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics", 
                                 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
                                 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
                                 "titulo"    => "Formulario para ingresar un nueva Cotizaci&oacute;n");			 

	$now 	   = new DateTime();
	$fechaCoti = $this->utils->traduceMeses($now->format('F-Y'));
	$id_coti   = substr(''.now(), -5);	
							 		
	$data['status']             = $this -> md_catalogo  -> poblarSelect("coti");
	$data['tipos_servicio']     = $this -> md_catalogo  -> poblarSelect("tipo_servicio");
	$data['terminosINCO']       = $this -> md_catalogo  -> poblarSelect("terminos");
	$data['admins'] 	    = $this -> md_usuario   -> traeAdmin();
	$data['templateCotizacion'] = $this -> md_cotizador -> traeTemplateCotizacion();
	$data['fechaCoti'] 	    = $fechaCoti;
	$data['accion'] 	    = "N";
	$data['id_coti'] 	    = $id_coti;
	$data['coti_pdf'] 	    = '';
	$data['atentamente']        = NULL;
								
	$this->load->view('vw_lg_frm_coti',$data);
	
	} catch (Exception $e) {echo 'nuevo  Excepción: ',  $e->getMessage(), "\n";}		
}

public function clonar($id_coti=0)
{
try{
	$this->validaSS();
	$this->load->helper('date');
	
	$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics", 
                                "ventana"    => "Rompiendo Barreras, Cumpliendo tus Metas",
                                "frase"      => "Servicios Integrales Especializados en Log&iacute;stica",
                                "titulo"     => "Formulario para editar la Cotizaci&oacute;n seleccionada");
							 		
	$data['tipos_servicio']     = $this -> md_catalogo  -> poblarSelect("tipo_servicio");
	$data['terminosINCO']       = $this -> md_catalogo  -> poblarSelect("terminos");
	$data['admins'] 	    = $this -> md_usuario   -> traeAdmin();
	$data['templateCotizacion'] = $this -> md_cotizador -> traeTemplateCotizacion();		
	$data['cotizacion'] 	    = $this -> traeDetalleCoti($id_coti,$data['tipos_servicio']);
	$data['accion'] 	    = "N";
        $now 	   = new DateTime();
	$fechaCoti = $this->utils->traduceMeses($now->format('F-Y'));
        $data['fechaCoti'] 	    = $fechaCoti;
	$data['id_coti'] 	    = substr(''.now(), -5);	
	$data['atentamente']        = $this -> md_usuario -> traeDetalleAdmin($data['cotizacion']['coti'][0]['atentamente']);

	$this->load->view('vw_lg_frm_coti',$data);
	
	} catch (Exception $e) {echo 'editar  Excepción: ',  $e->getMessage(), "\n";}					
}

public function editar($id_coti=0)
{
try{
	$this->validaSS();
	$this->load->helper('date');
	
	$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics", 
                                "ventana"    => "Rompiendo Barreras, Cumpliendo tus Metas",
                                "frase"      => "Servicios Integrales Especializados en Log&iacute;stica",
                                "titulo"     => "Formulario para editar la Cotizaci&oacute;n seleccionada");
							 		
	$data['tipos_servicio']     = $this -> md_catalogo  -> poblarSelect("tipo_servicio");
	$data['terminosINCO']       = $this -> md_catalogo  -> poblarSelect("terminos");
	$data['admins'] 	    	= $this -> md_usuario   -> traeAdmin();
	$data['templateCotizacion'] = $this -> md_cotizador -> traeTemplateCotizacion();	
	$data['accion'] 	    	= "A";
	$data['id_coti'] 	    	= $id_coti;	
	$data['cotizacion'] 	    = $this -> traeDetalleCoti($id_coti,$data['tipos_servicio']);
	$fecha_alta                 = new DateTime($data['cotizacion']['coti'][0]['fecha_alta']);
	$fechaCoti                  = $this->utils->traduceMeses($fecha_alta->format('F-Y'));		
	$data['fechaCoti'] 	    	= $fechaCoti;
	$data['atentamente']        = $this -> md_usuario -> traeDetalleAdmin($data['cotizacion']['coti'][0]['atentamente']);

	$this->load->view('vw_lg_frm_coti',$data);
	
	} catch (Exception $e) {echo 'editar  Excepción: ',  $e->getMessage(), "\n";}					
}
	
public function guardar()
{
 try{		
	$this->validaSS();
	
	$this->load->helper('date');	
			
	$this->user 		 = $this->session->userdata('datos_sesion');	
	$data['usuario'] 	 = element('nombre', $this->user['0'])." ".  element('apellidos', $this->user['0']);
	$data['iconuser'] 	 = '<img src="'.base_url().'images/user.png"/>';
	$correo 	     	 = element('correo', $this->user['0']); 
	$hoy 			 = date('Y-m-d H:i:s');

	$id_coti       = $this -> input -> post('id_coti');	
	$prosp_nombre  = $this -> input -> post('prosp_nombre');
	$prosp_empresa = $this -> input -> post('prosp_empresa');
	$asunto        = $this -> input -> post('asunto');	
	$prosp_correo  = $this -> input -> post('prosp_correo');
	$prosp_tel     = $this -> input -> post('prosp_tel');
	$coti_pdf      = $this -> input -> post('coti_pdf');
	$atentamente   = $this -> input -> post('admin');
	$accion        = $this -> input -> post('accion');
	$moneda        = $this -> input -> post('moneda');
	$tipo_cambio   = $this -> input -> post('tipo_cambio');
    $slAtte        = $this->utils->sennisEmptySL($this -> input -> post('slAtte'));
	
	if($accion == "N")
	{ $this ->  md_cotizador -> insert_coti($id_coti,$prosp_nombre,$prosp_empresa,$asunto,$prosp_correo,$prosp_tel,$coti_pdf,$atentamente,$hoy,$correo,$moneda,$tipo_cambio,$slAtte); }
	else
	{
		$this ->  md_cotizador -> update_coti($id_coti,$prosp_nombre,$prosp_empresa,$asunto,$prosp_correo,$prosp_tel,$coti_pdf,$atentamente,$moneda,$tipo_cambio,$slAtte);
		$this ->  md_cotizador -> borra_detalle_coti($id_coti);
	}

	
	$tipos_servicio = $this -> md_catalogo  -> poblarSelect("tipo_servicio");		
	
	//while (list($llave, $valor) = each($tipos_servicio)) 
	foreach($tipos_servicio as $llave => $valor)
	{
		if ($llave != 0 & $llave <= 66)
		{
			$slnotas     = $this->utils->sennisEmptySL($this->input->post('slNotas'    .$llave));
			$slterminos  = $this->utils->sennisEmptySL($this->input->post('slTerminos' .$llave));
			$slconceptos = $this->utils->sennisEmptySL($this->input->post('slConceptos'.$llave));
			$slservicios = $this->utils->sennisEmptySL($this->input->post('slServicios'.$llave));
			$this ->  md_cotizador -> insert_coti_sl($slnotas,$slterminos,$slconceptos,$slservicios,$llave,$id_coti);
			
			$numconceptos = $this -> input -> post($llave.'numconceptos');			
			for ($x = 0; $x <= $numconceptos; $x++) 
			{
				$concep 	 = $this -> input -> post($llave.'concep'.$x);
				$concep_dato = $this -> input -> post($llave.'concep_dato'.$x);
				if ($concep != "")
					$this ->  md_cotizador -> insert_coti_concepto($concep,$concep_dato,$llave,$id_coti);					
			}
						
			$numcargos = $this -> input -> post($llave.'numcargos');			
			for ($x = 0; $x <= $numcargos; $x++) 
			{
				$cargo 	 = $this -> input -> post($llave.'cargo'.$x);
				$importe = $this -> input -> post($llave.'importe'.$x);
				$iva 	 = $this -> input -> post($llave.'iva'.$x);
				if ($cargo != "")
					$this ->  md_cotizador -> insert_coti_cargo($cargo,$importe,$iva,$llave,$id_coti);
			}
						
			$numterminos  = $this -> input -> post($llave.'numterminos');			
			for ($x = 0; $x <= $numterminos; $x++) 
			{
				$termino      = $this -> input -> post($llave.'termino'.$x);
				$termino_dato = $this -> input -> post($llave.'termino_dato'.$x);
				if ($termino != "")
					$this ->  md_cotizador -> insert_coti_termino($termino,$termino_dato,$llave,$id_coti);					
			}
						
			$numnotas  = $this -> input -> post($llave.'numnotas');			
			for ($x = 0; $x <= $numnotas; $x++) 
			{
				$nota 	 = $this -> input -> post($llave.'nota'.$x);
				$nota 	 = $this -> input -> post($llave.'nota'.$x);
				if ($nota != "")
					$this ->  md_cotizador -> insert_coti_nota($nota,$llave,$id_coti);					
			}
		}
	}

	$this-> index();
	
 } catch (Exception $e) {log_message('error', 'guardar  Excepción:'.$e->getMessage()); }	
}

public function	borraCotizacionAX()
{
		
	$fileName = $this -> input -> post('nombreArchivo');
	$filePath = $this->output_dir . $fileName . '.pdf';
	
	if (file_exists($filePath)) 		
		unlink($filePath);		
}

public function borrar($id_coti=0)
{	
 try{	
	$this->validaSS();
	
	$this ->  md_cotizador -> borra_coti($id_coti);
	
	$coti_pdf = $this ->  md_cotizador -> traeNombreCotiPDF($id_coti);	

	$filePath = $this->output_dir . $coti_pdf[0]['coti_pdf'];
	
	if (file_exists($filePath)) 		
		unlink($filePath);		
	
	$this -> index();

 } catch (Exception $e) {echo 'borrar  Excepción: ',  $e->getMessage(), "\n";}	
}



public function index()
    {            
        $this->validaSS();
	
	$param = array("titulo"          => "Bandeja de Cotizaciones ",
                       "colBandeja"      => array('','Fecha Alta','A nombre de','Empresa','Asunto','Atendido Por','Acciones'),
                       "registrosPagina" => $this->registros_x_pagina,
                       "controlador"     => "cotizador",
                       "numColGrid"      => "7",
                       "formaId"         => "filtrosCoti",
                       "f1Label"         => "A nombre de",
                       "f1Image"         => "fa-user",
                       "f2Label"         => "Empresa",
                       "f2Image"         => "fa fa-university",
                       "f3Label"         => "Asunto",
                       "f3Image"         => "fa fa-tags",
                       "f4Label"         => "Atendido por",
                       "f4Image"         => "fa-user",
                       "f4Select"        => $this->md_usuario->traeAdmin(),
                       "accion"          => "nuevo",
                       "tipo"            => "prospecto de Cotizaci&oacute;n",
					   "mensajeConfirm"  => ""
                      );
	
        $data = $this->createFilter($param);				  				        	     
            
         $this->load->view('vw_lg_fil_pag',$data);
    }
                       
        
    public function paginarAX()
    {
        try{                        
            $pagina   = $this -> input -> post('pagina');
            $f1       = $this -> input -> post('f1');
            $f2       = $this -> input -> post('f2');
            $f3       = $this -> input -> post('f3');
            $f4       = $this -> input -> post('f4');
            $fechaIni = $this -> input -> post('fechaIni');
            $fechaFin = $this -> input -> post('fechaFin');
                         
            $grid = $this -> md_cotizador -> traeCotiFiltros($this->registros_x_pagina,$pagina,$f1,$f2,$f3,$f4,$fechaIni,$fechaFin);            
            
            echo json_encode ($grid);                          
            
        } catch (Exception $e) {echo ' paginarAX Excepción: ',  $e->getMessage(), "\n";}		
    }

public function consulta()
{		
	$this->validaSS();	
	$data['usuario'] = element('nombre', $this->user['0'])." ".  element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
		
	
	$this->pg_coti(0,"");

}

public function pg_coti($offset=0, $mensajeConfirm="")
{	
 try{
	$this->validaSS();
	$this -> load -> library('pagination');
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics",
                                 "titulo"    => "Bandeja de Cotizaciones ".$mensajeConfirm, 
                                 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
                                 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica");
	
	
	$data['usuario']  = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	$tipo_u =  "".element('tipo', $this->user['0']);
			  			
	if ($tipo_u == "A")
		$tipo_u = "";
	else
		$tipo_u= element('correo', $this->user['0']);
	
	$url_a_paginar = '/cotizador/pg_coti/';
	$registros_x_pagina = 10;		
					   	
	$cotis = $this -> md_cotizador -> traeCoti($tipo_u,$registros_x_pagina,$offset);
	
	$config['base_url'] = base_url().$url_a_paginar;
	$config['total_rows'] = $cotis["conteo"];
	
	$config['per_page'] = $registros_x_pagina;
	$config['num_links'] = 5;
	
	$this -> pagination -> initialize($config);					
                    
	$data['links']   = $this -> pagination -> create_links();	
	$tmpl = array ( 'table_open'  => '<table id="datagrid" class="display compact" cellspacing="0" width="100%">' );
	$this->table->set_template($tmpl);
	 
	$header = array('','Fecha Alta','A nombre de','Empresa','Asunto','Atendido Por','Acciones');
	$this -> table -> set_heading($header);
	
	$x = $offset;
	foreach($cotis["registros"] as $row)
	{
		$x = $x + 1;
		$celda1 = array('data'  => $x,'align'=>"center");
	 	$celda2 = array('data'  => $row['fecha_alta'],'align'=>"center");		
		$celda3 = array('data'  => $this->utils->revisaValorVacio($row['prosp_nombre']),'align'=>"left",'width'=>"150px");
	 	$celda4 = array('data'  => $this->utils->revisaValorVacio($row['prosp_empresa']),'align'=>"left",'width'=>"150px");
		$celda5 = array('data'  => $this->utils->revisaValorVacio($row['asunto']),'align'=>"left",'width'=>"220px");
		$celda6 = array('data'  => $this->utils->revisaValorVacio($row['at']),'align'=>"left",'width'=>"110px");

	 	$celda7 = array('data' =>  '<a href="'.base_url().'cotizador/editar/'.$row['id_coti'].'">
								   <img title="Editar Cotizaci&oacute;n" src="'.base_url().'images/edit.png"></a>
								   &nbsp;
								   <img class="boton_confirm" title="Borrar Cotizaci&oacute;n" id="'.$row['id_coti'].'" 
								   src="'.base_url().'/images/erase2.png">'
								   ,'align'=>"center");
										
		$this->table->add_row(array($celda1,
									$celda2,
									$celda3,
									$celda4,
									$celda5,
									$celda6,
									$celda7)
									);
	}
	
   $data['controlador'] = "cotizador";   
   $data['accion'] 	 	= "nuevo";
   $data['tipo'] 		= "prospecto de Cotizaci&oacute;n";
   $data['orden'] 		= "desc";
   $this->load->view('vw_lg_consulta',$data);
   
   } catch (Exception $e) {echo 'pg_coti AX Excepción: ',  $e->getMessage(), "\n";}	
}
	
private function traeDetalleCoti($id_coti,$tipos_servicio)
{
 try{	
    $coti = $this -> md_cotizador -> traeDetalleCoti($id_coti,NULL,"cotizacion","co","co.fecha_alta,co.prosp_nombre,co.prosp_empresa,co.asunto,co.creado_por, co.moneda, co.tipo_cambio, co.prosp_correo, co.prosp_tel, co.atentamente, co.slAtte");
    $servicios = array();		
    //while (list($llave, $valor) = each($tipos_servicio)) 
	foreach($tipos_servicio as $llave => $valor)
    {
        if ($llave != 0 & $llave <= 66)
        {         
            $coti_conceptos = $this -> md_cotizador -> traeDetalleCotiPedido($llave, NULL,"pedido_conceptos","id_pedido","concepto, descripcion, tipo_servicio"     ,$id_coti,"coti_conceptos","id_coti","concepto, descripcion, tipo_servicio");
            $coti_cargos    = $this -> md_cotizador -> traeDetalleCotiPedido($llave, NULL,"pedido_cargos"   ,"id_pedido","cargo, importe, iva, costo, tipo_servicio",$id_coti,"coti_cargos"   ,"id_coti","cargo, importe, iva, (importe*0) as costo, tipo_servicio");
			
            $coti_terminos  = $this -> md_cotizador -> traeDetalleCotiPedido($llave, NULL,"pedido_terminos" ,"id_pedido","termino, descripcion, tipo_servicio"      ,$id_coti,"coti_terminos" ,"id_coti","termino, descripcion, tipo_servicio");            
            $coti_notas  = $this -> md_cotizador -> traeDetalleCoti($id_coti,$llave,"coti_notas","ct","ct.nota,ct.tipo_servicio");
            $coti_sl	 = $this -> md_cotizador -> traeDetalleCoti($id_coti,$llave,"coti_sl","sl","sl.slnotas,sl.slterminos,sl.slconceptos,sl.slservicios");
            $servicios[] = array('id_servicio'   => $llave,
                                'servicio'       => $valor,
                                'coti_conceptos' => $coti_conceptos,
                                'coti_cargos'    => $coti_cargos,
                                'coti_terminos'  => $coti_terminos,
                                'coti_notas'     => $coti_notas,
                                'coti_sl'        => $coti_sl);				
        }			
    }        						
    return array('coti'  	 => $coti,
                             'servicios' => $servicios);

    } catch (Exception $e) {echo 'traeDetalleCoti AX Excepción: ',  $e->getMessage(), "\n";}	
}
	
	
public function traeDetalleAdminAX()
{				
 try{
	  $admin = $this -> md_usuario -> traeDetalleAdmin($this -> input -> post('correo'));
						
	  echo json_encode ($admin);
	  
	} catch (Exception $e) {echo 'Cotizador AX Excepción: ',  $e->getMessage(), "\n";}	
}


public function traeDatosClienteCotiAX()
{				
 try{
	  $coti = $this -> md_cotizador -> traeEncabezadoCoti($this -> input -> post('id_coti'));

	  $encabezado = array("prosp_empresa" => $coti["0"]["prosp_empresa"],
						  "prosp_nombre"  => $coti["0"]["prosp_nombre"],
						  "prosp_correo"  => $coti["0"]["prosp_correo"],
						  "prosp_tel"     => $coti["0"]["prosp_tel"] );
						
	  echo json_encode ($encabezado);
	  
	} catch (Exception $e) {echo 'Cotizador AX Excepción: ',  $e->getMessage(), "\n";}	
}

public function traeDatosCotiAX()
{				
 try{
    $id_coti        = $this -> input -> post('id_coti');
    $id_pedido      = $this -> input -> post('id_pedido');
    $tipos_servicio = $this -> md_catalogo  -> poblarSelect("tipo_servicio");
    $servicios 	    = array();		

    //while (list($llave, $valor) = each($tipos_servicio)) 
	foreach($tipos_servicio as $llave => $valor)
        {
          if ($llave != 0 & $llave <= 66)
          {
            $coti_conceptos = $this -> md_cotizador -> traeDetalleCotiPedido($llave,$id_pedido,"pedido_conceptos","id_pedido","concepto, descripcion, tipo_servicio"     ,$id_coti,"coti_conceptos","id_coti","concepto, descripcion, tipo_servicio");
            $coti_cargos    = $this -> md_cotizador -> traeDetalleCotiPedido($llave,$id_pedido,"pedido_cargos"   ,"id_pedido","cargo, importe, iva, costo, unidad, tipo, subtotal, tipo_servicio, status",$id_coti,"coti_cargos"   ,"id_coti","cargo, importe,('VENTA') as tipo, (1) as unidad, iva, (importe*0) as costo,(importe) as subtotal, tipo_servicio,('') as status");
            $coti_terminos  = $this -> md_cotizador -> traeDetalleCotiPedido($llave,$id_pedido,"pedido_terminos" ,"id_pedido","termino, descripcion, tipo_servicio"      ,$id_coti,"coti_terminos" ,"id_coti","termino, descripcion, tipo_servicio");
			$moneda         = $this -> md_cotizador -> traeMonedaCoti($id_coti);
			$tc 	        = $this -> md_cotizador -> traeTCCoti($id_coti);
            $fechas         = $this -> md_cotizador -> traeDetalleFechas($id_pedido,$llave);
            
            if( $coti_conceptos != false & $coti_cargos!= false & $coti_terminos != false)
                {    $servicios[] = array('id_servicio'    => $llave,
										  'moneda'		   => $moneda,										  
                                          'servicio' 	   => $valor,
                                          'coti_conceptos' => $coti_conceptos,
                                          'coti_cargos'    => $coti_cargos,
                                          'coti_terminos'  => $coti_terminos,
                                          'fechas'         => $fechas); }
          }
        }        						

    echo json_encode ($servicios);
	  
    } catch (Exception $e) {echo 'Cotizador AX Excepción: ',  $e->getMessage(), "\n";}	
}
	
}

