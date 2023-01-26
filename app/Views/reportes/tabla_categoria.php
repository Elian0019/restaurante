<?php $user_session=session();?>
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-2">
            <div class="card-body">      
                <div>
                <?php if($id_cat!=0){?>
                    <?php foreach ($prod as $dato) {?>
                        <?php $c= 'Categoría '.$dato['categoria']; break; ?>
                    <?php } ?>  
                    <?php if(isset($c)){$c=$c;}else{$c='Categoría sin productos';} ?>
                <?php  }else {?>  
                <?php $c='Todas las categorías';}; ?>  
                    <h2 class="fw-bold text-center"><?php echo $c ;?></h2>
                </div>
                    <div class="mb-3">
                        <a href="<?php echo  base_url(); ?>/reportes/index_CP" class= "btn btn-primary me-md-1 btn-sm">Regresar</a>
                        <a href="<?php echo  base_url().'/reportes/decargarPdfCat/'.$id_cat.'/'.$c;?>" class= "btn btn-danger me-md-1 btn-sm">Descargar Pdf</a>                   
                    </div> 
                <table id="datatablesSimple" >
                    <thead  class="fs-6">
                        <tr>
                            <th width= "1%">Código</th>                  
                            <th>Nombre</th>
                            <th>Descripción</th> 
                            <th>Precio venta</th>
                            <th>Precio compra</th>
                            <th width= "1%">Existencias</th> 
                        </tr>
                    </thead>
                    <tbody class="fs-8">                           
                        <?php foreach ($prod as $dato) {?>
                            <tr>
                                <td class="align-middle"><?php echo $dato['codigo'] ?></td>                              
                                <td class="align-middle"><?php echo $dato['nombre'] ?></td>
                                <td class="align-middle"><?php echo $dato['capacidad'] ?></td>
                                <td class="align-middle"><?php echo $dato['precio_venta'] ?></td>
                                <td class="align-middle"><?php echo $dato['precio_compra'] ?></td>
                                <td class="align-middle text-center"><?php echo $dato['existencias'] ?></td>
                            </tr>        
                        <?php } ?>   
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    <script type="text/javascript">
        if (window.history.replaceState) {
            window.history.replaceState(null,null,'<?php echo base_url(); ?>/reportes/index_CP'); 
        }
    </script>
