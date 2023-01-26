  <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2">
          <div class="card-body">
            <h2 class="fw-bold"><?php echo $titulo; ?></h2>
              <div>
                  <p>             
                      <a href="<?php echo base_url();?>/ventas/eliminados" class=" btn btn-warning btn-sm <?php echo $btn_eliminados; ?>" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver historial">Eliminados</a>
                  </p>
              </div>
                 <table class="table-striped"  id="datatablesSimple">
                  <thead >
                      <tr>
                          <th>Fecha</th>
                          <th>Folio</th>
                          <th>Cliente</th>
                          <th>Total</th>
                          <th>Cajero</th> 
                          <th class="<?php echo $btn_verticket; ?>"width="1%"></th>
                          <th class="<?php echo $btn_eliminar; ?>"width="1%"></th>
                      </tr>
                  </thead>
                  <tbody>
                      <?php foreach ($datos as $dato) {?>
                          <tr>
                              <td class="align-middle"><?php echo $dato['fecha_alta'] ?></td>
                              <td class="align-middle"><?php echo $dato['folio'] ?></td>
                              <td class="align-middle"><?php echo $dato['cliente'] ?></td>
                              <td class="align-middle"><?php echo $dato['total'] ?></td>
                              <td class="align-middle"><?php echo $dato['cajero'] ?></td>
                              <td class="<?php echo $btn_verticket; ?>"><a href="<?php echo base_url().'/ventas/muestraTicket/'.$dato['id']; ?>" class="badge bg-success" rel="tooltip" data-placement="top" title="Ver ticket"><i class="far fa-file-pdf" ></i></i></a></td>
                              <td class="<?php echo $btn_eliminar; ?>"><a href="#" data-href="<?php echo base_url().'/ventas/eliminar/'.$dato['id'];?>"data-bs-toggle="modal" data-bs-target="#modal-confirma" class="badge bg-danger" rel="tooltip" data-placement="top" title="Eliminar"><i class="fas fa-trash"></i></a></td>
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

