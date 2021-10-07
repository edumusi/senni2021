<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_cliente extends CI_Model {
					
  		
    public function insert_cliente($rfc,$nombre_cliente,$correo_principal,$calle,$numero,$colonia,$delegacion,
								   $estado,$pais,$cp,$dias_vencimiento)
    {
		$this->load->helper('date');
		$hoy = standard_date('DATE_W3C', time());
		
        $data = array(
            'rfc'          =>  $rfc,
            'razon_social' =>  $nombre_cliente,
            'correo'       =>  $correo_principal,
            'calle'        =>  $calle,
            'numero'       =>  $numero,			
            'colonia'      =>  $colonia,
            'delegacion'   =>  $delegacion,
            'estado'       =>  $estado,
            'pais'         =>  $pais,
            'cp'           =>  $cp,
            'dias_vencimiento'=>  $dias_vencimiento,
            'fecha_alta'   =>  $hoy
            );
            $this->db->insert('clientes',$data);
    }
	
	public function insert_dc($rfc,$contacto,$tel,$correo)
    {				
        $data = array(
            'rfc'      =>  $rfc,
            'contacto' =>  $contacto,
            'telefeno' =>  $tel,
			'correo'   =>  $correo,			
            );
            $this->db->insert('dcc',$data);
    }
   
   public function traeDetalleClientePorEn($rfc,$tabla,$t,$selectC)
    {							
		$this->db->select($selectC);
		$this->db->where($t.'.rfc',$rfc);
		$query = $this->db->get($tabla.' '.$t);								        
						
        if($query->num_rows() > 0 )      
            { return $query->result_array();}
        else 
            {return false; }
    }	
   
   public function validaDuplicidad($tipo,$campo,$valor)
    {   
        if($tipo=="proveedor")		
         { $this->db->select('rfc,nombre as razon_social,correo,calle,numero,colonia,delegacion,cp,estado,pais,id_prove'); }

         if($tipo=="usuarios")		
         { $this->db->select('apellidos,nombre, correo'); }

        $this->db->from($tipo);		
        $this->db->where($campo,$valor);
		
        $query = $this->db->get();
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
	else 
            return false;     
    }
	
	public function poblarSelect()
    {    					
        $this -> db -> select('c.rfc, c.razon_social');
        $this -> db -> order_by("c.razon_social","asc");		
        $query = $this -> db -> get('clientes c');
		
		$options = array();
		
        if($query -> num_rows() > 0 )
		{		  
		    $options[0] = '';
			foreach ($query->result() as $row)							 
				$options[$row->rfc] = $row->razon_social." (".$row->rfc.")";				
		}
		
		return $options;  
    }	
   
    public function traeClientesFiltros($registros_x_pagina,$offset,$f1,$f2,$f3,$f4,$fechaIni,$fechaFin)
    {                   
        $off  = (($offset-1) * $registros_x_pagina);
             	
        $this -> db -> select('count(c.rfc) as conteo');
	$this -> db -> from('clientes c');         
        if (!empty($f1))
            { $this -> db -> or_like(array('c.razon_social' => $f1)); }
        if (!empty($f2))
            { $this -> db -> or_like(array('c.rfc' => $f2)); }
        if (!empty($f3))
            { $this -> db -> or_like(array('c.correo' => $f3)); }
        if (!empty($f4))
            { $this -> db -> or_like(array('c.correo' => $f4)); }
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`c`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
        
        $query = $this->db->get()->result();
	$conteo = $query[0]->conteo;				
       
        $this -> db -> select('c.rfc,c.razon_social,c.correo');
	$this -> db -> select("DATE_FORMAT(`c`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta", FALSE);       
        if (!empty($f1))
            { $this -> db -> or_like(array('c.razon_social' => $f1)); }
        if (!empty($f2))
            { $this -> db -> or_like(array('c.rfc' => $f2)); }
        if (!empty($f3))
            { $this -> db -> or_like(array('c.correo' => $f3)); }
        if (!empty($f4))
            { $this -> db -> or_like(array('c.correo' => $f4)); }
        if (!empty($fechaIni) & !empty($fechaFin))
            { $this->db->where("`c`.`fecha_alta` BETWEEN '$fechaIni' AND '$fechaFin'",NULL, FALSE ); }  
            
        $this -> db -> order_by("c.razon_social","asc");
        $queryP = $this->db->get('clientes c',$registros_x_pagina,$off);			

        if($queryP -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryP->result_array(), "offset"=>$off); }
	else 
            { return false;  }
    }
   
   public function traeClientes($registros_x_pagina,$offset)
    {
    	$this -> db -> select('count(c.rfc) as conteo');
		$this -> db -> from('clientes c');        		
		$queryC = $this -> db -> get()-> result();
		$conteo = $queryC[0] -> conteo;		

        $this -> db -> select('c.rfc,c.razon_social,c.correo');
		$this -> db -> select("DATE_FORMAT(`c`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta", FALSE);
        $this -> db -> order_by("c.razon_social","asc");		
        $query = $this -> db -> get('clientes c',$registros_x_pagina,$offset);
		
		$pg_clientes= array("conteo"=>$conteo, "registros"=>$query->result_array());		

        if($query -> num_rows() > 0 )      
            return $pg_clientes;
		else 
			return false;
        
    }
	
	 public function traeClientesMA()
    {

        $this -> db -> select('c.rfc,c.razon_social,c.correo');
		$this -> db -> select("DATE_FORMAT(`c`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta", FALSE);
        $this -> db -> order_by("c.razon_social","asc");		
        $query = $this -> db -> get('clientes c');
		
		 if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;  
        
    }		
    
    
    public function traeDatosFiscales($rfc)
    {

        $this->db->select('c.rfc, c.razon_social, c.correo, c.calle, c.numero, c.colonia, c.delegacion, c.estado, c.pais, c.cp');
        $this->db->where('c.rfc', $rfc);
        $query = $this->db->get('clientes c');
		
		 if($query->num_rows() > 0 )      
            return $query->result_array()[0];
		else 
			return false;  
        
    }	

   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_cliente()
    {
        $this->db->delete('users', array('id' => 1));
    }
 
   public function delete_dc($rfc)
    {
        $this->db->delete('dcc', array('rfc' => $rfc));
    }
    
    public function update_cliente($rfc_ant,$rfc,$nombre_cliente,$correo_principal,$calle,$numero,$colonia,$delegacion,
	 				$estado,$pais,$cp,$dias_vencimiento)
    {		
        $data = array(
            'rfc'          =>  $rfc,
            'razon_social' =>  $nombre_cliente,
            'correo'       =>  $correo_principal,
            'calle'        =>  $calle,
            'numero'       =>  $numero,			
            'colonia'      =>  $colonia,
            'delegacion'   =>  $delegacion,
            'estado'       =>  $estado,
            'pais'         =>  $pais,
            'cp'           =>  $cp,
            'dias_vencimiento'=>  $dias_vencimiento,
            );
		
	$this->db->where('rfc', $rfc_ant);
        $ed=$this->db->update('clientes', $data);
        return $ed;
    }
    
    public function updateClientePedido($rfcAnt,$rfcNew)
    {		
        $data = array( 'rfc' =>  $rfcNew );
		
	$this->db->where('rfc', $rfcAnt);
        $this->db->update('pedidos', $data);           
    }
    
}
