<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_pedido extends CI_Model {
		
	
        public function traePedidosFiltros($registros_x_pagina,$offset,$f1,$f2,$f3,$f4,$f5,$f6,$f7,$fechaIni,$fechaFin,$deF8,$aF8)
        {                   
            $off  = (($offset-1) * $registros_x_pagina);

            $this->db->select('count(p.id_pedido) as conteo');
            $this->db->from('pedidos p');
            $this->db->join('catalogo c', 'c.id_opcion = p.carrier','left outer');
            $this->db->join('catalogo s', 's.id_opcion = p.status','left outer');
            $this->db->join('clientes cl', 'cl.rfc = p.rfc','left outer');
            if (!empty($f1))
                { $this -> db -> or_like(array('p.id_pedido' => $f1)); }
            if (!empty($f2))
                { $this -> db -> or_like(array('p.num_mbl' => $f2)); }
            if (!empty($f3))
                { $this -> db -> or_like(array('p.num_hbl' => $f3)); }
            if (!empty($f4))
                {  $this->db->where('p.status =',$f4); }
            if (!empty($f5))
                { $this->db->where('p.rfc =', $f5); }
            if (!empty($f6))
                { $this->db->where('p.carrier =', $f6); }
            if (!empty($f7))
                { $this->db->where('p.moneda =', $f7); }                             
            if (!empty($fechaIni) & !empty($fechaFin))
                { $this->db->where("`p`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
            if (!empty($deF8) & !empty($aF8))
                { $this->db->where("`p`.`profit` BETWEEN $deF8 AND $aF8",NULL, FALSE ); } 
            
            $queryC = $this->db->get()->result();
            $conteo = $queryC[0]->conteo;
            
            $this->db->select('p.id_pedido,s.opcion_catalogo, status_track as status,p.rfc,cl.razon_social,c.opcion_catalogo as carrier,p.num_mbl,p.fecha_alta,adjunto_mbl,adjunto_hbl,adjunto_facturaP,adjunto_le,adjunto_factura,adjunto_poliza,adjunto_cartaporte');
            $this->db->join('catalogo c', 'c.id_opcion = p.carrier','left outer');
            $this->db->join('catalogo s', 's.id_opcion = p.status','left outer');
            $this->db->join('clientes cl', 'cl.rfc = p.rfc','left outer');
            if (!empty($f1))
                { $this -> db -> or_like(array('p.id_pedido' => $f1)); }
            if (!empty($f2))
                { $this -> db -> or_like(array('p.num_mbl' => $f2)); }
            if (!empty($f3))
                { $this -> db -> or_like(array('p.num_hbl' => $f3)); }
            if (!empty($f4))
                {  $this->db->where('p.status =',$f4); }
            if (!empty($f5))
                { $this->db->where('p.rfc =', $f5); }
            if (!empty($f6))
                { $this->db->where('p.carrier =', $f6); }
            if (!empty($f7))
                { $this->db->where('p.moneda =', $f7);  }                             
            if (!empty($fechaIni) & !empty($fechaFin))
                { $this->db->where("`p`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
            if (!empty($deF8) & !empty($aF8))
                { $this->db->where("`p`.`profit` BETWEEN $deF8 AND $aF8",NULL, FALSE ); }  
                
            $this->db-> order_by("p.fecha_alta","DESC");
            $queryP    = $this->db->get('pedidos p',$registros_x_pagina,$off);
            $reg       = $queryP->result_array();
            $registros = array();            
            
            foreach($reg as $r)
            {
              $adjuntos  = $this->traeAdjuntosPedido($r['id_pedido']);                       
              $registros[] = array('id_pedido'=>$r['id_pedido'],'status'=>$r['status'], 'rfc'=>$r['rfc'], 'razon_social'=>$r['razon_social'], 'carrier'=>$r['carrier'], 'num_mbl'=>$r['num_mbl'], 'fecha_alta'=>$r['fecha_alta'], 'adjuntos' => $adjuntos );             
            }

            if($queryP->num_rows() > 0 )      
               { return array("conteo"=>$conteo, "registros"=>$registros, "offset"=>$off,"f7"=>$f7,"deF8"=>$deF8,"aF8"=>$aF8); }
            else 
               { return false;  }
        }        
    
	public function traePedidos($usuario, $registros_x_pagina,$offset)
    {
    	$this->db->select('count(p.id_pedido) as conteo');
        $this->db->from('pedidos p');
        $this->db->join('catalogo c', 'c.id_opcion = p.carrier','left outer');
        $this->db->join('catalogo s', 's.id_opcion = p.status','left outer');
        $this->db->join('clientes cl', 'cl.rfc = p.rfc');
	/*	if($usuario != "")
	        $this->db->where('p.correo',$usuario);		
	*/
        $this->db->where('p.status !=',STATUS_ELIMINADO);//status de eliminado
        $queryC = $this->db->get()->result();
        $conteo = $queryC[0]->conteo;		
		
        $this->db->select('p.id_pedido,s.opcion_catalogo as status,p.rfc,cl.razon_social,
						  c.opcion_catalogo as carrier,p.num_mbl,p.fecha_alta,
						   adjunto_mbl,adjunto_hbl,adjunto_facturaP,adjunto_le,adjunto_factura,adjunto_poliza,adjunto_cartaporte');
/*		$this->db->select("DATE_FORMAT(`p`.`etd`,'%d/%m/%Y') as etd, 																																																						
						   DATE_FORMAT(`p`.`eta`,'%d/%m/%Y') as eta", FALSE);
        if($usuario != "")
	        $this->db->where('p.correo',$usuario);
*/
		$this->db->join('catalogo c', 'c.id_opcion = p.carrier','left outer');
		$this->db->join('catalogo s', 's.id_opcion = p.status','left outer');
		$this->db->join('clientes cl', 'cl.rfc = p.rfc');
		$this->db->where('p.status !=',STATUS_ELIMINADO);//status de eliminado
        $this->db->order_by("p.fecha_alta","desc");		
        $query = $this->db->get('pedidos p',$registros_x_pagina,$offset);
		
		$pg_rastreo= array("conteo"=>$conteo, "registros"=>$query->result_array());		
		
        if($query->num_rows() > 0 )      
            return $pg_rastreo;
		else 
			return false;
        
    }
				
public function delete_pedido_adjunto($id_pedido,$id_adjunto)
    {
        $this->db->delete('pedido_adjuntos', array('id_pedido' => $id_pedido, 'id_adjunto'=>$id_adjunto));
    }
    
    public function  insert_pedido_adjunto($data)
    {
        $this->db->insert('pedido_adjuntos',$data);
        
        $this->db->select('id_adjunto');
	$this->db->where ($data);					
        $query = $this->db->get('pedido_adjuntos');
        if( $query->num_rows() > 0 )
          { return $query->result_array()[0]['id_adjunto']; }
	else 
          { return 0;                                       }
    }
    


    public function traeAdjuntosPedido($id_pedido)
    {
        $this->db->select('*');
	    $this->db->where ('id_pedido', $id_pedido);
        $this->db->order_by("tipo","DESC");
        $query = $this->db->get('pedido_adjuntos');
        
        return $query->result_array();
    }
    
    public function traeAdjuntosPedidoPublicos($id_pedido)
    {
        $this->db->select('*');
        $this->db->where ('id_pedido', $id_pedido);
        $this->db->where ('SEGURIDAD', DOC_PUBLICO);
        $this->db->order_by("tipo","DESC");
        $query = $this->db->get('pedido_adjuntos');
        
        return $query->result_array();
    }

    public function traeAdjuntosFactura($id_pedido)
    {
        $this->db->select('*');
        $this->db->where ('id_pedido', $id_pedido);
        $this->db->where ('tipo', 'FACTURA');        
        $query = $this->db->get('pedido_adjuntos');
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else 
            return array();
    }

    public function traeAdjuntosREP($id_pedido)
    {
        $this->db->select('*');
        $this->db->where ('id_pedido', $id_pedido);
        $this->db->where ('tipo', 'REP');        
        $query = $this->db->get('pedido_adjuntos');
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else 
            return array();
    } 

    public function traeAdjuntosFacturaREP($id_pedido)
    {
        $this->db->select('pa.adjunto, pa.filename, pa.desc_adjunto, f.id_factura, f.moneda, f.uuid, f.status, f.saldo_insoluto, f.total, f.num_parcialidades');
        $this->db->select("DATE_FORMAT(`f`.`fecha_timbrado`,'%d/%m/%Y %H:%i') as fecha_timbrado", FALSE);       
        $this->db->select("(CONCAT(`f`.`serie`,IF(`f`.`folio`=-1, `f`.`id_factura`, `f`.`folio`))) as folio", FALSE); 
        $this->db->select("IF(`f`.`saldo_insoluto` != 0 AND DATEDIFF(`f`.`fecha_timbrado`, NOW()) < 0,  CONCAT(ABS( DATEDIFF(`f`.`fecha_timbrado`, NOW()) ), ' día(s) vencido '), '' ) as dias_vencidos", FALSE);
        $this->db->where ('pa.id_pedido', $id_pedido);
        $this->db->where ('pa.tipo', 'FACTURA');      
        $this->db->join  ('factura f', 'f.uuid = pa.uuid', 'left outer');   
        $query = $this->db->get('pedido_adjuntos pa');        
        if($query->num_rows() > 0 )      
            return $query->result_array();
        else  
            return array();
    }

	public function creaNotificaciones()
	{
	try {
		$this->load->helper('date');
		
		$dateH 	  = new DateTime();
		$dateH 	  -> setTimestamp(time());
		$thisWeek = $dateH->format("W")-1;

		$fecha_alta = standard_date('DATE_W3C', time());

        $this -> db -> select('f.id_pedido, n.visto');
		$this -> db -> select("DATE_FORMAT(`f`.`eta`,'%d/%m/%Y') as eta", FALSE);
		$this -> db -> join('notificaciones n', 'n.id_pedido = f.id_pedido','left outer');
		$this -> db -> where('WEEK(f.eta)',$thisWeek);		

        $query = $this -> db -> get('flete f');

		$notificaciones = $query -> result_array();
		
		$notiFull = array();
		
		foreach($notificaciones as $n)
		{
			$desc = 'ETA cercana '.$n['eta'];			

			$noti = array(
			'tipo'        => 'eta',
			'descripcion' => $desc,
			'id_pedido'   => $n['id_pedido'],
			'fecha_alta'  => $fecha_alta
			);
			if($n['visto'] == '0')
				$notiFull[] = $noti;
			if( is_null($n['visto']) === TRUE )
			{				
				$notiFull[] = $noti;
				$this -> db -> insert('notificaciones',$noti);
			}
		}
		
		$this -> db -> select('t.id_pedido, n.visto');
		$this -> db -> select("DATE_FORMAT(`t`.`entrega`,'%d/%m/%Y') as entrega", FALSE);
		$this -> db -> join('notificaciones n', 'n.id_pedido = t.id_pedido','left outer');
		$this -> db -> where('WEEK(t.entrega)',$thisWeek);		

        $query = $this -> db -> get('transporte t');
		$notificaciones = $query -> result_array();
						
		foreach($notificaciones as $n)
		{
			$desc = 'Entrega Trans. '.$n['entrega'];			

			$noti = array(
			'tipo'        => 'entrega',
			'descripcion' => $desc,
			'id_pedido'   => $n['id_pedido'],
			'fecha_alta'  => $fecha_alta
			);
			if($n['visto'] == '0')
				$notiFull[] = $noti;
			if( is_null($n['visto']) === TRUE )
			{				
				$notiFull[] = $noti;
				$this -> db -> insert('notificaciones',$noti);
			}
		}
		
		$this -> db -> select('r.id_pedido, r.fecha_alta, n.visto');
		$this -> db -> join('notificaciones n', 'n.id_pedido = r.id_pedido','left outer');
		$this -> db -> where('WEEK(r.fecha_alta)',$thisWeek);		

        $query = $this -> db -> get('retroalimentacion r');
		$notificaciones = $query -> result_array();
						
		foreach($notificaciones as $n)
		{
			$desc = 'Restroalimentacion';

			$noti = array(
			'tipo'        => 'retro',
			'descripcion' => $desc,
			'id_pedido'   => $n['id_pedido'],
			'fecha_alta'  => $fecha_alta
			);
			if($n['visto'] == '0')
				$notiFull[] = $noti;
			if( is_null($n['visto']) === TRUE )
			{				
				$notiFull[] = $noti;
				$this -> db -> insert('notificaciones',$noti);
			}
		}
		
		return $notiFull;
	} catch (Exception $e) {echo 'creaNotificaciones Excepción: ',  $e->getMessage(), "\n";}	
	}
	
	
	public function notificacionRevisada($num_guia,$correo)
	{
            $data = array('visto_por' => $correo,'visto'=> true);
            $this->db->where('id_pedido', $num_guia);
            $this->db->update('notificaciones', $data);
	}
	
	public function traeDetallePorEn($num_guia,$tabla,$t,$selectC,$fechas)
    {		
		if($tabla == "pedidos")
		{			
			$this->db->join('catalogo c',   'c.id_opcion = p.carrier','left outer');
			$this->db->join('catalogo s',   's.id_opcion = p.status','left outer');
			$this->db->join('catalogo cg',  'cg.id_opcion = p.carta_garantia','left outer');
			$this->db->join('catalogo tcg', 'tcg.id_opcion = p.carta_no','left outer');
                        $this->db->join('catalogo te',  'te.id_opcion = p.tipo_embarque','left outer');
			$this->db->join('clientes cl',  'cl.rfc = p.rfc');			
		}					
		if( $tabla == "transporte")		
                  { $this->db->join('catalogo ct', 'ct.id_opcion = t.regreso_vacio','left outer'); }

		if($tabla == "flete")		
                  { $this->db->join('catalogo cf', 'cf.id_opcion = f.verificacion_origen','left outer'); }
		
		$this->db->select($selectC);
		
		if( $fechas != NULL)		
                  { $this->db->select($fechas, FALSE); }
		
		$this->db->where($t.'.id_pedido',$num_guia);
		$query = $this->db->get($tabla.' '.$t);								        
						
                if( $query->num_rows() > 0 )      
                  { return $query->result_array(); }
                else 
                  { return false;                  }
    }	
	
	//ejemplo nuevo usuario en la tabla users
    public function insert_pedido($id_pedido, $correo, $fecha_alta, $rfc, $carrier, $shipper, $carta_garantia, 
                                    $carta_no, $monto_carta_no,$num_booking, $num_contenedorNO, $num_mbl, $num_hbl, 
                                    $vessel_voyage, $ins_envio,
                                    $ins_booking, $revalidar_aa,$num_contenedor,
                                    $adjunto_mbl,$adjunto_hbl,$adjunto_facturaP,$adjunto_le,$adjunto_factura,
                                    $adjunto_poliza,$adjunto_cartaporte,
                                    $profit_origen,$profit,$costo_tot,$venta_tot,$comision_ventas,$comision_operaciones,
                                    $id_coti,$moneda)
    {
        $data = array(
            'id_pedido'        	 =>   $id_pedido,
            'correo'           	 =>   $correo,
            'fecha_alta'  	 =>   $fecha_alta,
            'rfc'         	 =>   $rfc,
            'carrier'          	 =>   $carrier,
            'shipper'  		 =>   $shipper,
            'carta_garantia'   	 =>   $carta_garantia,
            'carta_no'  	 =>   $carta_no,
            'monto_carta_no'   	 =>   $monto_carta_no,
            'num_booking'  	 =>   $num_booking,            
            'num_mbl'  	  	 =>   $num_mbl,
            'num_hbl'  		 =>   $num_hbl,
            'vessel_voyage'    	 =>   $vessel_voyage,							
            'ins_envio'  	 =>   $ins_envio,
            'ins_booking' 	 =>   $ins_booking,						
            'revalidar_aa' 	 =>   $revalidar_aa,
            'num_contenedor'   	 =>   $num_contenedor,
            'adjunto_mbl'  	 =>   $adjunto_mbl,
            'adjunto_hbl'  	 =>   $adjunto_hbl,
            'adjunto_facturaP' 	 =>   $adjunto_facturaP,
            'adjunto_le'  	 =>   $adjunto_le,
            'adjunto_factura'  	 =>   $adjunto_factura,
            'adjunto_poliza'   	 =>   $adjunto_poliza,
            'adjunto_cartaporte' =>   $adjunto_cartaporte,
            'profit_origen'      =>   $profit_origen,
            'profit'             =>   $profit,
            'costo_tot'          =>   $costo_tot,
            'venta_tot'          =>   $venta_tot,
            'comision_ventas'   =>   $comision_ventas,
            'comision_operaciones' =>   $comision_operaciones,
            'id_coti'		 =>   $id_coti,
            'moneda'		 =>   $moneda
            );
            $this->db->insert('pedidos',$data);
    }
   
    public function insertaPedido($data)
    {
     try {   
            $this->db->insert('pedidos',$data);
         } catch (Exception $e) {log_message('error', 'insertaPedido Excepción:'.$e->getMessage()); }	
    }
    
    public function actualizaPedido($id_pedido,$data)
    { 
    try {    
        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('pedidos', $data);
        } catch (Exception $e) {log_message('error', 'actualizaPedido Excepción:'.$e->getMessage()); }	
    }
    
    public function update_pedido($id_pedido, $correo, $fecha_alta, $rfc, $carrier, $shipper, $carta_garantia, 
                                $carta_no, $monto_carta_no,$num_booking, $num_contenedorNO, $num_mbl, $num_hbl, 
                                $vessel_voyage, $ins_envio,
                                $ins_booking, $revalidar_aa,$num_contenedor,
                                $adjunto_mbl,$adjunto_hbl,$adjunto_facturaP,$adjunto_le,$adjunto_factura,
                                $adjunto_poliza,$adjunto_cartaporte,
                                $profit_origen,$profit,$costo_tot,$venta_tot,$comision_ventas,$comision_operaciones,
                                $id_coti,$moneda,$tipo_embarque)
    {
        $data = array(            
            'correo'           	 =>   $correo,            
            'rfc'         	 =>   $rfc,
            'carrier'          	 =>   $carrier,
            'shipper'  		 =>   $shipper,
            'carta_garantia'   	 =>   $carta_garantia,
            'carta_no'  	 =>   $carta_no,
            'monto_carta_no'   	 =>   $monto_carta_no,
            'num_booking'  	 =>   $num_booking,            
            'num_mbl'  	  	 =>   $num_mbl,
            'num_hbl'  		 =>   $num_hbl,
            'vessel_voyage'    	 =>   $vessel_voyage,						
            'ins_envio'  	 =>   $ins_envio,
            'ins_booking' 	 =>   $ins_booking,						
            'revalidar_aa' 	 =>   $revalidar_aa,
            'num_contenedor'  	 =>   $num_contenedor,
            'adjunto_mbl'  	 =>   $adjunto_mbl,
            'adjunto_hbl'  	 =>   $adjunto_hbl,
            'adjunto_facturaP' 	 =>   $adjunto_facturaP,
            'adjunto_le'  	 =>   $adjunto_le,
            'adjunto_factura'  	 =>   $adjunto_factura,
            'adjunto_poliza'     =>   $adjunto_poliza,
            'adjunto_cartaporte' =>   $adjunto_cartaporte,
            'fecha_modificacion' =>   $fecha_alta,
            'profit_origen'      =>   $profit_origen,
            'profit'             =>   $profit,
            'costo_tot'          =>   $costo_tot,
            'venta_tot'          =>   $venta_tot,
            'comision_ventas'   =>   $comision_ventas,
            'comision_operaciones' =>   $comision_operaciones,
            'id_coti'		 =>   $id_coti,
            'moneda'		 =>   $moneda,
            'tipo_embarque'      =>   $tipo_embarque
            );
        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('pedidos', $data);
    }
   
   
   public function insert_pedido_concepto($concepto,$descripcion,$tipo_servicio,$id_pedido)
    {
        $data = array(
            'id_pedido'     =>   $id_pedido,
			'concepto' 	 	=>   $concepto,
			'descripcion'   =>   $descripcion,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('pedido_conceptos',$data);
    }
	
	public function insert_pedido_cargo($cargo,$importe,$unidad,$subtotal,$tipo,$iva,$tipo_servicio,$status,$id_pedido)
    {
        $data = array(
            'id_pedido'     =>   $id_pedido,
			'cargo' 	 	=>   $cargo,
			'importe'   	=>   $importe,
            'unidad'   		=>   $unidad,            
            'subtotal'   	=>   $subtotal,
            'tipo'   		=>   $tipo,
			'iva'   		=>   $iva,
            'status'   		=>   $status,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('pedido_cargos',$data);
    }
	
	
	public function insert_pedido_termino($termino,$descripcion,$tipo_servicio,$id_pedido)
    {
        $data = array(
            'id_pedido'     =>   $id_pedido,
			'termino' 	 	=>   $termino,
			'descripcion'   =>   $descripcion,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('pedido_terminos',$data);
    }	
   
    public function delete_pedido_termino($id_pedido)
    {
        $this->db->delete('pedido_terminos', array('id_pedido' => $id_pedido));
    }
	
	public function delete_pedido_cargo($id_pedido)
    {
        $this->db->delete('pedido_cargos', array('id_pedido' => $id_pedido));
    }
	
	public function delete_pedido_concepto($id_pedido)
    {
        $this->db->delete('pedido_conceptos', array('id_pedido' => $id_pedido));
    }
 
    //ejemplo actualizar los datos del usuario con id = 3
    public function borra_pedido($id_pedido)
    {
        $data = array('status' => STATUS_ELIMINADO);
        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('pedidos', $data);
    }
	
	
	 public function actualizaStatus($id_pedido,$status)
    {
        $data = array('status' =>$status);
        $this->db->where('id_pedido', $id_pedido);
        $this->db->update('pedidos', $data);
    }
	
	public function traeStatus($id_pedido)
	{
		$this->db->select('status');
		$this->db->where('id_pedido', $id_pedido);
       $query = $this->db->get('pedidos');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }
	
	public function traeDatosSL()
	{
		$this->db->select('*');		
        $query = $this->db->get('datos_senni');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }
	
	public function traeCuentasSL($rfc)
	{
		$this->db->select('*');
		 $this->db->where('rfc',$rfc);
        $query = $this->db->get('cuentas_senni');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }


    public function traeCargosTimbrarAX($id_pedido)
	{
		$this->db->select('*');
        $this->db->where('id_pedido'  ,$id_pedido);
        $this->db->where('tipo'       ,'VENTA');
        $this->db->where('importe !=' , '0');
        $this->db->where("`status` is NULL", NULL, FALSE);

        $query = $this->db->get('pedido_cargos');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return array();   
    }

    public function traeNumCargos($id_pedido)
	{
		$this->db->select('*');
        $this->db->where('id_pedido'  ,$id_pedido);
        $this->db->where('tipo'       ,'VENTA');
        $this->db->where('importe !=' , '0');

        $query = $this->db->get('pedido_cargos');
						
        if($query->num_rows() > 0 )      
            return 1;
		else 
			return 0;    
    }

    public function traeMonedaTimbrarAX($id_pedido)
	{
		$this->db->select('moneda, tipo_cambio');
        $this->db->where('id_pedido',$id_pedido);        

        $query = $this->db->get('pedidos');
						
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
		else 
			return array();
    }
    
    
	public function traeDetalleCoti($id_pedido,$tipo_servicio,$tabla,$t,$selectC)
    {		
//		if($tabla == "cotizador")
//			$this->db->join('catalogo c', 'c.id_opcion = co.estatus','left outer');

		$this->db->select($selectC);
		if($t == "ct")
			$this->db->join('catalogo c', 'c.id_opcion = ct.descripcion','left outer');
			
		$this->db->where($t.'.id_pedido',$id_pedido);
		if ($tipo_servicio != NULL)
			$this->db->where($t.'.tipo_servicio',$tipo_servicio);
		$query = $this->db->get($tabla.' '.$t);								        
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }	
	
}//Model
