<?php include("header_portal.php"); ?>

<script>

  $(function(){$( document ).tooltip();});
  
  $(document).ready(function(){$("#rastreo").validationEngine();});

</script>

<div class="container-fluid inner-offset">
                    <div class="hgroup text-center wow zoomIn" data-wow-delay="0.3s">
                            <h1>¿Por qué nosotros?</h1>
                    <div class="col-sm-12">
                    	<div class="col-sm-6" style="padding-top:15%;">
                            <?php                                	                             									

                                $attributes = array('class' => 'formular', 'id' => 'rastreo');
                                echo form_open(base_url().'rastreo/buscar/', $attributes);
                                echo $this->table->generate(); 
                                ?>
                                <a class="btn btn-success btn-default" href="javascript:submitForm();"><span>Buscar</span></a> 
                                <?php  
                                    br(1);
                                    echo form_close(); 
                                    br(2);
                                ?>                                                                                                                        
                        </div>
                    	<div class="col-sm-6">
                        	<img src="<?php echo base_url();?>img/introduccion.jpg" class="full-width">
                                <br><br><br>
                        </div>
                    </div>
		</div>
     </div>
                               
  
            
<script type="text/javascript">
function submitForm() {	

if($('#rastreo').validationEngine('validate'))
    document.getElementById("rastreo").submit();
}
</script>
  
<?php include("footer_portal.php"); ?>            