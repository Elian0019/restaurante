
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4 py-4">
            <?php $idVentaTmp = uniqid(); ?>

            <form id="form_venta" name="form_venta" class="form-horizontal" method="POST" action="<?php echo base_url();?>/ventas/guarda"    autocomplete="off">
            <?php echo csrf_field(); ?>

                <input type="hidden" id="id_venta" name="id_venta" value="<?php echo $idVentaTmp;?>"/>
                    <div class="form-group">
                    <input type="hidden" id="id_producto" name="id_producto"/>
                        <div class="row">
                            <div class="col-12 col-sm-4">
                                <div class="row">
                                    <label class="form-label">Nombre de producto</label>
                                </div>
                                <div class="input-group mb-3">
                                    <input class="form-control" id="nombre" name="nombre" type="text" placeholder="Escribe el nombre del producto"  autofocus>
                                    <button class="btn btn-outline-dark" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight" aria-controls="offcanvasRight" title="Lista Productos"><i class="fas fa-list-ol"></i></button>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4  mb-3">
                                <label  class="form-label">Forma de pago:</label>
                                    <select  id="forma_pago" name="forma_pago" class="form-select" aria-label="Default select example" required>
                                        <option value="001" >Efectivo</option>
                                        <option value="002" >Tarjeta</option>                                    
                                    </select>
                            </div>
                            <div class="col-12 col-sm-4  mb-3">
                                <div class="ui-widget">
                                    <label  class="form-label">Cliente:</label>
                                    <input type="hidden" id="id_cliente" name="id_cliente" value="1"/>
                                    <input type="text" class="form-control" id="cliente" name="cliente" placeholder="Escribe el nombre del cliente" value="Público en general" onkeyup="" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                <br>
                <div class="table-responsive">
                    <table id="tablaProductos" class="table table-bordered table-hover">
                        <thead class="table-dark ">
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Subtotal</th>
                            <th width= "1%"></th>
                        </thead>
                            <tbody></tbody>
                    </table>
                </div>
            <br>
                <div class="d-grid gap-3 d-md-flex justify-content-md-end  mb-3">
                    <label style="font-weight: bold; font-size: 30px; text-align: center;">Total Bs.</label>
                    <input  type="text" id="total" name="total" size="7" readonly="true" value="0.00" style="font-weight: bold; font-size: 30px; text-align: center;"/>
                    <button class="btn btn-success" type="button" id="completa_venta" >VENDER</button>
                </div>
            </form>
        </div>
    </main>
<!-- OFFCANVAS -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" style="width:450px;">
        <div class="offcanvas-header">
            <h3 id="offcanvasRightLabel">Lista de los Productos</h3>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <table id="datatablesSimple" class=" border-dark">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descrip.</th>
                        <th>Precio</th>
                         <th>stock</th>
                        <th width="1%"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto) {?>

                        <tr>                                                                               
                            <td class="align-middle"> <?php echo $producto['nombre'] ?></td>
                            <td class="align-middle"> <?php echo $producto['capacidad'] ?></td>
                            <td class="align-middle"> <?php echo $producto['precio_venta'] ?></td>
                            <td class="align-middle text-center"><?php echo $producto['existencias'] ?></td> 
                            <td><a class="badge bg-success" onclick="agregarProducto_offcanvas(<?php echo $producto['id']?>,<?php echo $producto['existencias']?>)"  rel="tooltip" data-placement="top" title="Seleccionar"> <i class="fas fa-plus"></i></a></td>
                        </tr>
                    <?php } ?> 

                </tbody>
            </table>
        </div>
    </div>

    <script>
    $(function(){
        $("#cliente").autocomplete({
            source:"<?php echo base_url();?>/clientes/autocompleteData", minLength:3,
            select: function(event, ui){
                event.preventDefault();
                $("#id_cliente").val(ui.item.id);
                $("#cliente").val(ui.item.value);
            }
        });
    });

    $(function(){
        $("#nombre").autocomplete({
            source:"<?php echo base_url();?>/productos/autocompleteData",
            minLength:3,
            select: function(event, ui){
                event.preventDefault();
                $("#nombre").val(ui.item.value);
                setTimeout(
                    function (){
                        e = jQuery.Event("keypress");
                        e.which=13;
                        agregarProducto(e,ui.item.id,1,'<?php echo $idVentaTmp; ?>');
                    }
                );
            }
        });
    });

    function agregarProducto(e,id_producto,cantidad,id_venta) {
    let enterKey = 13;
        if (nombre != '') {
            if (e.which == enterKey) {
                if (id_producto != null && id_producto != 0 && cantidad>0) {
                    $.ajax({
                        url:'<?php echo base_url(); ?>/TemporalCompra/insertar/'+ id_producto + "/"+ cantidad + "/"+id_venta,
                        success: function(resultado){
                            if (resultado == 0) {
                            }
                            else{
                                var resultado= JSON.parse(resultado);
                                if (resultado.error == '') {
                                    $("#tablaProductos tbody").empty();
                                    $("#tablaProductos tbody").append(resultado.datos);
                                    $("#total").val(resultado.total);
                                    $("#id_producto").val('');                                    
                                    $("#nombre").val('');
                                    $("#cantidad").val('');
                                    $("#precio_venta").val('');
                                    $("#subtotal").val('');
                                }
                            }
                        }
                    });
                }
            }
        }
    }

    function agregarProducto_offcanvas(id_producto,existencias) {
        if(existencias> 0){
        e = jQuery.Event("keypress");
        e.which=13;
        agregarProducto(e,id_producto,1,'<?php echo $idVentaTmp; ?>');
        }
        else{ swal('Aviso','Producto agotado.','warning');}
    }

    function eliminaProducto(id_producto, id_venta) {
        $.ajax({
            url:'<?php echo base_url(); ?>/TemporalCompra/eliminar/'+ id_producto +"/"+ id_venta,
            success: function(resultado){
                if (resultado == 0) {
                    $(tagCodigo).val('');
                }
                else{
                    var resultado= JSON.parse(resultado);
                    $("#tablaProductos tbody").empty();
                    $("#tablaProductos tbody").append(resultado.datos);
                    $("#total").val(resultado.total);
                }
            }
        });
    }

  $(function(){
        $("#completa_venta").click(function (){
            let nFilas = $("#tablaProductos tr").length;
            if(nFilas < 2) {
                swal('Aviso','Debe agregar un producto.','warning');
            }else{
                $("#form_venta").submit();
                swal({
                    title: "Realizado!",
                    text: "Espere un momento.",
                    type: "success",
                    timer: 2000,
                    showConfirmButton: false
                });
            }
        });
    });
    </script>
