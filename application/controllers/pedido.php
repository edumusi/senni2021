<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pedido extends CI_Controller {

	public  $user 		= NULL;
	private $output_dir = "adjuntos/";
        private $registros_x_pagina = 10;
	
	public function __construct()
    {
        parent::__construct();
		
        $this->load -> database('senni_logistics');
        $this->load -> model   ('md_pedido');
		$this->load -> model   ('md_cliente');
		$this->load -> model   ('md_catalogo');
		$this->load -> model   ('md_sat');
		$this->load -> library ('session');
		$this->load -> library ('table');
		$this->load -> library ('Utils');
		$this->load -> helper  ('array');
		
    }
	
	private function validaSS()
	{
		$this->user = $this -> session -> userdata('datos_sesion');
		$data['titulos'] = array("navegador"=>"INGRESO a SENNI LOGISTICS", 
					"ventana"=>"Rompiendo Barreras, Cumpliendo tus Metas",
					"frase"=>"Servicios Integrales Especializados en Log&iacute;stica");
												
		if( $this->user == NULL)
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
	
	public function index()
	{
		$data['titulos'] = array("navegador" => "Portal SENNI Logistics", 
					 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
					 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
					 "titulo"    => "Formulario para ingresar un nuevo Embarque");
						
		$this->load->view('vw_frm_rastreo',$data);		
	}

public function editar($num_guia=0)
{
try{
	$this->validaSS();
	$this->load->model('md_proveedor');
	$this->load->model('md_cotizador'); 
	$this->load->model('md_sat');
	$this->load->helper('date');
	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics",							 
				 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
				 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
				 "titulo"    => "Formulario para modificar el Embarque con referencia SENNI: <strong>".$num_guia."</strong>");
	
	
	$data['usuario']  = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
		
	$data['regreso_v']           = $this -> md_catalogo -> poblarSelect("regreso_v");
	$data['verificacion_origen'] = $this -> md_catalogo -> poblarSelect("verificacion_o");	
	$data['carta_garantia']      = $this -> md_catalogo -> poblarSelect("carta_garantia");
	$data['carta_no']            = $this -> md_catalogo -> poblarSelect("carta_no");
    $data['tipo_embarque']       = $this -> md_catalogo -> poblarSelect("tipo_embarque");
	$data['status']              = $this -> md_catalogo -> poblarSelect("status");
	$data['segdoc']              = $this -> md_catalogo -> poblarSelect("segdoc");
	$data['tipos_servicio']      = $this -> md_catalogo -> poblarSelect("tipo_servicio");
	$data['clientes']            = $this -> md_cliente  -> poblarSelect();
	$data['cotizaciones']        = $this -> md_cotizador -> poblarSelect();
	$data['terminosINCO']        = $this -> md_catalogo  -> poblarSelect("terminos");
	$data['id_pedido']           = $num_guia;
	$data['accion']              = "E";
	$data['pedido']              = $this->traeDetallePedido($num_guia, $data['tipos_servicio']);
    $data['adjuntos']      		 = $this->md_pedido->traeAdjuntosPedido($num_guia);
	$data['carrier']             = $this->md_proveedor->poblarSelect("0");		
	$data['usoCFDI']             = $this->md_sat->traeDatosUsosCFDI();
	$data['regimenFiscal']       = $this->md_sat->traeDatosRegimenFiscal();
	$data['metodoPago']      	 = $this->md_sat->traeMetodoPago();
	$data['formaPago']       	 = $this->md_sat->traeFormaPago();
	$data['monedaSAT']       	 = $this->md_sat->traeMonedaSAT();
	$data['tipoRelacion']	 	 = $this->md_sat->traeTipoRelacionSAT();
	$data['tipoComprobante'] 	= $this->md_sat->traeTiposComprobantesSAT();
	$data['fechaExpedicion']     = date('d/m/Y');
		
	$this->load->view('vw_lg_frm_ped',$data);
		
	} catch (Exception $e) {echo 'editar PEdido Excepción: ',  $e->getMessage(), "\n";}
	
}


/***
	Metodo Principal del controlador para cargar los datos necesarios la formulario de un nuevo pedido
****/	
public function nuevo()
{	
	$this->validaSS();
	
	$this->load->helper('date');
	$this->load->model('md_proveedor');
	$this->load->model('md_cotizador'); 
	$this->load->model('md_sat');
	
	$data['usuario']  = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	$data['titulos']  = array("navegador" => "Portal SENNI Logistics", 
                                  "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
                                  "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
                                  "titulo"    => "Formulario para ingresar un nuevo Embarque");
							 	
	$data['carrier']             = $this -> md_proveedor -> poblarSelect("0");
	$data['regreso_v']           = $this -> md_catalogo  -> poblarSelect("regreso_v");
	$data['verificacion_origen'] = $this -> md_catalogo  -> poblarSelect("verificacion_o");	
	$data['carta_garantia']      = $this -> md_catalogo  -> poblarSelect("carta_garantia");
	$data['carta_no']            = $this -> md_catalogo  -> poblarSelect("carta_no");
	$data['tipo_embarque']  	 = $this -> md_catalogo  -> poblarSelect("tipo_embarque");
	$data['status']              = $this -> md_catalogo  -> poblarSelect("status");
	$data['segdoc']              = $this -> md_catalogo  -> poblarSelect("segdoc");
	$data['tipos_servicio']      = $this -> md_catalogo  -> poblarSelect("tipo_servicio");
	$data['clientes'] 	     	 = $this -> md_cliente   -> poblarSelect();
	$data['cotizaciones']        = $this -> md_cotizador -> poblarSelect();
	$data['terminosINCO']        = $this -> md_catalogo  -> poblarSelect("terminos");
	$data['id_pedido']           = now();    
	$data['accion']		     	 = "N";
	$data['pedido']              = array('encabezado' => array(array('correo'=>NULL, 'rfc'=>NULL, 'status'=>NULL, 'carrier'=>NULL, 'folio_factura'=>NULL, 'adjunto_factura'=>NULL, 'fecha_alta'=>NULL, 'fecha_modificacion'=>NULL, 'ins_envio'=>NULL, 'ins_booking'=>NULL, 'num_booking'=>NULL, 'num_contenedor'=>1, 'num_mbl'=>NULL, 'adjunto_mbl'=>NULL, 'num_hbl'=>NULL, 'adjunto_hbl'=>NULL, 'vessel_voyage'=>NULL, 'shipper'=>NULL, 'revalidar_aa'=>NULL, 'num_contenedor'=>NULL, 'carta_garantia'=>47, 'carta_no'=>NULL, 'monto_carta_no'=>NULL, 'adjunto_le'=>NULL, 'adjunto_facturaP'=>NULL, 'adjunto_poliza'=>NULL, 'adjunto_cartaporte'=>NULL, 'profit_origen'=>NULL, 'profit'=>NULL, 'comision_ventas'=>NULL, 'comision_operaciones'=>NULL, 'id_carrier'=>NULL, 'id_coti'=>NULL, 'moneda'=>NULL, 'tipo_cambio'=>NULL, 'tipo_embarque'=>NULL, 'id_cg'=>NULL,'id_carta_no'=>NULL,'costo_tot'=>NULL,'venta_tot'=>NULL,'pol'=>NULL,'pod1'=>NULL,'pod2'=>NULL,'etd'=>NULL,'eta'=>NULL,'flagHeaderSaved'=>0,'status_track'=>NULL)), 
										'aduana' 	  => array(array('agencia'=>NULL, 'tiempo'=>NULL)) , 
										'flete' 	  => array(array('id_flete'=>NULL, 'id_pedido'=>NULL, 'tipo_servicio'=>NULL, 'etd'=>NULL, 'eta'=>NULL, 'verificacion_origen'=>NULL,'id_v_o'=>NULL)) ,
										'producto'   => array() ,
										'rastreo'	  => array() ,
										'seguro'	  => array(array('id_seguro'=>NULL, 'id_pedido'=>NULL, 'costo'=>NULL, 'venta'=>NULL, 'iva'=>NULL, 'cobertura'=>NULL)) ,
										'transporte' => array(array('id_transporte'=>NULL, 'id_pedido'=>NULL, 'regreso_vacio'=>NULL, 'costo'=>NULL, 'venta'=>NULL, 'iva'=>NULL, 'salida_puerto'=>NULL, 'maniobras'=>NULL, 'contacto_almacen'=>NULL, 'entrega'=>NULL,'id_regreso_v'=>NULL)),
										'numCargos' => 0,
										);	
	$data['adjuntos']  			= array();
	$data['usoCFDI']            = $this->md_sat->traeDatosUsosCFDI();
	$data['regimenFiscal']      = $this->md_sat->traeDatosRegimenFiscal();
	$data['metodoPago']      	= $this->md_sat->traeMetodoPago();
	$data['formaPago']       	= $this->md_sat->traeFormaPago();
	$data['monedaSAT']       	= $this->md_sat->traeMonedaSAT();
	$data['tipoRelacion']	    = $this->md_sat->traeTipoRelacionSAT();
	$data['tipoComprobante'] 	= $this->md_sat->traeTiposComprobantesSAT();
	$data['fechaExpedicion']    = date('d/m/Y');
	$this->load->view('vw_lg_frm_ped',$data);
	
}

/***
	Metodo Principal del controlador para Guargar y acturalizar un pedido
****/
public function guardar($id_in, $accion, $forma)
{	
try{
	$this->validaSS();
	$this->load->library('email');
	$this->load->library('word');
	$this->load->helper('date');	
		
	$this->load->model('md_aduana');
	$this->load->model('md_flete');
	$this->load->model('md_producto');
	$this->load->model('md_seguro');
	$this->load->model('md_transporte');
	$this->load->model('md_rastreo');
			
	$this->load->helper('date');	
			
	$this->user 	  = $this->session->userdata('datos_sesion');	
	$data['usuario']  = element('nombre', $this->user['0'])." ".  element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	$correo 	  	  = element('correo', $this->user['0']); 
	$hoy              = date('Y-m-d H:i:s');
    $id_pedido        = $id_in;	
	$fecha_alta       = $hoy;


       switch ($forma) 
        {
         case "ENC": 
            $carta_garantia = 0;//$this -> input -> post('carta_garantia');
            $carta_no       = null;
            $monto_carta_no = null;
/*
            if($carta_garantia === "48") // regla de negocio
            {
                $carta_no	= $this -> input -> post('carta_no');
                $monto_carta_no = $this -> input -> post('monto_carta_no');
			}
*/			
            $rfc                = $this -> input -> post('rfc');
            $carrier            = $this -> input -> post('carrier');
            $shipper            = $this -> input -> post('shipper');
            $num_booking        = $this -> input -> post('num_booking');            
            $num_mbl            = $this -> input -> post('num_mbl');
            $num_hbl            = $this -> input -> post('num_hbl');
            $vessel_voyage      = $this -> input -> post('vessel_voyage');	
            $ins_envio          = $this -> input -> post('ins_envio');
            $ins_booking        = $this -> input -> post('ins_booking');
            $revalidar_aa       = $this -> input -> post('revalidar_aa');            
			$id_coti            = $this -> input -> post('cotis');
			$etd 			    = $this->utils->senniDateFormat( $this->input->post('etd') ); 
			$eta 			    = $this->utils->senniDateFormat( $this->input->post('eta') );            
			$tipo_embarque      = $this -> input -> post('tipo_embarque'); 
			$pol      			= $this -> input -> post('pol');            
			$pod1      			= $this -> input -> post('pod1');            
			$pod2      			= $this -> input -> post('pod2');            
			$status 		    = $this->input->post('status_track');

            if($accion == "E")
              { $this -> md_pedido -> actualizaPedido($id_in,array('status_track'=>$status,'correo' => $correo,'fecha_modificacion' => $fecha_alta,'rfc' => $rfc,'carrier' => $carrier,'shipper' => $shipper,'carta_garantia' => $carta_garantia,'carta_no' => $carta_no,'monto_carta_no'=> $monto_carta_no,'num_booking' => $num_booking,'num_mbl' => $num_mbl,'num_hbl' => $num_hbl,'vessel_voyage' => $vessel_voyage,'ins_envio' => $ins_envio,'ins_booking' => $ins_booking,'revalidar_aa'=> $revalidar_aa,'num_contenedor' => $num_contenedor,'id_coti' => $id_coti,'tipo_embarque'=>$tipo_embarque,'pol'=>$pol,'pod1'=>$pod1,'pod2'=>$pod2, 'etd'=>$etd, 'eta'=>$eta)); } 
            else
              { $this -> md_pedido -> insertaPedido(array('id_pedido'=> $id_in,'status_track'=>$status,'correo' => $correo,'fecha_alta' => $fecha_alta,'rfc' => $rfc,'carrier' => $carrier,'shipper' => $shipper,'carta_garantia' => $carta_garantia,'carta_no' => $carta_no,'monto_carta_no'=> $monto_carta_no,'num_booking' => $num_booking,'num_mbl' => $num_mbl,'num_hbl' => $num_hbl,'vessel_voyage' => $vessel_voyage,'ins_envio' => $ins_envio,'ins_booking' => $ins_booking,'revalidar_aa'=> $revalidar_aa,'num_contenedor' => $num_contenedor,'id_coti' => $id_coti,'tipo_embarque'=>$tipo_embarque,'pol'=>$pol,'pod1'=>$pod1,'pod2'=>$pod2, 'etd'=>$etd, 'eta'=>$eta)); } 
 
         break;
		 case "PROD": 
			$num_contenedor     = $this -> input -> post('num_contenedor');
			$this -> md_pedido -> actualizaPedido($id_pedido, array('num_contenedor'=> $num_contenedor)); 

            $this -> md_producto -> delete_producto($id_pedido);
            $productos = $this -> input -> post('num_prod');

            for ($x = 0; $x <= $productos; $x++) 
            {
                $nombre    = $this -> input -> post('nombre'.$x);
                $commodity = $this -> input -> post('commodity'.$x);
                $peso  	   = $this -> input -> post('peso'.$x);
                $volumen   = $this -> input -> post('volumen'.$x);

                if($nombre != "")	
                { $this ->  md_producto -> insert_producto($id_pedido,$nombre,$commodity,$peso,$volumen); }
            }
         break;
         case "FLET": 
			$this -> md_flete -> delete_flete($id_pedido);
			$verificacion_origen = $this -> input -> post('verificacion_origen');
			$moneda              = $this -> input -> post('moneda');
            $tipo_cambio         = $this -> input -> post('tipo_cambio');
            $tipos_servicio      = $this -> md_catalogo -> poblarServicios("tipo_servicio","TS");
            $cargos              = array();
            $cargosIVA           = array();
            $terminos            = array();
			$fletes              = array();
			
            $this -> md_pedido -> delete_pedido_termino($id_pedido);
            $this -> md_pedido -> delete_pedido_cargo($id_pedido);
            $this -> md_pedido -> delete_pedido_concepto($id_pedido);

			$this -> md_pedido -> actualizaPedido($id_in,array('moneda'=> $moneda,'tipo_cambio'=>$tipo_cambio)); 
            //while (list($llave, $valor) = each($tipos_servicio)) 
			foreach($tipos_servicio as $llave => $valor)
            {
                if ($llave != 0 )
                { 
                    $numconceptos = $this -> input -> post($llave.'numconceptos');			
                    for ($x = 0; $x <= $numconceptos; $x++) 
                    {
                        $concep      = $this -> input -> post($llave.'concep'.$x);
                        $concep_dato = $this -> input -> post($llave.'concep_dato'.$x);
                        if ($concep != "")
                        { $this ->  md_pedido -> insert_pedido_concepto($concep,$concep_dato,$llave,$id_pedido);}
                    }

                    $numcargos = $this -> input -> post($llave.'numcargos');			
                    for ($x = 0; $x <= $numcargos; $x++) 
                    {
                        $cargo 	 = $this -> input -> post($llave.'cargoV'.$x);
                        $importe = $this -> input -> post($llave.'importeV'.$x);
                        $unidad  = $this -> input -> post($llave.'unidadV'.$x);
                        $iva 	 = $this -> input -> post($llave.'ivaV'.$x);
						$status  = $this -> input -> post($llave.'statusV'.$x)==""?NULL:$this -> input -> post($llave.'statusV'.$x);
                        if ($cargo != "")
                        {
							$subtotal = $importe * $unidad;
							$this->md_pedido->insert_pedido_cargo($cargo, $importe, $unidad, $subtotal, "VENTA", $iva, $llave, $status, $id_pedido);
                            if($iva == "1")
                                { $cargosIVA[] = array('servicio' => $valor,'cargo' => $cargo,'importe' => $importe); }
                            else
                                { $cargos[]    = array('servicio' => $valor,'cargo' => $cargo,'importe' => $importe); }
                        }
					}

					$numcostos = $this -> input -> post($llave.'numcostos');			
                    for ($x = 0; $x <= $numcostos; $x++) 
                    {
                        $cargo 	 = $this -> input -> post($llave.'cargoC'.$x);
                        $importe = $this -> input -> post($llave.'importeC'.$x);
                        $unidad  = $this -> input -> post($llave.'unidadC'.$x);
                        $iva 	 = $this -> input -> post($llave.'ivaC'.$x);
                        if ($cargo != "")
                        {
							$subtotal = $importe * $unidad;
							$this->md_pedido->insert_pedido_cargo($cargo, $importe, $unidad, $subtotal, "COSTO", $iva, $llave, NULL, $id_pedido);
                            if($iva == "1")
                                { $cargosIVA[] = array('servicio' => $valor,'cargo' => $cargo,'importe' => $importe); }
                            else
                                { $cargos[]    = array('servicio' => $valor,'cargo' => $cargo,'importe' => $importe); }
                        }
                    }

                    $numterminos  = $this -> input -> post($llave.'numterminos');			
                    for ($x = 0; $x <= $numterminos; $x++) 
                    {
                        $termino      = $this -> input -> post($llave.'termino'.$x);								
                        $termino_dato = $this -> input -> post($llave.'termino_dato'.$x);
                        if ($termino != "")
                        {
                            $this ->  md_pedido -> insert_pedido_termino($termino,$termino_dato,$llave,$id_pedido);
                            if($x == 0)
                                { $termino_dato = $this->md_catalogo->traeDescOpcion($this -> input -> post($llave.'termino_dato'.$x)); }
                            $terminos[] = array('servicio' => $valor,'termino' => $termino,'termino_dato' => $termino_dato);
                        }
                    }												
                }
             $this->guardaProfitAX($id_in,"FLET");   
            }
         break;
         case "DAA":            
             
         break;     
         case "TRAN": 
            $this ->  md_seguro     -> delete_seguro($id_pedido);
            $this ->  md_transporte -> delete_transporte($id_pedido);
            $costoSeg  = $this -> input -> post('costo_s');
            $cobertura = $this -> input -> post('cobertura');
            $ivaSeg    = $this -> input -> post('iva_s');
            $ventaSeg  = $this -> input -> post('venta_s');

            $this ->  md_seguro -> insert_seguro($id_pedido,$costoSeg,$ventaSeg,$ivaSeg,$cobertura);
            if($ventaSeg != NULL)
            {
                if($ivaSeg == "1")
                    { $cargosIVA[] = array('servicio' => ' ','cargo' => 'SEGURO','importe' => $ventaSeg); }
                else
                    { $cargos[]    = array('servicio' => ' ','cargo' => 'SEGURO','importe'  => $ventaSeg); }
            }

            $regreso_vacio    = $this -> input -> post('regreso_v');
            $costo            = $this -> input -> post('costo_tt');	
            $salida_puerto    = $this -> input -> post('salida_puerto');
            $maniobras        = $this -> input -> post('maniobras');
            $contacto_almacen = $this -> input -> post('contacto_almacen');
            $entrega          = $this -> input -> post('entrega');	
            $iva              = $this -> input -> post('iva_tt');
            $venta            = $this -> input -> post('venta_tt');            

            if($venta != NULL)
            {
                if($iva == "1")
                { $cargosIVA[] = array('servicio' => ' ','cargo' => 'TRANSPORTE','importe' => $venta); }
                else
                { $cargos[]    = array('servicio' => ' ','cargo' => 'TRANSPORTE','importe'=> $venta); }
            }
            
            $this ->  md_transporte -> insert_transporte($id_pedido,$regreso_vacio,$costo,$venta,$iva,$salida_puerto,$maniobras,$contacto_almacen,$this->utils->senniDateFormat($entrega));
            
            $this->guardaProfitAX($id_in,"TRAN");
         break;
         case "TRAC": 
            $movs             = $this->input->post('num_track');            
            $mandarPrefactura = FALSE;
			$mandarRetro      = FALSE; 
			$mandarNoti       = FALSE;
			$notiStatus       = array();
            
            $this ->  md_rastreo -> delete_rastreo($id_pedido);

            for ($x = 0; $x <= $movs; $x++) 
            {
				$status = $this->input->post('status'.$x);
                if($status != "" & $status != "0")
					{ 
						$fecha_r       = $this->utils->senniDateFormat( $this->input->post('fecha_r'.$x) ); 
   	            		$descripcion   = $this->input->post('descripcion'.$x);
                		$observaciones = $this->input->post('observaciones'.$x);
						$noti 	 	   = $this->input->post('noti_track'.$x) != "1" ? "0" : "1";
						$notiStatus[]  = array('status'=> $status,'fecha_r' => $fecha_r,'descripcion' => $descripcion,'observaciones'=> $observaciones,'noti'=>$noti);
						$this->md_rastreo->insert_rastreo($id_pedido,$status,$descripcion,$fecha_r,$observaciones,$noti); 
					}
            }            
            $this -> md_pedido -> actualizaPedido($id_in,array('status_track'=>$status,'fecha_modificacion' => $fecha_alta));
            
            if ($mandarPrefactura == TRUE)
            {
                $encabezado    = array();
                $encabezado[0] = array('id_pedido' => $id_pedido,'vessel_voyage' => $vessel_voyage, 'mbl' => $num_mbl,'hbl' => $num_hbl,'moneda'=> $moneda);
                $this -> mandaPrefactura($rfc,$correo,$encabezado,$fletes,$terminos,$cargos,$cargosIVA);
            }

            if ($mandarRetro == TRUE)
            {
                $cliente = $this->md_cliente->traeDetalleClientePorEn($rfc,"clientes","c","*");
                $this->mandarCorreoRetro($id_pedido,$cliente[0]['razon_social'],$cliente[0]['correo'],$correo,"clientes@senni.com.mx");
			}
			
         break;
         case "PROF": 
             $this->guardaProfitAX($id_in,"");             
         break;
        }	
echo json_encode(array("id_in"=>$id_in,"accion"=>$accion,"forma"=>$forma));                 
} catch (Exception $e) { log_message('error', 'guardar pedido Excepción:'.$e->getMessage()); }	
}

private function guardaProfitAX($id_in,$forma)
{
 try
 { 
    $profit_origen	= $this -> input -> post('profit_origen'.$forma);
    $profit             = $this -> input -> post('profit_c'.$forma);
    $costo_tot          = $this -> input -> post('costo_t'.$forma);
    $venta_tot          = $this -> input -> post('venta_t'.$forma);
    $comision_ventas   = $this -> input -> post('comision_ventas'.$forma);
    $comision_operaciones = $this -> input -> post('comision_operaciones'.$forma);
    $this -> md_pedido -> actualizaPedido($id_in,array('profit_origen'=>$profit_origen,'profit' => $profit,'costo_tot' => $costo_tot,'venta_tot' => $venta_tot,'comision_ventas' => $comision_ventas,'comision_operaciones' => $comision_operaciones));
 } catch (Exception $e) {echo ' guardar Excepción: ',  $e, "\n";}
}

public function generarPrefacturaPDFAX()
{
 try
 {
	$this->load->model('md_flete');	
	$this->load->model('md_seguro');
	$this->load->model('md_transporte');
	$this->load->model('md_cliente');
	$this->load->model('md_catalogo');
	$this->load->model('md_pedido');
	
	$id_pedido     = $this -> input -> post('id_pedidoFLET');	
	$num_mbl       = $this -> input -> post('num_mblFLET');
	$num_hbl       = $this -> input -> post('num_hblFLET');
	$vessel_voyage = $this -> input -> post('vessel_voyageFLET');	
	$moneda	       = $this -> input -> post('monedaFLET');
	$rfc           = $this -> input -> post('rfcFLET');
	$encabezado    = array();
	$cargos        = array();
	$cargosIVA     = array();
	$terminos      = array();
	$fletes        = array();	
	$encabezado[0] = array('id_pedido'  	=> $id_pedido,
                                'vessel_voyage' => $vessel_voyage,							   
                                'mbl'  		=> $num_mbl,
                                'hbl'  		=> $num_hbl,
                                'moneda'  	=> $moneda
                               );
	$this->user 	= $this->session->userdata('datos_sesion');		
	$correo 	    = element('correo', $this->user['0']); 						   
						   
	$cliente    = $this->md_cliente->traeDetalleClientePorEn($rfc,"clientes","c","*");		
						
	$datosSL    = $this->md_pedido->traeDatosSL();
	$cuentasSL  = $this->md_pedido->traeCuentasSL($datosSL[0]['rfc']);
		
	$tipos_servicio 	 = $this -> md_catalogo  -> poblarSelect("tipo_servicio");
		
	//while (list($llave, $valor) = each($tipos_servicio)) 
	foreach($tipos_servicio as $llave => $valor)
	{
		if ($llave != 0 & $llave <= 66)
		{
			$etd = $this -> input -> post($llave.'etd');
			$eta = $this -> input -> post($llave.'eta');
			if (!empty($etd) & !empty($eta))							
				$fletes[] =	array('servicio'    => $valor,
									'id_servicio' => $llave,
									'etd'         => $this -> input -> post($llave.'etd'),
									'eta'         => $this -> input -> post($llave.'eta')
									);			 							
						
			$numcargos = $this -> input -> post($llave.'numcargos');			
			for ($x = 0; $x <= $numcargos; $x++) 
			{
				$cargo 	 = $this -> input -> post($llave.'cargo'.$x);
				$importe = $this -> input -> post($llave.'importe'.$x);
				$costo 	 = $this -> input -> post($llave.'costo'.$x);
				$iva 	 = $this -> input -> post($llave.'iva'.$x);			 

				if ($cargo != "")				
					if($iva == "1")
						$cargosIVA[] = array('servicio' => $valor,
											 'cargo'    => $cargo,
                                             'importe'  => $importe
                                             );
					else
						$cargos[] = array('servicio' => $valor,
                                          'cargo'    => $cargo,
								  	 	  'importe'  => $importe
                                                                  );				
			}

			$numterminos  = $this -> input -> post($llave.'numterminos');			
			for ($x = 0; $x <= $numterminos; $x++) 
			{
				$termino 	  = $this -> input -> post($llave.'termino'.$x);
				if($x == 0)
					$termino_dato = $this->md_catalogo->traeDescOpcion($this -> input -> post($llave.'termino_dato'.$x));
				else
					$termino_dato = $this -> input -> post($llave.'termino_dato'.$x);
				if ($termino != "")			
					$terminos[] = array('servicio' 	   => $valor,
							    		'id_servicio'  => $llave,
										'termino'      => $termino,
										'termino_dato' => $termino_dato
							  			);				
			}
															
		}
	}

	$iva   = $this -> input -> post('iva_tt');
	$venta = $this -> input -> post('venta_tt');
	if($venta != NULL & $venta > 0)
		if($iva == "1")
			$cargosIVA[]= array('servicio' => ' ',
					    		'cargo'    => 'TRANSPORTE',
                                'importe'  => $venta
					            );
		else
			$cargos[] = array('servicio' => ' ',
					  		  'cargo'    => 'TRANSPORTE',
					  		  'importe'  => $venta
					  		 );	
							 
	$iva  			= $this -> input -> post('iva_s');
	$venta  		= $this -> input -> post('venta_s');
	if($venta != NULL & $venta > 0)
		if($iva == "1")
			$cargosIVA[] = array('servicio' => ' ',
								'cargo'    => 'SEGURO',
								'importe'  => $venta
                                            );
		else
			$cargos[] = array('servicio' => ' ',
								'cargo'    => 'SEGURO',
								'importe'  => $venta
					 );

	$preFactura = $this->generarPDF_Prefactura($encabezado,$fletes,$terminos,$cargos,$cargosIVA,$cliente,$datosSL,$cuentasSL);						   
	 
	 echo json_encode(array("preFactura"   => $preFactura['filename']));

 } catch (Exception $e) {json_encode( 'PREFACTURA generarPDFAX Excepción: ',  $e->getMessage());}	
}

public function downloadPF($filename)
	{
		$this->load->helper('download');			

		$data = file_get_contents("./".$this->output_dir.$fileName."/prefactura/".$filename);

		force_download($filename, $data);	
	}

public function	borraPFAX()
{
		
	$fileName = $this -> input -> post('nombreArchivo');
	$dir 	  = $this->output_dir."prefactura/";	
	$filePath = $dir . $fileName . '.pdf';
	
	if (file_exists($filePath)) 		
		unlink($filePath);		
}

public function borrar($num_guia=0)
{		

try{
	$this->validaSS();
	$this ->  md_pedido -> borra_pedido($num_guia);	
	
	$this->pg_pedidos(0,". Embarque con referencia SENNI <strong>".$id_pedido.'</strong> elimando exit&oacute;samente!');
	} catch (Exception $e) {echo 'editar PEdido Excepción: ',  $e->getMessage(), "\n";}

}

public function detalle($num_guia=0,$noti="",$tipoN="")
{	
	$this->validaSS();	
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics",							 
							 "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
							 "frase"     => "Servicios Integrales Especializados en Log&iacute;stica",
							 "titulo"    => "Detalle del Embarque con referencia SENNI: <strong>".$num_guia."</strong>");
	
	
	$data['usuario'] = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	
	if ($noti != "")
	{
		$data['noti'] = $noti;
		$data['tipoN'] = $tipoN;
		$this -> md_pedido -> notificacionRevisada($num_guia,element('correo', $this->user['0']));
		 
	}
			
	$data['pedido'] = $this->traeDetallePedido($num_guia,$this -> md_catalogo -> poblarSelect("tipo_servicio"));
	$data['ligaCoti'] = '<a href="'.base_url().'cotizador/editar/'.$data['pedido']['encabezado'][0]['id_coti'].'" >cotización</a>';
		
	$this->load->view('vw_lg_detalle_ped',$data);

}


