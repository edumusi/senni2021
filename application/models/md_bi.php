<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Modelo para interactuar en la BD
 */
 
class Md_bi extends CI_Model {
		
	public function test()
    { 
           //$this->db->query("SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
         //$this->db->query("UPDATE `pedidos` SET `corte_documentar` = NULL WHERE CAST(`corte_documentar` AS CHAR(10)) = '0000-00-00';");
         $this->db->query("UPDATE `pedidos` set `tipo_cambio`=19 WHERE `tipo_cambio` is null or `tipo_cambio`=0; ");
        // $this->db->query("ALTER TABLE `pedidos` CHANGE `fondo_ahorro_por` `comision_ventas` DECIMAL(10,3) NOT NULL DEFAULT '0.000'");
    }
    
    
    public function reportExcelAXIVA($dataInput)
    {
        try {   
         $this->db->select(" p.num_booking, p.pol, p.pod1, p.pod2, p.moneda, p.tipo_cambio, vc.subtotal, vc.importe, vc.tipo, vc.cargo, c.rfc, c.razon_social ");         
         if (!empty($dataInput["paramDe"]) & !empty($dataInput["paramHasta"]))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '".$dataInput["paramDe"]."' AND '".$dataInput["paramHasta"]."'",NULL, FALSE ); }
            
         if (!empty($dataInput["rfc"]))
            { $this->db->where("p.rfc", $dataInput["rfc"] ); }

         if ($dataInput["iva_venta"] == "YES" & $dataInput["iva_costo"] == "YES" )
         {  } 
         else{
               if ($dataInput["iva_venta"] == "YES" )
                  { $this->db->where("vc.iva", 1 ); $this->db->where("vc.tipo", "VENTA" ); }

               if ($dataInput["iva_costo"] == "YES" )
                  { $this->db->where("vc.iva", 1 ); $this->db->where("vc.tipo", "COSTO" ); }
         }

         $this->db->where   ("vc.importe !=", 0 ); 
         $this->db->join    ('clientes c'      , "c.rfc = p.rfc",'inner outer');
         $this->db->join    ('pedido_cargos vc', "vc.id_pedido = p.id_pedido",'inner outer');
         $this->db->group_by("p.fecha_alta, p.num_booking, p.pol, p.pod1, p.pod2, p.moneda, p.tipo_cambio,vc.subtotal, vc.importe, vc.tipo, vc.cargo, c.rfc, c.razon_social ");         
         $this->db->order_by("p.fecha_alta, vc.tipo", 'ASC');
         $query = $this->db->get("pedidos p");         
             
         return ( empty($query->result()) ? array() : $query->result_array());
               
      } catch (Exception $e) {log_message('error', 'reportExcelAXIVA Excepción:'.$e->getMessage()); }	
    } 


