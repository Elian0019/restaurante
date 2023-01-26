<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4"> 
            <h4 class="mt-3"><?php echo $titulo; ?></h4>
            <?php if(isset($validation)){?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $validation->listErrors(); ?>
                </div>
            <?php } ?>
            <form method="POST" enctype="multipart/form-data" action="<?php echo base_url(); ?>/productos/actualizar" autocomplete="off">
            <?php echo csrf_field(); ?>
                <input type="hidden" id="id" name="id" value="<?php echo $producto['id'];?>"/>
                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Código</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="codigo" name="codigo" type="text" value="<?php echo $producto['codigo'];?>" autofocus required />
                            </div> 
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Nombre</label>
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="nombre" name="nombre" type="text" value="<?php echo $producto['nombre'];?>" required />
                            </div> 
                        </div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Descripción</label> 
                            <div class="container-fluid px-0 py-2">
                              <input class="form-control" id="capacidad" name="capacidad" type="text" value="<?php echo $producto['capacidad']; ?>" required />
                              </select>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Categorias</label> 
                            <div class="container-fluid px-0 py-2">
                               <select class="form-select" aria-label="Default select example" id="id_categoria" name="id_categoria" required>
                                <option value="">Seleccionar categoria</option>
                    <?php foreach($categorias as $categoria) { ?>
                    <option value ="<?php echo $categoria['id']; ?>" <?php if($categoria['id']==$producto['id_categoria']){echo 'selected';}?> ><?php echo $categoria['nombre']; ?></option>
                    <?php } ?>
                    </select>
                            </div>
                        </div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                        <div class="col-12 col-sm-6">
                            <label>Precio venta</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="precio_venta" name="precio_venta" type="text" value="<?php echo $producto['precio_venta'];?>"required />
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Precio compra</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="precio_compra" name="precio_compra" type="text" value="<?php echo $producto['precio_compra'];?>" required />
                            </div> 
                        </div>
                    </div>   
                </div>

                <div class="form-group">
                    <div class="row">
                  
                        <div class="col-12 col-sm-6">
                            <label>Stock minimo</label> 
                            <div class="container-fluid px-0 py-2">
                               <input class="form-control" id="stock_minimo" name="stock_minimo" type="text" value="<?php echo $producto['stock_minimo'];?>" required /> <!--CONFIGURA EL INGRESO DE DATOS LA CASILLA-->
                            </div>
                        </div>
                        <div class="col-12 col-sm-6">
                            <label>Es inventariable</label>
                            <div class="container-fluid px-0 py-2">
                               <select class="form-select" aria-label="Default select example" id="inventariable" name="inventariable" class="form-control">
                                    <option value="1"<?php if($producto['inventariable']==1){echo 'selected';}?> >Si</option>
                                    <option value="0"<?php if($producto['inventariable']==0){echo 'selected';}?> >No</option>
                               </select>
                            </div>
                        </div>
                    </div>   
                </div>

               <div class="form-group">  
                    <div class="row">   
                         <div class="col-12 col-sm-6">  
                            <label>Imagen del Producto</label> 
                            <div class="container-fluid px-0 py-1">  
                            <img src="<?php echo base_url().'/images/productos/'.$producto['id'].'.jpg?';?><?php echo time(); ?>" class="img-responsive" width= "200"/>
                                <br><br>
                                <input type="file" id="img_producto" name="img_producto" accept="image/jpeg" />                            
                               <p class="text-danger"> Cargar imagen formato jpg de 150x150 px</p>
                            </div> 
                        </div>
                    </div>   
                </div>
                <div class="container-fluid px-0 py-3">
                   <a href="<?php echo  base_url(); ?>/productos" class= "btn btn-secondary me-md-1">Regresar</a>   
                   <button type="submit" class= "btn btn-primary">Guardar</button> 
               </div>

            </form> 
        </div> 
    </main>
