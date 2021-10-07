<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_catalogo extends CI_Model {
					
  		
    public function insert_catalogo($campo,$opcion_catalogo)
    {		
		
        $data = array(
            'campo'          =>  $campo,
            'opcion_catalogo' =>  $opcion_catalogo,
            );
            $this->db->insert('catalogo',$data);
    }
       
   
   public function poblarSelect($campo)
    {    						
        $this -> db -> select('c.id_opcion,c.opcion_catalogo');
	$this -> db -> where('c.campo',$campo);
        $this -> db -> order_by("c.id_opcion","asc");		
        $query = $this -> db -> get('catalogo c');
		
	$options = array();
		
        if($query -> num_rows() > 0 )
		{		  
		    $options[0] = '::Elegir::';
			foreach ($query->result() as $row)							 
				$options[$row->id_opcion] = $row->opcion_catalogo;				          	   
		}
		return $options;        
    }	
	
	public function poblarServicios($campo1, $campo2)
    {    						
        $this -> db -> select('c.id_opcion, c.opcion_catalogo');
	$this -> db -> where ('c.campo',$campo1);
        $this -> db -> where ('c.valor_catalogo',$campo2);
        $this -> db -> order_by("c.id_opcion","asc");		
        $query = $this -> db -> get('catalogo c');
		
	$options = array();
		
        if($query -> num_rows() > 0 )
            {   $options[0] = '::Elegir::';
                foreach ($query->result() as $row)							 
                    {   $options[$row->id_opcion] = $row->opcion_catalogo; }
            }

            return $options;
    }	
	
    public function traeDescOpcion($id_opcion)
    {    						
        $this -> db -> select('c.opcion_catalogo');
		$this -> db -> where('c.id_opcion',$id_opcion);
        $query = $this -> db -> get('catalogo c');		

		$registro = $query->row();
		
		return $registro->opcion_catalogo;        
    }		
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_catalogo()
    {
        $this->db->delete('users', array('id' => 1));
    }
 
    //ejemplo actualizar los datos del usuario con id = 3
    public function update_catalogo()
    {
        $data = array(
            'username' => 'silvia',
            'fname' => 'madrejo',
            'lname' => 'sánchez'
        );
        $this->db->where('id', 3);
        $this->db->update('users', $data);
    }

    public function poblarPaisDeOrigen()
    {    						
        $this -> db -> select('p.pol');	    
        $this -> db -> order_by("p.pol","asc");		
        $query = $this -> db -> get('pedidos p');
		
	    $options = array();
		
        if($query -> num_rows() > 0 )
            {   
                foreach ($query->result() as $row)							 
                    {   $options[$row->pol] = $row->pol; }
            }

            return $options;
    }	

    public function traeDatosFiscales($rfc, $campos)
    {   
        $resp = array();

        if($campos == null)
            $this->db->select('*');
        else
            $this->db->select($campos);
        $this->db->where ('rfc', $rfc);
        $query = $this->db->get('datos_senni');
        $resp  = ( empty($query->result()) ? array() : $query->result_array()[0] );        

        return $resp;          
    }

}
