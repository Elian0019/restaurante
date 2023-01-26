  <div id="layoutSidenav_content">
    <main>
      <div class="container-fluid px-2">
        <div class="card-body">
          <h2><?php echo $titulo; ?></h2>
          <div>
            <p>
              <a href="<?php echo base_url();?>/clientes" class=" btn btn-warning btn-sm" data-bs-toggle="tooltip" data-bs-placement="right" title="Regresar a clientes">Clientes</a> <!-- BOTON PARA VOLVER A LA TABLA Clientees -->
            </p>
          </div>
          <table id="datatablesSimple">
              <thead>
                <tr>
                  <th  width= "6%">Id</th>
                  <th>Nombre</th>
                  <th>Direccion</th>
                  <th>Telefono</th>
                  <th>Correo</th>
                  <th width= "4%"></th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($datos as $dato) {?>
                    <tr>
                      <td><?php echo $dato['id'] ?></td>
                      <td><?php echo $dato['nombre'] ?></td>
                      <td><?php echo $dato['direccion'] ?></td>
                      <td><?php echo $dato['telefono'] ?></td>
                      <td><?php echo $dato['correo'] ?></td>
                      <td><a href="#" data-href="<?php echo base_url().'/clientes/reingresar/'.$dato['id'];?>"data-bs-toggle="modal" data-bs-target="#modal-confirma" rel="tooltip" data-placement="top" title="Restaurar"><i class="fas fa-arrow-alt-circle-up"></i></a></td>
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
        <h5 class="modal-title" id="staticBackdropLabel">Reingresar Registro</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Desea Reingresar este registro?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <a class="btn btn-danger btn-ok">Confirmar</a>
      </div>
    </div>
  </div>
</div>
