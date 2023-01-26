<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
            <h2 class=" mb-3 mt-3 fw-bold"><?php echo $titulo; ?></h2>
            <form method="POST" action="<?php echo base_url(); ?>/reportes/reporte_ventas" enctype="multipart/form-data" autocomplete="off">
            <?php echo csrf_field(); ?> 

                <div class="form-group">
                    <div class="row mb-2">
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-bold"><i class="text-danger">*</i> Fecha de inicio:</label>                   
                            <input type='date' id="fecha_inicio" name="fecha_inicio" class="form-control mb-2" value="" required />
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-bold" ><i class="text-danger">*</i> Fecha de fin:</label>
                            <input type='date' id="fecha_fin" name="fecha_fin" class="form-control mb-2" required/>
                        </div>
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-bold" ><i class="text-danger">*</i> Caja</label>
                            <select class="form-select" id="caja" name="caja">
                            <option value="0">Todas</option>
                            <?php foreach($cajas as $caja) { ?>
                            <option value ="<?php echo $caja['id']; ?>"><?php echo $caja['nombre'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="mb-3">
                        <div class="col-12 col-sm-6 mb-3">
                            <i class="text-danger"> ( * ) Campos obligatorios</i>
                        </div>
                        <button type="submit" class="btn btn-success">Generar reporte</button>
                    </div>
                </div>

                <?php if(isset($validation)){?>
                    <div class="alert alert-danger">
                        <?php echo $validation->listErrors(); ?>
                    </div>
                <?php } ?>
            </form>
        </div>
    </main>
    <script type="text/javascript">
    if (window.history.replaceState) {
        window.history.replaceState(null,null,'<?php echo base_url(); ?>/reportes/index');
    }
    </script>