public function consulta($mensajeConfirm="")
{
    $this->load->model('md_proveedor');
    try{
        $this->validaSS();
	
	$param = array("titulo"          => "Bandeja de Embarques ".$mensajeConfirm,
                       "colBandeja"      => array(' ','Referencia SENNI','Status','Cliente', 'Gu&iacute;a Master','Adjuntos','Acciones'),
                       "registrosPagina" => $this->registros_x_pagina,
                       "controlador"     => "pedido",
                       "numColGrid"      => "6",
                       "formaId"         => "filtrosPed",
                       "f1Label"         => "Referencia SENNI",
                       "f1Image"         => "fa fa-truck",
                       "f2Label"         => "Guía Master",
                       "f2Image"         => "fa fa-folder-open",
                       "f3Label"         => "Guía House",
                       "f3Image"         => "fa fa-folder",
                       "f4Label"         => "Status",
                       "f4Select"        => $this -> md_catalogo  -> poblarSelect("status"),
                       "f5Label"         => "Cliente",
                       "f5Select"        => $this -> md_cliente   -> poblarSelect(),
                       "f6Label"         => "Carrier",
                       "f6Select"        => $this -> md_proveedor -> poblarSelect("0"),                                   
                       "f7Label"         => "Moneda",
                       "f8Label"         => "Profit",
                       "accion"          => "nuevo",
                       "tipo"            => "Embarque",
					   "mensajeConfirm"  => $mensajeConfirm
                      );
       
        $data = $this->createFilter($param);				  				        	     
            
        $this->load->view('vw_lg_fil_pag',$data);
      } catch (Exception $e) {echo ' consulta Excepción: ',  $e->getMessage(), "\n";}	
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
            $f5       = $this -> input -> post('f5');
            $f6       = $this -> input -> post('f6');
            $f7       = $this -> input -> post('f7');
            $deF8     = $this -> input -> post('deF8');
            $aF8      = $this -> input -> post('aF8');

            $grid = $this -> md_pedido-> traePedidosFiltros($this->registros_x_pagina,$pagina,$f1,$f2,$f3,$f4,$f5,$f6,$f7,$fechaIni,$fechaFin,$deF8,$aF8);
            
            echo json_encode ($grid);                          
            
        } catch (Exception $e) {echo ' paginarAX Excepción: ',  $e->getMessage(), "\n";}		
    }
	
