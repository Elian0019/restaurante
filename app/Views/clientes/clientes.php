    <div id="layoutSidenav_content">
      <main>
          <div class="container-fluid px-2">
            <div class="card-body">
              <h2 class="fw-bold"><?php echo $titulo; ?></h2>
              <?php if($btn_agregar==null){?><?php  $btn_agregar=''; };?>
              <?php if($btn_eliminados==null){?><?php  $btn_eliminados=''; };?>
                <div>
                  <p>
                    <a href="<?php echo base_url();?>/clientes/nuevo" class=" btn btn-primary me-md-1 btn-sm <?php echo $btn_agregar; ?>"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Agregar nuevo"><i class="fas fa-plus"></i> Agregar</a>
                    <a href="<?php echo base_url();?>/clientes/eliminados" class=" btn btn-warning btn-sm <?php echo $btn_eliminados; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver historial eliminado">Eliminados</a>
                  </p>
                </div>
              <table id="datatablesSimple">
                <thead>
                  <?php if($btn_editar==null){?><?php  $btn_editar=''; };?>
                  <?php if($btn_eliminar==null){?><?php  $btn_eliminar=''; };?>
                    <tr>
                      <th  width= "6%">Id</th>
                      <th>Nombre</th>
                      <th>Direccion</th>
                      <th>Telefono</th>
                      <th>Correo</th> 
                      <th class=" <?php echo $btn_editar; ?>"width= "1%"></th>
                      <th class=" <?php echo $btn_eliminar; ?>"width= "1%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($datos as $dato) {?>
                        <tr>
                          <td class="align-middle"><?php echo $dato['id'] ?></td>
                          <td class="align-middle"><?php echo $dato['nombre'] ?></td>
                          <td class="align-middle"><?php echo $dato['direccion'] ?></td>
                          <td class="align-middle"><?php echo $dato['telefono'] ?></td>
                          <td class="align-middle"><?php echo $dato['correo'] ?></td>
                          <td class="<?php echo $btn_editar; ?>"><a href="<?php echo base_url().'/clientes/editar/'.$dato['id']; ?>" class="btn btn-warning btn-sm" rel="tooltip" data-bs-placement="top" title="Modificar registro"><i class="fas fa-pencil-alt"></i></a></td>
                          <td class="<?php echo $btn_eliminar; ?>"><a href="#" data-href="<?php echo base_url().'/clientes/eliminar/'.$dato['id'];?>"data-bs-toggle="modal" data-bs-target="#modal-confirma" rel="tooltip" data-placement="top" title="Eliminar" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></a></td>
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
