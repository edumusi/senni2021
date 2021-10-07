<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_seguro extends CI_Model {
					
	

    public function insert_seguro($id_pedido,$costo,$venta,$iva,$cobertura)
    {
        $data = array(
            'id_pedido'      =>   $id_pedido,
            'costo'          =>   $costo,
            'venta'  	   	 =>   $venta,
			'iva'  	   	 	 =>   $iva,
            'cobertura'      =>   $cobertura            
            );
			
        $this->db->insert('seguro',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_seguro($id_pedido)
    {
        $this->db->delete('seguro', array('id_pedido' => $id_pedido));
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
