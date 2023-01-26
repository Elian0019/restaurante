<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2">
            <div class="card-body">
                <h2 class="fw-bold text-center"><?php echo $titulo; ?></h2>
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th width= "6%">Id</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th width= "2%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($compras as $compra) {?>
                            <tr>
                                <td class="align-middle"><?php echo $compra['id'] ?></td>
                                <td class="align-middle"><?php echo $compra['total'] ?></td>
                                <td class="align-middle"><?php echo $compra['fecha_alta'] ?></td>
                                <td><a href="<?php echo base_url().'/compras/muestraCompraPdf/'.$compra['id']; ?>" class=" btn btn-danger btn-sm" rel="tooltip" data-placement="top" title="Ver pdf"><i class="far fa-file-pdf" ></i></a></td>
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
