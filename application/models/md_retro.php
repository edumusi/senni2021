<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_retro extends CI_Model {
					
  		
   public function traeRetro($registros_x_pagina,$offset)
    {
    	$this->db->select('count(re.id_retro) as conteo');
		$this->db->from('retroalimentacion re');	
		
		$queryC = $this->db->get()->result();
		$conteo = $queryC[0]->conteo;		
		
        $this->db->select('re.id_pedido, re.calidad_servicio, re.comentarios, re.sugerencias');
		$this->db->select("DATE_FORMAT(`re`.`fecha_alta`,'%d/%m/%Y %H:%i:%s') as fecha_alta", FALSE);
        $this->db->order_by("re.fecha_alta","desc");		
        $query = $this->db->get('retroalimentacion re',$registros_x_pagina,$offset);
		
		$pg_retro= array("conteo"=>$conteo, "registros"=>$query->result_array());		
		
        if($query->num_rows() > 0 )      
            return $pg_retro;
		else 
			return false;
        
    }						
	
	//ejemplo nuevo usuario en la tabla users
    public function insert_retro($id_pedido,$correo,$calidad_servicio,$comentarios,$sugerencias,$hoy)
    {
        $data = array(
            'id_pedido'   	   =>   $id_pedido,
            'calidad_servicio' =>   $calidad_servicio,
			'comentarios'      =>   $comentarios,
			'sugerencias'      =>   $sugerencias,
			'fecha_alta'       =>   $hoy												
            );
            $this->db->insert('retroalimentacion',$data);
    }
       
 
    //ejemplo actualizar los datos del usuario con id = 3
    public function borra_retro($id_retro)
    {
        $data = array('status' => 51);
        $this->db->where('id_retro', $id_retro);
        $this->db->update('retroalimentacion', $data);
    }
}
