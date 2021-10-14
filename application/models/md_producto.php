<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_producto extends CI_Model {
					
	

    public function insert_producto($id_pedido,$nombre,$qty_contenedor,$tipo_contenedor,$commodity,$peso,$tipo_servicio)
    {
        $data = array(
            'id_pedido'        => $id_pedido,
            'nombre'           => $nombre,
            'qty_contenedor'   => $qty_contenedor,
            'tipo_contenedor'  => $tipo_contenedor,
            'commodity'  	   => $commodity,
            'peso'         	   => $peso,
            'tipo_servicio'    => $tipo_servicio
            );
			
        $this->db->insert('productos',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_producto($id_pedido)
    {
        $this->db->delete('productos', array('id_pedido' => $id_pedido));
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