public function pg_pedidos($offset=0, $mensajeConfirm="")
{	
	$this->validaSS();
	$this -> load -> library('pagination');
	$data['titulos'] = array("navegador" => "Portal SENNI Logistics",
                                "titulo"    => "Bandeja de Embarques ".$mensajeConfirm, 
                                "ventana"   => "Rompiendo Barreras, Cumpliendo tus Metas",
                                "frase"     => "Servicios Integrales Especializados en Log&iacute;stica");
	
	$this->user 	  = $this->session->userdata('datos_sesion');
	$data['usuario']  = element('nombre', $this->user['0'])." ".element('apellidos', $this->user['0']);
	$data['iconuser'] = '<img src="'.base_url().'images/user.png"/>';
	$tipo_u 	  =  "".element('tipo', $this->user['0']);
			  			
	if ($tipo_u == "A" )
           { $tipo_u = ""; }
	else
	   { $tipo_u= element('correo', $this->user['0']); }
	
	$url_a_paginar = '/pedido/pg_pedidos/';
	$registros_x_pagina = 10;		
					   	
	$pedidos = $this -> md_pedido -> traePedidos($tipo_u,$registros_x_pagina,$offset);
	
	$config['base_url']   = base_url().$url_a_paginar;
	$config['total_rows'] = $pedidos["conteo"];
	
	$config['per_page']   = $registros_x_pagina;
	$config['num_links']  = 5;
	
	$this -> pagination -> initialize($config);					
                    
	$data['links']   = $this -> pagination -> create_links();	
	$tmpl = array ( 'table_open'  => '<table id="datagrid" class="display compact" cellspacing="0" width="100%">' );
	$this->table->set_template($tmpl);
	 
	$header = array(' ','Referencia SENNI','Status','Cliente', 'Gu&iacute;a Master', 'Adjuntos','Acciones');
	$this -> table -> set_heading($header);	
	$x = $offset;
	
	foreach($pedidos["registros"] as $row)
	{
		$x = $x + 1;

	 	$celda1 = array('data'  => $x,'align'=>"center");		
	 	$celda2 = array('data'  => $row['id_pedido'],'align'=>"center");
		$celda3 = array('data'  => $this->utils->revisaValorVacio($row['status']),'align'=>"left");
		$celda4 = array('data'  => $this->utils->revisaValorVacio($row['razon_social']),'align'=>"left",'width'=>"200px");
		$celda6 = array('data'  => $this->utils->revisaValorVacio($row['num_mbl']),'align'=>"left",'width'=>"130px");
		$celda10 = array('data' => array() );
	 	$celda11 = array('data' => '<a href="'.base_url().'pedido/detalle/'.$row['id_pedido'].'">
								   <img title="Detalle Embarque" src="'.base_url().'images/detail.png" width="20px"></a>
								   &nbsp;'.
								   '<a href="'.base_url().'pedido/editar/'.$row['id_pedido'].'">
								   <img title="Editar Embarque" src="'.base_url().'images/edit.png" width="20px"></a>
								   &nbsp;'.
								   '<img class="boton_confirm" title="Borrar Embarque" id="'.$row['id_pedido'].'" 
								   src="'.base_url().'/images/erase2.png" width="20px">'
								   ,'align'=>"center");
										
		$this->table->add_row(array($celda1,
                                            $celda2,
                                            $celda3,
                                            $celda4,
                                            $celda6,
                                            $celda10,
                                            $celda11
                                           )
                                      );
	}

   $data['accion'] 	= "nuevo";
   $data['tipo'] 	= "Embarque";
   $data['controlador'] = "pedido";
   $data['orden'] 	= "desc";	
   $this->load->view('vw_lg_consulta',$data);
}


public function	agregaArchivoAdjuntoAX()
{
	if(isset($_FILES["myfile"]))
	{
		$ret = array();		
		$error =$_FILES["myfile"]["error"];
		//You need to handle  both cases
		//If Any browser does not support serializing of multiple files using FormData() 
		if(!is_array($_FILES["myfile"]["name"])) //single file
		{
			$fileName = $_FILES["myfile"]["name"];
			move_uploaded_file($_FILES["myfile"]["tmp_name"],$this->output_dir.$fileName);
			
			$ret[]= $fileName;
		}
		else  //Multiple files, file[]
		{
		  $fileCount = count($_FILES["myfile"]["name"]);
		  for($i=0; $i < $fileCount; $i++)
		  {
			$fileName = $_FILES["myfile"]["name"][$i];
			move_uploaded_file($_FILES["myfile"]["tmp_name"][$i],$this->output_dir.$fileName);
			$ret[]= $fileName;
		  }
		
		}
		echo json_encode($ret);
	 }
}


public function	borraArchivoAdjuntoAX()
{

	if(isset($_POST["op"]) && $_POST["op"] == "delete" && isset($_POST['name']))
	{
		$fileName =$_POST['name'];
		$filePath = $this->output_dir. $fileName;
		if (file_exists($filePath)) 		
			unlink($filePath);
		
		echo "Deleted File ".$fileName."<br>";
	}
}

