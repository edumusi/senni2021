<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_cotizador extends CI_Model {
					
  		
   public function traeCoti($coti, $registros_x_pagina,$offset)
    {
    	$this->db->select('count(co.id_coti) as conteo');
        $this->db->from('cotizacion co');
        $this->db->join('usuarios u', 'co.atentamente = u.correo','left outer');
	/*	if($usuario != "")
	        $this->db->where('p.correo',$usuario);		
	*/
        $queryC = $this->db->get()->result();
        $conteo = $queryC[0]->conteo;		
		
        $this->db->select('co.id_coti,co.prosp_nombre,co.prosp_empresa,co.asunto, co.prosp_tel, co.prosp_correo');
	$this->db->select("DATE_FORMAT(`co`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta,
			   CONCAT(`u`.`titulo`,' ',`u`.`nombre`,' ',`u`.`apellidos`) as at", FALSE);
	$this->db->join('usuarios u', 'co.atentamente = u.correo','left outer');
        $this->db->order_by("co.fecha_alta","desc");
        $query = $this->db->get('cotizacion co',$registros_x_pagina,$offset);
		
	$pg_coti= array("conteo"=>$conteo, "registros"=>$query->result_array());		
		
        if($query->num_rows() > 0 )      
            {return $pg_coti;}
        else 
            {return false;}
        
    }
 
    public function traeCotiFiltros($registros_x_pagina,$offset,$f1,$f2,$f3,$f4, $f5,$fechaIni,$fechaFin)
    {                   
        $off  = (($offset-1) * $registros_x_pagina);
         
    	$this->db->select('count(co.id_coti) as conteo');
        $this->db->from('cotizacion co');
        $this->db->join('usuarios u', 'co.atentamente = u.correo','inner outer');
        if (!empty($f1))
            { $this -> db -> or_like(array('co.prosp_nombre' => $f1)); }
        if (!empty($f2))
            { $this -> db -> or_like(array('co.prosp_empresa' => $f2)); }
        if (!empty($f3))
            { $this -> db -> or_like(array('co.asunto' => $f3)); }
        if (!empty($f4))
            { $this -> db -> or_like(array('co.atentamente' => $f4)); }
        if (!empty($f5))
            { $this -> db -> or_like(array('co.id_coti' => $f5)); }
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`co`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
        
        $query = $this->db->get()->result();
	$conteo = $query[0]->conteo;				

        $this->db->select('co.id_coti,co.prosp_nombre,co.prosp_empresa,co.asunto, co.prosp_tel, co.prosp_correo');
	$this->db->select("DATE_FORMAT(`co`.`fecha_alta`,'%d/%m/%Y') as fecha_alta,
			            CONCAT(`u`.`titulo`,' ',`u`.`nombre`,' ',`u`.`apellidos`) as at", FALSE);
	$this->db->join('usuarios u', 'co.atentamente = u.correo','inner outer');        
        if (!empty($f1))
            { $this -> db -> or_like(array('co.prosp_nombre' => $f1)); }
        if (!empty($f2))
            { $this -> db -> or_like(array('co.prosp_empresa' => $f2)); }
        if (!empty($f3))
            { $this -> db -> or_like(array('co.asunto' => $f3)); }
        if (!empty($f4))
            { $this -> db -> or_like(array('co.atentamente' => $f4)); }
        if (!empty($f5))
            { $this -> db -> or_like(array('co.id_coti' => $f5)); }
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`co`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
            
        $this->db->order_by("co.fecha_alta","desc");	
        $queryCoti = $this->db->get('cotizacion co',$registros_x_pagina,$off);			

        if($queryCoti -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryCoti->result_array(), "offset"=>$off); }
	else 
            { return false;  }
    }
	
    public function traeDetalleCoti($coti,$tipo_servicio,$tabla,$t,$selectC)
    {
        $this->db->select($selectC);
        $this->db->where($t.'.id_coti',$coti);
        if ($tipo_servicio != NULL)
            { $this->db->where($t.'.tipo_servicio',$tipo_servicio); }
        $query = $this->db->get($tabla.' '.$t);								        
						
        if($query->num_rows() > 0 )      
            { return $query->result_array(); }
	else 
            { return false; }
    }
    
    public function traeDetalleFechas($pedido,$tipo_servicio)
    {        
        $this->db->select("DATE_FORMAT(`etd`,'%d/%m/%Y' ) as etd, DATE_FORMAT(`eta`,'%d/%m/%Y' ) as eta", FALSE);
        $this->db->where('id_pedido',$pedido);
        if ($tipo_servicio != NULL)
            { $this->db->where('tipo_servicio',$tipo_servicio); }
        $query = $this->db->get("flete");								        
						
        if($query->num_rows() > 0 )      
            { return $query->result_array(); }
	else 
            { return array(array("eta"=>"","etd"=>"")); }
    }
    
    public function traeDetalleCotiPedido($tipo_servicio,$id_pedido,$tabla1,$where1,$select1,$id_coti,$tabla2,$where2,$select2)
    {        
        $this->db->select($select1);
        $this->db->where($where1,$id_pedido===NULL?'':$id_pedido);
        if ($tipo_servicio != NULL)
            { $this->db->where('tipo_servicio',$tipo_servicio); }
        $query = $this->db->get($tabla1);								        

        if($query->num_rows() > 0 )      
            { return $query->result_array(); }
	else 
            {
                $this->db->select($select2);
                $this->db->where($where2,$id_coti);
                if ($tipo_servicio != NULL)
                    { $this->db->where('tipo_servicio',$tipo_servicio); }
                $query = $this->db->get($tabla2);								        

                if($query->num_rows() > 0 )      
                    { return $query->result_array(); }
                else 
                    { return false; }
            }
    }	
	

    public function insert_coti($id_coti,$prosp_nombre,$prosp_empresa,$asunto,$prosp_correo,$prosp_tel,$coti_pdf,$atentamente,$hoy,$correo,$moneda,$tipo_cambio,$slAtte)
    {
    try{	
        $data = array(
            'id_coti'       =>   $id_coti,
            'prosp_nombre'  =>   $prosp_nombre,
	    'prosp_empresa' =>   $prosp_empresa,
            'asunto' 	    =>   $asunto,			
            'prosp_correo'  =>   $prosp_correo,
            'prosp_tel'     =>   $prosp_tel,
	    'coti_pdf'      =>   $coti_pdf,
	    'atentamente'   =>   $atentamente,			
            'fecha_alta'    =>   $hoy,
	    'creado_por'    =>   $correo,
        'moneda'        =>   $moneda,
        'tipo_cambio'   =>   $tipo_cambio,
            'slAtte'        =>   $slAtte 												
            );
            $this->db->insert('cotizacion',$data);
            
        } catch (Exception $e) {log_message('error', 'insert_coti Excepción:'.$e->getMessage()); }	
    }
	
	public function update_coti($id_coti,$prosp_nombre,$prosp_empresa,$asunto,$prosp_correo,$prosp_tel,$coti_pdf,$atentamente,$moneda,$tipo_cambio,$slAtte)
    {
        $data = array(
			'prosp_nombre'  =>   $prosp_nombre,
			'prosp_empresa' =>   $prosp_empresa,
            'asunto' 		=>   $asunto,			
            'prosp_correo'  =>   $prosp_correo,
			'prosp_tel'     =>   $prosp_tel,
			'coti_pdf'      =>   $coti_pdf,
			'atentamente'   =>   $atentamente,
            'moneda'    	=>   $moneda,
            'tipo_cambio'   =>   $tipo_cambio,
            'slAtte'    	=>   $slAtte    
            );
			
        $this->db->where('id_coti', $id_coti);
        $this->db->update('cotizacion', $data);  
    }
	
	public function insert_coti_concepto($concepto,$descripcion,$tipo_servicio,$id_coti)
    {
        $data = array(
            'id_coti'       =>   $id_coti,
			'concepto' 	 	=>   $concepto,
			'descripcion'   =>   $descripcion,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('coti_conceptos',$data);
    }
	
	public function insert_coti_sl($slnotas,$slterminos,$slconceptos,$slservicios,$tipo_servicio,$id_coti)
    {
        $data = array(
            'id_coti'       =>   $id_coti,
			'slnotas' 	 	=>   $slnotas,
			'slterminos'   =>   $slterminos,
			'slconceptos'   =>   $slconceptos,
			'slservicios'   =>   $slservicios,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('coti_sl',$data);
    }
	
	public function insert_coti_cargo($cargo,$importe,$iva,$tipo_servicio,$id_coti)
    {
        $data = array(
            'id_coti'       =>   $id_coti,
			'cargo' 	 	=>   $cargo,
			'importe'   	=>   $importe,
			'iva'   		=>   $iva,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('coti_cargos',$data);
    }
	
	public function insert_coti_nota($nota,$tipo_servicio,$id_coti)
    {
        $data = array(
            'id_coti'       =>   $id_coti,
			'nota' 	 		=>   $nota,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('coti_notas',$data);
    }
	
	public function insert_coti_termino($termino,$descripcion,$tipo_servicio,$id_coti)
    {
        $data = array(
            'id_coti'       =>   $id_coti,
			'termino' 	 	=>   $termino,
			'descripcion'   =>   $descripcion,
            'tipo_servicio' =>   $tipo_servicio								
            );
            $this->db->insert('coti_terminos',$data);
    }	
	
       
 
    public function borra_coti($id_coti)
    {
        $this->db->delete('coti_conceptos', array('id_coti' => $id_coti));
		$this->db->delete('coti_cargos',    array('id_coti' => $id_coti));
		$this->db->delete('coti_notas',     array('id_coti' => $id_coti));
		$this->db->delete('coti_terminos',  array('id_coti' => $id_coti));
		$this->db->delete('cotizacion',     array('id_coti' => $id_coti));
		$this->db->delete('coti_sl',     	array('id_coti' => $id_coti));
    }
	
	public function borra_detalle_coti($id_coti)
    {
        $this->db->delete('coti_conceptos', array('id_coti' => $id_coti));
		$this->db->delete('coti_cargos',    array('id_coti' => $id_coti));
		$this->db->delete('coti_notas',     array('id_coti' => $id_coti));
		$this->db->delete('coti_terminos',  array('id_coti' => $id_coti));
		$this->db->delete('coti_sl',     	array('id_coti' => $id_coti));
    }
	
	
	public function traeTemplateCotizacion()
	{
		$this->db->select('*');
        $query = $this->db->get('template_cotizacion');
						
        if($query->num_rows() > 0 )      
        {return $query->result_array(); }
        else 
        {return false;}
    }
	
	public function traeNombreCotiPDF($id_coti)
	{
		$this->db->select('coti_pdf');
		$this->db->where('id_coti',$coti);
        $query = $this->db->get('cotizacion');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }
	 
	public function traeMonedaCoti($id_coti)
	{
		$this->db->select('moneda, tipo_cambio');
		$this->db->where('id_coti',$id_coti);
        $query = $this->db->get('cotizacion');
						
        if($query->num_rows() > 0 )      
            { return $query->result_array()[0];  }
        else 
            { return false;                      }      
    }

    public function traeTCCoti($id_coti)
	{
		$this->db->select('tipo_cambio');
		$this->db->where('id_coti',$id_coti);
        $query = $this->db->get('cotizacion');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }
	
	public function traeEncabezadoCoti($id_coti)
	{
		$this->db->select('prosp_empresa,prosp_nombre,prosp_correo,prosp_tel');
		$this->db->where('id_coti',$id_coti);
        $query = $this->db->get('cotizacion');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }	
	
	 public function poblarSelect()
    {    						
        $this -> db -> select('id_coti, prosp_nombre, prosp_empresa');
        $this -> db -> select("DATE_FORMAT(`fecha_alta`,'%d/%m/%Y %H:%i') as fecha_alta_f", FALSE);
        $this -> db -> order_by("fecha_alta","DESC");		
        $query = $this -> db -> get('cotizacion');
		
	$options = array();
	
        if($query -> num_rows() > 0 )
		{		  
		    $options[0] = '';
			foreach ($query->result() as $row)							 
				$options[$row->id_coti] = $row->prosp_nombre.' - '.$row->prosp_empresa.'('.$row->id_coti.') ('.$row->fecha_alta_f.')';				          	   
		}
		return $options;        
    }	
}
