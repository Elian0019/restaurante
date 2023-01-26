 <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2">
            <div class="card-body">
              <h2><?php echo $titulo; ?></h2>
              <div>
                <p>
                  <a href="<?php echo base_url();?>/ventas" class=" btn btn-success btn-sm" data-bs-toggle="tooltip" data-bs-placement="right" title="Regresar a ventas">Ventas</a>
                </p>
              </div>
              <table id="datatablesSimple">
                  <thead>
                      <tr>
                          <th>Fecha</th>
                          <th>Folio</th>
                          <th>Cliente</th>
                          <th>Total</th>
                          <th>Cajero</th> 
                          <th width= "1%"></th>
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
                              <td><a href="<?php echo base_url().'/ventas/muestraTicket/'.$dato['id']; ?>" class=" btn btn-primary btn-sm" rel="tooltip" data-placement="top" title="Ver ticket"><i class="fas fa-list-alt"></i></a></td>                            
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
