    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4"> 
                <h4 class="mt-4 mb-3"><?php echo $titulo; ?></h4>
                <?php if(isset($validation)){?>
                    <div class="alert alert-danger">
                    <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>
                <form method="POST" action="<?php echo base_url(); ?>/roles/actualizar" autocomplete="off">
                <?php echo csrf_field(); ?>
                <input type="hidden" value="<?php echo $datos['id'] ?>"name="id"/>
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $datos['nombre'] ?>" autofocus required />
                        </div>
                    <div class="col-12">
                    <a href="<?php echo  base_url(); ?>/roles" class= "btn btn-secondary me-md-1">Regresar</a>
                    <button type="submit" class= "btn btn-primary">Guardar</button>
                </div> 
                </form>
            </div>
        </main>
