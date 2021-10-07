<?php include("header_datagrid_admin.php"); ?>


<div class="body">            
            <div class="body-wrapper">                
                <div class="content">                	 
                    <div class="container">                    	                        
                      <div class="sixteen columns" align="right">
                         <img src="<?php echo base_url();?>images/user.png"/>    
					     <?php echo $usuario;?>
                          <span class="hr mapdv"></span>
                        </div>                                                
                                        
                       <h5 class="semi"> <?php echo $titulos["titulo"];?> </h5>
                        
						<?php echo $this->table->generate($clientes); ?>
                        <?php echo $links; ?>                      
                                    
                         <div class="right">
                            ** <img src="<?php echo base_url();?>images/sort_both.png" />&nbsp;&nbsp; 	                            Columnas ordenables
                         </div>
						<?php echo br(2); ?>              
                        <div class="sixteen columns">
                            <span class="hr remove-bottom"></span>
                            <blockquote class="standard bottom">
                                <?php echo $titulos["frase"];?>
                            </blockquote>
                        </div>
                </div>
            </div>
        </div>
</div>
           
<script type="text/javascript">
$(document).ready(function() {
    var table = $('#datagrid').DataTable();
		table
		    .order( [[ 1, 'asc' ], [ 2, 'asc' ]] )
		    .draw();
	    
	$("#datagrid_paginate").remove();
	$("#datagrid_info").remove();
} );
</script>   
         
<?php include("footer.php"); ?>            