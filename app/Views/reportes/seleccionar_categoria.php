<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
            <h2 class=" mb-3 mt-3 fw-bold"><?php echo $titulo ; ?></h2>
            <?php if(isset($validation)){?>
                <div class="alert alert-danger">
                   <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>

            <form method="POST" action="<?php echo base_url(); ?>/reportes/tabla_CP" enctype="multipart/form-data" autocomplete="off">
                <?php echo csrf_field(); ?> 
                <div class="form-group">
                    <div class="row">
                        <label class="form-label fw-bold" ><i class="text-danger">* </i>Seleccionar categoría</label>
                    </div>
                </div>   
                <div class="form-group">
                    <div class="row mb-2">
                        <div class="col-12 col-sm-4">
                            <div class="input-group">
                                    <select class="form-select" aria-label="Default select example" id="id_categoria" name="id_categoria" required>
                                    <option value="0">todas</option>      
                                    <?php foreach($categorias as $categoria){ ?>
                                    <option value ="<?php echo $categoria['id']; ?>"><?php echo $categoria['nombre']; ?></option>
                                    <?php } ?>
                                    </select>  
                                <button class="btn btn-outline-secondary"  type="submit" >Resultado</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                <div class="mb-3">
                        <div class="col-12 col-sm-6">
                            <i class="text-danger"> ( * ) Campos obligatorios</i>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </main>
