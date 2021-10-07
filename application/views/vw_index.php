<?php include("header_lg_admin.php");

  echo form_open(base_url().'gestion/login/', array('class' => 'sky-form', 'id' => 'login','name' => 'login'));
?>
<div class='row'>
    <section class="col col-3"></section>
    <section class="col col-6">
        <img src="<?php echo base_url();?>img/introduccion.jpg"/>
    </section>
    <section class="col col-2"></section>
</div>                                	      


<div class="row errorMsg">		
<?php 
	echo br(1);
	echo $sesion;
	echo br(1);
?>
</div>   
         
<?php 
    echo form_close();
    include("footer_admin.php"); 
 ?>  