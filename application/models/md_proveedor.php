<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_proveedor extends CI_Model {
		
	
	public function insert_proveedor($rfc,$nombre,$correo_principal,$calle,$numero,$colonia,$delegacion,
								   	 $estado,$pais,$cp,$tipo_servicio,$obs,$id_prove)
    {
		$this->load->helper('date');
		$hoy = standard_date('DATE_W3C', time());
		
        $data = array(
            'rfc'          =>  $rfc,
            'nombre' 	   =>  $nombre,
            'correo'       =>  $correo_principal,
			'calle'        =>  $calle,
			'numero'       =>  $numero,			
			'colonia'      =>  $colonia,
			'delegacion'   =>  $delegacion,
			'estado'       =>  $estado,
			'pais'         =>  $pais,
			'cp'           =>  $cp,
            'fecha_alta'   =>  $hoy,
			'tipo_servicio'=>  $tipo_servicio,
			'obs'		   =>  $obs,
			'id_prove'	   =>  $id_prove
            );
            $this->db->insert('proveedor',$data);
    }
	
	public function insert_dc($id_prove,$contacto,$tel,$correo)
    {				
        $data = array(
            'id_prove' =>  $id_prove,
            'contacto' =>  $contacto,
            'telefeno' =>  $tel,
			'correo'   =>  $correo,			
            );
            $this->db->insert('dcc',$data);
    }
   
   public function traeDetalleProveedorPorEn($id_prove,$tabla,$t,$selectC)
    {							
		$this->db->select($selectC);
		if($tabla == "proveedor")		
			$this->db->join('catalogo c', 'c.id_opcion = '.$t.'.tipo_servicio','left outer');
		
		$this->db->where($t.'.id_prove',$id_prove);
		$query = $this->db->get($tabla.' '.$t);								        
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }	
   
   public function validaDuplicidad($rfc,$correo,$nombre)
    {        
        $this->db->select('rfc,nombre,correo,calle,numero,colonia,delegacion,cp,estado,pais');
        $this->db->from('proveedor ');
		if($rfc == NULL)
			$this->db->where('correo',$correo);
		else
			if($nombre == NULL)
        		$this->db->where('rfc',$rfc);
			else
				$this->db->where('nombre',$nombre);
       
        $query = $this->db->get();
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;     
    }
	
	public function poblarSelect($tipoServicio)
    {    					
        $this -> db -> select('pr.id_prove,pr.nombre');
        $this -> db -> order_by("pr.nombre","asc");
		
		if($tipoServicio != "0")
			$this->db->where('tipo_servicio',$tipoServicio);
			
        $query = $this -> db -> get('proveedor pr');
		
		$options = array();
        if($query -> num_rows() > 0 )
		{		  
		    $options[0] = '';
			foreach ($query->result() as $row)							 
				$options[$row->id_prove] = $row->nombre;				
		}
		
		return $options;  
    }
	
	public function poblarSelectAX($tipoServicio)
    {    					
        $this -> db -> select('pr.id_prove,pr.nombre');
        $this -> db -> order_by("pr.nombre","asc");
		
		if($tipoServicio != "0")
			$this->db->where('tipo_servicio',$tipoServicio);
			
        $query = $this -> db -> get('proveedor pr');
		
		$options = array();
		$options[] = array("id_prove" => 0,"nombre"  =>'');
		
        if($query -> num_rows() > 0 ) 		   
			foreach ($query->result() as $row)							 
				$options[] = array("id_prove" => $row->id_prove, "nombre" => $row->nombre);
		
		
		return $options;  
    }	
   
   
    public function traeProveFiltros($registros_x_pagina,$offset,$f1,$f2,$f3,$f4,$fechaIni,$fechaFin)
    {                   
        $off  = (($offset-1) * $registros_x_pagina);
             	
        $this -> db -> select('count(p.id_prove) as conteo');
        $this -> db -> from('proveedor p');
        $this -> db -> join('catalogo c', 'c.id_opcion = p.tipo_servicio','left outer');        
        if (!empty($f1))
            { $this -> db -> or_like(array('p.nombre' => $f1)); }
        if (!empty($f2))
            { $this -> db -> or_like(array('p.rfc' => $f2)); }
        if (!empty($f3))
            { $this -> db -> or_like(array('p.correo' => $f3)); }
        if (!empty($f4))
            { $this -> db -> or_like(array('p.tipo_servicio' => $f4)); }
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
        
        $query = $this->db->get()->result();
	$conteo = $query[0]->conteo;				
       
        $this -> db -> select('p.id_prove,p.nombre,p.correo,p.tipo_servicio as id_tipo_servicio,p.rfc,c.opcion_catalogo as tipo_servicio');
        $this -> db -> select("DATE_FORMAT(`p`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta", FALSE);
        $this -> db -> join('catalogo c', 'c.id_opcion = p.tipo_servicio','left outer');        
        if (!empty($f1))
            { $this -> db -> or_like(array('p.nombre' => $f1)); }
        if (!empty($f2))
            { $this -> db -> or_like(array('p.rfc' => $f2)); }
        if (!empty($f3))
            { $this -> db -> or_like(array('p.correo' => $f3)); }
        if (!empty($f4))
            { $this -> db -> or_like(array('p.tipo_servicio' => $f4)); }
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
            
        $this -> db -> order_by("p.nombre","asc");
        $queryP = $this->db->get('proveedor p',$registros_x_pagina,$off);			

        if($queryP -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryP->result_array(), "offset"=>$off); }
	else 
            { return false;  }
    }
   
   public function traeProveedores($registros_x_pagina,$offset)
    {
    	$this -> db -> select('count(p.id_prove) as conteo');
        $this -> db -> join('catalogo c', 'c.id_opcion = p.tipo_servicio','left outer');
        $this -> db -> from('proveedor p');        		
        $queryC = $this -> db -> get()-> result();
        $conteo = $queryC[0] -> conteo;		

        $this -> db -> select('p.id_prove,p.nombre,p.correo,p.tipo_servicio as id_tipo_servicio,p.rfc,c.opcion_catalogo as tipo_servicio');
        $this -> db -> select("DATE_FORMAT(`p`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta", FALSE);
        $this -> db -> join('catalogo c', 'c.id_opcion = p.tipo_servicio','left outer');
        $this -> db -> order_by("p.nombre","asc");		
        $query = $this -> db -> get('proveedor p',$registros_x_pagina,$offset);
		
	$pg_clientes= array("conteo"=>$conteo, "registros"=>$query->result_array());		

        if($query -> num_rows() > 0 )      
        {  return $pg_clientes;}
		else 
			return false;
        
    }	
	
	public function borraProveedor($id_prove)
	{
		$this->db->delete('proveedor', array('id_prove' => $id_prove));
		$this->delete_dc($id_prove);
	}
	
   public function delete_dc($id_prove)
    {
        $this->db->delete('dcc', array('id_prove' => $id_prove));
    }
	
	 public function update_proveedor($id_prove,$rfc,$nombre_cliente,$correo_principal,$calle,$numero,$colonia,$delegacion,
	 								  $estado,$pais,$cp,$tipo_servicio,$obs)
    {		
        $data = array(
            'rfc'          =>  $rfc,
            'nombre' 	   =>  $nombre_cliente,
            'correo'       =>  $correo_principal,
			'calle'        =>  $calle,
			'numero'       =>  $numero,			
			'colonia'      =>  $colonia,
			'delegacion'   =>  $delegacion,
			'estado'       =>  $estado,
			'pais'         =>  $pais,
			'cp'           =>  $cp,
			'tipo_servicio'=> $tipo_servicio,
			'obs'		   =>  $obs
            );
		
		$this->db->where('id_prove', $id_prove);
        $this->db->update('proveedor', $data);           
    }
}