public function	renombraAdjuntoAX()
{	
try{	
	$extension     	   = $this -> input -> post('extension');
	$nombreArchivo 	   = $this -> input -> post('nombreArchivo');
	$id_pedido     	   = $this -> input -> post('id_pedido');
	$tipoDoc           = $this -> input -> post('tipoDoc');
	$nombreTipoArchivo = $this->utils->generaNombrePDF($this -> input -> post('nombreTipoArchivo')); 
	$desc_adjunto 	   = $this -> input -> post('nombreTipoArchivo');

	$nombreArchivo = $nombreArchivo.".".$extension;
	$nombreSenni   = $nombreTipoArchivo.'_'.$id_pedido.".".$extension;
    $pathFile      = $this->output_dir.$id_pedido.'/'.$nombreSenni;
        
	if (file_exists($this->output_dir.$id_pedido) == FALSE)
	   { mkdir($this->output_dir.$id_pedido, 0755); 	  }    
	
	$r = rename ($this->output_dir.$nombreArchivo, $pathFile);		
	$id_adjunto = $this->md_pedido->insert_pedido_adjunto( array('adjunto'=>$pathFile,'SEGURIDAD'=>$tipoDoc,'desc_adjunto'=>$desc_adjunto,'id_pedido'=>$id_pedido) );
                
	echo json_encode (array("nombreSenni" => $nombreSenni,
							"id_pedido"   => $id_pedido,
							"tipoDoc"     => $tipoDoc,
							"desc_adjunto"=> $desc_adjunto,
							"id_adjunto"  => $id_adjunto,
							"result"      => $r  
							));
	
	} catch (Exception $e) {echo 'renombraAdjuntoAX Excepción: ',  $e->getMessage(), "\n";}	
}

public function	borraAdjuntoCargadoAX()
{	
try{	
	$extension     = $this -> input -> post('extension');
	$nombreArchivo = $this -> input -> post('nombreArchivo');
	$id_pedido     = $this -> input -> post('id_pedido');
	$opcionTA      = $this -> input -> post('opcionTA');
        $id_adjunto    = $this -> input -> post('id_adjunto');
	
	$nombreArchivo = $nombreArchivo.".".$extension;
	$filePath      = (strpos($nombreArchivo, 'adjunto') === 0)? $nombreArchivo : $this->output_dir.$id_pedido.'/'.$nombreArchivo;

	if (file_exists($filePath) )
           { unlink($filePath);	   }
        if ( $id_adjunto =='0')
            { $campo ="";
                switch (true) { case (strpos($nombreArchivo, "MBL")!== false) : $this->md_pedido->actualizaPedido($id_pedido,array("adjunto_mbl" => NULL)); break;     
                                case (strpos($nombreArchivo, "HBL")!== false) : $this->md_pedido->actualizaPedido($id_pedido,array("adjunto_hbl" => NULL)); break;     
                                case (strpos($nombreArchivo, "Factura_Producto")!== false) : $this->md_pedido->actualizaPedido($id_pedido,array("adjunto_facturaP" => NULL));  break;     
                                case (strpos($nombreArchivo, "Lista_")!== false) : $this->md_pedido->actualizaPedido($id_pedido,array("adjunto_le" => NULL));  break;     
                                case (strpos($nombreArchivo, "Poliza")!== false) : $this->md_pedido->actualizaPedido($id_pedido,array("adjunto_poliza" => NULL));  break;     
                                case (strpos($nombreArchivo, "Factura_SENNI")!== false) : $this->md_pedido->actualizaPedido($id_pedido,array("adjunto_factura" => NULL));  break;     
                              }               
            }
        else
            { $this->md_pedido->delete_pedido_adjunto($id_pedido, $id_adjunto); }
        
	echo json_encode (array("opcionTA" => $opcionTA, 'id_pedido'=>$id_pedido, 'id_adjunto'=>$id_adjunto));
	
	} catch (Exception $e) {echo 'renombraAdjuntoAX Excepción: ',  $e->getMessage(), "\n";}	
}



public function	datosTimbrarAX($portal=NULL)
{	

try{$this->load->model('md_pedido' );
	$this->load->model('md_cliente');
	$this->load->model('md_catalogo');
	
	$id_pedido  = $this->input->post('id_pedido');	

	$rfcCliente = $this->input->post('rfc');
	$conceptos = $this->md_pedido  ->traeCargosTimbrarAX($id_pedido);	
	$moneda    = $this->md_pedido  ->traeMonedaTimbrarAX($id_pedido);
	$cliente   = $this->md_cliente ->traeDatosFiscales($rfcCliente);    
	
	$emisior   = $this->md_catalogo->traeDatosFiscales(($portal == NULL ? RFC : RFC_SENNI), "rfc, nombre_fiscal, domicilio_fiscal, cp_fiscal, correo_fiscal");
	$adjuntoFac= $this->md_pedido  ->traeAdjuntosFacturaREP($id_pedido);	
	$factura   = $this->md_sat 	   ->traeFacturaVistaPreviaById($id_pedido);
	$cfdiRel   = $this->md_sat 	   ->traeFacturaCfdiRelById($id_pedido);

	if(empty($factura)) 
		 {	$vp = NULL;
			$facturaCon = array(); 
		 } 
	else {
			$vp = $factura['uuid'];
			$facturaCon = $this->md_sat->traeFacturaConceptosById($factura['id_factura'] );
		 } 	

	$facturaREP = $this->md_sat->traeFacturaPagosByIdPedido($id_pedido);	
	
	 
	echo json_encode( array( "cliente"   => $cliente
							,"conceptos" => $conceptos
							,"moneda"	 => $moneda
							,"emisor"	 => $emisior 
							,"adjuntoFac"=> $adjuntoFac
							,"factura"	 => $factura
							,"facturaCon"=> $facturaCon
							,"facturaREP"=> $facturaREP
							,"cfdiRel"   => $cfdiRel
							,"dir"		  =>$this->output_dir.$id_pedido.'/cfdi/'
							,"vistaprevia"=>($vp == NULL ? "1":"0")
						   )
					);
	
	} catch (Exception $e) { log_message('error', 'datosTimbrarAX Excepción:'.$e->getMessage()); }	
}

