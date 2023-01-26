<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
            <h4 class="mt-4"><?php echo $titulo; ?></h4>
            <?php if(isset($validation)){?>
                <div class="alert alert-danger">
                   <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/usuarios/insertar" autocomplete="off">
                <?php echo csrf_field(); ?>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Usuario</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="usuario" name="usuario" type="text" value="<?php echo set_value('usuario') ?>" autofocus required />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo set_value('nombre') ?>" require />
                            </div>
                        </div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Contraseña</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="password" name="password" type="password" value="<?php echo set_value('password') ?>" />
                            </div> 
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Repita contraseña</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="repassword" name="repassword" type="password" value="<?php echo set_value('repassword') ?>"  />
                            </div> 
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Caja</label>
                            <div class="container-fluid px-0 py-2">
                              <select class="form-select" aria-label="Default select example" id="id_caja" name="id_caja"  required>
                                    <option value="">Seleccionar Caja</option>
                                <?php foreach($cajas as $caja) { ?>
                                    <option value ="<?php echo $caja['id']; ?>"><?php echo $caja['nombre']; ?></option>
                                <?php } ?>
                              </select>
                            </div> 
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Rol</label> 
                            <div class="container-fluid px-0 py-2">
                               <select class="form-select" aria-label="Default select example" id="id_rol" name="id_rol" required>
                                     <option value="">Seleccionar Rol</option>
                                <?php foreach($roles as $rol) { ?>
                                <option value ="<?php echo $rol['id']; ?>"><?php echo $rol['nombre']; ?></option>
                                <?php } ?>
                              </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container-fluid px-0 py-3">
                   <a href="<?php echo  base_url(); ?>/usuarios" class= "btn btn-secondary me-md-1">Regresar</a>
                   <button type="submit" class= "btn btn-primary">Guardar</button>
               </div>
            </form>
        </div> 
    </main>
