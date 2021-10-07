<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_flete extends CI_Model {
					
	

    public function insert_flete($id_pedido,$tipo_servicio,$etd,$eta,$verificacion_origen)
    {
        $data = array(
            'id_pedido'     	  =>   $id_pedido,
			'tipo_servicio' 	  =>   $tipo_servicio,
            'etd'      	  		  =>   $etd,
            'eta'      	  		  =>   $eta,                       		
			'verificacion_origen' =>   $verificacion_origen
            );
            $this->db->insert('flete',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_flete($id_pedido)
    {
        $this->db->delete('flete', array('id_pedido' => $id_pedido));
    }
	
	
	public function traeDetallePorEn($num_guia,$tabla,$t,$selectC,$fechas)
    {				
		$this->db->join('catalogo cf', 'cf.id_opcion = f.verificacion_origen','left outer');			
		
		$this->db->select($selectC);
		
		if($fechas != NULL)		
			$this->db->select($fechas, FALSE);
				
		$this->db->where($t.'.id_pedido',$num_guia);
		$this->db->order_by("f.tipo_servicio","asc");	
		$query = $this->db->get($tabla.' '.$t);								        
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }	
 
    //ejemplo actualizar los datos del usuario con id = 3
    public function update_user()
    {
        $data = array(
            'username' => 'silvia',
            'fname' => 'madrejo',
            'lname' => 'sánchez'
        );
        $this->db->where('id', 3);
        $this->db->update('users', $data);
    }
}
