   <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h2 class="mt-3 fw-bold"><?php echo $titulo; ?></h2>
            <?php if(isset($validation)){?>
                <div class="alert alert-danger">
                   <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="POST"  enctype="multipart/form-data" action="<?php echo base_url(); ?>/configuracion/actualizar" autocomplete="off">
              <?php echo csrf_field(); ?>
                <div class="form-group">
                    <div class="row">      
                        <div class="col-12 col-sm-6">
                            <div class="mb-2">  
                                <label class="form-label fw-bold">Nombre del restaurante</label>  
                                <input class="form-control" id="tienda_nombre" name="tienda_nombre" type="text" value="<?php echo $nombre['valor']; ?>" required />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-2"> 
                                <label class="form-label fw-bold">NIC</label> 
                                <input class="form-control" id="tienda_rfc" name="tienda_rfc" type="text"value="<?php echo $rfc['valor']; ?>" required />
                            </div>
                        </div>
                    </div>   
                </div>
                <div class="form-group"> 
                    <div class="row"> 
                        <div class="col-12 col-sm-6">
                            <div class="mb-2"> 
                                <label class="form-label fw-bold">Teléfono del restaurante</label> 
                                <input class="form-control" id="tienda_telefono" name="tienda_telefono" type="text" value="<?php echo $telefono['valor']; ?>" required /> 
                            </div>
                        </div>
                        <div class="col-12 col-sm-6"> 
                            <div class="mb-2"> 
                                <label class="form-label fw-bold">Correo del restaurante</label> 
                                <input class="form-control" id="tienda_email" name="tienda_email" type="text" value="<?php echo $email['valor']; ?>" required /> 
                            </div>
                        </div>                
                    </div>   
                </div>
                <div class="form-group">
                    <div class="row">  
                        <div class="col-12 col-sm-6">
                            <div class="mb-2"> 
                                <label class="form-label fw-bold">Dirección del restaurante</label>              
                                <textarea class="form-control" id="tienda_direccion" name="tienda_direccion"  required><?php echo $direccion['valor']; ?></textarea>
                            </div>   
                        </div>
                        <div class="col-12 col-sm-6">
                            <div class="mb-2"> 
                                <label class="form-label fw-bold">Leyenda del Ticket</label>                  
                                <textarea class="form-control" id="ticket_leyenda" name="ticket_leyenda" required><?php echo $leyenda['valor']; ?></textarea>
                            </div> 
                        </div>    
                    </div>   
                </div>
                <div class="form-group">
                    <div class="row">
                        <label class="form-label fw-bold">Logo tipo</label> 
                        <div class="col-12 col-sm-6">  
                            <div class="mb-2">
                                <img src="<?php echo base_url(). '/images/logotipo.png?'; ?><?php echo time(); ?>" class="img-responsive" width= "100px" height="100px"/>
                            </div>
                        </div>         
                    </div> 
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <input class="form-control form-control-sm" type="file" id="tienda_logo" name="tienda_logo" accept="image/png" />
                            <p class="text-danger fst-italic"> Cargar imagen formato png de 150x150 px</p>
                        </div>
                    </div> 
                </div>
                   <button type="submit" class= "btn btn-success">Guardar</button> 
            </form>  
            <br>
        </div>
    </main>
<!-- Modal -->
<div class="modal fade" id="modal-confirma" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Eliminar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Desea Eliminar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a class="btn btn-danger btn-ok">Confirmar</a>
      </div>
    </div>
  </div>
</div>
