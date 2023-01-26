 <div id="layoutSidenav_content">
  <main>
    <div class="container-fluid px-4">
      <h4 class="mt-4"><?php echo $titulo; ?></h4>
        <div>
          <p>
            <a href="<?php echo base_url();?>/usuarios" class=" btn btn-warning btn-sm">Usuarios</a>
          </p>
        </div>
      <div class="card-body">
          <table id="datatablesSimple">
              <thead>
                  <tr>
                      <th width= "8%">Id</th>
                      <th>Usuario</th>
                      <th>Nombre</th>
                      <th width= "1%"></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach ($datos as $dato) {?>

                    <tr>
                      <td><?php echo $dato['id'] ?></td>
                      <td><?php echo $dato['usuario'] ?></td>
                      <td><?php echo $dato['nombre'] ?></td>
                      <td><a href="#" data-href="<?php echo base_url().'/usuarios/reingresar/'.$dato['id'];?>"data-bs-toggle="modal" data-bs-target="#modal-confirma" data-bs-placement="top" title="Reingresar registro"><i class="fas fa-arrow-alt-circle-up"></i></a></td>
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
