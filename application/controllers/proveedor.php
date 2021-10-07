<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proveedor extends CI_Controller {

	public  $user               = NULL;
        private $registros_x_pagina = 10;
	
	public function __construct()
    {
        parent::__construct();		
        $this->load->database('senni_logistics');
		$this->load->model('md_catalogo');
		$this->load->model('md_proveedor');
		$this->load->library('session');
		$this->load->helper('array');
		$this->load->library('table');
		$this->load->library('Utils');
    }
	
	private function validaSS()
	{
		$this->user = $this -> session -> userdata('datos_sesion');
		$data['titulos'] = array("navegador"=>"INGRESO a SENNI LOGISTICS", 
								"ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas",
								"frase"=>"Servicios Integrales Especializados en Log&iacute;stica");
												
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
			
			
		

public function nuevo()
{	
	$this->load->helper('date');
	$this->validaSS();
	
	$mensajeConfirm = "";
	$id_prove 		= substr(''.now(), -4);
	
	$data['usuario'] = element('nombre',$this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics", 
							"ventana"    => "Rompiendo Barreras, Cumpliendo tus Metas",
							"frase"      => "Servicios Integrales Especializados en Log&iacute;stica",
							"titulo"	 => "Formulario para ingresar a un nuevo Proveedor");
							
	$data['accion']   		= "N";
	$data['id_prove'] 		= $id_prove;
	$data['tipos_servicio'] = $this -> md_catalogo -> poblarSelect("tipo_servicio");
	
	$this->load->view('vw_lg_frm_proveedor',$data);						
}

public function editar($id_prove)
{	
	$this->validaSS();
	$mensajeConfirm = "";
	
	$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics", 
							"ventana"    => "Rompiendo Barreras, Cumpliendo tus Metas",
							"frase"      => "Servicios Integrales Especializados en Log&iacute;stica",
							"titulo"	 => "Formulario para actualizar a un Proveedor");
							
	$data['accion'] 		= "A";
	$data['proveedor'] 		= $this -> traeDetalleProveedor($id_prove);
	$data['tipos_servicio'] = $this -> md_catalogo -> poblarSelect("tipo_servicio");
	$data['id_prove'] 		= $id_prove;
	
	$this->load->view('vw_lg_frm_proveedor',$data);						
}


public function guardar()
{	
	$this->validaSS();
	$mensajeConfirm = "";
												
	$accion 		 = $this -> input -> post('accion');
	$rfc 			 = $this -> input -> post('rfc');
	$nombre			 = $this -> input -> post('nombre');
	$correo_principal= $this -> input -> post('correo');
	$calle 			 = $this -> input -> post('calle');
	$numero 		 = $this -> input -> post('numero');
	$colonia 		 = $this -> input -> post('colonia');
	$delegacion 	 = $this -> input -> post('delegacion');
	$estado 		 = $this -> input -> post('estado');
	$pais 			 = $this -> input -> post('pais');
	$cp 			 = $this -> input -> post('cp');
	$id_prove		 = $this -> input -> post('id_prove');
	$tipo_servicio   = $this -> input -> post('tipo_servicio');
	$obs   			 = $this -> input -> post('obs');
	
	if($accion == "N")
	{									
		$this -> md_proveedor -> insert_proveedor($rfc,$nombre,$correo_principal,$calle,$numero,$colonia,
											  	  $delegacion,$estado,$pais,$cp,$tipo_servicio,$obs,$id_prove);
		$mensajeConfirm = ": <strong>".$nombre."</strong> registrado ex&iacute;tosamente";
	}
	else
	{
		$this -> md_proveedor -> delete_dc($id_prove);
   		$this -> md_proveedor -> update_proveedor($id_prove,$rfc,$nombre,$correo_principal,$calle,$numero,$colonia,$delegacion,
	 											$estado,$pais,$cp,$tipo_servicio,$obs);
		$mensajeConfirm = ": <strong>".$nombre."</strong> actualizado ex&iacute;tosamente";
	}
		
		
	$contactos = $this -> input -> post('num_dc');	
	for ($x = 0; $x <= $contactos; $x++) 
	{
		$contacto = $this -> input -> post('contacto'.$x);
		$tel 	  = $this -> input -> post('tel'.$x);
		$correo	  = $this -> input -> post('correo'.$x);
		if($contacto != "")
			$this ->  md_proveedor -> insert_dc($id_prove,$contacto,$tel,$correo);
	}
			
	$this->index();									
}


public function detalle($id_prove=0)
{
	$this->validaSS();
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics",								 
							 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
							 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
							 "titulo"    => "Detalle del Proveedor");
		
	$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
		
	$data['proveedor'] = $this->traeDetalleProveedor($id_prove);
		
	$this->load->view('vw_lg_detalle_proveedor',$data);
	
}

public function index()
    {            
        $this->validaSS();
	
	$param = array("titulo"          => "Cat&aacute;logo de Proveedores ",
                       "colBandeja"      => array('','Nombre','RFC', 'Correo Principal','Tipo Servicio','Fecha de Alta', 'Acciones'),
                       "registrosPagina" => $this->registros_x_pagina,
                       "controlador"     => "proveedor",
                       "numColGrid"      => "6",
                       "formaId"         => "filtrosCoti",
                       "f1Label"         => "Nombre",
                       "f1Image"         => "fa-user",
                       "f2Label"         => "RFC",
                       "f2Image"        => "fa-user",
                       "f3Label"         => "Correo Principal",
                       "f3Image"         => "fa-envelope-o",
                       "f4Label"         => "Tipo Servicio",
                       "f4Select"        => $this -> md_catalogo -> poblarSelect("tipo_servicio"),
                       "accion"          => "nuevo",
                       "tipo"            => "Proveedor",
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
                         
            $grid = $this -> md_proveedor-> traeProveFiltros($this->registros_x_pagina,$pagina,$f1,$f2,$f3,$f4,$fechaIni,$fechaFin);            
            
            echo json_encode ($grid);                          
            
        } catch (Exception $e) {echo ' paginarAX Excepción: ',  $e->getMessage(), "\n";}		
    }