public function	timbrarAX($id_pedido=0, $action="")
{	
try{$this->load->model('md_pedido' );
	$this->load->model('md_cliente');
	$this->load->model('md_catalogo');
	$this->load->model('md_sat');	

	$this->load->library('Pdf');	

	$this->load->helper('file');
	$this->load->helper('date');

	$regimen_fiscal  	   = $this->input->post('regimen_fiscal');
	$numConceptosConCveSAT = $this->input->post('numConceptosConCveSAT');
 
	$dbFiscal 			  = $this->md_catalogo->traeDatosFiscales(RFC, null);
	$tipoComprobante	  = $this->md_sat->traeTipoComprobanteSAT(TIPOCOMP_FACT);
	$impuesto			  = $this->md_sat->traeImpuestoSAT(IMPUESTO);
	
	$flagTasaSinIVA			 = FALSE;
	$flagTasaIVA			 = FALSE;
	$ImpuestoTransTasaIVA    = 0;
	$ImpuestoTransTasaSinIVA = 1;

	$dbFiscal['dir_cfdi'] = $this->output_dir . $id_pedido . "/";
	
	$fe_yymmdd = $this->utils->arrayDateFormat( $this->input->post('fecha_expedicion') ); 
	$date = new DateTime();	
	$date->setDate($fe_yymmdd['year'], $fe_yymmdd['month'], $fe_yymmdd['day']);
	$fechaExpedicion = $date->format('Y/m/d\TH:i:s'); 
 
	$resp     = null;	
	if (file_exists($dbFiscal['dir_cfdi']) == FALSE)
       { mkdir($dbFiscal['dir_cfdi'], 0755); 	   } 

    if ( file_exists($dbFiscal['dir_cfdi']) == FALSE  )
	   { 
		 mkdir($dbFiscal['dir_cfdi'], 0755); 
		 $dbFiscal['dir_cfdi'] = $dbFiscal['dir_cfdi']."cfdi/";
		 mkdir($dbFiscal['dir_cfdi'], 0755);	  	  
	   }
	else{ $dbFiscal['dir_cfdi'] = $dbFiscal['dir_cfdi']."cfdi/";
		  if ( file_exists($dbFiscal['dir_cfdi']) == FALSE  )
	   	  	 { mkdir($dbFiscal['dir_cfdi'], 0755); 			}
	    }       
	$datos['dir_cfdi']     = $dbFiscal['dir_cfdi'];
    $datos['version_cfdi'] = '3.3';
    // Ruta del XML Timbrado
    $datos['cfdi'] = $dbFiscal['dir_cfdi'].$dbFiscal['rfc'].'_cfdi3_3.xml'; //APPPATH.'third_party/sdk2/timbrados/cfdi_ejemplo_factura.xml'; ; 
    // Ruta del XML de Debug
    $datos['xml_debug'] = APPPATH.'third_party/sdk2/timbrados/sin_timbrar_ejemplo_factura.xml';

    // Credenciales de Timbrado
    $this->configTimbrado['PAC']['usuario']    = $dbFiscal['PAC_USUARIO'];
    $this->configTimbrado['PAC']['pass']       = $dbFiscal['PAC_PWD'];
    $this->configTimbrado['PAC']['produccion'] = PROD_FAC;

    // Rutas y clave de los CSD
    $this->configTimbrado['conf']['cer']  = APPPATH.'third_party/sdk2/certificados/'.$dbFiscal['CSD_CER'];
    $this->configTimbrado['conf']['key']  = APPPATH.'third_party/sdk2/certificados/'.$dbFiscal['CSD_KEY'];
    $this->configTimbrado['conf']['pass'] = $dbFiscal['CSD_PWD'];

    // Datos del Emisor
    $this->configTimbrado['emisor']['rfc']    		 = $dbFiscal['rfc'];
    $this->configTimbrado['emisor']['nombre']		 = $dbFiscal['nombre_fiscal'];    

	// Datos de la Factura
	$datos['id_factura'] = $this->input->post('id_factura')==NULL ? now() : $this->input->post('id_factura'); 
	$datos['id_pedido']  = $id_pedido;
	$datos['factPDF']    = array();	
		
	$datos['factura']['LugarExpedicion']  = $dbFiscal['cp_fiscal'];//'77712';		
	$datos['factura']['RegimenFiscal']    = $this->input->post('regimen_fiscal');//'601';
	$datos['factPDF']['RegimenFiscalDesc']= $this->md_sat->traeDescRegimenFiscal($this->input->post('regimen_fiscal'));		

	if($action == "vistaprevia" || $action == "timbrar") // FACTURA
	{		
		$datos['factura']['folio']            = $action == "vistaprevia"? "0" : "";	
		$datos['factura']['fecha_expedicion'] = $this->utils->dateExpFactura($fechaExpedicion);//$fechaExpedicion;//date('Y-m-d\TH:i:s', time() - 120);
		$datos['factura']['descuento']        = $this->input->post('descuentoSAT');//'0.00';
		$datos['factPDF']['notas']            = $this->input->post('notasFactura');//249.99;
		$datos['factura']['forma_pago']       = $this->input->post('forma_pago');//'04';
		$datos['factura']['forma_pagoDesc']   = $this->md_sat->traeFormaPagoDesc( $this->input->post('forma_pago') );
		$datos['factura']['metodo_pago']      = $this->input->post('metodo_pago');//'PUE';
		$datos['factura']['metodo_pagoDesc']  = $this->md_sat->traeMetodoPagoDesc( $this->input->post('metodo_pago') );
		$datos['factura']['moneda']           = $this->input->post('monedaSAT');//'MXN';
		$datos['factura']['serie']            = SERIE_SAT;//'A';
		$datos['factura']['subtotal']         = $this->input->post('subtotalSAT');//215.51;
		$datos['factura']['tipocambio']       = $this->input->post('tcSAT');//1;
		$datos['factura']['tipocomprobante']  = substr($tipoComprobante['sat_TipoDeComprobante'], 0, 1);	
		$datos['factPDF']['tipocomprobanteDesc']= $tipoComprobante['Descripcion']; 
		$datos['factura']['total']            = $this->input->post('totalSAT');//249.99;
		$datos['factPDF']['totalConLetras']   = $this->utils->convertNumToChar( $this->input->post('totalSAT') );
		
		// Datos del Receptor
		$datos['receptor']['rfc']      = $this->input->post('rfcReceptor');//'SOHM7509289MA';
		$datos['receptor']['nombre']   = $this->input->post('rsReceptor');//'Pu&blico en General';
		
		// Datos de los conceptos			
		$y = -1;
		for ($x = 0; $x <= $numConceptosConCveSAT; $x++) 
			{	
				$concep = $this->input->post('conSATCodigo'.$x);
				
				if($concep != "")	
					{ 
						$y++;
						$impConcepto = $this->input->post('conSATsubtot'.$x);						

						$datos['conceptos'][$y]['cantidad']      = $this->input->post('conSATCantidad'.$x);
						$datos['conceptos'][$y]['unidad']        = $this->input->post('conSATUM'.$x); //'PIEZA';
						$datos['conceptos'][$y]['ID']            = $this->input->post('conSATID'.$x);//"M7390Z";
						$datos['conceptos'][$y]['descripcion']   = $this->input->post('conSATCargo'.$x);
						$datos['conceptos'][$y]['valorunitario'] = $this->input->post('conSATValorUni'.$x);//215.51;
						$datos['conceptos'][$y]['importe']       = $impConcepto;
						$datos['conceptos'][$y]['ClaveProdServ'] = $this->input->post('conSATCodigo'.$x);						
						$datos['conceptos'][$y]['ClaveUnidad']   = $this->input->post('conSATCveUnidad'.$x);
						
						$datos['pdfconceptos'][$y]['cantidad']      = $this->input->post('conSATCantidad'.$x);
						$datos['pdfconceptos'][$y]['unidad']        = $this->input->post('conSATUM'.$x); //'PIEZA';
						$datos['pdfconceptos'][$y]['ID']            = $this->input->post('conSATID'.$x);//"M7390Z";
						$datos['pdfconceptos'][$y]['descripcion']   = $this->input->post('conSATCargo'.$x);
						$datos['pdfconceptos'][$y]['valorunitario'] = $this->input->post('conSATValorUni'.$x);//215.51;
						$datos['pdfconceptos'][$y]['importe']       = $impConcepto;
						$datos['pdfconceptos'][$y]['ClaveProdServ'] = $this->input->post('conSATCodigo'.$x);
						$datos['pdfconceptos'][$y]['ClaveUnidad']   = $this->input->post('conSATCveUnidad'.$x);
						$datos['pdfconceptos'][$y]['sumaIVA']   	= $this->input->post('conSATIVA'.$x);
						
						//Datos de Impuestos
						if($this->input->post('conSATIVA'.$x) == "1")
						{
							$flagTasaIVA    = TRUE;
							$tasa['Factor'] = 'Tasa';
							$tasa['sat_TasaOCuota_Valor_Maximo'] = TASA_IVA;
							$ivaConcepto = $this->utils->toFixed( floatval($tasa['sat_TasaOCuota_Valor_Maximo']) * $impConcepto, 2);
							$ImpuestoTransTasaIVA += $ivaConcepto;

						} 
						else
						{
							$flagTasaSinIVA = TRUE;
							$tasa['Factor'] = 'Tasa';
							$tasa['sat_TasaOCuota_Valor_Maximo'] = TASA_IVA_CERO;							
							$ivaConcepto = '0.00';
						}
						//Datos de Impuestos
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['Base']       = $impConcepto;
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['Impuesto']   = $impuesto['sat_Impuesto'];//'002';
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['TipoFactor'] = $tasa['Factor'];//'Tasa';
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['TasaOCuota'] = $tasa['sat_TasaOCuota_Valor_Maximo'];//'0.160000';
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['Importe']    = $ivaConcepto;

						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['Base']       = $impConcepto;
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['Impuesto']   = $impuesto['sat_Impuesto'];//'002';
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['TipoFactor'] = $tasa['Factor'];//'Tasa';
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['TasaOCuota'] = $tasa['sat_TasaOCuota_Valor_Maximo'];//'0.160000';
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['Importe']    = $ivaConcepto;//34.48;											
					}
			}	
		// Se agregan los Impuestos FACTURA	
		if($flagTasaIVA == TRUE)
		{
			$datos['impuestos']['translados'][0]['impuesto']   = $impuesto['sat_Impuesto'];
			$datos['impuestos']['translados'][0]['tasa'] 	   = TASA_IVA;
			$datos['impuestos']['translados'][0]['importe']    = $this->utils->toFixed($ImpuestoTransTasaIVA,2 );
			$datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';
		}
		if($flagTasaSinIVA == TRUE)
		{
			$datos['impuestos']['translados'][1]['impuesto']   = $impuesto['sat_Impuesto'];
			$datos['impuestos']['translados'][1]['tasa']       = TASA_IVA_CERO;
			$datos['impuestos']['translados'][1]['importe']    = 0.00;
			$datos['impuestos']['translados'][1]['TipoFactor'] = 'Tasa';	
		}		
		$datos['impuestos']['TotalImpuestosTrasladados'] = $this->utils->toFixed($ImpuestoTransTasaIVA,2 );
		$datos['factPDF']['translados'][0]['base'] 	   	 = $this->utils->toFixed($ImpuestoTransTasaIVA,2 );

		// Datos del Receptor		
		$datos['receptor']['UsoCFDI']  	 = $this->input->post('uso_cfdi');//'G03';
		$datos['factPDF']['UsoCFDIDesc'] = $this->md_sat->traeDescUsosCFDI($this->input->post('uso_cfdi'));	
	}
	else //REP
	{
		$datos['rep']['parcial_rep']    	  = $this->input->post('parcial_rep');	
		$datos['rep']['fecha_rep']      	  = $this->utils->senniDateFormat( $this->input->post('fecha_rep') );
		$datos['factura']['folio']            = $datos['id_factura']."-".$datos['rep']['parcial_rep'];	
		$datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
		$datos['factura']['subtotal'] 		  = '0';
		$datos['factura']['total'] 			  = '0';
		$datos['factura']['moneda'] 		  = 'XXX';				
		$datos['factura']['serie']            = SERIE_SAT_PAGO;//'P';				
		$datos['factura']['tipocomprobante']  = SERIE_SAT_PAGO;	
		$datos['factPDF']['tipocomprobanteDesc']= TIPOCOMP_PAGO; 		
		
		// Datos del Receptor
		$datos['receptor']['UsoCFDI']  	 = 'P01';
		$datos['factPDF']['UsoCFDIDesc'] = $this->md_sat->traeDescUsosCFDI('P01');

		//REP
		$datos['rep']['moneda_rep']     = $this->input->post('moneda_rep');
		$datos['rep']['tc_rep']   	    = $this->input->post('tc_rep') == "" ? 1 : $this->input->post('tc_rep') ;
		$datos['rep']['monto_rep']      = $this->input->post('monto_rep');
		$datos['rep']['forma_pago_rep'] = $this->input->post('forma_pago_rep');		
		$datos['rep']['forma_pago_rep_desc'] = $this->md_sat->traeFormaPagoDesc( $this->input->post('forma_pago_rep') )["Descripcion"];
		$datos['rep']['facturaTipoCambio'] = $this->input->post('tcSAT');//1;
		$datos['rep']['fecha_rep']      = $this->utils->senniDateFormat( $this->input->post('fecha_rep') );		
		$datos['rep']['id_pedido']      = $id_pedido;		

		// Conceptos (valores por default)
		$datos['conceptos'][0]['ClaveProdServ'] = '84111506';
		$datos['conceptos'][0]['cantidad'] 		= '1';
		$datos['conceptos'][0]['ClaveUnidad'] 	= 'ACT';
		$datos['conceptos'][0]['descripcion'] 	= "Pago";
		$datos['conceptos'][0]['valorunitario'] = '0.0';
		$datos['conceptos'][0]['importe'] 		= '0.0';

		// Complemento de Pagos 1.0
		$datos['pagos10']['Pagos'][0]['FechaPago']	  = $this->utils->dateExpFactura($datos['rep']['fecha_rep']);
		$datos['pagos10']['Pagos'][0]['FormaDePagoP'] = $datos['rep']['fecha_rep'];
		$datos['pagos10']['Pagos'][0]['MonedaP']	  = $datos['rep']['moneda_rep'] ;
		$datos['pagos10']['Pagos'][0]['Monto']		  = $datos['rep']['monto_rep'];

		$datos['pagos10']['Pagos'][0]['NumOperacion'] 	 = $this->input->post('NumOperacion');
		$datos['pagos10']['Pagos'][0]['RfcEmisorCtaOrd'] = $this->input->post('RfcEmisorCtaOrd');
		$datos['pagos10']['Pagos'][0]['CtaOrdenante']	 = $this->input->post('CtaOrdenante');
		$datos['pagos10']['Pagos'][0]['RfcEmisorCtaBen'] = $this->input->post('RfcEmisorCtaBen');
		$datos['pagos10']['Pagos'][0]['CtaBeneficiario'] = $this->input->post('CtaBeneficiario');

		$id_factura = $this->input->post('facturaPedido');
		$factura    = $this->md_sat->traeFacturaByIdFactura($id_factura);

		$datos['receptor']['rfc']    = $factura['rfc'];
		$datos['receptor']['nombre'] = $factura['nombre'];

	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["IdDocumento"] 	 = $factura['uuid'];
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["Folio"] 			 = $factura['id_pedido'];
		$datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["Serie"] 			 = $factura['serie'];
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["MonedaDR"] 		 = $factura['moneda'];
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["MetodoDePagoDR"]   = $factura['metodo_pago'];
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["NumParcialidad"]   = $datos['rep']['parcial_rep'];
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoAnt"]      = $datos['rep']['monto_rep'] + $this->input->post('si'.$id_factura);
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpPagado"] 		 = $datos['rep']['monto_rep'];
	    $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoInsoluto"] = $this->input->post('si'.$id_factura);
	}	

	$datos['factPDF']['emailReceptor'] = $this->input->post('emailReceptor');
	$datos['factPDF']['cpReceptor']    = $this->input->post('cpReceptor');	
	
	$datos['pdf'] = $dbFiscal;	
		
	$filename = $datos['factura']['tipocomprobante']."_".$datos['factura']['serie']."_".$datos['factura']['folio'].".pdf";
//log_message('error', 'VER:'.var_export($datos, true));
	switch ($action) 
	{
	 case "vistaprevia": 			
		$datos['factura']['uuid'] = NULL;
		$datos['factura']['representacion_impresa_certificado_no'] = NULL;
		$datos['factura']['fecha_timbrado']  = NULL;
		$datos['factura']['status'] = "VPF";
		
		$this->md_sat->insert_factura_timbrada($datos);
		
		$filename = "PREFACTURA_".$filename;
		$datos['emisor']['rfc'] 	  	  = $dbFiscal['rfc'];
		$datos['emisor']['nombre_fiscal'] = $dbFiscal['nombre_fiscal'];
		$datos['emisor']['cp_fiscal'] 	  = $dbFiscal['cp_fiscal'];
		$datos['emisor']['correo_fiscal'] = $dbFiscal['correo_fiscal'];
		$this->generatePDF_Factura( $datos['dir_cfdi'] . $filename
								  , array("f" => $datos, "r" => array("archivo_png"=>"images/blank.png", "representacion_impresa_certificado_no"=>"","representacion_impresa_sello"=>"","representacion_impresa_selloSAT"=>"","representacion_impresa_certificadoSAT"=>"","representacion_impresa_cadena"=>"","folio_fiscal"=>"","fecha_timbrado"=>""  ) ) 
								  , 'vw_pdf_prefactura'
								  );
		$resp = array( "pdf"  => $filename, "dir" => $datos['dir_cfdi'], "vistaprevia"=>"1", "id_factura"=>$datos['id_factura'] );
	 break;	
	 	 
	 case "vp_rep":
			$filename = "VISTAPREVIA_REP_".$datos['factura']['folio'].".pdf";

			$datos['emisor']['rfc'] 	  	  = $dbFiscal['rfc'];
			$datos['emisor']['nombre_fiscal'] = $dbFiscal['nombre_fiscal'];
			$datos['emisor']['cp_fiscal'] 	  = $dbFiscal['cp_fiscal'];
			$datos['emisor']['correo_fiscal'] = $dbFiscal['correo_fiscal'];
			$datos['rep']['path_pdf']         = $datos['dir_cfdi'] . $filename;
			
			$this->generatePDF_Factura( $datos['rep']['path_pdf']
									  , array("p" => $datos, "r" => array("archivo_png"=>"images/blank.png", "representacion_impresa_certificado_no"=>"","representacion_impresa_sello"=>"","representacion_impresa_selloSAT"=>"","representacion_impresa_certificadoSAT"=>"","folio_fiscal"=>"","uuid"=>"" ) ) 
									  , 'vw_pdf_rep'
									  );
									  
			$resp = array( "pdf"  => $filename, "dir" => $datos['dir_cfdi']);

	 break;	 
	}

	echo json_encode( $resp );
	
	} catch (Exception $e) { log_message('error', 'timbrarAX Excepción:'.$e->getMessage()); }	
}//timbrar


