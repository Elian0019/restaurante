  <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h3 class="mt-4"><?php echo $titulo; ?></h3>
            <div class="row mb-2">
              <div class="col">
                <input  class="form-check-input" type="checkbox"onclick="marcar(this);" /> <label class="form-check-label">Seleccionar todo</label>
              </div>
            </div>

            <form id="form_permisos" name="form_permisos" method="POST" action="<?php echo base_url().'/roles/guardaPermisos';?>">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="id_rol" value="<?php echo $id_rol ?>"/>
                <div class="">
                  <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4">
                        <div class="col">
                          <div class="card mb-3">
                            <div class="card-header text-center">PRODUCTOS</div>
                            <div class="card-body">

                              <?php foreach ($permisos as $permiso) { ?>
                                  <?php if ($permiso['submodulo']=="producto" ) { ?>
                                    <?php if ($permiso['submodulo']=="producto" && $permiso['tipo']=="2"){ ?><label class="fw-bold">Productos</label><?php  } ?>

                                      <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/>
                                        <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                      </div>
                                  <?php  } ?>
                                  <?php if ($permiso['submodulo']=="categoria" && $permiso['tipo']=="2" ){ ?>
                                    
                                  <label class="fw-bold">Categorias</label><?php  } ?>
                                  <?php if ($permiso['submodulo']=="categoria") { ?>

                                      <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/>
                                        <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                      </div>
                                  <?php  } ?>
                              <?php } ?>

                            </div>
                          </div>
                          <div class="card mb-3">
                            <div class="card-header text-center">COMPRAS</div>
                            <div class="card-body">
                              <?php foreach ($permisos as $permiso) { ?>
                                <?php if ($permiso['submodulo']=="compra") { ?>
                                  <?php if ($permiso['submodulo']=="compra" && $permiso['nombre']=="NuevaCompra" ) {;?>

                                    <label class="fw-bold">Compras</label><?php  };?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/>
                                      <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                              <?php  } ?>

                            </div>
                          </div>
                        </div>

                        <div class="col">                       
                          <div class="card mb-3">
                            <div class="card-header text-center">CLIENTES</div>
                            <div class="card-body">
                              <?php foreach ($permisos as $permiso) { ?>
                                <?php if ($permiso['submodulo']=="cliente") { ?>
                                  <?php if ($permiso['submodulo']=="cliente" && $permiso['tipo']=="2" ) { ?>

                                    <label class="fw-bold">Clientes</label><?php } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                              <?php  } ?>

                            </div>
                          </div>
                        </div>

                        <div class="col">
                          <div class="card mb-3">
                            <div class="card-header text-center">CAJA Y VENTAS</div>
                            <div class="card-body">
                              <?php foreach ($permisos as $permiso){ ?>
                                <?php if ($permiso['submodulo']=="cajaventa"){ ?>

                                  <?php if ($permiso['submodulo']=="cajaventa" && $permiso['tipo']=="1" ) { ?><label class="fw-bold">Principal</label><?php  } ?>

                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/><label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                                <?php if ($permiso['submodulo']=="venta") { ?>

                                  <?php if ($permiso['submodulo']=="venta" && $permiso['nombre']=="Eliminados" ) { ?><label class="fw-bold">Ventas</label><?php  } ?>
                                    
                                  <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                              <?php  } ?>

                            </div>
                          </div>

                          <div class="card mb-3">
                            <div class="card-header text-center">REPORTES Y ESTADÍSTICA</div>
                            <div class="card-body">
                              <?php foreach ($permisos as $permiso) { ?>
                                <?php if ($permiso['submodulo']=="reporte") { ?>
                                  <?php if ($permiso['submodulo']=="reporte" && $permiso['nombre']=="StockMinimos" ) { ?>
                                    
                                    <label class="fw-bold">Reportes</label><?php  } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                                 <?php if ($permiso['submodulo']=="estadistica") { ?>

                                  <?php if ($permiso['tipo']=="1" ) { ?><label class="fw-bold">Estadística</label><?php  } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                              <?php  } ?>

                            </div>
                          </div>

                        </div>

                        <div class="col">                            
                          <div class="card mb-3">
                            <div class="card-header text-center">ADMINISTRACIÓN</div>
                            <div class="card-body">
                              <?php foreach ($permisos as $permiso) { ?>
                                <?php if ($permiso['submodulo']=="administracion") { ?>
                                  <?php if ($permiso['submodulo']=="administracion" && $permiso['tipo']=="2" ) { ?>
                                    
                                    <label class="fw-bold">Configuracion</label><?php  } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                                 <?php if ($permiso['submodulo']=="usuario") { ?>
                                  <?php if ($permiso['submodulo']=="usuario" && $permiso['tipo']=="2" ) { ?>
                                    
                                    <label class="fw-bold">Usuario</label><?php  } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                                 <?php if ($permiso['submodulo']=="rol") { ?>
                                  <?php if ($permiso['submodulo']=="rol" && $permiso['tipo']=="2" ) { ?>
                                    
                                    <label class="fw-bold">Roles</label><?php  } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                                 <?php if ($permiso['submodulo']=="caja") { ?>
                                  <?php if ($permiso['submodulo']=="caja" && $permiso['tipo']=="2" ) { ?>
                                    
                                    <label class="fw-bold">Cajas</label><?php  } ?>

                                    <div class="form-check form-switch">
                                      <input class="form-check-input" type="checkbox" value = "<?php echo $permiso['id'];?>" name= "permisos[]" <?php if(isset($asignado[$permiso['id']])){echo 'checked';}?>/> <label class="form-check-label"><?php echo $permiso['nombre']; ?></label>
                                    </div>
                                 <?php  } ?>
                              <?php  } ?>

                            </div>
                          </div>
                        </div>
                  </div>

                </div>
                <a href="<?php echo  base_url(); ?>/roles" class= "btn btn-secondary me-md-1">Regresar</a>   
                <button type="submit" class="btn btn-primary">Guardar</button>       
          </form>
          <br>
        </div>
    </main>

    <script type="text/javascript">
      function marcar(source) 
      {
        checkboxes=document.getElementsByTagName('input');
        for(i=0;i<checkboxes.length;i++)
        {
          if(checkboxes[i].type == "checkbox") 
          {
            checkboxes[i].checked=source.checked;
          }
        }
      }
    </script>
