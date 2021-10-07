<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_usuario extends CI_Model {
	
	
	public function validaUsuario($usuario,$pwd)
    {
        
        $this->db->select('nombre,apellidos,tipo,correo');
        $this->db->from('usuarios ');        
        $this->db->where('correo',$usuario);        
	$this->db->where('pwd',$pwd);
        $this->db->where('activo',1);
       
        $query = $this->db->get();
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;
        
    }
	 public function insert_boletin($correo)
    {
	$data = array('email' => $correo,);	
        $this->db->delete('boletin', $data);        
        $this->db->insert('boletin', $data);
    }	
  
  //ejemplo nuevo usuario en la tabla users
    public function insert_usuario_cliente($correo,$rs)
    {
		$this->load->helper('date');
		$hoy = standard_date('DATE_W3C', time());
		$pwd = now().'p';
		
        $data = array(
            'correo'     => $correo,
            'nombre'     => $rs,
            'fecha_alta' => $hoy,
            'tipo'  	 => 'C',
            'pwd'  		 => $pwd
            );
            $this->db->insert('usuarios',$data);
    }
  
	
	//ejemplo nuevo usuario en la tabla users
    public function insert_user($data)
    {       
            $this->db->insert('usuarios',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_user($correo)
    {
        $data = array('ACTIVO' => '0');
        $this->db->where('correo', $correo);
        $this->db->update('usuarios', $data);
    }
 
    //ejemplo actualizar los datos del usuario con id = 3
    public function update_user($correo, $data)
    {       
        $this->db->where('correo', $correo);
        $this->db->update('usuarios', $data);
    }
	
	public function verificaCuenta($correo)
    {        
        $this->db->select('nombre, apellidos, pwd,correo');
        $this->db->from('usuarios ');		
		$this->db->where('correo',$correo);		
       
        $query = $this->db->get();
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return FALSE;     
    }
	
	public function traeAdmin()
	{
		$options = array();
		
		$this->db->select('`correo` as id,  CONCAT(`titulo`,\' \',`nombre`,\' \',`apellidos`) as ec', FALSE);
		$this->db->where("(TIPO = 'A' OR TIPO = 'V')");
                $this->db->where("ACTIVO = 1");
        $query = $this->db->get('usuarios');
						
       if($query -> num_rows() > 0 )
		{		  
		    $options[0] = '::Elegir::';
			foreach ($query->result() as $row)							 
				$options[$row->id] = $row->ec;				          	   
		}
		return $options;       
    }	

    public function traePuestos()
	{
		$options = array();
		
		$this->db->select('`puesto` as id,  `puesto` as ec', FALSE);
		$this->db->where("(TIPO = 'A' OR TIPO = 'V')");
        $this->db->where("ACTIVO = 1");
        $query = $this->db->get('usuarios');
						
       if($query -> num_rows() > 0 )
		{		  
		    $options[0] = '::Elegir::';
			foreach ($query->result() as $row)							 
				$options[$row->id] = $row->ec;				          	   
		}
		return $options;       
    }	
	
    public function traeDetalleUsuario($correo)
    {
        $this->db->select('*');
        $this->db->where('correo',$correo);
        $query = $this->db->get('usuarios');
						
        if($query->num_rows() > 0 )      
            return $query->result_array()[0];
        else 
                return array();        
    }

    public function traeDetalleAdmin($correo)
    {
        $this->db->select('*');
        $this->db->where('correo',$correo);
        $query = $this->db->get('usuarios');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
	else 
            return false;        
    }
    
    public function traeUsuariosFiltros($registros_x_pagina,$offset,$f1,$f2,$f3)
    {                   
        $off  = (($offset-1) * $registros_x_pagina);
             	
        $this->db->select('count(u.correo) as conteo');
        $this->db->where("(u.tipo = 'A' || u.tipo = 'V')");
        $this->db->where('u.activo',1);
	    $this->db->from('usuarios u');         
        if (!empty($f1))
            { $this -> db -> or_like(array('u.nombre' => $f1,'u.apellidos' => $f1)); }            
        if (!empty($f2))
            { $this -> db -> where('u.correo',$f2); }
        if (!empty($f3))
            { $this -> db -> where('u.puesto', $f3); }  

        $query = $this->db->get()->result();
	    $conteo = $query[0]->conteo;				
       
        $this -> db -> select('u.nombre, u.apellidos, u.puesto, u.correo');
	    $this -> db -> select("DATE_FORMAT(`u`.`fecha_alta`,'%d/%m/%Y ') as fecha_alta", FALSE);       
        if (!empty($f1))
            { $this -> db -> or_like(array('u.nombre' => $f1,'u.apellidos' => $f1)); }            
        if (!empty($f2))
            { $this -> db -> where('u.correo',$f2); }
        if (!empty($f3))
            { $this -> db -> where('u.puesto', $f3); }  

        $this->db->order_by("u.fecha_alta","asc");
        $this->db->where("(u.tipo = 'A' || u.tipo = 'V')");
        $this->db->where('u.activo',1);
        $queryP = $this->db->get('usuarios u', $registros_x_pagina,$off);			

        if($queryP -> num_rows() > 0 )      
           { return array("conteo"=>$conteo, "registros"=>$queryP->result_array(), "offset"=>$off); }
	else 
            { return false;  }
    }
}