public function	timbrarCfdiRelAX($id_pedido=0, $action="")
{	
try{$this->load->model('md_pedido' );
	$this->load->model('md_cliente');
	$this->load->model('md_catalogo');
	$this->load->model('md_sat');	
	$this->load->library('Pdf');	
	$this->load->helper('file');
	$this->load->helper('date');

	$regimen_fiscal  	   = $this->input->post('regimen_fiscal');
	$numConceptosConCveSAT = $this->input->post('numConceptosConCveSAT');
	$dbFiscal 			   = $this->md_catalogo->traeDatosFiscales(RFC, null);
	$tipoComprobante	   = $this->md_sat->traeTipoComprobanteSATbyTipo( $this->input->post('tipo_comprobante') );
	$impuesto			   = $this->md_sat->traeImpuestoSAT(IMPUESTO);
	
	$flagTasaSinIVA			 = FALSE;
	$flagTasaIVA			 = FALSE;
	$ImpuestoTransTasaIVA    = 0;
	$ImpuestoTransTasaSinIVA = 1;

	$dbFiscal['dir_cfdi']  = $this->output_dir . $id_pedido . "/";
	
	$fe_yymmdd = $this->utils->arrayDateFormat( $this->input->post('fecha_expedicion') ); 
	$date = new DateTime();	
	$date->setDate($fe_yymmdd['year'], $fe_yymmdd['month'], $fe_yymmdd['day']);
	$fechaExpedicion = $date->format('Y/m/d\TH:i:s'); 
 
	$resp = null;	
	if (file_exists($dbFiscal['dir_cfdi']) == FALSE)
       { mkdir($dbFiscal['dir_cfdi'], 0755); 	   } 

    if ( file_exists($dbFiscal['dir_cfdi']) == FALSE  )
	   { 
		 mkdir($dbFiscal['dir_cfdi'], 0755); 
		 $dbFiscal['dir_cfdi'] = $dbFiscal['dir_cfdi']."cfdi/";
		 mkdir($dbFiscal['dir_cfdi'], 0755);	  	  
	   }
	else{ $dbFiscal['dir_cfdi'] = $dbFiscal['dir_cfdi']."cfdi/";
		  if ( file_exists($dbFiscal['dir_cfdi']) == FALSE  )
	   	  	 { mkdir($dbFiscal['dir_cfdi'], 0755); 			}
	    }       
	$datos['dir_cfdi']     = $dbFiscal['dir_cfdi'];
    $datos['version_cfdi'] = '3.3';
    // Ruta del XML Timbrado
    $datos['cfdi'] = $dbFiscal['dir_cfdi'].$dbFiscal['rfc'].'_cfdi3_3.xml'; //APPPATH.'third_party/sdk2/timbrados/cfdi_ejemplo_factura.xml'; ; 
    // Ruta del XML de Debug
    $datos['xml_debug'] = APPPATH.'third_party/sdk2/timbrados/sin_timbrar_ejemplo_factura.xml';

    // Credenciales de Timbrado
    $this->configTimbrado['PAC']['usuario']    = $dbFiscal['PAC_USUARIO'];
    $this->configTimbrado['PAC']['pass']       = $dbFiscal['PAC_PWD'];
    $this->configTimbrado['PAC']['produccion'] = PROD_FAC;

    // Rutas y clave de los CSD
    $this->configTimbrado['conf']['cer']  = APPPATH.'third_party/sdk2/certificados/'.$dbFiscal['CSD_CER'];
    $this->configTimbrado['conf']['key']  = APPPATH.'third_party/sdk2/certificados/'.$dbFiscal['CSD_KEY'];
    $this->configTimbrado['conf']['pass'] = $dbFiscal['CSD_PWD'];

    // Datos del Emisor
    $this->configTimbrado['emisor']['rfc']    = $dbFiscal['rfc'];
    $this->configTimbrado['emisor']['nombre'] = $dbFiscal['nombre_fiscal'];    

	// Datos de la Factura
	$datos['id_factura'] = $this->input->post('id_factura')==NULL ? now() : $this->input->post('id_factura'); 
	$datos['id_pedido']  = $id_pedido;
	$datos['factPDF']    = array();	
		
	$datos['factura']['LugarExpedicion']  = $dbFiscal['cp_fiscal'];//'77712';		
	$datos['factura']['RegimenFiscal']    = $this->input->post('regimen_fiscal');//'601';
	$datos['factPDF']['RegimenFiscalDesc']= $this->md_sat->traeDescRegimenFiscal($this->input->post('regimen_fiscal'));		
	$datos['factura']['folio']            = $action == "vp_cfdirel" ? "0" : "";	
	$datos['factura']['fecha_expedicion'] = $this->utils->dateExpFactura($fechaExpedicion);//$fechaExpedicion;//date('Y-m-d\TH:i:s', time() - 120);
	$datos['factura']['descuento']        = $this->input->post('descuentoSAT');//'0.00';
	$datos['factPDF']['notas']            = $this->input->post('notasFactura');//249.99;
	$datos['factura']['forma_pago']       = $this->input->post('forma_pago');//'04';
	$datos['factura']['forma_pagoDesc']   = $this->md_sat->traeFormaPagoDesc( $this->input->post('forma_pago') );
	$datos['factura']['metodo_pago']      = $this->input->post('metodo_pago');//'PUE';
	$datos['factura']['metodo_pagoDesc']  = $this->md_sat->traeMetodoPagoDesc( $this->input->post('metodo_pago') );
	$datos['factura']['moneda']           = $this->input->post('monedaSAT');//'MXN';
	$datos['factura']['serie']            = SERIE_SAT;//'A';
	$datos['factura']['subtotal']         = $this->input->post('subtotalSAT');//215.51;
	$datos['factura']['tipocambio']       = $this->input->post('tcSAT');//1;		
	$datos['factura']['total']            = $this->input->post('totalSAT');//249.99;
	$datos['factPDF']['totalConLetras']   = $this->utils->convertNumToChar( $this->input->post('totalSAT') );

	//CFDI Relacionados
	$datos['factura']['tipocomprobante']        = substr($tipoComprobante['sat_TipoDeComprobante'], 0, 1);	
	$datos['factPDF']['tipocomprobanteDesc']    = $tipoComprobante['Descripcion']; 
	$tipoRelacion     = $this->input->post('tipo_relacion');
	$tipoRelacionDesc = $this->md_sat->traeTipoRelacionSATbyTipo( $tipoRelacion  );
	$datos['CfdisRelacionados']['TipoRelacion'] = $tipoRelacion;	
	$datos['factPDF']['tipoRelacionDesc']       = $tipoRelacionDesc['Descripcion'];
	$datos['factPDF']['notasCfdiRel']           = $this->input->post('notasCfdiRel');
	$cfdiRelTot = $this->input->post('cfdiRelTot');	

	for($i=1; $i <= $cfdiRelTot; $i++)
	   { $datos['CfdisRelacionados']['UUID'][($i-1)] = $this->input->post('CfdiRelSel'.$i); }

	if( $cfdiRelTot ==0) 
	  { $datos['CfdisRelacionados']['UUID'] = array(); }

	// Datos del Receptor
	$datos['receptor']['rfc']    = $this->input->post('rfcReceptor');//'SOHM7509289MA';
	$datos['receptor']['nombre'] = $this->input->post('rsReceptor');//'Pu&blico en General';
	
	// Datos de los conceptos			
	$y = -1;
	for ($x = 0; $x <= $numConceptosConCveSAT; $x++) 
		{	
			$concep = $this->input->post('conSATCodigo'.$x);			
			if($concep != "")	
				{ 
					$y++;
					$impConcepto = $this->input->post('conSATsubtot'.$x);					

					$datos['conceptos'][$y]['cantidad']      = $this->input->post('conSATCantidad'.$x);
					$datos['conceptos'][$y]['unidad']        = $this->input->post('conSATUM'.$x); //'PIEZA';
					$datos['conceptos'][$y]['ID']            = $this->input->post('conSATID'.$x);//"M7390Z";
					$datos['conceptos'][$y]['descripcion']   = $this->input->post('conSATCargo'.$x);
					$datos['conceptos'][$y]['valorunitario'] = $this->input->post('conSATValorUni'.$x);//215.51;
					$datos['conceptos'][$y]['importe']       = $impConcepto;
					$datos['conceptos'][$y]['ClaveProdServ'] = $this->input->post('conSATCodigo'.$x);						
					$datos['conceptos'][$y]['ClaveUnidad']   = $this->input->post('conSATCveUnidad'.$x);
					
					$datos['pdfconceptos'][$y]['cantidad']      = $this->input->post('conSATCantidad'.$x);
					$datos['pdfconceptos'][$y]['unidad']        = $this->input->post('conSATUM'.$x); //'PIEZA';
					$datos['pdfconceptos'][$y]['ID']            = $this->input->post('conSATID'.$x);//"M7390Z";
					$datos['pdfconceptos'][$y]['descripcion']   = $this->input->post('conSATCargo'.$x);
					$datos['pdfconceptos'][$y]['valorunitario'] = $this->input->post('conSATValorUni'.$x);//215.51;
					$datos['pdfconceptos'][$y]['importe']       = $impConcepto;
					$datos['pdfconceptos'][$y]['ClaveProdServ'] = $this->input->post('conSATCodigo'.$x);
					$datos['pdfconceptos'][$y]['ClaveUnidad']   = $this->input->post('conSATCveUnidad'.$x);
					$datos['pdfconceptos'][$y]['sumaIVA']   	= $this->input->post('conSATIVA'.$x);
											
						//Datos de Impuestos
						if($this->input->post('conSATIVA'.$x) == "1")
						{
							$flagTasaIVA    = TRUE;
							$tasa['Factor'] = 'Tasa';
							$tasa['sat_TasaOCuota_Valor_Maximo'] = TASA_IVA;
							$ivaConcepto = $this->utils->toFixed( floatval($tasa['sat_TasaOCuota_Valor_Maximo']) * $impConcepto, 2);
							$ImpuestoTransTasaIVA += $ivaConcepto;

						} 
						else
						{
							$flagTasaSinIVA = TRUE;
							$tasa['Factor'] = 'Tasa';
							$tasa['sat_TasaOCuota_Valor_Maximo'] = TASA_IVA_CERO;							
							$ivaConcepto = '0.00';
						}
						//Datos de Impuestos
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['Base']       = $impConcepto;
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['Impuesto']   = $impuesto['sat_Impuesto'];//'002';
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['TipoFactor'] = $tasa['Factor'];//'Tasa';
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['TasaOCuota'] = $tasa['sat_TasaOCuota_Valor_Maximo'];//'0.160000';
						$datos['conceptos'][$y]['Impuestos']['Traslados'][0]['Importe']    = $ivaConcepto;

						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['Base']       = $impConcepto;
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['Impuesto']   = $impuesto['sat_Impuesto'];//'002';
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['TipoFactor'] = $tasa['Factor'];//'Tasa';
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['TasaOCuota'] = $tasa['sat_TasaOCuota_Valor_Maximo'];//'0.160000';
						$datos['pdfconceptos'][$y]['Impuestos']['Traslados'][0]['Importe']    = $ivaConcepto;//34.48;							
				}
		}	
	// Se agregan los Impuestos FACTURA	
	// Se agregan los Impuestos FACTURA	
	$indiceTranslados = -1;
	if($flagTasaIVA == TRUE)
	{
		$indiceTranslados++;
		$datos['impuestos']['translados'][$indiceTranslados]['impuesto']   = $impuesto['sat_Impuesto'];
		$datos['impuestos']['translados'][$indiceTranslados]['tasa'] 	   = TASA_IVA;
		$datos['impuestos']['translados'][$indiceTranslados]['importe']    = $this->utils->toFixed($ImpuestoTransTasaIVA,2 );
		$datos['impuestos']['translados'][$indiceTranslados]['TipoFactor'] = 'Tasa';
	}
	if($flagTasaSinIVA == TRUE)
	{
		$indiceTranslados++;
		$datos['impuestos']['translados'][$indiceTranslados]['impuesto']   = $impuesto['sat_Impuesto'];
		$datos['impuestos']['translados'][$indiceTranslados]['tasa']       = TASA_IVA_CERO;
		$datos['impuestos']['translados'][$indiceTranslados]['importe']    = 0.00;
		$datos['impuestos']['translados'][$indiceTranslados]['TipoFactor'] = 'Tasa';	
	}		
	$datos['impuestos']['TotalImpuestosTrasladados'] = $this->utils->toFixed($ImpuestoTransTasaIVA,2 );
	$datos['factPDF']['translados'][0]['base'] 	   	 = $this->utils->toFixed($ImpuestoTransTasaIVA,2 );

	// Datos del Receptor		
	$datos['receptor']['UsoCFDI']  	   = $this->input->post('uso_cfdi');//'G03';
	$datos['factPDF']['UsoCFDIDesc']   = $this->md_sat->traeDescUsosCFDI($this->input->post('uso_cfdi'));	
	$datos['factPDF']['emailReceptor'] = $this->input->post('emailReceptor');
	$datos['factPDF']['cpReceptor']    = $this->input->post('cpReceptor');	
	
	$datos['pdf'] = $dbFiscal;	
		 
	$filename = $datos['factura']['tipocomprobante']."_".$datos['factura']['serie']."_".$datos['factura']['folio'].".pdf";
//log_message('error', 'VER:'.var_export($datos, true));
	switch ($action) 
	{
	 case "vp_cfdirel": 			
		$datos['factura']['uuid'] = NULL;
		$datos['factura']['representacion_impresa_certificado_no'] = NULL;
		$datos['factura']['fecha_timbrado']  = NULL;
		$datos['factura']['status'] = "VPF";

		$this->md_sat->borraVistaPreviaFactura( $datos['id_pedido'] );
		$this->md_sat->insert_factura_timbrada($datos);
		$this->md_sat->inserta_cfdiRel($datos);
		
		$filename = "PREFACTURA_".$filename;
		$datos['emisor']['rfc'] 	  	  = $dbFiscal['rfc'];
		$datos['emisor']['nombre_fiscal'] = $dbFiscal['nombre_fiscal'];
		$datos['emisor']['cp_fiscal'] 	  = $dbFiscal['cp_fiscal'];
		$datos['emisor']['correo_fiscal'] = $dbFiscal['correo_fiscal'];
		$this->generatePDF_Factura( $datos['dir_cfdi'] . $filename
								  , array("f" => $datos, "r" => array("archivo_png"=>"images/blank.png", "representacion_impresa_certificado_no"=>"","representacion_impresa_sello"=>"","representacion_impresa_selloSAT"=>"","representacion_impresa_certificadoSAT"=>"","representacion_impresa_cadena"=>"","folio_fiscal"=>"","fecha_timbrado"=>""  ) ) 
								  , 'vw_pdf_prefactura_cdfi_rel'
								  );
		$resp = array( "pdf"  => $filename, "dir" => $datos['dir_cfdi'], "vistaprevia"=>"1", "id_factura"=>$datos['id_factura'] );
	 break;	
	 	 	 
	}

	echo json_encode( $resp );
	
	} catch (Exception $e) { log_message('error', 'timbrarCfdiRelAX Excepción:'.$e->getMessage()); }	
}//timbrarCfdiRelAX

