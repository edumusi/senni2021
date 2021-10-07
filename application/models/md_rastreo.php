<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_rastreo extends CI_Model {
		
	
	public function traeEncabezado($num_guia)
    {
        
        $this->db->select('p.id_pedido,s.opcion_catalogo as status,p.status_track,p.rfc,pv.nombre as nombre_carrier,						  	
						   p.num_mbl,p.shipper,p.fecha_alta,
						   p.adjunto_mbl, p.adjunto_hbl, p.adjunto_facturaP, 
                           p.adjunto_le, p.adjunto_factura,p.adjunto_poliza,p.adjunto_cartaporte,
                           p.pol,p.pod1');
		$this->db->select("DATE_FORMAT(`p`.`etd`,'%d/%m/%Y') as etd, 																																																						
						   DATE_FORMAT(`p`.`eta`,'%d/%m/%Y') as eta", FALSE);						   
        $this->db->from('pedidos p');        
        $this->db->where('p.id_pedido',$num_guia);
		$this->db->join('catalogo s', 's.id_opcion = p.status','left outer');
		$this->db->join('proveedor pv', 'pv.id_prove = p.carrier','left outer');
       
        $query = $this->db->get();
		
        if($query->num_rows() > 0 )      
            return $query->result();
		else 
			return false;
        
    }
	
	public function traeFletes($num_guia)
    {
        
        $this->db->select('s.opcion_catalogo as servicio');
		$this->db->select("DATE_FORMAT(`f`.`etd`,'%d/%m/%Y') as etd, 																																																						
						   DATE_FORMAT(`f`.`eta`,'%d/%m/%Y') as eta", FALSE);						   
        $this->db->from('flete f');        
        $this->db->where('f.id_pedido',$num_guia);
		$this->db->join('catalogo s', 's.id_opcion = f.tipo_servicio','left outer');
       
        $query = $this->db->get();
		
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;
        
    }
	
	public function traeRastreo($num_guia, $registros_x_pagina,$offset)
    {
    	$this->db->select('count(r.num_guia) as conteo');
		$this->db->from('rastreo r');
        $this->db->where('r.num_guia',$num_guia);		
		$queryC = $this->db->get()->result();
		$conteo = $queryC[0]->conteo;		
		
        $this->db->select('r.status_track as status,r.descripcion, r.observaciones,r.status as id_status');
	    $this->db->select("DATE_FORMAT(`r`.`fecha_hora`,'%d/%m/%Y') as fecha_hora", FALSE);
        $this->db->where('r.num_guia',$num_guia);	
        $this->db->order_by("r.status","asc");
        $query = $this->db->get('rastreo r',$registros_x_pagina,$offset);
		
		$pg_rastreo= array("conteo"=>$conteo, "registros"=>$query->result_array());		
		
        if($query->num_rows() > 0 )      
            return $pg_rastreo;
		else 
			return false;
        
    }	
	
	public function traeRastreoPor($num_guia)
    {
		$this->db->select('c.opcion_catalogo as status, r.descripcion, r.observaciones, r.id_hora, r.status_track, r.noti_track,
		                  r.status as id_status');
		$this->db->select("DATE_FORMAT(`r`.`fecha_hora`,'%d/%m/%Y') as fecha, 
						   DATE_FORMAT(`r`.`fecha_hora`,'%d/%m/%Y %H:%i:%s') as fecha_hora", FALSE);
        $this->db->where('r.num_guia',$num_guia);
        $this->db->join('catalogo c', 'c.id_opcion = r.status','left outer');        
        $this->db->order_by("r.status","asc");		
        $query = $this->db->get('rastreo r');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }	
	
	
	//ejemplo nuevo usuario en la tabla users
    public function insert_rastreo($num_guia,$status,$descripcion,$fecha_hora,$observaciones,$noti)
    {
        $data = array(
            'num_guia'      =>   $num_guia,
			'status_track'  =>   $status,
            'descripcion'   =>   $descripcion,
            'fecha_hora'    =>   $fecha_hora,
            'observaciones' =>   $observaciones,
            'noti_track'    =>   $noti,
            );
			
        $this->db->insert('rastreo',$data);
    }
   
    //ejemplo de eliminar al usuario con id = 1
    public function delete_rastreo($num_guia)
    {
        $this->db->delete('rastreo', array('num_guia' => $num_guia));
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
	
	public function traePuerto($id_puerto)
	{
		$this->db->select('*');
		 $this->db->where('id_puerto',$id_puerto);
        $query = $this->db->get('puertos_maritimos');
						
        if($query->num_rows() > 0 )      
            return $query->result_array();
		else 
			return false;        
    }	
}
