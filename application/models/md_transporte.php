<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_transporte extends CI_Model {
					
	

    public function insert_transporte($id_pedido,$regreso_vacio,$costo,$venta,$iva,$salida_puerto,$maniobras,$contacto_almacen,$entrega)
    {
        $data = array(
            'id_pedido'        =>   $id_pedido,
            'regreso_vacio'    =>   $regreso_vacio,
            'costo'  	   	   =>   $costo,
            'venta'            =>   $venta,
			'iva'  	   	 	   =>   $iva,
            'salida_puerto'    =>   $salida_puerto,			
			'maniobras'   	   =>   $maniobras,
			'contacto_almacen' =>   $contacto_almacen,
			'entrega'   	   =>   $entrega            											
            );
			
       $this->db->insert('transporte',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_transporte($id_pedido)
    {
        $this->db->delete('transporte', array('id_pedido' => $id_pedido));
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