public function	traeConsecutivoAX()
{

try{
	$this->load->model('md_sat');	

	echo json_encode( $this->md_sat->traeFolioConseutivo() );
		
} catch (Exception $e) { log_message('error', 'traeConsecutivoAX Excepción:'.$e->getMessage()); }	

}//traeConsecutivoAX

public function	guardaFacturaAX()
	{
	
	try{$this->load->model('md_usuario');
		$this->load->model('md_catalogo');
		$this->load->model('md_sat');	

		$this->load->library('Pdf');				
		$this->load->helper ('date');
		$this->load->helper ('file');	
		
		$data = array();
		$data['factura']      = $this->input->post('datos')['factura'];
		$data['id_factura']	  = $this->input->post('datos')['id_factura'];
		$data['id_pedido']	  = $this->input->post('datos')['id_pedido'];
		$data['factPDF']	  = $this->input->post('datos')['factPDF'];
		$data['conceptos']    = $this->input->post('datos')['conceptos'];
		$data['pdfconceptos'] = $this->input->post('datos')['pdfconceptos'];
		$data['impuestos']    = $this->input->post('datos')['impuestos'];
		$data['receptor']     = $this->input->post('datos')['receptor'];
		$data['pdf']		  = $this->input->post('datos')['pdf'];
		$data['pathFile']	  = $this->input->post('pathFile');
		$data['filename']	  = $this->input->post('filename');
		$data['xmlname']	  = $this->input->post('xmlname');
		$data['portal']	   	  = $this->input->post('portal');	
		$data['vistaprevia']  = $this->input->post('vistaprevia');	
		$data['success']	  = $this->input->post('success');	
		
		$this->md_sat->insert_factura_timbrada($data);
		$this->md_pedido->insert_pedido_adjunto( array('adjunto'=>$data['pathFile'] . $data['filename'], 'SEGURIDAD'=>"103", 'desc_adjunto'=>"FACTURA SENNI " . $data['filename'], 'id_pedido'=>$data['id_pedido'],'tipo'=>'FACTURA', 'uuid'=>$data['success']['uuid'], 'filename'=>$data['filename'] ) );				
		
		echo json_encode( $data );
		
		} catch (Exception $e) { log_message('error', 'guardaFacturaAX Excepción:'.$e->getMessage()); }	

	}//guardaFacturaAX

	public function	guardaFacturaCfdiRelAX()
	{
	
	try{$this->load->model('md_usuario');
		$this->load->model('md_catalogo');
		$this->load->model('md_sat');	

		$this->load->library('Pdf');				
		$this->load->helper ('date');
		$this->load->helper ('file');	
		
		$data = array();
		$data['factura']      = $this->input->post('datos')['factura'];
		$data['id_factura']	  = $this->input->post('datos')['id_factura'];
		$data['id_pedido']	  = $this->input->post('datos')['id_pedido'];
		$data['factPDF']	  = $this->input->post('datos')['factPDF'];
		$data['conceptos']    = $this->input->post('datos')['conceptos'];
		$data['pdfconceptos'] = $this->input->post('datos')['pdfconceptos'];
		$data['impuestos']    = $this->input->post('datos')['impuestos'];
		$data['receptor']     = $this->input->post('datos')['receptor'];
		$data['pdf']		  = $this->input->post('datos')['pdf'];
		$data['pathFile']	  = $this->input->post('pathFile');
		$data['filename']	  = $this->input->post('filename');
		$data['xmlname']	  = $this->input->post('xmlname');
		$data['portal']	   	  = $this->input->post('portal');	
		$data['vistaprevia']  = $this->input->post('vistaprevia');	
		$data['success']	  = $this->input->post('success');	
		
		$this->md_sat->borraVistaPreviaFactura( $data['id_pedido'] );
		$this->md_sat->insert_factura_timbrada( $data );
		$this->md_sat->inserta_cfdiRel($data);
		$this->md_pedido->insert_pedido_adjunto( array('adjunto'=>$data['pathFile'] . $data['filename'], 'SEGURIDAD'=>"103", 'desc_adjunto'=>"FACTURA SENNI " . $data['filename'], 'id_pedido'=>$data['id_pedido'],'tipo'=>'FACTURA', 'uuid'=>$data['success']['uuid'], 'filename'=>$data['filename'] ) );				
		
		echo json_encode( $data );
		
		} catch (Exception $e) { log_message('error', 'guardaFacturaAX Excepción:'.$e->getMessage()); }	

	}//guardaFacturaAX

	

	public function	guardaREPAX()
	{
	
	try{$this->load->model('md_pedido');
		$this->load->model('md_sat');	
		
		$this->load->helper ('date');
		$this->load->helper ('file');	
		
		$data = array();
		$data['factura']      = $this->input->post('datos')['factura'];
		$data['id_factura']	  = $this->input->post('datos')['id_factura'];
		$data['id_pedido']	  = $this->input->post('datos')['id_pedido'];
		$data['factPDF']	  = $this->input->post('datos')['factPDF'];
		$data['conceptos']    = $this->input->post('datos')['conceptos'];		
		$data['receptor']     = $this->input->post('datos')['receptor'];
		$data['pdf']		  = $this->input->post('datos')['pdf'];
		$data['pathFile']	  = $this->input->post('pathFile');
		$data['filename']	  = $this->input->post('filename');
		$data['portal']	   	  = $this->input->post('portal');	
		$data['vistaprevia']  = $this->input->post('vistaprevia');	
		$data['success']	  = $this->input->post('success');	
		$data['rep']	      = $this->input->post('datos')['rep'];
		$data['pagos10']      = $this->input->post('datos')['pagos10'];	

//log_message('error', 'VER:'.var_export($data, true));
		$this->md_sat->insert_rep_timbrada($data);
		$this->md_sat->actualizaFactura($data['id_factura'], array('saldo_insoluto' => $data["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoInsoluto"], 'num_parcialidades' => $data['rep']['parcial_rep']) );
		$this->md_pedido->insert_pedido_adjunto( array('adjunto'=>$data['pathFile'] . $data['filename'],'SEGURIDAD'=>"103", 'desc_adjunto'=>"REP ".$data['filename'],'id_pedido'=>$data['id_pedido'],'tipo' => 'REP', "uuid" => $data['factura']['uuid'], "filename" => $data['filename'] ) );
		
		echo json_encode( $data );
		
		} catch (Exception $e) { log_message('error', 'guardaREPAX Excepción:'.$e->getMessage()); }	

	}//guardaFacturaAX


private function generatePDF_Factura($pathFileName, $pdfContent, $view)
{	
try{
	$this->load->library('Pdf');		
	$this->load->helper( 'file');

	$html = $this->load->view($view, $pdfContent, true );
	$this->pdf->generate($html, $pathFileName, FALSE);

   } catch (Exception $e) { log_message('error', 'generatePDF_Factura Excepción:'.$e->getMessage()); }	
}
	
public function	cveProdSAT_AX()
{	
try{$this->load->model('md_sat' );	

	$search = $this->input->post('search');

	$cveProdSAT = $this->md_sat->searchCveProdServSAT($search);

	echo json_encode( $cveProdSAT );
	
	} catch (Exception $e) { log_message('error', 'cveProdSATAX Excepción:'.$e->getMessage()); }	
}


public function	cveUnidadSAT_AX()
{	
try{$this->load->model('md_sat' );	

	$search = $this->input->post('search');

	$cveUnidadSAT = $this->md_sat->searchCveUnidadSAT($search);

	echo json_encode( $cveUnidadSAT );
	
	} catch (Exception $e) { log_message('error', 'cveUnidadSATAX Excepción:'.$e->getMessage()); }	
}

public function	uuidCfdiRel_AX()
{	
try{$this->load->model('md_sat' );	

	$search      = $this->input->post('search');
	$uuidCfdiRel = $this->md_sat->searchUuidCfdiRelSAT($search);

	echo json_encode( $uuidCfdiRel );
	
	} catch (Exception $e) { log_message('error', 'uuidCfdiRel_AX Excepción:'.$e->getMessage()); }	
}