public function consulta()
{
try{
	$this->validaSS();				
	$data['usuario'] = element('nombre', $this->user['0'])." ".  element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
		
	$this->pg_proveedores(0,"");

	} catch (Exception $e) {echo 'consulta Provee Excepción: ',  $e->getMessage(), "\n";}
}

public function pg_proveedores($offset=0, $mensajeConfirm=""){
		
		$this->validaSS();
		$this -> load -> library('pagination'); 
		
		$data['titulos'] = array("navegador" => "Portal SENNI Logistics",								 
								 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
								 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
								 "titulo"    => "Cat&aacute;logo de Proveedores ".$mensajeConfirm);
		
		$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
		$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
												
		$registros_x_pagina = 10;				                     
						
		$clientes = $this -> md_proveedor -> traeProveedores($registros_x_pagina,$offset);
		
		$config['base_url']    = base_url().'/proveedor/pg_proveedores/';
		$config['total_rows']  = $clientes["conteo"];
		$config['per_page']    = $registros_x_pagina;
		$config['num_links']   = 10;	     	
						
	    $this->pagination->initialize($config);

	    $data['links']    = $this -> pagination -> create_links();				
		
		$tmpl = array('table_open' => '<table id="datagrid" class="display compact" cellspacing="0" width="100%">' );
		$this->table->set_template($tmpl);
         
        $header = array('','Nombre','RFC', 'Correo Principal','Tipo Servicio','Fecha de Alta', 'Acciones');

        $this -> table -> set_heading($header);
					
		$x = $offset;
		foreach($clientes["registros"] as $row)
		{	
			$x = $x + 1;
			$celda1 = array('data'  => $x									   ,			 'align'=>"center");
			$celda2 = array('data'  => $this->utils->revisaValorVacio($row['nombre']),
							'align' => "left",'width'=>"200px");
			$celda3 = array('data'  => $this->utils->revisaValorVacio($row['rfc']),			 'align'=>"center");
			$celda4 = array('data'  => $this->utils->revisaValorVacio($row['correo']),
							'align' => "left",'width'=>"150px");
			$celda5 = array('data'  => $this->utils->revisaValorVacio($row['tipo_servicio']),'align'=>"center");
			$celda6 = array('data'  => $this->utils->revisaValorVacio($row['fecha_alta']),   'align'=>"center");	
			$celda7 = array('data' => '<a href="'.base_url().'proveedor/detalle/'.$row['id_prove'].'">
									   <img title="Detalle Proveedor" src="'.base_url().'images/detail.png"></a>		
									   	&nbsp;&nbsp;&nbsp;'.
									   '<a href="'.base_url().'proveedor/editar/'.$row['id_prove'].'">
									   <img title="Editar Proveedor" src="'.base_url().'images/edit.png"></a>
									    &nbsp;',
									   'align'=>"center");
//									   <img class="boton_confirm" title="Borrar Proveedor" id="'.$row['id_prove'].'" 
//									   src="'.base_url().'/images/erase2.png">									   
											
			$this->table->add_row(array($celda1,
										$celda2,
										$celda3,
										$celda4,
										$celda5,
										$celda6,
										$celda7)
										);
		}		
			
		$data['controlador'] = "proveedor";
		$data['accion'] 	 = "nuevo";
		$data['tipo'] 		 = "Proveedor";		
		$data['orden'] 		 = "asc";	
		
        $this->load->view('vw_lg_consulta',$data);
    }


public function borrar($id_prove=0)
{
try{
	$this->validaSS();				
	
	$this -> md_proveedor -> borraProveedor($id_prove);
		
	$this->pg_proveedores(0,"Proveedor Elimininado");

	} catch (Exception $e) {echo 'borrar Provee Excepción: ',  $e->getMessage(), "\n";}
}    
    
private function traeDetalleProveedor($id_provee)
	{
		$this -> load -> model('md_proveedor');
		
		$proveedor = $this -> md_proveedor  -> traeDetalleProveedorPorEn($id_provee,"proveedor","pr","pr.rfc,pr.nombre,pr.correo,pr.calle,
																					pr.numero,pr.colonia,pr.delegacion,pr.estado, 
																					pr.pais,pr.cp,pr.tipo_servicio,pr.id_prove, 
																					pr.tipo_servicio as id_tipo_servicio,
																					c.opcion_catalogo as tipo_servicio,pr.obs");
		$contactos = $this -> md_proveedor  -> traeDetalleProveedorPorEn($id_provee,"dcc","d","*");		
				
		return array('datos' 	 => $proveedor, 
					 'contactos' => $contactos);					 
	}
	

public function traeProveedoresPorTSAX()
{
	$ts = $this -> input -> post('ts');// tipo de servicio
	
	$proveedores = $this -> md_proveedor  -> poblarSelectAX($ts);
	
	echo json_encode ($proveedores);
	
}

}//Controller

