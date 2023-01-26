<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
            <h4 class="mt-4"><?php echo $titulo; ?></h4>
            <?php if(isset($validation)){?>
                <div class="alert alert-danger">
                   <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/categorias/insertar" autocomplete="off">
            <?php echo csrf_field();?>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo set_value('nombre') ?>"autofocus required /> <!--CONFIGURA EL INGRESO DE DATOS LA CASILLA-->
                            </div>
                        </div>     
                    </div>
                </div>
                <div class="container-fluid px-0 py-2">
                   <a href="<?php echo  base_url(); ?>/categorias" class= "btn btn-secondary me-md-1">Regresar</a>
                   <button type="submit" class= "btn btn-primary">Guardar</button>
               </div>
            </form> 
        </div> 
    </main>
