<?php $user_session=session(); ?>
 <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-2">
        <div class="card-body">
          <div>
            <h2 class="fw-bold"><?php echo $titulo; ?></h2>
            <p>
              <a href="<?php echo base_url();?>/productos/nuevo" class=" btn btn-primary me-md-1 btn-sm <?php echo $btn_agregar; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Agregar nuevo"><i class="fas fa-plus"></i> Agregar</a>
              <a href="<?php echo base_url();?>/productos/eliminados" class=" btn btn-warning btn-sm <?php echo $btn_eliminados; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver historial">Eliminados</a>
            </p>
          </div>
           <table id="datatablesSimple" >
              <thead  class="fs-6">
                <tr>
                  <th width= "1%">Código</th>                  
                  <th>Nombre</th>
                  <th>Descripción</th> 
                  <th>Precio</th>
                  <th width= "1%">Existencias</th> 
                  <th width= "8%">Imagen</th> 
                  <th class="<?php echo $btn_editar; ?>" width= "1%"></th>
                  <th class="<?php echo $btn_eliminar; ?>"width= "1%"></th> 
                </tr>
              </thead>
              <tbody class="fs-8">
              <?php foreach ($datos as $dato){?>
                <tr>
                  <td class="align-middle"><?php echo $dato['codigo'] ?></td>                              
                  <td class="align-middle"><?php echo $dato['nombre'] ?></td>
                  <td class="align-middle"><?php echo $dato['capacidad'] ?></td>
                  <td class="align-middle"><?php echo $dato['precio_venta'] ?></td>
                  <td class="align-middle text-center"><?php echo $dato['existencias'] ?></td>
                  <td class="align-middle text-center"><img width="50"height="30" src="<?php echo base_url().'/images/productos/'.$dato['id'].'.jpg?'; ?><?php echo time(); ?>"/></td>
                  <td class="align-middle text-center <?php echo $btn_editar; ?>"><a href="<?php echo base_url().'/productos/editar/'.$dato['id']; ?>" class=" btn btn-warning btn-sm" rel="tooltip" data-bs-placement="top" title="Modificar registro"><i class="fas fa-pencil-alt" ></i></a></td>
                  <td class="align-middle text-center <?php echo $btn_eliminar; ?>"><a href="#" data-href="<?php echo base_url().'/productos/eliminar/'.$dato['id'];?>"data-bs-toggle="modal" data-bs-target="#modal-confirma" data-bs-placement="top" rel="tooltip"  title="Eliminar" class=" btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
                </tr>
                <?php } ?>
              </tbody>
         </table> 
        </div>
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
