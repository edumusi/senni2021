<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_aduana extends CI_Model {
					
	

    public function insert_aduana($id_pedido,$agencia,$tiempo)
    {
        $data = array(
            'id_pedido' =>   $id_pedido,
            'agencia'   =>   $agencia,
            'tiempo'  	=>   $tiempo										
            );
            $this->db->insert('aduana',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_aduana($id_pedido)
    {
        $this->db->delete('aduana', array('id_pedido' => $id_pedido));
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