private function traeDetallePedido($num_guia, $tipos_servicio)
	{
		$this -> load -> model('md_rastreo');
		$this -> load -> model('md_flete');
		
		$encabezado = $this -> md_pedido  -> traeDetallePorEn($num_guia,
                                                                        "pedidos",
                                                                        "p",
                                                                        "p.id_pedido,s.opcion_catalogo 		
                                                                        as status,p.status_track, p.rfc, 
                                                                        cl.razon_social,
                                                                        c.opcion_catalogo as 
                                                                        carrier,p.num_mbl,
                                                                        p.shipper, cg.opcion_catalogo 		
                                                                        as cg, tcg.opcion_catalogo as 
                                                                        carta_no, p.monto_carta_no,
                                                                        p.ins_booking, p.id_coti,
                                                                        p.ins_envio,
                                                                        p.vessel_voyage, p.num_hbl, 
                                                                        p.num_contenedor, 
                                                                        p.num_booking, p.carrier as 
                                                                        id_carrier, p.carta_no,
                                                                        p.carta_garantia ,															
                                                                        p.adjunto_mbl, p.adjunto_hbl, p.adjunto_facturaP, 
                                                                        p.adjunto_le, p.adjunto_factura,p.adjunto_poliza,p.adjunto_cartaporte,
                                                                        p.profit_origen,p.profit,p.costo_tot,p.venta_tot,p.comision_ventas,p.comision_operaciones,
                                                                        p.id_coti,p.moneda,p.tipo_cambio, p.tipo_embarque, te.opcion_catalogo as te_desc, p.revalidar_aa, p.pol, p.pod1, p.pod2", "DATE_FORMAT(`p`.`eta`,'%d/%m/%Y') as eta, DATE_FORMAT(`p`.`etd`,'%d/%m/%Y') as etd, (1) as flagHeaderSaved");
		$aduana 	= $this -> md_pedido  -> traeDetallePorEn($num_guia,"aduana","a","*", NULL);
		$flete 		= $this -> md_flete   -> traeDetallePorEn($num_guia,"flete","f","f.tipo_servicio, 
                                                                                                cf.opcion_catalogo 
                                                                                                as veri_o,
                                                                                                f.verificacion_origen as id_v_o",
                                                                                                "DATE_FORMAT(`f`.`etd`,'%d/%m/%Y') as etd, 																																																									
                                                                                                 DATE_FORMAT(`f`.`eta`,'%d/%m/%Y') as eta");
		$producto 	= $this -> md_pedido  -> traeDetallePorEn($num_guia,"productos","p","*", NULL);
		$rastreo 	= $this -> md_rastreo -> traeRastreoPor($num_guia);
		$seguro 	= $this -> md_pedido  -> traeDetallePorEn($num_guia,"seguro","s","*", NULL);
		$numCargos  = $this -> md_pedido  -> traeNumCargos($num_guia);
		$transporte = $this -> md_pedido  -> traeDetallePorEn($num_guia,
                                                                    "transporte",
                                                                    "t",
                                                                    "t.costo, t.venta,t.iva, t.salida_puerto, 
                                                                    t.maniobras,ct.opcion_catalogo as regreso_v, 
                                                                    t.contacto_almacen, t.entrega,
                                                                    t.regreso_vacio as id_regreso_v", 	
                                                                    "DATE_FORMAT(`t`.`entrega`,'%d/%m/%Y') as entrega");

		$servicios = array();		
		//while (list($llave, $valor) = each($tipos_servicio)) 
		foreach($tipos_servicio as $llave => $valor)
		{
			if ($llave != 0 )
			{
			  $pedido_conceptos = $this -> md_pedido -> traeDetalleCoti($num_guia,$llave,"pedido_conceptos","co","co.concepto, co.descripcion, 
			  																			  co.tipo_servicio");
			  $pedido_cargos 	= $this -> md_pedido -> traeDetalleCoti($num_guia,$llave,"pedido_cargos","ca","ca.cargo, ca.importe,ca.costo, 
			  																				ca.tipo_servicio,ca.iva");
			  $pedido_terminos  = $this -> md_pedido -> traeDetalleCoti($num_guia,$llave,"pedido_terminos","ct","ct.termino, ct.descripcion, 
			  																			  ct.tipo_servicio,c.opcion_catalogo as descINCO");
			  $servicios[] = array('id_servicio' 	    => $llave,
									 'servicio' 	    => $valor,
									 'pedido_conceptos' => $pedido_conceptos,
									 'pedido_cargos'    => $pedido_cargos,
									 'pedido_terminos'  => $pedido_terminos);				
			}			
		}        																  				
		return array('encabezado'  => $encabezado, 
					  'aduana' 	   => $aduana, 
					  'flete' 	   => $flete,
					  'producto'   => $producto,
					  'rastreo'	   => $rastreo,
					  'seguro'	   => $seguro,
					  'transporte' => $transporte,
					  'servicios'  => $servicios,
					  'numCargos'  => $numCargos);
	}
	
public function test()
{
	
	$this->load->library('word');
	$this->load->helper('date');	
	$encabezado = array();
	$encabezado[0] = array('id_pedido' 	    => '1436282212',
						   'etd'  			=> '01/06/2015',
						   'vessel_voyage'  => 'vessel_voyage',
						   'pol'  			=> 'VERA',
						   'pod'  			=> 'Acapulco',
						   'mbl'  			=> '123456789',
						   'hbl'  			=> '987654321',
					   );
	$cargos = array();
				$cargoArray = array('cargo'    => $cargo,
							   	    'importe'  => $importe
							  	   );
	$cargos[0] = array('cargo'    => "FLETE ",
							   	    'importe'  => '1231'
							  	   );
	$cargos[1] = array('cargo'    => "sdsd ",
							   	    'importe'  => '3435'
							  	   );						  			   
	echo "r: ".$this->mandaPrefactura("SENNITI1234567","eduardo.ms@senni.com.mx",$encabezado,$cargos);
	echo "bien";
/*	echo "r: ".$this->mandarCorreoRetro("1435776993",
										"Pito Perez",
										"eduardo.munoz.siller@gmail.com",
										"eduardo.ms@senni.com.mx",NULL);
*/										
}	

	
	private function mandaPrefactura($rfc,$correo,$encabezado,$fletes,$terminos,$cargos,$cargosIVA)
	{
	 try{		
		
		$cliente    = $this->md_cliente->traeDetalleClientePorEn($rfc,"clientes","c","*");		
						
		$datosSL    = $this->md_pedido->traeDatosSL();
		$cuentasSL  = $this->md_pedido->traeCuentasSL($datosSL[0]['rfc']);

		$preFactura = $this->generarPDF_Prefactura($encabezado,$fletes,$terminos,$cargos,$cargosIVA,$cliente,$datosSL,$cuentasSL);

		$id_pedido  = $encabezado[0]['id_pedido'];
		$to 	 	= $cliente[0]['correo'];
		$cc  		= $correoEjecutivoCuenta;
		$bcc 		= NULL;
		$r 			= $this->mandarCorreoPrefactura($id_pedido,$cliente[0]['razon_social'],$to,$cc,$bcc,$preFactura['dirFileName']);

		return $r;
				
	 } catch (Exception $e) {echo 'manda Prefactura Excepción: ',  $e->getMessage(), "\n";}		
	}
	
	
	private function generarPDF_Prefactura($encabezado,$fletes,$terminos,$cargos,$cargosIVA,$cliente,$datosSL,$cuentasSL)
	{
	 try
	 {
		$this->load->helper('date');
		$this->load->library('dompdf_gen');
		$this->load->helper( 'file');
		
		$dir 		= $this->output_dir."prefactura/";			
		$now 	    = new DateTime();
		$fechaPF    = $now->format('d-F-Y');
		$filename   = 'preFactura_'.$encabezado[0]['id_pedido'].'.pdf';		
		$fechaPFStr = $this->utils->traduceMeses($fechaPF);
	
		$data['fechaPF']    = $fechaPFStr;			
		$data['encabezado'] = $encabezado;
		$data['fletes'] 	= $fletes;
		$data['terminos'] 	= $terminos;
		$data['cargos'] 	= $cargos;
		$data['cargosIVA'] 	= $cargosIVA;
		$data['cliente'] 	= $cliente;
		$data['datosSL'] 	= $datosSL;
		$data['cuentasSL']  = $cuentasSL;
		
		$html = $this->load->view( 'vw_pdf_prefactura' , $data , true );
		
		$pdfContent = $this->utils->pdf_create($html,'',FALSE);
		$accion = write_file($dir.$filename, $pdfContent);
		
		return array("filename"    => $filename,
                             "dirFileName" => $dir.$filename
                            );
		
	 } catch (Exception $e) {echo 'Pedido Genera Prefactura Excepción: ',  $e->getMessage(), "\n";}	
	}

	
	private function mandarCorreoPrefactura($id_pedido,$nombre_cliente,$to,$cc,$bcc,$preFactura)
	{
		$this->load->library('email');
		
		$config['protocol']    = "smtp";
                $config['smtp_host']   = "smtp.office365.com";
                $config['smtp_port']   = "587";
                $config['smtp_crypto'] = "tls";
                $config['smtp_timeout']= '60';
                $config['smtp_user']   = CORREO_CONTACTO; 
                $config['smtp_pass']   = "4dm1n$2019";    
                $config['charset']     = "UTF8";
                $config['mailtype']    = "html";		
                $config['wordwrap']    = TRUE;
                $config['priority']    = 2;
                $config['crlf']        = "\r\n";
                $config['newline']     = "\r\n";

               $this->email->clear();
               $this->email->initialize($config);

		$fromMail = CORREO_CONTACTO;
		$fromName = 'SENNI Logistics';
		$subject  = "Su embarque se encuentra próximo a arribar";	
		$message  = '
		<html>
		<head>
		<title>SENNI Logistics</title>
		</head>
		<body>
		<hr>
		<p align="left" style="font-family:\'arial black\',\'avant garde\';font-size:12px"><strong>'
		.$nombre_cliente.',</strong></p>
		<p align="justify">
		Antes que nada reciba un cordial saludo de nuestra parte, el siguiente correo es para 
		informarle que su 
		embarque con referencia SENNI <a href="'.base_url().'rastreo/pf/'.$id_pedido.'" target="_blank"><strong>
		'.$id_pedido.'</strong></a>, se encuentra próximo a arribar, por ello le 
		hacemos llegar la 
		Pre-Factura, adjuntada a este correo, para que pueda validar sus datos fiscales. </p>
		<p align="justify">Agradeceremos responder por este medio la correcta información contenida en dicha 
		Pre-Factura</p><br>
		<p align="justify">Para conocer más información acerca de su embarque, dar click 
		<a href="'.base_url().'rastreo/pf/'.$id_pedido.'" target="_blank">aquí</a></p><br>
		<p align="justify"><strong>Saludos Cordiales</strong></p>
		<hr>
		<p>
		<span style="font-family:\'arial black\',\'avant garde\';font-size:large;color:#888888">
		<strong> SENNI LOGISTICS S.A. DE C.V</strong></span>
		</p>	
		<p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888">Telefono <strong>
		+52 55 70304506 /70304501</strong></span></strong>
		</span></p>
                <p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888">SAN FRANCISCO 1626 OFICINA 201 Y 202 COL. DEL VALLE SUR, 
                 <br>DEL. BENITO JUAREZ, MEXICO D.F. C.P 03100</span></strong>
		</span></p>
		<p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888">e-m. 
		<a href="mailto:ventas@senni.com.mx" target="_blank">
		<span class="il">
		ventas@senni.com.mx</span></a></span></strong></span></p>
		<p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888"><a href="http://www.senni.com.mx" target="_blank">
		www.senni.com.mx</a></span></strong></span></p>
		</body>
		</html>
		';		
		
		$this->email->from($fromMail, $fromName);
		$this->email->to($to);
		
		if( $cc != NULL)
                    { $this->email->cc($cc); }
			
		if( $bcc != NULL)		
                    { $this->email->bcc($bcc); }
		
		$this->email->subject($subject);		
		$this->email->message($message);	
		$this->email->attach($preFactura);	
				
		$r = $this->email->send();
		
	//	echo $this->email->print_debugger();	
		return $r;	
	}
	
	private function mandarCorreoRetro($id_pedido,$nombre_cliente,$to,$cc,$bcc)
	{
		$this->load->library('email');
		
		$config['protocol']    = "smtp";
                $config['smtp_host']   = "smtp.office365.com";
                $config['smtp_port']   = "587";
                $config['smtp_crypto'] = "tls";
                $config['smtp_timeout']= '60';
                $config['smtp_user']   = CORREO_CONTACTO; 
                $config['smtp_pass']   = "4dm1n$2019";    
                $config['charset']     = "UTF8";
                $config['mailtype']    = "html";		
                $config['wordwrap']    = TRUE;
                $config['priority']    = 2;
                $config['crlf']        = "\r\n";
                $config['newline']     = "\r\n";

               $this->email->clear();
               $this->email->initialize($config);

		$fromMail = 'ventas@senni.com.mx';
		$fromName = 'SENNI Logistics';
		$subject  = "Encuesta de Satisfacción";	
		$message  = '
		<html>
		<head>
		<title>SENNI Logistics</title>
		</head>
		<body>
		<hr>
		<p align="left" style="font-family:\'arial black\',\'avant garde\';font-size:12px"><strong>Estimado '
		.$nombre_cliente.',</strong></p>
		<p align="justify">
		Esperamos que nuestro servicio haya sido de su agrado y contemos con su preferencia para futuras ocasiones.
		</p> 
		<p align="justify">
		Le agradecéremos profundamente, si nos regala unos minutos más, de su tiempo para contestar la siguiente 
		encuesta, es muy breve. no le tomará más de 5 mins.<br><br>
		<center>
			<a href="'.base_url().'retro/encuesta/'.$id_pedido.'" target="_blank"><strong>
			Encuesta de Satisfacción</strong></a>
		</center>
		</p>
		<br><br>
		<p align="justify"><strong>Saludos Cordiales</strong></p>
		<hr>
		<p>
		<span style="font-family:\'arial black\',\'avant garde\';font-size:large;color:#888888">
		<strong> SENNI LOGISTICS S.A. DE C.V</strong></span>
		</p>	
		<p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888">Telefono;<strong>
		+52 55 70304506 /70304501</strong></span></strong>
		</span></p>
                <p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888">SAN FRANCISCO 1626 OFICINA 201 Y 202 COL. DEL VALLE SUR, 
                 <br>DEL. BENITO JUAREZ, MEXICO D.F. C.P 03100</span></strong>
		</span></p>
		<p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888">e-m. 
		<a href="mailto:ventas@senni.com.mx" target="_blank">
		<span class="il">
		ventas@senni.com.mx</span></a></span></strong></span></p>
		<p><span style="font-family:\'arial black\',\'avant garde\';font-size:small">
		<strong><span style="color:#888888"><a href="http://www.senni.com.mx" target="_blank">
		www.senni.com.mx</a></span></strong></span></p>
		</body>
		</html>
		';		
		
		$this->email->from($fromMail, $fromName);
		$this->email->to($to);
	
		if( $cc != NULL)
			$this->email->cc($cc); 
			
		if( $bcc != NULL)		
			$this->email->bcc($bcc); 
		
		$this->email->subject($subject);		
		$this->email->message($message);
	
		$r = $this->email->send();
		
//		echo $this->email->print_debugger();	
		return $r;	
	}
}