    public function reportExcelAXEDOCTA($dataInput)
    {
        try {  
         $this->db->select("p.status_track,p.id_pedido, p.num_booking, p.pol, p.pod1, p.pod2, p.moneda, p.tipo_cambio, p.ins_envio, SUM(vc.subtotal) as importe, c.rfc, c.razon_social, c.dias_vencimiento, pr.nombre, pr.commodity ");
         $this->db->select("(DATE_ADD(`p`.`fecha_alta`, INTERVAL `c`.`dias_vencimiento` DAY) ) AS vencimiento", FALSE );
         $this->db->select('CONCAT(`calle`, " ",`numero`, " , ",`colonia`) AS DIR1', FALSE );
         $this->db->select('CONCAT(`delegacion`, " , ",`estado`, " , ",`pais`, " CP ",`cp`) AS DIR2', FALSE );

         if (!empty($dataInput["paramDe"]) & !empty($dataInput["paramHasta"]))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '".$dataInput["paramDe"]."' AND '".$dataInput["paramHasta"]."'",NULL, FALSE ); }
            
         if (!empty($dataInput["rfc"])) 
            { $this->db->where("p.rfc", $dataInput["rfc"] ); }         

         $this->db->where   ("vc.tipo =", "VENTA" ); 
         $this->db->join    ('clientes c'      , "c.rfc = p.rfc",'inner outer');
         $this->db->join    ('pedido_cargos vc', "vc.id_pedido = p.id_pedido",'inner outer');
         $this->db->join    ('productos pr'    , "pr.id_pedido = p.id_pedido",'inner outer');
         $this->db->group_by("p.status_track,p.id_pedido, p.fecha_alta, p.num_booking, p.pol, p.pod1, p.pod2, p.moneda, p.tipo_cambio, p.ins_envio , c.rfc, c.razon_social, c.dias_vencimiento, pr.nombre, pr.commodity ");
         $this->db->order_by("p.fecha_alta "); 
         $query = $this->db->get("pedidos p"); 
              
         return ( empty($query->result()) ? array() : $query->result_array());
               
      } catch (Exception $e) {log_message('error', 'reportExcelAXEDOCTA Excepción:'.$e->getMessage()); }	
    }

    
    public function reportExcelAXORIGEN($dataInput)
    {
        try {   
         $this->db->select("r.fecha_hora, p.status_track, p.num_booking,p.num_mbl,p.num_hbl,p.ins_envio,p.num_contenedor, p.shipper, p.pol, p.pod1, p.pod2, p.etd, p.eta, c.rfc, c.razon_social ");
         $this -> db -> select("DATE_FORMAT(`p`.`etd`,'%d/%m/%Y') as pedido_etd", FALSE);
         $this -> db -> select("DATE_FORMAT(`p`.`eta`,'%d/%m/%Y') as pedido_eta", FALSE);
         $this -> db -> select("DATE_FORMAT(`r`.`fecha_hora`,'%d/%m/%Y') as entrega", FALSE);
         if (!empty($dataInput["paramDe"]) & !empty($dataInput["paramHasta"]))
            { $this->db->where("`p`.`fecha_alta` BETWEEN '".$dataInput["paramDe"]."' AND '".$dataInput["paramHasta"]."'",NULL, FALSE ); }         
             
         if (!empty($dataInput["origen"]))
            { $this->db->where("p.pol", $dataInput["origen"] ); }
          
         $this->db->join    ('clientes c', "c.rfc = p.rfc",'inner outer');
         $this->db->join    ('rastreo r' , "r.num_guia = p.id_pedido AND UPPER(`p`.`status_track`)= 'ENTREGADO'",'left outer');
         $this->db->group_by("r.fecha_hora,p.status_track, p.fecha_alta,p.num_mbl,p.num_hbl, p.etd, p.eta, p.num_booking,p.num_contenedor,p.ins_envio, p.shipper, p.pol, p.pod1, p.pod2, c.rfc, c.razon_social ");         
         $this->db->order_by("p.eta", 'ASC');
         $query = $this->db->get("pedidos p");         
             
         return ( empty($query->result()) ? array() : $query->result_array());
                
      } catch (Exception $e) {log_message('error', 'reportExcelAXIVA Excepción:'.$e->getMessage()); }	
    }

    
    public function chartServices($paramDe, $paramHasta, $tipos_servicio)
    {
        try {   
        $this->db->query("SET SQL_MODE=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')); ");            
        if (!empty($paramDe) & !empty($paramHasta))
           { $this->db->where("`e`.`fecha_alta` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); $inluirYear ="DATE_FORMAT(e.fecha_alta, \"%y\")"; }  
        else
           { $this->db->where("YEAR(e.fecha_alta)" ,date("Y")); $inluirYear ="\"\"";  }   
        $this->db->select("(CASE MONTH(e.fecha_alta) when 1 then (concat(\"Ene\",$inluirYear )) when 2 then (concat(\"Feb\",$inluirYear )) when 3 then (concat(\"Mar\",$inluirYear )) when 4 then (concat(\"Abr\",$inluirYear )) when 5 then (concat(\"May\",$inluirYear )) when 6 then (concat(\"Jun\",$inluirYear )) when 7 then  (concat(\"Jul\",$inluirYear )) when 8 then (concat(\"Ago\",$inluirYear )) when 9 then  (concat(\"Sep\",$inluirYear )) when 10 then (concat(\"Oct\",$inluirYear )) when 11 then (concat(\"Nov\",$inluirYear )) when 12 then (concat(\"Dic\",$inluirYear )) END) AS MES, MONTH(e.fecha_alta) as m",FALSE);
        $this->db->where("MONTH(e.fecha_alta) !=", 0);
        $this->db->group_by("MONTH(e.fecha_alta)");
        $this->db->order_by("e.fecha_alta", 'ASC'); 
        
        $queryCAT = $this->db->get("pedidos e");
        if($queryCAT->result() == TRUE)    
        {  foreach($queryCAT->result_array() as $row)
                  { $categories[] = $row['MES']; $meses[] = $row['m'];  }
        }
        else
            { $categories = array(); $meses = array(); }
        $this->db->query("SET SQL_MODE=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')); ");    
        //while (list($llave, $valor) = each($tipos_servicio)) 
	      foreach($tipos_servicio as $llave => $valor)        
        {   
        if ($llave != 0 )
          { $data  = NULL;
            $dataC = NULL;
            foreach($meses as $m)
            {
                $this -> db -> select('MONTH(e.fecha_alta) as mes, (CASE e.moneda WHEN \'USD\' THEN ( (SUM(c.importe*e.tipo_cambio) - SUM(c.costo*e.tipo_cambio)) ) WHEN \'MXN\' THEN (SUM(c.importe) - SUM(c.costo)) END) AS profit');
                if (!empty($paramDe) & !empty($paramHasta))
                   { $this->db->where("`e`.`fecha_alta` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); }  
                else
                   { $this->db->where   ("YEAR(e.fecha_alta)" ,date("Y")); }
                $this->db->join    ('pedido_cargos c', 'c.id_pedido = e.id_pedido','inner outer');                   
                $this->db->where   ('c.tipo_servicio',$llave);
                $this->db->where   ('MONTH(e.fecha_alta)',$m);                
                $this->db->group_by('MONTH(e.fecha_alta)');
                $this->db->order_by('e.fecha_alta', 'ASC');
                $queryDAT = $this -> db -> get("pedidos e");
           //     echo 'LLave: '.$llave.' Mes: '.$m.br();
                if($queryDAT->result() == TRUE)
                    {  foreach($queryDAT->result_array() as $row)
                              { $llave.$data[] = floatval($row['profit']) ; }
                    }
                else
                    { $data[] = 0; }
            }                
            switch ($llave) {
                   case 64: $srv = "AEREO";            break;
                   case 65: $srv = "MARITIMO";         break;
                   case 66: $srv = "TERESTRE";         break;
                   case 88: $srv = "IMPORTACION";      break;
                   case 89: $srv = "EXPORTACION";      break;
                   case 90: $srv = "DESPACHO ADUANAL"; break;
                   default: $srv = $llave;             break;
            }
            
            $series[] = array("name" => $srv, "data" => $data, "stack"=> $llave );            
        }
       }
        
        return array("categories"=>$categories,"series"=>$series); 
               
    } catch (Exception $e) {log_message('error', 'chartServices Excepción:'.$e->getMessage()); }	
    }
    
    
    public function chartVendedor($paramDe, $paramHasta, $type)
    {   
     try{
         if($type === "V")
            {   $calculoComision = " e.comision_ventas ";       }
            else
            {   $calculoComision = " e.comision_operaciones ";  }

        $this->db->select  ("e.correo");
        $this->db->select  ("CONCAT_WS(' ',`u`.`nombre`,`u`.`apellidos`) as vendedor  ", FALSE);
        $this->db->join    ('usuarios u', "u.correo = e.correo",'inner outer');
        $this->db->where   ('u.activo', 1);
        $this->db->where_in('u.tipo'  , array("V","A"));
        $this->db->group_by("e.correo");
        
        $queryV     = $this->db->get("pedidos e");
        $vendedores = $queryV->result_array();
         
        $this->db->query("SET SQL_MODE=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')); ");      
        if (!empty($paramDe) & !empty($paramHasta))
           { $this->db->where("`e`.`fecha_alta` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); $inluirYear ="DATE_FORMAT(e.fecha_alta, \"%y\")"; }  
        else
           { $this->db->where("YEAR(e.fecha_alta)" ,date("Y")); $inluirYear ="\"\"";  }   
        $this->db->select("(CASE MONTH(e.fecha_alta) when 1 then (concat(\"Ene\",$inluirYear )) when 2 then (concat(\"Feb\",$inluirYear )) when 3 then (concat(\"Mar\",$inluirYear )) when 4 then (concat(\"Abr\",$inluirYear )) when 5 then (concat(\"May\",$inluirYear )) when 6 then (concat(\"Jun\",$inluirYear )) when 7 then  (concat(\"Jul\",$inluirYear )) when 8 then (concat(\"Ago\",$inluirYear )) when 9 then  (concat(\"Sep\",$inluirYear )) when 10 then (concat(\"Oct\",$inluirYear )) when 11 then (concat(\"Nov\",$inluirYear )) when 12 then (concat(\"Dic\",$inluirYear )) END) AS MES, MONTH(e.fecha_alta) as m",FALSE);
        $this->db->where("MONTH(e.fecha_alta) !=", 0);
        $this->db->group_by("MONTH(e.fecha_alta)");
        $this->db->order_by("e.fecha_alta", 'ASC');                
        $queryCAT = $this->db->get("pedidos e");
        
        if($queryCAT->result() == TRUE)
        {  foreach($queryCAT->result_array() as $row)
           { $categories[] = $row['MES']; $meses[] = $row['m'];  }
        }
        else
            { $categories = array(); $meses = array(); }
        $this->db->query("SET lc_time_names = 'es_ES'");
        $this->db->query("SET SQL_MODE=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')); ");  
        $series = NULL;
        foreach($vendedores as $v)
        {   $data  = NULL;
            $dataC = NULL;            
            foreach($meses as $m)
            { 
                $this->db->select("MONTH(e.fecha_alta) as mes, (CASE e.moneda WHEN 'USD' THEN ( SUM($calculoComision * e.tipo_cambio)) WHEN 'MXN' THEN ( SUM($calculoComision) ) END) AS comision");
                
                if (!empty($paramDe) & !empty($paramHasta))
                   { $this->db->where("`e`.`fecha_alta` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); }  
                else
                   { $this->db->where("YEAR(e.fecha_alta)" ,date("Y")); }
                                   
                $this->db->where   ("MONTH(e.fecha_alta)", $m);
                $this->db->where   ("e.correo", $v["correo"]);
                $this->db->group_by("MONTH(e.fecha_alta)");
                $this->db->order_by("e.fecha_alta", 'ASC');
                $queryDAT = $this->db->get("pedidos e");
                if($queryDAT->result() == TRUE)
                {  foreach($queryDAT->result_array() as $row)
                   { $data[] = floatval($row['comision']); }
                }
                else
                    { $data[] = 0;}                                
            }
            $series[] = array("name" => $v["vendedor"], "data" => $data );           
        }
        
        return array("categories"=>$categories, "series"=>$series);
        
      } catch (Exception $e) {echo 'CHART : ',  $e->getMessage(), "\n";}	
    }
    
    public function chartCustomer($paramDe, $paramHasta, $typeCus, $typeCusII)
    {
        if ($typeCusII === "N")
           { $tipoParticipacionTot = "count(e.id_pedido)"; 
             $tipoParticipacionSub = "count($typeCus)"; 
           }
        else
           { $tipoParticipacionTot = "sum(e.profit)"; 
             $tipoParticipacionSub = "sum(e.profit)"; 
           }
           
        $this -> db -> select("$tipoParticipacionTot as total");        
        if (!empty($paramDe) & !empty($paramHasta))
           { $this->db->where("`e`.`fecha_alta` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); }
        else
           { $this->db->where("YEAR(e.fecha_alta)" ,date("Y"));     }   
           
        if ($typeCus === "nombre")
           { $this->db->join('proveedor p', "p.id_prove = e.carrier",'inner outer'); }
        else
           { $this->db->join('clientes c', "c.rfc = e.rfc",'inner outer');           }
        
        $queryTot = $this->db->get("pedidos e")->result();         
        $total    = $queryTot[0]->total;
        
        $this -> db -> select("$tipoParticipacionSub as subTotal, $typeCus as series");
        if (!empty($paramDe) & !empty($paramHasta))
           { $this->db->where("`e`.`fecha_alta` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); }
        else
           { $this->db->where("YEAR(e.fecha_alta)" ,date("Y")); }   
           
        if ($typeCus === "nombre")
           { $this->db->join('proveedor p', "p.id_prove = e.carrier",'inner outer'); }
        else
           { $this->db->join('clientes c', "c.rfc = e.rfc",'inner outer');           }
        
        $this->db->group_by("$typeCus");
        $this->db->order_by("$typeCus", 'ASC');
        $queryDAT = $this -> db -> get("pedidos e");
        if($queryDAT->result() == TRUE)
        {  foreach($queryDAT->result_array() as $row)
           { $data[] = array("name" => $row['series'], "y" => ( ($row['subTotal']*100)/$total), "x" =>$row['subTotal'] );}
        }
        else
            { $data = array(); }
            
        return $data;        
    }
    
   // $data[] = array("name" => "Opera" , "y"=> 0.91);
     public function chartStatus($paramDe, $paramHasta, $type)
    {   if($type === "es")
        {   $sufijo     = "c";
            $campoTotal = "id_retro";
            $tabla      = "retroalimentacion $sufijo";
            $subTotal   = "`$sufijo`.`id_retro`";
            $series     = "(CASE c.calidad_servicio WHEN 5 THEN 'Excelente' WHEN 4 THEN 'Bueno' WHEN 3 THEN 'Regular' WHEN 2 THEN 'Malo' WHEN 1 THEN 'Pesimo' ELSE 'No hubo respuesta' END)";
            $campoFecha = "fecha_alta";            
        }
        else
        {   $sufijo     = "e";
            $campoTotal = "$sufijo.id_pedido";
            $tabla      = "pedidos $sufijo";
            $subTotal   = "`$sufijo`.`status`";
            $series     = "st.opcion_catalogo";
            $campoFecha = "fecha_alta";            
        }
        
        $this -> db -> select("count($campoTotal) as total");        
        if (!empty($paramDe) & !empty($paramHasta))
           { $this->db->where("`$sufijo`.`$campoFecha` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); }            
        else
           { $this->db->where   ("YEAR($sufijo.$campoFecha)" ,date("Y")); }
        $queryTot = $this -> db -> get($tabla)->result();         
        $total    = $queryTot[0]->total;
        
        $this -> db -> select("count($subTotal) as subTotal, $series as series");
        if (!empty($paramDe) & !empty($paramHasta))
           { $this->db->where("`$sufijo`.`$campoFecha` BETWEEN '$paramDe' AND '$paramHasta'",NULL, FALSE ); }            
       else
           { $this->db->where   ("YEAR($sufijo.$campoFecha)" ,date("Y")); }
        $this->db->group_by($series);
        $this->db->order_by("count($subTotal)", 'ASC');
        
        if($type === "pedido" )
            { $this -> db -> join('catalogo st', 'st.id_opcion = e.status ','left outer'); }
            
        $queryDAT = $this -> db -> get($tabla);
        if($queryDAT->result() == TRUE)
        {  foreach($queryDAT->result_array() as $row)
           { $data[] = array("name" => $row['series'], "y" => ( ($row['subTotal']*100)/$total), "x" =>$row['subTotal']);}
        }
        else
            { $data = array(); }
            
        return $data;        
    }
}
