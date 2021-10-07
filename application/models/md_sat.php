<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_sat extends CI_Model {
					

    public function traeFacturaById($id_pedido)
    {

        $this->db->select('*');
        $this->db->select("DATE_FORMAT(`fecha_expedicion`,'%d/%m/%Y') as fe", FALSE);
        $this->db->select("DATEDIFF(CURDATE(), `fecha_expedicion`) as dv", FALSE);
        $this->db->where ('id_pedido', $id_pedido);
        $query = $this->db->get('factura');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();        
    }

    public function traeFacturaByIdFactura($id_factura)
    {

        $this->db->select('*');
        $this->db->select("DATE_FORMAT(`fecha_expedicion`,'%d/%m/%Y') as fe", FALSE);
        $this->db->select("DATEDIFF(CURDATE(), `fecha_expedicion`) as dv", FALSE);
        $this->db->where ('id_factura', $id_factura);
        $query = $this->db->get('factura');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();        
    }
    
    public function traeFacturaVistaPreviaById($id_pedido)
    {

        $this->db->select('*');
        $this->db->select("DATE_FORMAT(`fecha_expedicion`,'%d/%m/%Y') as fe", FALSE);
        $this->db->select("DATEDIFF(CURDATE(), `fecha_expedicion`) as dv", FALSE);
        $this->db->where ('id_pedido', $id_pedido);
        $this->db->where ('status', 'VPF');
        $query = $this->db->get('factura');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();        
    }

    public function traeFacturaCfdiRelById($id_pedido)
    {

        $this->db->select('fcr.id_factura, fcr.id_pedido, fcr.uuid_relacionado, fcr.tipo_relacion, fcr.tipo_comprobante, pa.adjunto, f.folio, f.total, f.moneda, f.fecha_timbrado');
        $this->db->join  ('factura f', 'fcr.uuid_relacionado = f.uuid');
        $this->db->join  ('pedido_adjuntos pa', 'pa.uuid = fcr.uuid_relacionado');
        $this->db->where ('fcr.id_pedido', $id_pedido);        
        $query = $this->db->get('factura_cfdi_relacionados fcr');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else 
            return array();        
    }


    public function traeFacturaConceptosById($id_factura)
    {

        $this->db->select('*');        
        $this->db->where ('id_factura', $id_factura);
        $query = $this->db->get('factura_conceptos');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else 
            return array();
        
    }

    public function traeFacturaRepById($id_factura)
    {

        $this->db->select('*');
        $this->db->select("DATE_FORMAT(`fecha_rep`,'%d/%m/%Y') as fr", FALSE);
        $this->db->where ('id_factura', $id_factura);
        $this->db->order_by("id_pago","asc");
        $query = $this->db->get('factura_pagos');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else 
            return array();
        
    }	

    public function traeFacturaPagosByIdPedido($id_pedido)
    {

        $this->db->select('*');
        $this->db->select("DATE_FORMAT(`fp`.`fecha_rep`,'%d/%m/%Y') as fr", FALSE);
        $this->db->where ('fp.id_pedido', $id_pedido);        
        $this->db->join  ('factura f', 'fp.id_factura = f.id_factura');
        $this->db->join  ('pedido_adjuntos pa', 'pa.uuid = f.uuid');
        $this->db->order_by("fp.id_pago","asc");
        $query = $this->db->get('factura_pagos fp');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else 
            return array();
    }	

    public function actualizaFacturaByUUID($uuid, $data)
    { 
    try {    
        $this->db->where('uuid', $uuid);
        $this->db->update('factura', $data);
        } catch (Exception $e) {log_message('error', 'actualizaFacturaByUUID Excepción:'.$e->getMessage()); }	
    }


    
    public function traeDatosUsosCFDI()
    {

        $this->db->select('TRIM(sat_UsoCFDI)sat_UsoCFDI, Descripcion');
        $this->db->where('Moral', 'Sí');
        $query = $this->db->get('sat_usocfdi');				 
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_UsoCFDI] = $row->Descripcion; }
        }
	
        return $options;   
        
    }	

    public function traeDescUsosCFDI($usoCFDI)
    {

        $this->db->select('Descripcion');
        $this->db->where('Moral', 'Sí');
        $this->db->where ('sat_UsoCFDI', $usoCFDI);
        $query = $this->db->get('sat_usocfdi');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array("Descripcion"=>""); 
        
    }	


    public function traeDatosRegimenFiscal()
    {

        $this->db->select('TRIM(sat_RegimenFiscal) as sat_RegimenFiscal, Descripcion');
        $this->db->where('Moral', 'Sí');
        $query = $this->db->get('sat_regimenfiscal');				 
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_RegimenFiscal] = $row->Descripcion; }
        }
	
        return $options;   
        
    }	

    public function traeDescRegimenFiscal($regimenFiscal)
    {

        $this->db->select('Descripcion');
        $this->db->where ('Moral', 'Sí');
        $this->db->where ('sat_RegimenFiscal', $regimenFiscal);
        $query = $this->db->get('sat_regimenfiscal');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array("Descripcion"=>"");
        
    }	


    public function traeFormaPago()
    {
        $this->db->select('sat_FormaPago, TRIM(Descripcion) as Descripcion');        
        $query = $this->db->get('sat_formapago');				 
		 
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_FormaPago] = $row->Descripcion; }
        }
	
        return $options;   
        
    }	
    public function traeFormaPagoDesc($formaPago)
    {
        $this->db->select('Descripcion');        
        $this->db->where ('sat_FormaPago', $formaPago);
        $query = $this->db->get('sat_formapago');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array("Descripcion"=>"");
	        
    }


    public function traeMetodoPago()
    {
        $this->db->select('TRIM(Descripcion) as Descripcion');   
        $this->db->select("SUBSTRING(`sat_MetodoPago`, 1, 3) AS sat_MetodoPago",FALSE);
        $query = $this->db->get('sat_metodopago');				 
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_MetodoPago] = $row->Descripcion; }
        }
	
        return $options;   
        
    }
    
    public function traeMetodoPagoDesc($metodoPago)
    {                
        switch ($metodoPago) 
	    {
            case "PUE": 			
                return array("Descripcion" => 'Pago en una sola exhibición');
         break;	
         case "PPD":
                return array("Descripcion" => 'Pago en parcialidades o diferido');
            break;	
        }
         
        /*
        $this->db->select('Descripcion');
        $this->db->like  ('sat_MetodoPago', $param, 'both');
        $query = $this->db->get('sat_metodopago');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array("Descripcion"=>$param);
        */
	        
    } 

    public function traeMonedaSAT()
    {
        $this->db->select('sat_Moneda, Descripcion');
        $this->db->where_in('idmoneda',  array(100, 148));
        $query = $this->db->get('sat_moneda');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_Moneda] = $row->Descripcion; }
        }
	
        return $options;   
        
    }	

    public function traeTipoRelacionSAT()
    {
        $this->db->select('LTRIM(sat_TipoRelacion) as sat_TipoRelacion, LTRIM(Descripcion) as Descripcion');        
        $query = $this->db->get('sat_tiporelacion');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_TipoRelacion] = $row->Descripcion; }
        }
	
        return $options;   

    }	


    public function traeTiposComprobantesSAT()
    {
        $this->db->select('LTRIM(sat_TipoDeComprobante) as sat_TipoDeComprobante, Descripcion');
        $this->db->where_not_in('sat_TipoDeComprobante', array('N','P') );
        $query = $this->db->get('sat_tipodecomprobante');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->sat_TipoDeComprobante] = $row->Descripcion; }
        }

        return $options;   

    }	


    public function traeTipoComprobanteSAT($tipo)
    {
        $this->db->select('LTRIM(sat_TipoDeComprobante) as sat_TipoDeComprobante, Descripcion');        
        $this->db->like('Descripcion',  $tipo);
        $query = $this->db->get('sat_tipodecomprobante');
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();
    }	

    public function traeTipoComprobanteSATbyTipo($tipo)
    {
        $this->db->select('LTRIM(sat_TipoDeComprobante) as sat_TipoDeComprobante, Descripcion');        
        $this->db->where ('sat_TipoDeComprobante', $tipo);
        $query = $this->db->get('sat_tipodecomprobante');
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();
    }	

    public function traeTipoRelacionSATbyTipo($tipo)
    {
        $this->db->select('LTRIM(sat_TipoRelacion) as sat_TipoRelacion, Descripcion');        
        $this->db->where  ('sat_TipoRelacion', $tipo);
        $query = $this->db->get('sat_tiporelacion');
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();
    }	


    public function traeImpuestoSAT($tipo)
    {
        $this->db->select('LTRIM(sat_Impuesto) as sat_Impuesto, Descripcion');
        $this->db->like('Descripcion',  $tipo);
        $query = $this->db->get('sat_impuesto');
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();
    }

    public function traeTasaCuotaSAT($tasa)
    {
        $this->db->select('LTRIM(sat_TasaOCuota_Valor_Maximo) as sat_TasaOCuota_Valor_Maximo, Factor');
        $this->db->like('sat_TasaOCuota_Valor_Maximo',  $tasa);        
        $this->db->where('Traslado',  'Sí');
        $this->db->where('Impuesto', IMPUESTO);
        $query = $this->db->get('sat_tasaocuota');
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();
    }

    


    public function searchCveProdServSAT($criterio)
    {
        $this->db->select  ('sat_ClaveProdServ as value, CONCAT("(", sat_ClaveProdServ, ") ", Descripcion)  as label', FALSE);
        $this->db->like    ('Descripcion', $criterio);
        $this->db->or_like ('sat_ClaveProdServ', $criterio);
        $this->db->order_by("Descripcion","asc");
        $query = $this->db->get('sat_claveprodserv', 60, 0);
        
        if($query -> num_rows() > 0 )      
            { return $query->result_array(); }
	    else
            { return array("value"=>0, "label"=>"No hay regisros buscando '".$criterio."'");   }        
    }	

    public function searchCveUnidadSAT($criterio)
    {
        $this->db->select  ('ClaveUnidad as value, CONCAT("(", ClaveUnidad, ") ", Nombre)  as label', FALSE);
        $this->db->like    ('Nombre', $criterio);        
        $this->db->order_by("Nombre","asc");
        $query = $this->db->get('sat_claveunidad', 60, 0);
        
        if($query -> num_rows() > 0 )      
            { return $query->result_array(); }
	    else
            { return array("value"=>0, "label"=>"No hay regisros buscando '".$criterio."'");   }        
    }

    public function searchUuidCfdiRelSAT($criterio)
    {
        $this->db->select  ('uuid as value, CONCAT("[", folio, "] [", uuid, "] [", total, "] [", moneda, "] [", fecha_timbrado, "] [", rfc, "] [", SUBSTRING(nombre, 1, 10),"...]")  as label', FALSE);
        $this->db->where   ("`uuid` is NOT NULL", NULL, FALSE);        
        $this->db->or_like ( array('uuid' => $criterio, 'folio' => $criterio, 'moneda' => $criterio, 'total' => $criterio, 'fecha_timbrado' => $criterio) );
        $this->db->order_by("uuid","asc");
        $query = $this->db->get('factura', 60, 0);
        
        if($query -> num_rows() > 0 )      
            { return $query->result_array(); }
	    else
            { return array("value"=>0, "label"=>"Sin registros: '".$criterio."' (click para seleccionar)");   }        
    }	


    public function traeFacturaByUUID($uuid)
    {

        $this->db->select('*');        
        $this->db->where ('f.uuid', $uuid);                
        $this->db->join  ('pedido_adjuntos pa', 'pa.uuid = f.uuid');        
        $query = $this->db->get('factura f');				 
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
            return array();
    }	
   
    public function traeFolioConseutivo()
    {
        $this->db->select('folio');
        $this->db->where('folio !=', -1);
        $this->db->where('status', STATUS_TIMBRADA);
        $this->db->order_by('fecha_timbrado DESC, folio DESC');
        $query = $this->db->get('factura');
		
        if($query->num_rows() > 0 )      
            return $query->result_array()[0]['folio'] + 1;
        else 
            return 1;
    }

    public function borraVistaPreviaFactura( $id_pedido )
    {
        $this->db->select('id_factura');
        $this->db->where('id_pedido', $id_pedido);
        $this->db->where('status', 'VPF');
        $this->db->order_by('fecha_timbrado DESC, folio DESC');
        $query = $this->db->get('factura');
		
        if($query -> num_rows() > 0 )
        {		              
            foreach ($query->result() as $f)							 
                    { $this->db->delete('factura_conceptos', array('id_factura' => $f->id_factura));
                      $this->db->delete('factura'          , array('id_factura' => $f->id_factura));
                      $this->db->delete('factura_cfdi_relacionados', array('id_factura' => $f->id_factura));
                    }
        }
    }

    public function inserta_cfdiRel($datos)
    {
        foreach($datos['CfdisRelacionados']['UUID'] as $cr)
        {  $data = array('id_factura'       => $datos['id_factura'],
                         'id_pedido'        => $datos['id_pedido'],
                         'uuid_relacionado' => $cr,
                         'tipo_relacion'    => $datos['CfdisRelacionados']['TipoRelacion'],
                         'tipo_comprobante' => $datos['factura']['tipocomprobante'],
                         'notas'            => $datos['factPDF']['notasCfdiRel'],
                        );

            $this->db->insert('factura_cfdi_relacionados',$data); 
        }
    }

    public function insert_factura_timbrada($datos)
    {
        
        $this->db->delete('factura_conceptos', array('id_factura' => $datos['id_factura']));
        $this->db->delete('factura', array('id_factura' => $datos['id_factura']));
        

        $data = array( 
        'id_factura' => $datos['id_factura'],
        'folio' => $datos['factura']['folio'],
        'id_pedido'  => $datos['id_pedido'],
        'descuento' => $datos['factura']['descuento']        ,
        'fecha_expedicion' => $datos['factura']['fecha_expedicion'] ,        
        'forma_pago' => $datos['factura']['forma_pago']       ,
        'forma_pagoDesc' => $datos['factura']['forma_pagoDesc']['Descripcion']   ,      
        'metodo_pago' => $datos['factura']['metodo_pago']      ,
        'metodo_pagoDesc' => $datos['factura']['metodo_pagoDesc']['Descripcion']  ,
        'LugarExpedicion' => $datos['factura']['LugarExpedicion']  ,       
        'moneda' => $datos['factura']['moneda']           ,
        'serie' => $datos['factura']['serie']            ,
        'subtotal' => $datos['factura']['subtotal']         ,
        'tipocambio' => $datos['factura']['tipocambio']       ,
        'tipocomprobante' => $datos['factura']['tipocomprobante']  ,
        'tipocomprobanteDesc' => $datos['factPDF']['tipocomprobanteDesc'],
        'total' => $datos['factura']['total']            ,
        'RegimenFiscal' => $datos['factura']['RegimenFiscal']    ,
        'RegimenFiscalDesc' => $datos['factPDF']['RegimenFiscalDesc']['Descripcion'],
        'totalConLetras' => $datos['factPDF']['totalConLetras']   ,
        'notas' => $datos['factPDF']['notas']            ,
        'rfc' => $datos['receptor']['rfc']     	      ,
        'nombre' => $datos['receptor']['nombre']  	      ,
        'UsoCFDI' => $datos['receptor']['UsoCFDI'] 	      ,
        'UsoCFDIDesc' => $datos['factPDF']['UsoCFDIDesc']['Descripcion'],
        'emailReceptor' => $datos['factPDF']['emailReceptor']   ,
        'cpReceptor' => $datos['factPDF']['cpReceptor'] 	,
        'impuesto' => $datos['impuestos']['translados'][0]['impuesto'],
	    'tasa' => $datos['impuestos']['translados'][0]['tasa'],
        'importe_imp' => $datos['impuestos']['translados'][0]['importe'],
        'TipoFactor' => $datos['impuestos']['translados'][0]['TipoFactor'],
        'base' => $datos['factPDF']['translados'][0]['base'],        
        'saldo_insoluto' => $datos['factura']['total'],
        'num_parcialidades' => 0,
        'uuid' => $datos['factura']['uuid'],
        'fecha_timbrado' =>	$datos['factura']['fecha_timbrado'],   
        'status' =>	$datos['factura']['status'],
        'representacion_impresa_certificado_no' => $datos['factura']['representacion_impresa_certificado_no'],
       // 'representacion_impresa_sello'          => $datos['factura']['representacion_impresa_sello'],
      //  'representacion_impresa_selloSAT'       => $datos['factura']['representacion_impresa_selloSAT'],        
        );
        $this->db->insert('factura',$data); 

        foreach($datos["pdfconceptos"] as $con)
            {                
                $data = array(
                    'id_factura' => $datos['id_factura'],
                    'id_pedido'  => $datos['id_pedido'],                 
                    'cantidad' => $con['cantidad'],				
                    'ID' => $con['ID'],
                    'descripcion' => $con['descripcion'],
                    'valorunitario' => $con['valorunitario'],
                    'importe' => $con['importe'],
                    'ClaveProdServ' => $con['ClaveProdServ'],
                    'ClaveUnidad' => $con['ClaveUnidad'],
                    'sumaIVA' => $con['sumaIVA'],
                    'Base' => $con['Impuestos']['Traslados'][0]['Base']==NULL?0:$con['Impuestos']['Traslados'][0]['Base'],
                    'Impuesto' => $con['Impuestos']['Traslados'][0]['Impuesto'],
                    'TipoFactor' => $con['Impuestos']['Traslados'][0]['TipoFactor'],
                    'TasaOCuota' => $con['Impuestos']['Traslados'][0]['TasaOCuota'],
                    'ImporteImp' => $con['Impuestos']['Traslados'][0]['Importe']==NULL?0:$con['Impuestos']['Traslados'][0]['Importe']
                    );
                $this->db->insert('factura_conceptos',$data);

                $this->db->where('id_cargo', $con['ID']);
                $this->db->update('pedido_cargos', array('status'=>$datos['factura']['status']));
            }
    }

    public function insert_rep_timbrada($datos)
    {
        try { 
        $data = array(
        'id_factura'    => $datos['id_factura'],
        'id_pedido'     => $datos['rep']['id_pedido'],
        'monto_rep'     => $datos['rep']['monto_rep'],
        'moneda_rep'    => $datos['rep']['moneda_rep'],
        'tc_rep'        => $datos['rep']['tc_rep'],
        'fecha_rep'     => $datos['rep']['fecha_rep'],
        'forma_pago_rep'=> $datos['rep']['forma_pago_rep'],
        'forma_pago_rep_desc'=> $datos['rep']['forma_pago_rep_desc'],
        'parcial_rep'      => $datos['rep']['parcial_rep'],
        'path_pdf'         => $datos['rep']['path_pdf'],
        'numoperacion'     => $datos['pagos10']['Pagos'][0]['NumOperacion'],
        'rfcemisorctacrd'  => $datos['pagos10']['Pagos'][0]['RfcEmisorCtaOrd'],
        'ctaordenante'     => $datos['pagos10']['Pagos'][0]['CtaOrdenante'],
        'rfcemisorctaben'  => $datos['pagos10']['Pagos'][0]['RfcEmisorCtaBen'],
        'ctabeneficiario'  => $datos['pagos10']['Pagos'][0]['CtaBeneficiario'],
        'impsaldoant'      => $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoAnt"],
        'imppagado'        => $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpPagado"],
        'impsaldoinsoluto' => $datos["pagos10"]["Pagos"][0]["DoctoRelacionado"][0]["ImpSaldoInsoluto"],
        'uuid'             => $datos['factura']['uuid'],
        'fecha_timbrado'   => $datos['factura']['fecha_timbrado']
        );
        $this->db->insert('factura_pagos',$data);
        } catch (Exception $e) {log_message('error', 'factura_pagos Excepción:'.$e->getMessage()); }	
    }

    public function actualizaFactura($id_factura, $data)
    { 
    try {    

        $this->db->where('id_factura', $id_factura);
        $this->db->update('factura', $data);

        } catch (Exception $e) {log_message('error', 'actualizaFactura Excepción:'.$e->getMessage()); }	
    }



    public function traeFacturasTimbradasFiltros($registros_x_pagina, $param)
    {                   
        $off  = (($param['pagina']-1) * $registros_x_pagina);
             	
        if ( $param['tipo'] == "FSI" )
           { $this->db->select('count(f.id_factura) as conteo');
             $this->db->where('saldo_insoluto !=', '0'); 
            }
        else 
           { $this->db->select('count(f.id_pedido) as conteo'); }        
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('f.id_pedido' => $param['f1'])); }

        if (!empty($param['f2']))
            { $this -> db -> or_like(array('f.rfc' => $param['f2'])); }

        if (!empty($param['f3']))
            { $this -> db -> or_like(array('f.nombre' => $param['f3'])); }        
        
        if (!empty($param['f4']))
            { $this -> db -> or_like(array('f.folio' => $param['f4'])); }                    

         if (!empty($param['fechaIni']) & !empty($param['fechaFin']))
            { $this->db->where("`f`.`fecha_timbrado` BETWEEN '".$param['fechaIni']."' AND '".$param['fechaFin']."'",NULL, FALSE ); }  


        $this->db->where("`f`.`uuid` is NOT NULL", NULL, FALSE);        
	    $this->db->from('factura f');      
        $query = $this->db->get()->result();
	    $conteo = $query[0]->conteo;				
       
        $this->db->select("DATE_FORMAT(`f`.`fecha_timbrado`,'%d/%m/%Y ') as fecha_factura", FALSE);
        if ( $param['tipo']=="FT" && $param['export']=="" )
           { $this->db->select('f.id_pedido,f.serie,f.id_factura,f.folio, f.nombre, f.rfc, f.total, f.importe_imp, f.saldo_insoluto, f.num_parcialidades,f.moneda'); 
             $this->db->select(",IF(`f`.`folio`=-1, `f`.`id_factura`, `f`.`folio`) as folio", FALSE); 
           }
           
        if ( $param['tipo']=="FT" && $param['export']=="1" )
           { $this->db->select('f.id_factura,f.serie,f.id_factura, f.id_pedido, f.rfc, f.nombre, f.descuento, f.subtotal, f.importe_imp, f.total, f.moneda, f.tipocambio, f.metodo_pago,f.metodo_pagoDesc, f.forma_pago,f.forma_pagoDesc, f.UsoCFDI, f.UsoCFDIDesc, f.notas, f.uuid '); 
             $this->db->select(",IF(`f`.`folio`=-1, `f`.`id_factura`, `f`.`folio`) as folio", FALSE); 
           }

        if( $param['tipo'] == "FSI" )
           { $this->db->select('f.id_factura,f.serie,f.folio, f.id_pedido, f.nombre, f.rfc, , f.descuento, f.subtotal, f.importe_imp, f.total, f.moneda, f.tipocambio, f.metodo_pago,f.metodo_pagoDesc, f.forma_pago,f.forma_pagoDesc, f.UsoCFDI, f.UsoCFDIDesc, f.notas, f.uuid, f.saldo_insoluto, f.num_parcialidades');
             $this->db->select(",IF(`f`.`folio`=-1, `f`.`id_factura`, `f`.`folio`) as folio, CONCAT(ABS( DATEDIFF(`f`.`fecha_timbrado`, NOW()) ), ' día(s) vencido ') as dias_vencidos", FALSE); 
             $this->db->where ('saldo_insoluto !=', '0');             
           }         
 
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('f.id_pedido' => $param['f1'])); }

        if (!empty($param['f2']))
            { $this -> db -> or_like(array('f.rfc' => $param['f2'])); }

        if (!empty($param['f3']))
            { $this -> db -> or_like(array('f.nombre' => $param['f3'])); }           
        
        if (!empty($param['f4']))
            { $this -> db -> or_like(array('f.folio' => $param['f4'])); }                    

        if (!empty($param['fechaIni']) & !empty($param['fechaFin']))
            { $this->db->where("`f`.`fecha_timbrado` BETWEEN '".$param['fechaIni']."' AND '".$param['fechaFin']."'",NULL, FALSE ); }  

        $this->db->where("`f`.`uuid` is NOT NULL", NULL, FALSE);
        
        $this->db->order_by("f.fecha_timbrado", ($param['tipo']=="FT" ? "desc" : "asc") );        
	    $queryP = $this->db->get('factura f', $registros_x_pagina, $off);        

        if($queryP -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryP->result_array(), "offset"=>$off); }
	    else 
           { return false;  } 

    }//traeFacturasTimbradasFiltros
   

    public function traePedidosParaFacturarFiltros($registros_x_pagina, $param)
    {                   
        $off  = (($param['pagina']-1) * $registros_x_pagina);

        $this->db->select('count(p.id_pedido) as conteo');           
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('p.id_pedido' => $param['f1'])); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('p.rfc' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('cl.razon_social' => $param['f3'])); }        
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
        if (!empty($param['fechaIni']) & !empty($param['fechaFin']))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '".$param['fechaIni']."' AND '".$param['fechaFin']."'",NULL, FALSE ); }              
        
        $this->db->join('clientes cl', 'cl.rfc = p.rfc');
        $this->db->where("0 != (SELECT count(pa.id_cargo) FROM pedido_cargos pa WHERE pa.id_pedido=p.id_pedido)",NULL, FALSE ); 
	    $this->db->from('pedidos p');      
        $query = $this->db->get()->result();
	    $conteo = $query[0]->conteo;
       
        $this->db->select("('') as folio, p.id_pedido, p.moneda, p.rfc, cl.razon_social as nombre, p.venta_tot as importe_imp, p.venta_tot as total");
	    $this->db->select("DATE_FORMAT(`p`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_factura", FALSE);       
        if (!empty($param['f1']))
            { $this -> db -> or_like(array('p.id_pedido' => $param['f1'])); }
        if (!empty($param['f2']))
            { $this -> db -> or_like(array('p.rfc' => $param['f2'])); }
        if (!empty($param['f3']))
            { $this -> db -> or_like(array('f.nombre' => $param['f3'])); }        
        if (!empty($param['fechaIni']) & !empty($param['fechaFin']))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '".$param['fechaIni']."' AND '".$param['fechaFin']."'",NULL, FALSE ); }  
                
        $this->db->join('clientes cl', 'cl.rfc = p.rfc');
        $this->db->where("0 != (SELECT count(pa.id_cargo) FROM pedido_cargos pa WHERE pa.id_pedido=p.id_pedido)",NULL, FALSE ); 
        $this->db->order_by("p.fecha_alta",  "desc" );        
	    $queryP = $this->db->get('pedidos p',$registros_x_pagina,$off);        

        if($queryP -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryP->result_array(), "offset"=>$off); }
	else 
            { return false;  }
    }//traePedidosParaFacturarFiltros


    public function validaListaNegraSAT($rfc)
    {
        $this->db->select('*');
        $this->db->like  ('rfc', $rfc);
        $query = $this->db->get('listado_completo_sat_69b');
        
        if($query -> num_rows() > 0 )
            { return array("enListaNegra" => TRUE , "detalle" => $query->result_array()[0] );  }
	    else
            { return array("enListaNegra" => FALSE, "detalle" => array() );                    }        
    }	


    /************ RECIBO DE NOMINA *************/
    public function traeRecibosNominasFiltros($registros_x_pagina, $param)
    {                   
        $off  = (($param['pagina']-1) * $registros_x_pagina);
             	
        $this->db->select('count(r.id_recibo) as conteo');                   

        if (!empty($param['fechaIni']) & !empty($param['fechaFin']))
            { $this->db->where("`r`.`FechaPago` BETWEEN '".$param['fechaIni']."' AND '".$param['fechaFin']."'",NULL, FALSE ); }  
        $this->db->where(array('r.correo_emp' => $param['correo']));
        $this->db->where("`r`.`uuid` is NOT NULL", NULL, FALSE);        
	    $this->db->from('recibos_nomina r');
        $query = $this->db->get()->result();
	    $conteo = $query[0]->conteo;				
       
        $this->db->select('*');	    
        $this->db->select("DATE_FORMAT(`r`.`FechaPago`,'%d/%m/%Y') as FechaPagoFormat", FALSE);       
        $this->db->select("DATE_FORMAT(`r`.`FechaInicialPago`,'%d/%m/%Y') as FechaInicialPagoFormat", FALSE);       
        $this->db->select("DATE_FORMAT(`r`.`FechaFinalPago`,'%d/%m/%Y') as FechaFinalPagoFormat", FALSE);       

        if (!empty($param['fechaIni']) & !empty($param['fechaFin']))
            { $this->db->where("`r`.`FechaPago` BETWEEN '".$param['fechaIni']."' AND '".$param['fechaFin']."'",NULL, FALSE ); }  
        $this->db->where(array('r.correo_emp' => $param['correo']));
        $this->db->where("`r`.`uuid` is NOT NULL", NULL, FALSE);
        $this->db->order_by("r.FechaPago", "desc" );        
	    $queryP = $this->db->get('recibos_nomina r',$registros_x_pagina,$off);        

        if($queryP -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryP->result_array(), "offset"=>$off); }
	else 
            { return false;  }
    }//traeFacturasTimbradasFiltros

    public function traeNominaBancoSAT()
    {
        $this->db->select('c_Banco, Descripcion');        
        $query = $this->db->get('sat_nomina_banco');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_Banco] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaPeriodicidadPagoSAT()
    {
        $this->db->select('c_PeriodicidadPago, Descripcion');        
        $query = $this->db->get('sat_nomina_periodicidadpago');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_PeriodicidadPago] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaRiesgoPuestoSAT()
    {
        $this->db->select('c_RiesgoPuesto, Descripcion');        
        $query = $this->db->get('sat_nomina_riesgopuesto');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_RiesgoPuesto] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaTipoContratoSAT()
    {
        $this->db->select('c_TipoContrato, Descripcion');        
        $query = $this->db->get('sat_nomina_tipocontrato');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoContrato] = $row->Descripcion; }
        }
	
        return $options;  
    }
    

    public function traeNominaTipoHorasSAT()
    {
        $this->db->select('c_TipoHoras, Descripcion');        
        $query = $this->db->get('sat_nomina_tipohoras');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoHoras] = $row->Descripcion; }
        }
	
        return $options;  
    }


    public function traeNominaTipoJornadaSAT()
    {
        $this->db->select('c_TipoJornada, Descripcion');        
        $query = $this->db->get('sat_nomina_tipojornada');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoJornada] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaTipoNominaSAT()
    {
        $this->db->select('c_TipoNomina, Descripcion');        
        $query = $this->db->get('sat_nomina_tiponomina');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoNomina] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaTipoRegimenSAT()
    {
        $this->db->select('c_TipoRegimen, Descripcion');        
        $query = $this->db->get('sat_nomina_tiporegimen');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoRegimen] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaEstadoSAT()
    {
        $this->db->select('c_Estado, nombre_estado');        
        $query = $this->db->get('sat_nomina_estado');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_Estado] = $row->nombre_estado; }
        }
	
        return $options;  
    }

    public function traeNominaOrigenRecursoSAT()
    {
        $this->db->select('c_OrigenRecurso, Descripcion');        
        $query = $this->db->get('sat_nomina_origenrecurso');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_OrigenRecurso] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaSindicalizadoSAT()
    {
        
        $options['No'] = 'No';        
	
        return $options;  
    }

    /**************AGREGAR*****************/
    public function traeNominaTipoPercepcionSAT()
    {
        $this->db->select('c_TipoPercepcion');
        $this->db->select('SUBSTRING(`Descripcion`, 1, 80) AS Descripcion', FALSE);         
        $query = $this->db->get('sat_nomina_tipopercepcion');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoPercepcion] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaTipoDeduccionSAT()
    {
        $this->db->select('c_TipoDeduccion');        
        $this->db->select('SUBSTRING(`Descripcion`, 1, 80) AS Descripcion', FALSE);
        $query = $this->db->get('sat_nomina_tipodeduccion');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoDeduccion] = $row->Descripcion; }
        }
	
        return $options;  
    }
    
    public function traeNominaTipoIncapacidadSAT()
    {
        $this->db->select('c_TipoIncapacidad');
        $this->db->select('SUBSTRING(`Descripcion`, 1, 80) AS Descripcion', FALSE);
        $query = $this->db->get('sat_nomina_tipoincapacidad');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoIncapacidad] = $row->Descripcion; }
        }
	
        return $options;  
    }

    public function traeNominaTipoOtroPagoSAT()
    {
        $this->db->select('c_TipoOtroPago');
        $this->db->select('SUBSTRING(`Descripcion`, 1, 80) AS Descripcion', FALSE);
        $query = $this->db->get('sat_nomina_tipootropago');
		
        if($query -> num_rows() > 0 )
        {		  
            $options[0] = '::Elegir::';
            foreach ($query->result() as $row)							 
                    { $options[$row->c_TipoOtroPago] = $row->Descripcion; }
        }
	
        return $options;  
    }    

    public function insert_recibo_nomina($datos)
    {        
        $this->db->delete('rn_percepciones',  array('id_recibo' => $datos['id_recibo'] ) );
        $this->db->delete('rn_deducciones',   array('id_recibo' => $datos['id_recibo'] ) );
        $this->db->delete('rn_otrospagos',    array('id_recibo' => $datos['id_recibo'] ) );
        $this->db->delete('rn_incapacidades', array('id_recibo' => $datos['id_recibo'] ) );
        $this->db->delete('recibos_nomina',   array('id_recibo' => $datos['id_recibo'] ) );

        $data = array(
        'id_recibo'              => $datos['id_recibo']
        ,'rfcEmisor'             => $datos['nomina12']['Emisor']['RfcPatronOrigen']
        ,'emailEmisor'           => $datos['PDF']['emailEmisor']
        ,'regimen_fiscalEmisor'  => $datos['factura']['RegimenFiscal']
        ,'RegistroPatronal'      => $datos['nomina12']['Emisor']['RegistroPatronal']
        ,'TipoNomina'            => $datos['nomina12']['TipoNomina']
        ,'NumDiasPagados'        => $datos['nomina12']['NumDiasPagados']
        ,'FechaPago'             => $datos['nomina12']['FechaPago']
        ,'FechaInicialPago'      => $datos['nomina12']['FechaInicialPago']
        ,'FechaFinalPago'        => $datos['nomina12']['FechaFinalPago']
        ,'origenRecurso'         => $datos['nomina12']['Emisor']['origenRecursos']
        ,'TotalPercepciones'     => $datos['nomina12']['TotalPercepciones']
        ,'TotalDeducciones'      => $datos['nomina12']['TotalDeducciones']
        ,'TotalOtrosPagos'       => $datos['nomina12']['TotalOtrosPagos']
        ,'nombre_emp'            => $datos['receptor']['nombre']
        ,'correo_emp'            => $datos['PDF']['correo_emp']
        ,'RFC_emp'               => $datos['receptor']['rfc']
        ,'Curp_emp'              => $datos['nomina12']['Receptor']['Curp'] 
        ,'NumSeguridadSocial'    => $datos['nomina12']['Receptor']['NumSeguridadSocial']
        ,'NumEmpleado'           => $datos['nomina12']['Receptor']['NumEmpleado']
        ,'puesto_emp'            => $datos['nomina12']['Receptor']['Puesto']
        ,'cve_entidad_emp'       => $datos['nomina12']['Receptor']['ClaveEntFed']
        ,'FechaInicioRelLaboral' => $datos['nomina12']['Receptor']['FechaInicioRelLaboral']
        ,'SalarioBaseCotApor'    => $datos['nomina12']['Receptor']['SalarioBaseCotApor']
        ,'SalarioDiarioIntegrado'=> $datos['nomina12']['Receptor']['SalarioDiarioIntegrado']
        ,'tipo_jornada_emp'      => $datos['tipo_jornada_emp']
        ,'sindi_emp'             => $datos['sindi_emp']	
        ,'periodo_emp'           => $datos['nomina12']['Receptor']['PeriodicidadPago']
        ,'tipo_regimen_emp'      => $datos['nomina12']['Receptor']['TipoRegimen']
        ,'tipo_contrato_emp'     => $datos['nomina12']['Receptor']['TipoContrato'] 
        ,'riesgo_emp'            => $datos['nomina12']['Receptor']['RiesgoPuesto'] 
        ,'banco_emp'             => $datos['nomina12']['Receptor']['Banco'] 
        ,'cuenta_banco_emp'      => $datos['nomina12']['Receptor']['CuentaBancaria']
        ,'tot_sueldo_emp'        => $datos['nomina12']['Percepciones']['TotalSueldos']
        ,'tot_gravado_emp'       => $datos['nomina12']['Percepciones']['TotalGravado']
        ,'tot_ext_emp'           => $datos['nomina12']['Percepciones']['TotalExento']        
        ,'tot_pag_dec_emp'       => $datos['tot_pag_dec_emp']
        ,'ano_serv_dec_emp'      => $datos['ano_serv_dec_emp']
        ,'ul_sueldo_dec_emp'     => $datos['ul_sueldo_dec_emp']
        ,'ing_acu_dec_emp'       => $datos['ing_acu_dec_emp']
        ,'ing_noacu_dec_emp'     => $datos['ing_noacu_dec_emp']
        ,'tot_o_deduc_emp'       => $datos['nomina12']['Deducciones']['TotalOtrasDeducciones']
        ,'tot_imp_ret_emp'       => $datos['nomina12']['Deducciones']['TotalImpuestosRetenidos']
        ,'uuid'                  => $datos['uuid']
        ,'fecha_timbrado'        =>	$datos['fecha_timbrado']
        ,'tipo_recibo'           =>	$datos['tipo_recibo']
        ,'filename'              =>	$datos['filename']
        ,'dir_cfdi'              =>	$datos['dir_cfdi']
        );
        $this->db->insert('recibos_nomina',$data); 

        if(isset($datos['nomina12']['Percepciones']))
        {
            $limite = count($datos['nomina12']['Percepciones']) - 3;
            for($i=0; $i < $limite; $i++)        
                {                               
                    $this->db->insert('rn_percepciones'
                                    , array('tipo'             => $datos['nomina12']['Percepciones'][$i]['TipoPercepcion']
                                            ,'clave'           => $datos['nomina12']['Percepciones'][$i]['Clave']
                                            ,'concepto'        => $datos['nomina12']['Percepciones'][$i]['Concepto']
                                            ,'importe_gravado' => $datos['nomina12']['Percepciones'][$i]['ImporteGravado']
                                            ,'importe_exento'  => $datos['nomina12']['Percepciones'][$i]['ImporteExento']
                                            ,'id_recibo'       => $datos['id_recibo']
                                            )
                                    );
                }
        }

        if(isset($datos['nomina12']['Deducciones']))
        {
            $limite = count($datos['nomina12']['Deducciones']) - 2;
            for($i=0; $i < $limite; $i++)                     
                {                                
                    $this->db->insert('rn_deducciones'
                                    , array('tipo'          => $datos['nomina12']['Deducciones'][$i]['TipoDeduccion']
                                            ,'clave'        => $datos['nomina12']['Deducciones'][$i]['Clave']
                                            ,'concepto'     => $datos['nomina12']['Deducciones'][$i]['Concepto']
                                            ,'importe'      => $datos['nomina12']['Deducciones'][$i]['Importe']
                                            ,'impuesto_ret' => $datos['nomina12']['Deducciones'][$i]['ir']
                                            ,'id_recibo'    => $datos['id_recibo']
                                            )
                                    );
                }
        }

        if(isset($datos['nomina12']['OtrosPagos']))
            foreach($datos['nomina12']['OtrosPagos'] as $o)
                {
                    $this->db->insert('rn_otrospagos'
                                    ,array('tipo'          => $o['TipoOtroPago']
                                            ,'clave'        => $o['Clave']
                                            ,'concepto'     => $o['Concepto']
                                            ,'importe'      => $o['Importe']                              
                                            ,'id_recibo'    => $datos['id_recibo']
                                            )
                                    );
                }               

        if(isset($datos['nomina12']['Incapacidades']))
            foreach($datos['nomina12']['Incapacidades'] as $i)
                {
                    $this->db->insert('rn_incapacidades'
                                    ,array('TipoIncapacidad'   => $i['TipoIncapacidad']
                                            ,'ImporteMonetario' => $i['ImporteMonetario']
                                            ,'DiasIncapacidad'  => $i['DiasIncapacidad']                                        
                                            ,'id_recibo'        => $datos['id_recibo']
                                            )
                                    );
                }                           
    }//insert_recibo_nomina


    public function traeReciboNominaById($id_recibo)
    {
        $recibo        = NULL;
        $deducciones   = NULL;        
        $percepciones  = NULL;
        $otrospagos    = NULL;
        $incapacidades = NULL;

        $this->db->select('*');
        $this->db->select("DATE_FORMAT(`FechaPago`,'%d/%m/%Y') as FechaPagoFormat", FALSE);       
        $this->db->select("DATE_FORMAT(`FechaInicialPago`,'%d/%m/%Y') as FechaInicialPagoFormat", FALSE);       
        $this->db->select("DATE_FORMAT(`FechaFinalPago`,'%d/%m/%Y') as FechaFinalPagoFormat", FALSE);       
        $this->db->select("DATE_FORMAT(`FechaInicioRelLaboral`,'%d/%m/%Y') as FechaInicioRelLaboralFormat", FALSE);       
        $this->db->where ('id_recibo', $id_recibo);
        $query = $this->db->get('recibos_nomina');		
        if( $query->num_rows() > 0 )      
          { $recibo = $query->result_array()[0]; }
        else 
          { $recibo = array();  }

        $this->db->select('*');        
        $this->db->where ('id_recibo', $id_recibo);
        $query = $this->db->get('rn_percepciones');		
        if( $query->num_rows() > 0 )      
          { $percepciones = $query->result_array(); }
        else 
          { $percepciones = array();  }   
          
        $this->db->select('*');        
        $this->db->where ('id_recibo', $id_recibo);
        $query = $this->db->get('rn_deducciones');		
        if( $query->num_rows() > 0 )      
          { $deducciones = $query->result_array(); }
        else 
          { $deducciones = array();  }

        $this->db->select('*');        
        $this->db->where ('id_recibo', $id_recibo);
        $query = $this->db->get('rn_otrospagos');		
        if( $query->num_rows() > 0 )      
          { $otrospagos = $query->result_array(); }
        else 
          { $otrospagos = array();  }

        $this->db->select('*');        
        $this->db->where ('id_recibo', $id_recibo);
        $query = $this->db->get('rn_incapacidades');		
        if( $query->num_rows() > 0 )      
          { $incapacidades = $query->result_array(); }
        else 
          { $incapacidades = array();  }


        return array('recibo' => $recibo, 'percepciones' => $percepciones, 'deducciones' => $deducciones, 'otrospagos' => $otrospagos, 'incapacidades' => $incapacidades);
	        
    }//traeReciboNominaById

    public function traeUltimoIdReciboNomina($correo)
    {
        $this->db->select  ('id_recibo');        
        $this->db->where   ('correo_emp', $correo);
        $this->db->order_by("FechaPago","DESC");
        $query = $this->db->get('recibos_nomina');
        if( $query->num_rows() > 0 )      
          { $recibo = $query->result_array()[0]; }
        else 
          { $recibo = array('id_recibo'=>0);  }

        return $recibo;

    }//traeUltimoIdReciboNomina

}//MODEL
