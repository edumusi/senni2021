<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	
	public function index()
	{
		$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
        
        public function quienes_somos()
	{
		$data['titulos'] = array("navegador"=>"Quienes somos| Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('vw_quienes_somos',$data);
	}
        
        public function servicios($tipo)
	{
		$data['titulos'] = array("navegador"=>"Servicios | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('vw_'.$tipo,$data);
	}
        
        
        public function contacto()
	{
		$data['titulos'] = array("navegador"=>"Contacto | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('vw_contacto',$data);
	}
        
        public function introduccion()
	{
		$data['titulos'] = array("navegador"=>"Estrategia | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('vw_introduccion',$data);
	}
        
         public function estrategia()
	{
		$data['titulos'] = array("navegador"=>"Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('index',$data);
	}
        
         public function aci()
	{
		$data['titulos'] = array("navegador"=>"Agentes de Carga Intenacional ACI | FREIGHT FORWARDER | Senni Logistics | Rompiendo Barreras... Cumpliendo tus Metas!!!");
		$this->load->view('vw_aci',$data);
	}
        
        public function captcha()
	{
            $this->load->library('session');
	    $ranStr = substr( sha1( microtime() ),0,6); 
	
            $this->session->set_userdata('captcha', $ranStr);            
	
            $newImage = imagecreatefromjpeg(base_url()."img/fondo_captcha.jpg" ); 

            $txtColor = imagecolorallocate($newImage, 0, 0, 200); 

            imagestring($newImage, 5, 30, 8, $ranStr, $txtColor); 
	
            header( "Content-type: image/jpeg" );
	
            imagejpeg($newImage);
	}
		
	
        public function test()
        {
        try{        
                $this->load->library('Contador'); 
                $this->load->database('MySQL_Conn' );        
                $this->load->model   ('md_catalogo');
                echo "HOLA CONTADOR".br(1);
                
                $id_pedido = 1545186278;
                $dbFiscal = $this->md_catalogo->traeDatosFiscales(RFC, null);
                $dbFiscal['dir_cfdi'] = $this->output_dir . $id_pedido . '/cfdi/';    
                
                $contador = new Contador();
                $contador->Init($dbFiscal);
                
                $datos = $contador->getconfigTimbrado();        
               // Datos de la Factura
                $datos['factura']['condicionesDePago'] = 'CONTADO';
                $datos['factura']['descuento']        = '0.00';
                $datos['factura']['fecha_expedicion'] = date('Y-m-d\TH:i:s', time() - 120);
                $datos['factura']['folio']            = '659155';
                $datos['factura']['forma_pago']       = '04';
                $datos['factura']['LugarExpedicion']  = '77712';
                $datos['factura']['metodo_pago']      = 'PUE';
                $datos['factura']['moneda']           = 'MXN';
                $datos['factura']['serie']            = 'A';
                $datos['factura']['subtotal']         = 215.51;
                $datos['factura']['tipocambio']       = 1;
                $datos['factura']['tipocomprobante']  = 'I';
                $datos['factura']['total']            = 249.99;
                $datos['factura']['RegimenFiscal']    = '601';
        /*        
                $datos['CfdisRelacionados']['TipoRelacion'] = '01';
                $datos['CfdisRelacionados']['UUID'][0]      = 'A39DA66B-52CA-49E3-879B-5C05185B0EF7';
        */
                // Datos del Receptor
                $datos['receptor']['rfc']     = 'SOHM7509289MA';
                $datos['receptor']['nombre']  = 'Pu&blico en General';
                $datos['receptor']['UsoCFDI'] = 'G03';        
        
                // Se agregan los conceptos
                $datos['conceptos'][0]['cantidad']      = 1.00;
                $datos['conceptos'][0]['unidad']        = 'PIEZA';
                $datos['conceptos'][0]['ID']            = "M7390Z";
                $datos['conceptos'][0]['descripcion']   = "taxi";
                $datos['conceptos'][0]['valorunitario'] = 215.51;
                $datos['conceptos'][0]['importe']       = 215.51;
                $datos['conceptos'][0]['ClaveProdServ'] = '53102700';
                $datos['conceptos'][0]['ClaveUnidad']   = 'H87';
        
                $datos['conceptos'][0]['Impuestos']['Traslados'][0]['Base']       = 215.51;
                $datos['conceptos'][0]['Impuestos']['Traslados'][0]['Impuesto']   = '002';
                $datos['conceptos'][0]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
                $datos['conceptos'][0]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
                $datos['conceptos'][0]['Impuestos']['Traslados'][0]['Importe']    = 34.48;
                /*
                $datos['conceptos'][1]['cantidad'] = 1.000;
                $datos['conceptos'][1]['unidad'] = 'PIEZA';
                $datos['conceptos'][1]['ID'] = "SPC764XZ";
                $datos['conceptos'][1]['descripcion'] = "BALATAS FRN/DIS TRAS.CHEVROLET ASTRA";
                $datos['conceptos'][1]['valorunitario'] = 464.61;
                $datos['conceptos'][1]['importe'] = 464.61;
                $datos['conceptos'][1]['ClaveProdServ'] = '25171700';
                $datos['conceptos'][1]['ClaveUnidad'] = 'H87';
        
                $datos['conceptos'][1]['Impuestos']['Traslados'][0]['Base'] = 464.61;
                $datos['conceptos'][1]['Impuestos']['Traslados'][0]['Impuesto'] = '002';
                $datos['conceptos'][1]['Impuestos']['Traslados'][0]['TipoFactor'] = 'Tasa';
                $datos['conceptos'][1]['Impuestos']['Traslados'][0]['TasaOCuota'] = '0.160000';
                $datos['conceptos'][1]['Impuestos']['Traslados'][0]['Importe'] = 74.34;*/
        
                // Se agregan los Impuestos
                $datos['impuestos']['translados'][0]['impuesto']   = '002';
                $datos['impuestos']['translados'][0]['tasa']       = '0.160000';
                $datos['impuestos']['translados'][0]['importe']    = 34.48;
                $datos['impuestos']['translados'][0]['TipoFactor'] = 'Tasa';
        
                $datos['impuestos']['TotalImpuestosTrasladados'] = 34.48;
        
            echo "<pre>DATOS: ";
            print_r($datos);
            echo "</pre>";
            $respTimb = $contador->Facturar($datos);
           /* echo "<pre>RESP: ";
            print_r($respTimb);
            echo "</pre>";       */
        
            echo "<h1>Respuesta Generar XML y Timbrado</h1>";
                foreach($respTimb AS $variable=>$valor)
                {
                        $valor=htmlentities($valor);
                        $valor=str_replace('&lt;br/&gt;','<br/>',$valor);
                        echo "<b>[$variable]=</b>$valor<hr>";
                }
        
                
                } catch (Exception $e) {log_message('error', 'test Excepción:'.$e->getMessage()); }	
        
                $this->load->view('test',$datos);
        
                }// test
        

}

